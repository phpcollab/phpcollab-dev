-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE IF NOT EXISTS `assignments` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `task` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `assigned_to` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comments` text,
  `assigned` varchar(16) DEFAULT NULL,
  `subtask` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `task`, `owner`, `assigned_to`, `comments`, `assigned`, `subtask`) VALUES
(1, 1, 1, 0, NULL, '2012-03-08 21:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `category` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` text,
  `shared` char(1) NOT NULL DEFAULT '',
  `home` char(1) NOT NULL DEFAULT '',
  `comments` char(1) NOT NULL DEFAULT '',
  `users` varchar(255) DEFAULT NULL,
  `created` varchar(16) DEFAULT NULL,
  `modified` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bookmarks`
--


-- --------------------------------------------------------

--
-- Table structure for table `bookmarks_categories`
--

CREATE TABLE IF NOT EXISTS `bookmarks_categories` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bookmarks_categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(155) DEFAULT NULL,
  `description` text,
  `shortname` varchar(155) DEFAULT NULL,
  `date_start` varchar(10) DEFAULT NULL,
  `date_end` varchar(10) DEFAULT NULL,
  `time_start` varchar(155) DEFAULT NULL,
  `time_end` varchar(155) DEFAULT NULL,
  `reminder` char(1) NOT NULL DEFAULT '',
  `recurring` char(1) NOT NULL DEFAULT '',
  `recur_day` char(1) NOT NULL DEFAULT '',
  `broadcast` char(1) NOT NULL DEFAULT '',
  `location` varchar(155) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `calendar`
--


-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `task` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `date` varchar(16) DEFAULT NULL,
  `size` varchar(155) DEFAULT NULL,
  `extension` varchar(155) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `comments_approval` varchar(255) DEFAULT NULL,
  `approver` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `date_approval` varchar(16) DEFAULT NULL,
  `upload` varchar(16) DEFAULT NULL,
  `published` char(1) NOT NULL DEFAULT '',
  `status` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vc_status` varchar(255) NOT NULL DEFAULT '0',
  `vc_version` varchar(255) NOT NULL DEFAULT '0.0',
  `vc_parent` int(10) unsigned NOT NULL DEFAULT '0',
  `phase` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `files`
--


-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `header_note` text,
  `footer_note` text,
  `date_sent` varchar(10) DEFAULT NULL,
  `due_date` varchar(10) DEFAULT NULL,
  `total_ex_tax` float(10,2) NOT NULL DEFAULT '0.00',
  `tax_rate` float(10,2) NOT NULL DEFAULT '0.00',
  `tax_amount` float(10,2) NOT NULL DEFAULT '0.00',
  `total_inc_tax` float(10,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT '',
  `active` char(1) NOT NULL DEFAULT '',
  `created` varchar(16) DEFAULT NULL,
  `modified` varchar(16) DEFAULT NULL,
  `published` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `invoices`
--


-- --------------------------------------------------------

--
-- Table structure for table `invoices_items`
--

CREATE TABLE IF NOT EXISTS `invoices_items` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `invoice` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `position` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `mod_type` char(1) NOT NULL DEFAULT '',
  `mod_value` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` varchar(155) DEFAULT NULL,
  `description` text,
  `worked_hours` float(10,2) NOT NULL DEFAULT '0.00',
  `amount_ex_tax` float(10,2) NOT NULL DEFAULT '0.00',
  `rate_type` varchar(10) DEFAULT NULL,
  `rate_value` float(10,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT '',
  `active` char(1) NOT NULL DEFAULT '',
  `completed` char(1) NOT NULL DEFAULT '',
  `created` varchar(16) DEFAULT NULL,
  `modified` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `invoices_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(155) DEFAULT NULL,
  `password` varchar(155) DEFAULT NULL,
  `ip` varchar(155) DEFAULT NULL,
  `session` varchar(155) DEFAULT NULL,
  `compt` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `last_visite` varchar(16) DEFAULT NULL,
  `connected` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `login`, `password`, `ip`, `session`, `compt`, `last_visite`, `connected`) VALUES
(1, 'admin', 'adpexzg3FUZAk', '::1', 's3n9c8umiqjcrg8cu055fcacp1', 2, '2012-03-08 21:42', '1331241390');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `organization` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `login` varchar(155) DEFAULT NULL,
  `password` varchar(155) DEFAULT NULL,
  `name` varchar(155) DEFAULT NULL,
  `title` varchar(155) DEFAULT NULL,
  `email_work` varchar(155) DEFAULT NULL,
  `email_home` varchar(155) DEFAULT NULL,
  `phone_work` varchar(155) DEFAULT NULL,
  `phone_home` varchar(155) DEFAULT NULL,
  `mobile` varchar(155) DEFAULT NULL,
  `fax` varchar(155) DEFAULT NULL,
  `comments` text,
  `profil` char(1) NOT NULL DEFAULT '',
  `created` varchar(16) DEFAULT NULL,
  `logout_time` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `last_page` varchar(255) DEFAULT NULL,
  `timezone` char(3) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `organization`, `login`, `password`, `name`, `title`, `email_work`, `email_home`, `phone_work`, `phone_home`, `mobile`, `fax`, `comments`, `profil`, `created`, `logout_time`, `last_page`, `timezone`) VALUES
(1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2012-03-08 20:58', 0, NULL, ''),
(2, 1, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'Demo user', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4', '2012-03-08 20:58', 0, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `newsdeskcomments`
--

CREATE TABLE IF NOT EXISTS `newsdeskcomments` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `newsdeskcomments`
--


-- --------------------------------------------------------

--
-- Table structure for table `newsdeskposts`
--

CREATE TABLE IF NOT EXISTS `newsdeskposts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pdate` varchar(16) DEFAULT NULL,
  `title` varchar(155) DEFAULT NULL,
  `author` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `related` varchar(155) DEFAULT NULL,
  `content` text,
  `links` text,
  `rss` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `newsdeskposts`
--


-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic` varchar(255) DEFAULT NULL,
  `subject` varchar(155) DEFAULT NULL,
  `description` text,
  `date` varchar(10) DEFAULT NULL,
  `published` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `member` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `taskAssignment` char(1) NOT NULL DEFAULT '0',
  `removeProjectTeam` char(1) NOT NULL DEFAULT '0',
  `addProjectTeam` char(1) NOT NULL DEFAULT '0',
  `newTopic` char(1) NOT NULL DEFAULT '0',
  `newPost` char(1) NOT NULL DEFAULT '0',
  `statusTaskChange` char(1) NOT NULL DEFAULT '0',
  `priorityTaskChange` char(1) NOT NULL DEFAULT '0',
  `duedateTaskChange` char(1) NOT NULL DEFAULT '0',
  `clientAddTask` char(1) NOT NULL DEFAULT '0',
  `uploadFile` char(1) NOT NULL DEFAULT '0',
  `dailyAlert` char(1) NOT NULL DEFAULT '0',
  `weeklyAlert` char(1) NOT NULL DEFAULT '0',
  `pastdueAlert` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `member`, `taskAssignment`, `removeProjectTeam`, `addProjectTeam`, `newTopic`, `newPost`, `statusTaskChange`, `priorityTaskChange`, `duedateTaskChange`, `clientAddTask`, `uploadFile`, `dailyAlert`, `weeklyAlert`, `pastdueAlert`) VALUES
(1, 1, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1'),
(2, 2, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE IF NOT EXISTS `organizations` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `zip_code` varchar(155) DEFAULT NULL,
  `city` varchar(155) DEFAULT NULL,
  `country` varchar(155) DEFAULT NULL,
  `phone` varchar(155) DEFAULT NULL,
  `fax` varchar(155) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `email` varchar(155) DEFAULT NULL,
  `comments` text,
  `created` varchar(16) DEFAULT NULL,
  `extension_logo` char(3) NOT NULL DEFAULT '',
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `hourly_rate` float(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `address1`, `address2`, `zip_code`, `city`, `country`, `phone`, `fax`, `url`, `email`, `comments`, `created`, `extension_logo`, `owner`, `hourly_rate`) VALUES
(1, 'My Company Name', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-03-08 20:58', '', 0, 0.00),
(2, 'test organization', '', NULL, NULL, NULL, NULL, '', NULL, '', '', '', '2012-03-08 21:14', '', 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `phases`
--

CREATE TABLE IF NOT EXISTS `phases` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `order_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` varchar(10) DEFAULT NULL,
  `name` varchar(155) DEFAULT NULL,
  `date_start` varchar(10) DEFAULT NULL,
  `date_end` varchar(10) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `phases`
--


-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topic` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `member` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `created` varchar(16) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `organization` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `priority` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(155) DEFAULT NULL,
  `description` text,
  `url_dev` varchar(255) DEFAULT NULL,
  `url_prod` varchar(255) DEFAULT NULL,
  `created` varchar(16) DEFAULT NULL,
  `modified` varchar(16) DEFAULT NULL,
  `published` char(1) NOT NULL DEFAULT '',
  `upload_max` varchar(155) DEFAULT NULL,
  `phase_set` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `invoicing` char(1) NOT NULL DEFAULT '',
  `hourly_rate` float(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `organization`, `owner`, `priority`, `status`, `name`, `description`, `url_dev`, `url_prod`, `created`, `modified`, `published`, `upload_max`, `phase_set`, `invoicing`, `hourly_rate`) VALUES
(1, 2, 1, 0, 3, 'test', '', '', '', NULL, '2012-03-08 21:13', '', '', 0, '0', 0.00),
(2, 2, 0, 0, 0, 'test 2', '', '', '', NULL, NULL, '', NULL, 0, '', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(155) DEFAULT NULL,
  `projects` varchar(255) DEFAULT NULL,
  `members` varchar(255) DEFAULT NULL,
  `priorities` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date_due_start` varchar(10) DEFAULT NULL,
  `date_due_end` varchar(10) DEFAULT NULL,
  `created` varchar(16) DEFAULT NULL,
  `date_complete_start` varchar(10) DEFAULT NULL,
  `date_complete_end` varchar(10) DEFAULT NULL,
  `clients` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `reports`
--


-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(155) DEFAULT NULL,
  `name_print` varchar(155) DEFAULT NULL,
  `hourly_rate` float(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `services`
--


-- --------------------------------------------------------

--
-- Table structure for table `sorting`
--

CREATE TABLE IF NOT EXISTS `sorting` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `member` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `home_projects` varchar(155) DEFAULT NULL,
  `home_tasks` varchar(155) DEFAULT NULL,
  `home_discussions` varchar(155) DEFAULT NULL,
  `home_reports` varchar(155) DEFAULT NULL,
  `projects` varchar(155) DEFAULT NULL,
  `organizations` varchar(155) DEFAULT NULL,
  `project_tasks` varchar(155) DEFAULT NULL,
  `discussions` varchar(155) DEFAULT NULL,
  `project_discussions` varchar(155) DEFAULT NULL,
  `users` varchar(155) DEFAULT NULL,
  `team` varchar(155) DEFAULT NULL,
  `tasks` varchar(155) DEFAULT NULL,
  `report_tasks` varchar(155) DEFAULT NULL,
  `assignment` varchar(155) DEFAULT NULL,
  `reports` varchar(155) DEFAULT NULL,
  `files` varchar(155) DEFAULT NULL,
  `organization_projects` varchar(155) DEFAULT NULL,
  `notes` varchar(155) DEFAULT NULL,
  `calendar` varchar(155) DEFAULT NULL,
  `phases` varchar(155) DEFAULT NULL,
  `support_requests` varchar(155) DEFAULT NULL,
  `subtasks` varchar(155) DEFAULT NULL,
  `bookmarks` varchar(155) DEFAULT NULL,
  `invoices` varchar(155) DEFAULT NULL,
  `newsdesk` varchar(155) DEFAULT NULL,
  `home_subtasks` varchar(155) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sorting`
--

INSERT INTO `sorting` (`id`, `member`, `home_projects`, `home_tasks`, `home_discussions`, `home_reports`, `projects`, `organizations`, `project_tasks`, `discussions`, `project_discussions`, `users`, `team`, `tasks`, `report_tasks`, `assignment`, `reports`, `files`, `organization_projects`, `notes`, `calendar`, `phases`, `support_requests`, `subtasks`, `bookmarks`, `invoices`, `newsdesk`, `home_subtasks`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

CREATE TABLE IF NOT EXISTS `subtasks` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `task` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `priority` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `assigned_to` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(155) DEFAULT NULL,
  `description` text,
  `start_date` varchar(10) DEFAULT NULL,
  `due_date` varchar(10) DEFAULT NULL,
  `estimated_time` varchar(10) DEFAULT NULL,
  `actual_time` varchar(10) DEFAULT NULL,
  `comments` text,
  `completion` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `created` varchar(16) DEFAULT NULL,
  `modified` varchar(16) DEFAULT NULL,
  `assigned` varchar(16) DEFAULT NULL,
  `published` char(1) NOT NULL DEFAULT '',
  `complete_date` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `subtasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `support_posts`
--

CREATE TABLE IF NOT EXISTS `support_posts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `request_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `message` text,
  `date` varchar(16) DEFAULT NULL,
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `support_posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `support_requests`
--

CREATE TABLE IF NOT EXISTS `support_requests` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `status` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `member` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `priority` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `date_open` varchar(16) DEFAULT NULL,
  `date_close` varchar(16) DEFAULT NULL,
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `support_requests`
--


-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `priority` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `assigned_to` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(155) DEFAULT NULL,
  `description` text,
  `start_date` varchar(10) DEFAULT NULL,
  `due_date` varchar(10) DEFAULT NULL,
  `estimated_time` varchar(10) DEFAULT NULL,
  `actual_time` varchar(10) DEFAULT NULL,
  `comments` text,
  `completion` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `created` varchar(16) DEFAULT NULL,
  `modified` varchar(16) DEFAULT NULL,
  `assigned` varchar(16) DEFAULT NULL,
  `published` char(1) NOT NULL DEFAULT '',
  `parent_phase` int(10) unsigned NOT NULL DEFAULT '0',
  `complete_date` varchar(10) DEFAULT NULL,
  `invoicing` char(1) NOT NULL DEFAULT '',
  `worked_hours` float(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project`, `priority`, `status`, `owner`, `assigned_to`, `name`, `description`, `start_date`, `due_date`, `estimated_time`, `actual_time`, `comments`, `completion`, `created`, `modified`, `assigned`, `published`, `parent_phase`, `complete_date`, `invoicing`, `worked_hours`) VALUES
(1, 1, 0, 2, 1, 0, 'test', 'test', '2012-03-08', '--', '', '', '', 0, '2012-03-08 21:22', NULL, NULL, '1', 0, NULL, '0', 0.00),
(2, 1, 0, 0, 0, 0, 'test 2', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', 0, NULL, '', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `member` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `published` char(1) NOT NULL DEFAULT '',
  `authorized` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `project`, `member`, `published`, `authorized`) VALUES
(1, 1, 1, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `project` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(155) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT '',
  `last_post` varchar(16) DEFAULT NULL,
  `posts` smallint(5) unsigned NOT NULL DEFAULT '0',
  `published` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `topics`
--


-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE IF NOT EXISTS `updates` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(1) NOT NULL DEFAULT '',
  `item` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `member` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comments` text,
  `created` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `updates`
--

