<?php

namespace Birbs\Peep

require_once("autoload.php")
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use http\Exception\BadQueryStringException;use http\Params;
use Ramsey\Uuid\Uuid;
/**
 * This is the birdSighting class. It will handle user-submitted bird sightings to the correct table.
@author Ruth E. Dove <senoritaruth@gmail.com>
@version 1.0
 **/

class birdSighting {
	use ValidateUuid;
	/**
	 * id for this sighting
	 * @var Uuid $sightingId
	 **/
	private $sightingId;
	/**
	 * id for the user who is submitting this sighting; fk
	 * @var  binary $birdSightingUserId
	 **/
	private $birdSightingUserId;
	/**
	 * id for the bird species table; fk
	 * @var string $birdSightingBirdSpeciesId
	 **/
	private $birdSightingBirdSpeciesId;
	/**
	 * this is the common name entry for every bird
	 * @var varchar $commonName
	 */
	private $commonName;
	/**
	 * this is the scientific name for every bird
	 * @var varchar $scientificName
	 */
	private $scientificName;
	/**
	 * this is the latitude for the location data of a bird sighting
	 * @var float $latitude
	 */
	private $latitude;
	/**
	 * this is the longitude for the location data of a bird sighting
	 * @var float $longitude
	 */
	private $longitude;
	/**
	 * this is the date and time of a bird sighting
	 * @var datetime $dateTime
	 */
	private $dateTime;
	/**
	 * this is the photo of the bird uploaded with the bird sighting
	 * @var varchar $birdPhoto
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
			$Uuid = self::validateUuid($newsightingId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the sighting ID
		$this->sightingId = $Uuid;
	}

	/** accessor method for birdsighting user ID
	 * @return Uuid value of the birdsighting user ID
	 **/
	public function getBirdSightingUserId(): binary {
		return $this->birdSightingUserId;
	}

	/**
	 *mutator method for birdsighting bird species user ID
	 *
	 * @param Uuid| string $newbirdSightingUserId
	 * @throws \RangeException if the $newbirdSightingUserId is not positive
	 * @throws \TypeError if the profile ID is not
	 */
	public function setBirdSightingUserId(binary $birdSightingUserId): void {
		try {
			$Uuid = self::validateUuid($newbirdsightingUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

/**
 * accessor method for the birdsighting bird species ID
 * @return string of birdsighting bird species ID
 **/
	public function getBirdSightingBirdSpeciesId(): void {
		return $this->birdSightingBirdSpeciesId;
	}

/**
 * mutator method for the birdsighting bird species ID
 *
 * @param string for $newbirdsightingBirdSpeciesId
 * @throws \InvalidArgumentException if not a string
 * @throws \RangeException if the bird species ID is shorter or longer than 6 chars
 * @throws \TypeError if the bird species ID is not a string
 **/

	public function setBirdSightingBirdSpeciesId( $birdSightingBirdSpeciesId) {
		$this->birdSightingBirdSpeciesId = $birdSightingBirdSpeciesId;
	}
}