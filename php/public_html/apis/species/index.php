<?php
namespace Birbs\Peep;

require_once(dirname(__DIR__, 3) . "/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");

require_once("/etc/apache2/capstone-mysql/Secrets.php");

require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";

use Birbs\Peep\{Sighting, BirdSpecies, Favorite, UserProfile};

// Check if session is active, and if not activate it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// Create an empty reply for some reason
$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// Create new PDO object
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/peep.ini");
	$pdo = $secrets->getPdoObject();

	// What HTTP method was used?
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

} catch(\Exception $exception) {
	$exceptionType = get_class($exception);
	throw(new $exceptionType($exception->getMessage(), 0, $exception));
}



