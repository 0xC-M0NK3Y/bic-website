
CREATE TABLE `accounts` (

	`id`			INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,

	`username`		VARCHAR(255)	UNIQUE NOT NULL,
	`password`		CHAR(60)		NOT NULL,
	`email`			VARCHAR(255)	UNIQUE NOT NULL,
	`creation_date`	DATETIME		NOT NULL DEFAULT NOW(),
	`updated_at`	DATETIME		NOT NULL DEFAULT NOW(),
	`creation_ip`	VARCHAR(255)	NOT NULL
);
