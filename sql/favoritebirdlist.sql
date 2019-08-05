-- sets collation of database to utf8
CREATE DATABASE peep CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- dropping and re-adding tables to prevent errors. this should only be done once, at the beginning of the project!

DROP TABLE IF EXISTS favoriteBirdList;

-- Note that the table FavoriteBirdlist contains two foreign keys, each from a different
-- table that must be created first. These tables are User and BirdSpecies, and the relationship is
CREATE TABLE favoriteBirdList (
	birdFavoriteUserId BINARY(16) NOT NULL,
   birdFavoriteSpeciesCode VARCHAR(6) NOT NULL,
		-- creates index before making foreign keys--
	INDEX (birdFavoriteUserId),
	INDEX (birdFavoriteSpeciesCode),
	-- creates foreign key relations
	FOREIGN KEY (birdFavoriteUserId) REFERENCES userProfile(userId),
	FOREIGN KEY (birdFavoriteSpeciesCode) REFERENCES birdSpecies(speciesCode),
	-- creates a  composite foreign key with the two foreign keys that depend on speciesId and userID
	PRIMARY KEY (birdFavoriteSpeciesCode, birdFavoriteUserId)
 );

DROP TABLE IF EXISTS favoriteBirdList;


CREATE TABLE favoriteBirdList (
	birdFavoriteUserId BINARY(16) NOT NULL,
	birdFavoriteSpeciesCode VARCHAR(6) NOT NULL,
	INDEX (birdFavoriteUserId),
	INDEX (birdFavoriteSpeciesCode),
	FOREIGN KEY (birdFavoriteUserId) REFERENCES userProfile(userId),
	FOREIGN KEY (birdFavoriteSpdeciesCode) REFERENCES birdSpecies(speciesCode),
	PRIMARY KEY (birdFavoriteSpeciesCode, birdFavoriteUserId)
);
