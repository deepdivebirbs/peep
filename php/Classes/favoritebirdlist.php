<?php
namespace Birbs\Peep;

use http\Exception\InvalidArgumentException;

require_once("autoload.php");
require_once(dirname(__DIR__) . "vendor/autoload.php");

/**
 * mutators and getters for the favoritebirdlist class
 */

class FavoriteBirdList {
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
	public function getBirdFavoriteSpeciesCode() : Uuid {
		return($this->getBirdFavoriteSpeciesCode());
	}

	/**
	 * mutator method for BirdFavoriteSpeciesCode
	 * @param string $newBirdFavoriteSpeciesCode
	 * @throws \InvalidArgumentException if $newFavoriteBirdSpeciesCode is not a valid object or string
	 * @throws \LengthException if $newBirdFavoriteSpeciesCode is not 6 characters
	 *
	 */




}