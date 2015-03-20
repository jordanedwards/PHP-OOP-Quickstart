
CREATE TABLE IF NOT EXISTS `user` (  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `user_first_name` varchar(50) NOT NULL DEFAULT '',  `user_last_name` varchar(50) NOT NULL DEFAULT '',  `user_email` varchar(100) NOT NULL DEFAULT '',  `user_tel` varchar(20) NOT NULL DEFAULT '0',  `user_carrier` varchar(20) NOT NULL DEFAULT '0',  `user_password` varchar(100) NOT NULL DEFAULT '',  `user_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `user_role` smallint(11) NOT NULL DEFAULT '0',  `user_date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `user_last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `user_last_updated_user` varchar(200) NOT NULL DEFAULT '0',  PRIMARY KEY (`user_id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `log` (
  `log_id` int(8) NOT NULL AUTO_INCREMENT,
  `log_user` int(3) NOT NULL,
  `log_val` longtext NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;
