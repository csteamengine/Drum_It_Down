-- --------------------------------------------------------
-- Host:                         mysql.kellydevittceramics.com
-- Server version:               5.6.25-log - Source distribution
-- Server OS:                    Linux
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table drumsinthedeep.downvotes
CREATE TABLE IF NOT EXISTS `downvotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `active` varchar(45) DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table drumsinthedeep.downvotes: ~2 rows (approximately)
/*!40000 ALTER TABLE `downvotes` DISABLE KEYS */;
INSERT INTO `downvotes` (`id`, `file_id`, `user_id`, `active`) VALUES
	(1, 7, 1, 'yes'),
	(2, 4, 2, 'no');
/*!40000 ALTER TABLE `downvotes` ENABLE KEYS */;


-- Dumping structure for table drumsinthedeep.midi_files
CREATE TABLE IF NOT EXISTS `midi_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `track_id` int(11) NOT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `popularity` int(11) DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `active` varchar(45) DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table drumsinthedeep.midi_files: ~7 rows (approximately)
/*!40000 ALTER TABLE `midi_files` DISABLE KEYS */;
INSERT INTO `midi_files` (`id`, `track_id`, `file_name`, `popularity`, `created`, `active`) VALUES
	(3, 3, 'Take_The_Money_And_Run_Steve_Miller_Band_Greatest_Hits_1974-78_1.mid', 0, '2016-11-01 14:12:51', 'yes'),
	(4, 4, 'My_Hero_Foo_Fighters_Greatest_Hits_1.mid', 2, '2016-11-01 14:16:28', 'yes'),
	(5, 5, 'Fly_By_Night_Rush_Fly_By_Night_1.mid', 1, '2016-11-01 14:17:55', 'yes'),
	(6, 6, 'Tom_Sawyer_Rush_Moving_Pictures_(2011_Remaster)_1.mid', 1, '2016-11-01 14:19:12', 'yes'),
	(7, 7, 'Gimme_Three_Steps_Lynyrd_Skynyrd_Pronounced_Leh-Nerd_Skin-Nerd_1.mid', -1, '2016-11-01 14:22:32', 'yes'),
	(8, 8, 'The_Joker_Steve_Miller_Band_The_Joker_1.mid', 1, '2016-11-01 14:24:37', 'yes'),
	(9, 5, 'Fly_By_Night_Rush_Fly_By_Night_2.mid', 0, '2016-11-01 14:35:40', 'yes');
/*!40000 ALTER TABLE `midi_files` ENABLE KEYS */;


-- Dumping structure for table drumsinthedeep.tracks
CREATE TABLE IF NOT EXISTS `tracks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album` varchar(50) DEFAULT NULL,
  `artist` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `spotify_id` varchar(100) DEFAULT NULL,
  `spotify_url` varchar(150) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `spotify_popularity` int(11) DEFAULT NULL,
  `popularity` int(11) DEFAULT '0',
  `preview_url` varchar(150) DEFAULT NULL,
  `spotify_uri` varchar(150) DEFAULT NULL,
  `image_url` varchar(100) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='This table will hold all track info. A track is just a song.';

-- Dumping data for table drumsinthedeep.tracks: ~6 rows (approximately)
/*!40000 ALTER TABLE `tracks` DISABLE KEYS */;
INSERT INTO `tracks` (`id`, `album`, `artist`, `duration`, `spotify_id`, `spotify_url`, `title`, `spotify_popularity`, `popularity`, `preview_url`, `spotify_uri`, `image_url`, `created`) VALUES
	(3, 'Greatest Hits 1974-78', 'Steve Miller Band', '172973', '2dV6oLMaJjV15KCVzcWLbF', 'https://api.spotify.com/v1/tracks/2dV6oLMaJjV15KCVzcWLbF', 'Take The Money And Run', 51, 0, 'https://p.scdn.co/mp3-preview/597a177b1e12b20ca739fa77b7b20668582301b1', 'spotify:track:2dV6oLMaJjV15KCVzcWLbF', 'https://i.scdn.co/image/2e6d1ba9fe9c5e264148ca9a1d1477a72c7ab181', '2016-11-01 14:12:50'),
	(4, 'Greatest Hits', 'Foo Fighters', '258973', '7u5dBtASrtOuBTTZjJrvuJ', 'https://api.spotify.com/v1/tracks/7u5dBtASrtOuBTTZjJrvuJ', 'My Hero', 61, 0, 'https://p.scdn.co/mp3-preview/46145f46a9246e10f645929311a5a5ce8bd01d27', 'spotify:track:7u5dBtASrtOuBTTZjJrvuJ', 'https://i.scdn.co/image/3b505559c2bce1f6205eeb0b19d65e3a2c8f5617', '2016-11-01 14:16:28'),
	(5, 'Fly By Night', 'Rush', '202200', '54TaGh2JKs1pO9daXNXI5q', 'https://api.spotify.com/v1/tracks/54TaGh2JKs1pO9daXNXI5q', 'Fly By Night', 46, 0, 'https://p.scdn.co/mp3-preview/d3b98ef6eb5a0932d030e7b5b076256c8fe123c8', 'spotify:track:54TaGh2JKs1pO9daXNXI5q', 'https://i.scdn.co/image/a3004eb1e2cc337ac5ee15655b0343b0cb61ff01', '2016-11-01 14:17:55'),
	(6, 'Moving Pictures (2011 Remaster)', 'Rush', '276880', '3QZ7uX97s82HFYSmQUAN1D', 'https://api.spotify.com/v1/tracks/3QZ7uX97s82HFYSmQUAN1D', 'Tom Sawyer', 59, 0, 'https://p.scdn.co/mp3-preview/ac1926c98cd4566da7a5d9e76ff2165d37571564', 'spotify:track:3QZ7uX97s82HFYSmQUAN1D', 'https://i.scdn.co/image/14e0400fc347d4576721c02e15975c1dcda23fe7', '2016-11-01 14:19:11'),
	(7, 'Pronounced\' Leh-\'Nerd \'Skin-\'Nerd', 'Lynyrd Skynyrd', '266826', '5x6vchLT7JBTZnLupOVeJe', 'https://api.spotify.com/v1/tracks/5x6vchLT7JBTZnLupOVeJe', 'Gimme Three Steps', 54, 0, 'https://p.scdn.co/mp3-preview/5cc15964c75f032972ee862ee6e6177fba274050', 'spotify:track:5x6vchLT7JBTZnLupOVeJe', 'https://i.scdn.co/image/2de99baeffaba7b8041383bd7f0eb9ab30e8276c', '2016-11-01 14:22:32'),
	(8, 'The Joker', 'Steve Miller Band', '264503', '1bp2IO61zbQrbWNmKKxg3f', 'https://api.spotify.com/v1/tracks/1bp2IO61zbQrbWNmKKxg3f', 'The Joker', 62, 0, 'https://p.scdn.co/mp3-preview/9e24cd880771d78797a1b6831087938570e7eff5', 'spotify:track:1bp2IO61zbQrbWNmKKxg3f', 'https://i.scdn.co/image/2ce133525413324d9dcdcf1ce648dded7d9b0285', '2016-11-01 14:24:37');
/*!40000 ALTER TABLE `tracks` ENABLE KEYS */;


-- Dumping structure for table drumsinthedeep.upvotes
CREATE TABLE IF NOT EXISTS `upvotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `active` varchar(45) DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table drumsinthedeep.upvotes: ~6 rows (approximately)
/*!40000 ALTER TABLE `upvotes` DISABLE KEYS */;
INSERT INTO `upvotes` (`id`, `file_id`, `user_id`, `active`) VALUES
	(3, 4, 1, 'yes'),
	(4, 6, 1, 'yes'),
	(5, 8, 1, 'yes'),
	(6, 4, 2, 'no'),
	(7, 4, 2, 'yes'),
	(8, 5, 2, 'yes');
/*!40000 ALTER TABLE `upvotes` ENABLE KEYS */;


-- Dumping structure for table drumsinthedeep.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table drumsinthedeep.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `f_name`, `l_name`, `username`, `password`, `created`) VALUES
	(1, 'Gregory', 'Steenhagen', 'csteamengine', '$2y$10$xZVQWE/zrC99JP67mgaF5OTy7A2Ws8ahFtHmtafvhnpaVvS.AQzVu', '2016-11-01 14:11:31'),
	(2, 'Other', 'Guy', 'other_guy', '$2y$10$iuxRQfL.9fsfJv3mPUagluhB9ZRMXlWCJJ96zdKMXYOhI6QB2u8/S', '2016-11-01 14:31:04');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
