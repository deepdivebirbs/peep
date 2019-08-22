<?php
namespace Birbs\Peep;

require_once("BirdSpecies.php");
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 1) . "/lib/uuid.php");

/**
 * Class DataDownloader
 * @package Birbs\Peep
 */
class DataDownloader {

	/**
	 * This function pulls a batch of birds from the Ebirds database through their API
	 *
	 * @return array
	 */
	public static function pullBirds(): array {
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://ebird.org/ws2.0/data/obs/US-NM/recent",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"X-eBirdApiToken: vr62jb4302c7"
			),
		));

		$response = curl_exec($curl);
		$jsonArray = json_decode($response, true);
		return $jsonArray;
	}

	/**
	 * This function takes two arguments, the array, and the field to grab from the array.
	 *
	 * @param $birdArray
	 * @param $field
	 * @return array
	 */
	public function parseBirds($birdArray, $field) {
		$returnArray = Array();

		foreach($birdArray as $key => $value) {
			array_push($returnArray, $birdArray[$key][$field]);
		}

		return $returnArray;
	}

	/**
	 * Sets the values from the API JSON array
	 */
	public function setValues() {
		$birdList = self::pullBirds();

		foreach($birdList as $key => $value) {
			$speciesId = generateUuidV4();
			$speciesCode = $birdList[$key]["speciesCode"];
			$speciesComName = $birdList[$key]["comName"];
			$speciesSciName = $birdList[$key]["sciName"];
			$speciesPhotoUrl = "www.testurl.com";
			$speciesObsDate = $birdList[$key]["obsDt"];
			$speciesLat = $birdList[$key]["lat"];
			$speciesLng = $birdList[$key]["lng"];

			print_r($speciesPhotoUrl . "\n");
			// Create new BirdSpecies
			$birdSpecies = new BirdSpecies($speciesId, $speciesCode, $speciesComName, $speciesSciName, $speciesPhotoUrl);

			$birdSpeciesArray = Array();

			array_push($birdSpeciesArray, $birdSpecies);

			var_dump($speciesId);
		};
	}
}

$test = new DataDownloader();
//$birds = $test->pullBirds();
//$comNames = $test->parseBirds($birds, "comName");

var_dump($test->setValues());

