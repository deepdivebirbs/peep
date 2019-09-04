<?php
namespace Birbs\Peep;

require_once(dirname(__DIR__, 3) . "/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

/**
 * This is the API for UserProfile, this API handles incoming HTTP requests by getting the request, reading the request
 * and pulling the data from the table to the user.
 */

use Birbs\Peep\{
	UserProfile
};

// Check if session is active, and if not activate it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// Create a template reply
$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;
try {
	// Create new PDO object and get MySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/peep.ini");
	$pdo = $secrets->getPdoObject();

	// What HTTP method was used?
	$method = $_SERVER("HTTP_X_HTTP_METHOD") ?? $_SERVER["REQUEST_METHOD"];

	// Sanitize and store input
	$userProfileId = filter_input(INPUT_GET, "userProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userProfileAuthenticationToken = filter_input(INPUT_GET, "userProfileAuthenticationToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userProfileEmail = filter_input(INPUT_GET, "userProfileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userProfileName = filter_input (INPUT_GET, "userProfileName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	// Define behaviour if $method is a GET request
	if($method === "GET") {

		// Set the XSRF cookie
		setXsrfCookie();

		// Get userProfile based on ID. Is this the best way?
		if(empty($userProfileId) === false) {
			$reply->data = UserProfile::getUserProfileById($pdo, $userProfileId);
		} else if (empty ($userProfileEmail) === false) {
			$reply->data = UserProfile::getUserProfileByEmail($pdo, $userProfileEmail);
		} else if (empty ($userProfileAuthenticationToken) === false) {
			$reply->data = UserProfile::getUserProfileByAuthenticationToken($pdo, $userProfileAuthenticationToken);
		} else if (empty ($userProfileName) === false) {
			$reply->data = UserProfile::getUserProfileByName($pdo, $userProfileName);
		}

		//Then comes checking for PUT or POST requests.
	}
	elseif($method === "PUT") {
		// enforce the user has a XSRF token
		verifyXsrf();

		//enforce the user is signed in with a valid JWT token and only trying to edit their own profile
		if(empty($_SESSION["userProfile"]) === true || $_SESSION["userProfile"]->getUserProfileId()->toString() !== $userProfileId) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}
		validateJwtHeader();

		//  Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestContent = file_get_contents("php://input");
		// This Line Then decodes the JSON package and stores that result in $requestObject
		$requestObject = json_decode($requestContent);
		//retrieve profile to be updated
		$userProfile = userProfile::getUserProfileById($pdo, $userProfileId);
		if ($userProfile=== null) {
			throw (new \RuntimeException("Profile doesn't exist",  404));
		}

		//make sure that a profile name exists
		if (empty($requestObject->userProfileName)=== true) {
			throw (new \InvalidArgumentException("No profile with this name", 405));
		}
		//make sure profile email is available (required field)
		if(empty($requestObject->userProfileEmail) === true) {
			throw(new \InvalidArgumentException ("No email for profile.", 405));
		}

		//profile activation token | if null use activation token in database
		if (empty($requestObject->userProfileAuthenticationToken)=== true) {
			$requestObject->userProfileAuthenticationToken = $userProfile ->getUserProfileAuthenticationToken()
		};

		$userProfile->setUserProfileName($requestObject->userProfileName);
		$userProfile->setUserProfileEmail($requestObject->userProfileEmail);
		$userProfile->setUserProfileAuthenticationToken($requestObject->userProfileAuthenticationToken);
		$userProfile->update($pdo);

		//updated reply
		$reply->message = "User Profile information updated";

//
//		if($method === "PUT") {
//
//			verifyXsrf();
//
//			//enforce the user is signed in with a valid JWT token and only trying to edit their own profile
//			if(empty($_SESSION["userProfile"]) === true || $_SESSION["userProfile"]->getUserProfileId()->toString() !== $userProfileId) {
//				throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
//			}
//			validateJwtHeader();
//
//			//determine if we have a PUT request. Process PUT request here
//			// retrieve the profile to update
//			$profile = UserProfile::getUserProfileById($pdo, $userProfileId);
//			if($profile == null) {
//				throw(new \RuntimeException("Profile does not exist", 404));
//			}
//			//Here, we must add security measures to prevent hostiles from altering profiles maliciously.
//			//To start, enforce the user is signed in.
//			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $profile->getUserProfileId()) {
//				throw(new \InvalidArgumentException("You must be Signed In to update your profile.", 403));
//			}
//			// update all attributes
//			$profile->setUserProfileId($requestObject->userProfileId);
//			$profile->setUserProfileAuthenticationToken($requestObject->userProfileAuthenticationToken);
//			$profile->setUserProfileEmail($requestObject->userProfileEmail);
//			$profile->setUserProfileFirstName($requestObject->userProfileFirstName);
//			$profile->setUserProfileLastName($requestObject->userProfileLastName);
//			$profile->setUserProfileHash($requestObject->userProfileHash);
//			$profile->update($pdo);
//			// update reply
//			$reply->message = "Everything updated";
//		}
	//We will need a delete option too.
	}else if($method === "DELETE") {
		//process DELETE request
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		// retrieve the profile to be deleted
		$profile = UserProfile::getUserProfileById($pdo, $userProfileId);
		if($profile === null) {
			throw(new \RuntimeException("Profile Does Not Exist", 404));
		}
		//enforce the user is signed in.
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $profile->getUserProfileId()) {
			throw(new \InvalidArgumentException("You must be Signed In to Delete", 403));
		}
		validateJwtHeader();

		// delete profile
		$profile->delete($pdo);
		// update reply
		$reply->message = "Profile deleted";
	}
	else {
		throw(new \InvalidArgumentException("Invalid HTTP Request...", 400));
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