<?php
namespace Birbs\Peep;

/**
 * This table is an example of data collected and stored
 * about an author for the purpose of categorizing them
 */

require_once "autoload.php";
require_once(dirname(__DIR__,1)."/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
class favorite implements \JsonSerializable {
	// TODO JsonSerializable not implemented, needed to figure out how to do so for UUID stringification or can I remove?
	use ValidateUuid;
	/**
	 *this is the species code of the bird that the user is adding to their favorites; this is a foreign key
	 */
	private $favoriteSpeciesId;
	/**
	 * this is taken from the user id of the user that is adding the bird to their favorites; this is a foreign key
	 */
	private $favoriteUserId;

	/**
	 * constructor for this favorite class
	 *
	 * @param string $newFavoriteSpeciesId id of the bird species that the user is saving (foreign key)
	 * @param string $newFavoriteUserId id of the user who is saving this bird (foreign key)
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */

	public function __construct($newFavoriteSpeciesId, $newFavoriteUserId) {
	try {
		$this->setNewFavoriteSpeciesId($newFavoriteSpeciesId);
		$this->setNewFavoriteUserId($newFavoriteUserId);
	}
		//this is the part where we determine what exception type is thrown, if any
	catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception)  {
			$exceptionType = get_class($exception);
			throw (new $exceptionType ($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for FavoriteSpeciesId
	 * @return string value for FavoriteSpeciesId
	 */
	public function getFavoriteSpeciesId(): string {
		return($this->getFavoriteSpeciesId());
	}

	/**
	 * mutator method for FavoriteSpeciesId
	 * @param string $newFavoriteSpeciesId
	 * @throws \InvalidArgumentException if $newFavoriteBirdSpeciesId is empty or insecure
	 * @throws \RangeException if $newFavoriteSpeciesId is not 6 characters
	 * @throws \TypeError if $newFavoriteSpeciesId is not a string
	 */

	public function setNewFavoriteSpeciesId ($newFavoriteSpeciesId): void {
		try {
			$uuid = self::validateUuid($newFavoriteSpeciesId);
		} catch(\invalidArgumentException |\RangeException|\Exception|\TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new$exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->favoriteSpeciesIds = $uuid;
	}

	/**
	 * accessor method for favoriteUserId
	 * @return string Uuid value of FavoriteUserId
	 */
	public function getFavoriteUserId():Uuid {
		return ($this->favoriteUserId);
	}
	/**
	 * mutator method for favoriteUserId
	 * @param Uuid|string $newFavoriteUserId
	 * $throws \TypeError if $newFavoriteUserId is not a Uuid or string
	 */
	public function setNewFavoriteUserId ($newFavoriteUserId): void {
	try {
			$uuid = self::validateUuid($newFavoriteUserId);
		} catch (\invalidArgumentException |\RangeException|\Exception|\TypeError $exception){
			$exceptionType=get_class($exception);
		throw(new$exceptionType($exception->getMessage(),0,$exception));
		}
		$this->favoriteUserId=$uuid;
	}
	/*
	 * inserts this favorite bird into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOexception when mySQL related errors occur
	 * @throwsTypeError if $pdo is not a PDO connection object
	 */
	public function insert (\PDO $pdo) : void {
		//template for query
		$query = "INSERT INTO favorite(favoriteSpeciesId, favoriteUserId) 
		VALUES (:favoriteSpeciesId, :FavoriteUserId )";
		$statement = $pdo->prepare($query);

		//binds member variables to the placeholders in the template. getbytes converts string into bytes
		$parameters= [ "favoriteSpeciesId"=>$this->favoriteSpeciesId->getBytes(),
			"favoriteUserId"=>$this->favoriteUserId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * deletes favorite bird from mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete (\PDO $pdo) : void {
		//create query template
		$query = "DELETE FROM favorite WHERE favoriteUserId=:favoriteSpeciesId";
		$statement = $pdo->prepare($query);
		//binds the member variables to the placeholder in the template
		$parameters = ["favoriteBirdList"=>$this->getBytes()];
		$statement->execute($parameters);
	}

	public static function getAllFavoritebyUserId (\PDO $pdo, $favoriteUserId): ?favorite{
		//create query template
		$query = "SELECT favoriteSpeciesId, favoriteUserId FROM favoriteBirdList WHERE favoriteUserId =:favoriteUserId";
		$statement=$pdo->prepare($query);
		// bind the favoriteUserId to the place holder in the template
		$parameters = ["favoriteUserid" => $favoriteUserId ->getBytes ()];
		$statement ->execute($parameters);
		//build an array of favorites
		$favoriteBirdList = new \SplFixedArray($statement->rowCount());
		$statement ->setFetchMode(\PDO::FETCH_ASSOC);
		while (($row=$statement->fetch())!==false) {
			try {
				$favorite = new favorite($row ["favoriteSpeciesId"], $row["favoriteUserId"]);
			} catch (\Exception $exception) {
				throw (new \PDOException($exception->getMessage(),$exception));
			}
		}
		return($favorite);
	}

	public function jsonSerialize() : array {
	$fields =get_object_vars ($this);

	$fields ["favoriteUserId"] = $this->favoriteUserId->toString();
	}
}
