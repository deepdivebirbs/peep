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
    protected validSpeciesId;

    /**
     * A string that represents the given code to a bird species from the Ebirds API.
     * 
     * @var string validSpeciesCode
     */
    protected validSpeciesCode;

    /**
     * A string that is the common non-scientific name of a bird species.
     * 
     * @var string validSpeciesComName
     */
    protected validSpeciesCode;

    /**
     * A string that is the given scientific name for a bird species.
     * 
     * @var string validScientificName
     */
    protected validScientificName;

    /**
     * A string that is the URL for a bird species photo.
     * 
     * @var string validSpeciesPhotoUrl
     */
    protected validSpeciesPhotoUrl;


}