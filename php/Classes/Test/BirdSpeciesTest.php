<?php

namespace Birbs\Peep\Test;

require_once("PeepTest.php");

// Guess unit test classes don't have a __construct()?

class BirdSpeciesTest extends PeepTest {
    // Create the test values.

    /**
     * A UUID that identifies a bird species in the database.
     * 
     * @var Uuid validSpeciesId
     */
    protected validSpeciesId = "2ae7ea43-c430-4e8f-96f1-f10727bc809f";

    /**
     * A string that represents the given code to a bird species from the Ebirds API.
     * 
     * @var string validSpeciesCode
     */
    protected validSpeciesCode = "123ABC";

    /**
     * A string that is the common non-scientific name of a bird species.
     * 
     * @var string validSpeciesComName
     */
    protected validSpeciesCode = "Pinyon Jay";

    /**
     * A string that is the given scientific name for a bird species.
     * 
     * @var string validScientificName
     */
    protected validScientificName = "Gymnorhinus cyanocephalus";

    /**
     * A string that is the URL for a bird species photo.
     * 
     * @var string validSpeciesPhotoUrl
     */
    protected validSpeciesPhotoUrl = "https://ebird.org/species/pinjay";

    // Do I test each function going down the list?

    /**
     * Create a dependent set of objects before starting the test.
     */
    public function setUp(): void {
        parent::setUp();
        
    }


}