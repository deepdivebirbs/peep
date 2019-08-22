ALTER DATABASE peep CHARACTER SET utf8 COLLATE utf8_unicode_cli;

/* ONLY RUN ONCE THIS LINE DELETES THE CURRENT TABLE AND REMAKES IT!! */

DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS sighting;
DROP TABLE IF EXISTS species;
DROP TABLE IF EXISTS userProfile;

create table userProfile(
	userProfileId binary(16) not null,
	userProfileName varchar(32) not null,
	userProfileFirstName varchar(32) not null,
	UserProfileLastName varchar(32) not null,
	userProfileEmail varchar(128) not null,
	userProfileAuthenticationToken char(32) not null,
	userProfileHash char(97) not null,
	primary key (userProfileId),
	unique (userProfileName)
);

CREATE TABLE species(
	speciesId BINARY(16) NOT NULL,
	speciesCode VARCHAR(6) NOT NULL,
	speciesComName VARCHAR(64) NULL,
	speciesSciName VARCHAR(64) NULL,
	speciesPhotoUrl VARCHAR(128) NULL,
	PRIMARY KEY (speciesId)
);

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

-- Note that the table FavoriteBirdlist contains two foreign keys, each from a different
-- table that must be created first. These tables are User and BirdSpecies, and the relationship is
CREATE TABLE favorite (
	favoriteSpeciesId BINARY(16) NOT NULL,
	favoriteUserProfileId BINARY (16) NOT NULL,
	-- creates index before making foreign keys--
	INDEX (favoriteSpeciesId),
	INDEX (favoriteUserProfileId),
	-- creates foreign key relations
	FOREIGN KEY (favoriteSpeciesId) REFERENCES species(speciesId),
	FOREIGN KEY (favoriteUserProfileId) REFERENCES userProfile(userProfileId),
	-- creates a  composite foreign key with the two foreign keys that depend on speciesId and userID
	PRIMARY KEY (favoriteSpeciesId, favoriteUserProfileId)
);