<?php

namespace Birbs\Peep;

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

	public $locData;

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

	public function getBirdId() : int {
		return $this->birdId;
	}

	public function getSpecCode() : string {
		return $this->specCode;
	}

	public function getComName() : string {
		return $this->comName;
	}

	public function getSciName() : string {
		return $this->sciName;
	}

	public function getLocData() : float {
		return $this->locData;
	}

	/**
	 * Setters
	 */

	public function setBirdId($birdId) : void {
		//Check if given parameter is valid data.
		/**
		 * Some try catch statement here?  Error handling for invalid data?
		 */
	}

	public function setSpecCode($specCode) : void {
		// Check if data is valid
		/**
		 * Try catch statement with error handling.
		 */
	}

	public function setComName($comName) : void {

	}

	public function setSciName($sciName) : void {

	}

	public function setLocData($locData) : void {
		// Make sure location data is valid and accurate.
		/**
		 * Try catch with error handling
		 */
	}
}
?>