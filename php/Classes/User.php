<?php


namespace Birbs\Peep;
require_once("autoload.php");
require_once(dirname(__DIR__,1) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;


class UserProfile {
	use ValidateUuid;

	/**
	 * @var $userProfileId, the primary key and index
	 * @var $userProfileAuthenticationToken, needed for security purposes
	 * @var $userProfileEmail, other information stored about the user
	 * @var $userProfileFirstName, other information stored about the the user
	 * @var $userProfileHash, needed for security purposes
	 * @var $userProfileLastName, other information stored about the the user
	 * @var $userProfileName, a unique identifier, but not the key
	 */
	private $userProfileId;
	private $userProfileAuthenticationToken;
	private $userProfileEmail;
	private $userProfileFirstName;
	private $userProfileHash;
	private $userProfileLastName;
	private $userProfileName;



	/**
	 * accessor method for userProfileId
	 * @return $userProfileId - should fit in Binary.
	 */
	public function getUserProfileId() :Uuid {
		return ($this->userProfileId);
	}
	/**
	 * Accessor method for userProfileAuthenticationToken.
	 *
	 * @return string userProfileAuthenticationToken
	 */
	public function getUserProfileAuthenticationToken(): string {
		return ($this->userProfileAuthenticationToken);
	}
	/**
	 * accessor method for userProfileEmail
	 * @return $userProfileEmail - should fit in varChar(128)
	 */
	public function getUserProfileEmail() :string {
		return ($this->userProfileEmail);
	}
	/**
	 * accessor method for userProfileFirstName
	 * @return $userProfileFirstName - should fit in varChar(32)
	 */
	public function getUserProfileFirstName() :string {
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
	 * @return $userProfileLastName - should fit in varChar(32).
	 */
	public function getUserProfileLastName() :string {
		return ($this->userProfileLastName);
	}
	/**
	 * accessor method for userProfileName
	 * @return $userProfileName - should fit in varchar(32).
	 */
	public function getUserProfileName() :string {
		return ($this->userProfileName);
	}




		/**
		 * Mutator method for userProfileId
		 *
		 * @param int $newUserProfileId new value of userProfileId
		 * @throws UnexpectedValueException if $newUserProfileId is not an Int. (Should fit into a binary)
		 */
	public function setUserProfileId(string $newUserProfileId): void {
		try {
			$uuid = self::validateUuid($newUserProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->userProfileId = $uuid;
	}
	/**
	 * Mutator method for userProfileAuthenticationToken. Needs additional sanitizing
	 *
	 * @param string $newUserAuthorizationToken new value of userProfileAuthenticationToken
	 * @throws \InvalidArgumentException if $newUserAuthorizationToken is empty or insecure
	 */
	public function setUserProfileAuthenticationToken(string $newUserProfileAuthenticationToken): void{
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
	 * @param string $newUserEmail new value of UserEmail
	 * @throws \InvalidArgumentException if input is empty or insecure
	 */
	public function setUserProfileEmail(string $newUserProfileEmail): void{
		$newUserProfileEmail = trim($newUserProfileEmail);
		$newUserProfileEmail = filter_var($newUserProfileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserProfileEmail) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->userProfileEmail = $newUserProfileEmail;
	}
	/**
	 * Mutator method for userProfileFirstName. Needs additional sanitizing
	 *
	 * @param string $newFirstName new value of FirstName
	 * @throws \InvalidArgumentException if input is empty or insecure
	 */
	public function setUserProfileFirstName(string $newUserProfileFirstName): void{
		$newUserProfileFirstName = trim($newUserProfileFirstName);
		$newUserProfileFirstName = filter_var($newUserProfileFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserProfileFirstName) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->userProfileFirstName = $newUserProfileFirstName;
	}
	/**
	 * Mutator method for userProfileHash. Needs additional sanitizing
	 *
	 * @param string $newUserHash new value of userProfileHash
	 * @throws \InvalidArgumentException if $newUserHash is empty or insecure
	 */
	public function setUserProfileHash(string $newUserProfileHash): void{
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
	 * @param string $newLastName new value of userProfileLastName
	 * @throws \InvalidArgumentException if input is empty or insecure
	 */
	public function setUserProfileLastName(string $newUserProfileLastName): void{
		$newUserProfileLastName = trim($newUserProfileLastName);
		$newUserProfileLastName = filter_var($newUserProfileLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserProfileLastName) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->userProfileLastName = $newUserProfileLastName;
	}

	/**
	 * Mutator method for userProfileName. Needs additional sanitizing
	 *
	 * @param string $newUserName new value of UserName
	 * @throws \InvalidArgumentException if input is empty or insecure
	 */
	public function setUserProfileName(string $newUserProfileName): void{
		$newUserProfileName = trim($newUserProfileName);
		$newUserProfileName = filter_var($newUserProfileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserProfileName) === true) {
			throw(new \InvalidArgumentException("input is empty or insecure"));
		}
		$this->userProfileName = $newUserProfileName;
	}



/**
 * Constructor method for User object
 *
 * @param $newUserProfileId, $newUserName, $newFirstName, $newLastName, $newUserEmail, $newUserAuthenticationToken, $newUserHash
 */
public function __construct(string $newUserProfileId, string $newUserProfileName, string $newUserProfileFirstName, string $newUserProfileLastName, string $newUserProfileEmail, string $newUserProfileAuthenticationToken, string $newUserProfileHash) {
		$this->setUserProfileId($newUserProfileId);
		$this->setUserProfileName($newUserProfileName);
		$this->setUserProfileFirstName($newUserProfileFirstName);
		$this->setUserProfileLastName($newUserProfileLastName);
		$this->setUserProfileEmail($newUserProfileEmail);
		$this->setUserProfileAuthenticationToken($newUserProfileAuthenticationToken);
		$this->setUserProfileHash($newUserProfileHash);
	}




}