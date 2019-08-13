<?php

namespace Birbs\Peep;

// Import BirdSpecies class
require_once(dirname(__DIR__, 1) . "/Classes/BirdSpecies.php");

// Import Secrets
require_once("/etc/apache2/capstone-mysql/Secrets.php");

$dataObject = new \PDO("mysql:dbname=mwaid1;host=localhost", "mwaid1", "Mm]bA&YZnFR8h,3U");

$species = new BirdSpecies("95c6f2f3-515c-4ee7-9c15-3b03b9569fa3", "123ABC", "Red Tailed Hawk", "Birdus Maximus", "https://birdphoto.com");

//echo($species->getSpeciesId());

$species->insert($dataObject);
echo


?>
