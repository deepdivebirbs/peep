<?php
namespace Birb\Peep;

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
/**
 * api for signing up too DDC Twitter
 *
 * @author Mark Waid
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// Create PDO Object
	$secret = new \Secrets("/etc/apache2/capstone-mysql/peep.ini");
	$pdo = $secret->getPdoObject();

	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	if($method === "POST") {
		// Get request JSON and convert to php Object
		$reqContent = file_get_contents("php://input");
		$reqObj = json_decode($reqContent);

		$reply->data = $reqObj;


		echo json_encode($reply->data->password);
	}


} catch(\Exception $exception) {
	$exceptionType = get_class($exception);
	throw(new $exceptionType($exception->getMessage(), 0, $exception));
}