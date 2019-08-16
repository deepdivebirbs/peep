<?php

namespace Birbs\Peep\Test;

use Birbs\Peep\BirdSpecies;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};
use Ramsey\Uuid\Uuid;

require_once("PeepTest.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once(dirname(__DIR__, 1) . "/autoload.php");

// Guess unit test classes don't have a __construct()?

class BirdSpeciesTest extends PeepTest {
	// Create the test values.

	/**
	 * A UUID that identifies a bird species in the database.
	 *
	 * @var Uuid validSpeciesId
	 */
	protected $VALID_SPECIES_ID = "2ae7ea43-c430-4e8f-96f1-f10727bc809f";

	/**
	 * A string that represents the given code to a bird species from the Ebirds API.
	 *
	 * @var string validSpeciesCode
	 */
	protected $VALID_SPECIES_CODE = "123ABC";

	/**
	 * A string that is the common non-scientific name of a bird species.
	 *
	 * @var string validSpeciesComName
	 */
	protected $VALID_SPECIES_COM_NAME = "Pinyon Jay";

	/**
	 * A string that is the given scientific name for a bird species.
	 *
	 * @var string validScientificName
	 */
	protected $VALID_SPECIES_SCI_NAME = "Gymnorhinus cyanocephalus";

	/**
	 * A string that is the URL for a bird species photo.
	 *
	 * @var string validSpeciesPhotoUrl
	 */
	protected $VALID_SPECIES_PHOTO_URL = "https://ebird.org/species/pinjay";


	// Do I test each function going down the list?

	/**
	 * Creates all of the objects to build the class object
	 */
	public function setUp(): void {
		parent::setUp();
	}

	/**
	 * @throws \Exception
	 * @returns void
	 */
	public function testSpeciesInsert(): void {

		// Get rows for some reason
		$rowCount = $this->getConnection()->getRowCount("birdSpecies");

		// Create new BirdSpecies object and insert it into the database
		$testSpecies = new BirdSpecies($this->VALID_SPECIES_ID, $this->VALID_SPECIES_CODE, $this->VALID_SPECIES_COM_NAME, $this->VALID_SPECIES_SCI_NAME, $this->VALID_SPECIES_PHOTO_URL);

		// Insert object into the table
		$testSpecies->insert($this->getPDO());

		$pdoBird = $testSpecies->getSpeciesBySpeciesId($this->getPDO(), $testSpecies->getSpeciesId());

		// Check if a row was indeed added to the table
		$this->assertEquals($rowCount + 1, $this->getConnection()->getRowCount("birdSpecies"));

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

		$testSpecies->delete($this->getPDO());
	}

	public function testSpeciesUpdate() {
		// Get row count for some reason
		$rowCount = $this->getConnection()->getRowCount("birdSpecies");

		// Create new BirdSpecies and inert it.
		$testSpecies = new BirdSpecies($this->VALID_SPECIES_ID, $this->VALID_SPECIES_CODE, $this->VALID_SPECIES_COM_NAME, $this->VALID_SPECIES_SCI_NAME, $this->VALID_SPECIES_PHOTO_URL);
		$testSpecies->insert($this->getPDO());

		// Set updated data for $testSpecies.
		$updatedComName = "Some Bird";

		// Edit common name
		$testSpecies->setSpeciesComName($updatedComName);

		// Update the database
		$testSpecies->update($this->getPDO());

		// Get inserted BirdSpecies
		$pdoBird = $testSpecies->getSpeciesBySpeciesId($this->getPDO(), $this->VALID_SPECIES_ID);

		// Compare all of the values.
		$this->assertEquals($rowCount + 1, $this->getConnection()->getRowCount("birdSpecies"));
		$this->assertEquals($pdoBird->getSpeciesId(), $this->VALID_SPECIES_ID);
		$this->assertEquals($pdoBird->getSpeciesCode(), $this->VALID_SPECIES_CODE);
		$this->assertEquals($pdoBird->getSpeciesComName(), $this->VALID_SPECIES_COM_NAME);
		$this->assertEquals($pdoBird->getSpeciesSciName(), $this->VALID_SPECIES_SCI_NAME);
		$this->assertEquals($pdoBird->getSpeciesPhotoUrl(), $this->VALID_SPECIES_PHOTO_URL);

		$testSpecies->delete($this->getPDO());
	}

	/*
	 * Unit test for my delete method in BirdSpecies
	 */
	public function testSpeciesDelete(): void {
		// Get the row count to compare later
		$rowCount = $this->getConnection()->getRowCount("birdSpecies");

		// Create new BirdSpecies
		$testSpecies = new BirdSpecies($this->VALID_SPECIES_ID, $this->VALID_SPECIES_CODE, $this->VALID_SPECIES_COM_NAME, $this->VALID_SPECIES_SCI_NAME, $this->VALID_SPECIES_PHOTO_URL);

		// Insert BirdSpecies into the table
		$testSpecies->insert($this->getPDO());

		// Check to see if the number of rows increased.
		$this->assertEquals($rowCount + 1, $this->getConnection()->getRowCount("birdSpecies"));

		// Delete BirdSpecies
		$testSpecies->delete($this->getPDO());

		// Try to grab the deleted entry, hopefully it fails.
		$testBirdGrab = $testSpecies->getSpeciesBySpeciesId($this->getPDO(), $this->VALID_SPECIES_ID);

		// Check if $testBirdGrab is NULL
		$this->assertNull($testBirdGrab);

		// Check if is deleted
		$this->assertEmpty($rowCount, $this->getConnection()->getRowCount("birdSpecies"));
	}
/*
	public function testGetBirdBySpeciesId(): void {

	}
*/
}