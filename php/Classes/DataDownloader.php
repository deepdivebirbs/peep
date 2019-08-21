<?php
namespace Birbs\Peep;


$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.ebird.org/v2/data/obs/{{regionCode}}/recent",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => false,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"X-eBirdApiToken: {{x-ebirdapitoken}}"
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
} 