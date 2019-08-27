<?php

require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__,3)."/vendor/autoload.php";
require_once dirname(__DIR__,3). "/Classes/autoload.php";require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";

use Birbs\Peep\ {
	Favorite
};

/**
 *Api for the Favorite class
 */

//verify the session, start if not active
if(session_status()!==PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {

	$secrets = new \Secrets("/etc/apache2/capstone-mysql/peep.ini");
	$pdo = $secrets ->getPdoObject();

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize the search parameters
	$favoriteUserProfileId = filter_input(INPUT_GET, "favoriteUserProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$favoriteBirdSpeciesId = filter_input(INPUT_GET, "favoriteSpeciesId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if ($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets a specific favorite associated based off of the composite key of favoriteUserProfileId and favoriteSpeciesId
		if ($favoriteUserProfileId !== null && $favoriteBirdSpeciesId !==null) {
			$favorite = Favorite::getFavoriteByFavoriteUserProfileIdAndFavoriteSpeciesId($pdo, $favoriteUserProfileId, $favoriteBirdSpeciesId);
			if($favorite !==null) {
				$reply->data = $favorite;
			}
			//if none of the search parameters are met throw an exception
		} else if (empty($favoriteUserProfileId)===false) {
			$reply->data = Favorite::getAllFavoriteByUserProfileId($pdo, $favoriteUserProfileId)->toArray();
		} else{
			throw new InvalidArgumentException("incorrect search parameter", 404);
		}
	} else if ($method === "POST" || $method === "PUT") {
		//decode the response from the front end
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);
	if(empty($requestObject->favoriteUserProfileId) === true) {
		throw (new \InvalidArgumentException("No Profile linked to this Favorite", 405));
	}
	if ( $method === "POST") {
		//enforce that the user has an XSRF token
		verifyXsrf();
		//enforce the user has a JWT token
		//validateJwtHeader();
		//enforce the user is signed in
		if(empty(S_SESSION["userProfile"]) ===true) {
			throw (new InvalidArgumentException("You must be logged in to access your favorites", 403));
		}
		validateJwtHeader();
		$favorite = new Favorite ($_SESSION["userProfile"]->getUserProfileId(), $requestObject->favoriteBirdSpeciesId);
		$favorite->insert($pdo);
		$reply->message = "restaurant successfully added to favorites";
	}elseif($method === "PUT") {
		//enforce the end user has an XSRF token
		verifyXsrf();
		//enforce the end user has a JWT token
		validateJwtHeader();
		//grab the favorite by its composite key
		$favorite = Favorite::getAllFavoriteByUserProfileId($pdo, $requestObject->favoriteUserProfileId);
		if ($favorite === null) {
			throw (new RuntimeException("favorite does not exist"));
		}
		//enforce the user is signed in and only trying to edit their own favorite
		if(empty($_SESSION["userProfile"]) === true || $_SESSION["userProfile"]->getUserProfileId() !== $favorite->getFavoriteUserProfileId()) {
			throw (new \InvalidArgumentException("you are not allowed to delete this favorite", 403));
		}
		//validateJwtHeader();
		//preform the actual delete
		$favorite->delete($pdo);
		//update the message
		$reply->message = "favorite successfully deleted";
		}
	} else {
		throw (new \InvalidArgumentException("invalid http request", 400));
	}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);

var_dump($reply);