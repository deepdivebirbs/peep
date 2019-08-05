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

class BirdSighting {
	use ValidateUuid;
	use ValidateDate;
	/**
	 * id for this sighting
	 * @var Uuid $sightingId
	 **/
	private $sightingId;
	/**
	 * id for the user who is submitting this sighting; pk
	 * @var Uuid $birdSightingUserProfileId
	 **/
	private $birdSightingUserProfileId;
	/**
	 * id for the bird species table; fk
	 * @var string $birdSightingSpeciesCode
	 **/
	private $birdSightingSpeciesCode;
	/**
	 * this is the common name entry for every bird; fk
	 * @var string $commonName
	 */
	private $commonName;
	/**
	 * this is the scientific name for every bird
	 * @var string $sciName
	 */
	private $sciName;
	/**
	 * this is the latitude for the location data of a bird sighting
	 * @var float $latitudeX
	 */
	private $latitudeX;
	/**
	 * this is the longitude for the location data of a bird sighting
	 * @var float $longitudeY
	 */
	private $longitudeY;
	/**
	 * this is the date and time of a bird sighting
	 * @var \DateTime $dateTime
	 */
	private $dateTime;
	/**
	 * this is the photo of the bird uploaded with the bird sighting
	 * @var string $birdPhoto
	 **/
	private $birdPhoto;

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

	/** accessor method for BirdSighting user profile ID
	 * @return Uuid value of the BirdSighting user profile ID
	 **/
	public function getBirdSightingUserProfileId(): Uuid {
		return $this->birdSightingUserProfileId;
	}

	/**
	 *mutator method for BirdSighting user profile ID
	 *
	 * @param Uuid| string $newBirdSightingUserId
	 * @throws \RangeException if the $newBirdSightingUserId is not positive
	 * @throws \TypeError if the profile ID is not
	 */
	public function setBirdSightingUserProfileId(Uuid $birdSightingUserProfileId): void {
		try {
			$Uuid = self::validateUuid($newBirdSightingUserProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->birdSightingUserProfileId = $newBirdSightingUserProfileId
	}

/**
 * accessor method for the BirdSighting species code
 * @return string of birdsighting bird species code
 **/
	public function getBirdSightingSpeciesCode(): string {
		return $this->birdSightingSpeciesCode;
	}

/**
 * mutator method for the BirdSighting species code
 *
 * @param string for $newBirdSightingSpeciesCode
 * @throws \InvalidArgumentException if not a string
 * @throws \RangeException if the bird species ID is shorter or longer than 6 chars
 * @throws \TypeError if the bird species ID is not a string
 **/
	public function setBirdSightingSpeciesCode(string $newBirdSightingSpeciesCode) {
		$newBirdSightingSpeciesCode = trim($newBirdSightingSpeciesCode);
		$newBirdSightingSpeciesCode = filter_var($newBirdSightingSpeciesCode, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newBirdSightingSpeciesCode) === true) {
			throw(new \InvalidArgumentException("Species Code is empty or insecure"));
		}
		if(strlen($newBirdSightingSpeciesCode) < 6 || strlen($newBirdSightingSpeciesCode) > 6) {
			throw(new \RangeException("Species Code must be exactly 6 characters"));
		}
		$this->birdSightingSpeciesCode = $newBirdSightingSpeciesCode;
	}

/**
 * accessor method for the common name
 * @return string of bird common name
 */
	public function getCommonName(): string {
		return $this->commonName;
	}

/**
 * mutator method for the common name
 *
 * @param string for $newCommonName
 * @throws \InvalidArgumentException if not a string
 * @throws \RangeException if the common name is longer than 64 chars
 * @throws \TypeError if the common name is not a string
 **/
	public function setCommonName(string $newCommonName) {
		$newCommonName = trim($newCommonName);
		$newCommonName = filter_var($newCommonName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCommonName) === true) {
			throw(new \InvalidArgumentException("Common Name is empty or insecure"));
		}
			if(strlen($newCommonName) > 64) {
				throw(new \RangeException("Common Name is too long"));
			}
			$this->commonName = $newCommonName;
		}

/** accessor for scientific name
 *
 * @return string for scientific name
 */
	public function getSciName(): string {
		return $this->sciName;
	}

/** mutator method for scientific name
 *
 * @param string for $newSciName
 * @throws \InvalidArgumentException if not a string
 * @throws \RangeException if the scientific name is longer than 64 chars
 * @throws \TypeError if the scientific name is not a string
 **/
	public function setSciName(string $newsciName) {
	$newsciName = trim($newsciName);
	$newsciName = filter_var($newsciName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newsciName) === true) {
		throw(new \InvalidArgumentException("Scientific name is empty or insecure"));
	}
	if(strlen($newsciName) > 64) {
		throw(new \RangeException("Scientific name is too long"));
	}
	$this->sciName = $newsciName;
	}

/**
 * accessor for latitudeX
 *
 * @return float for latitudeX
 **/
	public function getLatitudeX(): float {
		return $this->latitudeX;
	}

/**
 * mutator method for latitudeX
 *
 * @param float $latitudeX
 * @throws \InvalidArgumentException if latitudeX is not a float
 * @throws \RangeException if not to the thousandths decimal place
 * @throws \TypeError if latitudeX is not a float
 **/
	public function setLatitudeX(float $latitudeX) {
		//check if it's a float
		if(empty($latitudeX) === true) {
			throw(new \InvalidArgumentException("Location data is empty"));
		}
//waiting for if statement to check the thousandths decimal place to throw range exception
		if(is_float($latitudeX) !== true) {
			throw(new \TypeError("location data is not valid"));
		}
		$this->latitudeX = $latitudeX;
	}

/**
 * accessor for longitudeY
 *
 * @return float for longitudeY
 **/
	public function getLongitudeY(): float {
		return $this->longitudeY;
	}

/**
 * mutator method for longitudeY
 *
 * @param float $longitudeY
 * @throws \InvalidArgumentException if longitudeY is not a float
 * @throws \RangeException if not to the thousandths decimal place
 * @throws \TypeError if longitudeY is not a float
 **/
	public function setLongitudeY(float $longitudeY) {
		//check if it's a float
		if(empty($longitudeY) === true) {
			throw(new \InvalidArgumentException("Location data is empty"));
		}
//waiting for if statement to check the thousandths decimal place to throw range exception
		if(is_float($longitudeY) !== true) {
			throw(new \TypeError("location data is not valid"));
		}
		$this->latitudeX = $longitudeY;
	}

/**
 * accessor for dateTime
 *
 * @return \dateTime value for sighting date
 **/
	public function getDateTime(): \DateTime {
		return $this->dateTime;
	}
/**
 * mutator method for datetime
 *
 * @param \DateTime|string|null $newDateTime BirdSighting as a DateTime object or string (or null to load the current time)
 * @throws \InvalidArgumentException if $newDateTime is not a valid object or string
 * @throws \RangeException if $newDateTime is a date that does not exist
 **/
	/**
	 * @param datetime $dateTime
	 */
	public function setDateTime(datetime $dateTime): void {
		if($newDateTime === null) {
			$this->dateTime = new \DateTime();
			return;
		}
		try {
				$newDateTime = self::validateDateTime($newDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->dateTime = $dateTime;
	}

/**
 * accessor for birdPhoto
 *
 * @return string value of the bird photo url
 **/
	public function getBirdPhoto(): string {
		return $this->birdPhoto;
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
}
