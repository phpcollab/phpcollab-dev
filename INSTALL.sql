-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mbr_id` int(10) unsigned NOT NULL,
  `log_type` varchar(30) NOT NULL DEFAULT '',
  `log_reference` int(10) unsigned NOT NULL,
  `log_comments` text,
  `log_datecreated` datetime NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `mbr_id` (`mbr_id`),
  KEY `log_type` (`log_type`),
  KEY `log_reference` (`log_reference`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs_details`
--

CREATE TABLE IF NOT EXISTS `logs_details` (
  `log_dls_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_id` int(10) unsigned NOT NULL,
  `log_dls_field` varchar(30) NOT NULL DEFAULT '',
  `log_dls_old` text,
  `log_dls_new` text,
  PRIMARY KEY (`log_dls_id`),
  KEY `log_id` (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `fle_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prj_id` int(10) unsigned NOT NULL,
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
  PRIMARY KEY (`fle_id`),
  KEY `prj_id` (`prj_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `files`
--


-- --------------------------------------------------------

--
-- Table structure for table `files_milestones`
--

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
-- Table structure for table `files_tasks`
--

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

CREATE TABLE IF NOT EXISTS `members` (
  `mbr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_id` int(10) unsigned NOT NULL,
  `mbr_name` varchar(255) NOT NULL,
  `mbr_description` text,
  `mbr_email` varchar(255) NOT NULL,
  `mbr_password` char(40) NOT NULL,
  `mbr_forgotpassword` char(40) DEFAULT NULL,
  `mbr_authorized` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mbr_datecreated` datetime NOT NULL,
  `mbr_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`mbr_id`),
  UNIQUE KEY `mbr_email` (`mbr_email`),
  UNIQUE KEY `mbr_forgotpassword` (`mbr_forgotpassword`),
  KEY `org_id` (`org_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`mbr_id`, `org_id`, `mbr_name`, `mbr_description`, `mbr_email`, `mbr_password`, `mbr_authorized`, `mbr_datecreated`, `mbr_datemodified`) VALUES
(1, 1, 'Example', NULL, 'example@example.com', 'c3499c2729730a7f807efb8676a92dcb6f8a3f8f', 1, '2014-02-20 22:09:54', '2014-02-21 16:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `members_notifications`
--

CREATE TABLE IF NOT EXISTS `members_notifications` (
  `mbr_ntf_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mbr_id` int(10) unsigned NOT NULL,
  `ntf_id` int(10) unsigned NOT NULL,
  `mbr_ntf_datecreated` datetime NOT NULL,
  PRIMARY KEY (`mbr_ntf_id`),
  KEY `mbr_id` (`mbr_id`),
  KEY `ntf_id` (`ntf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `members_notifications`
--


-- --------------------------------------------------------

--
-- Table structure for table `members_roles`
--

CREATE TABLE IF NOT EXISTS `members_roles` (
  `mbr_rol_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mbr_id` int(10) unsigned NOT NULL,
  `rol_id` int(10) unsigned NOT NULL,
  `mbr_rol_datecreated` datetime NOT NULL,
  PRIMARY KEY (`mbr_rol_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=207 ;

--
-- Dumping data for table `members_roles`
--

INSERT INTO `members_roles` (`mbr_rol_id`, `mbr_id`, `rol_id`, `mbr_rol_datecreated`) VALUES
(1, 1, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

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
  `mln_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mln_datecreated` datetime NOT NULL,
  `mln_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`mln_id`),
  KEY `prj_id` (`prj_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `milestones`
--


-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `nte_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prj_id` int(10) unsigned NOT NULL,
  `nte_owner` int(10) unsigned NOT NULL,
  `nte_name` varchar(255) NOT NULL,
  `nte_description` text,
  `nte_date` date DEFAULT NULL,
  `nte_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `nte_datecreated` datetime NOT NULL,
  `nte_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`nte_id`),
  KEY `prj_id` (`prj_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `ntf_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ntf_code` varchar(255) NOT NULL,
  `ntf_datecreated` datetime NOT NULL,
  PRIMARY KEY (`ntf_id`),
  UNIQUE KEY `ntf_code` (`ntf_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`ntf_id`, `ntf_code`, `ntf_datecreated`) VALUES
(1, 'project/task/assigned', '0000-00-00 00:00:00'),
(2, 'project/member/created', '0000-00-00 00:00:00'),
(3, 'project/member/deleted', '0000-00-00 00:00:00'),
(4, 'project/topic/created', '0000-00-00 00:00:00'),
(5, 'project/topic/post/created', '0000-00-00 00:00:00'),
(6, 'project/task/updated', '0000-00-00 00:00:00'),
(7, 'project/task/created', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE IF NOT EXISTS `organizations` (
  `org_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_owner` int(10) unsigned NOT NULL,
  `org_name` varchar(255) NOT NULL,
  `org_description` text,
  `org_authorized` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `org_system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `org_datecreated` datetime NOT NULL,
  PRIMARY KEY (`org_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`org_id`, `org_owner`, `org_name`, `org_description`, `org_authorized`, `org_system`, `org_datecreated`) VALUES
(1, 1, 'My company', NULL, 1, 1, '2014-02-20 22:03:04');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `per_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `per_code` varchar(255) NOT NULL,
  `per_datecreated` datetime NOT NULL,
  PRIMARY KEY (`per_id`),
  UNIQUE KEY `per_code` (`per_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=128 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`per_id`, `per_code`, `per_datecreated`) VALUES
(1, 'files/index', '0000-00-00 00:00:00'),
(2, 'files/create', '0000-00-00 00:00:00'),
(3, 'files/read/comments', '0000-00-00 00:00:00'),
(4, 'files/update', '0000-00-00 00:00:00'),
(5, 'files/update/status', '0000-00-00 00:00:00'),
(6, 'files/update/comments', '0000-00-00 00:00:00'),
(7, 'files/update/published', '0000-00-00 00:00:00'),
(8, 'files/delete', '0000-00-00 00:00:00'),
(9, 'files_milestones/index', '0000-00-00 00:00:00'),
(10, 'files_milestones/create', '0000-00-00 00:00:00'),
(11, 'files_milestones/read/comments', '0000-00-00 00:00:00'),
(12, 'files_milestones/update', '0000-00-00 00:00:00'),
(13, 'files_milestones/delete', '0000-00-00 00:00:00'),
(19, 'files_tasks/index', '0000-00-00 00:00:00'),
(20, 'files_tasks/create', '0000-00-00 00:00:00'),
(21, 'files_tasks/read/comments', '0000-00-00 00:00:00'),
(22, 'files_tasks/update', '0000-00-00 00:00:00'),
(23, 'files_tasks/delete', '0000-00-00 00:00:00'),
(35, 'milestones/index', '0000-00-00 00:00:00'),
(36, 'milestones/create', '0000-00-00 00:00:00'),
(38, 'milestones/update', '0000-00-00 00:00:00'),
(39, 'milestones/update/date_start', '0000-00-00 00:00:00'),
(40, 'milestones/update/date_due', '0000-00-00 00:00:00'),
(41, 'milestones/update/date_complete', '0000-00-00 00:00:00'),
(42, 'milestones/update/status', '0000-00-00 00:00:00'),
(43, 'milestones/update/priority', '0000-00-00 00:00:00'),
(45, 'milestones/update/published', '0000-00-00 00:00:00'),
(46, 'milestones/delete', '0000-00-00 00:00:00'),
(47, 'notes/index', '0000-00-00 00:00:00'),
(48, 'notes/create', '0000-00-00 00:00:00'),
(50, 'notes/update', '0000-00-00 00:00:00'),
(51, 'notes/update/published', '0000-00-00 00:00:00'),
(52, 'notes/delete', '0000-00-00 00:00:00'),
(53, 'notifications/index', '0000-00-00 00:00:00'),
(54, 'notifications/create', '0000-00-00 00:00:00'),
(56, 'notifications/update', '0000-00-00 00:00:00'),
(57, 'notifications/delete', '0000-00-00 00:00:00'),
(58, 'organizations/index', '0000-00-00 00:00:00'),
(59, 'organizations/create', '0000-00-00 00:00:00'),
(61, 'organizations/update', '0000-00-00 00:00:00'),
(63, 'organizations/delete', '0000-00-00 00:00:00'),
(69, 'posts/create', '0000-00-00 00:00:00'),
(70, 'posts/delete', '0000-00-00 00:00:00'),
(71, 'projects/index', '0000-00-00 00:00:00'),
(72, 'projects/create', '0000-00-00 00:00:00'),
(74, 'projects/update', '0000-00-00 00:00:00'),
(75, 'projects/update/date_start', '0000-00-00 00:00:00'),
(76, 'projects/update/date_due', '0000-00-00 00:00:00'),
(77, 'projects/update/date_complete', '0000-00-00 00:00:00'),
(78, 'projects/update/status', '0000-00-00 00:00:00'),
(79, 'projects/update/priority', '0000-00-00 00:00:00'),
(81, 'projects/update/published', '0000-00-00 00:00:00'),
(82, 'projects/delete', '0000-00-00 00:00:00'),
(83, 'projects_members/index', '0000-00-00 00:00:00'),
(84, 'projects_members/create', '0000-00-00 00:00:00'),
(86, 'projects_members/update', '0000-00-00 00:00:00'),
(87, 'projects_members/delete', '0000-00-00 00:00:00'),
(103, 'tasks/index', '0000-00-00 00:00:00'),
(104, 'tasks/create', '0000-00-00 00:00:00'),
(106, 'tasks/update', '0000-00-00 00:00:00'),
(107, 'tasks/update/date_start', '0000-00-00 00:00:00'),
(108, 'tasks/update/date_due', '0000-00-00 00:00:00'),
(109, 'tasks/update/date_complete', '0000-00-00 00:00:00'),
(110, 'tasks/update/status', '0000-00-00 00:00:00'),
(111, 'tasks/update/priority', '0000-00-00 00:00:00'),
(113, 'tasks/update/published', '0000-00-00 00:00:00'),
(114, 'tasks/delete', '0000-00-00 00:00:00'),
(115, 'topics/index', '0000-00-00 00:00:00'),
(116, 'topics/create', '0000-00-00 00:00:00'),
(118, 'topics/update', '0000-00-00 00:00:00'),
(119, 'topics/update/status', '0000-00-00 00:00:00'),
(120, 'topics/update/priority', '0000-00-00 00:00:00'),
(121, 'topics/update/published', '0000-00-00 00:00:00'),
(122, 'topics/delete', '0000-00-00 00:00:00'),
(123, 'trackers/index', '0000-00-00 00:00:00'),
(124, 'trackers/create', '0000-00-00 00:00:00'),
(126, 'trackers/update', '0000-00-00 00:00:00'),
(127, 'trackers/delete', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `pst_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tcs_id` int(10) unsigned NOT NULL,
  `pst_owner` int(10) unsigned NOT NULL,
  `pst_description` text NOT NULL,
  `pst_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pst_datecreated` datetime NOT NULL,
  PRIMARY KEY (`pst_id`),
  KEY `tcs_id` (`tcs_id`),
  KEY `pst_owner` (`pst_owner`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

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
  `prj_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `prj_datecreated` datetime NOT NULL,
  `prj_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`prj_id`),
  KEY `org_id` (`org_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `projects`
--


-- --------------------------------------------------------

--
-- Table structure for table `projects_members`
--

CREATE TABLE IF NOT EXISTS `projects_members` (
  `prj_mbr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prj_id` int(10) unsigned NOT NULL,
  `mbr_id` int(10) unsigned NOT NULL,
  `prj_mbr_authorized` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `prj_mbr_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `prj_mbr_datecreated` datetime NOT NULL,
  PRIMARY KEY (`prj_mbr_id`),
  KEY `prj_id` (`prj_id`),
  KEY `mbr_id` (`mbr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `projects_members`
--


-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `rol_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol_code` varchar(255) NOT NULL,
  `rol_system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rol_datecreated` datetime NOT NULL,
  PRIMARY KEY (`rol_id`),
  UNIQUE KEY `rol_code` (`rol_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

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

CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `rol_per_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol_id` int(10) unsigned NOT NULL,
  `per_id` int(10) unsigned NOT NULL,
  `rol_per_datecreated` datetime NOT NULL,
  PRIMARY KEY (`rol_per_id`),
  KEY `rol_id` (`rol_id`),
  KEY `per_id` (`per_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`rol_per_id`, `rol_id`, `per_id`, `rol_per_datecreated`) VALUES
(1, 1, 2, '2014-02-22 02:59:46'),
(2, 1, 8, '2014-02-22 02:59:46'),
(3, 1, 1, '2014-02-22 02:59:46'),
(4, 1, 3, '2014-02-22 02:59:46'),
(5, 1, 4, '2014-02-22 02:59:46'),
(6, 1, 6, '2014-02-22 02:59:46'),
(7, 1, 7, '2014-02-22 02:59:46'),
(8, 1, 5, '2014-02-22 02:59:46'),
(9, 1, 10, '2014-02-22 02:59:46'),
(10, 1, 13, '2014-02-22 02:59:46'),
(11, 1, 9, '2014-02-22 02:59:46'),
(12, 1, 11, '2014-02-22 02:59:46'),
(13, 1, 12, '2014-02-22 02:59:46'),
(14, 1, 15, '2014-02-22 02:59:46'),
(15, 1, 18, '2014-02-22 02:59:46'),
(16, 1, 14, '2014-02-22 02:59:46'),
(17, 1, 16, '2014-02-22 02:59:46'),
(18, 1, 17, '2014-02-22 02:59:46'),
(19, 1, 20, '2014-02-22 02:59:46'),
(20, 1, 23, '2014-02-22 02:59:46'),
(21, 1, 19, '2014-02-22 02:59:46'),
(22, 1, 21, '2014-02-22 02:59:46'),
(23, 1, 22, '2014-02-22 02:59:46'),
(24, 1, 36, '2014-02-22 02:59:46'),
(25, 1, 46, '2014-02-22 02:59:46'),
(26, 1, 35, '2014-02-22 02:59:46'),
(27, 1, 37, '2014-02-22 02:59:46'),
(28, 1, 38, '2014-02-22 02:59:46'),
(29, 1, 44, '2014-02-22 02:59:46'),
(30, 1, 41, '2014-02-22 02:59:46'),
(31, 1, 40, '2014-02-22 02:59:46'),
(32, 1, 39, '2014-02-22 02:59:46'),
(33, 1, 43, '2014-02-22 02:59:46'),
(34, 1, 45, '2014-02-22 02:59:46'),
(35, 1, 42, '2014-02-22 02:59:46'),
(36, 1, 48, '2014-02-22 02:59:46'),
(37, 1, 52, '2014-02-22 02:59:46'),
(38, 1, 47, '2014-02-22 02:59:46'),
(39, 1, 49, '2014-02-22 02:59:46'),
(40, 1, 50, '2014-02-22 02:59:46'),
(41, 1, 51, '2014-02-22 02:59:46'),
(42, 1, 54, '2014-02-22 02:59:46'),
(43, 1, 57, '2014-02-22 02:59:46'),
(44, 1, 53, '2014-02-22 02:59:46'),
(45, 1, 55, '2014-02-22 02:59:46'),
(46, 1, 56, '2014-02-22 02:59:46'),
(47, 1, 59, '2014-02-22 02:59:46'),
(48, 1, 63, '2014-02-22 02:59:46'),
(49, 1, 58, '2014-02-22 02:59:46'),
(50, 1, 60, '2014-02-22 02:59:46'),
(51, 1, 61, '2014-02-22 02:59:46'),
(52, 1, 62, '2014-02-22 02:59:46'),
(58, 1, 69, '2014-02-22 02:59:46'),
(59, 1, 70, '2014-02-22 02:59:46'),
(60, 1, 72, '2014-02-22 02:59:46'),
(61, 1, 82, '2014-02-22 02:59:46'),
(62, 1, 71, '2014-02-22 02:59:46'),
(63, 1, 73, '2014-02-22 02:59:46'),
(64, 1, 74, '2014-02-22 02:59:46'),
(65, 1, 80, '2014-02-22 02:59:46'),
(66, 1, 77, '2014-02-22 02:59:46'),
(67, 1, 76, '2014-02-22 02:59:46'),
(68, 1, 75, '2014-02-22 02:59:46'),
(69, 1, 79, '2014-02-22 02:59:46'),
(70, 1, 81, '2014-02-22 02:59:46'),
(71, 1, 78, '2014-02-22 02:59:46'),
(72, 1, 84, '2014-02-22 02:59:46'),
(73, 1, 87, '2014-02-22 02:59:46'),
(74, 1, 83, '2014-02-22 02:59:46'),
(75, 1, 85, '2014-02-22 02:59:46'),
(76, 1, 86, '2014-02-22 02:59:46'),
(82, 1, 104, '2014-02-22 02:59:46'),
(83, 1, 114, '2014-02-22 02:59:46'),
(84, 1, 103, '2014-02-22 02:59:46'),
(85, 1, 105, '2014-02-22 02:59:46'),
(86, 1, 106, '2014-02-22 02:59:46'),
(87, 1, 112, '2014-02-22 02:59:46'),
(88, 1, 109, '2014-02-22 02:59:46'),
(89, 1, 108, '2014-02-22 02:59:46'),
(90, 1, 107, '2014-02-22 02:59:46'),
(91, 1, 111, '2014-02-22 02:59:46'),
(92, 1, 113, '2014-02-22 02:59:46'),
(93, 1, 110, '2014-02-22 02:59:46'),
(94, 1, 116, '2014-02-22 02:59:46'),
(95, 1, 122, '2014-02-22 02:59:46'),
(96, 1, 115, '2014-02-22 02:59:46'),
(97, 1, 117, '2014-02-22 02:59:46'),
(98, 1, 118, '2014-02-22 02:59:46'),
(99, 1, 120, '2014-02-22 02:59:46'),
(100, 1, 121, '2014-02-22 02:59:46'),
(101, 1, 119, '2014-02-22 02:59:46'),
(102, 1, 124, '2014-02-22 02:59:46'),
(103, 1, 127, '2014-02-22 02:59:46'),
(104, 1, 123, '2014-02-22 02:59:46'),
(105, 1, 125, '2014-02-22 02:59:46'),
(106, 1, 126, '2014-02-22 02:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `stu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stu_owner` int(10) unsigned NOT NULL,
  `stu_name` varchar(255) NOT NULL,
  `stu_isclosed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `stu_ordering` int(11) NOT NULL DEFAULT '0',
  `stu_datecreated` datetime NOT NULL,
  PRIMARY KEY (`stu_id`),
  KEY `stu_isclosed` (`stu_isclosed`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`stu_id`, `stu_owner`, `stu_name`, `stu_isclosed`, `stu_ordering`, `stu_datecreated`) VALUES
(1, 1, 'New', 0, 1, '2012-07-01 22:00:00'),
(2, 1, 'Re-opened', 0, 2, '2012-07-01 22:00:00'),
(3, 1, 'Suspended', 1, 3, '2012-07-01 22:00:00'),
(4, 1, 'Rejected', 1, 4, '2012-07-01 22:00:00'),
(5, 1, 'Done', 1, 5, '2012-07-01 22:00:00'),
(6, 1, 'Resolved', 1, 6, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

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
  `tsk_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `tsk_datecreated` datetime NOT NULL,
  `tsk_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`tsk_id`),
  KEY `prj_id` (`prj_id`),
  KEY `trk_id` (`trk_id`),
  KEY `mln_id` (`mln_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `tcs_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prj_id` int(10) unsigned NOT NULL,
  `tcs_owner` int(10) unsigned NOT NULL,
  `tcs_name` varchar(255) DEFAULT NULL,
  `tcs_status` int(10) unsigned NOT NULL,
  `tcs_priority` int(10) unsigned NOT NULL,
  `tcs_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `tcs_datecreated` datetime NOT NULL,
  `tcs_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`tcs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `topics`
--


-- --------------------------------------------------------

--
-- Table structure for table `trackers`
--

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
(1, 1, 'Feature', NULL, '2014-02-20 22:09:10'),
(2, 1, 'Issue', NULL, '2014-02-20 22:09:18'),
(3, 1, 'Bug', NULL, '2014-02-20 22:09:10'),
(4, 1, 'Support', NULL, '2014-02-20 22:09:18');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

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
(21, 'phpcollab/icons/projects_members', 'rocket', '0000-00-00 00:00:00'),
(22, 'phpcollab/icons/organizations', 'building-o', '0000-00-00 00:00:00'),
(23, 'phpcollab/icons/trackers', 'bullhorn', '0000-00-00 00:00:00'),
(24, 'phpcollab/icons/roles', 'shield', '0000-00-00 00:00:00'),
(25, 'phpcollab/icons/members', 'users', '2014-02-21 11:40:12'),
(26, 'phpcollab/icons/milestones', 'calendar', '0000-00-00 00:00:00'),
(27, 'phpcollab/default/status', '1', '2014-02-22 03:22:45'),
(28, 'phpcollab/default/priority', '2', '2014-02-22 03:24:18'),
(29, 'phpcollab/icons/statuses', 'sun-o', '2014-02-22 04:23:50'),
(30, 'phpcollab/icons/notes', 'file-text-o', '2014-02-22 04:41:52'),
(31, 'phpcollab/icons/files', 'cloud-upload', '2014-02-22 04:41:52'),
(32, 'sender/email', 'example@example.com', '2014-02-22 04:41:52'),
(33, 'sender/name', 'phpCollab', '2014-02-22 04:41:52'),
(34, 'phpcollab/icons/logs', 'bookmark', '2014-02-22 04:41:52'),
(35, 'phpcollab/icons/topics', 'comments', '2014-02-22 04:41:52'),
(36, 'phpcollab/icons/posts', 'comments', '2014-02-22 04:41:52'),
(37, 'phpcollab/enabled/notifications', '1', '2014-02-22 04:41:52'),
(38, 'phpcollab/icons/owner', 'star', '2014-02-22 04:41:52'),
(39, 'phpcollab/icons/published', 'eye', '2014-02-22 04:41:52'),
(40, 'phpcollab/icons/inteam', 'rocket', '2014-02-22 04:41:52'),
(41, 'phpcollab/icons/notauthorized', 'lock', '2014-02-22 04:41:52');

-- --------------------------------------------------------

--
-- Table structure for table `_connections`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `_languages`
--

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
(1, 'en', 'English', 1, '2014-02-08 07:33:59');
