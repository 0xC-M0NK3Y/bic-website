USE bic_db;

DROP TABLE pen;

CREATE TABLE `pen` (
	`pos`				INT UNSIGNED AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
	`family`			VARCHAR(255)		NOT NULL,
	`name`				VARCHAR(255)		NOT NULL,
	`image`				BLOB				NOT NULL,
	`tube_color`		VARCHAR(255)		NOT NULL,
	`tube_finish`		VARCHAR(255)		NOT NULL,
	`ring_color`		VARCHAR(255)		NOT NULL,
	`top`				VARCHAR(255)		NOT NULL,
	`ink_colors`		VARCHAR(255)		NOT NULL,
	`thickness`			VARCHAR(255)		NOT NULL,
	`price`				FLOAT UNSIGNED		NOT NULL,
	`rarity`			TINYINT UNSIGNED	NOT NULL,
	`tag`				VARCHAR(255)		NOT NULL,

	`id`				INT UNSIGNED 		NOT NULL UNIQUE,

	`comments`			VARCHAR(512),
	`latitude`			DECIMAL(10,6),
	`longitude`			DECIMAL(10,6)
);
