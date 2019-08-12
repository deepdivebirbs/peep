<?php

namespace Birbs\Peep;

// TODO Work on documentation!

// Require our external local classes
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");

use mysql_xdevapi\Exception;
use Ramsey\Uuid\Uuid;

/**
 * This class takes API data from the Ebirds API at https://confluence.cornell.edu/display/CLOISAPI/eBirdAPIs and parses
 * the data into usable chunks and inserts that data into the table as specified.
 **/
class BirdSpecies {

	use ValidateUuid;
	use ValidateDate;

	//Define variables
	// private $speciesId;

	// speciesId is the main identifier for a bird species on the site.
	public $speciesId;

	// speciesCode is an ID convention offered by the ebird API, we don't know what to do with it yet.
	public $speciesCode;

	// speciesComName hold the value for the common name given to the bird EX. Red Tailed Hawk.
	public $speciesComName;

	// speciesSciName holds the value of the scientific latin name given to the bird.  Ex. Columbidae.
	public $speciesSciName;

	// speciesPhoto holds the URL that the bird pic is stored.
	public $speciesPhoto;

	/**
	 * BirdSpecies constructor.
	 * @param $speciesId the unique ID that identifies a bird species.
	 * @param $speciesCode the code given by the eBirds API to each sighting.
	 * @param $speciesComName the common name given to a bird.
	 * @param $speciesSciName the scientific name given to a bird.
	 * @param $speciesPhoto the URL where the photo of the bird can be found.
	 * @throws \InvalidArgumentException if any arguments are invalid.
	 * @throws \RangeException if any arguments are out of specified range.
	 * @throws \Exception if any other Exception is caught.
	 * @throws \TypeError if any argument given is of the wrong type.
	 */
	public function __construct($speciesId, $speciesCode, $speciesComName, $speciesSciName, $speciesPhoto) {
		try {
			// Call all of the setters and create the object.
			$this->setSpeciesId($speciesId);
			$this->setSpeciesCode($speciesCode);
			$this->setspeciesComName($speciesComName);
			$this->setspeciesSciName($speciesSciName);
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
	 * Gets speciesId and returns it as a UUID.
	 *
	 * @return Uuid
	 */
	public function getSpeciesId(): Uuid {
		return $this->speciesCode;
	}

	/**
	 * Gets the speciesCode and returns it as a string.
	 *
	 * @return string
	 */
	public function getSpeciesCode() : string {
		return $this->speciesCode;
	}

	/**
	 * Gets the bird common name and returns it as a string.
	 *
	 * @return string
	 */
	public function getSpeciesComName() : string {
		return $this->speciesComName;
	}

	/**
	 * Gets the bird scientific name and returns it as a string.
	 *
	 * @return string
	 */
	public function getSpeciesSciName() : string {
		return $this->speciesSciName;
	}

	/**
	 * Gets the URL for the photo as a string and returns it.
	 *
	 * @return string
	 */
	public function getSpeciesPhoto() : string {
		return $this->speciesPhoto;
	}

	/**
	 * Setters
	 */

	/**
	 * Sets the value of bird species ID and stores it in $speciesId.
	 *
	 * @param $speciesId
	 * @return void
	 * @throws \RangeException if the UUID is too short or too long.
	 * @throws \TypeError if $speciesId isn't a UUID.
	 * @throws \Exception if any other exception is called.
	 * @throws \InvalidArgumentException if $speciesId isn't a UUID or not formatted correctly.
	 */
	public function setSpeciesId($speciesId) : void {
		try {
			$uuid = self::validateUuid($speciesId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($speciesId);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->speciesId = $uuid;
	}

	/**
	 * Sets $speciesCode variable
	 *
	 * @param $speciesCode
	 * @throws \TypeError if $speciesCode isn't a string
	 * @throws \RangeException if $speciesCode is less than 6 characters
	 */
	public function setSpeciesCode($speciesCode): void {
		// Check if speciesCode is a string.
		if(gettype($speciesCode) !== 'string') {
			throw(new \TypeError("speciesCode must be a string."));
		}

		if(strlen($speciesCode) !== 6) {
			throw(new \RangeException("speciesCode must be 6 characters."));
		}
		$this->speciesCode = $speciesCode;
	}

	/**
	 * Sets the bird common name and stores it in $speciesComName.
	 *
	 * @param $speciesComName
	 * @throws \InvalidArgumentException if $speciesComName is NULL
	 * @throws \TypeError if $speciesComName isn't a string
	 */
	public function setSpeciesComName($speciesComName): void {
		// Check if $speciesComName is NULL.
		if(empty($speciesComName) === true) {
			var_dump($speciesComName);
			throw(new \InvalidArgumentException('speciesComName cannot be empty!'));
		}

		// Check if $speciesSpeciesComName is string.
		if(gettype($speciesComName) !== 'string') {
			throw(new \TypeError('speciesComName must be string.'));
		}
		$this->speciesComName = $speciesComName;
	}

	/**
	 * Sets the bird's scientific name and stores it in $speciesSciName.
	 *
	 * @param $speciesSciName provided scientific name for a bird species.
	 * @throws \InvalidArgumentException if $speciesSciName is NULL
	 * @throws \TypeError if $speciesSciName isn't a string
	 */
	public function setSpeciesSciName($speciesSciName): void {
		// Check if $speciesSciName is NULL.
		if(is_null($speciesSciName)) {
			throw(new \InvalidArgumentException('speciesSciName cannot be null.'));
		}

		// Check if $speciesSciName is a string.
		if(gettype($speciesSciName) !== 'string') {
			throw(new \TypeError('speciesSciName must be a string.'));
		}
		$this->speciesSciName = $speciesSciName;
	}

	/**
	 * @param $speciesPhoto
	 * @throws \InvalidArgumentException if $speciesPhoto is NULL.
	 * @throws \RangeException if $speciesPhoto is empty.
	 * @throws \TypeError if $speciesPhoto is NOT a string.
	 * @return void
	 */
	public function setSpeciesPhotoUrl($speciesPhoto) : void {

		if(is_null($speciesPhoto)) {
			throw(new \InvalidArgumentException('$speciesPhoto must not be NULL.'));
		}

		if(empty($speciesPhoto)) {
			throw(new \RangeException('$speciesPhoto must not be empty.'));
		}

		if(gettype($speciesPhoto) !== 'string') {
			throw(new \TypeError('$speciesPhoto must be a string.'));
		}

		// Check if a valid URL is given.
		try {
			$speciesPhoto = filter_var($speciesPhoto, FILTER_VALIDATE_URL);
		} catch(\InvalidArgumentException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}


		$this->speciesPhoto = $speciesPhoto;
	}

	/**
	 * Gets a bird by the bird's
	 *
	 * @param $speciesId
	 * @param $pdo
	 * @throws \InvalidArgumentException if $speciesCode is NULL.
	 * @throws \PDOException if something is wrong with the PDO object.
	 * @throws \Exception if any other exception happens.
	 * @throws \RangeException if $speciesCode is > or < 6 characters.
	 * @return \Ramsey\Uuid\
	 */
	public function getBirdBySpeciesId(\PDO $pdo, string $speciesId): Uuid {
		if(empty($speciesId)) {
			throw(new \InvalidArgumentException("speciesCode must not be empty."));
		}

		if(strlen($speciesId) < 6 ?? strlen($speciesId) > 6) {
			throw(new \RangeException("speciesCode must be no more or less than 6 characters."));
		}

		// Create an SQL query to send for the speciesCodes.
		$query = "SELECT speciesCode, speciesComName, speciesSciName FROM peep WHERE speciesId = :speciesId";
		$statement = $pdo->prepare($query);

		$birds = new \SplFixedArray($statement->rowCount());

		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row = $statement->fetch()) !== false) {
			try {
				$bird = new BirdSpecies($row["speciesId"], $row["speciesCode"], $row["speciesComName"], $row["speciesSciName"], $row["speciesPhoto"]);
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return $bird->speciesId;
	}

	//Insert and Delete functions.

	/**
	 * Inserts data into the mySQL table.
	 *
	 * @param \PDO $pdo
	 * @returns void
	 */
	public function insert(\PDO $pdo): void {
		// Define the insert query
		$query = "INSERT INTO birdSpecies(speciesCode, commonName, speciesSciName, birdPhoto) VALUES(:speciesCode, :speciesComName, :speciesSciName, :birdPhoto)";
		$statement = $pdo->prepare($query);

		$params = ["speciesCode" => $this->speciesCode, "commonName" => $this->speciesComName, "speciesSciName" => $this->speciesSciName, "speciesLocX" => $this->speciesLocX, "speciesLocY" => $this->speciesLocY];
		$statement->execute($params);
	}

	/**
	 * Deletes the selected bird entry by ID.
	 *
	 * @param \PDO $pdo
	 * @return void
	 */
	public function delete(\PDO $pdo): void {
		// Create mySQL query
		$query = "DELETE FROM peep WHERE speciesId = :speciesId";

		// Prepare mySQL query
		$statement = $pdo->prepare($query);

		// Set values
		$values = ["speciesId" => $this->speciesId];

		// Execute statement
		$statement->execute($values);
	}

	/**
	 * Returns an array of state variables formatted for JSON serialization.
	 *
	 * @return array
	 */
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		return $fields;
	}
}

?>