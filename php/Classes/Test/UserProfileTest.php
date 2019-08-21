<?php

namespace Birbs\Peep\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};// grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/Secrets.php");// grab the class under scrutiny
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

/**
 * Unit test for UserProfile
 *
 * @author Alistair Gillikin
 */

class UserProfileTest extends PeepTest {


	/**
	 * @var $VALID_profileId - a test profile Id which should be valid. Might not be necessary.
	 */
	protected $VALID_profileId;
	/**
	 * @var $VALID_AUTHENTICATION - a test Authentication which should be valid. Might not be necessary.
	 */
	protected $VALID_AUTHENTICATION;
	/**
	 * @var $VALID_profileEmail - a test email which should be valid.
	 */
	protected $VALID_profileEmail = "Unit test should be passing.";
	/**
	 * @var $VALID_profileFirstName - a test name which should be valid.
	 */
	protected $VALID_profileFirstName = "Mr. User";
	/**
	 * @var $VALID_HASH - a test hash which should be valid. Might not be necessary.
	 */
	protected $VALID_HASH; //This one in particular will need development
	/**
	 * @var $VALID_profileLastName - A test last name which should be valid.
	 */
	protected $VALID_profileLastName = "Passes";
	/**
	 * @var $VALID_profileName - a test profilename which should be valid.
	 */
	protected $VALID_profileName = "Mr. User Passes";

	/**
	 * Create dependent objects
	 */
	public final function setUp() : void {
		parent::setUp();
		//Creating password salt
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_AUTHENTICATION = bin2hex(random_bytes(16));

	}

	/**
	 * Tests the Insert function, and checks whether the SQL data matches.
	 */
	public function testUserProfileInsert() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("userProfile");

		//generate and add profile object to database
		$testProfileId = generateUuidv4();

		$testProfile = new UserProfile($testProfileId, $this->VALID_profileName, $this->VALID_profileFirstName, $this->VALID_profileLastName, $this->VALID_profileEmail, $this->VALID_AUTHENTICATION, $this->VALID_HASH);
		$testProfile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match
		$pdoProfile= UserProfile::getUserProfileById($this->getPDO(), $UserProfile->getUserProfileId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$this->assertEquals($pdoProfile->getUserProfileId(), $testProfileId);
		$this->assertEquals($pdoProfile->getUserProfileName(), $this->VALID_profileName);
		$this->assertEquals($pdoProfile->getUserProfileFirstName(), $this->VALID_profileFirstName);
		$this->assertEquals($pdoProfile->getUserProfileLastName(), $this->VALID_profileLastName);
		$this->assertEquals($pdoProfile->getUserProfileEmail(), $this->VALID_profileEmail);
		$this->assertEquals($pdoProfile->getUserProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getUserProfileAuthenticationToken(), $this->VALID_AUTHENTICATION);
	}

	public function testUserProfileUpdate() {
		;
	}

	public function testUserProfileDelete() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("restaurant");

		//generate and add profile object to database
		$testProfileId = generateUuidv4();

		$testProfile = new UserProfile($testProfileId, $this->VALID_profileName, $this->VALID_profileFirstName, $this->VALID_profileLastName, $this->VALID_profileEmail, $this->VALID_AUTHENTICATION, $this->VALID_HASH);
		$testProfile->insert($this->getPDO());

		//delete the profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$testProfile->delete($this->getPDO());
	}

	public function testGetUserProfileById() {
		;
	}

	public function testGetUserProfileByName() {
		;
	}

	public function testGetUserProfileAll() {
		;
	}



}