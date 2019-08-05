<?php

namespace Birbs\Peep;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use http\Exception\BadQueryStringException; use http\Params;
use Ramsey\Uuid\Uuid;
/**
 * This is the BirdSighting class. It will handle user-submitted bird sightings to the correct table.
@author Ruth E. Dove <senoritaruth@gmail.com>
@version 1.0
 **/

class sighting {
	use ValidateUuid;
	use ValidateDate;

/**
 * id for this sighting
 * @var Uuid $sightingId
 **/
	private $sightingId;
/**
 * id for the user who is submitting this sighting; pk
 * @var Uuid $sightingUserProfileId
 **/
	private $sightingUserProfileId;
/**
 * id for the bird species table; fk
 * @var Uuid $sightingSpeciesId
 **/
	private $sightingSpeciesId;
/**
 * @var string $sightingSpeciescode; 	 *
 */
	private $sightingComName;
/**
 * this is the scientific name for every bird
 * @var string $sightingSciName
 **/
	private $sightingSciName;
/**
 * this is the latitude for the location data of a bird sighting
 * @var float $sightingLatitudeX
 **/
	private $sightingLocX;
/**
 * this is the longitude for the location data of a bird sighting
 * @var float $sightingLongitudeY
 */
	private $sightingLocY;
/**
 * this is the date and time of a bird sighting
 * @var \DateTime $sightingDateTime
 */
	private $sightingDateTime;
/**
 * this is the photo of the bird uploaded with the bird sighting
 * @var string $sightingBirdPhoto
 **/
	private $sightingBirdPhoto;

/**
 * constructor for this sighting
 *
 * @param string|Uuid $sightingId of this sighting or null if a new sighting
 * @param string|Uuid $sightingUserProfileId of the Profile that posted this sighting
 * @param string|Uuid $sightingSpeciesId
 * @param string $sightingComName
 * @param string $sightingSciName
 * @param float $sightingLatitudeX
 * @param float $sightingLongitudeY
 * @param \DateTime|string|null $sightingDateTime date and time sighting was sent or null if set to current date and time
 * @param string $sightingBirdPhoto
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
 * @throws \TypeError if data types violate type hints
 * @throws \Exception if some other exception occurs
 * @Documentation https://php.net/manual/en/language.oop5.decon.php
 **/
	public function __construct($newSightingId, $newSightingUserProfileId, $newSightingSpeciesId, string $newSightingSpeciesCode, string $sightingComName, string $sightingSciName, float $newSightingLatitudeX, float $newSightingLongitudeY, $newSightingDateTime = null, string $newSightingBirdPhoto) {
		try {
			$this->setSightingId($newSightingId);
			$this->setSightingUserProfileId($newSightingUserProfileId);
			$this->setSightingSpeciesId($newSightingSpeciesId);
			$this->setSightingComName($newSightingComName);
			$this->setSightingSciName($newSightingSciName);
			$this->setSightingLocX($newSightingLatitudeX);
			$this->setSightingLocY($newSightingLongitudeY);
			$this->setSightingDateTime($newSightingDateTime);
			$this->setSightingBirdPhoto($newSightingBirdPhoto);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

/**
 * accessor method for sightingId
 * @return Uuid value of sighting ID (or null if new)
 **/
	public function getSightingId(): Uuid {
		return ($this->sightingId);
	}

/**
 * mutator method for sighting ID
 * @param Uuid| string $sightingId value of sighting ID
 * @throws \RangeException if $sightingId is no positive
 * @throws \TypeError if the sighting ID is not
 **/
	public function setSightingId(Uuid $sightingId): void {
			try {
				$Uuid = self::validateUuid($newSightingId);
			} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
			//convert and store the sighting ID
			$this->sightingId = $Uuid;
	}

/** accessor method for Sighting user profile ID
 * @return Uuid value of the sighting user profile ID
 **/
	public function getSightingUserProfileId(): Uuid {
		return $this->sightingUserProfileId;
	}

/**
 *mutator method for sighting user profile ID
 *
 * @param Uuid| string $newSightingUserId
 * @throws \RangeException if the $newSightingUserId is not positive
 * @throws \TypeError if the profile ID is not
 */
	public function setSightingUserProfileId(Uuid $birdSightingUserProfileId): void {
		try {
			$Uuid = self::validateUuid($newSightingUserProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->sightingUserProfileId = $newSightingUserProfileId;
	}

/**
 * accessor method for the sighting species Id
 * @return Uuid sighting species Id
 */
	public function getSightingSpeciesId(): Uuid {
		return $this->sightingSpeciesId;
	}

	/**
	 *mutator method for sighting species ID
	 *
	 * @param Uuid| string $newSightingSpeciesId
	 * @throws \RangeException if the $newSightingSpeciesId is not positive
	 * @throws \TypeError if the profile ID is not
	 */
	public function setSightingSpeciesId(Uuid $sightingSpeciesId): void {
		try {
			$Uuid = self::validateUuid($newSightingSpeciesId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->sightingSpeciesId = $newSightingSpeciesId;
	}

/**
 * accessor method for the common name
 * @return string of bird common name
 */
	public function getSightingComName(): string {
		return $this->sightingComName;
	}

/**
 * mutator method for the common name
 *
 * @param string for $newSightingComName
 * @throws \InvalidArgumentException if not a string
 * @throws \RangeException if the common name is longer than 64 chars
 * @throws \TypeError if the common name is not a string
 **/
	public function setSightingComName(string $newSightingComName) {
		$newSightingComName = trim($newSightingComName);
		$newSightingComName = filter_var($newSightingComName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newSightingComName) === true) {
			throw(new \InvalidArgumentException("Common Name is empty or insecure"));
		}
			if(strlen($newSightingComName) > 64) {
				throw(new \RangeException("Common Name is too long"));
			}
			$this->sightingComName = $newSightingComName;
		}

/** accessor for scientific name
 *
 * @return string for sighting sci name
 */
	public function getSightingSciName(): string {
		return $this->sightingSciName;
	}

/** mutator method for scientific name
 *
 * @param string for $newSightingSciName
 * @throws \InvalidArgumentException if not a string
 * @throws \RangeException if the scientific name is longer than 64 chars
 * @throws \TypeError if the scientific name is not a string
 **/
	public function setSightingSciName(string $newSightingSciName) {
	$newSightingSciName = trim($newSightingSciName);
	$newSightingSciName = filter_var($newSightingSciName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newSightingSciName) === true) {
		throw(new \InvalidArgumentException("Scientific name is empty or insecure"));
	}
	if(strlen($newSightingSciName) > 64) {
		throw(new \RangeException("Scientific name is too long"));
	}
	$this->sightingSciName = $newSightingSciName;
	}

/**
 * accessor for sighting LocX
 *
 * @return float for sightingLocX
 **/
	public function getSightingLocX(): float {
		return $this->sightingLocX;
	}

/**
 * mutator method for sighting LocX
 *
 * @param float $sightingLocX
 * @throws \InvalidArgumentException if sightingLocX is not a float
 * @throws \RangeException if not to the thousandths decimal place
 * @throws \TypeError if sightingLocX is not a float
 **/
	public function setSightingLocX(float $sightingLocX) {
		//check if it's a float
		if(empty($sightingLocX) === true) {
			throw(new \InvalidArgumentException("Location data is empty"));
		}
//waiting for if statement to check the thousandths decimal place to throw range exception
		if(is_float($sightingLocX) !== true) {
			throw(new \TypeError("location data is not valid"));
		}
		$this->sightingLocX = $sightingLocX;
	}

/**
 * accessor for sighting LocY
 *
 * @return float for sightingLocY
 **/
	public function getSightingLocY(): float {
		return $this->sightingLocY;
	}

/**
 * mutator method for sighting LocY
 *
 * @param float $sightingLocY
 * @throws \InvalidArgumentException if sightingLocY is not a float
 * @throws \RangeException if not to the thousandths decimal place
 * @throws \TypeError if sightingLocY is not a float
 **/
	public function setSightingLocY(float $sightingLocY) {
		//check if it's a float
		if(empty($sightingLocY) === true) {
			throw(new \InvalidArgumentException("Location data is empty"));
		}
//waiting for if statement to check the thousandths decimal place to throw range exception
		if(is_float($sightingLocY) !== true) {
			throw(new \TypeError("location data is not valid"));
		}
		$this->sightingLocY = $sightingLocY;
	}

/**
 * accessor for sighting dateTime
 *
 * @return \dateTime value for sighting date time
 **/
	public function getSightingDateTime(): \DateTime {
		return $this->sightingDateTime;
	}
/**
 * mutator method for sighting datetime
 *
 * @param \DateTime|string|null $newSightingDateTime Sighting as a DateTime object or string (or null to load the current time)
 * @throws \InvalidArgumentException if $newDateTime is not a valid object or string
 * @throws \RangeException if $newSightingDateTime is a date that does not exist
 **/
	public function setsightingDateTime(datetime $sightingDateTime): void {
		if($newSightingDateTime === null) {
			$this->sightingDateTime = new \DateTime();
			return;
		}
		try {
				$newSightingDateTime = self::validateDateTime($newSightingDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->sightingDateTime = $sightingDateTime;
	}

/**
 * accessor for sighting birdPhoto
 *
 * @return string value of the bird photo url
 **/
	public function getSightingBirdPhoto(): string {
		return $this->sightingBirdPhoto;
	}
/**
 * mutator method for the bird photo url
 *
 * @param string $birdPhoto new value of bird photo url
 * @throws \InvalidArgumentException if the url is not a string or is insecure
 * @throws \RangeException if the url is > 255 characters
 * @throws \TypeError if the url is not a string
 */
	public function setBirdPhoto(string $birdPhoto): void {
		$newBirdPhoto = trim($newBirdPhoto);
		$newBirdPhoto = filter_var($newBirdPhoto, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(strlen($newBirdPhoto) > 255) {
				throw(new \RangeException("image content is too large"));
		}
		$this->birdPhoto = $birdPhoto;
	}
	/**
	 * inserts this sighting into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO birdSighting(sightingId,birdSightingUserProfileId, birdSightingSpeciesCode, commonName, sciName, latitudeX, longitudeY, dateTime, birdPhoto) VALUES(:sightingId, :birdSightingUserProfileId, :birdSightingSpeciesCode, :commName, :sciName, :latitudeX, :longitudeY, :dateTime, :birdPhoto)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->dateTime->format("Y-m-d H:i:s.u");
		$parameters = ["sightingId" => $this->sightingId->getBytes(), "birdSightingUserProfileId" => $this->birdSightingUserProfileId->getBytes(), "birdSightingSpeciesCode" => $this->birdSightingSpeciesCode, "commonName" => $this->commonName, "sciName" => $this->sciName, "latitudeX" => $this->latitudeX, "longitudeY" => $this->longitudeY, "dateTime" => $this->dateTime, "birdPhoto" => $this->birdPhoto];
		$statement->execute($parameters);
	}

	/**
	 * deletes this sighting from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM birdSighting WHERE sightingId = :sightingId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["sightingId" => $this->sightingId->getBytes(), "birdSightingUserProfileId" => $this->birdSightingUserProfileId->getBytes(), "birdSightingSpeciesCode" => $this->birdSightingSpeciesCode, "commonName" => $this->commonName, "sciName" => $this->sciName, "latitudeX" => $this->latitudeX, "longitudeY" => $this->longitudeY, "dateTime" => $this->dateTime, "birdPhoto" => $this->birdPhoto];
		$statement->execute($parameters);
	}


	// this is the jsonserialize part of the class
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["sightingId"] = $this->sightingId->toString();
		$fields["birdSightingUserProfileId"] = $this->birdSightingUserProfileId->toString();



		//format the date so that the front end can consume it
		$fields["dateTime"] = round(floatval($this->dateTime->format("U.u")) * 1000);
		echo get_class($fields);
		return($fields);

	}
}
