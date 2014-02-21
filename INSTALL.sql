-- --------------------------------------------------------

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `fle_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fle_owner` int(10) unsigned NOT NULL,
  `fle_approver` int(10) unsigned NOT NULL,
  `fle_name` varchar(255) NOT NULL,
  `fle_description` text,
  `fle_status` int(10) unsigned NOT NULL,
  `fle_parent` int(10) unsigned DEFAULT NULL,
  `fle_version` int(10) NOT NULL DEFAULT '1',
  `fle_size` int(10) NOT NULL,
  `fle_comments` text,
  `fle_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `fle_datecreated` datetime NOT NULL,
  `fle_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`fle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `files`
--


-- --------------------------------------------------------

--
-- Table structure for table `files_milestones`
--

DROP TABLE IF EXISTS `files_milestones`;
CREATE TABLE IF NOT EXISTS `files_milestones` (
  `fle_mln_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fle_id` int(10) unsigned NOT NULL,
  `mln_id` int(10) unsigned NOT NULL,
  `fle_mln_datecreated` datetime NOT NULL,
  PRIMARY KEY (`fle_mln_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `files_milestones`
--


-- --------------------------------------------------------

--
-- Table structure for table `files_projects`
--

DROP TABLE IF EXISTS `files_projects`;
CREATE TABLE IF NOT EXISTS `files_projects` (
  `fle_prj_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fle_id` int(10) unsigned NOT NULL,
  `prj_id` int(10) unsigned NOT NULL,
  `fle_prj_datecreated` datetime NOT NULL,
  PRIMARY KEY (`fle_prj_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `files_projects`
--


-- --------------------------------------------------------

--
-- Table structure for table `files_tasks`
--

DROP TABLE IF EXISTS `files_tasks`;
CREATE TABLE IF NOT EXISTS `files_tasks` (
  `fle_tsk_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fle_id` int(10) unsigned NOT NULL,
  `tsk_id` int(10) unsigned NOT NULL,
  `fle_tsk_datecreated` datetime NOT NULL,
  PRIMARY KEY (`fle_tsk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `files_tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `mbr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_id` int(10) unsigned NOT NULL,
  `mbr_name` varchar(255) NOT NULL,
  `mbr_description` text,
  `mbr_email` varchar(255) NOT NULL,
  `mbr_password` char(40) NOT NULL,
  `mbr_authorized` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mbr_comments` text,
  `mbr_datecreated` datetime NOT NULL,
  `mbr_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`mbr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`mbr_id`, `org_id`, `mbr_name`, `mbr_description`, `mbr_email`, `mbr_password`, `mbr_authorized`, `mbr_comments`, `mbr_datecreated`, `mbr_datemodified`) VALUES
(1, 1, 'Example', NULL, 'example@example.com', 'c3499c2729730a7f807efb8676a92dcb6f8a3f8f', 1, NULL, '2014-02-20 22:09:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `members_notifications`
--

DROP TABLE IF EXISTS `members_notifications`;
CREATE TABLE IF NOT EXISTS `members_notifications` (
  `mbr_ntf_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mbr_id` int(10) unsigned NOT NULL,
  `ntf_id` int(10) unsigned NOT NULL,
  `mbr_ntf_datecreated` datetime NOT NULL,
  PRIMARY KEY (`mbr_ntf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `members_notifications`
--


-- --------------------------------------------------------

--
-- Table structure for table `members_roles`
--

DROP TABLE IF EXISTS `members_roles`;
CREATE TABLE IF NOT EXISTS `members_roles` (
  `mbr_rol_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mbr_id` int(10) unsigned NOT NULL,
  `rol_id` int(10) unsigned NOT NULL,
  `mbr_rol_datecreated` datetime NOT NULL,
  PRIMARY KEY (`mbr_rol_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `members_roles`
--


-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

DROP TABLE IF EXISTS `milestones`;
CREATE TABLE IF NOT EXISTS `milestones` (
  `mln_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prj_id` int(10) unsigned NOT NULL,
  `mln_owner` int(10) unsigned NOT NULL,
  `mln_name` varchar(255) NOT NULL,
  `mln_description` text,
  `mln_date_start` date NOT NULL,
  `mln_date_due` date DEFAULT NULL,
  `mln_date_complete` date DEFAULT NULL,
  `mln_status` int(10) unsigned NOT NULL,
  `mln_priority` int(10) unsigned NOT NULL,
  `mln_comments` text,
  `mln_datecreated` datetime NOT NULL,
  `mln_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`mln_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `milestones`
--


-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `nte_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prj_id` int(10) unsigned NOT NULL,
  `nte_owner` int(10) unsigned NOT NULL,
  `nte_name` varchar(255) NOT NULL,
  `nte_description` text,
  `nte_date` date DEFAULT NULL,
  `nte_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `nte_datecreated` datetime NOT NULL,
  PRIMARY KEY (`nte_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `ntf_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ntf_code` varchar(255) NOT NULL,
  `ntf_datecreated` datetime NOT NULL,
  PRIMARY KEY (`ntf_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`ntf_id`, `ntf_code`, `ntf_datecreated`) VALUES
(1, 'project/task/member/assigned', '0000-00-00 00:00:00'),
(2, 'project/member/added', '0000-00-00 00:00:00'),
(3, 'project/member/removed', '0000-00-00 00:00:00'),
(4, 'project/topic/created', '0000-00-00 00:00:00'),
(5, 'project/topic/post/created', '0000-00-00 00:00:00'),
(6, 'project/task/updated', '0000-00-00 00:00:00'),
(7, 'project/member/assigned/task/updated', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
CREATE TABLE IF NOT EXISTS `organizations` (
  `org_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_owner` int(10) unsigned NOT NULL,
  `org_name` varchar(255) NOT NULL,
  `org_description` text,
  `org_comments` text,
  `org_authorized` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `org_system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `org_datecreated` datetime NOT NULL,
  PRIMARY KEY (`org_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`org_id`, `org_owner`, `org_name`, `org_description`, `org_comments`, `org_authorized`, `org_system`, `org_datecreated`) VALUES
(1, 1, 'My company', NULL, NULL, 1, 1, '2014-02-20 22:03:04'),
(2, 1, 'Test client', NULL, NULL, 0, 0, '2014-02-21 05:25:38');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `per_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `per_code` varchar(255) NOT NULL,
  `per_datecreated` datetime NOT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `permissions`
--


-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `pst_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tcs_id` int(10) unsigned NOT NULL,
  `mbr_id` int(10) unsigned NOT NULL,
  `pst_description` text NOT NULL,
  `pst_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pst_datecreated` datetime NOT NULL,
  PRIMARY KEY (`pst_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `prj_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_id` int(10) unsigned NOT NULL,
  `prj_owner` int(10) unsigned NOT NULL,
  `prj_name` varchar(255) NOT NULL,
  `prj_description` text,
  `prj_date_start` date NOT NULL,
  `prj_date_due` date DEFAULT NULL,
  `prj_date_complete` date DEFAULT NULL,
  `prj_status` int(10) unsigned NOT NULL,
  `prj_priority` int(10) unsigned NOT NULL,
  `prj_comments` text,
  `prj_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `prj_datecreated` datetime NOT NULL,
  `prj_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`prj_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`prj_id`, `org_id`, `prj_owner`, `prj_name`, `prj_description`, `prj_date_start`, `prj_date_due`, `prj_date_complete`, `prj_status`, `prj_priority`, `prj_comments`, `prj_published`, `prj_datecreated`, `prj_datemodified`) VALUES
(1, 2, 1, 'Test', NULL, '0000-00-00', NULL, NULL, 1, 1, NULL, 0, '2014-02-21 04:34:49', NULL),
(2, 1, 1, 'Test 2', NULL, '2014-02-20', NULL, NULL, 1, 2, NULL, 0, '2014-02-21 08:57:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects_members`
--

DROP TABLE IF EXISTS `projects_members`;
CREATE TABLE IF NOT EXISTS `projects_members` (
  `prj_mbr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prj_id` int(10) unsigned NOT NULL,
  `mbr_id` int(10) unsigned NOT NULL,
  `prj_mbr_authorized` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `prj_mbr_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `prj_mbr_datecreated` datetime NOT NULL,
  PRIMARY KEY (`prj_mbr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `projects_members`
--

INSERT INTO `projects_members` (`prj_mbr_id`, `prj_id`, `mbr_id`, `prj_mbr_authorized`, `prj_mbr_published`, `prj_mbr_datecreated`) VALUES
(2, 1, 1, 1, 1, '2014-02-21 08:39:20'),
(3, 2, 1, 1, 1, '2014-02-21 08:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `projects_trackers`
--

DROP TABLE IF EXISTS `projects_trackers`;
CREATE TABLE IF NOT EXISTS `projects_trackers` (
  `prj_trk_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prj_id` int(10) unsigned NOT NULL,
  `trk_id` int(10) unsigned NOT NULL,
  `prj_trk_datecreated` datetime NOT NULL,
  PRIMARY KEY (`prj_trk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `projects_trackers`
--


-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `rol_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol_code` varchar(255) NOT NULL,
  `rol_system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rol_datecreated` datetime NOT NULL,
  PRIMARY KEY (`rol_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`rol_id`, `rol_code`, `rol_system`, `rol_datecreated`) VALUES
(1, 'administrator', 1, '2014-02-20 22:03:48'),
(2, 'projectmanager', 1, '0000-00-00 00:00:00'),
(3, 'user', 1, '0000-00-00 00:00:00'),
(4, 'clientuser', 1, '0000-00-00 00:00:00'),
(5, 'accountmanager', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

DROP TABLE IF EXISTS `roles_permissions`;
CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `rol_per_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol_id` int(10) unsigned NOT NULL,
  `per_id` int(10) unsigned NOT NULL,
  `rol_per_datecreated` datetime NOT NULL,
  PRIMARY KEY (`rol_per_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `roles_permissions`
--


-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `tsk_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prj_id` int(10) unsigned NOT NULL,
  `trk_id` int(10) unsigned NOT NULL,
  `mln_id` int(10) unsigned DEFAULT NULL,
  `tsk_owner` int(10) unsigned NOT NULL,
  `tsk_assigned` int(10) unsigned DEFAULT NULL,
  `tsk_name` varchar(255) NOT NULL,
  `tsk_description` text,
  `tsk_date_start` date DEFAULT NULL,
  `tsk_date_due` date DEFAULT NULL,
  `tsk_date_complete` date DEFAULT NULL,
  `tsk_status` int(10) unsigned NOT NULL,
  `tsk_priority` int(10) unsigned NOT NULL,
  `tsk_parent` int(10) unsigned DEFAULT NULL,
  `tsk_completion` int(10) unsigned NOT NULL,
  `tsk_comments` text,
  `tsk_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `tsk_datecreated` datetime NOT NULL,
  `tsk_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`tsk_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`tsk_id`, `prj_id`, `trk_id`, `mln_id`, `tsk_owner`, `tsk_assigned`, `tsk_name`, `tsk_description`, `tsk_date_start`, `tsk_date_due`, `tsk_date_complete`, `tsk_status`, `tsk_priority`, `tsk_parent`, `tsk_completion`, `tsk_comments`, `tsk_published`, `tsk_datecreated`, `tsk_datemodified`) VALUES
(1, 1, 1, NULL, 1, 1, 'Test', NULL, NULL, NULL, NULL, 1, 1, NULL, 90, NULL, 0, '2014-02-21 09:22:25', '2014-02-21 09:47:15'),
(2, 1, 1, NULL, 1, NULL, 'Test name', 'Description', NULL, NULL, NULL, 1, 2, NULL, 20, NULL, 0, '2014-02-21 09:33:07', '2014-02-21 09:34:54'),
(3, 1, 2, NULL, 1, 1, 'Test name', NULL, NULL, NULL, NULL, 1, 2, NULL, 10, NULL, 0, '2014-02-21 09:38:16', NULL),
(4, 2, 1, NULL, 1, NULL, 'Test', NULL, NULL, NULL, NULL, 1, 2, NULL, 10, NULL, 0, '2014-02-21 09:59:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `tcs_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prj_id` int(10) unsigned NOT NULL,
  `tcs_owner` int(10) unsigned NOT NULL,
  `tcs_name` varchar(255) DEFAULT NULL,
  `tcs_status` int(10) unsigned NOT NULL,
  `tcs_priority` int(10) unsigned NOT NULL,
  `tcs_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `tcs_datecreated` datetime NOT NULL,
  PRIMARY KEY (`tcs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `topics`
--


-- --------------------------------------------------------

--
-- Table structure for table `trackers`
--

DROP TABLE IF EXISTS `trackers`;
CREATE TABLE IF NOT EXISTS `trackers` (
  `trk_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trk_owner` int(10) unsigned NOT NULL,
  `trk_name` varchar(255) NOT NULL,
  `tsk_description` text,
  `trk_datecreated` datetime NOT NULL,
  PRIMARY KEY (`trk_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `trackers`
--

INSERT INTO `trackers` (`trk_id`, `trk_owner`, `trk_name`, `tsk_description`, `trk_datecreated`) VALUES
(1, 1, 'Features', NULL, '2014-02-20 22:09:10'),
(2, 1, 'Tickets', NULL, '2014-02-20 22:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `_configuration`
--

CREATE TABLE IF NOT EXISTS `_configuration` (
  `cfg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cfg_path` varchar(255) NOT NULL,
  `cfg_value` text,
  `cfg_datecreated` datetime NOT NULL,
  PRIMARY KEY (`cfg_id`),
  UNIQUE KEY `cfg_path` (`cfg_path`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `_configuration`
--

INSERT INTO `_configuration` (`cfg_id`, `cfg_path`, `cfg_value`, `cfg_datecreated`) VALUES
(1, 'phpcollab/installed', '1', '2014-02-21 04:48:36'),
(2, 'tinymce/enabled', '1', '2014-02-21 04:48:36'),
(3, 'tinymce/init/selector', '.wysiwyg', '2014-02-21 04:48:36'),
(4, 'tinymce/init/remove_script_host', 'true', '2014-02-21 04:48:36'),
(5, 'tinymce/init/relative_urls', 'false', '2014-02-21 04:48:36'),
(6, 'tinymce/init/plugins', 'advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker searchreplace wordcount visualblocks visualchars code fullscreen media nonbreaking table contextmenu directionality template paste', '2014-02-21 04:48:36'),
(7, 'tinymce/init/toolbar1', 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect', '2014-02-21 04:48:36'),
(8, 'tinymce/init/toolbar2', 'cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code', '2014-02-21 04:48:36'),
(9, 'tinymce/init/toolbar3', 'table | hr removeformat | subscript superscript | charmap | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft', '2014-02-21 04:48:36'),
(10, 'tinymce/init/menubar', 'false', '2014-02-21 04:48:36'),
(11, 'tinymce/init/toolbar_items_size', 'small', '2014-02-21 04:48:36'),
(12, 'tinymce/cdn', '//tinymce.cachefly.net/4.0/tinymce.min.js', '2014-02-21 04:48:36'),
(13, 'font-awesome/cdn', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', '2014-02-21 04:48:36'),
(14, 'phpcollab/title', 'phpCollab', '2014-02-21 04:50:20'),
(15, 'phpcollab/driver/auth', 'default', '2014-02-21 04:57:00'),
(16, 'phpcollab/driver/auth/default/salt', NULL, '0000-00-00 00:00:00'),
(17, 'debug/enabled', '1', '2014-02-21 09:49:17'),
(18, 'environment', 'dev', '2014-02-21 09:49:24'),
(19, 'phpcollab/icons/projects', 'leaf', '0000-00-00 00:00:00'),
(20, 'phpcollab/icons/tasks', 'tasks', '0000-00-00 00:00:00'),
(21, 'phpcollab/icons/projects_members', 'rocket', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `_connections`
--

DROP TABLE IF EXISTS `_connections`;
CREATE TABLE IF NOT EXISTS `_connections` (
  `cnt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mbr_id` int(10) unsigned NOT NULL,
  `token_connection` char(40) NOT NULL,
  `cnt_ip` varchar(255) DEFAULT NULL,
  `cnt_agent` varchar(255) NOT NULL,
  `cnt_datecreated` datetime NOT NULL,
  PRIMARY KEY (`cnt_id`),
  UNIQUE KEY `token_connection` (`token_connection`),
  KEY `mbr_id` (`mbr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `_connections`
--

INSERT INTO `_connections` (`cnt_id`, `mbr_id`, `token_connection`, `cnt_ip`, `cnt_agent`, `cnt_datecreated`) VALUES
(2, 1, '5619da81c3da39fe9873944d99e558bd45718991', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '2014-02-21 05:23:46'),
(3, 1, 'b52a64716379baa6213670db0750d4f4b402d74c', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.117 Safari/537.36', '2014-02-21 04:57:45'),
(4, 1, '8c0e41b3fbad8053522cdf8696e1c4a8f124a914', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.117 Safari/537.36', '2014-02-21 08:20:53'),
(5, 1, 'cb4409b37088570d67892c2ab613582b78bba63a', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:27.0) Gecko/20100101 Firefox/27.0', '2014-02-21 10:12:58');

-- --------------------------------------------------------

--
-- Table structure for table `_languages`
--

DROP TABLE IF EXISTS `_languages`;
CREATE TABLE IF NOT EXISTS `_languages` (
  `lng_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lng_code` char(2) NOT NULL,
  `lng_name` varchar(255) NOT NULL,
  `lng_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lng_datecreated` datetime NOT NULL,
  PRIMARY KEY (`lng_id`),
  UNIQUE KEY `lng_code` (`lng_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000001 ;

--
-- Dumping data for table `_languages`
--

INSERT INTO `_languages` (`lng_id`, `lng_code`, `lng_name`, `lng_default`, `lng_datecreated`) VALUES
(1, 'en', 'English', 1, '2014-02-08 07:33:59'),
(2, 'fr', 'Français', 0, '2014-02-08 07:33:59');
