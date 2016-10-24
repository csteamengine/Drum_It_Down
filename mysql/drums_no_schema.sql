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

-- Dumping structure for table drumsinthedeep.likes
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table drumsinthedeep.likes: ~0 rows (approximately)
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;


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

-- Dumping data for table drumsinthedeep.midi_files: ~3 rows (approximately)
/*!40000 ALTER TABLE `midi_files` DISABLE KEYS */;
INSERT INTO `midi_files` (`id`, `track_id`, `file_name`, `popularity`, `created`, `active`) VALUES
	(7, 7, 'Ramble_On_Led_Zeppelin_Led_Zeppelin_II_5.mid', 0, '2016-10-24 07:26:49', 'yes'),
	(8, 8, 'My_Hero_Foo_Fighters_Greatest_Hits_1.mid', 0, '2016-10-24 07:34:47', 'yes'),
	(9, 9, 'Fly_By_Night_Rush_Fly_By_Night_1.mid', 0, '2016-10-24 07:41:19', 'yes');
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
  `popularity` int(11) DEFAULT NULL,
  `preview_url` varchar(150) DEFAULT NULL,
  `spotify_uri` varchar(150) DEFAULT NULL,
  `image_url` varchar(100) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='This table will hold all track info. A track is just a song.';

-- Dumping data for table drumsinthedeep.tracks: ~3 rows (approximately)
/*!40000 ALTER TABLE `tracks` DISABLE KEYS */;
INSERT INTO `tracks` (`id`, `album`, `artist`, `duration`, `spotify_id`, `spotify_url`, `title`, `spotify_popularity`, `popularity`, `preview_url`, `spotify_uri`, `image_url`, `created`) VALUES
	(7, 'Led Zeppelin II', 'Led Zeppelin', '263333', '3MODES4TNtygekLl146Dxd', 'https://api.spotify.com/v1/tracks/3MODES4TNtygekLl146Dxd', 'Ramble On', 68, NULL, 'https://p.scdn.co/mp3-preview/83383aceb01ea27b0bffdedfaebe55e29b33aca2', 'spotify:track:3MODES4TNtygekLl146Dxd', 'https://i.scdn.co/image/5fa3a6cc1848ea743a293d2088046746d1b09608', '2016-10-24 07:26:49'),
	(8, 'Greatest Hits', 'Foo Fighters', '258973', '7u5dBtASrtOuBTTZjJrvuJ', 'https://api.spotify.com/v1/tracks/7u5dBtASrtOuBTTZjJrvuJ', 'My Hero', 61, NULL, 'https://p.scdn.co/mp3-preview/46145f46a9246e10f645929311a5a5ce8bd01d27', 'spotify:track:7u5dBtASrtOuBTTZjJrvuJ', 'https://i.scdn.co/image/3b505559c2bce1f6205eeb0b19d65e3a2c8f5617', '2016-10-24 07:34:46'),
	(9, 'Fly By Night', 'Rush', '202200', '54TaGh2JKs1pO9daXNXI5q', 'https://api.spotify.com/v1/tracks/54TaGh2JKs1pO9daXNXI5q', 'Fly By Night', 46, NULL, 'https://p.scdn.co/mp3-preview/d3b98ef6eb5a0932d030e7b5b076256c8fe123c8', 'spotify:track:54TaGh2JKs1pO9daXNXI5q', 'https://i.scdn.co/image/a3004eb1e2cc337ac5ee15655b0343b0cb61ff01', '2016-10-24 07:41:19');
/*!40000 ALTER TABLE `tracks` ENABLE KEYS */;


-- Dumping structure for table drumsinthedeep.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table drumsinthedeep.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `f_name`, `l_name`, `username`, `created`) VALUES
	(1, 'Gregory', 'Steenhagen', 'csteamengine', '2016-10-19 09:41:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
