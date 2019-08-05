drop table if exists userProfile;

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
)