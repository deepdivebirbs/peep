<?php


namespace Birbs\Peep\Test;
use Birbs\Peep\Favorite;
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};

require_once("PeepTest.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");

//gets class under scrutiny
require_once(dirname(__DIR__, 1) . "/autoload.php");

//gets uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * full PHPUnit test for the Favorite class
 *
 * All mySQL/PDO enabled methods are tested for both valid and invalid outputs
 *
 * @see Favorite
 **/

class FavoriteTest extends PeepTest {

	/**
	 * Profile that added the favorite bird; used for foreign key relations
	 * @var UserProfile $userProfile;
	 */
	protected $userProfile;

	/**
	 * bird that was saved; used for foreign key relations
	 * @var Species $species
	 */
	protected $species;

	/**
	 * Valid hash to use to create mock userProfile to us in the test
	 */
	protected $VALID_UserProfileHash;

	/**
	 * Valid userProfileAuthentication token to create a mock userProfile
	 */
	protected $VALID_UserProfileAuthenticationToken;

	/**
	 * create dependent objects before running text
	 */

	public final function setUp() : void {
		//run default setUp () method first
		parent::setUp();

		//create a salt and hash for mocked profile
		$password = "abc123";
		$this->VALID_UserProfileHash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_UserProfileAuthenticationToken = bin2hex(random_bytes(16));

		//create and insert mocked profile
		$this->userProfile = new UserProfile(generateUuidV4(), "kewlbirdz", "Pam", "Beesley", "beesley@dundermifflin.com", null, $this->VALID_UserProfileHash);
		$this->userProfile->insert($this->getPDO());

		//create and insert mocked species
		$this->species = new Species(generateUuidV4(), "123456", "Roadrunner", "Geococcyx californianus", "birdphotos.com/roadrunner");
		$this->species->insert($this->getPDO());
	}

	/**
	 * test inserting valid Favorite and verify that the actual mySQL data matches
	 */

	public function testInsertValidFavorite() : void {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//create a new favorite and insert it into the table
		$favorite = new Favorite($this->userProfile->getUserProfileId(), $this->species->getSpeciesId());
		$favorite->insert($this->getPDO());

		//grab data from mySQL and enforce fields matching our expectations
		$pdoFavorite = Favorite::getFavoritebyFavoriteUserProfileIdAndFavoriteSpeciesId($this->getPDO(), $this->userProfile > getUserProfileID(), $this->species->getSpeciesId());
		$this->assertEquals($numRows + 1, $this->getPDO(), $this->userProfile->getUserProfileId(), $this->species->getSpeciesId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteUserProfileId(), $this->userProfile->getUserProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteSpeciesId(), $this->species->getSpeciesId());
	}

	/**
	 * test creating a favorite then deleting it
	 */
	public function testDeleteValidFavorite() : void {
		//counts the number of rows for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//creates a new favorite for insertion into mySQL
		$favorite= new Favorite($this->userProfile->getUserProfileId(), $this->speciesId->getSpeciesId());
		$favorite->insert($this->getPDO());

		//delete the favorite from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$favorite->delete($this->getPDO());

		//grab the data from mySQL and enforce the Favorite doesn't exit
		$pdoFavorite = Favorite::getFavoritebyFavoriteUserProfileIdAndFavoriteSpeciesId($this->getPDO(), $this->userProfile->getUserProfileId(), $this->species->getSpeciesId());
		$this->assertNull($pdoFavorite);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("favorite"));
	}

	/**
	 * test inserting a Favorite and regrabbing it from mySQL
	 */
	public function testGetValidFavoriteByUserProfileIdAndSpeciesId() : void {
		//count number of rows and safe for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//create a new favorite and insert it into mySQL
		$favorite=new Favorite ($this->userProfile->getUserProfileId(), $this->species->getSpeciesId());
		$favorite->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteUserProfileIdAndFavoriteSpeciesId($this->getPDO(), $this->userProfile > getUserProfileID(), $this->species->getSpeciesId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteUserProfileId(),$this->userProfile->getUserProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteSpeciesId(), $this->species->getSpeciesId());
	}

	/**
	 * test grabbing a favorite that does not exist
	 */
	public function testGetInvalidFavoriteByUserProfileIdAndSpeciesId () {
		//grab a user profile id and a species id that exceeds the maximum allowable user profile id and species id
		$favorite = Favorite::getFavoriteByFavoriteUserProfileIdAndFavoriteSpeciesId($this->getPDO(), generateUuidV4(), generateUuidV4());
		$this->assertNull($favorite);
	}

	/**
	 * test grabbing a favorite by userProfileId
	 */
	public function testGetValidFavoriteByUserProfileId (): void {
		//count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//create a new Favorite and insert into mySQL
		$favorite = new Favorite ($this->userProfile->getUserProfileId(), $this->speciesId->getSpeciesId());
		$favorite->insert($this->getPDO());

		//grab the data from mySQL and enforce that the fields match our expectations
		$results = Favorite::getAllFavoriteByUserProfileId($this->getPDO(), $this->userProfile->getUserProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);

		//enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Birbs\\Peep\\Favorite", $results);

		//grab the reslt from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteUserProfileId(), $this->userProfile->getUserProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteSpeciesId(), $this->species->getSpeciesId());
	}



}