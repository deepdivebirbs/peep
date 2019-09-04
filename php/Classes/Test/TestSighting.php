<?php

namespace Birbs\Peep\Test;

use Birbs\Peep\{Sighting, UserProfile, BirdSpecies};

require_once("PeepTest.php");
require_once(dirname(__DIR__, 1) . "/autoload.php");

/**
 * Full PHPUnit test for the Sighting class
 *
 * This is a complete unit test of the Sighting class. It is complete because *ALL* MySQL/PDO enabled methods are tested for both valid and invalid inputs.
 *
 * @see \Birbs\Peep\Sighting
 * @author Ruth Dove <senoritaruth@gmail.com>
 *
 **/
class TestSighting extends PeepTest {
	/**
	 * User profile that created the sighting; this is for foreign key relations
	 * @var $userProfile User Profile
	 **/
	protected $userProfile = "BirdLady";

	/**
	 * This is the species that was used to fill in the sighting being tested
	 * @var $sightingBirdSpeciesId Species from the API
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
	protected $userProfileHash;

	/**
	 * Sighting Date Time, which is when the sighting was entered into the table
	 * @var $sightingDateTime Sighting Date and Time
	 **/
	protected $sightingDateTime = null;

	/**Sighting Latitude, where the bird was sighted
	 * @var $sightingLocX float the bird was sighted
	 **/
	protected $sightingLocX = 43.098;

	/**Sighting Latitude, where the bird was sighted
	 * @var $sightingLocY float of the bird was sighted
	 **/
	protected $sightingLocY = 36.098;

	/**
	 * @var $sightingBirdPhoto
	 */
	protected $sightingBirdPhoto = "img";

	/**
	 * @var $sightingId   Uuid of the sighting
	 */
	protected $sightingId;

	/**
	 * create dependent objects before running each test
	 **/

	// create a salt and a hash for the mocked profile
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();


		$password = "abc123";
		$this->userProfileHash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$userProfileAuthenticationToken = bin2hex(random_bytes(16));

		//create and insert the mocked profile
		$userProfileId = generateUuidV4();
		$this->userProfile = new UserProfile($userProfileId, "Bird Lady", "Cardi", "Nal", "cardib@gsnail.com", $userProfileAuthenticationToken, $this->userProfileHash);

		//create and insert the mocked species
		$speciesId = generateUuidV4();
		//$this->species = new BirdSpecies($speciesId, "pingym", "Pinyon Jay", "Gymnorhinus cyanocephalus", "photo.url/bird");
		//$this->species->insert($this->getPDO());

		$birdSpecies = new BirdSpecies(generateUuidV4(), "pingym", "Pinyon Jay", "Gymnorhinus cyanocephalus", "photo.url/bird");
	}


	//calculate the date (just use the time the unit test was set up)
	//$this->sightingDateTime = \DateTime();

	/**
	 * Test inserting a valid sighting and verify that the actual MySQL data matches
	 **/
	public function testInsertValidSighting(): void {
		$birdSpecies = new BirdSpecies(generateUuidV4(), "pingym", "Pinyon Jay", "Gymnorhinus cyanocephalus", "photo.url/bird");

		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("sighting");

		//create a new sighting and insert it into MySQL
		$sightingId = generateUuidV4();
		$sighting = new Sighting (generateUuidV4(), generateUuidV4(), $birdSpecies->getSpeciesId(), $this->sightingBirdPhoto, $this->sightingDateTime, $this->sightingLocX, $this->sightingLocY);
		$sighting->insert($this->getPDO());

		//grab the data from MySQL and enforce the fields match
		$pdoSighting = Sighting::getSightingBySightingId($this->getPDO(), $sighting->getSightingId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("sighting"));
		$this->assertEquals($pdoSighting->getSightingId(), $sightingId);
		$this->assertEquals($pdoSighting->getSightingBirdSpeciesId(), $sighting->getSightingBirdSpeciesId());
		$this->assertEquals($pdoSighting->getSightingUserProfileId(), $sighting->getSightingUserProfileId());
		$this->assertEquals($pdoSighting->getSightingBirdPhoto(), $sighting->getSightingBirdPhoto());
		$this->assertEquals($pdoSighting->getSightingDateTime()->getTimestamp(), $sighting->getSightingDateTime()->getTimestamp());
		$this->assertEquals($pdoSighting->getSightingLocX(), $sighting->getSightingLocX());
		$this->assertEquals($pdoSighting->getSightingLocY(), $sighting->getSightingLocY());
	} //test insert valid sighting end curly

	/**
	 * Test creating a sighting and then deleting it
	 **/
	public function testDeleteValidSighting(): void {
		$birdSpecies = new BirdSpecies(generateUuidV4(), "pingym", "Pinyon Jay", "Gymnorhinus cyanocephalus", "photo.url/bird");
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("sighting");

		//create a new sighting and insert into MySQL
		$sightingId = generateUuidV4();

		$sighting = new Sighting (generateUuidV4(), generateUuidV4(), generateUuidV4(), $this->sightingBirdPhoto, $this->sightingDateTime, $this->sightingLocX, $this->sightingLocY);
		$sighting->insert($this->getPDO());

		//delete the sighting from MySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("sighting"));
		$sighting->delete($this->getPDO());

		//grab the data from MySQL and enforce the sighting does not exist
		$pdoSighting = Sighting::getSightingBySightingId($this->getPDO(), $sighting->getSightingId());
		$this->assertNull($pdoSighting);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("sighting"));
	} //test delete valid sighting end curly


	/**
	 * Test get an array of sightings by user profile id
	 */
	public function testGetAllSightingsByUserProfileId(): void {
		$birdSpecies = new BirdSpecies(generateUuidV4(), "pingym", "Pinyon Jay", "Gymnorhinus cyanocephalus", "photo.url/bird");
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("sighting");

		//create a new sighting and insert it into MySQL
		$sightingId = generateUuidV4();
		$sighting = new Sighting (generateUuidV4(), generateUuidV4(), generateUuidV4(), $this->sightingBirdPhoto, $this->sightingDateTime,  $this->sightingLocX, $this->sightingLocY);
		$sighting->insert($this->getPDO());

	//grab the data from MySQL and enforce the fields match our expectations
	$results = Sighting::getSightingsBySightingUserProfileId($this->getPDO(), $sighting->getSightingUserProfileId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("sighting"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Birbs\\Peep\\Sighting", $results);

	//grab the result from the array and validate it
	$pdoSighting = $results[0];

		$this->assertEquals($pdoSighting->getSightingId(), $sightingId);
		$this->assertEquals($pdoSighting->getSightingBirdSpeciesId(), $sighting->getSightingBirdSpeciesId());
		$this->assertEquals($pdoSighting->getSightingUserProfileId(), $sighting->getSightingUserProfileId());
		$this->assertEquals($pdoSighting->getSightingBirdPhoto(), $sighting->getSightingBirdPhoto());
		$this->assertEquals($pdoSighting->getSightingDateTime()->getTimestamp(), $sighting->getSightingDateTime()->getTimestamp());
		$this->assertEquals($pdoSighting->getSightingLocX(), $sighting->getSightingLocX());
		$this->assertEquals($pdoSighting->getSightingLocY(), $sighting->getSightingLocY());

} //test get all sightings by user profile id end curly

	/**
	 * Test get an array of sightings by sighting species id
	 */
	public function testGetAllSightingsSpeciesId(): void {
		$birdSpecies = new BirdSpecies(generateUuidV4(), "pingym", "Pinyon Jay", "Gymnorhinus cyanocephalus", "photo.url/bird");
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("sighting");

		//create a new sighting and insert it into MySQL
		$sightingId = generateUuidV4();
		$sighting = new Sighting (generateUuidV4(), generateUuidV4(), generateUuidV4(), $this->sightingBirdPhoto, $this->sightingDateTime, $this->sightingLocX, $this->sightingLocY);
		$sighting->insert($this->getPDO());

	//grab the data from MySQL and enforce the fields match our expectations
	$results = Sighting::getSightingsBySightingBirdSpeciesId($this->getPDO(), $sighting->getSightingBirdSpeciesId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("sighting"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Birbs\\Peep\\Sighting", $results);

	//grab the result from the array and validate it
	$pdoSighting = $results[0];

		$this->assertEquals($pdoSighting->getSightingId(), $sightingId);
		$this->assertEquals($pdoSighting->getSightingBirdSpeciesId(), $sighting->getSightingBirdSpeciesId());
		$this->assertEquals($pdoSighting->getSightingUserProfileId(), $sighting->getSightingUserProfileId());
		$this->assertEquals($pdoSighting->getSightingBirdPhoto(), $sighting->getSightingBirdPhoto());
		$this->assertEquals($pdoSighting->getSightingDateTime()->getTimestamp(), $sighting->getSightingDateTime()->getTimestamp());
		$this->assertEquals($pdoSighting->getSightingLocX(), $sighting->getSightingLocX());
		$this->assertEquals($pdoSighting->getSightingLocY(), $sighting->getSightingLocY());
} //test get all sightings by species id end curly


} //final test class curly