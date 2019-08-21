<?php

namespace Birbs\Peep\Test;
use Birbs\Peep\{Sighting};
require_once("PeepTest.php");
require_once (dirname(__DIR__, 1) . "/autoload.php");

/**
 * Full PHPUnit test for the Sighting class
 *
 * This is a complete unit test of the Sighting class. It is complete because *ALL* MySQL/PDO enabled methods are tested for both valid and invalid inputs.
 *
 * @see \Birbs\Peep\Sighting
 * @author Ruth Dove <senoritaruth@gmail.com>
 *
 **/

class SightingTest extends PeepTest {
	/**
	 * User profile that created the sighting; this is for foreign key relations
	 * @var $userProfile User Profile
	 **/
	protected $userProfile = null;

	/**
	 * This is the species that was used to fill in the sighting being tested
	 * @var $species Species from the API
	 */
	protected $species = null;

	/**
	 * User Profile authentication token used to create the user profile for this test sighting
	 * @var $userProfileAuthenticationToken User Profile Authentication Token
	 **/
	protected $userProfileAuthenticationToken = null;

	/**
	 * User Profile hash used to create the user profile for this test sighting
	 * @var $userProfileHash user Profile Hash
	 **/
	protected $userProfileHash = null;

	/**
	 * Sighting Date Time, which is when the sighting was entered into the table
	 * @var $sightingDateTime Sighting Date and Time
	 **/
	protected $sightingDateTime = null;

	/**
	 * create dependent objects before running each test
	 **/

	public final function setUp() : void {
		//run the default setUp() method first

		parent::setUp();

		// create a salt and a hash for the mocked profile
		$password = "abc123";
		$this->VALID_USERPROFILEHASH = userProfileHash($password, PASSWORD_ARGON21, ["time_cost" => 384]);
		$this->VALID_USERPROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16));

		//create and insert the mocked profile
		$this->userProfile = new userProfile(generateUuidV4(), "Bird Lady", "Cardi", "Nal","cardib@gsnail.com", null, $this->VALID_USERPROFILEHASH);
		$this->userProfile->insert($this->getPDO());

		//create and insert the mocked species
		$this->species = new species(generateUuidV4(), "pingym", "Pinyon Jay", "Gymnorhinus cyanocephalus", "photo.url/bird");
		$this->species->insert($this->getPDO());

		//create the and insert the mocked sighting
		$this->sighting = new sighting(generateUuidV4(), generateUuidV4(), generateUuidV4() , $this->sightingBirdPhoto, $this->sightingDateTime, $this->$sightingLocX, $this->$sightingLocY);

		//calculate the date (just use the time the unit test was set up)
		$this->VALID = \DateTime();

	} //public final function end curly

/**
 * Test inserting a valid sighting and verify that the actual MySQL data matches
 **/
public function testInsertValidSighting(): void {
	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("sighting");

	//create a new sighting and insert it into MySQL
	$sighting = new sighting ($sightingId, $this->VALID_SIGHTINGSPECIESID, $this->VALID_SIGHTINGUSERPROFILEID, $this->VALID_SIGHTINGBIRDPHOTO, $this->VALID_SIGHTINGDATETIME, $this->VALID_SIGHTINGLOCX, $this->VALID_SIGHTINGLOCY);
	$sighting->insert($this->getPDO());

	//grab the data from MySQL and enforce the fields match
	$pdoSighting = Sighting::getSightingBySightingId($this->getPDO(), $sighting->getSightingId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("sighting"));
	$this->assertEquals($pdoSighting->getSightingId(), $sightingId);
	$this->assertEquals($pdoSighting->getSightingSpeciesId(), $sightingSpeciesId);
	$this->assertEquals($pdoSighting->getSightingUserProfileId(), $sightingUserProfileId);
	$this->assertEquals($pdoSighting->getSightingBirdPhoto(), $sightingBirdPhoto);
	$this->assertEquals($pdoSighting->getSightingDateTime(), $sightingDateTime);
	$this->assertEquals($pdoSighting->getSightingLocX(), $sightingLocX);
	$this->assertEquals($pdoSighting->getSightingLocY(), $sightingLocY);
} //test insert valid sighting end curly

/**
 * Test creating a sighting and then deleting it
 **/
public function testDeleteValidSighting(): void {
	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("sighting");

	//create a new sighting and insert into MySQL

	$sighting = new sighting($sightingId, $this->VALID_SIGHTINGSPECIESID, $this->VALID_SIGHTINGPROFILEUSERID, $this->VALID_SIGHTINGBIRDPHOTO, $this->VALID_SIGHTINGDATETIME, $this->VALID_SIGHTINGLOCX, $this->VALID_SIGHTINGLOCY);
	$sighting->insert($this->getPDO());

	//delete the sighting from MySQL
	$this->assertEquals($numrows + 1, $this->getConnection()->getRowCount("sighting"));
	$sighting->delete($this->getPDO);

	//grab the data from MySQL and enforce the sighting does not exist
	$pdoSighting = Sighting::getSightingBySightingId($this->getPDO(), $sighting->getSightingId());
	$this->assertNull($pdoSighting);
	$this->assertEquals($numrows, $this->getConnection()->getRowCount("sighting"));
} //test delete valid sighting end curly

/**
 * Test get a single sighting by sighting ID
 */
public function testGetSightingBySightingId(): void {

	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("sighting");

	//create a new sighting and insert it into MySQL
	$sightingId = generateUuidV4();
	$sighing = new Sighting($sightingId, $this->sightingId->getSightingId(), $this->VALID_SIGHTING; $this->VALID_SIGHTINGDATE);
	$sighting->insert($this->getPDO());

		//grab the data from MySQL and enforce the fields match our expectations
	$results = Sighting::getSightingBySightingId($this->getPDO(), $sighting->getSightingId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("sighting"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Birbs\\Peep\\Sighting", $results);
	} //end single sighting test curly



/**
 * Test get an array of sightings by user profile id
 */
public function testGetAllSightingsByUserProfileId(): void {
	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("sighting");

	//create a new sighting and insert it into MySQL
	$sightingId = generateUuidV4();
	$sighting = new Sighting($sightingId, $this->userProfile->getUserpProfileId(), $this->VALID_SIGHTING; $this->VALID_SIGHTINGDATE);
	$sighting->insert($this->getPDO());

	//grab the data from MySQL and enforce the fields match our expectations
	$results = Sighting::getSightingsBySightingUserProfileId($this->getPDO(), $sighting->getSightingUserProfileId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("sighting"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Birbs\\Peep\\Sighting", $results);

	//grab the result from the array and validate it
	$pdoSighting = $results[0];

	$this->assertEquals($pdoSighting->getSightingId(), $sightingId)
	$this->assertEquals($pdoSighting->getSightingUserProfileId(), $this->profile->getProfileId());
	$this->assertEquals($pdoSighting->$this->VALID_SIGHTINGSPECIESID, $this->VALID_SIGHTINGPROFILEUSERID, $this->VALID_SIGHTINGBIRDPHOTO, $this->VALID_SIGHTINGDATETIME, $this->VALID_SIGHTINGLOCX, $this->VALID_SIGHTINGLOCY);
	//format the date to seconds since the beginning of time to avoid round off error
	$this->assertEquals($pdoSighting->getSightingDateTime()->getTimeStamp(), $this->VALID_SIGHTINGDATETIME->getTimeStamp());

} //test get all sightings by user profile id end curly



} //final test class curly