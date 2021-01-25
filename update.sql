ALTER TABLE `disk_speed`
    ADD COLUMN `datetime` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `1m_as_mbps`;

ALTER TABLE `servers`
    ADD COLUMN `ssh_port` INT(11) NULL DEFAULT '22' AFTER `os`;

ALTER TABLE `servers`
    ADD COLUMN `notes` VARCHAR(255) NULL DEFAULT NULL AFTER `tags`;

ALTER TABLE `disk_speed`
    DROP PRIMARY KEY;

ALTER TABLE `disk_speed`
    ADD UNIQUE INDEX `Index 1` (`server_id`, `datetime`);