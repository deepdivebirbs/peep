<?php

namespace Birbs\Peep;

use http\Exception\BadQueryStringException;
use http\Exception\InvalidArgumentException;
use PDO;

/**
 * This class takes API data from the Ebirds API at https://confluence.cornell.edu/display/CLOISAPI/eBirdAPIs and parses
 * the data into usable chunks and inserts that data into the table as specified.
 **/
class BirdSpecies {

	//Define variables
	// private $birdId;

	public $specCode;

	public $comName;

	public $sciName;

	public $locData;/**

	/**
	 * BirdSpecies constructor.
	 * @param specCode $
	 * @param comName $
	 * @param sciName $
	 * @param locData $
	 * @throws \InvalidArgumentException
	 * @throws \RangeException
	 * @throws \Exception
	 * @throws \TypeError
	 */
	public function __construct($specCode, $comName, $sciName, $locData) {
		try {
			// Call all of the setters and create the object.
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->setSpeciesCode($specCode);
		$this->setComName($comName);
		$this->setSciName($sciName);
		// $this->setLocData($locData);
	}

	/**
	 * Getters
	 */

/*
	public function getBirdId() : string {
		return $this->birdId;
	}
*/

	/**
	 * Gets the specCode and returns it.
	 *
	 * @return string
	 */
	public function getSpecCode() : string {
		return $this->specCode;
	}

	/**
	 * @return string
	 */
	public function getComName() : string {
		return $this->comName;
	}

	/**
	 * @return string
	 */
	public function getSciName() : string {
		return $this->sciName;
	}

	/**
	 * @return float
	 */
	public function getLocData() : float {
		return $this->locData;
	}

	/**
	 * Setters
	 */

	/**
	 * @param $specCode
	 * @throws \TypeError if $specCode isn't a string
	 * @throws \RangeException if $specCode is less than 6 characters
	 */
	public function setSpeciesCode($specCode) : void {
		//Check if given parameter is valid data.
		if(get_class($specCode) !== 'string') {
			throw(new \TypeError("specCode must be a string."));
		}

		if (strlen($specCode) <= 6) {
			throw(new \RangeException("specCode must be at least 6 characters."));
		}
		$this->specCode = $specCode;
	}

	/**
	 * @param $comName
	 * @throws \InvalidArgumentException if $comName is NULL
	 * @throws \TypeError if $comName isn't a string
	 */
	public function setComName($comName) : void {
		// Check if $comName is NULL.
		if(is_null($comName) !== true) {
			throw(new InvalidArgumentException('comName cannot be NULL!'));
		}

		// Check if $comName is string.
		if(get_class($comName) !== 'string') {
			throw(new \TypeError('comName must be string.'));
		}
		$this->comName = $comName;
	}

	/**
	 * @param $sciName
	 * @throws \InvalidArgumentException if $sciName is NULL
	 * @throws \TypeError if $sciName isn't a string
	 */
	public function setSciName($sciName) : void {
		// Check if $sciName is NULL.
		if(is_null($sciName)) {
			throw(new InvalidArgumentException('sciName cannot be null.'));
		}

		// Check if $sciName is a string.
		if(get_class($sciName) !== 'string') {
			throw(new \TypeError('sciName must be a string.'));
		}
		$this->sciName = $sciName;
	}

	public function setLocData($locX, $locY) {
		$this->locData = "X:$locX" . "Y:$locY";
	}

	// Insert Function
	public function insert(\PDO $pdo) : void {
		// Define the insert query
		$query = "INSERT INTO birdSpecies(speciesCode, commonName, sciName, locationX, locationY, dateTime, birdPhoto) VALUES(:specCode, :comName, :sciName, :locData)";
		$statement = $pdo->prepare($query);

		echo get_class($query);
		echo get_class($statement);

		$params = ["speciesCode" => $this->specCode, "commonName" => $this->comName, "sciName" => $this->sciName, "locationX" => $this->lo];

	}
}
?>