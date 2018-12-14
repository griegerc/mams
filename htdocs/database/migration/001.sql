SET FOREIGN_KEY_CHECKS = 0;
SET AUTOCOMMIT = 0;
START TRANSACTION;

CREATE TABLE `measureTypes` (
    `measureTypeId` SMALLINT unsigned NOT NULL AUTO_INCREMENT,
    `measureKey` CHAR(32) NOT NULL,
    `gameId` TINYINT unsigned NOT NULL,
        PRIMARY KEY (`measureTypeId`),
        KEY `measureKey` (`gameId`, `measureKey`)
) ENGINE=InnoDB;

CREATE TABLE `measureData` (
    `dataId` INT unsigned NOT NULL AUTO_INCREMENT,
    `dataTime` INT UNSIGNED NOT NULL,
    `measureTypeId` SMALLINT unsigned NOT NULL,
    `value` SMALLINT NOT NULL,
        PRIMARY KEY (`dataId`),
        KEY `measureTypeId` (`measureTypeId`),
        CONSTRAINT `measureData_ibfk_1`
            FOREIGN KEY (`measureTypeId`)
            REFERENCES `measureTypes` (`measureTypeId`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;