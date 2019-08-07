<?php
namespace Birbs\Peep;

require_once (dirname(__DIR__, 1) . "/Classes/sighting.php");

/**
 * @var sighting $foo instantiation test
 **/

//new \DateTime("now", new \DateTimeZone("America/Denver"));

$foo = new sighting("6099832b-e521-4d90-92f3-a6f354a90a39", "c8c67ec4-bc09-4de2-83cd-93940ab8e807", "8cd72411-79f1-40fc-b9a0-ad62fef9d447", "pretty bird", "birdimus prettimus", 35.085, -106.649, "08/10/18", "birdphoto.com/birdie");


var_dump($foo);