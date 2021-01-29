/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;


-- Dumping database structure for my_idlers
CREATE DATABASE IF NOT EXISTS `idlers` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `idlers`;

-- Dumping structure for table my_idlers.disk_speed
CREATE TABLE IF NOT EXISTS `disk_speed`
(
    `server_id`    char(8)  NOT NULL,
    `4k`           float             DEFAULT NULL,
    `4k_type`      char(4)           DEFAULT NULL,
    `4k_as_mbps`   float             DEFAULT NULL,
    `64k`          float             DEFAULT NULL,
    `64k_type`     char(4)           DEFAULT NULL,
    `64k_as_mbps`  float             DEFAULT NULL,
    `512k`         float             DEFAULT NULL,
    `512k_type`    char(4)           DEFAULT NULL,
    `512k_as_mbps` float             DEFAULT NULL,
    `1m`           float             DEFAULT NULL,
    `1m_type`      char(4)           DEFAULT NULL,
    `1m_as_mbps`   float             DEFAULT NULL,
    `datetime`     datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `Index 1` (`server_id`, `datetime`)
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

-- Dumping data for table my_idlers.disk_speed: ~0 rows (approximately)
/*!40000 ALTER TABLE `disk_speed`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `disk_speed`
    ENABLE KEYS */;

-- Dumping structure for table my_idlers.domains
CREATE TABLE IF NOT EXISTS `domains`
(
    `id`          char(8) NOT NULL,
    `attached_to` char(8)      DEFAULT NULL,
    `domain`      varchar(124) DEFAULT NULL,
    `provider`    int(11)      DEFAULT NULL,
    `ns1`         varchar(124) DEFAULT NULL,
    `ns2`         varchar(124) DEFAULT NULL,
    `still_have`  tinyint(1)   DEFAULT '1',
    `owned_since` date         DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `Index 2` (`domain`)
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

-- Dumping data for table my_idlers.domains: ~0 rows (approximately)
/*!40000 ALTER TABLE `domains`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `domains`
    ENABLE KEYS */;

-- Dumping structure for table my_idlers.locations
CREATE TABLE IF NOT EXISTS `locations`
(
    `id`   int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(124) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `Index 2` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

-- Dumping data for table my_idlers.locations: ~83 rows (approximately)
/*!40000 ALTER TABLE `locations`
    DISABLE KEYS */;
INSERT INTO `locations` (`id`, `name`)
VALUES (1, 'Adelaide, Australia'),
       (2, 'Amsterdam, Netherlands'),
       (3, 'Atlanta, USA'),
       (4, 'Auckland, New Zealand'),
       (5, 'Bangkok, Thailand'),
       (6, 'Barcelona, Spain'),
       (7, 'Beijing, China'),
       (8, 'Bengaluru, India'),
       (9, 'Berlin, Germany'),
       (10, 'Brisbane, Australia'),
       (11, 'Brussels, Belgium'),
       (12, 'Bucharest, Romania'),
       (13, 'Buenos Aires, Argentina'),
       (14, 'Charlotte, USA'),
       (15, 'Chennai, India'),
       (16, 'Chicago, USA'),
       (17, 'Christchurch, New Zealand'),
       (18, 'Dallas, USA'),
       (19, 'Denver, USA'),
       (20, 'Dublin, Ireland'),
       (21, 'Frankfurt, Germany'),
       (22, 'Hamburg, Germany'),
       (23, 'Helsinki, Finland'),
       (24, 'Hong Kong'),
       (25, 'Houston, USA'),
       (26, 'Istanbul, Turkey'),
       (27, 'Jakarta, Indonesia'),
       (28, 'Johannesburg, South Africa'),
       (29, 'Kansas City, USA'),
       (30, 'Kuala Lumpur, Malaysia'),
       (31, 'Kyiv, Ukraine'),
       (32, 'Las Vegas, USA'),
       (33, 'London, United kingdom'),
       (34, 'Los Angeles, USA'),
       (35, 'Luxembourg'),
       (36, 'Lyon, France'),
       (37, 'Madrid, Spain'),
       (38, 'Manchester, United Kingdom'),
       (39, 'Melbourne, Australia'),
       (40, 'Mexico City, Mexico'),
       (41, 'Miami, USA'),
       (42, 'Milan, Italy'),
       (43, 'Montreal, Canada'),
       (44, 'Moscow, Russia'),
       (45, 'Mumbai, India'),
       (46, 'Munich, Germany'),
       (47, 'New Delhi, India'),
       (48, 'New Jersey, USA'),
       (49, 'New York, USA'),
       (50, 'Newcastle, United Kingdom'),
       (51, 'Nuremberg, Germany'),
       (52, 'Ogden, USA'),
       (53, 'Oslo, Norway'),
       (54, 'Paris, France'),
       (55, 'Perth, Australia'),
       (56, 'Phoenix, USA'),
       (57, 'Piladelphia, USA'),
       (58, 'Portland, USA'),
       (83, 'Quebec, Canada'),
       (59, 'Riga, Latvia'),
       (60, 'Rome, Italy'),
       (61, 'Rotterdam, Netherlands'),
       (62, 'Salt Lake City, USA'),
       (63, 'San Diego, USA'),
       (64, 'San Francisco, USA'),
       (65, 'San Jose, USA'),
       (66, 'Seattle, USA'),
       (67, 'Seoul, South Korea'),
       (68, 'Shanghai, China'),
       (69, 'Silicon Valley, USA'),
       (70, 'Singapore'),
       (71, 'Sofia, Bulgaria'),
       (72, 'St Petersburg, Russia'),
       (73, 'Stockholm, Sweeden'),
       (74, 'Sydney, Australia'),
       (75, 'Tampa, USA'),
       (76, 'Tokyo, Japan'),
       (77, 'Toronto, Canada'),
       (78, 'Vancouver, Canada'),
       (79, 'Warsaw, Poland'),
       (80, 'Washington, USA'),
       (81, 'Wellington, New Zealand'),
       (82, 'Zurich, Switzerland');
/*!40000 ALTER TABLE `locations`
    ENABLE KEYS */;

-- Dumping structure for table my_idlers.pricing
CREATE TABLE IF NOT EXISTS `pricing`
(
    `server_id`     char(8) NOT NULL,
    `price`         decimal(10, 2) DEFAULT NULL,
    `currency`      char(3)        DEFAULT NULL,
    `term`          int(11)        DEFAULT NULL,
    `per_month`     decimal(10, 2) DEFAULT NULL,
    `as_usd`        decimal(10, 2) DEFAULT NULL,
    `usd_per_month` decimal(10, 2) DEFAULT NULL,
    `next_dd`       date           DEFAULT NULL,
    PRIMARY KEY (`server_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

-- Dumping data for table my_idlers.pricing: ~0 rows (approximately)
/*!40000 ALTER TABLE `pricing`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `pricing`
    ENABLE KEYS */;

-- Dumping structure for table my_idlers.providers
CREATE TABLE IF NOT EXISTS `providers`
(
    `id`   int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(124) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `Index 1` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

-- Dumping data for table my_idlers.providers: ~90 rows (approximately)
/*!40000 ALTER TABLE `providers`
    DISABLE KEYS */;
INSERT INTO `providers` (`id`, `name`)
VALUES (1, 'AWS'),
       (2, 'Bandit Host'),
       (3, 'Bit Accel'),
       (4, 'Bluehost'),
       (5, 'BudgetNode'),
       (6, 'BuyVM'),
       (7, 'CloudCone'),
       (8, 'Clouvider'),
       (9, 'CrownCloud'),
       (10, 'David Froehlich'),
       (11, 'Dedispec'),
       (12, 'DesiVPS'),
       (13, 'Digital Ocean'),
       (14, 'Domain.com'),
       (15, 'Dr. Server'),
       (16, 'DreamHost'),
       (17, 'Dynadot'),
       (18, 'Evolution Host'),
       (19, 'ExonHost'),
       (20, 'ExtraVM'),
       (21, 'FlowVPS'),
       (22, 'FreeRangeCloud'),
       (23, 'George Data Center'),
       (24, 'Gestiondbi'),
       (25, 'Gullo\'s Hosting'),
       (26, 'HappyBeeHost'),
       (27, 'Hetzner'),
       (28, 'Host Sailor'),
       (29, 'HostEons'),
       (30, 'HostGator'),
       (31, 'HostHatch'),
       (32, 'Hostigger'),
       (33, 'HostMaxim'),
       (34, 'HostSolutions'),
       (35, 'Hostus'),
       (36, 'HostYD'),
       (37, 'Hotlineservers'),
       (38, 'Hover'),
       (39, 'Hyonix'),
       (40, 'Hyperexpert'),
       (41, 'Inception Hosting'),
       (42, 'IndoVirtue'),
       (43, 'IOflood'),
       (44, 'IonSwitch'),
       (45, 'Khan Web Host'),
       (46, 'KTS24 (Haendler.IT)'),
       (47, 'LaunchVPS'),
       (48, 'LETBox'),
       (49, 'Lilchosting'),
       (50, 'Linode'),
       (51, 'Liteserver'),
       (52, 'lkwebhosting'),
       (53, 'MrVM'),
       (54, 'MYW'),
       (55, 'Namecheap'),
       (56, 'NameSilo'),
       (57, 'Naranjatech'),
       (58, 'NexusBytes'),
       (59, 'Novos'),
       (60, 'One Provider'),
       (61, 'OVH'),
       (62, 'Owned networks'),
       (63, 'Porkbun'),
       (64, 'Prolo'),
       (65, 'Pure Voltage'),
       (66, 'Quantum Core'),
       (67, 'Quick Packet'),
       (68, 'RackNerd'),
       (69, 'Rad Web hosting'),
       (70, 'RamNode'),
       (71, 'ReadyDedis'),
       (72, 'Servarica'),
       (73, 'Servers Galore'),
       (74, 'Skylon Host'),
       (75, 'SmallWeb'),
       (76, 'Smarthost'),
       (77, 'SpryServers'),
       (78, 'SSDBlaze'),
       (79, 'Store Host'),
       (80, 'TeraSwitch'),
       (81, 'Terrahost'),
       (82, 'Ulayer'),
       (83, 'Ultra VPS'),
       (84, 'Virmach'),
       (85, 'VPS Aliens'),
       (86, 'Vultr'),
       (87, 'WebHorizon'),
       (88, 'Wishhosting'),
       (89, 'X4B'),
       (90, 'ZeptoVM');
/*!40000 ALTER TABLE `providers`
    ENABLE KEYS */;

-- Dumping structure for table my_idlers.servers
CREATE TABLE IF NOT EXISTS `servers`
(
    `id`               char(8) NOT NULL,
    `hostname`         varchar(124) DEFAULT NULL,
    `location`         int(11)      DEFAULT NULL,
    `provider`         int(11)      DEFAULT NULL,
    `ipv4`             varchar(124) DEFAULT NULL,
    `ipv6`             varchar(124) DEFAULT NULL,
    `ns1`              varchar(124) DEFAULT NULL,
    `ns2`              varchar(124) DEFAULT NULL,
    `virt`             varchar(4)   DEFAULT NULL,
    `cpu`              int(11)      DEFAULT 1,
    `cpu_type`         varchar(124) DEFAULT NULL,
    `cpu_freq`         float        DEFAULT NULL,
    `ram`              float        DEFAULT NULL,
    `ram_mb`           float        DEFAULT NULL,
    `ram_type`         char(2)      DEFAULT 'MB',
    `swap`             float        DEFAULT NULL,
    `swap_mb`          float        DEFAULT NULL,
    `swap_type`        char(2)      DEFAULT 'MB',
    `disk`             int(11)      DEFAULT NULL,
    `disk_gb`          int(11)      DEFAULT NULL,
    `disk_type`        char(2)      DEFAULT 'GB',
    `bandwidth`        float        DEFAULT NULL,
    `bandwidth_type`   char(2)      DEFAULT 'TB',
    `gb5_single`       int(11)      DEFAULT NULL,
    `gb5_multi`        int(11)      DEFAULT NULL,
    `gb5_id`           varchar(12)  DEFAULT NULL,
    `aes_ni`           tinyint(1)   DEFAULT 0,
    `amd_v`            tinyint(1)   DEFAULT 0,
    `is_dedicated`     tinyint(1)   DEFAULT 0,
    `is_cpu_dedicated` tinyint(1)   DEFAULT 0,
    `was_special`      tinyint(1)   DEFAULT 0,
    `os`               int(11)      DEFAULT NULL,
    `ssh_port`         int(11)      DEFAULT 22,
    `still_have`       tinyint(1)   DEFAULT 1,
    `owned_since`      date         DEFAULT NULL,
    `tags`             varchar(255) DEFAULT NULL,
    `notes`            varchar(255) DEFAULT NULL,
    `has_yabs`         tinyint(1)   DEFAULT 0,
    `has_st`           tinyint(1)   DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `Index 2` (`ipv4`, `hostname`, `ipv6`)
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

-- Dumping data for table my_idlers.servers: ~0 rows (approximately)
/*!40000 ALTER TABLE `servers`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `servers`
    ENABLE KEYS */;

-- Dumping structure for table my_idlers.shared_hosting
CREATE TABLE IF NOT EXISTS `shared_hosting`
(
    `id`            char(8)      NOT NULL,
    `domain`        varchar(124) NOT NULL DEFAULT '',
    `domains_limit` int(11)      NOT NULL DEFAULT '0',
    `emails`        int(11)      NOT NULL DEFAULT '0',
    `disk`          int(11)      NOT NULL DEFAULT '0',
    `disk_type`     char(2)      NOT NULL DEFAULT '0',
    `disk_as_gb`    int(11)      NOT NULL DEFAULT '0',
    `ftp`           int(11)      NOT NULL DEFAULT '0',
    `db`            int(11)      NOT NULL DEFAULT '0',
    `bandwidth`     int(11)      NOT NULL DEFAULT '0',
    `provider`      int(11)      NOT NULL DEFAULT '0',
    `location`      int(11)      NOT NULL DEFAULT '0',
    `was_special`   tinyint(1)   NOT NULL DEFAULT '0',
    `still_have`    tinyint(1)   NOT NULL DEFAULT '1',
    `type`          varchar(24)  NOT NULL DEFAULT '0',
    `owned_since`   date         NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

-- Dumping data for table my_idlers.shared_hosting: ~0 rows (approximately)
/*!40000 ALTER TABLE `shared_hosting`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `shared_hosting`
    ENABLE KEYS */;

-- Dumping structure for table my_idlers.speed_tests
CREATE TABLE IF NOT EXISTS `speed_tests`
(
    `id`              int(11) NOT NULL AUTO_INCREMENT,
    `server_id`       char(8)      DEFAULT NULL,
    `location`        varchar(124) DEFAULT NULL,
    `send`            float        DEFAULT NULL,
    `send_type`       char(4)      DEFAULT NULL,
    `send_as_mbps`    float        DEFAULT NULL,
    `recieve`         float        DEFAULT NULL,
    `recieve_type`    char(4)      DEFAULT NULL,
    `recieve_as_mbps` float        DEFAULT NULL,
    `datetime`        datetime     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

-- Dumping data for table my_idlers.speed_tests: ~0 rows (approximately)
/*!40000 ALTER TABLE `speed_tests`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `speed_tests`
    ENABLE KEYS */;

/*!40101 SET SQL_MODE = IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS = IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;