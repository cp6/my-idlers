ALTER TABLE `servers`
    ADD COLUMN `asn` VARCHAR(124) NULL DEFAULT NULL AFTER `notes`;