CREATE TABLE IF NOT EXISTS `slider` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`image` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`old_price` VARCHAR(255)  NOT NULL ,
`new_price` VARCHAR(255)  NOT NULL ,
`active` VARCHAR(255)  NOT NULL ,
`order` TINYINT(4)  NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT COLLATE=utf8_general_ci;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Slider','com_slider.slider','{"special":{"dbtable":"slider","key":"id","type":"Slider","prefix":"SliderTable"}}', '{"formFile":"administrator\/components\/com_slider\/models\/forms\/slider.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"description"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_slider.slider')
) LIMIT 1;
