/*
Created: 11/09/2023
Modified: 11/09/2023
Model: MySQL 8.0
Database: MySQL 8.0
*/

-- Create tables section -------------------------------------------------

-- Table Uporabniki

CREATE TABLE `Uporabniki`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `ime` Varchar(250) NOT NULL,
  `priimek` Varchar(250) NOT NULL,
  `email` Varchar(250) NOT NULL,
  `geslo` Varchar(250) NOT NULL,
  `admin` Bool NOT NULL DEFAULT 0,
  `telefon` Varchar(20),
  `kraj_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship2` ON `Uporabniki` (`kraj_id`)
;

-- Table Kraji

CREATE TABLE `Kraji`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `kraj` Varchar(250) NOT NULL,
  `postna_st` Varchar(10) NOT NULL,
  `kratica` Char(250),
  `drzava_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship1` ON `Kraji` (`drzava_id`)
;

-- Table Drzave

CREATE TABLE `Drzave`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `drzava` Varchar(250) NOT NULL,
  `kratica` Varchar(250),
  PRIMARY KEY (`id`)
)
;

-- Table Oglasi

CREATE TABLE `Oglasi`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `naslov` Varchar(250) NOT NULL,
  `opis` Text,
  `uporabnik_id` Int,
  `slika_id` Int,
  `kategorija_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship3` ON `Oglasi` (`uporabnik_id`)
;

CREATE INDEX `IX_Relationship4` ON `Oglasi` (`slika_id`)
;

CREATE INDEX `IX_Relationship6` ON `Oglasi` (`kategorija_id`)
;

-- Table Slike

CREATE TABLE `Slike`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `slika` Varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
)
;

-- Table Kategorije

CREATE TABLE `Kategorije`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `kategorija` Varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
)
;

-- Create foreign keys (relationships) section -------------------------------------------------

ALTER TABLE `Kraji` ADD CONSTRAINT `Relationship1` FOREIGN KEY (`drzava_id`) REFERENCES `Drzave` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Uporabniki` ADD CONSTRAINT `Relationship2` FOREIGN KEY (`kraj_id`) REFERENCES `Kraji` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Oglasi` ADD CONSTRAINT `Relationship3` FOREIGN KEY (`uporabnik_id`) REFERENCES `Uporabniki` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Oglasi` ADD CONSTRAINT `Relationship4` FOREIGN KEY (`slika_id`) REFERENCES `Slike` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Oglasi` ADD CONSTRAINT `Relationship6` FOREIGN KEY (`kategorija_id`) REFERENCES `Kategorije` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;


