<?php

namespace Birbs\Peep;

use Birbs\Peep\Test\PeepTest;

require_once("BirdSpecies.php");
require_once("Sighting.php");
require_once(".something.php");

require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 1) . "/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");


/**
 * Class DataDownloader
 *
 * This class pulls bird data from the Ebird API, creates objects from that data, then inserts those objects into
 * the database.
 *
 * @package Birbs\Peep
 * @author Mark Waid Jr
 */
class DataDownloader {
	/**
	 * This function pulls a batch of birds from the Ebirds database through their API
	 *
	 * @return array
	 */
	public static function pullBirds(): array {
		// Get API key
		$key = getApiKey();

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
				"X-eBirdApiToken: $key"
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
	public static function parseBirds($birdArray, $field): array {
		$returnArray = Array();

		foreach($birdArray as $key => $value) {
			array_push($returnArray, $birdArray[$key][$field]);
		}

		return $returnArray;
	}

	/**
	 * Sets the values from the API JSON array
	 */
	public function setAndInsert() {
		// Create PDO Secrets
		$secrets = new \Secrets("/etc/apache2/capstone-mysql/peep.ini");
		// Create PDO Object
		$pdo = $secrets->getPdoObject();

		// Pull birds from API
		$birdList = self::pullBirds();

		foreach($birdList as $key => $value) {
			// Generate IDs
			$speciesId = generateUuidV4();
			$sightingId = generateUuidV4();
			$sightingUserProfileId = generateUuidV4();

			// Parse API data
			$speciesCode = $birdList[$key]["speciesCode"];
			$speciesComName = $birdList[$key]["comName"];
			$speciesSciName = $birdList[$key]["sciName"];
			$speciesPhotoUrl = "https://ebird.org/species/pinjay";
			$speciesObsDate = $birdList[$key]["obsDt"];
			$speciesLat = $birdList[$key]["lat"];
			$speciesLng = $birdList[$key]["lng"];

			// Create DateTime object from the API dates
			$sightingDateTime = \DateTime::createFromFormat("Y-m-d H:i", $speciesObsDate);

			// Create new BirdSpecies
			$birdSpecies = new BirdSpecies($speciesId, $speciesCode, $speciesComName, $speciesSciName, $speciesPhotoUrl);
			//$sighting = new Sighting($sightingId, $sightingUserProfileId, $speciesId, $speciesComName, $speciesSciName, $speciesLat, $speciesLng, $sightingDateTime, $speciesPhotoUrl);

			$birdSpeciesArray = Array();

			array_push($birdSpeciesArray, $birdSpecies);

			// Insert objects into species
			$birdSpecies->insert($pdo);
			//$sighting->insert($this->getPDO());
		};
	}

	public function showAllBirds() {
		// Create PDO object
		$secrets = new \Secrets("/etc/apache2/capstone-mysql/peep.ini");
		$pdo = $secrets->getPdoObject();

		$birds = BirdSpecies::getAllBirds($pdo);

		print_r($birds);
	}
}

$test = new DataDownloader();
$test->setAndInsert();
//$test->showAllBirds();
