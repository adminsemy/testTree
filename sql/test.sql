-- Valentina Studio --
-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE TABLE "comments" -------------------------------------
CREATE TABLE `comments` ( 
	`id` Int( 255 ) AUTO_INCREMENT NOT NULL,
	`parent_id` Int( 255 ) NULL,
	`topic_id` Int( 255 ) NULL,
	`body` VarChar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`created_at` DateTime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY ( `id` ),
	CONSTRAINT `unique_id` UNIQUE( `id` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 9;
-- -------------------------------------------------------------


-- CREATE TABLE "posts" ----------------------------------------
CREATE TABLE `posts` ( 
	`id` Int( 255 ) AUTO_INCREMENT NOT NULL,
	`text` VarChar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	PRIMARY KEY ( `id` ),
	CONSTRAINT `unique_id` UNIQUE( `id` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 2;
-- -------------------------------------------------------------


-- Dump data of "comments" ---------------------------------
INSERT INTO `comments`(`id`,`parent_id`,`topic_id`,`body`,`created_at`) VALUES 
( '1', '0', '1', 'Answer to first comment', '2020-10-02 10:37:09' ),
( '2', '1', '1', 'Test child comment', '2020-10-02 10:37:34' ),
( '3', '0', '1', 'ÐŸÑ€Ð¾Ð²ÐµÑ€ÐºÐ° Ð²ÑÑ‚Ð°Ð²ÐºÐ¸ ÐºÐ¾Ð¼Ð¼ÐµÐ½Ñ‚Ð°Ñ€Ð¸Ñ Ð½Ð° Ñ€ÑƒÑÑÐºÐ¾Ð¼ ÑÐ·Ñ‹ÐºÐµ', '2020-10-02 10:37:59' ),
( '4', '3', '1', 'ÐžÑ‚Ð²ÐµÑ‚  Ð½Ð° Ñ€ÑƒÑÑÐºÐ¾Ð¼', '2020-10-02 10:48:42' ),
( '5', '4', '1', 'ÐŸÐ¾Ð¿Ñ‹Ñ‚ÐºÐ° Ð²ÑÑ‚Ð°Ð²Ð¸Ñ‚ÑŒ Ñ‚ÐµÐ³Ð¸ Ð¸Ð»Ð¸ ÑÐºÑ€Ð¸Ð¿Ñ‚ &lt;h1&gt;ÐŸÑ€Ð¾Ð²ÐµÑ€ÐºÐ° &lt;/h1&gt;', '2020-10-02 10:49:17' );
-- ---------------------------------------------------------


-- Dump data of "posts" ------------------------------------
INSERT INTO `posts`(`id`,`text`) VALUES 
( '1', 'My first text' );
-- ---------------------------------------------------------


-- CREATE INDEX "lnk_posts_comments" ---------------------------
CREATE INDEX `lnk_posts_comments` USING BTREE ON `comments`( `topic_id` );
-- -------------------------------------------------------------


-- CREATE LINK "lnk_posts_comments" ----------------------------
ALTER TABLE `comments`
	ADD CONSTRAINT `lnk_posts_comments` FOREIGN KEY ( `topic_id` )
	REFERENCES `posts`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------


