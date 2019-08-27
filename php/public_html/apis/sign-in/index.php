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
