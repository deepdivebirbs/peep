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










}