DROP TABLE IF EXISTS sighting;

create table sighting (
	sightingId BINARY (16) NOT NULL,
	sightingUserProfileId BINARY (16) NOT NULL,
	sightingSpeciesId BINARY (16) NOT NULL,
	sightingBirdPhoto VARCHAR (128) NULL,
	sightingDateTime DATETIME (6) NOT NULL,
	sightingLocX FLOAT (6, 3) NOT NULL,
	sightingLocY FLOAT (6, 3) NOT NULL,


	unique(sightingId),
	primary key(sightingId),
	foreign key(sightingUserProfileId) REFERENCES userProfile(userProfileId),
	foreign key(sightingSpeciesId) REFERENCES species(speciesId)
);
