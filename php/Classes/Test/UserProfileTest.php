<?php

namespace Birbs\Peep\Test;
use Birbs\Peep\UserProfile;
require_once ("PeepTest.php");
require_once(dirname(__DIR__, 1) . "/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Unit test for UserProfile
 *
 * @author Alistair Gillikin
 */

class UserProfileTest extends PeepTest {

	/**
	 * @var $VALID_PROFILEID - a test profile Id which should be valid. Might not be necessary.
	 */
	protected $VALID_PROFILEID;
	/**
	 * @var $VALID_AUTHENTICATION - a test Authentication which should be valid. Might not be necessary.
	 */
	protected $VALID_AUTHENTICATION;
	/**
	 * @var $VALID_PROFILEEMAIL - a test email which should be valid.
	 */
	protected $VALID_PROFILEEMAIL = "Unit test should be passing.";
	/**
	 * @var $VALID_PROFILEFIRSTNAME - a test name which should be valid.
	 */
	protected $VALID_PROFILEFIRSTNAME = "Mr. User";
	/**
	 * @var $VALID_HASH - a test hash which should be valid. Might not be necessary.
	 */
	protected $VALID_HASH; //This one in particular will need development
	/**
	 * @var $VALID_PROFILELASTNAME - A test last name which should be valid.
	 */
	protected $VALID_PROFILELASTNAME = "Passes";
	/**
	 * @var $VALID_PROFILENAME - a test profilename which should be valid.
	 */
	protected $VALID_PROFILENAME = "Mr. User Passes";

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
	 * Tests the Insert function, and checks whether the SQL data matches. Also tests GetUserProfileById.
	 */
	public function testUserProfileInsert() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("userProfile");

		//generate and add profile object to database
		$testProfileId = generateUuidv4();

		$testProfile = new UserProfile($testProfileId, $this->VALID_PROFILENAME, $this->VALID_PROFILEFIRSTNAME, $this->VALID_PROFILELASTNAME, $this->VALID_PROFILEEMAIL, $this->VALID_AUTHENTICATION, $this->VALID_HASH);
		$testProfile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match
		$pdoProfile= UserProfile::getUserProfileById($this->getPDO(), $testProfile->getUserProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$this->assertEquals($pdoProfile->getUserProfileId(), $testProfileId);
		$this->assertEquals($pdoProfile->getUserProfileName(), $this->VALID_PROFILENAME);
		$this->assertEquals($pdoProfile->getUserProfileFirstName(), $this->VALID_PROFILEFIRSTNAME);
		$this->assertEquals($pdoProfile->getUserProfileLastName(), $this->VALID_PROFILELASTNAME);
		$this->assertEquals($pdoProfile->getUserProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($pdoProfile->getUserProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getUserProfileAuthenticationToken(), $this->VALID_AUTHENTICATION);
	}

	/**
	 * Tests userProfileUpdate.
	 */
	public function testUserProfileUpdate(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("userProfile");

		// create a new userProfile and insert to into mySQL
		$profileId = generateUuidV4();
		$userProfile = new UserProfile($profileId, $this->VALID_PROFILENAME, $this->VALID_PROFILEFIRSTNAME, $this->VALID_PROFILELASTNAME, $this->VALID_PROFILEEMAIL, $this->VALID_AUTHENTICATION, $this->VALID_HASH);
		$userProfile->insert($this->getPDO());

		// edit the Profile and update it in mySQL
		$userProfile->setUserProfileEmail($this->VALID_PROFILEEMAIL);
		$userProfile->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = userProfile::getUserProfileById($this->getPDO(), $userProfile->getUserProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$this->assertEquals($pdoProfile->getUserProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getUserProfileAuthenticationToken(), $this->VALID_AUTHENTICATION);
		$this->assertEquals($pdoProfile->getUserProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($pdoProfile->getUserProfileFirstName(), $this->VALID_PROFILEFIRSTNAME);
		$this->assertEquals($pdoProfile->getUserProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getUserProfileLastName(), $this->VALID_PROFILELASTNAME);
		$this->assertEquals($pdoProfile->getUserProfileName(), $this->VALID_PROFILENAME);
	}

	/**
	 * Tests UserProfileDelete.
	 */
	public function testUserProfileDelete(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("userProfile");

		//generate and add profile object to database
		$testProfileId = generateUuidv4();

		$testProfile = new UserProfile($testProfileId, $this->VALID_PROFILENAME, $this->VALID_PROFILEFIRSTNAME, $this->VALID_PROFILELASTNAME, $this->VALID_PROFILEEMAIL, $this->VALID_AUTHENTICATION, $this->VALID_HASH);
		$testProfile->insert($this->getPDO());

		//delete the profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$testProfile->delete($this->getPDO());

		//test that this profile was deleted by grabbing profile id
		$pdoProfile = UserProfile::getUserProfileById($this->getPDO(), $testProfile->getUserProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("userProfile"));
	}

	/**
	 * Test grabbing a profile by an ID that can't exist.
	 *
	 */
	public function testGetInvalidProfileByProfileId() : void {
		//grab profile id that exceeds the maximum allowable profile id
		$profileId = generateUuidV4();
		$profile = UserProfile::getUserProfileById($this->getPDO(), $profileId);
		$this->assertNull($profile);
	}

	/**
	 * Test get User Profile by name.
	 *
	 */

	public function testGetUserProfileByName() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("userProfile");

		// create a new user profile and insert to into mySQL
		$profileId = generateUuidV4();
		$userProfile = new UserProfile($profileId, $this->VALID_PROFILENAME, $this->VALID_PROFILEFIRSTNAME, $this->VALID_PROFILELASTNAME, $this->VALID_PROFILEEMAIL, $this->VALID_AUTHENTICATION, $this->VALID_HASH);
		$userProfile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = UserProfile::getUserProfileByName($this->getPDO(), $userProfile->getUserProfileName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));


		// grab the result from the array and validate it
		$pdoUserProfile= UserProfile::getUserProfileByName($this->getPDO(), $userProfile->getUserProfileName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$this->assertEquals($pdoUserProfile->getUserProfileId(), $profileId);
		$this->assertEquals($pdoUserProfile->getUserProfileAuthenticationToken(), $this->VALID_AUTHENTICATION);
		$this->assertEquals($pdoUserProfile->getUserProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($pdoUserProfile->getUserProfileFirstName(), $this->VALID_PROFILEFIRSTNAME);
		$this->assertEquals($pdoUserProfile->getUserProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUserProfile->getUserProfileLastName(), $this->VALID_PROFILELASTNAME);
		$this->assertEquals($pdoUserProfile->getUserProfileName(), $this->VALID_PROFILENAME);
	}

	/**
	 * test grabbing the Profile by the profile activation token
	 * this will be used by the user to find and activate their profile from an email
	 */
	public function testGetValidUserProfileByUserProfileAuthenticationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("userProfile");

		// create a new userProfile and insert to into mySQL
		$profileId = generateUuidV4();
		$userProfile = new UserProfile($profileId, $this->VALID_PROFILENAME, $this->VALID_PROFILEFIRSTNAME, $this->VALID_PROFILELASTNAME, $this->VALID_PROFILEEMAIL, $this->VALID_AUTHENTICATION, $this->VALID_HASH);
		$userProfile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = UserProfile::getUserProfileByAuthenticationToken($this->getPDO(), $userProfile->getUserProfileAuthenticationToken());

		// validate the results

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$this->assertEquals($results->getUserProfileId(), $profileId);
		$this->assertEquals($results->getUserProfileAuthenticationToken(), $this->VALID_AUTHENTICATION);
		$this->assertEquals($results->getUserProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($results->getUserProfileFirstName(), $this->VALID_PROFILEFIRSTNAME);
		$this->assertEquals($results->getUserProfileHash(), $this->VALID_HASH);
		$this->assertEquals($results->getUserProfileLastName(), $this->VALID_PROFILELASTNAME);
		$this->assertEquals($results->getUserProfileName(), $this->VALID_PROFILENAME);
	}




}