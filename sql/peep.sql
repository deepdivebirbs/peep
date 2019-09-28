/* ONLY RUN ONCE THIS LINE DELETES THE CURRENT TABLE AND REMAKES IT!! */
DROP DATABASE peep;
CREATE DATABASE peep;
USE peep;
ALTER DATABASE peep CHARACTER SET utf8;

DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS sighting;
DROP TABLE IF EXISTS species;
DROP TABLE IF EXISTS userProfile;

create table userProfile(
	userProfileId BINARY(16) NOT NULL,
	userProfileName VARCHAR(32) NOT NULL,
	userProfileFirstName VARCHAR(32) NOT NULL,
	userProfileLastName VARCHAR(32) NOT NULL,
	userProfileEmail VARCHAR(128) NOT NULL,
	userProfileAuthenticationToken CHAR(32) NULL,
	userProfileHash CHAR(97) NOT NULL,
	PRIMARY KEY (userProfileId),
	unique (userProfileName)
);

CREATE TABLE species(
	speciesId BINARY(16) NOT NULL,
	speciesCode VARCHAR(8) NOT NULL,
	speciesComName VARCHAR(64) NULL,
	speciesSciName VARCHAR(64) NULL,
	speciesPhotoUrl VARCHAR(128) NULL,
	PRIMARY KEY (speciesId)
);

CREATE TABLE sighting (
	sightingId BINARY (16) NOT NULL,
	sightingUserProfileId BINARY (16) NOT NULL,
	sightingBirdSpeciesId BINARY (16) NOT NULL,
	sightingBirdPhoto VARCHAR (128) NULL,
	sightingDateTime DATETIME (6) NOT NULL,
	sightingLocX FLOAT (6, 3) NOT NULL,
	sightingLocY FLOAT (6, 3) NOT NULL,
	unique(sightingId),
	PRIMARY KEY(sightingId),
	FOREIGN KEY(sightingUserProfileId) REFERENCES userProfile(userProfileId),
	FOREIGN KEY(sightingBirdSpeciesId) REFERENCES species(speciesId)
);

-- NOTe that the table FavoriteBirdlist contains two FOREIGN KEYs, each from a different
-- table that must be created first. These tables are User and BirdSpecies, and the relationship is
CREATE TABLE favorite (
	favoriteSpeciesId BINARY(16) NOT NULL,
	favoriteUserProfileId BINARY (16) NOT NULL,
	-- creates index before making FOREIGN KEYs--
	INDEX (favoriteSpeciesId),
	INDEX (favoriteUserProfileId),
	-- creates FOREIGN KEY relations
	FOREIGN KEY (favoriteSpeciesId) REFERENCES species(speciesId),
	FOREIGN KEY (favoriteUserProfileId) REFERENCES userProfile(userProfileId),
	-- creates a  composite FOREIGN KEY with the two FOREIGN KEYs that depend on speciesId and userID
	PRIMARY KEY (favoriteSpeciesId, favoriteUserProfileId)
);