CREATE TABLE uhqgeolocate_v4cache (
	ipaddr			INT UNSIGNED,
	hits			INT UNSIGNED,
	countrycode		CHAR(2),
	region			VARCHAR(128),
	city			VARCHAR(128),
	latitude		DOUBLE,
	longitude		DOUBLE,
	isp				VARCHAR(128),
	org				VARCHAR(128),
	PRIMARY KEY (ipaddr)
) ENGINE=MyISAM;