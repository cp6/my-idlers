CREATE TABLE IF NOT EXISTS `auth`
(
    `user`        varchar(64) NOT NULL,
    `pass`        varchar(255) DEFAULT NULL,
    `token`       char(32)     DEFAULT NULL,
    `login_count` int(11)      DEFAULT 0,
    `login_fails` int(11)      DEFAULT 0,
    `last_login`  datetime     DEFAULT NULL,
    `last_fail`   datetime     DEFAULT NULL,
    PRIMARY KEY (`user`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS `login_attempts`
(
    `user`     varchar(124) DEFAULT NULL,
    `ip`       varchar(124) DEFAULT NULL,
    `datetime` datetime     DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;