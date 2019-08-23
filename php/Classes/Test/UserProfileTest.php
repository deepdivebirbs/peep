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
		$pdoProfile= UserProfile::getUserProfileById($this->getPDO(), $testProfile->getUserProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$this->assertEquals($pdoProfile->getUserProfileId(), $testProfileId);
		$this->assertEquals($pdoProfile->getUserProfileName(), $this->VALID_profileName);
		$this->assertEquals($pdoProfile->getUserProfileFirstName(), $this->VALID_profileFirstName);
		$this->assertEquals($pdoProfile->getUserProfileLastName(), $this->VALID_profileLastName);
		$this->assertEquals($pdoProfile->getUserProfileEmail(), $this->VALID_profileEmail);
		$this->assertEquals($pdoProfile->getUserProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getUserProfileAuthenticationToken(), $this->VALID_AUTHENTICATION);
	}

	public function testUserProfileUpdate(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("userProfile");

		// create a new userProfile and insert to into mySQL
		$profileId = generateUuidV4();
		$userProfile = new UserProfile($profileId, $this->VALID_profileName, $this->VALID_profileFirstName, $this->VALID_profileLastName, $this->VALID_profileEmail, $this->VALID_AUTHENTICATION, $this->VALID_HASH);
		$userProfile->insert($this->getPDO());

		// edit the Profile and update it in mySQL
		$userProfile->setUserProfileEmail($this->VALID_profileEmail);
		$userProfile->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = userProfile::getUserProfileById($this->getPDO(), $userProfile->getUserProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$this->assertEquals($pdoProfile->getUserProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getUserProfileAuthenticationToken(), $this->VALID_AUTHENTICATION);
		$this->assertEquals($pdoProfile->getUserProfileEmail(), $this->VALID_profileEmail);
		$this->assertEquals($pdoProfile->getUserProfileFirstName(), $this->VALID_profileFirstName);
		$this->assertEquals($pdoProfile->getUserProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getUserProfileLastName(), $this->VALID_profileLastName);
		$this->assertEquals($pdoProfile->getUserProfileName(), $this->VALID_profileName);
	}

	public function testUserProfileDelete() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("userProfile");

		//generate and add profile object to database
		$testProfileId = generateUuidv4();

		$testProfile = new UserProfile($testProfileId, $this->VALID_profileName, $this->VALID_profileFirstName, $this->VALID_profileLastName, $this->VALID_profileEmail, $this->VALID_AUTHENTICATION, $this->VALID_HASH);
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
	 * TODO make sure the generated ID is too big
	 */
	public function testGetInvalidProfileByProfileId() : void {
		//grab profile id that exceeds the maximum allowable profile id
		$profileId = generateUuidV4();
		$profile = UserProfile::getUserProfileById($this->getPDO(), $profileId);
		$this->assertNull($profile);
	}

	public function testGetUserProfileByName() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("userProfile");

		// create a new user profile and insert to into mySQL
		$profileId = generateUuidV4();
		$userProfile = new UserProfile($profileId, $this->VALID_profileName, $this->VALID_profileFirstName, $this->VALID_profileLastName, $this->VALID_profileEmail, $this->VALID_AUTHENTICATION, $this->VALID_HASH);
		$userProfile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = [UserProfile::getUserProfileByName($this->getPDO(), $userProfile->getUserProfileName())];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Birbs\\Peep\\UserProfile", $results);

		// grab the result from the array and validate it
		$pdoUserProfile = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$this->assertEquals($pdoUserProfile->getUserProfileId(), $profileId);
		$this->assertEquals($pdoUserProfile->getUserProfileAuthenticationToken(), $this->VALID_AUTHENTICATION);
		$this->assertEquals($pdoUserProfile->getUserProfileEmail(), $this->VALID_profileEmail);
		$this->assertEquals($pdoUserProfile->getUserProfileFirstName(), $this->VALID_profileFirstName);
		$this->assertEquals($pdoUserProfile->getUserProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUserProfile->getUserProfileLastName(), $this->VALID_profileLastName);
		$this->assertEquals($pdoUserProfile->getUserProfileName(), $this->VALID_profileName);
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
		$userProfile = new UserProfile($profileId, $this->VALID_profileName, $this->VALID_profileFirstName, $this->VALID_profileLastName, $this->VALID_profileEmail, $this->VALID_AUTHENTICATION, $this->VALID_HASH);
		$userProfile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = UserProfile::getUserProfileByAuthenticationToken($this->getPDO(), $userProfile->getUserProfileAuthenticationToken());

		// validate the results

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("userProfile"));
		$this->assertEquals($results->getUserProfileId(), $profileId);
		$this->assertEquals($results->getUserProfileAuthenticationToken(), $this->VALID_AUTHENTICATION);
		$this->assertEquals($results->getUserProfileEmail(), $this->VALID_profileEmail);
		$this->assertEquals($results->getUserProfileFirstName(), $this->VALID_profileFirstName);
		$this->assertEquals($results->getUserProfileHash(), $this->VALID_HASH);
		$this->assertEquals($results->getUserProfileLastName(), $this->VALID_profileLastName);
		$this->assertEquals($results->getUserProfileName(), $this->VALID_profileName);
	}




}