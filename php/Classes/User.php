<?php


namespace birbs\peep;

use Ramsey\Uuid\Uuid;


class UserProfile {

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
	public function getUserId() {
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

}