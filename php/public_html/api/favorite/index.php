<?php

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
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize the search parameters
	$favoriteUserProfileId = $id = filter_input(INPUT_get, "favoriteUserProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$favoriteBirdSpeciesId = $id = filter_input(INPUT_GET, "favoriteSpeciesId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if ($method ==="GET") {
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
			$reply->data = Favorite::getAllFavoriteByUserProfileId()
		}
	}







}