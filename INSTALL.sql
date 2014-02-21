-- --------------------------------------------------------

--
-- Table structure for table `files`
--

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
  `mbr_authorized` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mbr_comments` text,
  `mbr_datecreated` datetime NOT NULL,
  `mbr_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`mbr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`mbr_id`, `org_id`, `mbr_name`, `mbr_description`, `mbr_email`, `mbr_password`, `mbr_authorized`, `mbr_comments`, `mbr_datecreated`, `mbr_datemodified`) VALUES
(1, 1, 'Example', 'test 2', 'example@example.com', 'c3499c2729730a7f807efb8676a92dcb6f8a3f8f', 1, NULL, '2014-02-20 22:09:54', '2014-02-21 11:54:23'),
(4, 1, 'Example', NULL, 'example2@example.com', '30e0c510958c33b6a29f8b7ec2b640fe022f80ad', 1, NULL, '2014-02-21 11:47:57', '2014-02-21 12:05:39'),
(5, 2, 'Client 1', NULL, 'client@example.com', 'c3499c2729730a7f807efb8676a92dcb6f8a3f8f', 1, NULL, '2014-02-21 11:51:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `members_notifications`
--

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

CREATE TABLE IF NOT EXISTS `members_roles` (
  `mbr_rol_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mbr_id` int(10) unsigned NOT NULL,
  `rol_id` int(10) unsigned NOT NULL,
  `mbr_rol_datecreated` datetime NOT NULL,
  PRIMARY KEY (`mbr_rol_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
  `mln_comments` text,
  `mln_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mln_datecreated` datetime NOT NULL,
  `mln_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`mln_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `milestones`
--

INSERT INTO `milestones` (`mln_id`, `prj_id`, `mln_owner`, `mln_name`, `mln_description`, `mln_date_start`, `mln_date_due`, `mln_date_complete`, `mln_status`, `mln_priority`, `mln_comments`, `mln_published`, `mln_datecreated`, `mln_datemodified`) VALUES
(1, 1, 1, 'Test step 1', NULL, '2014-02-23', NULL, NULL, 1, 2, NULL, 0, '2014-02-21 13:30:59', NULL),
(2, 2, 1, 'MIlestone other project', NULL, '2014-02-23', NULL, NULL, 1, 2, NULL, 0, '2014-02-21 13:35:32', NULL),
(3, 1, 1, 'Test step 2', NULL, '2014-02-23', NULL, NULL, 2, 2, NULL, 0, '2014-02-21 13:43:27', NULL);

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
  PRIMARY KEY (`nte_id`)
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
(14, 'files_projects/index', '0000-00-00 00:00:00'),
(15, 'files_projects/create', '0000-00-00 00:00:00'),
(16, 'files_projects/read/comments', '0000-00-00 00:00:00'),
(17, 'files_projects/update', '0000-00-00 00:00:00'),
(18, 'files_projects/delete', '0000-00-00 00:00:00'),
(19, 'files_tasks/index', '0000-00-00 00:00:00'),
(20, 'files_tasks/create', '0000-00-00 00:00:00'),
(21, 'files_tasks/read/comments', '0000-00-00 00:00:00'),
(22, 'files_tasks/update', '0000-00-00 00:00:00'),
(23, 'files_tasks/delete', '0000-00-00 00:00:00'),
(24, 'members/index', '0000-00-00 00:00:00'),
(25, 'members/create', '0000-00-00 00:00:00'),
(26, 'members/read/comments', '0000-00-00 00:00:00'),
(27, 'members/update', '0000-00-00 00:00:00'),
(28, 'members/update/comments', '0000-00-00 00:00:00'),
(29, 'members/delete', '0000-00-00 00:00:00'),
(35, 'milestones/index', '0000-00-00 00:00:00'),
(36, 'milestones/create', '0000-00-00 00:00:00'),
(37, 'milestones/read/comments', '0000-00-00 00:00:00'),
(38, 'milestones/update', '0000-00-00 00:00:00'),
(39, 'milestones/update/date_start', '0000-00-00 00:00:00'),
(40, 'milestones/update/date_due', '0000-00-00 00:00:00'),
(41, 'milestones/update/date_complete', '0000-00-00 00:00:00'),
(42, 'milestones/update/status', '0000-00-00 00:00:00'),
(43, 'milestones/update/priority', '0000-00-00 00:00:00'),
(44, 'milestones/update/comments', '0000-00-00 00:00:00'),
(45, 'milestones/update/published', '0000-00-00 00:00:00'),
(46, 'milestones/delete', '0000-00-00 00:00:00'),
(47, 'notes/index', '0000-00-00 00:00:00'),
(48, 'notes/create', '0000-00-00 00:00:00'),
(49, 'notes/read/comments', '0000-00-00 00:00:00'),
(50, 'notes/update', '0000-00-00 00:00:00'),
(51, 'notes/update/published', '0000-00-00 00:00:00'),
(52, 'notes/delete', '0000-00-00 00:00:00'),
(53, 'notifications/index', '0000-00-00 00:00:00'),
(54, 'notifications/create', '0000-00-00 00:00:00'),
(55, 'notifications/read/comments', '0000-00-00 00:00:00'),
(56, 'notifications/update', '0000-00-00 00:00:00'),
(57, 'notifications/delete', '0000-00-00 00:00:00'),
(58, 'organizations/index', '0000-00-00 00:00:00'),
(59, 'organizations/create', '0000-00-00 00:00:00'),
(60, 'organizations/read/comments', '0000-00-00 00:00:00'),
(61, 'organizations/update', '0000-00-00 00:00:00'),
(62, 'organizations/update/comments', '0000-00-00 00:00:00'),
(63, 'organizations/delete', '0000-00-00 00:00:00'),
(64, 'permissions/index', '0000-00-00 00:00:00'),
(65, 'permissions/create', '0000-00-00 00:00:00'),
(66, 'permissions/read/comments', '0000-00-00 00:00:00'),
(67, 'permissions/update', '0000-00-00 00:00:00'),
(68, 'permissions/delete', '0000-00-00 00:00:00'),
(69, 'posts/create', '0000-00-00 00:00:00'),
(70, 'posts/delete', '0000-00-00 00:00:00'),
(71, 'projects/index', '0000-00-00 00:00:00'),
(72, 'projects/create', '0000-00-00 00:00:00'),
(73, 'projects/read/comments', '0000-00-00 00:00:00'),
(74, 'projects/update', '0000-00-00 00:00:00'),
(75, 'projects/update/date_start', '0000-00-00 00:00:00'),
(76, 'projects/update/date_due', '0000-00-00 00:00:00'),
(77, 'projects/update/date_complete', '0000-00-00 00:00:00'),
(78, 'projects/update/status', '0000-00-00 00:00:00'),
(79, 'projects/update/priority', '0000-00-00 00:00:00'),
(80, 'projects/update/comments', '0000-00-00 00:00:00'),
(81, 'projects/update/published', '0000-00-00 00:00:00'),
(82, 'projects/delete', '0000-00-00 00:00:00'),
(83, 'projects_members/index', '0000-00-00 00:00:00'),
(84, 'projects_members/create', '0000-00-00 00:00:00'),
(85, 'projects_members/read/comments', '0000-00-00 00:00:00'),
(86, 'projects_members/update', '0000-00-00 00:00:00'),
(87, 'projects_members/delete', '0000-00-00 00:00:00'),
(88, 'projects_trackers/index', '0000-00-00 00:00:00'),
(89, 'projects_trackers/create', '0000-00-00 00:00:00'),
(90, 'projects_trackers/read/comments', '0000-00-00 00:00:00'),
(91, 'projects_trackers/update', '0000-00-00 00:00:00'),
(92, 'projects_trackers/delete', '0000-00-00 00:00:00'),
(93, 'roles/index', '0000-00-00 00:00:00'),
(94, 'roles/create', '0000-00-00 00:00:00'),
(95, 'roles/read/comments', '0000-00-00 00:00:00'),
(96, 'roles/update', '0000-00-00 00:00:00'),
(97, 'roles/delete', '0000-00-00 00:00:00'),
(98, 'roles_permissions/index', '0000-00-00 00:00:00'),
(99, 'roles_permissions/create', '0000-00-00 00:00:00'),
(100, 'roles_permissions/read/comments', '0000-00-00 00:00:00'),
(101, 'roles_permissions/update', '0000-00-00 00:00:00'),
(102, 'roles_permissions/delete', '0000-00-00 00:00:00'),
(103, 'tasks/index', '0000-00-00 00:00:00'),
(104, 'tasks/create', '0000-00-00 00:00:00'),
(105, 'tasks/read/comments', '0000-00-00 00:00:00'),
(106, 'tasks/update', '0000-00-00 00:00:00'),
(107, 'tasks/update/date_start', '0000-00-00 00:00:00'),
(108, 'tasks/update/date_due', '0000-00-00 00:00:00'),
(109, 'tasks/update/date_complete', '0000-00-00 00:00:00'),
(110, 'tasks/update/status', '0000-00-00 00:00:00'),
(111, 'tasks/update/priority', '0000-00-00 00:00:00'),
(112, 'tasks/update/comments', '0000-00-00 00:00:00'),
(113, 'tasks/update/published', '0000-00-00 00:00:00'),
(114, 'tasks/delete', '0000-00-00 00:00:00'),
(115, 'topics/index', '0000-00-00 00:00:00'),
(116, 'topics/create', '0000-00-00 00:00:00'),
(117, 'topics/read/comments', '0000-00-00 00:00:00'),
(118, 'topics/update', '0000-00-00 00:00:00'),
(119, 'topics/update/status', '0000-00-00 00:00:00'),
(120, 'topics/update/priority', '0000-00-00 00:00:00'),
(121, 'topics/update/published', '0000-00-00 00:00:00'),
(122, 'topics/delete', '0000-00-00 00:00:00'),
(123, 'trackers/index', '0000-00-00 00:00:00'),
(124, 'trackers/create', '0000-00-00 00:00:00'),
(125, 'trackers/read/comments', '0000-00-00 00:00:00'),
(126, 'trackers/update', '0000-00-00 00:00:00'),
(127, 'trackers/delete', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`prj_id`, `org_id`, `prj_owner`, `prj_name`, `prj_description`, `prj_date_start`, `prj_date_due`, `prj_date_complete`, `prj_status`, `prj_priority`, `prj_comments`, `prj_published`, `prj_datecreated`, `prj_datemodified`) VALUES
(1, 2, 1, 'Test', NULL, '2014-02-22', '2014-02-27', '2014-02-28', 1, 1, NULL, 1, '2014-02-21 04:34:49', '2014-02-21 14:24:27'),
(2, 1, 1, 'Test 2', NULL, '2014-02-20', NULL, NULL, 1, 3, NULL, 0, '2014-02-21 08:57:46', '2014-02-21 13:59:27'),
(3, 1, 1, 'Urgent project', NULL, '2014-02-20', NULL, NULL, 2, 4, NULL, 0, '2014-02-21 14:03:14', NULL);

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
  PRIMARY KEY (`prj_mbr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `projects_members`
--

INSERT INTO `projects_members` (`prj_mbr_id`, `prj_id`, `mbr_id`, `prj_mbr_authorized`, `prj_mbr_published`, `prj_mbr_datecreated`) VALUES
(2, 1, 1, 0, 0, '2014-02-21 08:39:20'),
(3, 2, 1, 1, 1, '2014-02-21 08:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `projects_trackers`
--

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

CREATE TABLE IF NOT EXISTS `roles` (
  `rol_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol_code` varchar(255) NOT NULL,
  `rol_system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rol_datecreated` datetime NOT NULL,
  PRIMARY KEY (`rol_id`),
  UNIQUE KEY `rol_code` (`rol_code`)
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

CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `rol_per_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol_id` int(10) unsigned NOT NULL,
  `per_id` int(10) unsigned NOT NULL,
  `rol_per_datecreated` datetime NOT NULL,
  PRIMARY KEY (`rol_per_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=125 ;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`rol_per_id`, `rol_id`, `per_id`, `rol_per_datecreated`) VALUES
(1, 1, 2, '2014-02-21 15:12:22'),
(2, 1, 8, '2014-02-21 15:12:22'),
(3, 1, 1, '2014-02-21 15:12:22'),
(4, 1, 3, '2014-02-21 15:12:22'),
(5, 1, 4, '2014-02-21 15:12:22'),
(6, 1, 6, '2014-02-21 15:12:22'),
(7, 1, 7, '2014-02-21 15:12:22'),
(8, 1, 5, '2014-02-21 15:12:22'),
(9, 1, 10, '2014-02-21 15:12:22'),
(10, 1, 13, '2014-02-21 15:12:22'),
(11, 1, 9, '2014-02-21 15:12:22'),
(12, 1, 11, '2014-02-21 15:12:22'),
(13, 1, 12, '2014-02-21 15:12:22'),
(14, 1, 15, '2014-02-21 15:12:22'),
(15, 1, 18, '2014-02-21 15:12:22'),
(16, 1, 14, '2014-02-21 15:12:22'),
(17, 1, 16, '2014-02-21 15:12:22'),
(18, 1, 17, '2014-02-21 15:12:22'),
(19, 1, 20, '2014-02-21 15:12:22'),
(20, 1, 23, '2014-02-21 15:12:22'),
(21, 1, 19, '2014-02-21 15:12:22'),
(22, 1, 21, '2014-02-21 15:12:22'),
(23, 1, 22, '2014-02-21 15:12:22'),
(24, 1, 25, '2014-02-21 15:12:22'),
(25, 1, 29, '2014-02-21 15:12:22'),
(26, 1, 24, '2014-02-21 15:12:22'),
(27, 1, 26, '2014-02-21 15:12:22'),
(28, 1, 27, '2014-02-21 15:12:22'),
(29, 1, 28, '2014-02-21 15:12:22'),
(30, 1, 36, '2014-02-21 15:12:22'),
(31, 1, 46, '2014-02-21 15:12:22'),
(32, 1, 35, '2014-02-21 15:12:22'),
(33, 1, 37, '2014-02-21 15:12:22'),
(34, 1, 38, '2014-02-21 15:12:22'),
(35, 1, 44, '2014-02-21 15:12:22'),
(36, 1, 41, '2014-02-21 15:12:22'),
(37, 1, 40, '2014-02-21 15:12:22'),
(38, 1, 39, '2014-02-21 15:12:22'),
(39, 1, 43, '2014-02-21 15:12:22'),
(40, 1, 45, '2014-02-21 15:12:22'),
(41, 1, 42, '2014-02-21 15:12:22'),
(42, 1, 48, '2014-02-21 15:12:22'),
(43, 1, 52, '2014-02-21 15:12:22'),
(44, 1, 47, '2014-02-21 15:12:22'),
(45, 1, 49, '2014-02-21 15:12:22'),
(46, 1, 50, '2014-02-21 15:12:22'),
(47, 1, 51, '2014-02-21 15:12:22'),
(48, 1, 54, '2014-02-21 15:12:22'),
(49, 1, 57, '2014-02-21 15:12:22'),
(50, 1, 53, '2014-02-21 15:12:22'),
(51, 1, 55, '2014-02-21 15:12:22'),
(52, 1, 56, '2014-02-21 15:12:22'),
(53, 1, 59, '2014-02-21 15:12:22'),
(54, 1, 63, '2014-02-21 15:12:22'),
(124, 1, 58, '2014-02-21 15:30:00'),
(56, 1, 60, '2014-02-21 15:12:22'),
(57, 1, 61, '2014-02-21 15:12:22'),
(58, 1, 62, '2014-02-21 15:12:22'),
(59, 1, 65, '2014-02-21 15:12:22'),
(60, 1, 68, '2014-02-21 15:12:22'),
(61, 1, 64, '2014-02-21 15:12:22'),
(62, 1, 66, '2014-02-21 15:12:22'),
(63, 1, 67, '2014-02-21 15:12:22'),
(64, 1, 69, '2014-02-21 15:12:22'),
(65, 1, 70, '2014-02-21 15:12:22'),
(66, 1, 72, '2014-02-21 15:12:22'),
(67, 1, 82, '2014-02-21 15:12:22'),
(68, 1, 71, '2014-02-21 15:12:22'),
(69, 1, 73, '2014-02-21 15:12:22'),
(70, 1, 74, '2014-02-21 15:12:22'),
(71, 1, 80, '2014-02-21 15:12:22'),
(72, 1, 77, '2014-02-21 15:12:22'),
(73, 1, 76, '2014-02-21 15:12:22'),
(74, 1, 75, '2014-02-21 15:12:22'),
(75, 1, 79, '2014-02-21 15:12:22'),
(76, 1, 81, '2014-02-21 15:12:22'),
(77, 1, 78, '2014-02-21 15:12:22'),
(78, 1, 84, '2014-02-21 15:12:22'),
(79, 1, 87, '2014-02-21 15:12:22'),
(80, 1, 83, '2014-02-21 15:12:22'),
(81, 1, 85, '2014-02-21 15:12:22'),
(82, 1, 86, '2014-02-21 15:12:22'),
(83, 1, 89, '2014-02-21 15:12:22'),
(84, 1, 92, '2014-02-21 15:12:22'),
(85, 1, 88, '2014-02-21 15:12:22'),
(86, 1, 90, '2014-02-21 15:12:22'),
(87, 1, 91, '2014-02-21 15:12:22'),
(88, 1, 94, '2014-02-21 15:12:22'),
(89, 1, 97, '2014-02-21 15:12:22'),
(90, 1, 93, '2014-02-21 15:12:22'),
(91, 1, 95, '2014-02-21 15:12:22'),
(92, 1, 96, '2014-02-21 15:12:22'),
(93, 1, 99, '2014-02-21 15:12:22'),
(94, 1, 102, '2014-02-21 15:12:22'),
(95, 1, 98, '2014-02-21 15:12:22'),
(96, 1, 100, '2014-02-21 15:12:22'),
(97, 1, 101, '2014-02-21 15:12:22'),
(98, 1, 104, '2014-02-21 15:12:22'),
(99, 1, 114, '2014-02-21 15:12:22'),
(100, 1, 103, '2014-02-21 15:12:22'),
(101, 1, 105, '2014-02-21 15:12:22'),
(102, 1, 106, '2014-02-21 15:12:22'),
(103, 1, 112, '2014-02-21 15:12:22'),
(104, 1, 109, '2014-02-21 15:12:22'),
(105, 1, 108, '2014-02-21 15:12:22'),
(106, 1, 107, '2014-02-21 15:12:22'),
(107, 1, 111, '2014-02-21 15:12:22'),
(108, 1, 113, '2014-02-21 15:12:22'),
(109, 1, 110, '2014-02-21 15:12:22'),
(110, 1, 116, '2014-02-21 15:12:22'),
(111, 1, 122, '2014-02-21 15:12:22'),
(112, 1, 115, '2014-02-21 15:12:22'),
(113, 1, 117, '2014-02-21 15:12:22'),
(114, 1, 118, '2014-02-21 15:12:22'),
(115, 1, 120, '2014-02-21 15:12:22'),
(116, 1, 121, '2014-02-21 15:12:22'),
(117, 1, 119, '2014-02-21 15:12:22'),
(118, 1, 124, '2014-02-21 15:12:22'),
(119, 1, 127, '2014-02-21 15:12:22'),
(120, 1, 123, '2014-02-21 15:12:22'),
(121, 1, 125, '2014-02-21 15:12:22'),
(122, 1, 126, '2014-02-21 15:12:22');

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
  `tsk_comments` text,
  `tsk_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `tsk_datecreated` datetime NOT NULL,
  `tsk_datemodified` datetime DEFAULT NULL,
  PRIMARY KEY (`tsk_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`tsk_id`, `prj_id`, `trk_id`, `mln_id`, `tsk_owner`, `tsk_assigned`, `tsk_name`, `tsk_description`, `tsk_date_start`, `tsk_date_due`, `tsk_date_complete`, `tsk_status`, `tsk_priority`, `tsk_parent`, `tsk_completion`, `tsk_comments`, `tsk_published`, `tsk_datecreated`, `tsk_datemodified`) VALUES
(1, 1, 1, 1, 1, 1, 'Test', NULL, NULL, NULL, NULL, 1, 1, NULL, 90, NULL, 0, '2014-02-21 09:22:25', '2014-02-21 13:33:50'),
(2, 1, 1, 3, 1, NULL, 'Test name', 'Description', '2014-02-20', NULL, NULL, 1, 5, 1, 20, NULL, 0, '2014-02-21 09:33:07', '2014-02-21 14:28:23'),
(3, 1, 2, NULL, 1, 1, 'Test name', NULL, NULL, NULL, NULL, 1, 3, NULL, 10, NULL, 0, '2014-02-21 09:38:16', '2014-02-21 14:00:30'),
(4, 2, 1, NULL, 1, NULL, 'Test', NULL, NULL, NULL, NULL, 1, 2, NULL, 10, NULL, 0, '2014-02-21 09:59:25', NULL),
(5, 2, 1, NULL, 1, NULL, 'Test', NULL, NULL, NULL, NULL, 1, 2, NULL, 60, NULL, 0, '2014-02-21 12:19:32', NULL),
(6, 1, 1, 1, 1, 5, 'tsk_name', 'tsk_description', '0000-00-00', '0000-00-00', '0000-00-00', 1, 4, 1, 50, 'tsk_comments', 1, '2014-02-21 14:00:47', '2014-02-21 14:11:01'),
(7, 1, 1, 1, 1, 5, 'tsk_name', 'tsk_description', '0000-00-00', '0000-00-00', '0000-00-00', 1, 5, 1, 20, 'tsk_comments', 1, '2014-02-21 14:01:03', NULL),
(8, 2, 1, 2, 1, NULL, 'task other project', NULL, '2014-02-21', NULL, NULL, 2, 3, NULL, 60, NULL, 0, '2014-02-21 14:12:53', '2014-02-21 14:13:05');

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
  PRIMARY KEY (`tcs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

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
(26, 'phpcollab/icons/milestones', 'calendar', '0000-00-00 00:00:00');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

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
