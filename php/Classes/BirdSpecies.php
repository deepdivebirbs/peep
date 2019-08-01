<?php

namespace Birbs\Peep;

use http\Exception\BadQueryStringException;
use http\Exception\InvalidArgumentException;

/**
 * This class takes API data from the Ebirds API at https://confluence.cornell.edu/display/CLOISAPI/eBirdAPIs and parses
 * the data into usable chunks and inserts that data into the table as specified.
 **/
class BirdSpecies {

	//Define variables
	private $birdId;

	public $specCode;

	public $comName;

	public $sciName;

	public $locData;/**
		 * Some try catch statement here?  Error handling for invalid data?
		 */

	/**
	 * BirdSpecies constructor.
	 * @param birdId $
	 * @param specCode $
	 * @param comName $
	 * @param sciName $
	 * @param locData $
	 * @throws \InvalidArgumentException
	 * @throws \RangeException
	 * @throws \Exception
	 * @throws \TypeError
	 */
	public function __construct($birdId, $specCode, $comName, $sciName, $locData) {
		try {
			// Call all of the setters and create the object.
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * Getters
	 */

	/**
	 * Gets the birdId string and returns it.
	 *
	 * @return string
	 */
	public function getBirdId() : string {
		return $this->birdId;
	}

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
	 * @param $birdId
	 * @throws \TypeError if $birdId isn't a string
	 * @throws \RangeException if $birdId is less than 6 characters
	 */
	public function setBirdId($birdId) : void {
		//Check if given parameter is valid data.
		if(get_class($birdId) !== 'string') {
			throw(new \TypeError("birdId must be a string."));
		}

		if (strlen($birdId) <= 6) {
			throw(new \RangeException("birdId must be at least 6 characters."));
		}
		$this->birdId = $birdId;
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

	//Javascript location function here.
	/*
	 * function setLocData() {
	 *
	 * }
	 */
}
?>