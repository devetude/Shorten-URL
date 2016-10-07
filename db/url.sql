SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `url` (
		`idx` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '인덱스',
		`original_url` varchar(255) NOT NULL COMMENT '원본 url',
		`shorten_url` varchar(255) NOT NULL COMMENT '줄임 url',
		`hits` bigint(20) unsigned NOT NULL COMMENT '조회수',
		`insert_date` datetime NOT NULL COMMENT '입력시간',
		PRIMARY KEY (`idx`),
		KEY `idx` (`idx`),
		KEY `original_url` (`original_url`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='url' AUTO_INCREMENT=2 ;
