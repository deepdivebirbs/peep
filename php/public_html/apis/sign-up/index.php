<?php
use Birbs\Peep\UserProfile;
use http\Client\Curl\User;
use http\Exception\InvalidArgumentException;

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
/**
 * Sign-Up API for the Ebirbs project
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



		/* Set object variables */

		// Get first and last name
		$userFirstName = $reqObj->userFirstName;
		$userLastName = $reqObj->userLastName;

		// Get Username
		$profileUsername = $reqObj->profileUsername;

		// Get Email
		$userProfileEmail = $reqObj->userProfileEmail;

		// Get userProfilePassword
		$userProfilePassword = $reqObj->userProfilePassword;
		$userProfilePasswordConfirm = $reqObj->userProfilePasswordConfirm;

		/* FIRST AND LAST NAME STUFF */
		// Check if first name field is empty
		if(empty($userFirstName) === true || empty($userLastName) === true) {
			throw(new \InvalidArgumentException("First name is required.", 405));
		}

		/* USERNAME STUFF */
		// Check if Username is empty
		if(empty($profileUsername) === true) {
			throw(new \InvalidArgumentException("Username must not be empty.", 405));
		}

		if(strlen($profileUsername) < 3 && strlen($profileUsername) > 40) {
			throw(new \InvalidArgumentException("Username minimum 3 characters and max 40 characters.", 405));
		}

		// Check if username exists
		if(UserProfile::getUserProfileByName($pdo, $profileUsername)) {
			throw(new \InvalidArgumentException("Username exists.  Please choose another.", 405));
		}

		/* EMAIL STUFF */
		// Check if email field is empty
		if(empty($userProfileEmail) === true) {
			throw(new \InvalidArgumentException("Email is required.", 405));
		}

		/* PASSWORD STUFF */
		// Check if password field is empty
		if(empty($userProfilePassword) === true) {
			echo "Password Can't be empty.";
			throw(new \InvalidArgumentException("Password cannot be empty.", 405));
		}

		// Check if password confirmation is empty
		if(empty($userProfilePasswordConfirm) === true) {
			echo "<h1>You must confirm you password.</h1>";
			throw(new \InvalidArgumentException("You must confirm your password.", 405));
		}

		// Make sure the password length is at least 8 characters
		if(strlen($userProfilePassword) < 8) {
			throw(new \RangeException("Password must be at least 8 characters.", 405));
		}

		// Make sure password and the password confirmation match
		if($userProfilePassword !== $userProfilePasswordConfirm) {
			throw(new \InvalidArgumentException("Passwords did not match.", 405));
		}

		/*
		if(!strpos($userProfilePassword, $specialChars[1], 0)) {
			echo "<h1>Must contain a special character.</h1>";
		}
		*/

		// Hash the password
		$hash = password_hash($userProfilePassword, PASSWORD_ARGON2I, ["time_cost" => 384]);

		// Generate profile activation token
		$profileAuthToken = bin2hex(random_bytes(16));

		// Create new user profile
		$userProfile = new UserProfile(generateUuidV4(), $profileUsername, $userFirstName, $userLastName, $userProfileEmail, $profileAuthToken, $hash);

		// Insert the created user profile into the database
		$userProfile->insert($pdo);

		// Create email subject
		$emailSubject = "You are about to enter the wonderful world of BIRBS!";

		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);

		$urlGlue = $basePath . "/apis/activation/index.php/?activation=" . "$profileAuthToken";

		// Create the actual link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlGlue;

		// Message contents
		$message = <<< EOF
<h1>Welcome to your Peep Account!</h1>
<p>With this account you can:</p>
<ul>
	<li>Log in and view birds</li>
	<li>View bird location info</li>
	<li>Learn when you will see certain birds during the year</li>
	<li><br> We'll be adding the ability to favorite birds, with lots more functionality on the way!</li>
</ul>
<p>Click on the link below to activate you account:</p>
<a href="$confirmLink">$confirmLink</a>
EOF;
		// Create new swift mail object
		$swiftMessage = new \Swift_Message();

		// Set return address
		$swiftMessage->setFrom(["fleabass4@gmail.com" => "Ebirbs Team"]);

		// Set recipient
		$to = [$userProfileEmail];
		$swiftMessage->setTo($to);

		// Set subject
		$swiftMessage->setSubject($emailSubject);

		// Set body
		$swiftMessage->setBody($message, "text/html");
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");

		// Set up smtp and mailer objects
		$smtp = new \Swift_SmtpTransport("localhost", 25);
		$mailer = new \Swift_Mailer($smtp);

		$numSent = $mailer->send($swiftMessage, $failed);

		if($numSent !== count($to)) {
			throw(new \RuntimeException("Unable to send Email.", 400));
		}

		$reply->message = "Thank you for creating an account on the Ebirbs website!";

	} else {
		throw(new \InvalidArgumentException("Invalid HTTP Request..."));
	}
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}

header("Content-type: application/json");
echo json_encode($reply);