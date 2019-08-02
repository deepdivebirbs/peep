<?php


namespace birbs\peep;
require_once("autoload.php");
use Ramsey\Uuid\Uuid;


class UserProfile {
	use ValidateUuid;

	/**
	 * @var $userId, the primary key and index
	 */
	private $userId;

	/**
	 * @var  $userName, a unique identifier, but not the key
	 */
	private $userName;
	/**
	 * @var $firstName, $lastName, $userEmail, other information stored by the user
	 */
	private $firstName;
	private $lastName;
	private $userEmail;
	/**
	 * @var $userAuthenticationToken, $userHash, needed for security purposes
	 */
	private $userAuthenticationToken;
	private $userHash;

	/**
	 * accessor method for userId
	 * @return $userId - should fit in Binary.
	 */
	public function getUserId() ?Uuid {
		return ($this->userId);
	}
	/**
	 * accessor method for userName
	 * @return $userName - should fit in varchar(32).
	 */
	public function getUserName() ?string {
		return ($this->userName);
	}
	/**
	 * accessor method for firstName
	 * @return $firstName - should fit in varChar(32)
	 */
	public function getFirstName() ?string {
		return ($this->firstName);
	}
	/**
	 * accessor method for lastName
	 * @return $lastName - should fit in varChar(32).
	 */
	public function getLastName() ?string {
		return ($this->lastName);
	}
	/**
	 * accessor method for userEmail
	 * @return $userEmail - should fit in varChar(128)
	 */
	public function getUserEmail() ?string {
		return ($this->userEmail);
	}
	/**
	 * Accessor method for userActivationToken.
	 *
	 * @return string userActivationToken
	 */
	public function getUserAuthenticationToken(): ?string {
		return ($this->userAuthenticationToken);
	}
	/**
	 * Accessor method for userHash.
	 *
	 * @return string userHash
	 */
	public function getUserHash(): ?string {
		return ($this->userHash);
	}

		/**
		 * Mutator method for userId
		 *
		 * @param int $newUserId new value of userId
		 * @throws UnexpectedValueException if $newUserId is not an Int. (Should actually be binary)
		 */
	public function setUserId(string $newUserId): void {
		try {
			$uuid = self::validateUuid($newUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->userId = $uuid;
	}
	/**
	 * Mutator method for userName. Needs additional sanitizing
	 *
	 * @param string $newUserName new value of UserName
	 * @throws \InvalidArgumentException if input is empty or insecure
	 */
	public function setUserName(string $newUserName): void{
		$newUserName = trim($newUserName);
		$newUserName = filter_var($newUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserName) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->userName = $newUserName;
	}

	/**
	 * Mutator method for firstName. Needs additional sanitizing
	 *
	 * @param string $newFirstName new value of FirstName
	 * @throws \InvalidArgumentException if input is empty or insecure
	 */
	public function setFirstName(string $newFirstName): void{
		$newFirstName = trim($newFirstName);
		$newFirstName = filter_var($newFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newFirstName) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->firstName = $newFirstName;
	}

	/**
	 * Mutator method for lastName. Needs additional sanitizing
	 *
	 * @param string $newLastName new value of lastName
	 * @throws \InvalidArgumentException if input is empty or insecure
	 */
	public function setLastName(string $newLastName): void{
		$newLastName = trim($newLastName);
		$newLastName = filter_var($newLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newLastName) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->lastName = $newLastName;
	}
	/**
	 * Mutator method for userEmail. Needs additional sanitizing
	 *
	 * @param string $newUserEmail new value of UserEmail
	 * @throws \InvalidArgumentException if input is empty or insecure
	 */
	public function setUserEmail(string $newUserEmail): void{
		$newUserEmail = trim($newUserEmail);
		$newUserEmail = filter_var($newUserEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserEmail) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->userEmail = $newUserEmail;
	}
	/**
	 * Mutator method for userAuthorizationToken. Needs additional sanitizing
	 *
	 * @param string $newUserAuthorizationToken new value of userAuthorizationToken
	 * @throws \InvalidArgumentException if $newUserAuthorizationToken is empty or insecure
	 */
	public function setUserAuthorizationToken(string $newUserAuthorizationToken): void{
		$newUserAuthorizationToken = strtolower(trim($newUserAuthorizationToken));
		$newUserAuthorizationToken = filter_var($newUserAuthorizationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserAuthorizationToken) === true) {
			throw(new \InvalidArgumentException("input is empty"));
		}
		if(ctype_xdigit($newUserAuthorizationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		if(strlen($newUserAuthorizationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32 characters."));
		}

		$this->userAuthorizationToken = $newUserAuthorizationToken;
	}

	/**
	 * Mutator method for userHash. Needs additional sanitizing
	 *
	 * @param string $newUserHash new value of userHash
	 * @throws \InvalidArgumentException if $newUserHash is empty or insecure
	 */
	public function setUserHash(string $newUserHash): void{
		$newUserHash = trim($newUserHash);
		$newUserHash = filter_var($newUserHash, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserHash) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->userHash = $newUserHash;
	}

/**
 * Constructor method for User object
 *
 * @param $newUserId, $newUserName, $newFirstName, $newLastName, $newUserEmail, $newUserAuthenticationToken, $newUserHash
 */
public function __construct(string $newUserId, string $newUserName, string $newLastName, string $newUserEmail, string $newUserAuthenticationToken, string $newUserHash) {
		$this->setUserId($newUserId);
		$this->setUserName($newUserName);
		$this->setLastName($newLastName);
		$this->setUserEmail($newUserEmail);
		$this->setUserAuthenticationToken($newUserAuthenticationToken);
		$this->setUserHash($newUserHash);
	}
}



}