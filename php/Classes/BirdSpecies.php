<?php

namespace Birbs\Peep;

// Require our external local classes
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * This class takes API data from the Ebirds API at https://confluence.cornell.edu/display/CLOISAPI/eBirdAPIs and parses
 * the data into usable chunks and inserts that data into the table as specified.
 **/
class BirdSpecies {

	use ValidateUuid;
	use ValidateDate;

	//Define variables

	// speciesId is the main identifier for a bird species on the site.
	public $speciesId;

	// speciesCode is an ID convention offered by the ebird API, we don't know what to do with it yet.
	public $speciesCode;

	// speciesComName hold the value for the common name given to the bird EX. Red Tailed Hawk.
	public $speciesComName;

	// speciesSciName holds the value of the scientific latin name given to the bird.  Ex. Columbidae.
	public $speciesSciName;

	// speciesPhotoUrl holds the URL that the bird pic is stored.
	public $speciesPhotoUrl;

	/**
	 * BirdSpecies constructor.
	 * @param $speciesId the unique ID that identifies a bird species.
	 * @param $speciesCode the code given by the eBirds API to each sighting.
	 * @param $speciesComName the common name given to a bird.
	 * @param $speciesSciName the scientific name given to a bird.
	 * @param $speciesPhotoUrl the URL where the photo of the bird can be found.
	 * @throws \InvalidArgumentException if any arguments are invalid.
	 * @throws \RangeException if any arguments are out of specified range.
	 * @throws \Exception if any other Exception is caught.
	 * @throws \TypeError if any argument given is of the wrong type.
	 */
	public function __construct($speciesId, $speciesCode, $speciesComName, $speciesSciName, $speciesPhotoUrl) {
		try {
			// Call all of the setters and create the object.
			$this->setSpeciesId($speciesId);
			$this->setSpeciesCode($speciesCode);
			$this->setSpeciesComName($speciesComName);
			$this->setSpeciesSciName($speciesSciName);
			$this->setspeciesPhotoUrl($speciesPhotoUrl);

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
		return $this->speciesId;
	}

	/**
	 * Gets the speciesCode and returns it as a string.
	 *
	 * @return string
	 */
	public function getSpeciesCode(): string {
		return $this->speciesCode;
	}

	/**
	 * Gets the bird common name and returns it as a string.
	 *
	 * @return string
	 */
	public function getSpeciesComName(): string {
		return $this->speciesComName;
	}

	/**
	 * Gets the bird scientific name and returns it as a string.
	 *
	 * @return string
	 */
	public function getSpeciesSciName(): string {
		return $this->speciesSciName;
	}

	/**
	 * Gets the URL for the photo as a string and returns it.
	 *
	 * @return string
	 */
	public function getSpeciesPhotoUrl(): string {
		return $this->speciesPhotoUrl;
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
	public function setSpeciesId($speciesId): void {
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
	public function setSpeciesSciName($newSpeciesSciName): void {
		// Check if $speciesSciName is NULL.
		if(is_null($newSpeciesSciName)) {
			throw(new \InvalidArgumentException('speciesSciName cannot be null.'));
		}

		// Check if $speciesSciName is a string.
		if(gettype($newSpeciesSciName) !== 'string') {
			throw(new \TypeError('speciesSciName must be a string.'));
		}
		$this->speciesSciName = $newSpeciesSciName;
	}

	/**
	 * Sets the value of $speciesPhotoUrl.
	 *
	 * @param  $speciesPhotoUrl $ holds the URL of a photo as a string.
	 * @return void
	 * @throws \RangeException if $speciesPhotoUrl is empty.
	 * @throws \TypeError if $speciesPhotoUrl is NOT a string.
	 * @throws \InvalidArgumentException if $speciesPhotoUrl is NULL.
	 */
	public function setSpeciesPhotoUrl($speciesPhotoUrl): void {

		if(is_null($speciesPhotoUrl)) {
			throw(new \InvalidArgumentException('$speciesPhotoUrlUrl must not be NULL.'));
		}

		if(empty($speciesPhotoUrl)) {
			throw(new \RangeException('$speciesPhotoUrl must not be empty.'));
		}

		if(gettype($speciesPhotoUrl) !== 'string') {
			throw(new \TypeError('$speciesPhotoUrl must be a string.'));
		}

		// Check if a valid URL is given.
		try {
			trim($speciesPhotoUrl);
			$speciesPhotoUrl = filter_var($speciesPhotoUrl, FILTER_VALIDATE_URL);
		} catch(\InvalidArgumentException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->speciesPhotoUrl = $speciesPhotoUrl;
	}

	/**
	 * Gets a bird by the bird's species id
	 *
	 * @param $speciesId
	 * @param $pdo
	 * @throws \Exception if any other exception happens.
	 * @throws \RangeException if $speciesCode is > or < 6 characters.
	 * @throws \InvalidArgumentException if $speciesCode is NULL.
	 * @throws \PDOException if something is wrong with the PDO object.
	 * @throws \TypeError if NULL is returned
	 * @return BirdSpecies
	 */
	public function getSpeciesBySpeciesId(\PDO $pdo, $speciesId): ?BirdSpecies {
		if(empty($speciesId)) {
			throw(new \InvalidArgumentException("speciesId must not be empty."));
		}

		try {
			$validSpeciesId = self::validateUuid($speciesId);
		} catch(\PDOException | \RangeException | \InvalidArgumentException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// Create an SQL query to send for the speciesCodes.
		$query = "SELECT speciesCode, speciesComName, speciesSciName FROM birdSpecies WHERE speciesId = :speciesId";
		$statement = $pdo->prepare($query);

		// Set values
		$values = ["speciesId" => $validSpeciesId->getBytes()];
		$statement->execute($values);

		try {
			$birdSpecies = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$birdSpecies = new BirdSpecies($row["speciesId"], $row["speciesCode"], $row["speciesComName"], $row["speciesSciName"], $row["speciesPhotoUrl"]);
				var_dump($birdSpecies);
			}
		} catch(\Exception $exception) {
			$exceptionType = get_class($exception);
			//throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		return($birdSpecies);
	}

	/**
	 * Gets all birds in species table and returns them in a \SplitFixedArray.
	 *
	 * @param \PDO $pdo
	 * @return \SplFixedArray
	 */
	public function getAllBirds(\PDO $pdo): \SplFixedArray {
		// Create mySQL query
		$query = "SELECT speciesId, speciesCode, speciesComName, speciesSciName, speciesPhotoUrl FROM birdSpecies";

		// Prepare mySQL query
		$statement = $pdo->prepare($query);

		// Create array of birds
		$birds = new \SplFixedArray();

		// Set PDO fetch mode to FETCH_ASSOC.
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$statement->execute();

		// Loop through the table until there are no more birds to fetch.
		while(($row = $statement->fetch()) !== false) {
			try {
				$bird = new BirdSpecies($row["speciesId"], $row["speciesCode"], $row["speciesComName"], $row["speciesSciName"], $row["speciesPhotoUrl"]);
				$birds[$birds->key()] = $bird;
				$birds->next();
			} catch(\Exception $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
		}
		return $birds;
	}

	//Insert, delete, and update functions.

	/**
	 * Inserts data into the mySQL table.
	 *
	 * @param \PDO $pdo PHP Data Object
	 * @returns void
	 */
	public function insert(\PDO $pdo): void {
		// Define create mySQL query
		$query = "INSERT INTO birdSpecies(speciesId, speciesCode, speciesComName, speciesSciName, speciesPhotoUrl) VALUES(:speciesId, :speciesCode, :speciesComName, :speciesSciName, :speciesPhotoUrl)";

		// Prepare mySQL query
		$statement = $pdo->prepare($query);

		// Set values
		$values = ["speciesId" => $this->speciesId->getBytes(), "speciesCode" => $this->speciesCode, "speciesComName" => $this->speciesComName, "speciesSciName" => $this->speciesSciName, "speciesPhotoUrl" => $this->speciesPhotoUrl];

		// Bind values?


		// Execute statement
		$statement->execute($values);
	}

	/**
	 * Deletes the selected bird entry by ID.
	 *
	 * @param \PDO $pdo
	 * @return void
	 */
	public function delete(\PDO $pdo): void {
		// Create mySQL query
		$query = "DELETE FROM birdSpecies WHERE speciesId = :speciesId";

		// Prepare mySQL query
		$statement = $pdo->prepare($query);

		// Set values
		$values = ["speciesId" => $this->speciesId];

		// Execute statement
		$statement->execute($values);
	}

	/**
	 * Updates the values stored in the database.
	 *
	 * @param \PDO $pdo
	 * @returns void
	 */
	public function update(\PDO $pdo): void {
		// Create mySQL query
		$query = "UPDATE birdSpecies SET speciesId = :speciesId, speciesCode = :speciesCode, speciesComName = :speciesComName, speciesSciName = :speciesSciName, speciesPhotoUrl = :speciesPhotoUrl";

		// Prepare mySQL query
		$statement = $pdo->prepare($query);

		// Set values
		$values = ["speciesId" => $this->speciesId->getBytes(), "speciesCode" => $this->speciesCode, "speciesComName" => $this->speciesComName, "speciesSciName" => $this->speciesSciName, "speciesPhotoUrl" => $this->speciesPhotoUrl];

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
