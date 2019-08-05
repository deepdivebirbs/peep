/**
* This is the table where user-submitted bird sightings will be stored.
**/

DROP TABLE IF EXISTS birdSighting;

create table birdSighting (
	sightingId BINARY (16) NOT NULL,
	birdSightingUserProfileId BINARY (16) NOT NULL,
	birdSightingSpeciesCode VARCHAR (6) NOT NULL,
	commonName VARCHAR (64) NULL,
	sciName VARCHAR (64),
	latitudeX FLOAT (6, 3) NOT NULL,
	longitudeY FLOAT (6, 3) NOT NULL,
	dateTime DATETIME (19) NOT NULL,
	birdPhoto VARCHAR (128) NULL,
	unique(sightingId),
	primary key(sightingId),
	foreign key(birdSightingUserProfileId),
	foreign key(birdSightingSpeciesCode)
)
