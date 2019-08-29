<?php

namespace Birbs\Peep\Test;

use Birbs\Peep\BirdSpecies;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};

require_once("PeepTest.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once(dirname(__DIR__, 1) . "/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

// Guess unit test classes don't have a __construct()?

/**
 * Class BirdSpeciesTest
 * @package Birbs\Peep\Test
 * @author Mark Waid Jr
 */
class BirdSpeciesTest extends PeepTest {
	// Create the test values.

	/**
	 * A UUID that identifies a bird species in the database.
	 *
	 * @var Uuid $VALID_SPECIES_ID
	 */
	protected $VALID_SPECIES_ID;

	/**
	 * A string that represents the given code to a bird species from the Ebirds API.
	 *
	 * @var string $VALID_SPECIES_CODE
	 */
	protected $VALID_SPECIES_CODE = "123ABC";

	/**
	 * A string that is the common non-scientific name of a bird species.
	 *
	 * @var string $VALID_SPECIES_COM_NAME
	 */
	protected $VALID_SPECIES_COM_NAME = "Pinyon Jay";

	/**
	 * A string that is the given scientific name for a bird species.
	 *
	 * @var string $VALID_SPECIES_SCI_NAME
	 */
	protected $VALID_SPECIES_SCI_NAME = "Gymnorhinus cyanocephalus";

	/**
	 * A string that is the URL for a bird species photo.
	 *
	 * @var string $VALID_SPECIES_PHOTO_URL
	 */
	protected $VALID_SPECIES_PHOTO_URL = "https://ebird.org/species/pinjay";


	// Do I test each function going down the list?

	/**
	 * Creates all of the objects to build the class object
	 */
	public function setUp(): void {
		parent::setUp();

		$this->VALID_SPECIES_ID = generateUuidV4();
	}

	/**
	 * Deletes all data and resets data base after each unit test.
	 */
	public final function tearDown(): void {
		parent::tearDown();

		$this->VALID_SPECIES_ID = null;
		$this->VALID_SPECIES_CODE = null;
		$this->VALID_SPECIES_COM_NAME = null;
		$this->VALID_SPECIES_SCI_NAME = null;
		$this->VALID_SPECIES_PHOTO_URL = null;

		Factory::DELETE_ALL();
	}

	/**
	 * @throws \Exception
	 * @returns void
	 */
	public function testSpeciesInsert(): void {
		// Get rows for some reason
		$rowCount = $this->getConnection()->getRowCount("species");

		// Create new BirdSpecies object and insert it into the database
		$testSpecies = new BirdSpecies($this->VALID_SPECIES_ID, $this->VALID_SPECIES_CODE, $this->VALID_SPECIES_COM_NAME, $this->VALID_SPECIES_SCI_NAME, $this->VALID_SPECIES_PHOTO_URL);

		// Insert object into the table
		$testSpecies->insert($this->getPDO());

		$pdoBird = $testSpecies->getSpeciesBySpeciesId($this->getPDO(), $testSpecies->getSpeciesId());

		// Check if a row was indeed added to the table
		$this->assertEquals($rowCount + 1, $this->getConnection()->getRowCount("species"));

		// Compare inserted ID to $this->VALID_SPECIES_ID
		$this->assertEquals($pdoBird->getSpeciesId(), $this->VALID_SPECIES_ID);

		// Compare inserted species code to $this->VALID_SPECIES_CODE
		$this->assertEquals($pdoBird->getSpeciesCode(), $this->VALID_SPECIES_CODE);

		// Compare inserted speciesComName to $this->VALID_COM_NAME
		$this->assertEquals($pdoBird->getSpeciesComName(), $this->VALID_SPECIES_COM_NAME);

		// Compare inserted speciesSciName to $this->VALID_SCI_NAME
		$this->assertEquals($pdoBird->getSpeciesSciName(), $this->VALID_SPECIES_SCI_NAME);

		// Compare inserted speciesPhotoUrl to $this->VALID_SPECIES_PHOTO_URL
		$this->assertEquals($pdoBird->getSpeciesPhotoUrl(), $this->VALID_SPECIES_PHOTO_URL);
	}

	/**
	 * @throws \Exception
	 */
	public function testSpeciesUpdate() {
		// Get row count for some reason
		$rowCount = $this->getConnection()->getRowCount("species");

		// Create new BirdSpecies and inert it.
		$testSpecies = new BirdSpecies($this->VALID_SPECIES_ID, $this->VALID_SPECIES_CODE, $this->VALID_SPECIES_COM_NAME, $this->VALID_SPECIES_SCI_NAME, $this->VALID_SPECIES_PHOTO_URL);
		$testSpecies->insert($this->getPDO());

		// Set updated data for $testSpecies.
		$updatedComName = "Some Bird";

		// Set new speciesComName value
		$testSpecies->setSpeciesComName($updatedComName);

		// Update the database
		$testSpecies->update($this->getPDO());

		// Get inserted BirdSpecies
		$pdoBird = $testSpecies->getSpeciesBySpeciesId($this->getPDO(), $this->VALID_SPECIES_ID);

		// Compare all of the values.
		$this->assertEquals($rowCount + 1, $this->getConnection()->getRowCount("species"));
		$this->assertEquals($pdoBird->getSpeciesId(), $this->VALID_SPECIES_ID);
		$this->assertEquals($pdoBird->getSpeciesCode(), $this->VALID_SPECIES_CODE);
		$this->assertEquals($pdoBird->getSpeciesComName(), $updatedComName);	// Comparing with UPDATED com name.
		$this->assertEquals($pdoBird->getSpeciesSciName(), $this->VALID_SPECIES_SCI_NAME);
		$this->assertEquals($pdoBird->getSpeciesPhotoUrl(), $this->VALID_SPECIES_PHOTO_URL);
	}

	/*
	 * Unit test for my delete method in BirdSpecies class
	 */
	public function testSpeciesDelete(): void {
		// Get the row count to compare later
		$rowCount = $this->getConnection()->getRowCount("species");

		// Create new BirdSpecies
		$testSpecies = new BirdSpecies($this->VALID_SPECIES_ID, $this->VALID_SPECIES_CODE, $this->VALID_SPECIES_COM_NAME, $this->VALID_SPECIES_SCI_NAME, $this->VALID_SPECIES_PHOTO_URL);

		// Insert BirdSpecies into the table
		$testSpecies->insert($this->getPDO());

		// Check to see if the number of rows increased.
		$this->assertEquals($rowCount + 1, $this->getConnection()->getRowCount("species"));

		// Delete BirdSpecies
		$testSpecies->delete($this->getPDO());

		// Try to grab the deleted entry, hopefully it fails.
		$testBirdGrab = $testSpecies->getSpeciesBySpeciesId($this->getPDO(), $this->VALID_SPECIES_ID);

		// Check if $testBirdGrab is NULL
		$this->assertNull($testBirdGrab);
	}

	/**
	 * @throws \Exception
	 */
	public function testGetBirdBySpeciesId(): void {
		// Get row count for later
		$rowCount = $this->getConnection()->getRowCount("species");

		// Create new BirdSpecies
		$testSpecies = new BirdSpecies($this->VALID_SPECIES_ID, $this->VALID_SPECIES_CODE, $this->VALID_SPECIES_COM_NAME, $this->VALID_SPECIES_SCI_NAME, $this->VALID_SPECIES_PHOTO_URL);

		// Insert the new BirdSpecies
		$testSpecies->insert($this->getPDO());

		// Confirm the species has been inserted
		$this->assertGreaterThan($rowCount, $this->getConnection()->getRowCount("species"));

		// Get the species by it's ID
		$testGrabSpecies = BirdSpecies::getSpeciesBySpeciesId($this->getPDO(), $this->VALID_SPECIES_ID);

		// Assert that they are the same
		$this->assertEquals($testGrabSpecies->getSpeciesId(), $this->VALID_SPECIES_ID);
	}

	/**
	 * @throws \Exception
	 */
	public function testGetAllBirds() {
		// Get row count
		$baseRowCount = $this->getConnection()->getRowCount("species");

		// Create new bird to insert.  Because how can we get ALL birds if there is only one bird?
		$testBird = new BirdSpecies($this->VALID_SPECIES_ID, $this->VALID_SPECIES_CODE, $this->VALID_SPECIES_COM_NAME, $this->VALID_SPECIES_SCI_NAME, $this->VALID_SPECIES_PHOTO_URL);

		// Insert the test bird
		$testBird->insert($this->getPDO());

		// Create a split fixed array the size of the table, and populate it with birds
		//$testBirds = new \SplFixedArray($baseRowCount + 2);
		$testBirds = BirdSpecies::getAllBirds($this->getPDO());

		// Check if both birds were inserted
		$this->assertEquals($baseRowCount + 1, $this->getConnection()->getRowCount('species'));

		// Run checks on the retrieved first retrieved bird.
		$this->assertEquals($this->VALID_SPECIES_ID, $testBirds[0]->getSpeciesId());
		$this->assertEquals($this->VALID_SPECIES_CODE, $testBirds[0]->getSpeciesCode());
		$this->assertEquals($this->VALID_SPECIES_COM_NAME, $testBirds[0]->getSpeciesComName());
		$this->assertEquals($this->VALID_SPECIES_SCI_NAME, $testBirds[0]->getSpeciesSciName());
		$this->assertEquals($this->VALID_SPECIES_PHOTO_URL, $testBirds[0]->getSpeciesPhotoUrl());
	}

	public function testGetBirdSpeciesBySpeciesCode() {
		// Get row count
		$baseRowCount = $this->getConnection()->getRowCount("species");

		// Create test bird
		$testBird = new BirdSpecies($this->VALID_SPECIES_ID, $this->VALID_SPECIES_CODE, $this->VALID_SPECIES_COM_NAME, $this->VALID_SPECIES_SCI_NAME, $this->VALID_SPECIES_PHOTO_URL);

		// Insert test bird
		$testBird->insert($this->getPDO());

		// Test if bird was inserted
		$this->assertEquals($baseRowCount + 1, $this->getConnection()->getRowCount("species"));

		// Get species by it's species code
		$testBird = BirdSpecies::getBirdSpeciesBySpeciesCode($this->getPDO(), $this->VALID_SPECIES_CODE);

		// Assert all of the values
		$this->assertEquals($this->VALID_SPECIES_ID, $testBird->getSpeciesId());
		$this->assertEquals($this->VALID_SPECIES_CODE, $testBird->getSpeciesCode());
		$this->assertEquals($this->VALID_SPECIES_COM_NAME, $testBird->getSpeciesComName());
		$this->assertEquals($this->VALID_SPECIES_SCI_NAME, $testBird->getSpeciesSciName());
		$this->assertEquals($this->VALID_SPECIES_PHOTO_URL, $testBird->getSpeciesPhotoUrl());
	}

	public function testGetSpeciesByComName() {
		// Get row count
		$baseRowCount = $this->getConnection()->getRowCount("species");

		// Create new test bird
		$testBird = new BirdSpecies($this->VALID_SPECIES_ID, $this->VALID_SPECIES_CODE, $this->VALID_SPECIES_COM_NAME, $this->VALID_SPECIES_SCI_NAME, $this->VALID_SPECIES_PHOTO_URL);

		// Insert test bird
		$testBird->insert($this->getPDO());

		// Confirm test bird was inserted
		$this->assertEquals($baseRowCount + 1, $this->getConnection()->getRowCount("species"));

		// Test the values coming from the database
		$this->assertEquals($this->VALID_SPECIES_ID, $testBird->getSpeciesId());
		$this->assertEquals($this->VALID_SPECIES_CODE, $testBird->getSpeciesCode());
		$this->assertEquals($this->VALID_SPECIES_COM_NAME, $testBird->getSpeciesComName());
		$this->assertEquals($this->VALID_SPECIES_SCI_NAME, $testBird->getSpeciesSciName());
		$this->assertEquals($this->VALID_SPECIES_PHOTO_URL, $testBird->getSpeciesPhotoUrl());
	}
}