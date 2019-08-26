<?php
namespace Birbs\Peep;

require_once(dirname(__DIR__, 3) . "/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");

require_once("/etc/apache2/capstone-mysql/Secrets.php");

require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";

/**
 * This is the API for UserProfile, this API handles incoming HTTP requests by getting the request, reading the request
 * and pulling the data from the table to the user.
 */

use Birbs\Peep\{UserProfile};

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
	// TODO Do we need the authentication key and Hash here?
	$userProfileId = filter_input(INPUT_GET, "userProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userProfileAuthenticationToken = filter_input(INPUT_GET, "userProfileAuthenticationToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userProfileEmail = filter_input(INPUT_GET, "userProfileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userProfileFirstName = filter_input(INPUT_GET, "userProfileFirstName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userProfileLastName = filter_input(INPUT_GET, "userProfileLastName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userProfileName = filter_input(INPUT_GET, "userProfileName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userProfileHash = filter_input(INPUT_GET, "userProfileHash", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);




	// Define behaviour if $method is a GET request
	if($method === "GET") {
		// Set the XSRF cookie
		setXsrfCookie();

		// Get userProfile based on ID. Is this the best way?
		if(empty($userProfileId) === false) {
			$userProfile = UserProfile::getUserProfileById($pdo, $userProfileId);
			if($userProfile !== null) {
				$reply->data = $userProfile;
			}
		} //else {
			//$userProfile = UserProfile::getAllUserProfiles($pdo)->toArray();
			//if($userProfile !== null) {
			//	$reply->data = $userProfile;
			//} I didn't make a way to get all users. For now, I'll see whether something comparable is necessary.
		//}
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