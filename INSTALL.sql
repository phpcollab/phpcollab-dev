-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `att_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tsk_id` int(10) unsigned NOT NULL,
  `att_owner` int(10) unsigned NOT NULL,
  `att_name` varchar(255) NOT NULL,
  `att_size` int(10) NOT NULL,
  `att_datecreated` datetime NOT NULL,
  PRIMARY KEY (`att_id`),
  KEY `tsk_id` (`tsk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `attachments`
--


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
  `fle_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `fle_datecreated` datetime NOT NULL,
  PRIMARY KEY (`fle_id`),
  KEY `prj_id` (`prj_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `files`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `logs`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `logs_details`
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
  PRIMARY KEY (`mbr_id`),
  UNIQUE KEY `mbr_email` (`mbr_email`),
  UNIQUE KEY `mbr_forgotpassword` (`mbr_forgotpassword`),
  KEY `org_id` (`org_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`mbr_id`, `org_id`, `mbr_name`, `mbr_description`, `mbr_email`, `mbr_password`, `mbr_forgotpassword`, `mbr_authorized`, `mbr_datecreated`) VALUES
(1, 1, 'Example', NULL, 'example@example.com', 'c3499c2729730a7f807efb8676a92dcb6f8a3f8f', NULL, 1, NOW());

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `members_roles`
--

INSERT INTO `members_roles` (`mbr_rol_id`, `mbr_id`, `rol_id`, `mbr_rol_datecreated`) VALUES
(1, 1, 1, NOW());

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
(1, 'project/task/assigned', NOW()),
(2, 'project/member/created', NOW()),
(3, 'project/member/deleted', NOW()),
(4, 'project/topic/created', NOW()),
(5, 'project/topic/post/created', NOW()),
(6, 'project/task/updated', NOW()),
(7, 'project/task/created', NOW());

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`org_id`, `org_owner`, `org_name`, `org_description`, `org_authorized`, `org_system`, `org_datecreated`) VALUES
(1, 1, 'My company', NULL, 1, 1, NOW());

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`per_id`, `per_code`, `per_datecreated`) VALUES
(1, 'organizations/index', NOW()),
(2, 'organizations/create', NOW()),
(3, 'organizations/read/any', NOW()),
(4, 'organizations/read/ifowner', NOW()),
(5, 'organizations/read/ifmember', NOW()),
(6, 'organizations/update/any', NOW()),
(7, 'organizations/update/ifowner', NOW()),
(8, 'organizations/update/ifmember', NOW()),
(9, 'organizations/delete/any', NOW()),
(10, 'organizations/delete/ifowner', NOW()),
(12, 'projects/index', NOW()),
(13, 'projects/create', NOW()),
(14, 'projects/read/any', NOW()),
(15, 'projects/read/ifowner', NOW()),
(16, 'projects/read/ifmember', NOW()),
(17, 'projects/update/any', NOW()),
(18, 'projects/update/ifowner', NOW()),
(19, 'projects/update/ifmember', NOW()),
(20, 'projects/delete/any', NOW()),
(21, 'projects/delete/ifowner', NOW()),
(35, 'projects/read/onlypublished', NOW()),
(30, 'projects_members/manage/any', NOW()),
(31, 'projects_members/manage/ifowner', NOW()),
(32, 'projects_members/read/any', NOW()),
(33, 'projects_members/read/ifowner', NOW()),
(36, 'projects_members/read/ifmember', NOW()),
(34, 'projects_members/read/onlypublished', NOW()),
(37, 'tasks/read/onlypublished', NOW()),
(38, 'milestones/read/onlypublished', NOW()),
(39, 'topics/read/onlypublished', NOW()),
(40, 'notes/read/onlypublished', NOW()),
(41, 'files/read/onlypublished', NOW()),
(42, 'tasks/update/date_start', NOW()),
(43, 'tasks/update/date_due', NOW()),
(44, 'tasks/update/date_complete', NOW()),
(45, 'tasks/update/status', NOW()),
(46, 'tasks/update/priority', NOW()),
(47, 'tasks/update/published', NOW()),
(48, 'tasks/update/assigned', NOW()),
(49, 'tasks/update/owner', NOW()),
(52, 'tasks/read/onlyassigned', NOW()),
(53, 'tasks/delete/any', NOW()),
(54, 'tasks/delete/ifowner', NOW()),
(55, 'milestones/delete/any', NOW()),
(56, 'milestones/delete/ifowner', NOW()),
(57, 'topics/delete/any', NOW()),
(58, 'topics/delete/ifowner', NOW()),
(59, 'notes/delete/any', NOW()),
(60, 'notes/delete/ifowner', NOW()),
(61, 'files/delete/any', NOW()),
(62, 'files/delete/ifowner', NOW()),
(63, 'milestones/index', NOW()),
(64, 'files/index', NOW()),
(65, 'tasks/index', NOW()),
(66, 'topics/index', NOW()),
(67, 'notes/index', NOW()),
(68, 'calendar/index', NOW());

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`rol_id`, `rol_code`, `rol_system`, `rol_datecreated`) VALUES
(1, 'administrator', 1, NOW()),
(2, 'projectmanager', 1, NOW()),
(3, 'user', 1, NOW()),
(4, 'clientuser', 1, NOW()),
(5, 'accountmanager', 1, NOW());

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`rol_per_id`, `rol_id`, `per_id`, `rol_per_datecreated`) VALUES
(1, 1, 2, NOW()),
(2, 1, 9, NOW()),
(3, 1, 11, NOW()),
(50, 1, 46, NOW()),
(5, 1, 1, NOW()),
(6, 1, 3, NOW()),
(49, 1, 49, NOW()),
(48, 1, 42, NOW()),
(9, 1, 6, NOW()),
(47, 1, 43, NOW()),
(46, 1, 44, NOW()),
(12, 1, 13, NOW()),
(13, 1, 20, NOW()),
(14, 1, 22, NOW()),
(45, 1, 48, NOW()),
(16, 1, 12, NOW()),
(17, 1, 14, NOW()),
(66, 1, 68, NOW()),
(44, 1, 53, NOW()),
(20, 1, 17, NOW()),
(21, 1, 25, NOW()),
(22, 1, 24, NOW()),
(23, 1, 23, NOW()),
(43, 1, 50, NOW()),
(42, 1, 51, NOW()),
(26, 1, 27, NOW()),
(27, 1, 28, NOW()),
(28, 1, 26, NOW()),
(29, 2, 1, NOW()),
(30, 2, 3, NOW()),
(31, 2, 13, NOW()),
(32, 2, 21, NOW()),
(33, 2, 12, NOW()),
(34, 2, 14, NOW()),
(35, 2, 17, NOW()),
(36, 1, 29, NOW()),
(37, 1, 30, NOW()),
(38, 1, 32, NOW()),
(39, 1, 61, NOW()),
(40, 1, 55, NOW()),
(41, 1, 59, NOW()),
(51, 1, 47, NOW()),
(52, 1, 45, NOW()),
(53, 1, 57, NOW()),
(54, 9, 61, NOW()),
(55, 9, 56, NOW()),
(56, 9, 40, NOW()),
(57, 9, 1, NOW()),
(58, 9, 14, NOW()),
(59, 9, 33, NOW()),
(60, 9, 43, NOW()),
(61, 1, 64, NOW()),
(62, 1, 63, NOW()),
(63, 1, 67, NOW()),
(64, 1, 65, NOW()),
(65, 1, 66, NOW());

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
(1, 1, 'New', 0, 1, NOW()),
(2, 1, 'Re-opened', 0, 2, NOW()),
(3, 1, 'Suspended', 1, 3, NOW()),
(4, 1, 'Rejected', 1, 4, NOW()),
(5, 1, 'Done', 1, 5, NOW()),
(6, 1, 'Resolved', 1, 6, NOW());

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `trackers`
--

INSERT INTO `trackers` (`trk_id`, `trk_owner`, `trk_name`, `tsk_description`, `trk_datecreated`) VALUES
(1, 1, 'Feature', NULL, NOW()),
(2, 1, 'Issue', NULL, NOW()),
(3, 1, 'Bug', NULL, NOW()),
(4, 1, 'Support', NULL, NOW());

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `_configuration`
--

INSERT INTO `_configuration` (`cfg_id`, `cfg_path`, `cfg_value`, `cfg_datecreated`) VALUES
(1, 'phpcollab/installed', '1', NOW()),
(2, 'tinymce/enabled', '1', NOW()),
(3, 'tinymce/init/selector', '.wysiwyg', NOW()),
(4, 'tinymce/init/remove_script_host', 'true', NOW()),
(5, 'tinymce/init/relative_urls', 'false', NOW()),
(6, 'tinymce/init/plugins', 'advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker searchreplace wordcount visualblocks visualchars code fullscreen media nonbreaking table contextmenu directionality template paste', NOW()),
(7, 'tinymce/init/toolbar1', 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect', NOW()),
(8, 'tinymce/init/toolbar2', 'cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code', NOW()),
(9, 'tinymce/init/toolbar3', 'table | hr removeformat | subscript superscript | charmap | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft', NOW()),
(10, 'tinymce/init/menubar', 'false', NOW()),
(11, 'tinymce/init/toolbar_items_size', 'small', NOW()),
(12, 'tinymce/cdn', '//tinymce.cachefly.net/4.0/tinymce.min.js', NOW()),
(13, 'font-awesome/cdn', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', NOW()),
(14, 'phpcollab/title', 'phpCollab', NOW()),
(15, 'phpcollab/driver/auth', 'default', NOW()),
(16, 'phpcollab/driver/auth/default/salt', NULL, NOW()),
(17, 'debug/enabled', '1', NOW()),
(18, 'environment', 'dev', NOW()),
(19, 'phpcollab/icons/projects', 'leaf', NOW()),
(20, 'phpcollab/icons/tasks', 'tasks', NOW()),
(21, 'phpcollab/icons/projects_members', 'rocket', NOW()),
(22, 'phpcollab/icons/organizations', 'building-o', NOW()),
(23, 'phpcollab/icons/trackers', 'bullhorn', NOW()),
(24, 'phpcollab/icons/roles', 'shield', NOW()),
(25, 'phpcollab/icons/members', 'users', NOW()),
(26, 'phpcollab/icons/milestones', 'calendar', NOW()),
(27, 'phpcollab/default/status', '1', NOW()),
(28, 'phpcollab/default/priority', '2', NOW()),
(29, 'phpcollab/icons/statuses', 'sun-o', NOW()),
(30, 'phpcollab/icons/notes', 'file-text-o', NOW()),
(31, 'phpcollab/icons/files', 'cloud-upload', NOW()),
(32, 'sender/email', 'example@example.com', NOW()),
(33, 'sender/name', 'phpCollab', NOW()),
(34, 'phpcollab/icons/logs', 'bookmark', NOW()),
(35, 'phpcollab/icons/topics', 'comments', NOW()),
(36, 'phpcollab/icons/posts', 'comments', NOW()),
(37, 'phpcollab/enabled/notifications', '1', NOW()),
(38, 'phpcollab/icons/owner', 'star', NOW()),
(39, 'phpcollab/icons/published', 'exchange', NOW()),
(40, 'phpcollab/icons/ismember', 'rocket', NOW()),
(41, 'phpcollab/icons/notauthorized', 'lock', NOW()),
(42, 'phpcollab/icons/assigned', 'thumb-tack', NOW()),
(43, 'phpcollab/icons/calendar', 'calendar', NOW());

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `_connections`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `_languages`
--

INSERT INTO `_languages` (`lng_id`, `lng_code`, `lng_name`, `lng_default`, `lng_datecreated`) VALUES
(1, 'en', 'English', 1, NOW());
