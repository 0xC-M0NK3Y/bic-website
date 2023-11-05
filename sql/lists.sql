
CREATE TABLE `wish_list`(

	`account_id`	INT UNSIGNED NOT NULL,
	`pen_id`		INT UNSIGNED NOT NULL

);
CREATE INDEX `idx_account_pen` ON `wish_list`(`account_id`,`pen_id`);

CREATE TABLE `got_list`(

	`account_id`	INT UNSIGNED NOT NULL,
	`pen_id`		INT UNSIGNED NOT NULL

);
CREATE INDEX `idx_account_pen` ON `got_list`(`account_id`,`pen_id`);
