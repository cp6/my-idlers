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

ALTER TABLE `servers`
    ADD COLUMN `has_st` TINYINT(1) NULL DEFAULT '0' AFTER `has_yabs`;

UPDATE servers t1
    JOIN
    (
        SELECT server_id
        FROM speed_tests
        GROUP BY server_id
        HAVING COUNT(*) > 0
    ) t2
    ON t1.id = t2.server_id
SET t1.has_st = 1;

ALTER TABLE `servers`
    CHANGE COLUMN `bandwidth` `bandwidth` FLOAT NULL DEFAULT NULL AFTER `disk_type`;