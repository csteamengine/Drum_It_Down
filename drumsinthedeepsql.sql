-- --------------------------------------------------------
-- Host:                         66.147.244.88
-- Server version:               5.5.51-38.2-log - Percona Server (GPL), Release 38.2, Revision 2
-- Server OS:                    Linux
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table stonesu0_stonestreet.images
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(10) DEFAULT NULL,
  `file_name` varchar(50) DEFAULT NULL,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table stonesu0_stonestreet.images: ~0 rows (approximately)
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;


-- Dumping structure for table stonesu0_stonestreet.life_images
CREATE TABLE IF NOT EXISTS `life_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(50) NOT NULL,
  `active` varchar(10) DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table stonesu0_stonestreet.life_images: 9 rows
/*!40000 ALTER TABLE `life_images` DISABLE KEYS */;
INSERT INTO `life_images` (`id`, `file_name`, `active`) VALUES
	(1, 'KellySlalomCropped.jpg', 'yes'),
	(2, 'NickNMeCropped.jpg', 'yes'),
	(3, 'Megalodon.jpg', 'yes'),
	(4, 'KellNMe.jpg', 'yes'),
	(5, 'ClubFest_table_Fall_2015.JPG', 'yes'),
	(6, 'WakeboardCropped.jpg', 'yes'),
	(7, 'KellNMeChristmas.jpg', 'yes'),
	(8, 'TheFamily.jpg', 'yes'),
	(9, 'Slopes1.jpg', 'yes');
/*!40000 ALTER TABLE `life_images` ENABLE KEYS */;


-- Dumping structure for table stonesu0_stonestreet.most_recent
CREATE TABLE IF NOT EXISTS `most_recent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `most_recent_projects_id_fk` (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table stonesu0_stonestreet.most_recent: 1 rows
/*!40000 ALTER TABLE `most_recent` DISABLE KEYS */;
INSERT INTO `most_recent` (`id`, `project_id`) VALUES
	(1, 2);
/*!40000 ALTER TABLE `most_recent` ENABLE KEYS */;


-- Dumping structure for table stonesu0_stonestreet.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `text` text,
  `description` varchar(100) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` varchar(10) DEFAULT 'yes',
  `main_page` varchar(10) DEFAULT 'no',
  `url` varchar(100) DEFAULT NULL,
  KEY `Index 1` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table stonesu0_stonestreet.projects: 9 rows
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `title`, `text`, `description`, `image`, `category`, `created`, `active`, `main_page`, `url`) VALUES
	(1, 'PiCopter', 'A friend and I built this quadcopter from scratch using a Raspberry Pi, Arduino, some brushless motors, and lots of K\'NEX. We built the PiCopter for HackISU which is a competition where computer nerds gather to build whatever crazy ideas they can think up.', 'Raspberry Pi Powered Quadcopter', 'PiCopter.jpg', 'hardware', '2016-07-01 02:41:30', 'yes', 'no', ''),
	(2, 'BalanceBot', 'An autonomous self balancing robot built with an Arduino, a gyroscope, a custom circuit board and two brushless motors. This was built for HackISU for it, we were awarded the ingenuity award from Rockwell Collins.', 'Self Balancing Robot', 'BalanceBot.jpg', 'hardware', '2016-07-01 01:03:30', 'yes', 'yes', ''),
	(3, 'BB-St8', 'We designed this BB-St8 during a HackISU competition. It is built with a Raspberry Pi, motors, and a PS3 Controller to drive it. In the end, it didn\'t work very well, but it was a blast to make. ', 'Our version of the very popular BB-8 Droid', 'BB-St8.jpg', 'hardware', '2016-07-01 12:11:39', 'yes', 'yes', ''),
	(8, 'DrumItDown', 'This site allows user to upload a midi file and it shows them how to play the drum part using a graphical drum set. It will play the Spotify mp3 along with it so learners can learn by association.', 'My homemade drum instruction website', 'drumitdown.jpg', 'website', '2016-07-01 12:30:46', 'yes', 'yes', 'http://www.drumitdown.com'),
	(7, 'Jewell Family Dentistry', 'I was asked to create this website for Jewell Family Dentistry in early 2016 by Dan and Meryl Scarrow. They were starting their company from scratch and wanted the site to have a very homespun feel to it. The building they are located in is brick and they wanted to site to reflect that. The site is fully functional and can be maintained by Dan and Meryl. They can add images, and edit other content on the site without having to touch the code.', 'A website for the new dentist in Jewell IA', 'JFD.png', 'website', '2016-07-01 12:27:51', 'yes', 'yes', 'http://www.jewellfamilydentistry.com'),
	(12, 'MyLand', 'MyLand is a revolutionary social media website that takes a new approach to user interaction. Each user is given an island that they can do whatever they want with. Rather than following the traditional top to bottom feed, MyLand allows users to scroll around in all directions exploring other users islands. This website was built as a school project for ISU and is no longer live.', 'Social Media with a twist', 'myland.PNG', 'website', '2016-07-07 14:58:37', 'yes', 'no', ''),
	(15, 'Rogue-Like Game', 'I designed this rogue-like game from scratch using C and C++ for a programming class at ISU. It is played from the command line, and controlled with the keyboard. We were given some liberty when it came to game design, so many of the colors and text I used were my own choice.', 'A traditional rogue-like game', 'rogue-like-game.png', 'software', '2016-08-17 15:54:42', 'yes', 'no', ''),
	(16, 'oprah', 'When a user wants to transfer a repository from one git hosting site to another, it is easy do a simple git pull/git push to get the code switched over. For the issues, projects, and wiki, this is not the case. That is where oprah comes in. Oprah is a CLI that automatically transfers the code, branches, commits, and issues from GitHub to a specified GForge repository in under a minute. Simply run the command oprah and all your troubles will be over.\r\n\r\nGForge is a fairly new company that is trying to revolutionize the git community. They are making a website similar to GitHub, but with far more uses. They are mixing GitHub, Slack, and Jira to simplify the project management part of software projects. Once their site is complete, they will need a way to convince users to switch to their product, and that is the goal of oprah. We wanted to help GForge attract new customers, and automating the repo transfer process seemed like a good place to start.', 'CLI to transfer a repository from GitHub to GForge', 'gallery.jpg', 'software', '2016-09-19 08:29:17', 'yes', 'yes', '/portfolio/project_view.php?id=16'),
	(17, 'Stonestreet Software', 'I built this website to serve as my online portfolio where I can store my projects as I complete them. It has a custom built admin page where I can upload new projects, images, snippets, and edit any contact information without having to edit the code and push it to the server. It has undergone many remakes since I first had it live, and I think I have gotten it to a point that I am happy with. However, as I love doing web development, I expect to revisit this site many times over the course of my career as I continue to learn. Every time I redo this site, it gets better and better, so there\'s no reason to stop improving it. ', 'My personal website built from scratch using PHP, CSS, HTML and Javascript.', 'stonestreet.png', 'website', '2016-09-19 08:34:29', 'yes', 'yes', 'http://www.stonestreetsoftware.com');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;


-- Dumping structure for table stonesu0_stonestreet.snippets
CREATE TABLE IF NOT EXISTS `snippets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `brief` varchar(100) DEFAULT NULL,
  `directory` varchar(100) DEFAULT NULL,
  `active` varchar(5) NOT NULL DEFAULT 'yes',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `Index 1` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table stonesu0_stonestreet.snippets: 4 rows
/*!40000 ALTER TABLE `snippets` DISABLE KEYS */;
INSERT INTO `snippets` (`id`, `title`, `url`, `description`, `brief`, `directory`, `active`, `created`) VALUES
	(1, 'Slide Out Footer', '/snippets/not_ready.php', 'A hidden, static footer that slides out from under the content as you scroll down. The footer initially hides behind the body and reveals itself as you scroll down.', 'A hidden, static footer that slides out from under the content', 'Slide_Out_Footer', 'yes', '2016-07-08 09:54:07'),
	(2, 'Responsive Header', '/snippets/HeaderShrink/', 'A responsive header that shrinks as you scroll down. This can be used if you want more room for displaying content on your page but also want to have lots of information in your header. If the user scrolls to the top, the header grows to show the extra information, but when they scroll down it hides it.', 'A responsive header that shrinks as you scroll down.', 'HeaderShrink', 'yes', '2016-08-02 11:20:07'),
	(3, 'Hover Overlay', '/snippets/not_ready.php', 'An animated overlay that activates when you hover over an item. Can be used for images or divs as a way of displaying extra information on a given item.', 'An animated overlay that activates when you hover over an item. ', 'HoverOverlay', 'yes', '2016-08-02 11:22:33'),
	(4, 'Responsive Grid', '/snippets/not_ready.php', 'The same technique used on this page with each of the grid items.', 'The same technique used on this page with each of the grid items.', '#', 'yes', '2016-08-02 10:27:48');
/*!40000 ALTER TABLE `snippets` ENABLE KEYS */;


-- Dumping structure for table stonesu0_stonestreet.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(80) DEFAULT NULL,
  `resume` varchar(50) DEFAULT NULL,
  KEY `Index 1` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table stonesu0_stonestreet.users: 1 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `resume`) VALUES
	(1, 'csteamengine', '$2y$10$wRLdGh5jUXNBgibHi/O7deipN4TvZhMwPXp1pvP8hdY6iWaVG207C', 'Gregory_Resume_2016_Summer.pdf');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
