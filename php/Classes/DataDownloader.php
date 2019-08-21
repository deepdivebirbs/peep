<?php
namespace Birbs\Peep;

require_once("BirdSpecies.php");
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");

/**
 * Class DataDownloader
 * @package Birbs\Peep
 */
class DataDownloader {
	/**
	 * @return Array
	 */
	public function pullBirds(): Array {
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


		/*
		 * Don't forget, you don't have to print anything in the foreach loop, just push elements to the array
		 * and print the array outside of the loop.  DO NOT ENCODE THE ARRAY YET!!
		 */
		/*

		*/

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
	 * This function creates a bunch of arrays that contain the specified fields.
	 */
	public function createValueArrays() {
		$speciesCodes = $this->parseBirds($this->pullBirds(), "speciesCode");
		$speciesComNames = $this->parseBirds($this->pullBirds(), "comName");
		$speciesSciNames = $this->parseBirds($this->pullBirds(), "sciName");
		$speciesObsDate = $this->parseBirds($this->pullBirds(), "obsDt");
		$speciesLat = $this->parseBirds($this->pullBirds(), "lat");
		$speciesLng = $this->parseBirds($this->pullBirds(), "lng");

		$valueArray = [$speciesCodes, $speciesComNames, $speciesSciNames, $speciesObsDate, $speciesLat, $speciesLng];

		print_r($valueArray);
	}

}

$test = new DataDownloader();
//$birds = $test->pullBirds();
//$comNames = $test->parseBirds($birds, "comName");

$test->createValueArrays();
