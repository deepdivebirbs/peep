<?php


namespace birbs\peep;
require_once("autoload.php");
use Ramsey\Uuid\Uuid;


class UserProfile {
	use ValidateUuid;

	/**
	 * @var $userProfileId, the primary key and index
	 */
	private $userProfileId;

	/**
	 * @var  $userProfileName, a unique identifier, but not the key
	 */
	private $userProfileName;
	/**
	 * @var $userProfileFirstName, $userProfileLastName, $userProfileEmail, other information stored by the user
	 */
	private $userProfileFirstName;
	private $userProfileLastName;
	private $userProfileEmail;
	/**
	 * @var $userProfileAuthenticationToken, $userProfileHash, needed for security purposes
	 */
	private $userProfileAuthenticationToken;
	private $userProfileHash;

	/**
	 * accessor method for userProfileId
	 * @return $userProfileId - should fit in Binary.
	 */
	public function getuserProfileId() :Uuid {
		return ($this->userProfileId);
	}
	/**
	 * accessor method for userProfileName
	 * @return $userProfileName - should fit in varchar(32).
	 */
	public function getUserName() :string {
		return ($this->userProfileName);
	}
	/**
	 * accessor method for userProfileFirstName
	 * @return $userProfileFirstName - should fit in varChar(32)
	 */
	public function getFirstName() :string {
		return ($this->userProfileFirstName);
	}
	/**
	 * accessor method for userProfileLastName
	 * @return $userProfileLastName - should fit in varChar(32).
	 */
	public function getLastName() :string {
		return ($this->userProfileLastName);
	}
	/**
	 * accessor method for userProfileEmail
	 * @return $userProfileEmail - should fit in varChar(128)
	 */
	public function getUserEmail() :string {
		return ($this->userProfileEmail);
	}
	/**
	 * Accessor method for userActivationToken.
	 *
	 * @return string userActivationToken
	 */
	public function getUserAuthenticationToken(): string {
		return ($this->userProfileAuthenticationToken);
	}
	/**
	 * Accessor method for userProfileHash.
	 *
	 * @return string userProfileHash
	 */
	public function getUserHash(): string {
		return ($this->userProfileHash);
	}

		/**
		 * Mutator method for userProfileId
		 *
		 * @param int $newUserProfileId new value of userProfileId
		 * @throws UnexpectedValueException if $newUserProfileId is not an Int. (Should actually be binary)
		 */
	public function setuserProfileId(string $newUserProfileId): void {
		try {
			$uuid = self::validateUuid($newUserProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->userProfileId = $uuid;
	}
	/**
	 * Mutator method for userProfileName. Needs additional sanitizing
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
		$this->userProfileName = $newUserName;
	}

	/**
	 * Mutator method for userProfileFirstName. Needs additional sanitizing
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
		$this->userProfileFirstName = $newFirstName;
	}

	/**
	 * Mutator method for userProfileLastName. Needs additional sanitizing
	 *
	 * @param string $newLastName new value of userProfileLastName
	 * @throws \InvalidArgumentException if input is empty or insecure
	 */
	public function setLastName(string $newLastName): void{
		$newLastName = trim($newLastName);
		$newLastName = filter_var($newLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newLastName) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->userProfileLastName = $newLastName;
	}
	/**
	 * Mutator method for userProfileEmail. Needs additional sanitizing
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
		$this->userProfileEmail = $newUserEmail;
	}
	/**
	 * Mutator method for userProfileAuthenticationToken. Needs additional sanitizing
	 *
	 * @param string $newUserAuthorizationToken new value of userProfileAuthenticationToken
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

		$this->userProfileAuthenticationToken = $newUserAuthorizationToken;
	}

	/**
	 * Mutator method for userProfileHash. Needs additional sanitizing
	 *
	 * @param string $newUserHash new value of userProfileHash
	 * @throws \InvalidArgumentException if $newUserHash is empty or insecure
	 */
	public function setUserHash(string $newUserHash): void{
		$newUserHash = trim($newUserHash);
		$newUserHash = filter_var($newUserHash, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserHash) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->userProfileHash = $newUserHash;
	}

/**
 * Constructor method for User object
 *
 * @param $newUserProfileId, $newUserName, $newFirstName, $newLastName, $newUserEmail, $newUserAuthenticationToken, $newUserHash
 */
public function __construct(string $newUserProfileId, string $newUserName, string $newLastName, string $newUserEmail, string $newUserAuthenticationToken, string $newUserHash) {
		$this->setuserProfileId($newUserProfileId);
		$this->setUserName($newUserName);
		$this->setLastName($newLastName);
		$this->setUserEmail($newUserEmail);
		$this->setUserAuthorizationToken($newUserAuthenticationToken);
		$this->setUserHash($newUserHash);
	}




}