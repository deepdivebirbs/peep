
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

use Birbs\Peep\{Sighting};
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
	$sightingSpeciesId = filter_input(INPUT_GET, "sightingSpeciesId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

// Define behavior if $method is a GET request
	if($method === "GET") {
// Set the XSRF cookie
		setXsrfCookie();
//gets a post by content
	if(empty($sightingId) === false) {
		$reply->data = Sighting::getSightingBySightingId($pdo, $sightingId);
	} else if(empty($sightingUserProfileId) === false) {
		$reply->data = Sighting::getSightingsBySightingUserProfileId($pdo, $sightingUserProfileId);
	} else if(empty($sightingSpeciesId) === false) {
		$reply->data = Sighting::getSightingsBySightingSpeciesId($pdo, $sightingSpeciesId);
	}

//POST the sighting object
else if($method === "POST") {
	//enforce user has xsrf token
	verifyXsrf();
	//enforce the user is signed in
	if(empty($_SESSION["userProfile"]) === true) {
		throw(new \InvalidArgumentException("You must be signed in to create a sighting.", 401));
	}

	//this line grabs JSON and stores result in $requestContent
	$requestContent = file_get_contents("php://input");
	//parses JSON package that the front end sent, and stores it in $requestObject
	$requestObject = json_decode($requestContent);

	//ensure sighting content is available (required)
	if(empty($requestObject->sightingBirdPhoto) === true) {
		throw(new \InvalidArgumentException("No photo uploaded.", 405));
	}

	//ensure that the sighting includes correct datetime and latlong
	if(empty($requestObject->sightingDateTime) === true) {
			$requestObject->sightingDateTime =  date("y-m-d H:i:s");

	}
	if(empty($requestObject->sightingLocX) === true) {
			throw(new \InvalidArgumentException("No location data entered."));
	}

	if(empty($requestObject->sightingLocX) === true) {
		throw(new \InvalidArgumentException("No location data entered."));
	}

	//is this necessary for the sighting ID?
	if(empty($requestObject->sightingSpeciesId) === true) {
		throw (new \InvalidArgumentException("No sighting entry linked to the sighting.", 405));
	}

//enforce for POST method
	//enforce the end user has a JWT token
	// enforce the user is signed in
	if(empty($_SESSION["profile"]) === true) {
		throw(new \InvalidArgumentException("You must be logged in to access sightings.", 403));
		}

//CREATE the sighting object
		validateJwtHeader();
		$sighting = new Sighting(generateUuidV4(), $_SESSION["userProfile"]->getUserProfileId(), $requestObject->sightingSpeciesId, $requestObject->newSightingDateTime, $requestObject->sightingBirdPhoto, $requestObject->newSightingLocX, $requestObject->newSightingLocY);
		$sighting->insert($pdo);
		$reply->message = "Sighting successfully added.";}

//DELETE the sighting object
	 else if($method === "DELETE") {
		//enforce the end user has a XSRF token.
		verifyXsrf();
		//grab the sighting by its primary key
		$sighting = Sighting::getSightingsBySightingId($pdo, $sightingId);
		if($sighting === null) {
			throw (new RuntimeException("Sighting does not exist."));
		}
		//enforce the user is signed in and only trying to edit their own sighting
		if(empty($_SESSION["userProfile"]) === true || $_SESSION["profile"]->getProfileId() !== $sighting->getSightingProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this sighting.", 403));
		}
		validateJwtHeader();
		//preform the actual delete
		$sighting->delete($pdo);
		//update the message
		$reply->message = "Sighting successfully deleted.";
	}

	// if any other HTTP request is sent throw an exception
} else {
	throw new \InvalidArgumentException("invalid http request", 400);
}
//catch any exceptions that is thrown and update the reply status and message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

else {
	throw(new \InvalidArgumentException("Invalid HTTP Request...", 418));
}
} catch(\Exception $exception) {
	// Set error messages
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(\TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
// If the reply data is empty, unset the variable
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);

