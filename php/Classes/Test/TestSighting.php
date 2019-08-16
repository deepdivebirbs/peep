<?php

namespace Birbs\Peep\Test;
use Birbs\Peep\Sighting;
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
	 * @var userProfile User Profile
	 **/
	protected $userProfile = null;

	/**
	 * This is the species that was used to fill in the sighting being tested
	 * @var birdSpecies Species from the API
	 */

	/**
	 * User Profile authentication token used to create the user profile for this test sighting
	 * @var userProfileAuthenticationToken User Profile Authentication Token
	 **/
	protected $userProfileAuthenticationToken = null;

	/**
	 * User Profile hash used to create the user profile for this test sighting
	 * @var userProfileHash User Profile Hash
	 **/
	protected $userProfileHash = null;

	/**
	 * Sighting Date Time, which is when the sighting was entered into the table
	 * @var sightingDateTime Sighting Date and Time
	 **/
	protected $sightingDateTime = null;

	/**
	 * create dependent objects before running each test
	 **/

	public final function setUp() : void {
		//run the default setUp() method first

		parent::setUp();

		$sightingId = generateUuidV4();
		$sightingSpeciesId = generateUuidV4();
		$sightingUserProfileId = generateUuidV4();

		// create a salt and a hash for the mocked profile
		$password = "abc123";
		$this->VALID_USERPROFILEHASH = userProfileHash($password, PASSWORD_ARGON21, ["time_cost" => 384]);
		$this->VALID_USERPROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16));

		//create and insert the mocked profile
		$this->userProfile = new userProfile(generateUuidV4(), "Bird Lady", "Cardi", "Nal","cardib@gsnail.com", null, $this->VALID_USERPROFILEHASH);
		$this->profile->insert($this->getPDO());

		//create and insert the mocked species
		$this->birdSpecies = new birdSpecies(generateUuidV4(), "pingym", "Pinyon Jay", "Gymnorhinus cyanocephalus", "photo.url/bird");
		$this->birdSpecies->insert($this->getPDO());

		//create the and insert the mocked sighting
		$this->sighting = new Sighting(generateUuidV4(), $this->sightingSpeciesId, $this->sightingProfileUserId , $this->sightingBirdPhoto, $this->sightingDateTime, $this->$sightingLocX, $this->$sightingLocY);

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
	$sighting = new Sighting ($sightingId, $this->VALID_SIGHTINGSPECIESID, $this->VALID_SIGHTINGUSERPROFILEID, $this->VALID_SIGHTINGBIRDPHOTO, $this->VALID_SIGHTINGDATETIME, $this->VALID_SIGHTINGLOCX, $this->VALID_SIGHTINGLOCY);
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
	$numrows = $this->getConnection()->getRowCount("sighting");

	//create a new sighting and insert into MySQL
	$sightingId = generateUuidV4();
	$sightingSpeciesId = generateUuidV4();
	$sightingUserProfileId = generateUuidV4();

	$sighting = new Sighting($sightingId, $this->VALID_SIGHTINGSPECIESID, $this->VALID_SIGHTINGPROFILEUSERID, $this->VALID_SIGHTINGBIRDPHOTO, $this->VALID_SIGHTINGDATETIME, $this->VALID_SIGHTINGLOCX, $this->VALID_SIGHTINGLOCY);
	$sighting->insert($this->getPDO());

	//delete the sighting from MySQL
	$this->assertEquals($numrows + 1, $this->getConnection()->getRowCount("sighting"));
	$sighting->delete($this->getPDO);

	//grab the data from MySQL and enforce the sighting does not exist
	$pdoSighting = Sighting::getSightingBySightingId($this->getPDO(), $sighting->getSightingId());
	$this->assertNull($pdoSighting);
	$this->assertEquals($numrows, $this->getConnection()->getRowCount("sighting"));
} //test delete valid sighting end curly

} //final test class curly