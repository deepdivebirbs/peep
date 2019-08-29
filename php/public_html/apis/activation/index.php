<?php

require_once dirname(__DIR__,3) . "/vendor/autoload.php";
require_once dirname(__DIR__,3) . "/Classes/autoload.php";
require_once ("/etc/apache2/capstone-mysql/Secrets.php");

use Birbs\Peep\UserProfile;

/**
 * API to check userProfile activation status
 *
 */

//check to seee if session is active, and start it if not
if (session_start()!== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	//grab mySQL connection
	$secrets = new \Secrets ("/etc/apache2/capstone-mysql/peep.ini");
	$pdo = $secrets->getPdoObject();

	//checks the HTTP method being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize the input
	$activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING);

	//make sure the activation token is the correct size
	if(strlen($activation) !== 32) {
		throw (new InvalidArgumentException("activation has an incorrect length", 405));
	}

	//verify the activation token is a string value of a hexadecimal
	if(ctype_xdigit($activation) !== false) {
		throw (new \InvalidArgumentException("activation token is empty or invalid", 405));
	}

	//handle the GET HTTP request
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		//find the profile associated with the activation token
		$userProfile = $userProfile::getUserProfileByAuthenticationToken($pdo, $activation);

		//verify the profile is not null
		if($userProfile !== null) {

			//make sure activation token matches
			if($activation === $userProfile->getUserProfileAuthenticationToken()) {

				//set activation to null
				$userProfile->setUserProfileAuthenticationToken(null);

				//update the profile in the database
				$userProfile->update($pdo);

				//set the reply for end user
				$reply->data = "Account activated. You should be automatically redirected to your profile.";
			}
		} else {
			//throw an exception if the activation token does not exist
			throw (new RuntimeException("The profile with this activation token does not exist", 404));
		}
	} else {
		//throw an exception if the HTTP request is not a GET
		throw (new InvalidArgumentException("Invalid HTTP method request", 403));
	}

//update the reply object's status and message state variable if an exception or a type exception was thrown;
} catch (Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch (TypeError $typeError){
	$reply->status = $typeError->getCode();
	$reply->message = $typeError ->getMessage();
}

//prepare and send the reply
header ("Content-type: application/json");
if ($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);