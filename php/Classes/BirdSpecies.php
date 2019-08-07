<?php

namespace Birbs\Peep;

// Require our external local classes
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
//require_once("ValidateDate.php");
//require_once ("ValidateUuid.php");

use Ramsey\Uuid\Uuid;

/**
 * This class takes API data from the Ebirds API at https://confluence.cornell.edu/display/CLOISAPI/eBirdAPIs and parses
 * the data into usable chunks and inserts that data into the table as specified.
 **/
class BirdSpecies {

	use ValidateUuid;
	use ValidateDate;

	//Define variables
	// private $birdId;

	// speciesId is the main identifier for a bird species on the site.
	public $speciesId;

	// speciesCode is an ID convention offered by the ebird API, we don't know what to do with it yet.
	public $speciesCode;

	// speciesComName hold the value for the common name given to the bird EX. Red Tailed Hawk.
	public $speciesComName;

	// speciesSciName holds the value of the scientific latin name given to the bird.  Ex. Columbidae.
	public $speciesSciName;

	// speciesLocX holds the X lat/long coord for a bird sighting specified in the API.
	public $speciesLocX;

	// speciesLocY holds the Y lat/long coord for a bird sighting specified in the API.
	public $speciesLocY;

	// speciesDateTime holds the date time object for an API sighting.
	public $speciesDateTime;

	// speciesPhoto holds the URL that the bird pic is stored.
	public $speciesPhoto;

	/**
	 * BirdSpecies constructor.
	 * @param $speciesId
	 * @param $speciesCode
	 * @param $speciesComName
	 * @param $speciesSciName
	 * @param $speciesLocX
	 * @param $speciesLocY
	 * @param $speciesDateTime
	 * @param $speciesPhoto
	 * @throws \InvalidArgumentException
	 * @throws \RangeException
	 * @throws \Exception
	 * @throws \TypeError
	 */
	public function __construct($speciesId, $speciesCode, $speciesComName, $speciesSciName, $speciesLocX, $speciesLocY, $speciesDateTime, $speciesPhoto) {
		try {
			// Call all of the setters and create the object.
			$this->setSpeciesId($speciesId);
			$this->setSpeciesCode($speciesCode);
			$this->setspeciesComName($speciesComName);
			$this->setspeciesSciName($speciesSciName);
			$this->setLocData($speciesLocX, $speciesLocY);
			$this->setSpeciesDateTime($speciesDateTime);
			$this->setSpeciesPhotoUrl($speciesPhoto);

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * Getters
	 */

	/**
	 * @return Uuid
	 */
	public function getSpeciesId(): Uuid {
		return $this->speciesCode;
	}

	/**
	 * Gets the speciesCode and returns it.
	 *
	 * @return string
	 */
	public function getSpeciesCode(): string {
		return $this->speciesCode;
	}

	/**
	 * @return string
	 */
	public function getSpeciesComName(): string {
		return $this->speciesComName;
	}

	/**
	 * @return string
	 */
	public function getspeciesSciName(): string {
		return $this->speciesSciName;
	}

	/**
	 * @return string
	 */
	public function getLocData(): string {
		// Create string from location data
		$locString = $this->speciesLocX . $this->speciesLocY;
		return $locString;
	}

	/**
	 * @return \DateTime
	 */
	public function getSpeciesDateTime(): int {
		return $this->speciesDateTime;
	}

	/**
	 * @return string
	 */
	public function getSpeciesPhoto(): string {
		return $this->speciesPhoto;
	}

	/**
	 * Setters
	 */

	/**
	 * @param $speciesId
	 * @return void
	 * @throws \RangeException if the UUID is too short or too long.
	 * @throws \TypeError if $speciesId isn't a UUID.
	 * @throws \Exception if any other exception is called.
	 * @throws \InvalidArgumentException if $speciesId isn't a UUID or not formatted correctly.
	 */
	public function setSpeciesId($speciesId): void {
		try {
			$uuid = self::validateUuid($speciesId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($speciesId);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->speciesId = $speciesId;
	}

	/**
	 * @param $speciesCode
	 * @throws \TypeError if $speciesCode isn't a string
	 * @throws \RangeException if $speciesCode is less than 6 characters
	 */
	public function setSpeciesCode($speciesCode): void {
		// Check if speciesCode is a string.
		if(gettype($speciesCode) !== 'string') {
			throw(new \TypeError("speciesCode must be a string."));
		}

		if(strlen($speciesCode) < 6) {
			throw(new \RangeException("speciesCode must be at least 6 characters."));
		}
		$this->speciesCode = $speciesCode;
	}

	/**
	 * @param $speciesspeciesComName
	 * @throws \InvalidArgumentException if $speciesspeciesComName is NULL
	 * @throws \TypeError if $speciesspeciesComName isn't a string
	 */
	public function setspeciesComName($speciesspeciesComName): void {
		// Check if $speciesspeciesComName is NULL.
		if(empty($speciesspeciesComName) === true) {
			var_dump($speciesspeciesComName);
			throw(new \InvalidArgumentException('speciesComName cannot be empty!'));
		}

		// Check if $speciesSpeciesComName is string.
		if(gettype($speciesspeciesComName) !== 'string') {
			throw(new \TypeError('speciesComName must be string.'));
		}
		$this->speciesComName = $speciesspeciesComName;
	}

	/**
	 * @param $speciesspeciesSciName
	 * @throws \InvalidArgumentException if $speciesspeciesSciName is NULL
	 * @throws \TypeError if $speciesspeciesSciName isn't a string
	 */
	public function setspeciesSciName($speciesspeciesSciName): void {
		// Check if $speciesspeciesSciName is NULL.
		if(is_null($speciesspeciesSciName)) {
			throw(new \InvalidArgumentException('speciesSciName cannot be null.'));
		}

		// Check if $speciesspeciesSciName is a string.
		if(gettype($speciesspeciesSciName) !== 'string') {
			throw(new \TypeError('speciesSciName must be a string.'));
		}
		$this->speciesSciName = $speciesspeciesSciName;
	}

	/**
	 * @param $speciesLocX
	 * @param $speciesLocY
	 * @throws \TypeError if $speciesLocX or $speciesLocY are not floats.
	 */
	public function setLocData($speciesLocX, $speciesLocY) {

		//echo(var_dump($speciesLocX, $speciesLocY));
		// Check if $speciesLocX is NULL.
		if(is_null($speciesLocX)) {
			throw(new \InvalidArgumentException("speciesLocX cannot be NULL"));
		}

		// Check if empty.
		if(empty($speciesLocX) || empty($speciesLocY)) {
			throw(new \InvalidArgumentException('$speciesLocX and $speciesLocY must not be NULL'));
		}

		if(is_float($speciesLocX) !== true && is_float($speciesLocY) !== true) {
			throw(new \TypeError('$speciesLocX and speciesLocY must both be floats.'));
		}
		$this->speciesLocX = $speciesLocX;
		$this->speciesLocY = $speciesLocY;
	}

	/**
	 * @param $speciesPhoto
	 */
	public function setSpeciesPhotoUrl($speciesPhoto): void {
		if(empty($speciesPhoto)) {
			throw(new \InvalidArgumentException('$speciesPhoto must not be empty!'));
		}

		if(gettype($speciesPhoto) !== 'string') {
			throw(new \TypeError('$speciesPhoto must be a string!'));
		}

		$this->speciesPhoto = $speciesPhoto;
	}

	/**
	 * @param \DateTime $dateTime
	 * @throws \InvalidArgumentException if $datetime isn't a DateTime object.
	 * @throws \Exception
	 */
	public function setSpeciesDateTime(\DateTime $dateTime) {

		// Check to see if $datetime is empty.
		if(empty($dateTime)) {
			throw(new \InvalidArgumentException("datetime must not be empty."));
		}

		// Check if $datetime is a datetime object.
		if(get_class($dateTime) !== 'DateTime') {
			throw(new \InvalidArgumentException("Date Time must be a \DateTime object."));
		}

		// Get current datetime.
		$currentDate = new \DateTime("now", new \DateTimeZone("America/Denver"));

		// TODO Compare current date with given date and throw an error if given date is > than today's date.

		$this->speciesDateTime = $dateTime;
	}

	/**
	 * @param $speciesCode
	 * @throws \InvalidArgumentException if $speciesCode is NULL.
	 * @throws \PDOException if something is wrong with the PDO object.
	 * @throws \Exception if any other exception happens.
	 * @throws \RangeException if $speciesCode is > or < 6 characters.
	 * @return \Ramsey\Uuid\
	 */
	public function getBirdBySpeciesId(\PDO $pdo, string $speciesCode): Uuid {
		if(empty($speciesCode)) {
			throw(new \InvalidArgumentException("speciesCode must not be empty."));
		}

		if(strlen($speciesCode) < 6 ?? strlen($speciesCode) > 6) {
			throw(new \RangeException("speciesCode must be no more or less than 6 characters."));
		}

		// Create an SQL query to send for the speciesCodes.
		$query = "SELECT speciesCode, speciesComName, speciesSciName FROM peep WHERE speciesCode = :speciesCode";
		$statement = $pdo->prepare($query);

		$birds = new \SplFixedArray($statement->rowCount());

		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row = $statement->fetch()) !== false) {
			try {
				$bird = new BirdSpecies($row["speciesId"], $row["speciesCode"], $row["speciesComName"], $row["speciesSciName"], $row["speciesLocX"], $row["speciesLocY"]);
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return $birds;
	}

	//Insert and Delete functions.

	/**
	 * Insert Function
	 * @param \PDO $pdo
	 */
	public function insert(\PDO $pdo): void {
		// Define the insert query
		$query = "INSERT INTO birdSpecies(speciesCode, commonName, speciesSciName, locationX, locationY, dateTime, birdPhoto) VALUES(:speciesCode, :speciesComName, :speciesSciName, :locData)";
		$statement = $pdo->prepare($query);

		$params = ["speciesCode" => $this->speciesCode, "commonName" => $this->speciesComName, "speciesSciName" => $this->speciesSciName, "speciesLocX" => $this->speciesLocX, "speciesLocY" => $this->speciesLocY];
		$statement->execute($params);
	}

	public function delete($post) {
		// Delete some stuff...
	}
}

?>