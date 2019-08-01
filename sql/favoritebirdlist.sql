-- sets collation of database to utf8
ALTER DATABASE peep CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- dropping and re-adding tables to prevent errors

DROP TABLE IF EXISTS FavoriteBirdList;

-- Note that the table FavoriteBirdlist contains two foreign keys, each from a different
-- table that must be created first. These tables are User and BirdSpecies, and the relationship is
CREATE TABLE FavoriteBirdList (
	birdFavoriteSpeciesCode CHAR(32) NOT NULL,
	birdFavoriteUserId BINARY (16) NOT NULL,
	-- creates index becfore making foreign keys--
	INDEX (birdFavoriteSpeciesCode),
	INDEX (birdFavoriteUserId),
	-- creates foreign key relations
	FOREIGN KEY (birdFavoriteSpeciesCode) REFERENCES birdSpecies(speciesCode),
	FOREIGN KEY (birdFavoriteUserId) REFERENCES user(userId),
	-- creates a  composite foreign key with the two foreign keys that depend on speciesId and userID
	PRIMARY KEY (birdFavoriteSpeciesCode, birdFavoriteUserId)
 );