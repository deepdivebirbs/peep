<?php
require_once "Favorite.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once "UserProfile.php";
require_once "BirdSpecies.php";



$secrets = new \Secrets("/etc/apache2/capstone-mysql/peep.ini");
$pdo = $secrets->getPdoObject();

$password = "abc123";
$VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

$authtoken= bin2hex(random_bytes(16));
$userProfile = new \Birbs\Peep\UserProfile("8095b2c7-bd5d-4968-b02b-b90071a82e39", "name", "FirsName", "LassName",  "gmail@gmail.com", $authtoken, $VALID_HASH);

$birdSpecies = new \Birbs\Peep\BirdSpecies("230e90d9-753c-42ab-888f-37ddeb0e62c2", "123445", "Bird", "Birdus Maximus", "https://url.com");

$birdSpecies->insert($pdo);
$userProfile->insert($pdo);

$favorite = new \Birbs\Peep\Favorite("230e90d9-753c-42ab-888f-37ddeb0e62c2", "8095b2c7-bd5d-4968-b02b-b90071a82e39");
$favorite->insert($pdo);


