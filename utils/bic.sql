CREATE DATABASE bic_db;

USE bic_db;

CREATE TABLE `pen` (
	`id`	INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,

	-- `name`				VARCHAR(255)		NOT NULL,
	`tag`				VARCHAR(255)		NOT NULL,
	`body`				VARCHAR(255)		NOT NULL,
	`image`				BLOB				NOT NULL,
	`tube_color`		VARCHAR(255)		NOT NULL,
	`tube_finition`		VARCHAR(255)		NOT NULL,
	`ring`				VARCHAR(255)		NOT NULL,
	`top`				VARCHAR(255)		NOT NULL,
	`colors`			VARCHAR(255)		NOT NULL,
	`thick`				VARCHAR(255)		NOT NULL,
	`price`				FLOAT UNSIGNED		NOT NULL,
	`rarity`			TINYINT UNSIGNED	NOT NULL,

	`comments`			TEXT
);
