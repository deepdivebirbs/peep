<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";

require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Birbs\Peep\{UserProfile};

/**
 * API for the app sign in, UserProfile class
 */

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {

	//Verify the session status. If it's not active, start it.
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}

	//grab the mySQL connection
	$secrets = new \secrets ("etc/apache2/capstone-mysql/peep.ini");
	$pdo = $secrets->getPdoObject();

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
		if(empty($requestObject->userProfileEmail) === true) {
			throw (new \InvalidArgumentException("email address not provided", 401));
		} else {
			$userProfileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}

		//grab the profile from the database by the email provided
		$userProfile = UserProfile::getUserProfileByEmail($pdo, $userProfileEmail);
		if(empty($userProfile) === true) {
			throw (new InvalidArgumentException("Invalid Email", 401));
		}
		$userProfile->setUserProfileAuthenticationToken(null);
		$userProfile->update($pdo);

		//verify hash is correct
		if(password_verify($requestObject->userProfilePassword, $userProfile->getUserProfileHash()) === false) {
			throw(new \InvalidArgumentException("Password or email is incorrect", 401));
		}

		//grab profile from database and put into a session
		$userProfile = UserProfile::getUserProfileById($pdo, $userProfile->getUserProfileId());
		$_SESSION["userProfile"] = $userProfile;

		//create the Auth payload
		$authObject = (object)[
			"userProfileId" => $userProfile->getUserProfileId(),
		];

		//create and set the JWT token
		setJwtAndAuthHeader("auth", $authObject);


		$reply->message = "Sign in successful";
	} else {
		throw (new \InvalidArgumentException("Invalid HTTP method request", 418));
	}

} catch (\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

//sets up the response header
header("Content-type: application/json");


//JSON encode the $reply object and echo it back to the front end
echo json_encode($reply);