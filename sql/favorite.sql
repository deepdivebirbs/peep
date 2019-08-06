-- sets collation of database to utf8
CREATE DATABASE peep CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- dropping and re-adding tables to prevent errors. this should only be done once, at the beginning of the project!

DROP TABLE IF EXISTS favorite;

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

-- DROP TABLE IF EXISTS favorite;
-- CREATE TABLE favorite (
-- 	favoriteSpeciesId BINARY(16) NOT NULL,
--    favoriteUserProfileId BINARY (16) NOT NULL,
-- 	INDEX (favoriteSpeciesId),
-- 	INDEX (favoriteUserProfileId),
-- 	FOREIGN KEY (favoriteSpeciesId) REFERENCES species(speciesId),
-- 	FOREIGN KEY (favoriteUserProfileId) REFERENCES userProfile(userProfileId),
-- 	PRIMARY KEY (favoriteSpeciesId, favoriteUserProfileId)
--  );
