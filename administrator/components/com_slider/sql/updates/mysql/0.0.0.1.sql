

CREATE TABLE IF NOT EXISTS #__sl_slider  (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NOT NULL,
			  `published` tinyint(3) NOT NULL DEFAULT '0',			 
			  `description` text NOT NULL,
			  `ordering` int(11) NOT NULL DEFAULT '0',
			  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
			  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
			  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
			  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',			  
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `#__sl_slider` DROP `name` ; 

ALTER TABLE  `#__sl_slider`  CHANGE `description` `description` VARCHAR(255) NOT NULL ;

ALTER TABLE  `#__sl_slider`  ADD `image` VARCHAR(200) NOT NULL ;

ALTER TABLE  `#__sl_slider`  ADD `old_price` INT NOT NULL ;

ALTER TABLE  `#__sl_slider`  ADD `ew_price` INT NOT NULL ;

ALTER TABLE  `#__sl_slider`  CHANGE `ew_price` `new_price` INT(11) NOT NULL ;