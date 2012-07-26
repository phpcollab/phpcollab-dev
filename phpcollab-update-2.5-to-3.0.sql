CREATE TABLE IF NOT EXISTS `permissions` (
  `per_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `per_code` varchar(100) NOT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

INSERT INTO `permissions` (`per_id`, `per_code`) VALUES
(1, 'project_create'),
(2, 'project_update_all'),
(3, 'project_update_owned'),
(4, 'task_create'),
(5, 'task_update_all'),
(6, 'task_update_owned'),
(7, 'task_update_assigned');

CREATE TABLE IF NOT EXISTS `permissions_roles` (
  `per_rol_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `per_id` int(10) unsigned NOT NULL,
  `rol_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`per_rol_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

INSERT INTO `permissions_roles` (`per_rol_id`, `per_id`, `rol_id`) VALUES
(1, 1, 0),
(2, 1, 1),
(3, 1, 5),
(4, 2, 0),
(5, 2, 5),
(6, 3, 1),
(7, 4, 1),
(8, 4, 5),
(9, 5, 5),
(10, 7, 2),
(11, 6, 1),
(12, 4, 0),
(13, 5, 0);
