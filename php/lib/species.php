<?php

namespace Birbs\Peep;

// Import BirdSpecies class
require_once(dirname(__DIR__, 1) . "/Classes/BirdSpecies.php");

// Import Secrets
require_once("/etc/apache2/capstone-mysql/Secrets.php");

// Read .ini file
$dbInfo = parse_ini_file(dirname(__DIR__, 2) . "/sql/peep.ini");

// Check if parse_ini_file was successful
if($dbInfo === false) {
	throw(new \Exception("Something is wrong with either the .ini file, the .ini file path, or parse_ini_file()"));
}

$species = new BirdSpecies("95c6f2f3-515c-4ee7-9c15-3b03b9569fa3", "123ABC", "Red Tailed Hawk", "Birdus Maximus", "https://birdphoto.com");

//echo($species->getSpeciesId());

$species->insert($dataObject);


