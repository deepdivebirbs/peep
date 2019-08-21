<?php


namespace Birbs\Peep;
require_once("autoload.php");
require_once(dirname(__DIR__,1) . "/vendor/autoload.php");

use http\Exception\BadConversionException;
use Ramsey\Uuid\Uuid;

//TODO add dockblock for class
class UserProfile implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * @var $userProfileId , the primary key and index
	 * @var $userProfileAuthenticationToken , needed for security purposes
	 * @var $userProfileEmail , other information stored about the user
	 * @var $userProfileFirstName , other information stored about the the user
	 * @var $userProfileHash , needed for security purposes
	 * @var $userProfileLastName , other information stored about the the user
	 * @var $userProfileName , a unique identifier, but not the key
	 */
	private $userProfileId;
	private $userProfileAuthenticationToken;
	private $userProfileEmail;
	private $userProfileFirstName;
	private $userProfileHash;
	private $userProfileLastName;
	private $userProfileName;

	/**
	 * Constructor method for User object
	 *
	 * @param string|Uuid newUserProfileId,
	 * @param string newUserName,
	 * @param string newFirstName,
	 * @param string newLastName,
	 * @param string newUserEmail,
	 * @param string newUserAuthenticationToken,
	 * @param string newUserHash
	 *
	 * @throws \InvalidArgumentException if one of the inputs is marked as invalid by the setter it was passed to
	 * @throws \RangeException if a setter finds one
	 * @throws \TypeError if the input type is wrong
	 * @throws \Exception if an exeption turns up.
	 */
	public function __construct($newUserProfileId, string $newUserProfileName, string $newUserProfileFirstName, string $newUserProfileLastName, string $newUserProfileEmail, string $newUserProfileAuthenticationToken, string $newUserProfileHash) {
		try {
			$this->setUserProfileId($newUserProfileId);
			$this->setUserProfileName($newUserProfileName);
			$this->setUserProfileFirstName($newUserProfileFirstName);
			$this->setUserProfileLastName($newUserProfileLastName);
			$this->setUserProfileEmail($newUserProfileEmail);
			$this->setUserProfileAuthenticationToken($newUserProfileAuthenticationToken);
			$this->setUserProfileHash($newUserProfileHash);
		} //The following determines what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for userProfileId
	 * @return Uuid value of userProfileId - should fit in Binary.
	 */
	public function getUserProfileId(): Uuid {
		return ($this->userProfileId);
	}

	/**
	 * Accessor method for userProfileAuthenticationToken.
	 *
	 * @return string userProfileAuthenticationToken
	 */
	public function getUserProfileAuthenticationToken(): ?string {
		return ($this->userProfileAuthenticationToken);
	}

	/**
	 * accessor method for userProfileEmail
	 * @return string userProfileEmail - should fit in varChar(128)
	 */
	public function getUserProfileEmail(): string {
		return ($this->userProfileEmail);
	}

	/**
	 * accessor method for userProfileFirstName
	 * @return  string userProfileFirstName - should fit in varChar(32)
	 */
	public function getUserProfileFirstName(): string {
		return ($this->userProfileFirstName);
	}

	/**
	 * Accessor method for userProfileHash.
	 *
	 * @return string userProfileHash
	 */
	public function getUserProfileHash(): string {
		return ($this->userProfileHash);
	}

	/**
	 * accessor method for userProfileLastName
	 * @return string userProfileLastName - should fit in varChar(32).
	 */
	public function getUserProfileLastName(): string {
		return ($this->userProfileLastName);
	}

	/**
	 * accessor method for userProfileName
	 * @return string userProfileName - should fit in varchar(32).
	 */
	public function getUserProfileName(): string {
		return ($this->userProfileName);
	}


	/**
	 * Mutator method for userProfileId
	 *
	 * @param string|Uuid $newUserProfileId new value of userProfileId
	 * @throws \InvalidArgumentException if $newUserProfileId is not an Int. (Should fit into a binary)
	 * @throws \RangeException
	 * @throws \Exception
	 * @throws \TypeError
	 */
	public function setUserProfileId(string $newUserProfileId): void {
		try {
			$uuid = self::validateUuid($newUserProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->userProfileId = $uuid; //Once input is converted, userProfileId is set here.
	}

	/**
	 * Mutator method for userProfileAuthenticationToken. Needs additional sanitizing
	 *
	 * @param string newUserAuthorizationToken new value of userProfileAuthenticationToken
	 * @throws \InvalidArgumentException if $newUserAuthorizationToken is empty or insecure
	 * @throws \RangeException if sanitized input is the wrong length or contains invalid characters
	 */
	public function setUserProfileAuthenticationToken(string $newUserProfileAuthenticationToken): void {
		$newUserProfileAuthenticationToken = strtolower(trim($newUserProfileAuthenticationToken));
		$newUserProfileAuthenticationToken = filter_var($newUserProfileAuthenticationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserProfileAuthenticationToken) === true) {
			throw(new \InvalidArgumentException("input is empty"));
		}
		if(ctype_xdigit($newUserProfileAuthenticationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		if(strlen($newUserProfileAuthenticationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32 characters."));
		}
		$this->userProfileAuthenticationToken = $newUserProfileAuthenticationToken;
	}

	/**
	 * Mutator method for userProfileEmail. Needs additional sanitizing
	 *
	 * @param string newUserEmail new value of UserEmail
	 * @throws \InvalidArgumentException if input is empty or insecure
	 * @throws \RangeException if input is too long
	 */
	public function setUserProfileEmail(string $newUserProfileEmail): void {
		$newUserProfileEmail = trim($newUserProfileEmail);
		$newUserProfileEmail = filter_var($newUserProfileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserProfileEmail) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		if(strlen($newUserProfileEmail) > 128) {
			throw(new \RangeException("This email is too long."));
		}
		$this->userProfileEmail = $newUserProfileEmail;
	}

	/**
	 * Mutator method for userProfileFirstName. Needs additional sanitizing
	 *
	 * @param string newFirstName new value of FirstName
	 * @throws \InvalidArgumentException if input is empty or insecure
	 * @throws \RangeException if input is too long
	 */
	public function setUserProfileFirstName(string $newUserProfileFirstName): void {
		$newUserProfileFirstName = trim($newUserProfileFirstName);
		$newUserProfileFirstName = filter_var($newUserProfileFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserProfileFirstName) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		if(strlen($newUserProfileFirstName) > 32) {
			throw(new \RangeException("Unfortunately, this is too long to store."));
		}
		$this->userProfileFirstName = $newUserProfileFirstName;
	}

	/**
	 * Mutator method for userProfileHash. Needs additional sanitizing
	 * TODO Improve hashing and unhashing
	 * @param string newUserHash new value of userProfileHash
	 * @throws \InvalidArgumentException if newUserHash is empty or insecure
	 */
	public function setUserProfileHash(string $newUserProfileHash): void {
		$newUserProfileHash = trim($newUserProfileHash);
		$newUserProfileHash = filter_var($newUserProfileHash, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserProfileHash) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->userProfileHash = $newUserProfileHash;
	}

	/**
	 * Mutator method for userProfileLastName. Needs additional sanitizing
	 *
	 * @param string newLastName new value of userProfileLastName
	 * @throws \InvalidArgumentException if input is empty or insecure
	 * @throws \RangeException if input is too long
	 */
	public function setUserProfileLastName(string $newUserProfileLastName): void {
		$newUserProfileLastName = trim($newUserProfileLastName);
		$newUserProfileLastName = filter_var($newUserProfileLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserProfileLastName) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		if(strlen($newUserProfileLastName) > 32) {
			throw(new \RangeException("Unfortunately, this is too long to store."));
		}
		$this->userProfileLastName = $newUserProfileLastName;
	}

	/**
	 * Mutator method for userProfileName. Needs additional sanitizing
	 *
	 * @param string newUserName new value of UserName
	 * @throws \InvalidArgumentException if input is empty or insecure
	 * @throws \RangeException if input is too long
	 */
	public function setUserProfileName(string $newUserProfileName): void {
		$newUserProfileName = trim($newUserProfileName);
		$newUserProfileName = filter_var($newUserProfileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserProfileName) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		if(strlen($newUserProfileName) > 32) {
			throw(new \RangeException("Unfortunately, this is too long to store."));
		}
		$this->userProfileName = $newUserProfileName;
	}



	/**
	 * inserts a userProfile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO userProfile(userProfileId, userProfileName, userProfileFirstName, userProfileLastName, userProfileEmail, userProfileAuthenticationToken, userProfileHash) VALUES(:userProfileId, :userProfileName, :userProfileFirstName, :userProfileLastName, :userProfileEmail, :userProfileAuthenticationToken, :userProfileHash)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		//$formattedDate = $this->tweetDate->format("Y-m-d H:i:s.u");
		$parameters = ["userProfileId" => $this->userProfileId->getBytes(), "userProfileName" => $this->userProfileName->getBytes(), "userProfileFirstName" => $this->userProfileFirstName, "userProfileLastName" => $this->userProfileLastName, "userProfileEmail" => $this->userProfileEmail, "userProfileAuthenticationToken" => $this->userProfileAuthenticationToken, "userProfileHash" => $this->userProfileHash];
		$statement->execute($parameters);
	}


	/**
	 * updates this UserProfile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE userProfile SET userProfileId = :userProfileId, userProfileName = :userProfileName, userProfileFirstName = :userProfileFirstName, userProfileLastName = :userProfileLastName, userProfileEmail = :userProfileEmail, userProfileAuthenticationToken = :userProfileAuthenticationToken, userProfileHash = :userProfileHash WHERE userProfileId = :userProfileId";
		$statement = $pdo->prepare($query);

		$parameters = ["userProfileId" => $this->userProfileId->getBytes(), "userProfileName" => $this->userProfileName->getBytes(), "userProfileFirstName" => $this->userProfileFirstName, "userProfileLastName" => $this->userProfileLastName, "userProfileEmail" => $this->userProfileEmail, "userProfileAuthenticationToken" => $this->userProfileAuthenticationToken, "userProfileHash" => $this->userProfileHash];
		$statement->execute($parameters);
	}

	/**
	 * deletes this userProfile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM userProfile WHERE userProfileId = :userProfileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["userProfileId" => $this->userProfileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * Takes an ID and pdo object, and returns the profile from the pdo that matches it.
	 *
	 * @param \PDO $pdo
	 * @param string $userId
	 * @return UserProfile|null
	 */
	public function getUserProfileById(\PDO $pdo , string $userId ): ?userProfile{
		// sanitize the userId before searching
		try {
			$userId = self::validateUuid($userId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT userProfileId, userProfileName, userProfileFirstName, userProfileLastName, userProfileEmail, userProfileAuthenticationToken, userProfileHash FROM userProfile WHERE userProfileId = :userId";
		$pdoStatement = $pdo->prepare($query);

		// bind the user id to the place holder in the template
		$parameters = ["userProfileId" => $userProfileId->getBytes()];
		$pdoStatement->execute($parameters);

		// grab the statement from mySQL
		try {
			$user = null;
			$pdoStatement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $pdoStatement->fetch();
			if($row !== false) {
				$user = new userProfile($row["userProfileId"], $row["userProfileName"], $row["userProfileFirstName"], $row["userProfileLastName"], $row["userProfileEmail"], $row["userProfileAuthenticationToken"], $row["userProfileHash"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($user);
	}

	public function getUserProfileByName(\PDO $pdo , string $userProfileName ): ?userProfile{
		// sanitize the userName before searching
		try {
			$userProfileName = self::validateUuid($userProfileName);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT userProfileId, userProfileName, userProfileFirstName, userProfileLastName, userProfileEmail, userProfileAuthenticationToken, userProfileHash FROM userProfile WHERE userProfileName = :userProfileName";
		$pdoStatement = $pdo->prepare($query);

		// bind the user id to the place holder in the template
		$parameters = ["userProfileName" => $userProfileName->getBytes()];
		$pdoStatement->execute($parameters);

		// grab the statement from mySQL
		try {
			$user = null;
			$pdoStatement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $pdoStatement->fetch();
			if($row !== false) {
				$user = new userProfile($row["userProfileId"], $row["userProfileName"], $row["userProfileFirstName"], $row["userProfileLastName"], $row["userProfileEmail"], $row["userProfileAuthenticationToken"], $row["userProfileHash"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($user);
	}


	/**
	 * formats the state variables for JSON serialization. Might need changing.
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["userProfileId"] = $this->userProfileId->toString();
		//$fields["userProfileAuthenticationToken"] = $this->userProfileAuthenticationToken->toString();
		$fields["userProfileEmail"] = $this->userProfileEmail->toString();
		$fields["userProfileFirstName"] = $this->userProfileFirstName->toString();
		//$fields["userProfileHash"] = $this->userProfileHash->toString();
		$fields["userProfileLastName"] = $this->userProfileLastName->toString();
		$fields["userProfileName"] = $this->userProfileName->toString();

		return($fields);
	}

}