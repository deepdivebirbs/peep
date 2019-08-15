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
	 *Sighting ID that identifies the sighting; this is for the foreign key relations
	 * @var sightingId Sighting ID
	 **/
	protected $sightingId = null;

	/**
	 * Sighting Species ID that identifies the bird from the Species class
	 * @var sightingSpeciesId Sighting Species ID
	 **/
	protected $sightingSpeciesId = null;

	/**
	 * Sighting User Profile ID which binds the sighting to the user who submitted it
	 * @var sightingProfileUserId Sighting Profile User ID
	 **/
	protected $sightingProfileUserId = null;

	/**
	 * Sighting Bird Photo URL, which the user uploads at the time of sighting
	 * @var sightingBirdPhoto Sighting Bird Photo URL
	 **/
	protected $sightingBirdPhoto = null;

	/**
	 * Sighting Date Time, which is when the sighting was entered into the table
	 * @var sightingDateTime Sighting Date and Time
	 **/
	protected $sightingDateTime = null;

	/**
	 * Sighting Location X (latitude), which is the latitude of the sighting
	 * @var sightingLocX Sighting Location X, which is latitude
	 **/
	protected $sightingLocX = null;

	/**
	 * Sighting Location Y (longitude), which is the longitude of the sighting
	 * @var sightingLocY Sighting Location Y, which is longitude
	 **/
	protected $sightingLocY = null;

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
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON21, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		//create and insert the mocked profile
		$this->profile = new Profile(generateUuidV4(), null,"@phpunit", "test@phpunit.de",$this->VALID_HASH, "+15058675309");
		$this->profile->insert($this->getPDO());

		//create the and insert the mocked sighting
		$this->sighting = new Sighting(generateUuidV4(), $this->sightingSpeciesId, $this->sightingProfileUserId , $this->sightingBirdPhoto, $this->sightingDateTime, $this->$sightingLocX, $this->$sightingLocY);

		//calculate the date (just use the time the unit test was set up)
		$this->VALID_LIKEDATE = \DateTime();

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