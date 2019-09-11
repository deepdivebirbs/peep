<?php
require_once(dirname(__DIR__, 3) . "/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";

/**
 * This is the API for Sighting, this API handles incoming HTTP requests by getting, posting, and putting user requests relating to the Sighting class and sighting table.
 *
 */

use Birbs\Peep\{Sighting, BirdSpecies};

// Check if session is active, and if not activate it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// Create a template reply
$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// Create new PDO object
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/peep.ini");
	$pdo = $secrets->getPdoObject();
	// What HTTP method was used?
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	// Sanitize and store input
	$sightingId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$sightingUserProfileId = filter_input(INPUT_GET, "sightingUserProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$sightingBirdSpeciesId = filter_input(INPUT_GET, "sightingBirdSpeciesId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// Define behavior if $method is a GET request

	if($method === "GET") {

		// Set the XSRF cookie
		setXsrfCookie();

		// Gets a post by content
		if(empty($sightingId) === false) {
			$reply->data = Sighting::getSightingBySightingId($pdo, $sightingId);
		} else if(empty($sightingUserProfileId) === false) {
			$sightings = Sighting::getSightingsBySightingUserProfileId($pdo, $sightingUserProfileId)->toArray();
			$sightingSpecies = [];
			foreach($sightings as $sighting){
				$bird = BirdSpecies::getSpeciesBySpeciesId($pdo, $sighting->getSightingBirdSpeciesId());
				$sightingSpecies[] = (object) [
					"sighting" => $sighting,
					"birdSpecies" => $bird
				];
				var_dump($sighting);
			}
			$reply->data = $sightingSpecies;
		} else if(empty($sightingBirdSpeciesId) === false) {
			$reply->data = Sighting::getSightingsBySightingBirdSpeciesId($pdo, $sightingBirdSpeciesId);
		}

		// POST the sighting object
	} else if($method === "POST") {
		// Enforce user has xsrf token
		verifyXsrf();
		// Enforce the user is signed in
		if(empty($_SESSION["userProfile"]) === true) {
			throw(new \InvalidArgumentException("You must be signed in to create a sighting.", 401));
		}
		// This line grabs JSON and stores result in $requestContent
		$requestContent = file_get_contents("php://input");
		//parses JSON package that the front end sent, and stores it in $requestObject
		$requestObject = json_decode($requestContent);

		// Ensure sighting content is available (required)
		if(empty($requestObject->sightingBirdPhoto) === true) {
			throw(new \InvalidArgumentException("No photo uploaded.", 405));

		}

		// Ensure that the sighting includes correct datetime and latlong
		if(empty($requestObject->sightingDateTime) === true) {
			date_default_timezone_set("America/Denver");
			$dateString = date ("y-m-d H:i:s");
			$requestObject->sightingDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
		}

		if(empty($requestObject->sightingLocX) === true) {
			throw(new \InvalidArgumentException("No location data entered."));
		}

		if(empty($requestObject->sightingLocX) === true) {
			throw(new \InvalidArgumentException("No location data entered."));
		}

		if(empty($requestObject->sightingBirdSpeciesId) === true) {
			throw (new \InvalidArgumentException("No sighting entry linked to the sighting.", 405));
		}

// Enforce for POST method
		// Enforce the end user has a JWT token
		// Enforce the user is signed in
		if(empty($_SESSION["userProfile"]) === true) {
			throw(new \InvalidArgumentException("You must be logged in to access sightings.", 403));
		}

// CREATE the sighting object
		validateJwtHeader();
		$sighting = new Sighting(generateUuidV4(), $_SESSION["userProfile"]->getUserProfileId(), $requestObject->sightingBirdSpeciesId, $requestObject->sightingBirdPhoto, $requestObject->sightingDateTime, $requestObject->sightingLocX, $requestObject->sightingLocY);
		$sighting->insert($pdo);
		$reply->message = "Sighting successfully added.";

		// DELETE the sighting object
	} else if($method === "DELETE") {
		//enforce the end user has a XSRF token.
		verifyXsrf();
		//grab the sighting by its primary key
		$sighting = Sighting::getSightingBySightingId($pdo, $sightingId);
		if($sighting === null) {
			throw (new RuntimeException("Sighting does not exist."));
		}
		// Enforce the user is signed in and only trying to edit their own sighting
		if(empty($_SESSION["userProfile"]) === true || $_SESSION["userProfile"]->getUserProfileId()->toString() !== $sighting->getSightingUserProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this sighting.", 403));
		}
		validateJwtHeader();
		//perform the actual delete
		$sighting->delete($pdo);
		//update the message
		$reply->message = "Sighting successfully deleted.";
	}
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);

// finally - JSON encodes the $reply object and sends it back to the front end.






