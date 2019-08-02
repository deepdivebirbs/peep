<?php
namespace Birbs\Peep;

use http\Exception\InvalidArgumentException;

require_once("autoload.php");
require_once(dirname(__DIR__) . "vendor/autoload.php");

use Ramsey\Uuid\Uuid;


class favoriteBirdList implements \JsonSerializable {
	use ValidateUuid;
	/**
	 *this is the species code of the bird that the user is adding to their favorites; this is a foreign key
	 */
	private $birdFavoriteSpeciesCode;
	/**
	 * this is taken from the user id of the user that is adding the bird to their favorites; this is a foreign key
	 */
	private $birdFavoriteUserId;

	/**
	 * constructor for this favorite bird list
	 *
	 * @param string $newBirdFavoriteSpeciesCode id of the bird species that the user is saving
	 * @param string $newBirdFavoriteUserId id of the user who is saving this bird
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception f some other exception occurs
	 */

	public function __construct($newBirdFavoriteSpeciesCode, $newBirdFavoriteUserId) {
	try {
		$this->setnewBirdFavoriteSpeciesCode($newBirdFavoriteSpeciesCode);
		$this->birdFavoriteUserId($newBirdFavoriteUserId);
	}
		//this is the part where we determine what exception type is thrown, if any
	catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception)  {
			$exceptionType = get_class($exception);
			throw (new $exceptionType ($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for BirdFavoriteSpeciesCode
	 * @return string value for BirdFavoriteSpeciesCode
	 */
	public function getBirdFavoriteSpeciesCode(): string {
		return($this->getBirdFavoriteSpeciesCode());
	}

	/**
	 * mutator method for BirdFavoriteSpeciesCode
	 * @param string $newBirdFavoriteSpeciesCode
	 * @throws \InvalidArgumentException if $newFavoriteBirdSpeciesCode is empty or insecure
	 * @throws \RangeException if $newBirdFavoriteSpeciesCode is not 6 characters
	 * @throws \TypeError if $newBirdFavoriteSpeciesCode is not a string
	 */

	public function setBirdFavoriteSpeciesCode(string $newBirdFavoriteSpeciesCode ): void {
		//verify that the BirdFavoriteSpeciesCode is secure
		$newBirdFavoriteSpeciesCode=trim($newBirdFavoriteSpeciesCode);
		$newBirdFavoriteSpeciesCode=filter_var($newBirdFavoriteSpeciesCode, FILTER_SANITIZE_STRING);
		if(empty($newBirdFavoriteSpeciesCode)===true) {
			throw(new\InvalidArgumentException("Bird Favorite Species code is empty or insecure"));
		}
		if(strlen($newBirdFavoriteSpeciesCode)!==6) {
		throw (new\InvalidArgumentException("species id is not 6 characters"));
		}
		//store the username
		$this->$newBirdFavoriteSpeciesCode;
	}

	/**
	 * accessormethod for birdFavoriteUserId
	 * @return string Uuid value of BirdFavoriteUserId
	 */
	public function getBirdFavoriteUserId():Uuid {
		return ($this->birdFavoriteUserId);
	}
	/**
	 * mutator method for birdFavoriteUserId
	 * @param Uuid|string $newBirdFavoriteUserId
	 * $throws \TypeError if $newBirdFavoriteUserId is not a Uuid or string
	 */
	public function setNewBirdFavoriteUserId ($newBirdFavoriteUserId): void {
	try {
			$uuid = self::validateUuid($newBirdFavoriteUserId);
		} catch (\invalidArgumentException |\RangeException|\Exception|\TypeError $exception){
			$exceptionType=get_class($exception);
		throw(new$exceptionType($exception->getMessage(),0,$exception));
		}

	}
}