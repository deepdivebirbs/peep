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

class UserProfileTest extends DataDesignTest {

	protected $VALID_profileId;
	protected $VALID_AUTHENTICATION;
	protected $VALID_profileEmail;
	protected $VALID_profileFirstName;
	protected $VALID_HASH; //This one in particular will need development
	protected $VALID_profileLastName;
	protected $VALID_profileName;

	/**
	 * run the default setup operation to create salt and hash.
	 */
	public final function setUp() : void {
		parent::setUp();
		//
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_AUTHENTICATION = bin2hex(random_bytes(16));
	}





}