-- sets collation of database to utf8
ALTER DATABASE PEEPS CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--dropping and re-adding tables to prevent errors

DROP TABLE IF EXISTS FavoriteBirdList

-- Note that the table FavoriteBirdlist contains two foreign keys, each from a different
-- table that must be created first. These tables are User and BirdSpecies
CREATE TABLE FavoriteBirdList (
birdFavoriteBirdSpeciesId
birdFavoriteUserId
 )