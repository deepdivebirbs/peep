<?php
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\Codec\StringCodec;

function generateUuidV4(): UuidInterface {
	try {
		$factory = new UuidFactory();
		$codec = new StringCodec($factory->getUuidBuilder());
		$factory->setCodec($codec);
		$uuid = $factory->uuid4();
		return ($uuid);
	} catch(Exception $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}