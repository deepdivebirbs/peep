<?php
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Birbs\Peep\UserProfile;

/**
 * API for the app sign in, UserProfile class
 */

//Verify the session. If it's not active, start it.
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$secrets = new \secrets ("etc/apache2/capstone-mysql/peep.ini");
	$pdo = $secrets->getPdoObject ();
	//determine what HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER ["REQUEST_METHOD"];

	//If the method is post, handle the sign-in logic
	if($method === "POST") {

		//make sure XSRF token is valid
		verifyXsrf();

		//process the request content and decode the json object into a PHP object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check to make sure the password and email fields are not empty
		if (empty($requestObject->userProfileEmail) === true) {
			throw (new \InvalidArgumentException("email address not provided", 401))
		} else {
			$userProfileEmail
		}
	}















}