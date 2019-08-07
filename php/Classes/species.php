<?php

namespace Birbs\Peep;
//require_once("autoload.php");
//require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");

require_once("BirdSpecies.php");

$datetime = new \DateTime("now", new \DateTimeZone("America/Denver"));

$species = new BirdSpecies("95c6f2f3-515c-4ee7-9c15-3b03b9569fa3", "123ebv", "Some Bird", "Birdus Maximus", 123.021, 43.123, $datetime, "http://url.com");


echo(var_dump($species));

?>