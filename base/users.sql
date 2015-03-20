
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
---- Table structure for table `user`--
CREATE TABLE IF NOT EXISTS `user` (  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `user_first_name` varchar(50) NOT NULL DEFAULT '',  `user_last_name` varchar(50) NOT NULL DEFAULT '',  `user_email` varchar(100) NOT NULL DEFAULT '',  `user_tel` varchar(20) NOT NULL DEFAULT '0',  `user_carrier` varchar(20) NOT NULL DEFAULT '0',  `user_password` varchar(100) NOT NULL DEFAULT '',  `user_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `user_role` smallint(11) NOT NULL DEFAULT '0',  `user_date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `user_last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `user_last_updated_user` varchar(200) NOT NULL DEFAULT '0',  PRIMARY KEY (`user_id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
