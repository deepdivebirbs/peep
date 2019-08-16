<?php

namespace Birbs\Peep;

/**
 * This table is an example of data collected and stored
 * about an author for the purpose of categorizing them
 */

require_once "autoload.php";
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class Favorite implements \JsonSerializable {
	use ValidateUuid;

	/**
	 *this is the species code of the bird that the user is adding to their favorites; this is a foreign key
	 */
	private $favoriteSpeciesId;

	/**
	 * this is taken from the user id of the user that is adding the bird to their favorites; this is a foreign key
	 */
	private $favoriteUserProfileId;

	/**
	 * constructor for this favorite class
	 *
	 * @param string|Uuid $newFavoriteSpeciesId id of the bird species that the user is saving (foreign key)
	 * @param string|Uuid $newFavoriteUserProfileId id of the user who is saving this bird (foreign key)
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data is out of range
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct($newFavoriteSpeciesId, $newFavoriteUserProfileId) {
		try {
			$this->setNewFavoriteSpeciesId($newFavoriteSpeciesId);
			$this->setNewFavoriteUserProfileId($newFavoriteUserProfileId);
		} //this is the part where we determine what exception type is thrown, if any
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType ($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for FavoriteSpeciesId
	 * @return Uuid value for FavoriteSpeciesId
	 */
	public function getFavoriteSpeciesId(): Uuid {
		return ($this->favoriteSpeciesId);
	}

	/**
	 * accessor method for favoriteUserProfileId
	 * @return Uuid value of favoriteUserProfileId
	 */
	public function getFavoriteUserProfileId(): Uuid {
		return ($this->favoriteUserProfileId);
	}

	/**
	 * mutator method for FavoriteSpeciesId
	 * @param string|Uuid $newFavoriteSpeciesId
	 * @throws \InvalidArgumentException if $newFavoriteBirdSpeciesId is empty or insecure
	 * @throws \RangeException if $newFavoriteSpeciesId is out of range
	 * @throws \TypeError if $newFavoriteSpeciesId is not a Uuid
	 * @throws \Exception if there is another exception
	 */
	public function setNewFavoriteSpeciesId($newFavoriteSpeciesId): void {
		try {
			$uuid = self::validateUuid($newFavoriteSpeciesId);
		} catch(\invalidArgumentException |\RangeException|\Exception|\TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new$exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->favoriteSpeciesId = $uuid;
	}

	/**
	 * mutator method for favoriteUserProfileId
	 * @param Uuid|string $newFavoriteUserProfileId
	 * @throws \InvalidArgumentException if $newUserProfileId is empty or insecure
	 * @throws \RangeException if $newFavoriteUserProfileId is out of range
	 * @throws \TypeError if $newFavoriteUserProfileId is not a Uuid or string
	 * @throws \Exception if there is another exception
	 */
	public function setNewFavoriteUserProfileId($newFavoriteUserProfileId): void {
		try {
			$uuid = self::validateUuid($newFavoriteUserProfileId);
		} catch(\invalidArgumentException |\RangeException|\Exception|\TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new$exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->favoriteUserProfileId = $uuid;
	}

	/*
	 * inserts this favorite bird into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo): void {
		//template for query
		$query = "INSERT INTO favorite(favoriteSpeciesId, favoriteUserProfileId) 
		VALUES (:favoriteSpeciesId, :favoriteUserProfileId )";
		$statement = $pdo->prepare($query);

		//binds member variables to the placeholders in the template. getbytes converts string into bytes
		$parameters = ["favoriteSpeciesId" => $this->favoriteSpeciesId->getBytes(),
			"favoriteUserProfileId" => $this->favoriteUserProfileId->getBytes()]

		;
		$statement->execute($parameters);
	}

	/**
	 * deletes favorite bird from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {

		//create query template
		$query = "DELETE FROM favorite WHERE favoriteUserProfileId = :favoriteUserProfileId AND favoriteSpeciesId = :favoriteSpeciesId";
		$statement = $pdo->prepare($query);

		//binds the member variables to the placeholder in the template
		$parameters = ["favoriteUserProfileId" => $this->favoriteUserProfileId -> getBytes(), "favoriteSpeciesId" =>
			$this->favoriteSpeciesId->getBytes()];
		$statement->execute($parameters);
	}

	/**gets a favorite bird by userProfileId and favoriteSpeciesId
	 * @param \PDO $pdo pdo connection object
	 * @param string $favoriteUserProfileId profile id to search for
	 * @param string $favoriteSpeciesId species id to search for
	 * @return Favorite|null favorite found or null if not found
	 **/

	public static function getFavoritebyFavoriteUserProfileIdAndFavoriteSpeciesId (\PDO $pdo, string $favoriteUserProfileId, string $favoriteSpeciesId) : ?Favorite {
		try {
			$favoriteUserProfileId= self::validateUuid($favoriteUserProfileId);
		} catch (\InvalidArgumentException |\RangeException |\Exception |\TypeError $exception) {
			throw (new \PDOException($exception->getMessage(),0, $exception));
		}

		try {
			$favoriteSpeciesId= self::validateUuid($favoriteSpeciesId);
		} catch (\InvalidArgumentException |\RangeException |\Exception |\TypeError $exception) {
			throw (new \PDOException($exception->getMessage(),0, $exception));
		}

		//create query template
		$query = "SELECT favoriteUserProfileId, favoriteSpeciesId FROM favorite WHERE favoriteUserProfileId = :favoriteUserProfileId AND favoriteSpeciesId= :favoriteSpeciesID";
		$statement = $pdo->prepare($query);

		// bind the userProfileId and the speciesId to their placeholder in the template
		$parameters = ["favoriteUserProfileId"=>$favoriteUserProfileId->getBytes(), "favoriteSpeciesId"=> $favoriteSpeciesId->getBytes()];
		$statement->execute($parameters);

		//grab the favorite from mySQL
		try {
			$favorite = null;
			$statement ->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if ($row !==false) {
				$favorite = new Favorite($row["favoriteUserProfileId"], $row["favoriteSpeciesId"]);
			}
		}catch (\Exception $exception){
			//if the row couldn't be converted, rethrow it
			throw (new \PDOException($exception->getMessage(),0,$exception));
		}
		return ($favorite);
	}



	/**
	 * gets all of a user's favorite birds by userProfileId
	 * @param \PDO $pdo pdo connection object
	 * @param $favoriteUserProfileId
	 * @return favorite bird list
	 */
	public static function getAllFavoriteByUserProfileId(\PDO $pdo, string $favoriteUserProfileId): \SplFixedArray {
		try {
			$favoriteUserProfileId = self::validateUuid($favoriteUserProfileId);
		} catch (\InvalidArgumentException |\ RangeException |\Exception |\TypeError $exception) {
			throw (new \PDOException($exception->getMessage(),0, $exception));
		}
		//create query template
		$query = "SELECT favoriteSpeciesId, favoriteUserProfileId FROM favorite WHERE favoriteUserProfileId = :favoriteUserProfileId";
		$statement = $pdo->prepare($query);

		// bind the favoriteUserProfileId to the place holder in the template
		$parameters = ["favoriteUserProfileId" => $favoriteUserProfileId->getBytes()];
		$statement->execute($parameters);

		//build an array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row ["favoriteSpeciesId"], $row["favoriteUserProfileId"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();

				echo gettype ($favorites);
			} catch(\Exception $exception) {
				//if row couldn't be converted, rethrow it
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($favorites);
	}

	/**
	 * jsonSerialize converts uuids to string
	 */
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields ["favoriteUserProfileId"] = $this->favoriteUserProfileId->toString();
		$fields ["favoriteSpeciesId"] = $this->favoriteSpeciesId->toString();

		return ($fields);
	}
}
