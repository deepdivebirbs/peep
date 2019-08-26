
<?php
namespace Birbs\Peep;
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
	$sightingId = filter_input(INPUT_GET, "sightingId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$sightingUserProfileId = filter_input(INPUT_GET, "sightingUserProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$sightingSpeciesId = filter_input(INPUT_GET, "sightingSpeciesId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$sightingLocX = filter_input(INPUT_GET, "sightingLocX", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$sightingLocY = filter_input(INPUT_GET, "sightingLocY", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$sightingDateTime = filter_input(INPUT_GET, "sightingDateTime", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$sightingBirdPhoto = filter_input(INPUT_GET, "sightingBirdPhoto", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// Define behaviour if $method is a GET request
	if($method === "GET") {
		// Set the XSRF cookie
		setXsrfCookie();
		// Get bird species based on stuff?
		if(empty($sightingId) === false) {
			$sighting = Sighting::getSightingBySightingId($pdo, $sightingId);
			if($sighting !== null) {
				$reply->data = $sighting;
			}
		} else {
			$sighting = Sighting::getSightingsBySightingSpeciesId($pdo, $sightingSpeciesId)->toArray();
			if($sighting !== null) {
				$reply->data = $sighting;
			}
		}
	} else {
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

