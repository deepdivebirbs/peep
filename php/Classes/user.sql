drop table if exists userProfile;

create table userProfile(
	userId binary(16) not null,
	userName varchar(32) not null,
	firstName varchar(32) not null,
	lastName varchar(32) not null,
	userEmail varchar(128) not null,
	userAuthenticationToken char(32) not null,
	userHash char(97) not null,
	primary key (userId),
	unique (userName)
)