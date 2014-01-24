-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 23, 2014 at 06:16 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `clean_repo`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl_levels`
--

DROP TABLE IF EXISTS `acl_levels`;
CREATE TABLE IF NOT EXISTS `acl_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `description` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `acl_levels`
--

INSERT INTO `acl_levels` VALUES(8, 11, 'people');
INSERT INTO `acl_levels` VALUES(2, 21, 'group');
INSERT INTO `acl_levels` VALUES(3, 31, 'branch');
INSERT INTO `acl_levels` VALUES(4, 41, 'customer');
INSERT INTO `acl_levels` VALUES(5, 51, 'agents');
INSERT INTO `acl_levels` VALUES(6, 61, 'partner');
INSERT INTO `acl_levels` VALUES(7, 71, 'ITSP');
INSERT INTO `acl_levels` VALUES(9, 81, 'OSM');
INSERT INTO `acl_levels` VALUES(10, 76, 'ITSP Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `home_phone` varchar(20) NOT NULL,
  `work_phone` varchar(20) NOT NULL,
  `work_extension` varchar(10) NOT NULL,
  `mobile_phone` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `gtalk` varchar(200) NOT NULL,
  `msn` varchar(200) NOT NULL,
  `yahoo` varchar(200) NOT NULL,
  `icq` varchar(50) NOT NULL,
  `im` varchar(200) NOT NULL,
  `facebook` varchar(200) NOT NULL,
  `twitter` varchar(200) NOT NULL,
  `myspace` varchar(200) NOT NULL,
  `orkut` varchar(200) NOT NULL,
  `www` varchar(255) NOT NULL,
  `secondary_email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1788 ;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` VALUES(2, '', '', '', '2146041551', '', 'enetto@opensourcemind.net', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `contact` VALUES(5, '', '', '', '2145561311', '', 'abc@abccompany.com', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `contact` VALUES(1783, '', '', '', '2143299894', '', 'cgranado@opensourcemind.net', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `contact` VALUES(1784, '', '', '', '6174020001', '', 'djbelieny@opensourcemind.net', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partner_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `time_zone` varchar(60) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=Cancelled,1=Active,2=Suspended',
  `cim_id` int(11) NOT NULL,
  `billing_location_id` int(11) NOT NULL,
  `shipping_location_id` int(11) NOT NULL,
  `e911_location_id` int(11) NOT NULL,
  `sales_rep` varchar(40) NOT NULL,
  `aniversary_date` varchar(4) NOT NULL,
  `first_month` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'Defines if the customer was created at this month and skip the first billing cycle',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62552 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` VALUES(61558, 1, 'Open Source Mind', 1, 2, 'US/Central', 3, 2158451, 3, 4, 2360, '', '99', 0);
INSERT INTO `customer` VALUES(62533, 1, 'ABC Company', 2, 5, 'US/Central', 1, 0, 0, 0, 0, '', '15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_widgets`
--

DROP TABLE IF EXISTS `dashboard_widgets`;
CREATE TABLE IF NOT EXISTS `dashboard_widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `widget_function` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `class` varchar(100) NOT NULL DEFAULT 'full',
  `dashboard_type` int(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `dashboard_widgets`
--

INSERT INTO `dashboard_widgets` VALUES(1, 'Server Properties', 'This is a test to List of Users Widget, This is a test to List of Users Widget. ', '', 'server_properties', 1, 'ui-state-default', 1);
INSERT INTO `dashboard_widgets` VALUES(2, 'Server Environment', 'This is a test to List of Devices Widget, \nThis is a test to List of Devices Widget,\nThis is a test to List of Devices Widget.', '', 'server_environment', 1, 'ui-state-default', 1);
INSERT INTO `dashboard_widgets` VALUES(3, 'Activity Log', 'This is a test to List of Phone Numbers Widget, This is a test to List of Phone Numbers Widget, This is a test to List of Phone Numbers Widget.', '', 'activity_logs', 1, 'ui-state-default', 1);
INSERT INTO `dashboard_widgets` VALUES(4, 'List of Trunks Test', 'This is a test to List of Trunks Widget, This is a test to List of Trunks Widget, This is a test to List of Trunks Widget.', '', 'dashboard_build_graph', 1, 'ui-state-default', 1);
INSERT INTO `dashboard_widgets` VALUES(5, 'Inbound/Outbound Reports', 'It shows the amount of Inbound/Outbound compared with the total amount of calls', NULL, 'show_inbound_outbound', 1, 'ui-state-default', 1);
INSERT INTO `dashboard_widgets` VALUES(6, 'Calls by hour', 'Calls by hour', NULL, 'show_calls_by_hour', 1, 'ui-state-default', 1);
INSERT INTO `dashboard_widgets` VALUES(7, 'Outbound Report', 'Outbound Report', NULL, 'outbound_dialer_report', 1, 'ui-state-default', 1);
INSERT INTO `dashboard_widgets` VALUES(8, 'Total Calls by Month', 'Total Calls by Month', NULL, 'total_calls_by_month', 1, 'ui-state-default', 1);
INSERT INTO `dashboard_widgets` VALUES(9, 'Account Plan', 'Shows Account plan', NULL, 'show_account_plan', 1, 'ui-state-default', 2);
INSERT INTO `dashboard_widgets` VALUES(10, 'Account Profile', 'Contact Information', 'Contact Information', 'show_contact_information', 1, 'ui-state-default', 2);
INSERT INTO `dashboard_widgets` VALUES(11, 'Tickets', 'Tickets', 'Tickets', 'show_tickets', 1, 'ui-state-default', 2);

-- --------------------------------------------------------

--
-- Table structure for table `fieldsets`
--

DROP TABLE IF EXISTS `fieldsets`;
CREATE TABLE IF NOT EXISTS `fieldsets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `css_class` varchar(50) NOT NULL,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `fieldsets`
--

INSERT INTO `fieldsets` VALUES(1, 0, 'default-open', 'default_open', '');
INSERT INTO `fieldsets` VALUES(2, 1, 'default-closed', 'default_closed', '');
INSERT INTO `fieldsets` VALUES(3, 0, 'campaign-info', 'default_open', 'Campaign Information (All fields are required)');
INSERT INTO `fieldsets` VALUES(4, 1, 'campaign-timestamp', 'default_closed', 'Date and Time');
INSERT INTO `fieldsets` VALUES(14, 0, 'user-info', 'default_open', 'User Information');
INSERT INTO `fieldsets` VALUES(15, 1, 'more-user-info', 'default_closed', 'More');
INSERT INTO `fieldsets` VALUES(16, 2, 'add-phone-number', 'default_open', 'Add Phone Number');
INSERT INTO `fieldsets` VALUES(17, 1, 'add-customer-payment', 'default_closed', 'Payment Information');
INSERT INTO `fieldsets` VALUES(18, 0, 'add-customer', 'default_open', 'Customer Information');
INSERT INTO `fieldsets` VALUES(19, 0, 'agent_add_new', 'default_open', 'Agent Info');
INSERT INTO `fieldsets` VALUES(20, 0, 'upload_file', 'default_open', 'Upload File');
INSERT INTO `fieldsets` VALUES(21, 1, 'campaign-time', 'default_open', 'Time Information (Use following formats to set the time 8am or 0800 - 9pm or 2100. Use dnc or leave blank on the Start Field for Do Not Call)');
INSERT INTO `fieldsets` VALUES(22, 0, 'reports_config', 'default_closed', 'Add Modifiers for Field Last Dial Status');
INSERT INTO `fieldsets` VALUES(23, 0, 'queue_acd_basic', 'default_open', 'ACD Basic');
INSERT INTO `fieldsets` VALUES(24, 1, 'queue_advanced_announce', 'default_closed', 'Advanced Announcements');
INSERT INTO `fieldsets` VALUES(25, 2, 'queue_agent_basic', 'default_closed', 'Agent Basic');
INSERT INTO `fieldsets` VALUES(26, 0, 'campaign-info-view', 'default_open', 'Campaign Information');
INSERT INTO `fieldsets` VALUES(27, 1, 'campaign-time-view', 'default_open', 'Time Information');
INSERT INTO `fieldsets` VALUES(28, 0, 'exten-info', 'default_open', 'Extension Information');
INSERT INTO `fieldsets` VALUES(29, 1, 'exten-config', 'default_closed', 'Configuration');
INSERT INTO `fieldsets` VALUES(30, 0, 'mailbox-info', 'default_open', 'Mailbox Information');
INSERT INTO `fieldsets` VALUES(31, 1, 'mailbox-config', 'default_closed', 'Configuration');
INSERT INTO `fieldsets` VALUES(32, 0, 'system_api', 'default_open', 'Hive Communication Suite API Key');
INSERT INTO `fieldsets` VALUES(33, 1, 'system_settings', 'default_open', 'System Settings');
INSERT INTO `fieldsets` VALUES(34, 0, 'preview_basic', 'default_open', 'Basic Information');
INSERT INTO `fieldsets` VALUES(35, 1, 'preview_workspace', 'default_closed', 'Workspace Setting');

-- --------------------------------------------------------

--
-- Table structure for table `field_templates`
--

DROP TABLE IF EXISTS `field_templates`;
CREATE TABLE IF NOT EXISTS `field_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_reference` varchar(50) NOT NULL,
  `field_id` varchar(50) NOT NULL,
  `field_name` varchar(50) NOT NULL,
  `form_field_order` int(4) NOT NULL,
  `html_type` varchar(255) NOT NULL,
  `def_label` text NOT NULL,
  `html_options` varchar(255) NOT NULL,
  `css_class` varchar(255) NOT NULL,
  `data_table` varchar(255) NOT NULL,
  `data_query` varchar(255) NOT NULL,
  `data_sort` varchar(255) NOT NULL,
  `data_label` varchar(255) NOT NULL,
  `data_value` varchar(255) NOT NULL,
  `field_values` varchar(255) NOT NULL,
  `def_val` varchar(255) NOT NULL,
  `vertical` varchar(255) NOT NULL,
  `click` varchar(255) NOT NULL,
  `focus` varchar(255) NOT NULL,
  `blur` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `acl` varchar(255) NOT NULL,
  `onchange` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `fieldset_name` varchar(50) NOT NULL,
  `tooltip` text NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2744 ;

--
-- Dumping data for table `field_templates`
--

INSERT INTO `field_templates` VALUES(1001, 'user_new', 'partner_id', 'partner_id', 1, 'hidden', 'Partner', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1002, 'user_new', 'customer_id', 'customer_id', 2, 'hidden', 'Customer', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1003, 'user_new', 'group_id', 'group_id', 4, 'hidden', 'Group', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1004, 'user_new', 'first_name', 'first_name', 5, 'text', 'First Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1005, 'user_new', 'last_name', 'last_name', 6, 'text', 'Last Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1006, 'user_new', 'contact_id', 'contact_id', 7, 'hidden', 'Contact', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1007, 'user_new', 'username', 'username', 8, 'text', 'Username', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1008, 'user_new', 'password', 'password', 9, 'text', 'Password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1009, 'user_new', 'access_level', 'access_level', 10, 'hidden', 'Access Level', '', '', '', '', '', '', '', '', '11', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1010, 'user_new', 'pin', 'pin', 11, 'text', 'Pin', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1011, 'user_new', 'status', 'status', 12, 'hidden', 'Status', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1012, 'user_new', 'time_zone', 'time_zone', 13, 'text', 'Time Zone', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1013, 'user_new', 'type', 'type', 14, 'hidden', 'Type', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1014, 'user_new', 'comission_id', 'comission_id', 15, 'text', 'Comission', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1015, 'user_new', 'default_caller_id', 'default_caller_id', 16, 'text', 'Default Caller', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1016, 'user_new', 'permit_sms', 'permit_sms', 17, 'text', 'Permit Sms', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1017, 'user_new', 'sms_credits', 'sms_credits', 18, 'text', 'Sms Credits', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1018, 'user_new', 'preferred_language', 'preferred_language', 19, 'text', 'Preferred Language', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1019, 'user_new', 'sub1', 'sub2', 20, 'submit', 'New User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1020, 'user_new', 'admin', 'admin', 3, 'list', 'Admin', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1101, 'user_view', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1102, 'user_view', 'partner_id', 'partner_id', 1, 'hidden', 'Partner', '', '', '', '', '', '', '', '', 'partner_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1103, 'user_view', 'customer_id', 'customer_id', 2, 'hidden', 'Customer', '', '', '', '', '', '', '', '', 'customer_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1104, 'user_view', 'group_id', 'group_id', 4, 'hidden', 'Group', '', '', '', '', '', '', '', '', 'group_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1105, 'user_view', 'first_name', 'first_name', 5, 'readonly', 'First Name', '', '', '', '', '', '', '', '', 'first_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1106, 'user_view', 'last_name', 'last_name', 6, 'readonly', 'Last Name', '', '', '', '', '', '', '', '', 'last_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1107, 'user_view', 'contact_id', 'contact_id', 7, 'readonly', 'Contact', '', '', '', '', '', '', '', '', 'contact_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1108, 'user_view', 'username', 'username', 8, 'readonly', 'Username', '', '', '', '', '', '', '', '', 'username', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1109, 'user_view', 'password', 'password', 9, 'readonly', 'Password', 'readonly', '', '', '', '', '', '', '', 'password', '', '', '', '', '81', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1110, 'user_view', 'access_level', 'access_level', 10, 'readonly', 'Access Level', '', '', '', '', '', '', '', '', 'access_level', '', '', '', '', '50', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1111, 'user_view', 'pin', 'pin', 11, 'readonly', 'Pin', '', '', '', '', '', '', '', '', 'pin', '', '', '', '', '0', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1112, 'user_view', 'status', 'status', 12, 'readonly', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1113, 'user_view', 'time_zone', 'time_zone', 13, 'readonly', 'Time Zone', '', '', '', '', '', '', '', '', 'time_zone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1114, 'user_view', 'type', 'type', 14, 'readonly', 'Type', '', '', '', '', '', '', '', '', 'type', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1115, 'user_view', 'comission_id', 'comission_id', 15, 'readonly', 'Comission', '', '', '', '', '', '', '', '', 'comission_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1116, 'user_view', 'default_caller_id', 'default_caller_id', 16, 'readonly', 'Default Caller', '', '', '', '', '', '', '', '', 'default_caller_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1117, 'user_view', 'permit_sms', 'permit_sms', 17, 'readonly', 'Permit Sms', '', '', '', '', '', '', '', '', 'permit_sms', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1118, 'user_view', 'sms_credits', 'sms_credits', 18, 'readonly', 'Sms Credits', '', '', '', '', '', '', '', '', 'sms_credits', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1119, 'user_view', 'preferred_language', 'preferred_language', 19, 'readonly', 'Preferred Language', '', '', '', '', '', '', '', '', 'preferred_language', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2348, 'extension_edit', 'permit_virtual_codes', 'permit_virtual_codes', 28, 'list', 'Allow Vertical Code', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'permit_virtual_codes', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2347, 'extension_edit', 'permit_411_directory', 'permit_411_directory', 27, 'list', 'Allow 411 Directory', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'permit_411_directory', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2129, 'customer_user_new', 'sub1', 'sub2', 37, 'submit', 'New User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2128, 'customer_user_new', 'www', 'www', 36, 'text', 'Website', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2127, 'customer_user_new', 'orkut', 'orkut', 35, 'text', 'Orkut', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2126, 'customer_user_new', 'myspace', 'myspace', 34, 'text', 'MySpace', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2125, 'customer_user_new', 'twitter', 'twitter', 33, 'text', 'Twitter', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2124, 'customer_user_new', 'facebook', 'facebook', 32, 'text', 'Facebook', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2123, 'customer_user_new', 'im', 'im', 31, 'text', 'IM', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2122, 'customer_user_new', 'icq', 'icq', 30, 'text', 'ICQ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2120, 'customer_user_new', 'msn', 'msn', 28, 'text', 'MSN', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2121, 'customer_user_new', 'yahoo', 'yahoo', 29, 'text', 'Yahoo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2094, 'user_edit', 'id', 'id', 0, 'hidden', 'Id', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2093, 'user_edit', 'partner_id', 'partner_id', 1, 'hidden', 'Partner', '', '', '', '', '', '', '', '', 'partner_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1222, 'customer_new', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1223, 'customer_edit', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1224, 'customer_view', 'id', 'id', 0, 'readonly', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1225, 'customer_new', 'partner_id', 'partner_id', 1, 'text', 'Partner', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1226, 'customer_edit', 'partner_id', 'partner_id', 1, 'text', 'Partner', '', '', '', '', '', '', '', '', 'partner_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1227, 'customer_view', 'partner_id', 'partner_id', 1, 'readonly', 'Partner', '', '', '', '', '', '', '', '', 'partner_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1228, 'customer_new', 'name', 'name', 2, 'text', 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1229, 'customer_edit', 'name', 'name', 2, 'text', 'Name', '', '', '', '', '', '', '', '', 'name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1230, 'customer_view', 'name', 'name', 2, 'readonly', 'Name', '', '', '', '', '', '', '', '', 'name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1231, 'customer_new', 'type', 'type', 3, 'text', 'Type', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1232, 'customer_edit', 'type', 'type', 3, 'text', 'Type', '', '', '', '', '', '', '', '', 'type', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1233, 'customer_view', 'type', 'type', 3, 'readonly', 'Type', '', '', '', '', '', '', '', '', 'type', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1234, 'customer_new', 'location_id', 'location_id', 4, 'text', 'Location', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1235, 'customer_edit', 'location_id', 'location_id', 4, 'text', 'Location', '', '', '', '', '', '', '', '', 'location_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1236, 'customer_view', 'location_id', 'location_id', 4, 'readonly', 'Location', '', '', '', '', '', '', '', '', 'location_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1237, 'customer_new', 'contact_id', 'contact_id', 5, 'text', 'Contact', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1238, 'customer_edit', 'contact_id', 'contact_id', 5, 'text', 'Contact', '', '', '', '', '', '', '', '', 'contact_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1239, 'customer_view', 'contact_id', 'contact_id', 5, 'readonly', 'Contact', '', '', '', '', '', '', '', '', 'contact_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1240, 'customer_new', 'time_zone', 'time_zone', 6, 'text', 'Time Zone', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1241, 'customer_edit', 'time_zone', 'time_zone', 6, 'text', 'Time Zone', '', '', '', '', '', '', '', '', 'time_zone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1242, 'customer_view', 'time_zone', 'time_zone', 6, 'readonly', 'Time Zone', '', '', '', '', '', '', '', '', 'time_zone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1243, 'customer_new', 'calling_group', 'calling_group', 7, 'text', 'Calling Group', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1244, 'customer_edit', 'calling_group', 'calling_group', 7, 'text', 'Calling Group', '', '', '', '', '', '', '', '', 'calling_group', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1245, 'customer_view', 'calling_group', 'calling_group', 7, 'readonly', 'Calling Group', '', '', '', '', '', '', '', '', 'calling_group', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1246, 'customer_new', 'status', 'status', 8, 'text', 'Status', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1247, 'customer_edit', 'status', 'status', 8, 'text', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1248, 'customer_view', 'status', 'status', 8, 'readonly', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1249, 'partner_new', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1250, 'partner_edit', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1251, 'partner_view', 'id', 'id', 0, 'readonly', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1252, 'partner_new', 'itsp_id', 'itsp_id', 1, 'text', 'Itsp', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1253, 'partner_edit', 'itsp_id', 'itsp_id', 1, 'text', 'Itsp', '', '', '', '', '', '', '', '', 'itsp_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1254, 'partner_view', 'itsp_id', 'itsp_id', 1, 'readonly', 'Itsp', '', '', '', '', '', '', '', '', 'itsp_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1255, 'partner_new', 'name', 'name', 2, 'text', 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1256, 'partner_edit', 'name', 'name', 2, 'text', 'Name', '', '', '', '', '', '', '', '', 'name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1257, 'partner_view', 'name', 'name', 2, 'readonly', 'Name', '', '', '', '', '', '', '', '', 'name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1258, 'partner_new', 'calling_group', 'calling_group', 3, 'text', 'Calling Group', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1259, 'partner_edit', 'calling_group', 'calling_group', 3, 'text', 'Calling Group', '', '', '', '', '', '', '', '', 'calling_group', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1260, 'partner_view', 'calling_group', 'calling_group', 3, 'readonly', 'Calling Group', '', '', '', '', '', '', '', '', 'calling_group', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1261, 'partner_new', 'location_id', 'location_id', 4, 'text', 'Location', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1262, 'partner_edit', 'location_id', 'location_id', 4, 'text', 'Location', '', '', '', '', '', '', '', '', 'location_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1263, 'partner_view', 'location_id', 'location_id', 4, 'readonly', 'Location', '', '', '', '', '', '', '', '', 'location_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1264, 'partner_new', 'api_key', 'api_key', 5, 'text', 'Api Key', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1265, 'partner_edit', 'api_key', 'api_key', 5, 'text', 'Api Key', '', '', '', '', '', '', '', '', 'api_key', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1266, 'partner_view', 'api_key', 'api_key', 5, 'readonly', 'Api Key', '', '', '', '', '', '', '', '', 'api_key', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1267, 'partner_new', 'contact_id', 'contact_id', 6, 'text', 'Contact', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1268, 'partner_edit', 'contact_id', 'contact_id', 6, 'text', 'Contact', '', '', '', '', '', '', '', '', 'contact_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1269, 'partner_view', 'contact_id', 'contact_id', 6, 'readonly', 'Contact', '', '', '', '', '', '', '', '', 'contact_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1307, 'location_edit', '911_house_number', '911_house_number', 5, 'text', '911 House Number', '', '', '', '', '', '', '', '', '911_house_number', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1306, 'location_new', '911_house_number', '911_house_number', 5, 'text', '911 House Number', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1305, 'location_view', 'zip', 'zip', 4, 'readonly', 'Zip', '', '', '', '', '', '', '', '', 'zip', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1304, 'location_edit', 'zip', 'zip', 4, 'text', 'Zip', '', '', '', '', '', '', '', '', 'zip', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1303, 'location_new', 'zip', 'zip', 4, 'text', 'Zip', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1302, 'location_view', 'state', 'state', 3, 'readonly', 'State', '', '', '', '', '', '', '', '', 'state', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1301, 'location_edit', 'state', 'state', 3, 'text', 'State', '', '', '', '', '', '', '', '', 'state', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1300, 'location_new', 'state', 'state', 3, 'text', 'State', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1299, 'location_view', 'city', 'city', 2, 'readonly', 'City', '', '', '', '', '', '', '', '', 'city', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1298, 'location_edit', 'city', 'city', 2, 'text', 'City', '', '', '', '', '', '', '', '', 'city', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1297, 'location_new', 'city', 'city', 2, 'text', 'City', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1296, 'location_view', 'address', 'address', 1, 'readonly', 'Address', '', '', '', '', '', '', '', '', 'address', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1295, 'location_edit', 'address', 'address', 1, 'text', 'Address', '', '', '', '', '', '', '', '', 'address', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1294, 'location_new', 'address', 'address', 1, 'text', 'Address', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1293, 'location_view', 'id', 'id', 0, 'readonly', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1291, 'location_new', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1292, 'location_edit', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1308, 'location_view', '911_house_number', '911_house_number', 5, 'readonly', '911 House Number', '', '', '', '', '', '', '', '', '911_house_number', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1309, 'location_new', '911_house_number_suffix', '911_house_number_suffix', 6, 'text', '911 House Number Suffix', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1310, 'location_edit', '911_house_number_suffix', '911_house_number_suffix', 6, 'text', '911 House Number Suffix', '', '', '', '', '', '', '', '', '911_house_number_suffix', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1311, 'location_view', '911_house_number_suffix', '911_house_number_suffix', 6, 'readonly', '911 House Number Suffix', '', '', '', '', '', '', '', '', '911_house_number_suffix', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1312, 'location_new', '911_pre_directional', '911_pre_directional', 7, 'text', '911 Pre Directional', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1313, 'location_edit', '911_pre_directional', '911_pre_directional', 7, 'text', '911 Pre Directional', '', '', '', '', '', '', '', '', '911_pre_directional', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1314, 'location_view', '911_pre_directional', '911_pre_directional', 7, 'readonly', '911 Pre Directional', '', '', '', '', '', '', '', '', '911_pre_directional', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1315, 'location_new', '911_street', '911_street', 8, 'text', '911 Street', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1316, 'location_edit', '911_street', '911_street', 8, 'text', '911 Street', '', '', '', '', '', '', '', '', '911_street', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1317, 'location_view', '911_street', '911_street', 8, 'readonly', '911 Street', '', '', '', '', '', '', '', '', '911_street', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1318, 'location_new', '911_community', '911_community', 9, 'text', '911 Community', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1319, 'location_edit', '911_community', '911_community', 9, 'text', '911 Community', '', '', '', '', '', '', '', '', '911_community', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1320, 'location_view', '911_community', '911_community', 9, 'readonly', '911 Community', '', '', '', '', '', '', '', '', '911_community', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1321, 'location_new', '911_location', '911_location', 10, 'text', '911 Location', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1322, 'location_edit', '911_location', '911_location', 10, 'text', '911 Location', '', '', '', '', '', '', '', '', '911_location', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1323, 'location_view', '911_location', '911_location', 10, 'readonly', '911 Location', '', '', '', '', '', '', '', '', '911_location', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1324, 'location_new', 'status', 'status', 11, 'text', 'Status', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1325, 'location_edit', 'status', 'status', 11, 'text', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1326, 'location_view', 'status', 'status', 11, 'readonly', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1341, 'admin_partner_new', 'itsp_id', 'itsp_id', 1, 'hidden', 'Itsp', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1342, 'admin_partner_new', 'name', 'name', 2, 'text', 'Partner Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1343, 'admin_partner_new', 'calling_group', 'calling_group', 3, 'text', 'Calling Group', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1344, 'admin_partner_new', 'api_key', 'api_key', 5, 'text', 'API Key', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1345, 'admin_partner_new', 'home_phone', 'home_phone', 1, 'text', 'Home Phone', '', '', '', '', '', '', '', '', '1234567', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1346, 'admin_partner_new', 'work_phone', 'work_phone', 2, 'text', 'Work Phone', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1347, 'admin_partner_new', 'work_extension', 'work_extension', 3, 'text', 'Work Phone Extension', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1348, 'admin_partner_new', 'mobile_phone', 'mobile_phone', 4, 'text', 'Mobile', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1349, 'admin_partner_new', 'fax', 'fax', 5, 'text', 'FAX', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1350, 'admin_partner_new', 'email', 'email', 6, 'text', 'Email', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1351, 'admin_partner_new', 'gtalk', 'gtalk', 7, 'text', 'Google Talk', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1352, 'admin_partner_new', 'msn', 'msn', 8, 'text', 'Msn', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1353, 'admin_partner_new', 'yahoo', 'yahoo', 9, 'text', 'Yahoo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1354, 'admin_partner_new', 'icq', 'icq', 10, 'text', 'ICQ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1355, 'admin_partner_new', 'im', 'im', 11, 'text', 'Instant Messager', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1356, 'admin_partner_new', 'facebook', 'facebook', 12, 'text', 'Facebook', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1357, 'admin_partner_new', 'twitter', 'twitter', 13, 'text', 'Twitter', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1358, 'admin_partner_new', 'myspace', 'myspace', 14, 'text', 'MySpace', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1359, 'admin_partner_new', 'orkut', 'orkut', 15, 'text', 'Orkut', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1360, 'admin_partner_new', 'www', 'www', 16, 'text', 'Web Page', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1361, 'admin_partner_new', 'address', 'address', 1, 'text', 'Adress', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1362, 'admin_partner_new', 'city', 'city', 2, 'text', 'City', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1363, 'admin_partner_new', 'state', 'state', 3, 'list', 'State', '', '', 'states', '1', 'prefix', 'state', '', 'prefix', 'TX', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1364, 'admin_partner_new', 'zip', 'zip', 4, 'text', 'Zip', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1365, 'admin_partner_new', 'sub1', 'sub2', 20, 'submit', 'New User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2092, 'user_edit', 'customer_id', 'customer_id', 2, 'hidden', 'Customer', '', '', '', '', '', '', '', '', 'customer_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2091, 'user_edit', 'company_id', 'company_id', 3, 'hidden', 'Company', '', '', '', '', '', '', '', '', 'company_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2090, 'user_edit', 'group_id', 'group_id', 4, 'hidden', 'Group', '', '', '', '', '', '', '', '', 'group_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2089, 'user_edit', 'first_name', 'first_name', 5, 'text', 'First Name *', '', '', '', '', '', '', '', '', 'first_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2088, 'user_edit', 'last_name', 'last_name', 6, 'text', 'Last Name *', '', '', '', '', '', '', '', '', 'last_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2087, 'user_edit', 'contact_id', 'contact_id', 7, 'hidden', 'Contact', '', '', '', '', '', '', '', '', 'contact_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2086, 'user_edit', 'username', 'username', 8, 'hidden', 'Username *', '', '', '', '', '', '', '', '', 'username', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2085, 'user_edit', 'password', 'password', 9, 'hidden', 'Password', '', '', '', '', '', '', '', '', 'password', '', '', '', '', '71', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2084, 'user_edit', 'access_level', 'access_level', 10, 'list', 'Access Level *', '', '', '', '', '', '', '', 'access_level_options', 'access_level', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2083, 'user_edit', 'pin', 'pin', 11, 'text', 'Pin *', '', '', '', '', '', '', '', '', 'pin', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2082, 'user_edit', 'status', 'status', 12, 'list', 'Status *', '', '', 'select_option', 'upstream_name=''user_status''', 'description', 'description', 'value', '', 'status', '', '', '', '', '61', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2081, 'user_edit', 'time_zone', 'time_zone', 13, 'list', 'Time Zone *', '', '', 'timezone', 'zone!=''''', 'zone DESC', 'zone', 'zone', 'zone', 'time_zone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2080, 'user_edit', 'type', 'type', 14, 'hidden', 'Type', '', '', '', '', '', '', '', '', 'type', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2079, 'user_edit', 'comission_id', 'comission_id', 15, 'hidden', 'Comission', '', '', '', '', '', '', '', '', 'comission_id', '', '', '', '', '61', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2078, 'user_edit', 'default_caller_id', 'default_caller_id', 16, 'text', 'Default Caller', '', '', '', '', '', '', '', '', 'default_caller_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2077, 'user_edit', 'permit_sms', 'permit_sms', 17, 'hidden', 'Permit Sms', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'permit_sms', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2076, 'user_edit', 'sms_credits', 'sms_credits', 18, 'hidden', 'Sms Credits', '', '', '', '', '', '', '', '', 'sms_credits', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2075, 'user_edit', 'preferred_language', 'preferred_language', 19, 'hidden', 'Preferred Language', '', '', '', '', '', '', '', '', 'preferred_language', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2074, 'user_edit', 'sub1', 'sub2', 58, 'submit', 'Update User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2073, 'user_edit', 'twitter', 'twitter', 54, 'text', 'Twitter', '', '', '', '', '', '', '', '', 'twitter', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2072, 'user_edit', 'facebook', 'facebook', 53, 'text', 'Facebook', '', '', '', '', '', '', '', '', 'facebook', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2071, 'user_edit', 'icq', 'icq', 51, 'text', 'ICQ', '', '', '', '', '', '', '', '', 'icq', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2070, 'user_edit', 'im', 'im', 52, 'text', 'IM', '', '', '', '', '', '', '', '', 'im', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2069, 'user_edit', 'yahoo', 'yahoo', 50, 'text', 'Yahoo', '', '', '', '', '', '', '', '', 'yahoo', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2068, 'user_edit', 'msn', 'msn', 49, 'text', 'MSN', '', '', '', '', '', '', '', '', 'msn', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2067, 'user_edit', 'gtalk', 'gtalk', 48, 'text', 'Gtalk', '', '', '', '', '', '', '', '', 'gtalk', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2066, 'user_edit', 'email', 'email', 47, 'text', 'Email *', '', '', '', '', '', '', '', '', 'email', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2065, 'user_edit', 'fax', 'fax', 46, 'text', 'Fax', '', '', '', '', '', '', '', '', 'fax', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2064, 'user_edit', 'mobile_phone', 'mobile_phone', 45, 'text', 'Mobile Phone *', '', '', '', '', '', '', '', '', 'mobile_phone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2063, 'user_edit', 'work_extension', 'work_extension', 44, 'text', 'Work Extension', '', '', '', '', '', '', '', '', 'work_extension', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2062, 'user_edit', 'work_phone', 'work_phone', 43, 'text', 'Work Phone', '', '', '', '', '', '', '', '', 'work_phone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2061, 'user_edit', 'home_phone', 'home_phone', 42, 'text', 'Home Phone', '', '', '', '', '', '', '', '', 'home_phone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2060, 'user_edit', 'orkut', 'orkut', 56, 'text', 'Orkut', '', '', '', '', '', '', '', '', 'orkut', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2059, 'user_edit', 'myspace', 'myspace', 55, 'text', 'MySpace', '', '', '', '', '', '', '', '', 'myspace', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1417, 'change_user_pass', 'old_pass', 'old_pass', 0, 'password', 'Type your current password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1418, 'change_user_pass', 'pass1', 'pass1', 1, 'password', 'Type your new password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1419, 'change_user_pass', 'pass2', 'pass2', 2, 'password', 'Repeat password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1420, 'change_user_pass', '', '', 3, 'submit', 'Save Password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2119, 'customer_user_new', 'gtalk', 'gtalk', 27, 'text', 'Gtalk', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2118, 'customer_user_new', 'email', 'email', 26, 'text', 'Email *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2117, 'customer_user_new', 'fax', 'fax', 25, 'text', 'Fax', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2116, 'customer_user_new', 'mobile_phone', 'mobile_phone', 24, 'text', 'Mobile Phone *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2115, 'customer_user_new', 'work_extension', 'work_extension', 23, 'text', 'Work Extension', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2114, 'customer_user_new', 'work_phone', 'work_phone', 22, 'text', 'Work Phone', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2113, 'customer_user_new', 'home_phone', 'home_phone', 21, 'text', 'Home Phone', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2112, 'customer_user_new', 'preferred_language', 'preferred_language', 19, 'hidden', 'Preferred Language', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2111, 'customer_user_new', 'sms_credits', 'sms_credits', 18, 'hidden', 'Sms Credits', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2110, 'customer_user_new', 'permit_sms', 'permit_sms', 17, 'hidden', 'Permit Sms', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', '0', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2109, 'customer_user_new', 'default_caller_id', 'default_caller_id', 16, 'text', 'Default Caller', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2107, 'customer_user_new', 'type', 'type', 14, 'hidden', 'Type', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2108, 'customer_user_new', 'comission_id', 'comission_id', 15, 'hidden', 'Comission', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2106, 'customer_user_new', 'time_zone', 'time_zone', 13, 'list', 'Time Zone *', '', '', 'timezone', 'zone!=''''', 'zone', 'zone', 'zone', 'zone', 'time_zone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2105, 'customer_user_new', 'status', 'status', 12, 'hidden', 'Status', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2104, 'customer_user_new', 'pin', 'pin', 11, 'text', 'Pin *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2103, 'customer_user_new', 'access_level', 'access_level', 10, 'list', 'Access Level *', '', '', '', '', '', '', '', 'access_level_options', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2102, 'customer_user_new', 'password', 'password', 9, 'hidden', 'Password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2101, 'customer_user_new', 'username', 'username', 8, 'text', 'Username *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2100, 'customer_user_new', 'contact_id', 'contact_id', 7, 'hidden', 'Contact', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2099, 'customer_user_new', 'last_name', 'last_name', 6, 'text', 'Last Name *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2098, 'customer_user_new', 'first_name', 'first_name', 5, 'text', 'First Name *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2097, 'customer_user_new', 'group_id', 'group_id', 3, 'hidden', 'Group', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2096, 'customer_user_new', 'customer_id', 'customer_id', 2, 'hidden', 'Customer', '', '', '', '', '', '', '', '', 'customer_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2095, 'customer_user_new', 'partner_id', 'partner_id', 1, 'hidden', 'Partner', '', '', '', '', '', '', '', '', 'partner_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2058, 'user_edit', 'www', 'www', 57, 'text', 'Website', '', '', '', '', '', '', '', '', 'www', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1538, 'extension_new', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1540, 'extension_view', 'id', 'id', 0, 'readonly', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1541, 'extension_new', 'user_id', 'user_id', 1, 'text', 'User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2346, 'extension_edit', 'permit_international', 'permit_international', 26, 'list', 'Allow International Calls', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'permit_international', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1543, 'extension_view', 'user_id', 'user_id', 1, 'readonly', 'User', '', '', '', '', '', '', '', '', 'user_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1544, 'extension_new', 'calling_group', 'calling_group', 2, 'text', 'Calling Group', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1546, 'extension_view', 'calling_group', 'calling_group', 2, 'readonly', 'Calling Group', '', '', '', '', '', '', '', '', 'calling_group', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1547, 'extension_new', 'extension_number', 'extension_number', 3, 'text', 'Extension Number', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1549, 'extension_view', 'extension_number', 'extension_number', 3, 'readonly', 'Extension Number', '', '', '', '', '', '', '', '', 'extension_number', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1550, 'extension_new', 'username', 'username', 4, 'text', 'Username', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1552, 'extension_view', 'username', 'username', 4, 'readonly', 'Username', '', '', '', '', '', '', '', '', 'username', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1553, 'extension_new', 'password', 'password', 5, 'text', 'Password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1555, 'extension_view', 'password', 'password', 5, 'readonly', 'Password', '', '', '', '', '', '', '', '', 'password', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1556, 'extension_new', 'caller_id_number', 'caller_id_number', 6, 'text', 'Caller Number', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1558, 'extension_view', 'caller_id_number', 'caller_id_number', 6, 'readonly', 'Caller Number', '', '', '', '', '', '', '', '', 'caller_id_number', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1559, 'extension_new', 'caller_id_name', 'caller_id_name', 7, 'text', 'Caller Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2344, 'extension_edit', 'permit_out_of_group', 'permit_out_of_group', 24, 'list', 'Permit Out of Group Calls', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'permit_out_of_group', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2343, 'extension_edit', 'cid_block', 'cid_block', 23, 'list', 'Caller ID Blocking', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'cid_block', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1561, 'extension_view', 'caller_id_name', 'caller_id_name', 7, 'readonly', 'Caller Name', '', '', '', '', '', '', '', '', 'caller_id_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1562, 'extension_new', 'status', 'status', 8, 'text', 'Status', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1564, 'extension_view', 'status', 'status', 8, 'readonly', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1565, 'extension_new', 'protocol', 'protocol', 9, 'text', 'Protocol', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1567, 'extension_view', 'protocol', 'protocol', 9, 'readonly', 'Protocol', '', '', '', '', '', '', '', '', 'protocol', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1568, 'extension_new', 'nat_support', 'nat_support', 10, 'text', 'Nat Support', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2342, 'extension_edit', 'dnd', 'dnd', 22, 'list', 'Do Not Disturb', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'dnd', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1570, 'extension_view', 'nat_support', 'nat_support', 10, 'readonly', 'Nat Support', '', '', '', '', '', '', '', '', 'nat_support', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1571, 'extension_new', 'video_support', 'video_support', 11, 'text', 'Video Support', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1573, 'extension_view', 'video_support', 'video_support', 11, 'readonly', 'Video Support', '', '', '', '', '', '', '', '', 'video_support', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1574, 'extension_new', 'qualify', 'qualify', 12, 'text', 'Qualify', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1576, 'extension_view', 'qualify', 'qualify', 12, 'readonly', 'Qualify', '', '', '', '', '', '', '', '', 'qualify', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1577, 'extension_new', 'primary_codec', 'primary_codec', 13, 'text', 'Primary Codec', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1579, 'extension_view', 'primary_codec', 'primary_codec', 13, 'readonly', 'Primary Codec', '', '', '', '', '', '', '', '', 'primary_codec', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1580, 'extension_new', 'secondary_codec', 'secondary_codec', 14, 'text', 'Secondary Codec', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1582, 'extension_view', 'secondary_codec', 'secondary_codec', 14, 'readonly', 'Secondary Codec', '', '', '', '', '', '', '', '', 'secondary_codec', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1583, 'extension_new', 'simultaneous_calls_limit', 'simultaneous_calls_limit', 15, 'text', 'Simultaneous Calls Limit', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2339, 'extension_edit', 'ring_timeout', 'ring_timeout', 19, 'list', 'Time before VM Picks Up', '', '', 'select_option', 'upstream_name=''timeout''', 'value', 'description', 'value', '', 'ring_timeout', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1585, 'extension_view', 'simultaneous_calls_limit', 'simultaneous_calls_limit', 15, 'readonly', 'Simultaneous Calls Limit', '', '', '', '', '', '', '', '', 'simultaneous_calls_limit', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1586, 'extension_new', 'context', 'context', 16, 'text', 'Context', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1588, 'extension_view', 'context', 'context', 16, 'readonly', 'Context', '', '', '', '', '', '', '', '', 'context', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1589, 'extension_new', 'ring_timeout', 'ring_timeout', 17, 'text', 'Ring Timeout', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1591, 'extension_view', 'ring_timeout', 'ring_timeout', 17, 'readonly', 'Ring Timeout', '', '', '', '', '', '', '', '', 'ring_timeout', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1592, 'extension_new', 'mail_box', 'mail_box', 18, 'text', 'Mail Box', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1594, 'extension_view', 'mail_box', 'mail_box', 18, 'readonly', 'Mail Box', '', '', '', '', '', '', '', '', 'mail_box', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1595, 'extension_new', 'mail_box_id', 'mail_box_id', 19, 'text', 'Mail Box', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2338, 'extension_edit', 'context', 'context', 18, 'hidden', 'Context', '', '', '', '', '', '', '', '', 'context', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1597, 'extension_view', 'mail_box_id', 'mail_box_id', 19, 'readonly', 'Mail Box', '', '', '', '', '', '', '', '', 'mail_box_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1599, 'device_new', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1600, 'device_edit', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1601, 'device_view', 'id', 'id', 0, 'readonly', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1602, 'device_new', 'partner_id', 'partner_id', 1, 'text', 'Partner', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1603, 'device_edit', 'partner_id', 'partner_id', 1, 'list', 'Partner', '', '', 'partner', 'name!=''''', 'name', 'name', 'id', 'ITSP=0', 'partner_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1604, 'device_view', 'partner_id', 'partner_id', 1, 'readonly', 'Partner', '', '', '', '', '', '', '', '', 'partner_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1605, 'device_new', 'customer_id', 'customer_id', 2, 'text', 'Customer', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1606, 'device_edit', 'customer_id', 'customer_id', 2, 'text', 'Customer', '', '', '', '', '', '', '', '', 'customer_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1607, 'device_view', 'customer_id', 'customer_id', 2, 'readonly', 'Customer', '', '', '', '', '', '', '', '', 'customer_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1608, 'device_new', 'user_id', 'user_id', 3, 'text', 'User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1609, 'device_edit', 'user_id', 'user_id', 3, 'text', 'User', '', '', '', '', '', '', '', '', 'user_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1610, 'device_view', 'user_id', 'user_id', 3, 'readonly', 'User', '', '', '', '', '', '', '', '', 'user_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1611, 'device_new', 'mac', 'mac', 4, 'text', 'Mac', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1612, 'device_edit', 'mac', 'mac', 4, 'text', 'Mac', '', '', '', '', '', '', '', '', 'mac', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1613, 'device_view', 'mac', 'mac', 4, 'readonly', 'Mac', '', '', '', '', '', '', '', '', 'mac', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1614, 'device_new', 'vendor', 'vendor', 5, 'text', 'Vendor', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1615, 'device_edit', 'vendor', 'vendor', 5, 'text', 'Vendor', '', '', '', '', '', '', '', '', 'vendor', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1616, 'device_view', 'vendor', 'vendor', 5, 'readonly', 'Vendor', '', '', '', '', '', '', '', '', 'vendor', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1617, 'device_new', 'model', 'model', 6, 'text', 'Model', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1618, 'device_edit', 'model', 'model', 6, 'text', 'Model', '', '', '', '', '', '', '', '', 'model', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1619, 'device_view', 'model', 'model', 6, 'readonly', 'Model', '', '', '', '', '', '', '', '', 'model', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1620, 'device_new', 'status', 'status', 7, 'text', 'Status', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1621, 'device_edit', 'status', 'status', 7, 'text', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1622, 'device_view', 'status', 'status', 7, 'readonly', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1623, 'device_new', 'provisoning_configuration', 'provisoning_configuration', 8, 'text', 'Provisoning Configuration', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1624, 'device_edit', 'provisoning_configuration', 'provisoning_configuration', 8, 'textarea', 'Provisoning Configuration', 'cols="65" rows="10" ', '', '', '', '', '', '', '', 'provisoning_configuration', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1625, 'device_view', 'provisoning_configuration', 'provisoning_configuration', 8, 'readonly', 'Provisoning Configuration', '', '', '', '', '', '', '', '', 'provisoning_configuration', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1626, 'device_new', 'location_id', 'location_id', 9, 'text', 'Location', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1627, 'device_edit', 'location_id', 'location_id', 9, 'text', 'Location', '', '', '', '', '', '', '', '', 'location_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1628, 'device_view', 'location_id', 'location_id', 9, 'readonly', 'Location', '', '', '', '', '', '', '', '', 'location_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1629, 'directory_new', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1630, 'directory_edit', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1631, 'directory_view', 'id', 'id', 0, 'readonly', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1632, 'directory_new', 'user_id', 'user_id', 1, 'text', 'User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1633, 'directory_edit', 'user_id', 'user_id', 1, 'text', 'User', '', '', '', '', '', '', '', '', 'user_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1634, 'directory_view', 'user_id', 'user_id', 1, 'readonly', 'User', '', '', '', '', '', '', '', '', 'user_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1635, 'directory_new', 'first_name', 'first_name', 2, 'text', 'First Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1636, 'directory_edit', 'first_name', 'first_name', 2, 'text', 'First Name', '', '', '', '', '', '', '', '', 'first_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1637, 'directory_view', 'first_name', 'first_name', 2, 'readonly', 'First Name', '', '', '', '', '', '', '', '', 'first_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1638, 'directory_new', 'last_name', 'last_name', 3, 'text', 'Last Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1639, 'directory_edit', 'last_name', 'last_name', 3, 'text', 'Last Name', '', '', '', '', '', '', '', '', 'last_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1640, 'directory_view', 'last_name', 'last_name', 3, 'readonly', 'Last Name', '', '', '', '', '', '', '', '', 'last_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1641, 'directory_new', 'contact_id', 'contact_id', 4, 'text', 'Contact', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1642, 'directory_edit', 'contact_id', 'contact_id', 4, 'text', 'Contact', '', '', '', '', '', '', '', '', 'contact_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1643, 'directory_view', 'contact_id', 'contact_id', 4, 'readonly', 'Contact', '', '', '', '', '', '', '', '', 'contact_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1644, 'mailbox_new', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1646, 'mailbox_view', 'id', 'id', 0, 'readonly', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1647, 'mailbox_new', 'user_id', 'user_id', 1, 'text', 'User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2316, 'mailbox_edit', 'forcegreeting', 'forcegreeting', 18, 'hidden', 'Force Greeting', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'forcegreeting', '', '', '', '', '61', 'hidden', '', '', '', '', 'ITSP will force every ''new user'' to record his/hers greeting.', 0);
INSERT INTO `field_templates` VALUES(1649, 'mailbox_view', 'user_id', 'user_id', 1, 'readonly', 'User', '', '', '', '', '', '', '', '', 'user_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1650, 'mailbox_new', 'customer_id', 'customer_id', 2, 'text', 'Customer', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1652, 'mailbox_view', 'customer_id', 'customer_id', 2, 'readonly', 'Customer', '', '', '', '', '', '', '', '', 'customer_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1653, 'mailbox_new', 'mailbox', 'mailbox', 3, 'text', 'Mailbox', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2315, 'mailbox_edit', 'forcename', 'forcename', 17, 'hidden', 'Force Name', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'forcename', '', '', '', '', '61', 'hidden', '', '', '', '', 'ITSP will force every new user to record his/hers name.', 0);
INSERT INTO `field_templates` VALUES(1655, 'mailbox_view', 'mailbox', 'mailbox', 3, 'readonly', 'Mailbox', '', '', '', '', '', '', '', '', 'mailbox', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1656, 'mailbox_new', 'password', 'password', 4, 'text', 'Password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1658, 'mailbox_view', 'password', 'password', 4, 'readonly', 'Password', '', '', '', '', '', '', '', '', 'password', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1659, 'mailbox_new', 'email', 'email', 5, 'text', 'Email', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2314, 'mailbox_edit', 'nextaftercmd', 'nextaftercmd', 16, 'hidden', 'Auto Save or Delete', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'nextaftercmd', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1661, 'mailbox_view', 'email', 'email', 5, 'readonly', 'Email', '', '', '', '', '', '', '', '', 'email', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1662, 'mailbox_new', 'attatch', 'attatch', 6, 'text', 'Attatch', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1664, 'mailbox_view', 'attatch', 'attatch', 6, 'readonly', 'Attatch', '', '', '', '', '', '', '', '', 'attatch', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1665, 'mailbox_new', 'saycid', 'saycid', 7, 'text', 'Saycid', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2313, 'mailbox_edit', 'deletevm', 'deletevm', 15, 'list', 'Delete Voicemail', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'deletevm', '', '', '', '', '', '', '', '', '', '', 'If set to "yes" the message will be deleted from the voicemailbox (after having been emailed). \r\nThe delete flag, when used alone (instead of with voicemail broadcast), provides functionality that allows a user to receive their voicemail via email alone.', 0);
INSERT INTO `field_templates` VALUES(1667, 'mailbox_view', 'saycid', 'saycid', 7, 'readonly', 'Saycid', '', '', '', '', '', '', '', '', 'saycid', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1668, 'mailbox_new', 'dialout', 'dialout', 8, 'text', 'Dialout', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1670, 'mailbox_view', 'dialout', 'dialout', 8, 'readonly', 'Dialout', '', '', '', '', '', '', '', '', 'dialout', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1671, 'mailbox_new', 'callback', 'callback', 9, 'text', 'Callback', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1673, 'mailbox_view', 'callback', 'callback', 9, 'readonly', 'Callback', '', '', '', '', '', '', '', '', 'callback', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1674, 'mailbox_new', 'review', 'review', 10, 'text', 'Review', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1676, 'mailbox_view', 'review', 'review', 10, 'readonly', 'Review', '', '', '', '', '', '', '', '', 'review', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1677, 'mailbox_new', 'operator', 'operator', 11, 'text', 'Operator', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2312, 'mailbox_edit', 'sendvm', 'sendvm', 14, 'hidden', 'Send Voicemail', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'sendvm', '', '', '', '', '61', 'hidden', '', '', '', '', 'This setting takes a yes or no value. It enables the "Leave a message" menu option from the Advanced Options menu which allows the voicemail user to send a message to another voicemail user.', 0);
INSERT INTO `field_templates` VALUES(1679, 'mailbox_view', 'operator', 'operator', 11, 'readonly', 'Operator', '', '', '', '', '', '', '', '', 'operator', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1680, 'mailbox_new', 'operator_envelop', 'operator_envelop', 12, 'text', 'Operator Envelop', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1682, 'mailbox_view', 'operator_envelop', 'operator_envelop', 12, 'readonly', 'Operator Envelop', '', '', '', '', '', '', '', '', 'operator_envelop', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1683, 'mailbox_new', 'sendvm', 'sendvm', 13, 'text', 'Sendvm', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2311, 'mailbox_edit', 'operator_envelop', 'operator_envelop', 13, 'list', 'Envelope', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'operator_envelop', '', '', '', '', '', '', '', '', '', '', 'Envelope controls whether or not ITSP will play the message envelope (date/time) before playing the voicemail message.', 0);
INSERT INTO `field_templates` VALUES(1685, 'mailbox_view', 'sendvm', 'sendvm', 13, 'readonly', 'Sendvm', '', '', '', '', '', '', '', '', 'sendvm', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1686, 'mailbox_new', 'deletevm', 'deletevm', 14, 'text', 'Deletevm', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1688, 'mailbox_view', 'deletevm', 'deletevm', 14, 'readonly', 'Deletevm', '', '', '', '', '', '', '', '', 'deletevm', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1689, 'mailbox_new', 'nextaftercmd', 'nextaftercmd', 15, 'text', 'Nextaftercmd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2310, 'mailbox_edit', 'operator', 'operator', 12, 'hidden', 'Operator', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'operator', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1691, 'mailbox_view', 'nextaftercmd', 'nextaftercmd', 15, 'readonly', 'Nextaftercmd', '', '', '', '', '', '', '', '', 'nextaftercmd', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1692, 'mailbox_new', 'forcename', 'forcename', 16, 'text', 'Forcename', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1694, 'mailbox_view', 'forcename', 'forcename', 16, 'readonly', 'Forcename', '', '', '', '', '', '', '', '', 'forcename', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1695, 'mailbox_new', 'forcegreeting', 'forcegreeting', 17, 'text', 'Forcegreeting', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2309, 'mailbox_edit', 'review', 'review', 11, 'list', 'Review', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'review', '', '', '', '', '', '', '', '', '', '', 'Sometimes it is nice to let a caller review their message before committing it to a mailbox. If set to yes, then the caller will be asked to review the message, or save it as is after they have pressed ''#''. If set to no, the message will be saved and the voice mail system will disconnect the caller.', 0);
INSERT INTO `field_templates` VALUES(1697, 'mailbox_view', 'forcegreeting', 'forcegreeting', 17, 'readonly', 'Forcegreeting', '', '', '', '', '', '', '', '', 'forcegreeting', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1698, 'mailbox_new', 'context', 'context', 18, 'text', 'Context', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1700, 'mailbox_view', 'context', 'context', 18, 'readonly', 'Context', '', '', '', '', '', '', '', '', 'context', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1701, 'mailbox_new', 'status', 'status', 19, 'text', 'Status', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2308, 'mailbox_edit', 'callback', 'callback', 10, 'hidden', 'Callback', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'callback', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1703, 'mailbox_view', 'status', 'status', 19, 'readonly', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1741, 'admin_user_new', 'partner_id', 'partner_id', 1, 'list', 'Partner *', '', '', 'partner', 'name!=''''', 'name', 'name', 'id', 'ITSP=0', '0', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1742, 'admin_user_new', 'customer_id', 'customer_id', 2, 'hidden', 'Customer', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1743, 'admin_user_new', 'group_id', 'group_id', 3, 'hidden', 'Group', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1744, 'admin_user_new', 'admin', 'admin', 4, 'hide', 'Admin', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1745, 'admin_user_new', 'first_name', 'first_name', 5, 'text', 'First Name *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1746, 'admin_user_new', 'last_name', 'last_name', 6, 'text', 'Last Name *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1747, 'admin_user_new', 'contact_id', 'contact_id', 7, 'hidden', 'Contact', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1748, 'admin_user_new', 'username', 'username', 8, 'text', 'Username *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1749, 'admin_user_new', 'password', 'password', 9, 'hidden', 'Password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1750, 'admin_user_new', 'access_level', 'access_level', 10, 'list', 'Access Level *', '', '', '', '', '', '', '', 'access_level_options', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1751, 'admin_user_new', 'pin', 'pin', 11, 'hidden', 'Pin *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1752, 'admin_user_new', 'status', 'status', 12, 'hidden', 'Status', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1753, 'admin_user_new', 'time_zone', 'time_zone', 13, 'hidden', 'Time Zone', '', '', '', '', '', '', '', 'timezone_list', 'GMT-6', '', '', '', '', '', '', '', '', '', 'add-customer', '', 1);
INSERT INTO `field_templates` VALUES(1754, 'admin_user_new', 'type', 'type', 14, 'hidden', 'Type', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1755, 'admin_user_new', 'comission_id', 'comission_id', 15, 'hidden', 'Comission', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1756, 'admin_user_new', 'default_caller_id', 'default_caller_id', 16, 'hidden', 'Default Caller Id', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1757, 'admin_user_new', 'permit_sms', 'permit_sms', 17, 'hidden', 'Permit Sms', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', '0', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1758, 'admin_user_new', 'sms_credits', 'sms_credits', 18, 'hidden', 'Sms Credits', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1759, 'admin_user_new', 'preferred_language', 'preferred_language', 19, 'hidden', 'Preferred Language', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1760, 'admin_user_new', 'home_phone', 'home_phone', 21, 'hidden', 'Home Phone', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(1761, 'admin_user_new', 'work_phone', 'work_phone', 22, 'hidden', 'Work Phone', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(1762, 'admin_user_new', 'work_extension', 'work_extension', 23, 'hidden', 'Work Extension', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(1763, 'admin_user_new', 'mobile_phone', 'mobile_phone', 24, 'text', 'Mobile Phone *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1764, 'admin_user_new', 'fax', 'fax', 25, 'hidden', 'Fax', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(1765, 'admin_user_new', 'email', 'email', 26, 'text', 'E-mail *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1766, 'admin_user_new', 'gtalk', 'gtalk', 27, 'hidden', 'Gtalk', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1767, 'admin_user_new', 'msn', 'msn', 28, 'hidden', 'MSN', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1768, 'admin_user_new', 'yahoo', 'yahoo', 29, 'hidden', 'Yahoo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1769, 'admin_user_new', 'icq', 'icq', 30, 'hidden', 'ICQ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1770, 'admin_user_new', 'im', 'im', 31, 'hidden', 'IM', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1771, 'admin_user_new', 'facebook', 'facebook', 32, 'hidden', 'Facebook', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1772, 'admin_user_new', 'twitter', 'twitter', 33, 'hidden', 'Twitter', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1773, 'admin_user_new', 'myspace', 'myspace', 34, 'hidden', 'MySpace', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1774, 'admin_user_new', 'orkut', 'orkut', 35, 'hidden', 'Orkut', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1775, 'admin_user_new', 'www', 'www', 36, 'hidden', 'Website', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1776, 'admin_user_new', 'sub1', 'sub2', 37, 'submit', 'New Admin User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2035, 'admin_user_edit', 'default_caller_id', 'default_caller_id', 16, 'hidden', 'Default Caller', '', '', '', '', '', '', '', '', 'default_caller_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2034, 'admin_user_edit', 'comission_id', 'comission_id', 15, 'hidden', 'Comission', '', '', '', '', '', '', '', '', 'comission_id', '', '', '', '', '61', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2033, 'admin_user_edit', 'type', 'type', 14, 'hidden', 'Type', '', '', '', '', '', '', '', '', 'type', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2032, 'admin_user_edit', 'time_zone', 'time_zone', 13, 'list', 'Time Zone *', '', '', 'timezone', 'zone!=''''', 'zone DESC', 'zone', 'zone', 'zone', 'time_zone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2031, 'admin_user_edit', 'status', 'status', 12, 'list', 'Status *', '', '', 'select_option', 'upstream_name=''user_status''', 'description', 'description', 'value', '', 'status', '', '', '', '', '61', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2030, 'admin_user_edit', 'pin', 'pin', 11, 'hidden', 'Pin *', '', '', '', '', '', '', '', '', 'pin', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2029, 'admin_user_edit', 'access_level', 'access_level', 10, 'list', 'Access Level *', '', '', '', '', '', '', '', 'access_level_options', 'access_level', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2028, 'admin_user_edit', 'password', 'password', 9, 'hidden', 'Password', '', '', '', '', '', '', '', '', 'password', '', '', '', '', '71', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2027, 'admin_user_edit', 'username', 'username', 8, 'hidden', 'Username *', '', '', '', '', '', '', '', '', 'username', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2026, 'admin_user_edit', 'contact_id', 'contact_id', 7, 'hidden', 'Contact', '', '', '', '', '', '', '', '', 'contact_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2025, 'admin_user_edit', 'last_name', 'last_name', 6, 'text', 'Last Name *', '', '', '', '', '', '', '', '', 'last_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2024, 'admin_user_edit', 'first_name', 'first_name', 5, 'text', 'First Name *', '', '', '', '', '', '', '', '', 'first_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2022, 'admin_user_edit', 'company_id', 'company_id', 3, 'hidden', 'Company', '', '', '', '', '', '', '', '', 'company_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2023, 'admin_user_edit', 'group_id', 'group_id', 4, 'hidden', 'Group', '', '', '', '', '', '', '', '', 'group_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2021, 'admin_user_edit', 'customer_id', 'customer_id', 2, 'hidden', 'Customer', '', '', '', '', '', '', '', '', 'customer_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2020, 'admin_user_edit', 'partner_id', 'partner_id', 1, 'list', 'Partner *', '', '', 'partner', 'name!=''''', 'name', 'name', 'id', 'ITSP=0', 'partner_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2019, 'admin_user_edit', 'id', 'id', 0, 'hidden', 'Id', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1851, 'admin_device_new', 'partner_id', 'partner_id', 1, 'list', 'Partner', '', '', 'partner', 'name!=''''', 'name', 'name', 'id', 'ITSP=0', 'partner_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1852, 'admin_device_new', 'customer_id', 'customer_id', 2, 'hidden', 'Customer', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1853, 'admin_device_new', 'user_id', 'user_id', 3, 'hidden', 'User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1854, 'admin_device_new', 'mac', 'mac', 4, 'text', 'Mac', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1855, 'admin_device_new', 'vendor', 'vendor', 5, 'list', 'Vendor', '', '', 'device_template', 'make,type,model', 'make,model', 'make,type,model', 'id', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1856, 'admin_device_new', 'model', 'model', 6, 'text', 'Model', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1861, 'device_edit', 'sub1', 'sub2', 10, 'submit', 'Update Device', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1901, 'admin_device_edit', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1860, 'admin_device_new', 'sub1', 'sub2', 20, 'submit', 'Create New Device', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1902, 'admin_device_edit', 'partner_id', 'partner_id', 1, 'list', 'Partner', '', '', 'partner', 'name!=''''', 'name', 'name', 'id', 'ITSP=0', 'partner_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1903, 'admin_device_edit', 'customer_id', 'customer_id', 2, 'text', 'Customer', '', '', '', '', '', '', '', '', 'customer_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1904, 'admin_device_edit', 'user_id', 'user_id', 3, 'text', 'User', '', '', '', '', '', '', '', '', 'user_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1905, 'admin_device_edit', 'mac', 'mac', 4, 'text', 'Mac', '', '', '', '', '', '', '', '', 'mac', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1906, 'admin_device_edit', 'vendor', 'vendor', 5, 'text', 'Vendor', '', '', '', '', '', '', '', '', 'vendor', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1907, 'admin_device_edit', 'model', 'model', 6, 'text', 'Model', '', '', '', '', '', '', '', '', 'model', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1908, 'admin_device_edit', 'status', 'status', 7, 'text', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1909, 'admin_device_edit', 'lines', 'lines', 8, 'text', 'Lines', '', '', '', '', '', '', '', '', 'lines', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2695, 'route_profile_feature_transfer', 'Timeout', 'Timeout', 2, 'list', 'Timeout (Sec.)', '', '', 'select_option', 'upstream_name=''timeout''', 'id', 'description', 'value', '', 'Timeout', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1911, 'admin_device_edit', 'location_id', 'location_id', 10, 'text', 'Location', '', '', '', '', '', '', '', '', 'location_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1912, 'admin_device_edit', 'sub1', 'sub2', 11, 'submit', 'Update Device', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2694, 'route_profile_feature_get-dtmf', 'OnNoKeyPressed', 'OnNoKeyPressed', 15, 'text', 'On No Key Pressed', 'size=5 maxlength=2', '', '', '', '', '', '', '', 'OnNoKeyPressed', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2693, 'route_profile_feature_play-tts', 'OnFinishPlay', 'OnFinishPlay', 2, 'text', 'On Finish Play', 'size=5 maxlength=2', '', '', '', '', '', '', '', 'OnFinishPlay', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2692, 'route_profile_feature_play-number', 'OnFinishPlay', 'OnFinishPlay', 2, 'text', 'On Finish Play', 'size=5 maxlength=2', '', '', '', '', '', '', '', 'OnFinishPlay', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2691, 'route_profile_feature_play-message', 'OnFinishPlay', 'OnFinishPlay', 2, 'text', 'On Finish Play', 'size=5 maxlength=2', '', '', '', '', '', '', '', 'OnFinishPlay', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2690, 'route_profile_feature_time-condition', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2689, 'route_profile_feature_time-condition', 'Match', 'Match', 5, 'text', 'Match', '', 'dtmf_field', '', '', '', '', '', '', 'Match', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2688, 'route_profile_feature_time-condition', 'NoMatch', 'NoMatch', 6, 'text', 'NoMatch', '', 'dtmf_field', '', '', '', '', '', '', 'NoMatch', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2687, 'route_profile_feature_time-condition', 'DayOfWeek', 'DayOfWeek', 1, 'list', 'Day of Week', '', '', 'select_option', 'upstream_name=''days_of_week''', 'id', 'description', 'value', '', '', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2686, 'route_profile_feature_time-condition', 'StartTime', 'StartTime', 2, 'list', 'Start Time', '', '', '', '', '', '', '', 'am=am;pm=pm', '', '', '', '', '', '', '', '', 'hour_minute_start', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2685, 'route_profile_feature_time-condition', 'EndTime', 'EndTime', 3, 'list', 'End Time', '', '', '', '', '', '', '', 'am=am;pm=pm', '', '', '', '', '', '', '', '', 'hour_minute_end', 'add_time', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2684, 'route_profile_feature_date-condition', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2683, 'route_profile_feature_date-condition', 'Dates', 'Dates', 1, 'text', 'Dates (<sub>mm-dd</sub>)', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'dates_suffix', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2682, 'route_profile_feature_date-condition', 'Match', 'Match', 2, 'text', 'Match', '', 'dtmf_field', '', '', '', '', '', '', 'Match', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2681, 'route_profile_feature_date-condition', 'NoMatch', 'NoMatch', 3, 'text', 'NoMatch', '', 'dtmf_field', '', '', '', '', '', '', 'NoMatch', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2679, 'route_profile_info', 'profile_name', 'profile_name', 2, 'text', 'Name', '', '', '', '', '', '', '', '', 'profile_name', '', '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `field_templates` VALUES(2680, 'route_profile_info', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1933, 'list_devices', 'device_list', 'device_list', 0, 'list', 'Select Device', '', '', 'device_template', 'id!=''''', 'model', 'model', 'model', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1934, 'list_devices', 'submit', 'submit', 1, 'submit', 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2678, 'route_profile_feature_transfer', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2677, 'route_profile_feature_transfer', 'Number', 'Number', 1, 'text', 'Number', '', 'Gateway phone_number', '', '', '', '', '', '', 'Number', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2676, 'route_profile_feature_get-dtmf', 'DTMF10', 'DTMF10', 14, 'text', 'DTMF*', 'maxlength =2', 'dtmf_field', '', '', '', '', '', '', 'DTMF10', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2675, 'route_profile_feature_get-dtmf', 'DTMF9', 'DTMF9', 13, 'text', 'DTMF9', 'maxlength =2', 'dtmf_field', '', '', '', '', '', '', 'DTMF9', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2674, 'route_profile_feature_get-dtmf', 'DTMF8', 'DTMF8', 12, 'text', 'DTMF8', 'maxlength =2', 'dtmf_field', '', '', '', '', '', '', 'DTMF8', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2673, 'route_profile_feature_get-dtmf', 'DTMF7', 'DTMF7', 11, 'text', 'DTMF7', 'maxlength =2', 'dtmf_field', '', '', '', '', '', '', 'DTMF7', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2672, 'route_profile_feature_get-dtmf', 'DTMF6', 'DTMF6', 10, 'text', 'DTMF6', 'maxlength =2', 'dtmf_field', '', '', '', '', '', '', 'DTMF6', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2671, 'route_profile_feature_get-dtmf', 'DTMF5', 'DTMF5', 9, 'text', 'DTMF5', 'maxlength =2', 'dtmf_field', '', '', '', '', '', '', 'DTMF5', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2670, 'route_profile_feature_get-dtmf', 'DTMF4', 'DTMF4', 8, 'text', 'DTMF4', 'maxlength =2', 'dtmf_field', '', '', '', '', '', '', 'DTMF4', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2669, 'route_profile_feature_get-dtmf', 'DTMF3', 'DTMF3', 7, 'text', 'DTMF3', 'maxlength =2', 'dtmf_field', '', '', '', '', '', '', 'DTMF3', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2668, 'route_profile_feature_get-dtmf', 'DTMF2', 'DTMF2', 6, 'text', 'DTMF2', 'maxlength =2', 'dtmf_field', '', '', '', '', '', '', 'DTMF2', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2667, 'route_profile_feature_get-dtmf', 'DTMF1', 'DTMF1', 5, 'text', 'DTMF1', 'maxlength =2', 'dtmf_field', '', '', '', '', '', '', 'DTMF1', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2666, 'route_profile_feature_get-dtmf', 'DTMF0', 'DTMF0', 4, 'text', 'DTMF0', 'maxlength =2', 'dtmf_field', '', '', '', '', '', '', 'DTMF0', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2665, 'route_profile_feature_get-dtmf', 'Retry', 'Retry', 3, 'list', 'Retry', '', '', '', '', '', '', '', 'retry_times', 'Retry', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2664, 'route_profile_feature_get-dtmf', 'Prompt', 'Prompt', 1, 'list', 'Prompt', '', '', '', '', '', '', '', 'prompt_list', 'Prompt', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(1956, 'state_selection', 'state_selected', 'state_selected', 0, 'list', 'Select State', '', '', 'states', 'country=''USA''', 'state', 'state', 'prefix', '', '', '', '', '', '', '', '', '', '', ' <input type=''submit'' value=''Search''>', '', '', 0);
INSERT INTO `field_templates` VALUES(1958, 'area_selection', 'area_code', 'area_code', 0, 'list', 'Select one Area Code', '', '', '', '', '', '', '', 'area_code_list', '', '', '', '', '', '', '', ' ', '', 'submit_button', '', '', 0);
INSERT INTO `field_templates` VALUES(1959, 'phone_number_list', 'ph', 'ph', 0, 'list', 'Phone Number', '', '', '', '', '', '', '', 'ph_list', '', '', '', '', '', '', '', '', '', 'submit_button', '', '', 0);
INSERT INTO `field_templates` VALUES(1960, 'add_porting_number', 'phone_number', 'phone_number', 0, 'text', 'Phone Number', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1961, 'add_porting_number', 'customer_number', 'customer_number', 1, 'text', 'Customer Number', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1962, 'add_porting_number', 'subm_bt', 'subm_bt', 2, 'submit', 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1963, 'call_recording_menu', 'year', 'year', 0, 'list', 'Select Year', '', '', '', '', '', '', '', 'year_options', 'current_year', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1964, 'call_recording_menu', 'month', 'month', 1, 'list', 'Select Month', '', '', 'select_option', 'upstream_name=''months''', 'value', 'description', 'value', '', 'current_month', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1965, 'call_recording_menu', '', '', 2, 'submit', 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1966, 'customer_account_form_billing_address', 'billing_address_field_address', 'address', 0, 'text', 'Address', '', '', '', '', '', '', '', '', 'address', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1967, 'customer_account_form_billing_address', 'billing_address_field_city', 'city', 1, 'text', 'City', '', '', '', '', '', '', '', '', 'city', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1968, 'customer_account_form_billing_address', 'billing_address_field_state', 'state', 2, 'list', 'State', '', '', 'states', 'country=''USA''', 'state', 'state', 'prefix', '', 'state', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1969, 'customer_account_form_billing_address', 'billing_address_field_zip', 'zip', 3, 'text', 'Zip', '', '', '', '', '', '', '', '', 'zip', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1970, 'customer_account_form_billing_address', 'billing_address_field_id', 'id', 5, 'hidden', 'id', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1971, 'customer_account_form_shipping_address', 'shipping_address_field_address', 'address', 0, 'text', 'Address', '', '', '', '', '', '', '', '', 'address', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1972, 'customer_account_form_shipping_address', 'shipping_address_field_city', 'city', 1, 'text', 'City', '', '', '', '', '', '', '', '', 'city', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1973, 'customer_account_form_shipping_address', 'shipping_address_field_state', 'state', 2, 'list', 'State', '', '', 'states', 'country=''USA''', 'state', 'state', 'prefix', '', 'state', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1974, 'customer_account_form_shipping_address', 'shipping_address_field_zip', 'zip', 3, 'text', 'Zip', '', '', '', '', '', '', '', '', 'zip', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1975, 'customer_account_form_shipping_address', 'shipping_address_field_id', 'id', 5, 'hidden', 'id', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1976, 'customer_account_form_e-911_address', 'e-911_address_field_address', 'address', 0, 'text', 'Address', '', '', '', '', '', '', '', '', 'address', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1977, 'customer_account_form_e-911_address', 'e-911_address_field_city', 'city', 1, 'text', 'City', '', '', '', '', '', '', '', '', 'city', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1978, 'customer_account_form_e-911_address', 'e-911_address_field_state', 'state', 2, 'list', 'State', '', '', 'states', 'country=''USA''', 'state', 'state', 'prefix', '', 'state', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1979, 'customer_account_form_e-911_address', 'e-911_address_field_zip', 'zip', 3, 'text', 'Zip', '', '', '', '', '', '', '', '', 'zip', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1980, 'customer_account_form_e-911_address', 'e-911_address_field_id', 'id', 5, 'hidden', 'id', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1981, 'customer_account_form_extension', 'extension_field_caller_id_number', 'caller_id_number', 0, 'list', 'Caller ID Number', '', '', '', '', '', '', '', 'my_numbers', 'caller_id_number', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1982, 'customer_account_form_extension', 'extension_field_caller_id_name', 'caller_id_name', 1, 'text', 'Caller ID Name', '', '', '', '', '', '', '', '', 'caller_id_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1983, 'customer_account_form_extension', 'extension_video_support', 'video_support', 2, 'list', 'Video Support', '', '', '', '', '', '', '', 'yes_no_options', 'video_support', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1984, 'customer_account_form_extension', 'extension_field_nat_support', 'nat_support', 3, 'list', 'Nat Support', '', '', '', '', '', '', '', 'yes_no_options', 'nat_support', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1985, 'customer_account_form_extension', 'extension_field_qualify', 'qualify', 4, 'list', 'Qualify', '', '', '', '', '', '', '', 'yes_no_options', 'qualify', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1986, 'customer_account_form_extension', 'extension_field_status', 'status', 10, 'list', 'Status', '', '', '', '', '', '', '', 'status_options', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1987, 'customer_account_form_extension', 'extension_field_simultaneous_calls_limit', 'simultaneous_calls_limit', 5, 'list', 'Simultaneous Call Paths', '', '', '', '', '', '', '', 'simultaneous_calls_limit_options\r\n', 'simultaneous_calls_limit', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1988, 'customer_account_form_extension', 'extension_field_ring_timeout', 'ring_timeout', 6, 'list', 'Ringing Timeout', '', '', '', '', '', '', '', 'ring_timeout_options', 'ring_timeout', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1989, 'customer_account_form_extension', 'extension_field_id', 'id', 10, 'hidden', 'id', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1990, 'customer_account_form_extension', 'extension_field_cid_911', 'cid_911', 7, 'list', 'Cid 911', '', '', '', '', '', '', '', 'my_numbers', 'cid_911', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1991, 'customer_account_form_extension_feature', 'extension_feature_field_cid_block', 'cid_block', 0, 'list', 'Cid Block', '', '', '', '', '', '', '', 'yes_no_options', 'cid_block', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1992, 'customer_account_form_extension_feature', 'extension_feature_field_dnd', 'dnd', 1, 'list', 'Dnd', '', '', '', '', '', '', '', 'yes_no_options', 'dnd', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1993, 'customer_account_form_extension_feature', 'extension_feature_field_permit_out_of_group', 'permit_out_of_group', 2, 'list', 'Permit  Out of Group', '', '', '', '', '', '', '', 'yes_no_options', 'permit_out_of_group', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1994, 'customer_account_form_extension_feature', 'extension_feature_field_permit_long_distance', 'permit_long_distance', 3, 'list', 'Permit Long Distance', '', '', '', '', '', '', '', 'yes_no_options', 'permit_long_distance', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1995, 'customer_account_form_extension_feature', 'extension_feature_field_permit_international', 'permit_international', 4, 'list', 'Permit International', '', '', '', '', '', '', '', 'yes_no_options', 'permit_international', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1996, 'customer_account_form_extension_feature', 'extension_feature_field_permit_411_directory', 'permit_411_directory', 5, 'list', 'Permit 411 Directory', '', '', '', '', '', '', '', 'yes_no_options', 'permit_411_directory', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1997, 'customer_account_form_extension_feature', 'extension_feature_field_permit_virtual_codes', 'permit_virtual_codes', 6, 'list', 'Permit Virtual Codes', '', '', '', '', '', '', '', 'yes_no_options', 'permit_virtual_codes', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1998, 'customer_account_form_extension_feature', 'extension_feature_field_call_forwarding_always', 'call_forwarding_always', 7, 'text', 'Call Forwarding Always', '', '', '', '', '', '', '', '', 'call_forwarding_always', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(1999, 'customer_account_form_extension_feature', 'extension_feature_field_call_forwarding_on_busy', 'call_forwarding_on_busy', 8, 'text', 'Call Forwarding On Busy', '', '', '', '', '', '', '', '', 'call_forwarding_on_busy', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2000, 'customer_account_form_extension_feature', 'extension_feature_field_call_forwarding_on_no_answ', 'call_forwarding_on_no_answer', 9, 'text', 'Call Forwarding On No Answer', '', '', '', '', '', '', '', '', 'call_forwarding_on_no_answer', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2001, 'customer_account_form_extension_feature', 'extension_feature_field_anonymous_call_rejection', 'anonymous_call_rejection', 10, 'list', 'Anonymous Call Rejection', '', '', '', '', '', '', '', 'yes_no_options', 'anonymous_call_rejection', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2002, 'customer_account_form_extension_feature', 'extension_feature_field_call_recording', 'call_recording', 11, 'list', 'Call Recording', '', '', '', '', '', '', '', 'yes_no_options', 'call_recording', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2003, 'customer_account_form_extension_feature', 'extension_feature_field_call_recording_beep', 'call_recording_beep', 12, 'list', 'Call Recording Beep', '', '', '', '', '', '', '', 'yes_no_options', 'call_recording_beep', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2004, 'customer_account_form_extension_feature', 'extension_feature_field_id', 'id', 13, 'hidden', 'id', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2005, 'customer_account_form_conference', 'conference_field_pin', 'pin', 0, 'text', 'Pin', '', '', '', '', '', '', '', '', 'pin', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2006, 'customer_account_form_conference', 'conference_field_admin_pin', 'admin_pin', 1, 'text', 'Admin Pin', '', '', '', '', '', '', '', '', 'admin_pin', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2007, 'customer_account_form_conference', 'conference_field_id', 'id', 3, 'hidden', 'id', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2036, 'admin_user_edit', 'permit_sms', 'permit_sms', 17, 'hidden', 'Permit Sms', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'permit_sms', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2336, 'extension_edit', 'secondary_codec', 'secondary_codec', 16, 'list', 'Secondary Codec', '', '', 'select_option', 'upstream_name=''codecs''', 'value', 'description', 'value', '', 'secondary_codec', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2330, 'extension_edit', 'status', 'status', 10, 'hidden', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2331, 'extension_edit', 'protocol', 'protocol', 11, 'readonly', 'Protocol', '', '', '', '', '', '', '', '', 'protocol', '', '', '', '', '61', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2329, 'extension_edit', 'caller_id_name', 'caller_id_name', 9, 'text', 'Caller Name', '', '', '', '', '', '', '', '', 'caller_id_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2328, 'extension_edit', 'caller_id_number', 'caller_id_number', 8, 'list', 'Caller Number', '', '', '', '', '', '', '', 'caller_id_number_list', 'caller_id_number', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2326, 'extension_edit', 'password', 'password', 6, 'readonly', 'Password', '', '', '', '', '', '', '', '', 'password', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2325, 'extension_edit', 'username', 'username', 5, 'readonly', 'Username', '', '', '', '', '', '', '', '', 'username', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2323, 'extension_edit', 'calling_group', 'calling_group', 3, 'hidden', 'Calling Group', '', '', '', '', '', '', '', '', 'calling_group', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2037, 'admin_user_edit', 'sms_credits', 'sms_credits', 18, 'hidden', 'Sms Credits', '', '', '', '', '', '', '', '', 'sms_credits', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2038, 'admin_user_edit', 'preferred_language', 'preferred_language', 19, 'hidden', 'Preferred Language', '', '', '', '', '', '', '', '', 'preferred_language', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2039, 'admin_user_edit', 'sub1', 'sub2', 58, 'submit', 'Update User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2040, 'admin_user_edit', 'twitter', 'twitter', 54, 'hidden', 'Twitter', '', '', '', '', '', '', '', '', 'twitter', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2041, 'admin_user_edit', 'facebook', 'facebook', 53, 'hidden', 'Facebook', '', '', '', '', '', '', '', '', 'facebook', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2042, 'admin_user_edit', 'icq', 'icq', 51, 'hidden', 'ICQ', '', '', '', '', '', '', '', '', 'icq', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2043, 'admin_user_edit', 'im', 'im', 52, 'hidden', 'IM', '', '', '', '', '', '', '', '', 'im', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2044, 'admin_user_edit', 'yahoo', 'yahoo', 50, 'hidden', 'Yahoo', '', '', '', '', '', '', '', '', 'yahoo', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2045, 'admin_user_edit', 'msn', 'msn', 49, 'hidden', 'MSN', '', '', '', '', '', '', '', '', 'msn', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2046, 'admin_user_edit', 'gtalk', 'gtalk', 48, 'hidden', 'Gtalk', '', '', '', '', '', '', '', '', 'gtalk', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2047, 'admin_user_edit', 'email', 'email', 47, 'text', 'Email *', '', '', '', '', '', '', '', '', 'email', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2048, 'admin_user_edit', 'fax', 'fax', 46, 'text', 'Fax', '', '', '', '', '', '', '', '', 'fax', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2049, 'admin_user_edit', 'mobile_phone', 'mobile_phone', 45, 'text', 'Mobile Phone *', '', '', '', '', '', '', '', '', 'mobile_phone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2050, 'admin_user_edit', 'work_extension', 'work_extension', 44, 'text', 'Work Extension', '', '', '', '', '', '', '', '', 'work_extension', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2051, 'admin_user_edit', 'work_phone', 'work_phone', 43, 'text', 'Work Phone', '', '', '', '', '', '', '', '', 'work_phone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2052, 'admin_user_edit', 'home_phone', 'home_phone', 42, 'text', 'Home Phone', '', '', '', '', '', '', '', '', 'home_phone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2053, 'admin_user_edit', 'myspace', 'myspace', 55, 'hidden', 'MySpace', '', '', '', '', '', '', '', '', 'myspace', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2054, 'admin_user_edit', 'orkut', 'orkut', 56, 'hidden', 'Orkut', '', '', '', '', '', '', '', '', 'orkut', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2055, 'admin_user_edit', 'www', 'www', 57, 'hidden', 'Website', '', '', '', '', '', '', '', '', 'www', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2307, 'mailbox_edit', 'dialout', 'dialout', 9, 'hidden', 'Dial Out', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'dialout', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2306, 'mailbox_edit', 'saycid', 'saycid', 8, 'list', 'Say Caller ID', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'saycid', '', '', '', '', '', '', '', '', '', '', 'Read back caller''s telephone number prior to playing the incoming message, and just after announcing the date and time the message was left. This setting takes a yes or no value. If the administrator wants the caller''s phone number to be heard prior to playing back a voicemail message, this option should be set to yes.', 0);
INSERT INTO `field_templates` VALUES(2305, 'mailbox_edit', 'attatch', 'attatch', 7, 'list', 'Attach', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'attatch', '', '', '', '', '', '', '', '', '', '', 'Attach causes ITSP to copy a voicemail message to an audio file and send it to the user as an attachment in an e-mail voicemail notification message.', 0);
INSERT INTO `field_templates` VALUES(2304, 'mailbox_edit', 'email', 'email', 6, 'text', 'Email', '', '', '', '', '', '', '', '', 'email', '', '', '', '', '', '', '', '', '', '', 'Email address that will be used by ITSP to send voicemail as an audio file.', 0);
INSERT INTO `field_templates` VALUES(2302, 'mailbox_edit', 'mailbox', 'mailbox', 3, 'hidden', 'Mailbox', '', '', '', '', '', '', '', '', 'mailbox', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2303, 'mailbox_edit', 'password', 'password', 5, 'password', 'Password *', 'maxlength=4', '', '', '', '', '', '', '', 'password', '', '', '', '', '', '', '', '', '', '', 'Can be any NUMBER and will be used by the user to access their voice mail box via phone.', 0);
INSERT INTO `field_templates` VALUES(2300, 'mailbox_edit', 'user_id', 'user_id', 1, 'hidden', 'User', '', '', '', '', '', '', '', '', 'user_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2301, 'mailbox_edit', 'customer_id', 'customer_id', 2, 'hidden', 'Customer', '', '', '', '', '', '', '', '', 'customer_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2299, 'mailbox_edit', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2182, 'user_edit_device_form_GXP2000', 'id', 'id', 0, 'hidden', 'id', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2183, 'user_edit_device_form_GXP2000', 'P35', 'P35', 1, 'list', 'Line 1 User ID', '', '', '', '', '', '', '', 'extension_options', 'P35', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2184, 'user_edit_device_form_GXP2000', 'P3', 'P3', 2, 'text', 'Line 1 Display Name', '', '', '', '', '', '', '', '', 'P3', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2185, 'user_edit_device_form_GXP2000', 'P404', 'P404', 3, 'list', 'Line 2 User ID', '', '', '', '', '', '', '', 'extension_options', 'P404', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2186, 'user_edit_device_form_GXP2000', 'P407', 'P407', 4, 'text', 'Line 2 Display Name', '', '', '', '', '', '', '', '', 'P407', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2187, 'user_edit_device_form_GXP2000', 'P504', 'P504', 5, 'list', 'Line 3 User ID', '', '', '', '', '', '', '', 'extension_options', 'P504', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2188, 'user_edit_device_form_GXP2000', 'P507', 'P507', 6, 'text', 'Line 3 Display Name', '', '', '', '', '', '', '', '', 'P507', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2189, 'user_edit_device_form_GXP2000', 'P604', 'P604', 7, 'list', 'Line 4 User ID', '', '', '', '', '', '', '', 'extension_options', 'P604', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2190, 'user_edit_device_form_GXP2000', 'P607', 'P607', 8, 'text', 'Line 4 Display Name', '', '', '', '', '', '', '', '', 'P607', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2191, 'user_edit_device_form_GXP2000', 'sub', 'sub', 9, 'submit', 'Update Device', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2192, 'user_edit_device_form_GXP2020', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2193, 'user_edit_device_form_GXP2020', 'P35', 'P35', 1, 'list', 'Line 1 User ID', '', '', '', '', '', '', '', 'extension_options', 'P35', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2194, 'user_edit_device_form_GXP2020', 'P3', 'P3', 2, 'text', 'Line 1 Display Name', '', '', '', '', '', '', '', '', 'P3', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2195, 'user_edit_device_form_GXP2020', 'P404', 'P404', 3, 'list', 'Line 2 User ID', '', '', '', '', '', '', '', 'extension_options', 'P404', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2196, 'user_edit_device_form_GXP2020', 'P407', 'P407', 4, 'text', 'Line 2 Display Name', '', '', '', '', '', '', '', '', 'P407', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2197, 'user_edit_device_form_GXP2020', 'P504', 'P504', 5, 'list', 'Line 3 User ID', '', '', '', '', '', '', '', 'extension_options', 'P504', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2198, 'user_edit_device_form_GXP2020', 'P507', 'P507', 6, 'text', 'Line 3 Display Name', '', '', '', '', '', '', '', '', 'P507', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2199, 'user_edit_device_form_GXP2020', 'P604', 'P604', 7, 'list', 'Line 4 User ID', '', '', '', '', '', '', '', 'extension_options', 'P604', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2200, 'user_edit_device_form_GXP2020', 'P607', 'P607', 8, 'text', 'Line 4 Display Name', '', '', '', '', '', '', '', '', 'P607', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2201, 'user_edit_device_form_GXP2020', 'P1704', 'P1704', 9, 'list', 'Line 5 User ID', '', '', '', '', '', '', '', 'extension_options', 'P1704', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2202, 'user_edit_device_form_GXP2020', 'P1707', 'P1707', 10, 'text', 'Line 5 Display Name', '', '', '', '', '', '', '', '', 'P1707', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2203, 'user_edit_device_form_GXP2020', 'P1804', 'P1804', 11, 'list', 'Line 6 User ID', '', '', '', '', '', '', '', 'extension_options', 'P1804', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2204, 'user_edit_device_form_GXP2020', 'P1807', 'P1807', 12, 'text', 'Line 6 Display Name', '', '', '', '', '', '', '', '', 'P1807', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2205, 'user_edit_device_form_GXP2020', 'sub', 'sub', 50, 'submit', 'Update Device', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2206, 'user_edit_device_form_GXV3140', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2207, 'user_edit_device_form_GXV3140', 'P304', 'P304', 1, 'list', 'Line 1 User ID', '', '', '', '', '', '', '', 'extension_options', 'P304', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2208, 'user_edit_device_form_GXV3140', 'P307', 'P307', 2, 'text', 'Line 1 Display Name', '', '', '', '', '', '', '', '', 'P307', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2209, 'user_edit_device_form_GXV3140', 'P404', 'P404', 3, 'list', 'Line 2 User ID', '', '', '', '', '', '', '', 'extension_options', 'P404', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2210, 'user_edit_device_form_GXV3140', 'P407', 'P407', 4, 'text', 'Line 2 Display Name;', '', '', '', '', '', '', '', '', 'P407', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2211, 'user_edit_device_form_GXV3140', 'P504', 'P504', 5, 'list', 'Line 3 User ID', '', '', '', '', '', '', '', 'extension_options', 'P504', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2212, 'user_edit_device_form_GXV3140', 'P507', 'P507', 6, 'text', 'Line 3 Display Name', '', '', '', '', '', '', '', '', 'P507', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2213, 'user_edit_device_form_GXV3140', 'sub', 'sub', 50, 'submit', 'Update Device', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2214, 'user_edit_device_form_BT200', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2215, 'user_edit_device_form_BT200', 'P35', 'P35', 1, 'list', 'Line 1 User ID', '', '', '', '', '', '', '', 'extension_options', 'P35', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2216, 'user_edit_device_form_BT200', 'P3', 'P3', 2, 'text', 'Line 1 Display Name', '', '', '', '', '', '', '', '', 'P3', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2217, 'user_edit_device_form_BT200', 'sub', 'sub', 50, 'submit', 'Update Device', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2218, 'user_edit_device_form_HT502', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2219, 'user_edit_device_form_HT502', 'P35', 'P35', 1, 'list', 'Line 1 User ID', '', '', '', '', '', '', '', 'extension_options', 'P35', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2220, 'user_edit_device_form_HT502', 'P3', 'P3', 2, 'text', 'Line 1 Display Name', '', '', '', '', '', '', '', '', 'P3', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2221, 'user_edit_device_form_HT502', 'P735', 'P735', 3, 'list', 'Line 2 User ID', '', '', '', '', '', '', '', 'extension_options', 'P735', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2222, 'user_edit_device_form_HT502', 'P703', 'P703', 4, 'text', 'Line 2 Display Name;', '', '', '', '', '', '', '', '', 'P703', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2223, 'user_edit_device_form_HT502', 'sub', 'sub', 5, 'submit', 'Update Device', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2224, 'user_edit_device_form_HT486', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2225, 'user_edit_device_form_HT486', 'P35', 'P35', 1, 'list', 'Line 1 User ID', '', '', '', '', '', '', '', 'extension_options', 'P35', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2226, 'user_edit_device_form_HT486', 'P3', 'P3', 2, 'text', 'Line 1 Display Name', '', '', '', '', '', '', '', '', 'P3', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2227, 'user_edit_device_form_HT486', 'sub', 'sub', 50, 'submit', 'Update Device', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2260, 'customer_create_payment_profile_form', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2270, 'user_edit_remote_access_form', 'user_id', 'user_id', 1, 'hidden', '', '', '', '', '', '', '', '', '', 'user_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2262, 'customer_create_payment_profile_form', 'sub', 'sub', 50, 'submit', 'Add Payment Profile', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2263, 'customer_create_payment_profile_form', 'firstName', 'firstName', 2, 'text', 'First Name *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2264, 'customer_create_payment_profile_form', 'lastName', 'lastName', 3, 'text', 'Last Name *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2265, 'customer_create_payment_profile_form', 'company', 'company', 4, 'text', 'Company', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2266, 'customer_create_payment_profile_form', 'cardNumber', 'cardNumber', 11, 'text', 'Card Number *', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2267, 'customer_create_payment_profile_form', 'expirationDateMonth', 'expirationDateMonth', 12, 'list', 'Expiration Month', '', '', '', '', '', '', '', 'months_options', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2268, 'customer_create_payment_profile_form', 'expirationDateYear', 'expirationDateYear', 13, 'list', 'Expiration Year', '', '', '', '', '', '', '', 'years_options', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2269, 'customer_create_payment_profile_form', 'cardCode', 'cardCode', 14, 'text', 'Card Security Code (CVV)', 'size=4', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2324, 'extension_edit', 'extension_number', 'extension_number', 4, 'readonly', 'Extension Number', '', '', '', '', '', '', '', '', 'extension_number', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2332, 'extension_edit', 'nat_support', 'nat_support', 12, 'list', 'Nat Support', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'nat_support', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2337, 'extension_edit', 'simultaneous_calls_limit', 'simultaneous_calls_limit', 17, 'text', 'Simultaneous Calls Limit', 'maxlength=2', '', '', '', '', '', '', '', 'simultaneous_calls_limit', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2271, 'user_edit_remote_access_form', 'mobile_number', 'mobile_number', 2, 'text', 'Mobile Number', '', '', '', '', '', '', '', '', 'mobile_number', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2272, 'user_edit_remote_access_form', 'sub', 'sub', 50, 'submit', 'Edit Mobile Number', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2411, 'conference_plus_setup', 'cfp_participants', 'cfp_participants', 5, 'textarea', 'Invite the following Participants \r\n<br> <sub>* Maximum of 20 Participants<br>&#8226; For each participant, you must type their number and press enter<br>&#8226; One participant per entry in either of the following formats:<br>&nbsp; &nbsp; &nbsp; &ordm; 2145559874 or John Doe,2145559874<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &sect; Example of inviting participants:<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; \r\nJohn Doe,2145559874<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; \r\n2143335963', 'cols=''40'' rows=''10''', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2412, 'conference_plus_setup', 'cfp_announce_count', 'cfp_announce_count', 6, 'checkbox', 'Announce number of participants', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2410, 'conference_plus_setup', 'cfp_timezone', 'cfp_timezone', 2, 'list', 'Conference Time Zone', '', '', 'timezone', 'zone!=''''', 'zone DESC', 'zone', 'zone', '', 'US/Central', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2409, 'conference_plus_setup', 'cfp_submit', 'cfp_submit', 50, 'submit', 'Schedule', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2408, 'conference_plus_setup', 'cfp_time', 'cfp_time', 1, 'text', 'Conference Time', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2407, 'conference_plus_setup', 'cfp_date', 'cfp_date', 0, 'text', 'Conference Date', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2406, 'conference_plus_setup', 'cfp_admin', 'cfp_admin', 3, 'list', 'Add me to the conference via', '', '', 'contact c, user u, phone_number p', 'u.customer_id=''s{selected_customer_id}'' AND u.contact_id=c.id AND p.customer_id=''s{selected_customer_id}''', 'mobile_phone ASC', 'mobile_phone,number', 'mobile_phone,number', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2287, 'customer_pay_now_form', 'amount', 'amount', 1, 'text', 'Amount', 'size=8', '', '', '', '', '', '', '', 'amount', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2288, 'customer_pay_now_form', 'payment_profile_id', 'payment_profile_id', 2, 'list', 'Charge this card', '', '', '', '', '', '', '', 'payment_profile_options', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2289, 'customer_pay_now_form', 'sub', 'sub', 10, 'submit', 'Pay Now', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2290, 'customer_pay_now_confirmation_form', 'amount', 'amount', 1, 'hidden', '', '', '', '', '', '', '', '', '', 'amount', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2291, 'customer_pay_now_confirmation_form', 'payment_profile_id', 'payment_profile_id', 2, 'hidden', '', '', '', '', '', '', '', '', '', 'payment_profile_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2292, 'customer_pay_now_confirmation_form', 'sub', 'sub', 9, 'submit', 'Submit', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'cancel_button', '', '', 0);
INSERT INTO `field_templates` VALUES(2293, 'customer_current_limit_form', 'current_limit', 'current_limit', 1, 'list', 'Current Limit', '', '', '', '', '', '', '', 'limit_options', 'current_limit', '', '', '', '', '75', 'readonly', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2294, 'customer_current_limit_form', 'sub', 'sub', 10, 'submit', 'Update', '', '', '', '', '', '', '', '', '', '', '', '', '', '75', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2295, 'customer_create_transaction_form', 'transaction_code', 'transaction_code', 1, 'list', 'Type', '', '', '', '', '', '', '', 'transaction_code_options', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2296, 'customer_create_transaction_form', 'description', 'description', 2, 'textarea', 'Description', 'maxlength=100', '', '', '', '', '', '', '', '', '4', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2297, 'customer_create_transaction_form', 'amount', 'amount', 3, 'text', 'Amount', 'size=8', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2298, 'customer_create_transaction_form', 'sub', 'sub', 10, 'submit', 'Create Transaction', '', '', '', '', '', '', '', '', 'Create Transaction', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2317, 'mailbox_edit', 'context', 'context', 19, 'hidden', 'Context', '', '', '', '', '', '', '', '', 'context', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2318, 'mailbox_edit', 'status', 'status', 20, 'list', 'Status', '', '', 'select_option', 'upstream_name=''enabled_disabled''', 'description', 'description', 'value', '', 'status', '', '', '', '', '', '', '', '', '', '', 'If the VM box is active of canceled.', 0);
INSERT INTO `field_templates` VALUES(2319, 'mailbox_edit', 'sub', 'sub', 50, 'submit', 'Update Mailbox', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2320, 'mailbox_edit', 'label', 'label', 4, 'text', 'Mailbox Name', 'maxlength=100', '', '', '', '', '', '', '', 'label', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2345, 'extension_edit', 'permit_long_distance', 'permit_long_distance', 25, 'list', 'Long Distance Calling', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'permit_long_distance', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2341, 'extension_edit', 'mail_box_id', 'mail_box_id', 21, 'hidden', 'Mail Box', '', '', '', '', '', '', '', '', 'mail_box_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2340, 'extension_edit', 'mail_box', 'mail_box', 20, 'hidden', 'Mail Box', '', '', '', '', '', '', '', '', 'mail_box', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2335, 'extension_edit', 'primary_codec', 'primary_codec', 15, 'list', 'Primary Codec', '', '', 'select_option', 'upstream_name=''codecs''', 'value', 'description', 'value', '', 'primary_codec', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2334, 'extension_edit', 'qualify', 'qualify', 14, 'list', 'Qualify', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'qualify', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2333, 'extension_edit', 'video_support', 'video_support', 13, 'list', 'Video Support', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'video_support', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2327, 'extension_edit', 'cid_911', 'cid_911', 7, 'list', '911 Caller ID', '', '', '', '', '', '', '', 'caller_id_number_list', 'cid_911', '', '', '', '', '61', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2322, 'extension_edit', 'id', 'id', 2, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2321, 'extension_edit', 'user_id', 'user_id', 1, 'hidden', 'User', '', '', '', '', '', '', '', '', 'user_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2349, 'extension_edit', 'call_forwarding_always', 'call_forwarding_always', 29, 'text', 'Call Forwarding Always', 'maxlength=10', '', '', '', '', '', '', '', 'call_forwarding_always', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2350, 'extension_edit', 'call_forwarding_on_busy', 'call_forwarding_on_busy', 30, 'text', 'Call Forwarding Busy', 'maxlength=10', '', '', '', '', '', '', '', 'call_forwarding_on_busy', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2351, 'extension_edit', 'call_forwarding_on_no_answer', 'call_forwarding_on_no_answer', 31, 'text', 'Call Forwarding No Answer', 'maxlength=10', '', '', '', '', '', '', '', 'call_forwarding_on_no_answer', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2352, 'extension_edit', 'anonymous_call_rejection', 'anonymous_call_rejection', 32, 'list', 'Anonymous Call Rejection', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'anonymous_call_rejection', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2353, 'extension_edit', 'sub', 'sub', 35, 'submit', 'Update Extension', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2354, 'cdr_list_menu', 'year', 'year', 0, 'list', 'Select Year', '', '', '', '', '', '', '', 'year_options', 'current_year', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2355, 'cdr_list_menu', 'month', 'month', 1, 'list', 'Select Month', '', '', 'select_option', 'upstream_name=''cdr_months''', 'value', 'description', 'value', '', 'current_month', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2356, 'cdr_list_menu', '', '', 2, 'submit', 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2357, 'quick_list_menu', 'customer_id', 'customer_id', 0, 'text', 'Please type the customer Number', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ' <input type=''submit'' value=''Search''>', '', '', 0);
INSERT INTO `field_templates` VALUES(2359, 'directory_create_form', 'first_name', 'first_name', 1, 'text', 'First Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2360, 'directory_create_form', 'last_name', 'last_name', 2, 'text', 'Last Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2361, 'directory_create_form', 'company_name', 'company_name', 3, 'text', 'Company', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2362, 'directory_create_form', 'home_phone', 'home_phone', 4, 'text', 'Home Phone', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2363, 'directory_create_form', 'work_phone', 'work_phone', 5, 'text', 'Work Phone', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2364, 'directory_create_form', 'work_extension', 'work_extension', 6, 'text', 'Work Extension', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2365, 'directory_create_form', 'mobile_phone', 'mobile_phone', 7, 'text', 'Mobile Phone', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2366, 'directory_create_form', 'fax', 'fax', 8, 'text', 'Fax', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2367, 'directory_create_form', 'email', 'email', 9, 'text', 'Email', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2368, 'directory_create_form', 'gtalk', 'gtalk', 10, 'text', 'Gtalk', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2369, 'directory_create_form', 'msn', 'msn', 11, 'text', 'MSN', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2370, 'directory_create_form', 'yahoo', 'yahoo', 12, 'text', 'Yahoo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2371, 'directory_create_form', 'icq', 'icq', 13, 'text', 'ICQ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2372, 'directory_create_form', 'im', 'im', 14, 'text', 'IM', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2373, 'directory_create_form', 'facebook', 'facebook', 15, 'text', 'Facebook', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2374, 'directory_create_form', 'twitter', 'twitter', 16, 'text', 'Twitter', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2375, 'directory_create_form', 'myspace', 'myspace', 17, 'text', 'MySpace', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2376, 'directory_create_form', 'orkut', 'orkut', 18, 'text', 'Orkut', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2377, 'directory_create_form', 'www', 'www', 19, 'text', 'Website', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2378, 'directory_create_form', 'sub', 'sub', 20, 'submit', 'New Contact', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2379, 'directory_edit_form', 'first_name', 'first_name', 1, 'text', 'First Name', '', '', '', '', '', '', '', '', 'first_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2380, 'directory_edit_form', 'last_name', 'last_name', 2, 'text', 'Last Name', '', '', '', '', '', '', '', '', 'last_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2381, 'directory_edit_form', 'company_name', 'company_name', 3, 'text', 'Company', '', '', '', '', '', '', '', '', 'company_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2382, 'directory_edit_form', 'home_phone', 'home_phone', 4, 'text', 'Home Phone', '', '', '', '', '', '', '', '', 'home_phone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2383, 'directory_edit_form', 'work_phone', 'work_phone', 5, 'text', 'Work Phone', '', '', '', '', '', '', '', '', 'work_phone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2384, 'directory_edit_form', 'work_extension', 'work_extension', 6, 'text', 'Work Extension', '', '', '', '', '', '', '', '', 'work_extension', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2385, 'directory_edit_form', 'mobile_phone', 'mobile_phone', 7, 'text', 'Mobile Phone', '', '', '', '', '', '', '', '', 'mobile_phone', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2386, 'directory_edit_form', 'fax', 'fax', 8, 'text', 'Fax', '', '', '', '', '', '', '', '', 'fax', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2387, 'directory_edit_form', 'email', 'email', 9, 'text', 'Email', '', '', '', '', '', '', '', '', 'email', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2388, 'directory_edit_form', 'gtalk', 'gtalk', 10, 'text', 'Gtalk', '', '', '', '', '', '', '', '', 'gtalk', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2389, 'directory_edit_form', 'msn', 'msn', 11, 'text', 'MSN', '', '', '', '', '', '', '', '', 'msn', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2390, 'directory_edit_form', 'yahoo', 'yahoo', 12, 'text', 'Yahoo', '', '', '', '', '', '', '', '', 'yahoo', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2391, 'directory_edit_form', 'icq', 'icq', 13, 'text', 'ICQ', '', '', '', '', '', '', '', '', 'icq', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2392, 'directory_edit_form', 'im', 'im', 14, 'text', 'IM', '', '', '', '', '', '', '', '', 'im', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2393, 'directory_edit_form', 'facebook', 'facebook', 15, 'text', 'Facebook', '', '', '', '', '', '', '', '', 'facebook', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2394, 'directory_edit_form', 'twitter', 'twitter', 16, 'text', 'Twitter', '', '', '', '', '', '', '', '', 'twitter', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2395, 'directory_edit_form', 'myspace', 'myspace', 17, 'text', 'MySpace', '', '', '', '', '', '', '', '', 'twitter', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2396, 'directory_edit_form', 'orkut', 'orkut', 18, 'text', 'Orkut', '', '', '', '', '', '', '', '', 'orkut', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2397, 'directory_edit_form', 'www', 'www', 19, 'text', 'Website', '', '', '', '', '', '', '', '', 'www', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2398, 'directory_edit_form', 'sub', 'sub', 20, 'submit', 'Edit Contact', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2399, 'directory_edit_form', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2400, 'show_conference', 'id', 'id', 1, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2401, 'show_conference', 'room', 'room', 2, 'readonly', 'Room', '', '', '', '', '', '', '', '', 'room', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2402, 'show_conference', 'status', 'status', 3, 'readonly', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2403, 'show_conference', 'pin', 'pin', 4, 'text', 'Pin', '', '', '', '', '', '', '', '', 'pin', '', '', '', '', '40', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2404, 'show_conference', 'admin_pin', 'admin_pin', 5, 'text', 'Admin Pin', '', '', '', '', '', '', '', '', 'admin_pin', '', '', '', '', '40', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2405, 'show_conference', 'sub', 'sub', 20, 'submit', 'Update', '', '', '', '', '', '', '', '', 'sub', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2413, 'conference_plus_setup', 'cfp_announce_join', 'cfp_announce_join', 7, 'checkbox', 'Announce participant on Join/Leave', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2414, 'conference_plus_setup', 'cfp_listen_only', 'cfp_listen_only', 8, 'checkbox', 'Set participant(s) in "Listen Only" mode', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2415, 'conference_plus_setup', 'cfp_quit_with_admin', 'cfp_quit_with_admin', 9, 'checkbox', 'Terminate conference when I hangup', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2416, 'conference_add_participants', 'participants', 'participants', 1, 'textarea', '<sub>Example: 2145559874 or Richard Smith, 2145559874</sub>', 'cols=40 rows=2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2417, 'conference_add_participants', 'room', 'room', 1, 'hidden', '', '', '', '', '', '', '', '', '', 'room', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2418, 'conference_add_participants', 'sub', 'sub', 2, 'submit', 'Add Participants', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2419, 'trouble_ticket_add_new', 'title', 'title', 2, 'text', 'Title', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2420, 'trouble_ticket_add_new', 'details', 'details', 4, 'textarea', 'Details', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2421, 'trouble_ticket_add_new', 'priority', 'priority', 6, 'list', 'Priority', '', '', 'select_option', 'upstream_name="trouble_ticket_priority"', 'value', 'description', 'value', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2422, 'trouble_ticket_add_new', 'category', 'category', 8, 'list', 'Category', '', '', 'select_option', 'upstream_name="trouble_ticket_category"', 'description', 'description', 'value', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2423, 'trouble_ticket_add_new', 'assigned_user_id', 'assigned_user_id', 10, 'list', 'Assign to', '', '', '', '', '', '', '', 'assign_user_options', '', '', '', '', '', '51', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2424, 'trouble_ticket_add_new', 'status', 'status', 12, 'list', 'Status', '', '', 'select_option', 'upstream_name="trouble_ticket_status"', 'description', 'description', 'value', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2425, 'trouble_ticket_add_new', 'sub', 'sub', 20, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2426, 'trouble_ticket_edit', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2427, 'trouble_ticket_edit', 'title', 'title', 2, 'text', 'Title', '', '', '', '', '', '', '', '', 'title', '', '', '', '', '80', 'readonly', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2428, 'trouble_ticket_edit', 'details', 'details', 4, 'textarea', 'Details', '', '', '', '', '', '', '', '', 'details', '', '', '', '', '80', 'readonly', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2429, 'trouble_ticket_edit', 'priority', 'priority', 6, 'list', 'Priority', '', '', 'select_option', 'upstream_name="trouble_ticket_priority"', 'value', 'description', 'value', '', 'priority', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2430, 'trouble_ticket_edit', 'category', 'category', 8, 'list', 'Category', '', '', 'select_option', 'upstream_name="trouble_ticket_category"', 'description', 'description', 'value', '', 'category', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2431, 'trouble_ticket_edit', 'assigned_user_id', 'assigned_user_id', 10, 'list', 'Assign to', '', '', '', '', '', '', '', 'assign_user_options', 'assigned_user_id', '', '', '', '', '51', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2432, 'trouble_ticket_edit', 'status', 'status', 12, 'list', 'Status', '', '', 'select_option', 'upstream_name="trouble_ticket_status"', 'description', 'description', 'value', '', 'status', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2433, 'trouble_ticket_edit', 'sub', 'sub', 20, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2434, 'trouble_ticket_comment_add_new', 'trouble_ticket_id', 'trouble_ticket_id', 2, 'hidden', '', '', '', '', '', '', '', '', '', 'trouble_ticket_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2435, 'trouble_ticket_comment_add_new', 'comment', 'comment', 4, 'textarea', 'Comments', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2436, 'trouble_ticket_comment_add_new', 'public', 'public', 6, 'list', 'Public', '', '', 'select_option', 'upstream_name="yes_no"', 'description', 'description', 'value', '', '1', '', '', '', '', '41', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2437, 'trouble_ticket_comment_add_new', 'sub', 'sub', 20, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2438, 'trouble_ticket_customer_add_new', 'customer_id', 'customer_id', 0, 'hidden', '', '', '', '', '', '', '', '', '', 'customer_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2439, 'trouble_ticket_customer_add_new', 'title', 'title', 2, 'text', 'Title', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2440, 'trouble_ticket_customer_add_new', 'details', 'details', 4, 'textarea', 'Details', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2441, 'trouble_ticket_customer_add_new', 'priority', 'priority', 6, 'list', 'Priority', '', '', 'select_option', 'upstream_name="trouble_ticket_priority"', 'value', 'description', 'value', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2442, 'trouble_ticket_customer_add_new', 'category', 'category', 8, 'list', 'Category', '', '', 'select_option', 'upstream_name="trouble_ticket_category"', 'description', 'description', 'value', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2443, 'trouble_ticket_customer_add_new', 'assigned_user_id', 'assigned_user_id', 10, 'list', 'Assign to', '', '', '', '', '', '', '', 'assign_user_options', '', '', '', '', '', '51', 'hidden', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2444, 'trouble_ticket_customer_add_new', 'status', 'status', 12, 'list', 'Status', '', '', 'select_option', 'upstream_name="trouble_ticket_status"', 'description', 'description', 'value', '', '1', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2445, 'trouble_ticket_customer_add_new', 'sub', 'sub', 20, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2446, 'phone_number_add_new', 'number', 'number', 2, 'text', 'Number', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2447, 'phone_number_add_new', 'provider_id', 'provider_id', 4, 'list', 'Provider', '', '', 'provider', 'id<>0', 'name', 'name', 'id', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2448, 'phone_number_add_new', 'sub', 'sub', 6, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2449, 'phone_number_multiple_add_new', 'number', 'number', 2, 'textarea', 'Numbers <br/><sub>One number for each line</sub>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2450, 'phone_number_multiple_add_new', 'provider_id', 'provider_id', 4, 'list', 'Provider', '', '', 'provider', 'id<>0', 'name', 'name', 'id', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2451, 'phone_number_multiple_add_new', 'sub', 'sub', 6, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2452, 'npa_nxx_search', 'npa_nxx', 'npa_nxx', 2, 'text', 'NPA NXX <br/><sub>(Eg. 222555)</sub>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2453, 'npa_nxx_search', 'sub', 'sub', 4, 'submit', 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2454, 'npa_nxx_threshold_edit', 'npa', 'npa', 2, 'hidden', 'NPA', '', '', '', '', '', '', '', '', 'npa', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2455, 'npa_nxx_threshold_edit', 'nxx', 'nxx', 4, 'hidden', 'NXX', '', '', '', '', '', '', '', '', 'nxx', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2456, 'npa_nxx_threshold_edit', 'threshold', 'threshold', 6, 'text', 'Threshold', 'size=4', '', '', '', '', '', '', '', 'threshold', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2457, 'npa_nxx_threshold_edit', 'numbers_available', 'numbers_available', 8, 'readonly', 'Available Phone Numbers', '', '', '', '', '', '', '', '', 'numbers_available', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2458, 'npa_nxx_threshold_edit', 'sub', 'sub', 10, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2459, 'npa_nxx_threshold_edit', 'state', 'state', 5, 'readonly', 'State', '', '', '', '', '', '', '', '', 'state', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2460, 'phone_number_assign', 'npa', 'npa', 2, 'text', 'NPA', 'size=4', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2461, 'phone_number_assign', 'nxx', 'nxx', 4, 'text', 'NXX', 'size=4', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2462, 'phone_number_assign', 'state', 'state', 6, 'list', 'State', '', '', '', '', '', '', '', 'state_options', '', '', '', '', '', '', '', 'javascript:enable_disable_npa_nxx(this);', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2463, 'phone_number_assign', 'sub', 'sub', 8, 'submit', 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2464, 'trouble_ticket_add_new', 'customer_id', 'customer_id', 14, 'hidden', '', '', '', '', '', '', '', '', '', 'customer_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2465, 'cdr_search', 'year', 'year', 2, 'list', 'Year', '', '', 'select_option', 'upstream_name="cdr_years"', 'value', 'description', 'value', '', 'actual_year', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2466, 'cdr_search', 'month', 'month', 4, 'list', 'Month', '', '', 'select_option', 'upstream_name="cdr_months"', 'id', 'description', 'value', '', 'actual_month', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2467, 'cdr_search', 'sub', 'sub', 6, 'submit', 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2663, 'route_profile_feature_get-dtmf', 'Dtmf_Timeout', 'Dtmf_Timeout', 2, 'list', 'Timeout (sec.)', '', '', '', '', '', '', '', 'dtmf_timeout', 'Dtmf_Timeout', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2662, 'route_profile_feature_get-dtmf', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2661, 'route_profile_feature_play-tts', 'Field', 'Field', 1, 'text', 'Field', '', '', '', '', '', '', '', '', 'Field', '', '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `field_templates` VALUES(2660, 'route_profile_feature_play-tts', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2658, 'route_profile_feature_play-message', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2659, 'route_profile_feature_play-message', 'Message', 'Message', 1, 'list', 'Message', '', '', '', '', '', '', '', 'message_list', 'Message', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2657, 'route_profile_feature_play-number', 'Field', 'Field', 1, 'text', 'Field', '', '', '', '', '', '', '', '', 'Field', '', '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `field_templates` VALUES(2477, 'extension_edit', 'call_recording', 'call_recording', 33, 'list', 'Call Recording', '', '', 'select_option', 'upstream_name=''yes_no''', 'description', 'description', 'value', '', 'call_recording', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2478, 'call_recording', 'call_recording_beep', 'call_recording_beep', 0, 'list', 'Call Recording Beep', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2479, 'extension_edit', 'call_recording_beep', 'call_recording_beep', 34, 'list', 'Call Recording Beep', '', '', 'select_option', 'upstream_name=''yes_no''', 'description', 'description', 'value', '', 'call_recording_beep', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2481, 'admin_user_new', 'secondary_email', 'secondary_email', 38, 'hidden', 'Alternate E-mail', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2482, 'admin_user_edit', 'secondary_email', 'secondary_email', 48, 'hidden', 'Alternate E-mail', '', '', '', '', '', '', '', '', 'secondary_email', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2483, 'form_edit', 'form_id', 'form_id', 1, 'text', 'Form Id', '', '', '', '', '', '', '', '', 'form_id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2484, 'form_edit', 'form_name', 'form_name', 2, 'text', 'Form Name', '', '', '', '', '', '', '', '', 'form_name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2485, 'form_edit', 'form_action', 'form_action', 3, 'text', 'Form Action', 'size=''80''', '', '', '', '', '', '', '', 'form_action', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2486, 'form_edit', 'form_method', 'form_method', 4, 'text', 'Form Method', 'text', '', '', '', '', '', '', '', 'form_method', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2487, 'form_edit', 'form_class', 'form_class', 5, 'text', 'Form Class', '', '', '', '', '', '', '', '', 'form_class', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2488, 'form_edit', 'form_title', 'form_title', 6, 'text', 'Title', '', '', '', '', '', '', '', '', 'form_title', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2489, 'form_edit', 'form_onsubmit', 'form_onsubmit', 7, 'text', 'On Submit', '', '', '', '', '', '', '', '', 'form_onsubmit', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2490, 'form_edit', 'form_tips', 'form_tips', 8, 'text', 'Tips', '', '', '', '', '', '', '', '', 'form_tips', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2491, 'form_edit', 'form_legend', 'form_legend', 9, 'text', 'Legend', '', '', '', '', '', '', '', '', 'form_legend', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2492, 'form_edit', 'id', 'id', 0, 'readonly', 'Id', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2493, 'form_edit', '', '', 10, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2494, 'form_new', 'form_id', 'form_id', 0, 'text', 'Form id', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2495, 'form_new', 'form_name', 'form_name', 1, 'text', 'Form Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2496, 'form_new', 'form_action', 'form_action', 2, 'text', 'Form Action', 'size=''80''', '', '', '', '', '', '', '', 'javascript:proccess_information(''form_name'', ''function_name'', ''module'', '''');', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2497, 'form_new', 'form_method', 'form_method', 3, 'text', 'Form Method', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2498, 'form_new', 'form_class', 'form_class', 4, 'text', 'Form Class', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2499, 'form_new', 'form_title', 'form_title', 5, 'text', 'Title', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2500, 'form_new', 'form_onsubmit', 'form_onsubmit', 6, 'text', 'On Submit', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2501, 'form_new', 'form_tips', 'form_tips', 7, 'text', 'Tips', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2502, 'form_new', 'form_legend', 'form_legend', 8, 'text', 'Legend', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2503, 'form_new', 'submit', 'submit', 9, 'submit', 'Save Form', '', '', '', '', '', '', '', '', 'Save New Form', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2504, 'acl_levels_new', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2505, 'acl_levels_new', 'level', 'level', 1, 'text', 'Level', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2506, 'acl_levels_new', 'description', 'description', 2, 'text', 'Description', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2507, 'acl_levels_edit', 'id', 'id', 0, 'text', '', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2508, 'acl_levels_edit', 'level', 'level', 1, 'text', 'Level', '', '', '', '', '', '', '', '', 'level', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2509, 'acl_levels_edit', 'description', 'description', 2, 'text', 'Description', '', '', '', '', '', '', '', '', 'description', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2510, 'field_templates_new', 'id', 'id', 0, 'hidden', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2511, 'field_templates_new', 'form_reference', 'form_reference', 1, 'list', 'Reference', '', '', 'form_parameters', 'id!=''''', 'form_id', 'form_id', 'form_id', '', 'form_reference', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2512, 'field_templates_new', 'field_id', 'field_id', 2, 'text', 'Field ID', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2513, 'field_templates_new', 'field_name', 'field_name', 3, 'text', 'Field Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2514, 'field_templates_new', 'form_field_order', 'form_field_order', 4, 'hidden', 'Field Order', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2515, 'field_templates_new', 'html_type', 'html_type', 5, 'text', 'Html Type', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2516, 'field_templates_new', 'def_label', 'def_label', 6, 'text', 'Default Label', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2517, 'field_templates_new', 'html_options', 'html_options', 7, 'text', 'Html Options', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2518, 'field_templates_new', 'css_class', 'css_class', 8, 'text', 'Css Class', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2519, 'field_templates_new', 'data_table', 'data_table', 9, 'text', 'Data Table', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2520, 'field_templates_new', 'data_query', 'data_query', 10, 'text', 'Data Query', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2521, 'field_templates_new', 'data_sort', 'data_sort', 11, 'text', 'Data Sort', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2522, 'field_templates_new', 'data_label', 'data_label', 12, 'text', 'Data Label', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2523, 'field_templates_new', 'data_value', 'data_value', 13, 'text', 'Data Value', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2524, 'field_templates_new', 'field_values', 'field_values', 14, 'text', 'Field Values', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2525, 'field_templates_new', 'def_val', 'def_val', 15, 'text', 'Default Value', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2526, 'field_templates_new', 'vertical', 'vertical', 16, 'text', 'Vertical', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2527, 'field_templates_new', 'click', 'click', 17, 'text', 'Click', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2528, 'field_templates_new', 'focus', 'focus', 18, 'text', 'Focus', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2529, 'field_templates_new', 'blur', 'blur', 19, 'text', 'Blur', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2530, 'field_templates_new', 'level', 'level', 20, 'text', 'Level', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2531, 'field_templates_new', 'acl', 'acl', 21, 'text', 'Acl', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2532, 'field_templates_new', 'onchange', 'onchange', 22, 'text', 'OnChange', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2533, 'field_templates_new', 'prefix', 'prefix', 23, 'text', 'Prefix', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2534, 'field_templates_new', 'fieldset_name', 'fieldset_name', 26, 'list', 'Fieldset Name', '', '', 'fieldsets', 'id!=''''', 'name', 'name', 'name', 'default-open', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2535, 'field_templates_new', 'suffix', 'suffix', 24, 'text', 'Suffix', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2536, 'field_templates_new', 'submit', 'submit', 29, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2537, 'field_templates_new', 'tooltip', 'tooltip', 27, 'text', 'Tootip Message', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'selected', '', 0);
INSERT INTO `field_templates` VALUES(2538, 'field_templates_new', 'required', 'required', 28, 'list', 'Required', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', '0', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2539, 'new_main_menu', 'position', 'position', 0, 'hidden', 'Position', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2540, 'new_main_menu', 'element_name', 'element_name', 1, 'text', 'Element Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2541, 'new_main_menu', 'label', 'label', 2, 'text', 'Label', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2542, 'new_main_menu', 'title', 'title', 3, 'text', 'Title', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2543, 'new_main_menu', 'func', 'func', 4, 'text', 'Func', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2544, 'new_main_menu', 'module', 'module', 5, 'list', 'Module', '', '', 'module', 'id!=''''', 'module', 'label', 'module', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2545, 'new_main_menu', 'allow', 'allow', 6, 'list', 'Allow Levels', '', '', 'select_option', 'upstream_name=''menu_conditions''', 'description', 'description', 'value', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2546, 'new_main_menu', 'allow_value', 'allow_value', 7, 'text', 'User Level', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2547, 'new_main_menu', 'status', 'status', 8, 'hidden', 'Status', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2548, 'new_main_menu', 'initial', 'initial', 9, 'hidden', 'Initial', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2549, 'new_main_menu', 'submit', 'submit', 11, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2550, 'edit_main_menu', 'id', 'id', 0, 'hidden', 'ID', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2551, 'edit_main_menu', 'position', 'position', 1, 'readonly', 'Position', '', '', '', '', '', '', '', '', 'position', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2552, 'edit_main_menu', 'element_name', 'element_name', 2, 'text', 'Element Name', '', '', '', '', '', '', '', '', 'element_name', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2553, 'edit_main_menu', 'label', 'label', 3, 'text', 'Label', '', '', '', '', '', '', '', '', 'label', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2554, 'edit_main_menu', 'title', 'title', 4, 'text', 'Title', '', '', '', '', '', '', '', '', 'title', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2555, 'edit_main_menu', 'func', 'func', 5, 'text', 'Function', '', '', '', '', '', '', '', '', 'func', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2556, 'edit_main_menu', 'module', 'module', 6, 'list', 'Module', '', '', 'module', 'id!=''''', 'module', 'label', 'module', '', 'module', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2557, 'edit_main_menu', 'allow', 'allow', 7, 'list', 'Allow Levels', '', '', 'select_option', 'upstream_name=''menu_conditions''', 'description', 'description', 'value', '', 'allow', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2558, 'edit_main_menu', 'allow_value', 'allow_value', 8, 'text', 'User Level', '', '', '', '', '', '', '', '', 'allow_value', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2559, 'edit_main_menu', 'status', 'status', 9, 'hidden', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2560, 'edit_main_menu', 'initial', 'initial', 10, 'hidden', 'Initial', '', '', '', '', '', '', '', '', 'initial', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2561, 'edit_main_menu', 'submit', 'submit', 12, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2562, 'new_sub_menu', 'main_menu_id', 'main_menu_id', 0, 'list', 'Main Menu', '', '', 'main_menu', 'id!=''''', 'position', 'label', 'id', '', 'main_menu_id', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2563, 'new_sub_menu', 'position', 'position', 1, 'hidden', 'Position', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2564, 'new_sub_menu', 'element_name', 'element_name', 2, 'text', 'Element Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2565, 'new_sub_menu', 'label', 'label', 3, 'text', 'Label', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2566, 'new_sub_menu', 'title', 'title', 4, 'text', 'Title', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2567, 'new_sub_menu', 'func', 'func', 5, 'text', 'Function', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2568, 'new_sub_menu', 'module', 'module', 6, 'list', 'Module', '', '', 'module', 'id!=''''', 'module', 'label', 'module', '', 'module', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2569, 'new_sub_menu', 'allow', 'allow', 7, 'list', 'Allow Levels', '', '', 'select_option', 'upstream_name=''menu_conditions''', 'description', 'description', 'value', '', 'all', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2570, 'new_sub_menu', 'allow_value', 'allow_value', 8, 'text', 'Level', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2571, 'new_sub_menu', 'status', 'status', 9, 'hidden', 'Status', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2572, 'new_sub_menu', 'initial', 'initial', 10, 'hidden', 'Initial', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2573, 'new_sub_menu', 'submit', 'submit', 12, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2574, 'edit_sub_menu', 'id', 'id', 0, 'hidden', 'ID', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2575, 'edit_sub_menu', 'main_menu_id', 'main_menu_id', 1, 'list', 'Main Menu ID', '', '', '', '', '', '', '', 'main_menu_list', 'main_menu_id', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2576, 'edit_sub_menu', 'position', 'position', 2, 'hidden', 'Position', '', '', '', '', '', '', '', '', 'position', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2577, 'edit_sub_menu', 'element_name', 'element_name', 3, 'text', 'Element Name', '', '', '', '', '', '', '', '', 'element_name', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2578, 'edit_sub_menu', 'label', 'label', 4, 'text', 'Label', '', '', '', '', '', '', '', '', 'label', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2579, 'edit_sub_menu', 'title', 'title', 5, 'text', 'Title', '', '', '', '', '', '', '', '', 'title', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2580, 'edit_sub_menu', 'func', 'func', 6, 'text', 'Function', '', '', '', '', '', '', '', '', 'func', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2581, 'edit_sub_menu', 'module', 'module', 7, 'list', 'Module', '', '', 'module', 'id!=''''', 'module', 'label', 'module', '', 'module', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2582, 'edit_sub_menu', 'allow', 'allow', 8, 'list', 'Allow Levels', '', '', 'select_option', 'upstream_name=''menu_conditions''', 'description', 'description', 'value', '', 'allow', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2583, 'edit_sub_menu', 'allow_value', 'allow_value', 9, 'text', 'Levels', '', '', '', '', '', '', '', '', 'allow_value', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2584, 'edit_sub_menu', 'status', 'status', 10, 'hidden', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2585, 'edit_sub_menu', 'initial', 'initial', 11, 'hidden', 'Initial', '', '', '', '', '', '', '', '', 'initial', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2586, 'edit_sub_menu', 'submit', 'submit', 13, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2587, 'new_side_menu', 'sub_menu_id', 'sub_menu_id', 0, 'list', 'Sub Menu', '', '', '', '', '', '', '', 'sub_menu_list', 'sub_menu_id', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2588, 'new_side_menu', 'position', 'position', 1, 'hidden', 'Position', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2589, 'new_side_menu', 'element_name', 'element_name', 2, 'text', 'Element Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2590, 'new_side_menu', 'label', 'label', 3, 'text', 'Label', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2591, 'new_side_menu', 'title', 'title', 4, 'text', 'Title', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2592, 'new_side_menu', 'func', 'func', 5, 'text', 'Function', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2593, 'new_side_menu', 'module', 'module', 6, 'list', 'Module', '', '', 'module', 'id!=''''', 'module', 'label', 'module', '', 'module', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2594, 'new_side_menu', 'allow', 'allow', 7, 'list', 'Allow Levels', '', '', 'select_option', 'upstream_name=''menu_conditions''', 'description', 'description', 'value', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2595, 'new_side_menu', 'allow_value', 'allow_value', 8, 'text', 'Level', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2596, 'new_side_menu', 'status', 'status', 9, 'hidden', 'Status', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2597, 'new_side_menu', 'initial', 'initial', 10, 'hidden', 'Initial', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2598, 'new_side_menu', 'submit', 'submit', 12, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2599, 'edit_side_menu', 'id', 'id', 0, 'hidden', 'ID', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2600, 'edit_side_menu', 'sub_menu_id', 'sub_menu_id', 1, 'list', 'Sub Menu', '', '', '', '', '', '', '', 'sub_menu_list', 'sub_menu_id', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2601, 'edit_side_menu', 'position', 'position', 2, 'hidden', 'Position', '', '', '', '', '', '', '', '', 'position', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2602, 'edit_side_menu', 'element_name', 'element_name', 3, 'text', 'Element Name', '', '', '', '', '', '', '', '', 'element_name', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2603, 'edit_side_menu', 'label', 'label', 4, 'text', 'Label', '', '', '', '', '', '', '', '', 'label', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2604, 'edit_side_menu', 'title', 'title', 5, 'text', 'Titlle', '', '', '', '', '', '', '', '', 'title', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2605, 'edit_side_menu', 'func', 'func', 6, 'text', 'Function', '', '', '', '', '', '', '', '', 'func', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2606, 'edit_side_menu', 'module', 'module', 7, 'list', 'Module', '', '', '', '', '', '', '', 'module_list', 'module', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2607, 'edit_side_menu', 'allow', 'allow', 8, 'list', 'Allow Levels', '', '', 'select_option', 'upstream_name=''menu_conditions''', 'description', 'description', 'value', '', 'allow', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2608, 'edit_side_menu', 'allow_value', 'allow_value', 9, 'text', 'Level', '', '', '', '', '', '', '', '', 'allow_value', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2609, 'edit_side_menu', 'status', 'status', 10, 'hidden', 'Status', '', '', '', '', '', '', '', '', 'status', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2610, 'edit_side_menu', 'initial', 'initial', 11, 'hidden', 'Initial', '', '', '', '', '', '', '', '', 'initial', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2611, 'edit_side_menu', 'submit', 'submit', 13, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2612, 'field_templates_edit', 'id', 'id', 0, 'hidden', 'ID', '', '', '', '', '', '', '', '', 'id', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2613, 'field_templates_edit', 'form_reference', 'form_reference', 1, 'list', 'Form Reference', '', '', 'form_parameters', 'id!=''''', 'form_id', 'form_id', 'form_id', '', 'form_reference', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2614, 'field_templates_edit', 'field_id', 'field_id', 2, 'text', 'Field', '', '', '', '', '', '', '', '', 'field_id', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2615, 'field_templates_edit', 'field_name', 'field_name', 3, 'text', 'Field Name', '', '', '', '', '', '', '', '', 'field_name', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2616, 'field_templates_edit', 'form_field_order', 'form_field_order', 4, 'hidden', 'Form Field Order', '', '', '', '', '', '', '', '', 'form_field_order', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2617, 'field_templates_edit', 'html_type', 'html_type', 5, 'text', 'Html Type', '', '', '', '', '', '', '', '', 'html_type', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2618, 'field_templates_edit', 'def_label', 'def_label', 6, 'text', 'Default Label', '', '', '', '', '', '', '', '', 'def_label', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2619, 'field_templates_edit', 'html_options', 'html_options', 7, 'text', 'Html Options', '', '', '', '', '', '', '', '', 'html_options', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2620, 'field_templates_edit', 'css_class', 'css_class', 8, 'text', 'Css Class', '', '', '', '', '', '', '', '', 'css_class', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2621, 'field_templates_edit', 'data_table', 'data_table', 9, 'text', 'Data Table', '', '', '', '', '', '', '', '', 'data_table', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2622, 'field_templates_edit', 'data_query', 'data_query', 10, 'text', 'Data Query', '', '', '', '', '', '', '', '', 'data_query', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2623, 'field_templates_edit', 'data_sort', 'data_sort', 11, 'text', 'Data Sort', '', '', '', '', '', '', '', '', 'data_sort', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2624, 'field_templates_edit', 'data_label', 'data_label', 12, 'text', 'Data Label', '', '', '', '', '', '', '', '', 'data_label', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2625, 'field_templates_edit', 'data_value', 'data_value', 13, 'text', 'Data Value', '', '', '', '', '', '', '', '', 'data_value', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2626, 'field_templates_edit', 'field_values', 'field_values', 14, 'text', 'Field Values', '', '', '', '', '', '', '', '', 'field_values', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2627, 'field_templates_edit', 'def_val', 'def_val', 15, 'text', 'Default Value', '', '', '', '', '', '', '', '', 'def_val', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2628, 'field_templates_edit', 'vertical', 'vertical', 16, 'text', 'Vertical', '', '', '', '', '', '', '', '', 'vertical', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2629, 'field_templates_edit', 'click', 'click', 17, 'text', 'Click', '', '', '', '', '', '', '', '', 'click', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2630, 'field_templates_edit', 'focus', 'focus', 18, 'text', 'Focus', '', '', '', '', '', '', '', '', 'focus', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2631, 'field_templates_edit', 'blur', 'blur', 19, 'text', 'Blur', '', '', '', '', '', '', '', '', 'blur', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2632, 'field_templates_edit', 'level', 'level', 20, 'text', 'Level', '', '', '', '', '', '', '', '', 'level', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2633, 'field_templates_edit', 'acl', 'acl', 21, 'text', 'Acl', '', '', '', '', '', '', '', '', 'acl', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2634, 'field_templates_edit', 'onchange', 'onchange', 22, 'text', 'OnChange', '', '', '', '', '', '', '', '', 'onchange', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2635, 'field_templates_edit', 'prefix', 'prefix', 23, 'text', 'Prefix', '', '', '', '', '', '', '', '', 'prefix', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2636, 'field_templates_edit', 'suffix', 'suffix', 24, 'text', 'Suffix', '', '', '', '', '', '', '', '', 'suffix', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2637, 'field_templates_edit', 'fieldset_name', 'fieldset_name', 26, 'list', 'Fieldset Name', '', '', 'fieldsets', 'id!=''''', 'name', 'name', 'name', '', 'fieldset_name', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2638, 'field_templates_edit', 'submit', 'submit', 29, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'default-open', '', 0);
INSERT INTO `field_templates` VALUES(2639, 'field_templates_edit', 'tootip', 'tooltip', 27, 'text', 'Tootip Message', '', '', '', '', '', '', '', '', 'tooltip', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2640, 'field_templates_edit', 'required', 'required', 28, 'list', 'Required', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', 'required', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2641, 'build_modules', 'username', 'username', 0, 'text', 'Username', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'add-device', '', 1);
INSERT INTO `field_templates` VALUES(2642, 'build_modules', 'pass', 'pass', 1, 'password', 'Password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'add-device', '', 1);
INSERT INTO `field_templates` VALUES(2643, 'build_modules', 'sub', 'sub', 8, 'submit', 'Build Update', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2644, 'build_modules', 'update_type', 'update_type', 3, 'list', 'Update Type', '', '', '', '', '', '', '', 'Module Update=module;Core=core', 'core', '', '', '', '', '', '', '', '', '', 'add-customer', '', 1);
INSERT INTO `field_templates` VALUES(2645, 'build_modules', 'version', 'version', 2, 'readonly', 'Version', '', '', '', '', '', '', '', '', 'version', '', '', '', '', '', '', '', '', '', 'add-device', '', 1);
INSERT INTO `field_templates` VALUES(2646, 'build_modules', 'upload_sql', 'upload_sql', 4, 'list', 'Upload Mysql Updates', '', '', 'select_option', 'upstream_name=''yes_no''', 'description', 'description', 'value', '', '', '', '', '', '', '', '', '', '', '', 'add-customer', '', 1);
INSERT INTO `field_templates` VALUES(2647, 'build_modules', 'require_restart', 'require_restart', 5, 'list', 'Require System Restart', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', '', '', '', '', '', '', '', '', '', '', 'add-customer', '', 1);
INSERT INTO `field_templates` VALUES(2648, 'build_modules', 'message', 'message', 7, 'textarea', 'Message', 'cols=''80'', rows=''6''', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'add-customer', '', 1);
INSERT INTO `field_templates` VALUES(2649, 'build_modules', 'update_asterisk', 'update_asterisk', 6, 'list', 'Update Asterisk Modules', '', '', 'select_option', 'upstream_name=''yes_no''', 'value', 'description', 'value', '', '', '', '', '', '', '', '', '', '', '', 'add-customer', '', 1);
INSERT INTO `field_templates` VALUES(2650, 'admin_user_new', 'dashboard_1', 'dashboard_1', 37, 'hidden', 'dashboard_1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2651, 'admin_user_new', 'dashboard_2', 'dashboard_2', 38, 'hidden', 'dashboard_2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2652, 'admin_user_edit', 'dashboard_1', 'dashboard_1', 38, 'hidden', 'dashboard_1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2653, 'admin_user_edit', 'dashboard_2', 'dashboard_2', 39, 'hidden', 'dashboard_2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2656, 'route_profile_feature_play-number', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2696, 'route_profile_feature_transfer', 'SendDTMF', 'SendDTMF', 3, 'text', 'Send DTMF', '', '', '', '', '', '', '', '', 'SendDTMF', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2697, 'route_profile_feature_transfer', 'OnBusy', 'OnBusy', 4, 'text', 'On Busy', '', '', '', '', '', '', '', '', 'OnBusy', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2698, 'route_profile_feature_transfer', 'OnUnavailable', 'OnUnavailable', 5, 'text', 'On Unavailable', '', '', '', '', '', '', '', '', 'OnUnavailable', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2699, 'route_profile_feature_transfer', 'OnNoAnswer', 'OnNoAnswer', 6, 'text', 'On No Answer', '', '', '', '', '', '', '', '', 'OnNoAnswer', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2700, 'route_profile_feature_acd-group', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2701, 'route_profile_feature_acd-group', 'Group', 'Group', 1, 'list', 'ACD Group', '', '', 'acd_group', 'id<>0', 'name', 'name', 'id', '', 'Group', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2702, 'route_profile_feature_acd-group', 'Timeout', 'Timeout', 2, 'list', 'Timeout (Sec.)', '', '', 'select_option', 'upstream_name=''timeout''', 'id', 'description', 'value', '', 'Timeout', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2703, 'route_profile_feature_acd-group', 'OnTimeout', 'OnTimeout', 3, 'text', 'On Timeout', 'size=5 maxlength=2', '', '', '', '', '', '', '', 'OnTimeout', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2704, 'route_profile_feature_hangup', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2705, 'route_profile_feature_plugin', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2706, 'route_profile_feature_plugin', 'Name', 'Name', 1, 'list', 'Plugin Name', '', '', 'plugin', 'id<>0', 'name', 'name', 'name', '', 'Name', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2707, 'route_profile_feature_plugin', 'ContinueTo', 'ContinueTo', 2, 'text', 'Continue To', 'size=5 maxlength=2', '', '', '', '', '', '', '', 'ContinueTo', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2708, 'route_profile_feature_pause-campaign', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2709, 'route_profile_feature_pause-campaign', 'ContinueTo', 'ContinueTo', 1, 'text', 'Continue To', 'size=5 maxlength=2', '', '', '', '', '', '', '', 'ContinueTo', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2710, 'route_profile_feature_fax2email', 'Email', 'Email', 1, 'text', 'Email', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'email_suffix', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2711, 'route_profile_feature_fax2email', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2712, 'route_profile_feature_ring-group', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2713, 'route_profile_feature_ring-group', 'RingGroup', 'RingGroup', 1, 'list', 'Extension', '', '', '', '', '', '', '', 'ring_group_list', 'RingGroup', '', '', '', '', '', '', '', '', 'ring_group_suffix', '', '', 0);
INSERT INTO `field_templates` VALUES(2714, 'route_profile_feature_ring-group', 'OnBusy', 'OnBusy', 4, 'text', 'On Busy', '', '', '', '', '', '', '', '', 'OnBusy', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2715, 'route_profile_feature_ring-group', 'OnUnavailable', 'OnUnavailable', 5, 'text', 'On Unavailable', '', '', '', '', '', '', '', '', 'OnUnavailable', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2716, 'route_profile_feature_ring-group', 'OnNoAnswer', 'OnNoAnswer', 6, 'text', 'On No Answer', '', '', '', '', '', '', '', '', 'OnNoAnswer', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2717, 'route_profile_feature_voicemail', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2718, 'route_profile_feature_voicemail', 'Mailbox', 'Mailbox', 1, 'list', 'Mailbox', '', '', '', '', '', '', '', 'mailbox_list', 'Mailbox', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2719, 'route_profile_feature_voicemail', 'Type', 'Type', 2, 'list', 'Type', '', '', 'select_option', 'upstream_name=''mailbox_routing_type''', 'id', 'description', 'value', '', 'Type', '', '', '', '', '', '', '', '', '', 'add-customer', '', 0);
INSERT INTO `field_templates` VALUES(2720, 'route_profile_feature_dial-exten', 'OnUnavailable', 'OnUnavailable', 6, 'text', 'OnUnavailable', 'maxlength =2', '', '', '', '', '', '', '', 'OnUnavailable', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2721, 'route_profile_feature_dial-exten', 'OnBusy', 'OnBusy', 5, 'text', 'OnBusy', 'maxlength =2', '', '', '', '', '', '', '', 'OnBusy', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2722, 'route_profile_feature_dial-exten', 'OnNoAnswer', 'OnNoAnswer', 4, 'text', 'OnNoAnswer', 'maxlength =2', '', '', '', '', '', '', '', 'OnNoAnswer', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2723, 'route_profile_feature_dial-exten', 'RingTimeout', 'RingTimeout', 3, 'list', 'Timeout', '', '', 'select_option', 'upstream_name=''timeout_no_unlimited''', 'id', 'value', 'value', '', 'RingTimeout', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2724, 'route_profile_feature_dial-exten', 'Override', 'Override', 2, 'list', 'Override', '', '', 'select_option', 'upstream_name=''yes_no''', 'description', 'description', 'value', '', 'Override', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2725, 'route_profile_feature_dial-exten', 'Exten', 'Exten', 1, 'list', 'Extension', '', '', '', '', '', '', '', 'extension_list', 'Exten', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2726, 'route_profile_feature_dial-exten', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2727, 'route_profile_feature_conference-bridge', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2728, 'route_profile_feature_conference-bridge', 'Room', 'Room', 2, 'list', 'Room', '', '', '', '', '', '', '', 'room_list', 'Room', '', '', '', '', '', '', '', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2729, 'route_profile_feature_conference-bridge', 'AskForRoom', 'AskForRoom', 1, 'list', 'Request Room Number', '', 'bridge_conference_ask', 'select_option', 'upstream_name=''yes_no''', 'description', 'description', 'value', '', 'AskForRoom', '', '', '', '', '', '', 'javascript:conference_bridge_switch(this);', '', '', 'default', '', 0);
INSERT INTO `field_templates` VALUES(2730, 'route_profile_feature_say-number', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2731, 'route_profile_feature_say-number', 'Value', 'Value', 1, 'text', 'Value', '', '', '', '', '', '', '', '', 'Value', '', '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `field_templates` VALUES(2732, 'route_profile_feature_say-tts', 'Feature', 'Feature', 0, 'text', '', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2733, 'route_profile_feature_say-tts', 'Value', 'Value', 1, 'text', 'Value', '', '', '', '', '', '', '', '', 'Value', '', '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `field_templates` VALUES(2734, 'route_profile_feature_say-number', 'OnFinishPlay', 'OnFinishPlay', 2, 'text', 'On Finish Play', 'size=5 maxlength=2', '', '', '', '', '', '', '', 'OnFinishPlay', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2735, 'route_profile_feature_say-tts', 'OnFinishPlay', 'OnFinishPlay', 2, 'text', 'On Finish Play', 'size=5 maxlength=2', '', '', '', '', '', '', '', 'OnFinishPlay', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2736, 'route_profile_feature_do-not-call', 'Feature', 'Feature', 0, 'text', 'Feature', '', 'feature_field_hidden', '', '', '', '', '', '', 'Feature', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2737, 'route_profile_feature_do-not-call', 'OnDoneProcessing', 'OnDoneProcessing', 1, 'text', 'On Done Processing', 'size=5 maxlength=2', '', '', '', '', '', '', '', 'OnDoneProcessing', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2738, 'audio_prompt_upload', 'sub', 'sub', 3, 'submit', 'Save', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'upload_file', '', 0);
INSERT INTO `field_templates` VALUES(2739, 'audio_prompt_upload', 'Upload', 'Upload', 2, 'fileuploader', 'File', '', '', '', '', '', '', '', 'wav|WAV|mp3|MP3', '', '', '', '', '', '', '', '', '', '', 'upload_file', '', 0);
INSERT INTO `field_templates` VALUES(2740, 'audio_prompt_upload', 'description', 'description', 1, 'text', 'Description', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'upload-file', '', 1);
INSERT INTO `field_templates` VALUES(2741, 'audio_prompt_upload', 'label', 'label', 0, 'text', 'Label', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'upload-file', '', 1);
INSERT INTO `field_templates` VALUES(2742, 'route_profile_feature_ring-group', 'Rule', 'Rule', 2, 'list', 'Ring', '', '', '', '', '', '', '', 'Sequential=sequential;All=all', 'all', '', '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `field_templates` VALUES(2743, 'route_profile_feature_ring-group', 'RingTimeout', 'RingTimeout', 3, 'list', 'Ring Timeout', '', '', 'select_option', 'upstream_name=''timeout_no_unlimited''', 'id', 'description', 'value', '', 'RingTimeout', '', '', '', '', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `form_parameters`
--

DROP TABLE IF EXISTS `form_parameters`;
CREATE TABLE IF NOT EXISTS `form_parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` varchar(50) NOT NULL,
  `form_name` varchar(50) NOT NULL,
  `form_action` varchar(255) NOT NULL,
  `form_method` varchar(50) NOT NULL,
  `form_class` varchar(255) NOT NULL,
  `form_title` varchar(255) NOT NULL,
  `form_onsubmit` varchar(255) NOT NULL,
  `form_tips` varchar(255) NOT NULL,
  `form_legend` varchar(255) NOT NULL,
  `module` varchar(60) NOT NULL,
  `system` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1989 ;

--
-- Dumping data for table `form_parameters`
--

INSERT INTO `form_parameters` VALUES(1959, 'new_main_menu', 'new_main_menu', 'javascript:proccess_information(''new_main_menu'', ''save_main_menu'', ''menu_nav'', '''');', '', 'NewMain_menuForm', 'Add New Main Menu Item', '', '', '', 'dial_plan', 1);
INSERT INTO `form_parameters` VALUES(1958, 'field_templates_new', 'field_templates_new', 'javascript:proccess_information(''field_templates_new'', ''add_field'', ''natural'', '''');', 'POST', '', '', '', '', '', 'dial_plan', 1);
INSERT INTO `form_parameters` VALUES(1957, 'acl_levels_edit', 'acl_levels_edit', 'javascript:proccess_information(''acl_levels_edit'', ''save_acl_levels'', ''acl_levels'', '''');', 'POST', '', '', '', '', '', 'dial_plan', 1);
INSERT INTO `form_parameters` VALUES(1001, 'user_new', 'user_new', 'javascript:proccess_information(''user_new'', ''save_new_user'', ''user'', ''Are you sure you want to create this new user?'');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1101, 'user_view', 'user_view', 'javascript:proccess_information(''user_view'', '''', ''user'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1201, 'user_edit', 'user_edit', 'javascript:proccess_information(''user_edit'', ''save_edit_user'', ''user'', '''', '''', ''panel-msg'', ''panel-wrapper'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1501, 'customer_new', 'customer_new', 'javascript:proccess_information(''customer_new'', ''save_new_customer'', ''customer'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1502, 'customer_edit', 'customer_edit', 'javascript:proccess_information(''customer_edit'', ''save_customer'', ''customer'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1503, 'customer_view', 'customer_view', 'javascript:proccess_information(''customer_view'', '''', ''customer'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1504, 'partner_new', 'partner_new', 'javascript:proccess_information(''partner_new'', ''save_new_partner'', ''partner'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1505, 'partner_edit', 'partner_edit', 'javascript:proccess_information(''partner_edit'', ''save_partner'', ''partner'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1506, 'partner_view', 'partner_view', 'javascript:proccess_information(''partner_view'', '''', ''partner'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1507, 'location_new', 'location_new', 'javascript:proccess_information(''location_new'', ''save_new_location'', ''location'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1508, 'location_edit', 'location_edit', 'javascript:proccess_information(''location_edit'', ''save_location'', ''location'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1509, 'location_view', 'location_view', 'javascript:proccess_information(''location_view'', '''', ''location'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1956, 'acl_levels_new', 'acl_levels_new', 'javascript:proccess_information(''acl_levels_new'', ''save_new_acl_levels'', ''acl_levels'', '''');', 'POST', '', '', '', '', '', 'dial_plan', 1);
INSERT INTO `form_parameters` VALUES(1955, 'form_new', 'form_new', 'javascript:proccess_information(''form_new'', ''save_new_form'', ''natural'', '''');', 'POST', '', '', '', '', 'Add new form', '', 1);
INSERT INTO `form_parameters` VALUES(1954, 'form_edit', 'form_edit', 'javascript:proccess_information(''form_edit'', ''save_form_param'', ''natural'', '''');', 'POST', '', '', '', '', 'Edit Form Parameters', '', 1);
INSERT INTO `form_parameters` VALUES(1513, 'admin_partner_new', 'admin_partner_new', 'javascript:proccess_information(''partner_new2'', ''save_new_partner'', ''partner'', ''Are you shure you want to create this new partner?'');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1514, 'contact_new', 'contact_new', 'javascript:proccess_information(''contact_new'', ''save_new_contact'', ''contact'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1515, 'contact_edit', 'contact_edit', 'javascript:proccess_information(''contact_edit'', ''save_contact'', ''contact'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1516, 'contact_view', 'contact_view', 'javascript:proccess_information(''contact_view'', '''', ''contact'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1517, 'change_user_pass', 'change_user_pass', 'javascript:proccess_information(''change_user_pass'', ''change_my_password'', ''user'', ''Are you sure you want to change your password?'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1518, 'customer_user_new', 'customer_user_new', 'javascript:proccess_information(''customer_user_new'', ''save_new_user'', ''user'', ''Are you sure you want to create this user?'');', 'POST', '', 'Add New User', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1519, 'extension_new', 'extension_new', 'javascript:proccess_information(''extension_new'', ''save_new_extension'', ''extension'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1520, 'extension_edit', 'extension_edit', 'javascript:proccess_information(''extension_edit'', ''save_extension'', ''extension'',  '''', '''', ''panel-msg'', ''panel-wrapper'');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1521, 'extension_view', 'extension_view', 'javascript:proccess_information(''extension_view'', '''', ''extension'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1522, 'device_new', 'device_new', 'javascript:proccess_information(''device_new'', ''save_new_device'', ''device'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1523, 'device_edit', 'device_edit', 'javascript:proccess_information(''device_edit'', ''save_device'', ''device'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1524, 'device_view', 'device_view', 'javascript:proccess_information(''device_view'', '''', ''device'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1525, 'directory_new', 'directory_new', 'javascript:proccess_information(''directory_new'', ''save_new_directory'', ''directory'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1526, 'directory_edit', 'directory_edit', 'javascript:proccess_information(''directory_edit'', ''save_directory'', ''directory'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1527, 'directory_view', 'directory_view', 'javascript:proccess_information(''directory_view'', '''', ''directory'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1528, 'mailbox_new', 'mailbox_new', 'javascript:proccess_information(''mailbox_new'', ''save_new_mailbox'', ''mailbox'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1529, 'mailbox_edit', 'mailbox_edit', 'javascript:proccess_information(''mailbox_edit'', ''edit_mailbox'', ''mailbox'',  '''', '''', ''panel-msg'', ''panel-wrapper'');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1530, 'mailbox_view', 'mailbox_view', 'javascript:proccess_information(''mailbox_view'', '''', ''mailbox'', '''');', 'POST', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1531, 'admin_user_new', 'admin_user_new', 'javascript:proccess_information(''admin_user_new'', ''save_new_admin_user'', ''user'', ''Are you sure you want to create this admin user?'');', 'POST', 'jqtransform', 'New Admin User', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1801, 'admin_user_edit', 'admin_user_edit', 'javascript:proccess_information(''admin_user_edit'', ''save_edit_admin_user'', ''user'', '''');', 'POST', '', 'Edit Admin User', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1850, 'admin_device_new', 'admin_device_new', 'javascript:proccess_information(''admin_device_new'', ''save_new_device'', ''device'', '''');', 'POST', '', '', '', '', 'Device Information', '', 0);
INSERT INTO `form_parameters` VALUES(1901, 'admin_device_edit', 'admin_device_edit', 'javascript:proccess_information(''admin_device_edit'', ''admin_save_device'', ''device'', '''');', 'POST', '', '', '', '', 'Device Information', '', 0);
INSERT INTO `form_parameters` VALUES(1975, 'route_profile_feature_time-condition', 'route_profile_feature_time-condition', '', '', '', '', '', '', '', 'route_profile', 0);
INSERT INTO `form_parameters` VALUES(1974, 'route_profile_feature_date-condition', 'route_profile_feature_date-condition', '', '', '', '', '', '', '', 'route_profile', 0);
INSERT INTO `form_parameters` VALUES(1973, 'route_profile_info', 'route_profile_info', '', '', '', '', '', '', '', 'route_profile', 0);
INSERT INTO `form_parameters` VALUES(1972, 'route_profile_feature_get-dtmf', 'route_profile_feature_get-dtmf', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1971, 'route_profile_feature_play-tts', 'route_profile_feature_play-tts', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1908, 'list_devices', 'list_devices', 'javascript:proccess_information(''list_devices'',''list_devices'',''provisioning'','''');', '', '', '', '', '', 'Select Devices', '', 0);
INSERT INTO `form_parameters` VALUES(1970, 'route_profile_feature_play-message', 'route_profile_feature_play-message', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1911, 'state_selection', 'state_selection', 'javascript:proccess_information(''state_selection'',''show_area_codes'',''phone_number'','''','''','''',''area_code_response'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1912, 'area_selection', 'area_selection', 'javascript:proccess_information(''area_selection'',''find_phone_numbers'',''phone_number'','''','''','''',''show_numbers'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1913, 'phone_number_list', 'phone_number_list', 'javascript:proccess_information(''phone_number_list'', ''assign_phone_number'', ''phone_number'', ''Are you sure you want to add this Phone Number to Stock?'','''','''',''ph_assign'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1914, 'add_porting_number', 'add_porting_number', 'javascript:proccess_information(''add_porting_number'', ''confirm_account'', ''phone_number'', '''','''',''main-error-message'',''show_account_confirmation'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1916, 'call_recording_menu', 'call_recording_menu', 'javascript:proccess_information(''call_recording_menu'', ''list_call_recording'', ''media'', '''','''','''',''show_list_recording'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1917, 'customer_account_form_billing_address', 'customer_account_form_billing_address', '', '', 'customer_account_form', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1918, 'customer_account_form_shipping_address', 'customer_account_form_shipping_address', '', '', 'customer_account_form', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1919, 'customer_account_form_e-911_address', 'customer_account_form_e-911_address', '', '', 'customer_account_form', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1920, 'customer_account_form_extension', 'customer_account_form_extension', '', '', 'customer_account_form', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1921, 'customer_account_form_extension_feature', 'customer_account_form_extension_feature', '', '', 'customer_account_form', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1922, 'customer_account_form_conference', 'customer_account_form_conference', '', '', 'customer_account_form', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1924, 'user_edit_device_form_GXP2000', 'user_edit_device_form_GXP2000', 'javascript:proccess_information(''user_edit_device_form_GXP2000'', ''user_edit_device'', ''device'',  '''', '''', ''panel-msg'', ''panel-wrapper'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1925, 'user_edit_device_form_GXP2020', 'user_edit_device_form_GXP2020', 'javascript:proccess_information(''user_edit_device_form_GXP2020'', ''user_edit_device'', ''device'',  '''', '''', ''panel-msg'', ''panel-wrapper'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1926, 'user_edit_device_form_GXV3140', 'user_edit_device_form_GXV3140', 'javascript:proccess_information(''user_edit_device_form_GXV3140'', ''user_edit_device'', ''device'',  '''', '''', ''panel-msg'', ''panel-wrapper'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1927, 'user_edit_device_form_BT200', 'user_edit_device_form_BT200', 'javascript:proccess_information(''user_edit_device_form_BT200'', ''user_edit_device'', ''device'',  '''', '''', ''panel-msg'', ''panel-wrapper'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1928, 'user_edit_device_form_HT502', 'user_edit_device_form_HT502', 'javascript:proccess_information(''user_edit_device_form_HT502'', ''user_edit_device'', ''device'',  '''', '''', ''panel-msg'', ''panel-wrapper'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1929, 'user_edit_device_form_HT486', 'user_edit_device_form_HT486', 'javascript:proccess_information(''user_edit_device_form_HT486'', ''user_edit_device'', ''device'',  '''', '''', ''panel-msg'', ''panel-wrapper'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1930, 'conference_plus_setup', 'conference_plus_setup', 'javascript:proccess_information(''conference_plus_setup'', ''process_new_conference'', ''conference_plus'',  ''Are you sure you want to schedule this conference?'');', '', '', '', '', '', 'Schedule new conference call', '', 0);
INSERT INTO `form_parameters` VALUES(1931, 'customer_create_payment_profile_form', 'customer_create_payment_profile_form', 'javascript:proccess_information(''customer_create_payment_profile_form'', ''customer_create_payment_profile'', ''payment_profile'', '''');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1932, 'user_edit_remote_access_form', 'user_edit_remote_access_form', 'javascript:proccess_information(''user_edit_remote_access_form'', ''user_edit_remote_access'', ''remote_access'',  '''', '''', ''panel-msg'', ''panel-wrapper'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1933, 'customer_pay_now_form', 'customer_pay_now_form', 'javascript:proccess_information(''customer_pay_now_form'', ''customer_pay_now_confirmation_form'', ''payment_profile'',  '''', '''');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1934, 'customer_pay_now_confirmation_form', 'customer_pay_now_confirmation_form', 'javascript:proccess_information(''customer_pay_now_confirmation_form'', ''customer_pay_now'', ''payment_profile'',  '''', '''');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1935, 'customer_current_limit_form', 'customer_current_limit_form', 'javascript:proccess_information(''customer_current_limit_form'', ''customer_current_limit'', ''payment_profile'',  '''', '''');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1936, 'customer_create_transaction_form', 'customer_create_transaction_form', 'javascript:proccess_information(''customer_create_transaction_form'', ''customer_create_transaction'', ''transaction'',  '''', '''');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1937, 'cdr_list_menu', 'cdr_list_menu', 'javascript:proccess_information(''cdr_list_menu'', ''get_call_data_records'', ''cdr'', '''','''','''',''show_cdr_data'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1938, 'quick_list_menu', 'quick_list_menu', 'javascript:proccess_information(''quick_list_menu'', ''reactivate_quick_list'', ''provisioning'', '''', '''', '''', ''ql_list'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1939, 'directory_create_form', 'directory_create_form', 'javascript:proccess_information(''directory_create_form'', ''directory_save'', ''directory'', '''');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1940, 'directory_edit_form', 'directory_edit_form', 'javascript:proccess_information(''directory_edit_form'', ''directory_edit'', ''directory'',  '''', '''', ''panel-msg'', ''panel-wrapper'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1941, 'show_conference', 'show_conference', 'javascript:proccess_information(''show_conference'', ''show_conference_edit'', ''conference_plus'', '''');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1942, 'conference_add_participants', 'conference_add_participants', 'javascript:proccess_information(''conference_add_participants'', ''conference_add_participants'',  ''conference_plus'',  null, null, ''conference_resp'', ''Conference-Room'' );', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1943, 'trouble_ticket_add_new', 'trouble_ticket_add_new', 'javascript:proccess_information(''trouble_ticket_add_new'', ''trouble_ticket_add_new'', ''trouble_ticket'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1944, 'trouble_ticket_edit', 'trouble_ticket_edit', 'javascript:proccess_information(''trouble_ticket_edit'', ''trouble_ticket_edit'', ''trouble_ticket'',  null, null, ''panel-msg'', ''panel-wrapper'', ''update_row'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1945, 'trouble_ticket_comment_add_new', 'trouble_ticket_comment_add_new', 'javascript:proccess_information(''trouble_ticket_comment_add_new'', ''trouble_ticket_comment_add_new'', ''trouble_ticket'', '''', '''', ''panel-msg'', ''trouble-ticket-comment-wrapper'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1946, 'trouble_ticket_customer_add_new', 'trouble_ticket_customer_add_new', 'javascript:proccess_information(''trouble_ticket_customer_add_new'', ''trouble_ticket_add_new'', ''trouble_ticket'',  null, null, ''panel-msg'', ''panel-wrapper'', ''update_row'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1947, 'phone_number_add_new', 'phone_number_add_new', 'javascript:proccess_information(''phone_number_add_new'', ''phone_number_add_new'', ''phone_number'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1948, 'phone_number_multiple_add_new', 'phone_number_multiple_add_new', 'javascript:proccess_information(''phone_number_multiple_add_new'', ''phone_number_add_new'', ''phone_number'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1949, 'npa_nxx_search', 'npa_nxx_search', 'javascript:proccess_information(''npa_nxx_search'', ''npa_nxx_search'', ''phone_number'', null, null, null, ''npa_nxx_threshold_edit_form'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1950, 'npa_nxx_threshold_edit', 'npa_nxx_threshold_edit', 'javascript:proccess_information(''npa_nxx_threshold_edit'', ''npa_nxx_threshold_edit'', ''phone_number'', null, null, ''panel-msg'', ''panel-wrapper'', ''update_row'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1951, 'phone_number_assign', 'phone_number_assign', 'javascript:proccess_information(''phone_number_assign'', ''phone_number_assign'', ''phone_number'', '''', '''', '''', ''phone-number-available-list'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1952, 'cdr_search', 'cdr_search', 'javascript:proccess_information(''cdr_search'', ''cdr_search'', ''cdr'', null, null, null, ''cdr_search_list'');', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1969, 'route_profile_feature_play-number', 'route_profile_feature_play-number', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1960, 'edit_main_menu', 'edit_main_menu', 'javascript:proccess_information(''edit_main_menu'', ''save_main_menu_config'', ''menu_nav'', ''Are you sure you want to save this configuration?'');', '', '', 'Edit Main Menu Item', '', '', '', 'dial_plan', 1);
INSERT INTO `form_parameters` VALUES(1961, 'new_sub_menu', 'new_sub_menu', 'javascript:proccess_information(''new_sub_menu'', ''save_new_submenu'', ''menu_nav'', ''Are you sure you want to save this Sub Menu?'');', '', '', 'Add New Sub Menu Item', '', '', '', 'dial_plan', 1);
INSERT INTO `form_parameters` VALUES(1962, 'edit_sub_menu', 'edit_sub_menu', 'javascript:proccess_information(''edit_sub_menu'', ''save_sub_menu_config'', ''menu_nav'', ''Are you sure you want to save this configuration?'');', '', '', 'Edit Sub Menu Item', '', '', '', 'dial_plan', 1);
INSERT INTO `form_parameters` VALUES(1963, 'new_side_menu', 'new_side_menu', 'javascript:proccess_information(''new_side_menu'', ''save_new_sidemenu'', ''menu_nav'', ''Are you sure you want to save this Side Menu?'');', '', '', 'Side Menu Information', '', '', '', 'dial_plan', 1);
INSERT INTO `form_parameters` VALUES(1964, 'edit_side_menu', 'edit_side_menu', 'javascript:proccess_information(''edit_side_menu'', ''save_side_menu_config'', ''menu_nav'', ''Are you sure you want to save this configuration?'');', '', '', 'Side Meun Information', '', '', '', 'dial_plan', 1);
INSERT INTO `form_parameters` VALUES(1965, 'field_templates_edit', 'field_templates_edit', 'javascript:proccess_information(''field_templates_edit'', ''save_form_fields'', ''natural'', '''');', 'POST', '', '', '', '', '', 'dial_plan', 1);
INSERT INTO `form_parameters` VALUES(1966, 'build_modules', 'build_modules', 'javascript:proccess_information(''build_modules'', ''update_module'', ''natural'', ''Are You sure you want to build the Hive Core Update?'');', '', '', 'HIVE Core Module Updates', '', '', 'Select the Update Type and hit Build Core Update', 'natural', 1);
INSERT INTO `form_parameters` VALUES(1968, 'route_profile_feature_transfer', 'route_profile_feature_transfer', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1976, 'route_profile_feature_acd-group', 'route_profile_feature_acd-group', '', '', '', '', '', '', '', 'route_profile', 0);
INSERT INTO `form_parameters` VALUES(1977, 'route_profile_feature_hangup', 'route_profile_feature_hangup', '', '', '', '', '', '', '', 'route_profile', 0);
INSERT INTO `form_parameters` VALUES(1978, 'route_profile_feature_plugin', 'route_profile_feature_plugin', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1979, 'route_profile_feature_pause-campaign', 'route_profile_feature_pause-campaign', '', '', '', '', '', '', '', 'route_profile', 0);
INSERT INTO `form_parameters` VALUES(1980, 'route_profile_feature_fax2email', 'route_profile_feature_fax2email', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1981, 'route_profile_feature_ring-group', 'route_profile_feature_ring-group', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1982, 'route_profile_feature_conference-bridge', 'route_profile_feature_conference-bridge', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1983, 'route_profile_feature_voicemail', 'route_profile_feature_voicemail', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1984, 'route_profile_feature_dial-exten', 'route_profile_feature_dial-exten', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1985, 'route_profile_feature_say-number', 'route_profile_feature_say-number', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1986, 'route_profile_feature_say-tts', 'route_profile_feature_say-tts', '', '', '', '', '', '', '', '', 0);
INSERT INTO `form_parameters` VALUES(1987, 'route_profile_feature_do-not-call', 'route_profile_feature_do-not-call', '', '', '', '', '', '', '', 'route_profile', 1);
INSERT INTO `form_parameters` VALUES(1988, 'audio_prompt_upload', 'audio_prompt_upload', 'javascript:proccess_information(''audio_prompt_upload'', ''audio_prompt_upload'', ''media'');', '', '', 'Upload Audio Prompt', '', 'The audio format must be wav Uncompressed 16bit 8Khz', '', 'audio_manager', 0);

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original` text NOT NULL,
  `translate` text NOT NULL,
  `lang` varchar(5) NOT NULL DEFAULT 'pt',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `language`
--


-- --------------------------------------------------------

--
-- Table structure for table `main_menu`
--

DROP TABLE IF EXISTS `main_menu`;
CREATE TABLE IF NOT EXISTS `main_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` tinyint(20) NOT NULL,
  `element_name` varchar(50) NOT NULL,
  `label` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `func` varchar(50) NOT NULL,
  `module` varchar(20) NOT NULL,
  `allow` varchar(20) DEFAULT 'all',
  `allow_value` varchar(20) NOT NULL DEFAULT '0',
  `status` tinyint(20) NOT NULL DEFAULT '1',
  `initial` tinyint(22) NOT NULL DEFAULT '0',
  `dash_admin` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `main_menu`
--

INSERT INTO `main_menu` VALUES(1, 0, 'dashboard_main', 'Dashboard', 'Main Dashboard', 'dashboard_home', 'dashboard', 'all', '0', 1, 1, 1);
INSERT INTO `main_menu` VALUES(16, 5, 'admin_main', 'Admin Users', 'Admin Users', 'admin_list_users', 'user', 'all', '0', 1, 0, 1);
INSERT INTO `main_menu` VALUES(3, 2, 'system_main', 'System', 'System Management', 'show_configuration_overview', 'system', 'all', '0', 0, 0, 1);
INSERT INTO `main_menu` VALUES(19, 4, 'customer_service_main', 'Customer Service', 'Customer Service Management', 'customer_list', 'customer', 'all', '0', 1, 0, 1);
INSERT INTO `main_menu` VALUES(18, 9, 'packages_main', 'Packages', 'Packages', '', 'package', 'higher', '81', 0, 0, 0);
INSERT INTO `main_menu` VALUES(20, 1, 'c_dashboard_main', 'My Account', 'My Account', 'view_customer_info', 'customer', 'all', '0', 1, 1, 0);
INSERT INTO `main_menu` VALUES(22, 3, 'c_phonenumber_main', 'Phone Numbers', 'Phone Numbers', 'list_phone_numbers', 'phone_number', 'higher', '40', 0, 0, 0);
INSERT INTO `main_menu` VALUES(24, 17, 'c_support_main', 'Support', 'Customer Support', '', '', 'higher', '39', 0, 0, 0);
INSERT INTO `main_menu` VALUES(25, 10, 'c_media_main', 'Media', 'Customer Media Manegent', 'media_fax_list', 'media', 'higher', '40', 0, 0, 0);
INSERT INTO `main_menu` VALUES(26, 11, 'device_customer_main', 'Devices', 'Manage My Account Devices', 'list_customer_devices', 'device', 'higher', '60', 0, 0, 0);
INSERT INTO `main_menu` VALUES(27, 12, 'c_extension_main', 'Lines', 'Lines', 'customer_list_extension', 'extension', 'higher', '40', 0, 0, 0);
INSERT INTO `main_menu` VALUES(28, 14, 'c_package_main', 'Packages', 'Packages', 'list_customer_packages', 'package', 'all', '', 0, 0, 0);
INSERT INTO `main_menu` VALUES(29, 13, 'mailbox_main', 'Mailboxes', 'Mailboxes', 'customer_list_mailbox', 'mailbox', 'higher', '40', 0, 0, 0);
INSERT INTO `main_menu` VALUES(30, 2, 'c_features_main', 'Features', 'Features', 'view_3way_calling_description', 'features', 'higher', '40', 0, 0, 0);
INSERT INTO `main_menu` VALUES(31, 16, 'cdr_search_form_main', 'Call History', 'Call History', 'cdr_search_form', 'cdr', 'higher', '40', 0, 0, 0);
INSERT INTO `main_menu` VALUES(33, 6, 'how_to_main', 'How To', 'How To', 'view_help', 'help', 'higher', '40', 0, 0, 0);
INSERT INTO `main_menu` VALUES(34, 19, 'contact_us_info_main', 'Contact Us', 'Big Earth Contact Information', 'show_ben_contact_info', 'contact', 'all', '0', 0, 0, 0);
INSERT INTO `main_menu` VALUES(35, 4, 'trunk_main_account', 'Trunks', 'Trunks', 'trunk_list', 'acl', 'all', '0', 0, 0, 0);
INSERT INTO `main_menu` VALUES(36, 2, 'pbx_main_account', 'Appliances', 'Appliances', 'instance_list', 'acl', 'all', '0', 0, 0, 0);
INSERT INTO `main_menu` VALUES(37, 22, 'store_main_account', 'Store', 'Store', 'load_store_menu', 'store', 'all', '0', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(40) NOT NULL,
  `module` varchar(60) NOT NULL,
  `label` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `license_quantity` int(11) NOT NULL DEFAULT '0' COMMENT '0=unlimited',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL COMMENT '0=disabled, 1=active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` VALUES(1, '1', 'natural', 'Natural', 'Natural', 0, '2011-05-13 12:16:14', 1);
INSERT INTO `module` VALUES(4, '1', 'acl', 'Access Control', 'Access Control', 0, '2011-05-13 12:16:14', 1);
INSERT INTO `module` VALUES(5, '1', 'menu_nav', 'Menu Management', 'Menu Management', 0, '2011-05-13 12:16:14', 1);
INSERT INTO `module` VALUES(6, '1', 'cdr', 'Call History Management', 'Call History Management', 0, '2011-05-13 12:16:27', 1);
INSERT INTO `module` VALUES(7, '1', 'dashboard', 'Dashboard', 'Dashboard', 0, '2011-05-13 12:16:14', 1);
INSERT INTO `module` VALUES(14, '1', 'user', 'User Management', 'User Management', 0, '2011-05-13 12:16:51', 1);
INSERT INTO `module` VALUES(65, '1', 'package', 'Package', 'Package', 0, '2011-05-13 12:28:49', 1);
INSERT INTO `module` VALUES(39, '1', 'media', 'Media Management', 'Media Management', 0, '2011-05-13 12:16:14', 1);
INSERT INTO `module` VALUES(38, '1', 'conference_plus', 'Conference', 'Conference Management', 0, '2011-05-13 12:17:44', 1);
INSERT INTO `module` VALUES(21, '1', 'customer', 'Customer', 'Customer Management', 0, '2011-05-13 12:16:14', 1);
INSERT INTO `module` VALUES(37, '1', 'route_profile', 'Route Profile', 'Route Profile', 0, '2011-05-13 12:16:14', 1);
INSERT INTO `module` VALUES(64, '1', 'order', 'Order', 'Order', 0, '2011-05-13 12:28:49', 1);
INSERT INTO `module` VALUES(63, '1', 'mailbox', 'Mailbox', 'Mailbox', 0, '2011-05-13 12:28:49', 1);
INSERT INTO `module` VALUES(62, '1', 'location', 'Location', 'Location', 0, '2011-05-13 12:24:24', 1);
INSERT INTO `module` VALUES(61, '1', 'help', 'Help', 'Help', 0, '2011-05-13 12:24:24', 1);
INSERT INTO `module` VALUES(60, '1', 'features', 'Features', 'Features', 0, '2011-05-13 12:24:24', 1);
INSERT INTO `module` VALUES(59, '1', 'extension', 'Extension', 'Extension', 0, '2011-05-13 12:24:24', 1);
INSERT INTO `module` VALUES(58, '1', 'e911', 'E911', 'E911', 0, '2011-05-13 12:24:24', 1);
INSERT INTO `module` VALUES(57, '1', 'downloads', 'Downloads', 'Downloads', 0, '2011-05-13 12:24:24', 1);
INSERT INTO `module` VALUES(56, '1', 'directory', 'Directory', 'Directory', 0, '2011-05-13 12:24:24', 1);
INSERT INTO `module` VALUES(55, '1', 'device', 'Device', 'Device', 0, '2011-05-13 12:24:24', 1);
INSERT INTO `module` VALUES(54, '1', 'contact', 'Contact', 'Contact', 0, '2011-05-13 12:24:24', 1);
INSERT INTO `module` VALUES(53, '1', 'billing', 'Billing', 'Billing', 0, '2011-05-13 12:24:24', 1);
INSERT INTO `module` VALUES(66, '1', 'partner', 'Partner', 'Partner', 0, '2011-05-13 12:28:49', 1);
INSERT INTO `module` VALUES(67, '1', 'payment_profile', 'Payment Profile', 'Payment Profile', 0, '2011-05-13 12:28:49', 1);
INSERT INTO `module` VALUES(68, '1', 'phone_number', 'Phone Number', 'Phone Number', 0, '2011-05-13 12:28:49', 1);
INSERT INTO `module` VALUES(69, '1', 'provisioning', 'Provisioning', 'Provisioning', 0, '2011-05-13 12:28:49', 1);
INSERT INTO `module` VALUES(70, '1', 'remote_access', 'Remote Access', 'Remote Access', 0, '2011-05-13 12:28:49', 1);
INSERT INTO `module` VALUES(71, '1', 'transaction', 'Transaction', 'Transaction', 0, '2011-05-13 12:28:49', 1);
INSERT INTO `module` VALUES(72, '1', 'trouble_ticket', 'Troube Ticket', 'Troube Ticket', 0, '2011-05-13 12:28:49', 1);
INSERT INTO `module` VALUES(73, '1', 'store', 'Store', 'Store', 0, '2012-02-08 18:26:47', 1);
INSERT INTO `module` VALUES(74, '1', 'ippbx', 'IP PBX', 'IP PBX', 0, '2012-02-08 18:26:47', 1);
INSERT INTO `module` VALUES(75, '1', 'trunk', 'Trunks', 'Trunks', 0, '2012-02-08 18:27:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

DROP TABLE IF EXISTS `reset_password`;
CREATE TABLE IF NOT EXISTS `reset_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `token` varchar(150) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `reset_password`
--

INSERT INTO `reset_password` VALUES(1, '61558', '7', 'd58162978f83cfbe7ab41d3b1cf96821', '2012-01-02 16:36:18');
INSERT INTO `reset_password` VALUES(2, '61558', '1081', 'd58162978f83cfbe7ab41d3b1cf96821', '2012-01-02 16:36:18');
INSERT INTO `reset_password` VALUES(3, '61558', '1085', '5b8cd1232fb255f34fff11572c54b0cd', '2012-01-02 16:36:19');
INSERT INTO `reset_password` VALUES(4, '61558', '7', 'e100ea86079ae68df9c5c993d00a0605', '2012-01-02 16:40:02');
INSERT INTO `reset_password` VALUES(5, '61558', '1081', 'e100ea86079ae68df9c5c993d00a0605', '2012-01-02 16:40:02');
INSERT INTO `reset_password` VALUES(6, '61558', '1085', '69b5c666323f1a29caeb66fa3b530bdb', '2012-01-02 16:40:03');
INSERT INTO `reset_password` VALUES(7, '61558', '7', '393d84b6bae5b80c2f8097ff52c62e38', '2012-01-02 16:41:09');
INSERT INTO `reset_password` VALUES(8, '61558', '1081', '7713be26b8d1e6d390c3c754c3730caa', '2012-01-02 16:41:10');
INSERT INTO `reset_password` VALUES(9, '61558', '1085', 'bbaa8f9b5f78191c7b6a0b1c520be4fb', '2012-01-02 16:41:11');
INSERT INTO `reset_password` VALUES(10, '61558', '7', '4d75f92777afaebeb40559a90f66d450', '2012-01-02 17:01:19');
INSERT INTO `reset_password` VALUES(11, '61558', '1081', '4d75f92777afaebeb40559a90f66d450', '2012-01-02 17:01:19');
INSERT INTO `reset_password` VALUES(12, '61558', '1085', '4d75f92777afaebeb40559a90f66d450', '2012-01-02 17:01:19');
INSERT INTO `reset_password` VALUES(13, '61558', '1085', 'ba49b3093a9637a7235b34960a54a7f9', '2012-01-03 11:14:02');

-- --------------------------------------------------------

--
-- Table structure for table `select_option`
--

DROP TABLE IF EXISTS `select_option`;
CREATE TABLE IF NOT EXISTS `select_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upstream_name` varchar(40) NOT NULL,
  `value` varchar(40) NOT NULL,
  `description` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `upstream_name_value` (`upstream_name`,`value`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=235 ;

--
-- Dumping data for table `select_option`
--

INSERT INTO `select_option` VALUES(1, 'codecs', 'g729', 'g.729');
INSERT INTO `select_option` VALUES(2, 'codecs', 'ulaw', 'g.711(ulaw)');
INSERT INTO `select_option` VALUES(3, 'codecs', 'alaw', 'g.711(alaw)');
INSERT INTO `select_option` VALUES(4, 'codecs', 'gsm', 'gsm');
INSERT INTO `select_option` VALUES(5, 'dtmfmode', 'sipinfo', 'Sip Info');
INSERT INTO `select_option` VALUES(6, 'dtmfmode', 'rfc2833', 'RFC 2833');
INSERT INTO `select_option` VALUES(7, 'enabled_disabled', '1', 'Enabled');
INSERT INTO `select_option` VALUES(8, 'enabled_disabled', '0', 'Disabled');
INSERT INTO `select_option` VALUES(9, 'yes_no', '1', 'Yes');
INSERT INTO `select_option` VALUES(10, 'yes_no', '0', 'No');
INSERT INTO `select_option` VALUES(11, 'campaign', 'W', 'Waiting');
INSERT INTO `select_option` VALUES(12, 'campaign', 'S', 'Stop');
INSERT INTO `select_option` VALUES(13, 'order_tracking', '0', 'Open');
INSERT INTO `select_option` VALUES(14, 'order_tracking', '1', 'Completed');
INSERT INTO `select_option` VALUES(15, 'order_tracking', '2', 'Cancelled');
INSERT INTO `select_option` VALUES(16, 'order_tasks', '0', 'Pending');
INSERT INTO `select_option` VALUES(17, 'order_tasks', '1', 'Completed');
INSERT INTO `select_option` VALUES(18, 'order_tasks', '2', 'Cancelled');
INSERT INTO `select_option` VALUES(19, 'order_tasks', '3', 'Waiting');
INSERT INTO `select_option` VALUES(134, 'trouble_ticket_category', '1', 'Phone not Working');
INSERT INTO `select_option` VALUES(133, 'trouble_ticket_category', '0', 'Billing Issue');
INSERT INTO `select_option` VALUES(29, 'timeout', '20', '20');
INSERT INTO `select_option` VALUES(30, 'timeout', '25', '25');
INSERT INTO `select_option` VALUES(31, 'timeout', '30', '30');
INSERT INTO `select_option` VALUES(32, 'timeout', '35', '35');
INSERT INTO `select_option` VALUES(33, 'timeout', '40', '40');
INSERT INTO `select_option` VALUES(34, 'timeout', '45', '45');
INSERT INTO `select_option` VALUES(35, 'timeout', '50', '50');
INSERT INTO `select_option` VALUES(36, 'timeout', '55', '55');
INSERT INTO `select_option` VALUES(37, 'timeout', '60', '60');
INSERT INTO `select_option` VALUES(38, 'timeout', '65', '65');
INSERT INTO `select_option` VALUES(39, 'timeout', '70', '70');
INSERT INTO `select_option` VALUES(40, 'timeout', '75', '75');
INSERT INTO `select_option` VALUES(41, 'feature_yes_no', 'y', 'Yes');
INSERT INTO `select_option` VALUES(42, 'feature_yes_no', 'n', 'No');
INSERT INTO `select_option` VALUES(43, 'feature_rule', 'sequential', 'Sequential');
INSERT INTO `select_option` VALUES(44, 'feature_rule', 'all', 'All');
INSERT INTO `select_option` VALUES(45, 'feature_mb_type', 'b', 'Busy');
INSERT INTO `select_option` VALUES(46, 'feature_mb_type', 'u', 'Unavailable');
INSERT INTO `select_option` VALUES(47, 'feature_message', 'goodbye', 'Good Bye');
INSERT INTO `select_option` VALUES(48, 'feature_message', 'thank-you', 'Thank You');
INSERT INTO `select_option` VALUES(49, 'feature_message', '', 'Don`t play anything');
INSERT INTO `select_option` VALUES(50, 'timeout', '80', '80');
INSERT INTO `select_option` VALUES(51, 'timeout', '85', '85');
INSERT INTO `select_option` VALUES(52, 'timeout', '90', '90');
INSERT INTO `select_option` VALUES(53, 'timeout', '80', '80');
INSERT INTO `select_option` VALUES(54, 'timeout', '85', '85');
INSERT INTO `select_option` VALUES(55, 'months', '01', 'Jan');
INSERT INTO `select_option` VALUES(56, 'months', '02', 'Feb');
INSERT INTO `select_option` VALUES(57, 'months', '03', 'Mar');
INSERT INTO `select_option` VALUES(58, 'months', '04', 'Apr');
INSERT INTO `select_option` VALUES(59, 'months', '05', 'May');
INSERT INTO `select_option` VALUES(60, 'months', '06', 'Jun');
INSERT INTO `select_option` VALUES(61, 'months', '07', 'Jul');
INSERT INTO `select_option` VALUES(62, 'months', '08', 'Aug');
INSERT INTO `select_option` VALUES(63, 'months', '09', 'Sep');
INSERT INTO `select_option` VALUES(64, 'months', '10', 'Oct');
INSERT INTO `select_option` VALUES(65, 'months', '11', 'Nov');
INSERT INTO `select_option` VALUES(66, 'months', '12', 'Dec');
INSERT INTO `select_option` VALUES(67, 'phone_number_status', '0', 'Disconnected');
INSERT INTO `select_option` VALUES(68, 'phone_number_status', '1', 'Active');
INSERT INTO `select_option` VALUES(69, 'phone_number_status', '2', 'Ported');
INSERT INTO `select_option` VALUES(70, 'device_status', '0', 'In Stock');
INSERT INTO `select_option` VALUES(71, 'device_status', '1', 'In Use');
INSERT INTO `select_option` VALUES(72, 'device_status', '2', 'Waiting Return');
INSERT INTO `select_option` VALUES(73, 'device_status', '3', 'Manufacturing Problem');
INSERT INTO `select_option` VALUES(74, 'device_status', '4', 'Burned');
INSERT INTO `select_option` VALUES(75, 'device_status', '5', 'Manualy Configured');
INSERT INTO `select_option` VALUES(76, 'device_status', '6', 'Account Suspended');
INSERT INTO `select_option` VALUES(77, 'device_status', '7', 'Account Cancelled');
INSERT INTO `select_option` VALUES(78, 'user_status', '0', 'Suspended');
INSERT INTO `select_option` VALUES(79, 'user_status', '1', 'Active');
INSERT INTO `select_option` VALUES(80, 'years', '2009', '2009');
INSERT INTO `select_option` VALUES(81, 'years', '2010', '2010');
INSERT INTO `select_option` VALUES(82, 'years', '2011', '2011');
INSERT INTO `select_option` VALUES(83, 'years', '2012', '2012');
INSERT INTO `select_option` VALUES(84, 'years', '2013', '2013');
INSERT INTO `select_option` VALUES(85, 'years', '2014', '2014');
INSERT INTO `select_option` VALUES(86, 'years', '2015', '2015');
INSERT INTO `select_option` VALUES(87, 'years', '2016', '2016');
INSERT INTO `select_option` VALUES(88, 'years', '2017', '2017');
INSERT INTO `select_option` VALUES(89, 'years', '2018', '2018');
INSERT INTO `select_option` VALUES(90, 'years', '2019', '2019');
INSERT INTO `select_option` VALUES(91, 'years', '2020', '2020');
INSERT INTO `select_option` VALUES(92, 'payment_type', 'CC', 'Credit Card');
INSERT INTO `select_option` VALUES(93, 'payment_type', 'CA', 'Cash');
INSERT INTO `select_option` VALUES(94, 'payment_type', 'DC', 'Debit Card');
INSERT INTO `select_option` VALUES(95, 'payment_type', 'MO', 'Money Order');
INSERT INTO `select_option` VALUES(96, 'payment_type', 'CK', 'Check');
INSERT INTO `select_option` VALUES(97, 'payment_type', 'ID', 'Internal Discount');
INSERT INTO `select_option` VALUES(98, 'customer_current_limit', '0.00', '0.00');
INSERT INTO `select_option` VALUES(99, 'customer_current_limit', '10.00', '10.00');
INSERT INTO `select_option` VALUES(100, 'customer_current_limit', '25.00', '25.00');
INSERT INTO `select_option` VALUES(101, 'customer_current_limit', '50.00', '50.00');
INSERT INTO `select_option` VALUES(102, 'customer_current_limit', '75.00', '75.00');
INSERT INTO `select_option` VALUES(103, 'customer_current_limit', '100.00', '100.00');
INSERT INTO `select_option` VALUES(104, 'customer_current_limit', '150.00', '150.00');
INSERT INTO `select_option` VALUES(105, 'customer_current_limit', '200.00', '200.00');
INSERT INTO `select_option` VALUES(106, 'customer_current_limit', '99999.99', 'house');
INSERT INTO `select_option` VALUES(107, 'cdr_months', '1', 'Jan');
INSERT INTO `select_option` VALUES(108, 'cdr_months', '2', 'Feb');
INSERT INTO `select_option` VALUES(109, 'cdr_months', '3', 'Mar');
INSERT INTO `select_option` VALUES(110, 'cdr_months', '4', 'Apr');
INSERT INTO `select_option` VALUES(111, 'cdr_months', '5', 'May');
INSERT INTO `select_option` VALUES(112, 'cdr_months', '6', 'Jun');
INSERT INTO `select_option` VALUES(113, 'cdr_months', '7', 'Jul');
INSERT INTO `select_option` VALUES(114, 'cdr_months', '8', 'Aug');
INSERT INTO `select_option` VALUES(115, 'cdr_months', '9', 'Sep');
INSERT INTO `select_option` VALUES(116, 'cdr_months', '10', 'Oct');
INSERT INTO `select_option` VALUES(117, 'cdr_months', '11', 'Nov');
INSERT INTO `select_option` VALUES(118, 'cdr_months', '12', 'Dec');
INSERT INTO `select_option` VALUES(119, 'trouble_ticket_status', '0', 'Closed');
INSERT INTO `select_option` VALUES(120, 'trouble_ticket_status', '1', 'Open');
INSERT INTO `select_option` VALUES(121, 'trouble_ticket_status', '2', 'Pending');
INSERT INTO `select_option` VALUES(122, 'customer_status', '0', 'Cancelled');
INSERT INTO `select_option` VALUES(123, 'customer_status', '1', 'Active');
INSERT INTO `select_option` VALUES(124, 'customer_status', '2', 'Suspended');
INSERT INTO `select_option` VALUES(125, 'customer_status', '3', 'In House');
INSERT INTO `select_option` VALUES(126, 'trouble_ticket_priority', '0', 'Low');
INSERT INTO `select_option` VALUES(127, 'trouble_ticket_priority', '1', 'Medium');
INSERT INTO `select_option` VALUES(128, 'trouble_ticket_priority', '2', 'High');
INSERT INTO `select_option` VALUES(129, 'trouble_ticket_priority', '3', 'Urgent');
INSERT INTO `select_option` VALUES(135, 'trouble_ticket_category', '2', 'Call Quality');
INSERT INTO `select_option` VALUES(136, 'trouble_ticket_category', '3', 'Update Information');
INSERT INTO `select_option` VALUES(137, 'trouble_ticket_category', '4', 'Sales Inquiry');
INSERT INTO `select_option` VALUES(138, 'trouble_ticket_category', '5', 'Other');
INSERT INTO `select_option` VALUES(139, 'phone_number_status', '3', 'Not Assigned');
INSERT INTO `select_option` VALUES(140, 'phone_number_status', '4', 'Pending');
INSERT INTO `select_option` VALUES(141, 'cdr_years', '2009', '2009');
INSERT INTO `select_option` VALUES(142, 'cdr_years', '2010', '2010');
INSERT INTO `select_option` VALUES(143, 'cdr_years', '2011', '2011');
INSERT INTO `select_option` VALUES(144, 'cdr_years', '2012', '2012');
INSERT INTO `select_option` VALUES(145, 'cdr_years', '2013', '2013');
INSERT INTO `select_option` VALUES(146, 'cdr_years', '2014', '2014');
INSERT INTO `select_option` VALUES(147, 'cdr_years', '2015', '2015');
INSERT INTO `select_option` VALUES(148, 'cdr_years', '2016', '2016');
INSERT INTO `select_option` VALUES(149, 'menu_conditions', 'between', 'between');
INSERT INTO `select_option` VALUES(150, 'menu_conditions', 'equal', 'equal');
INSERT INTO `select_option` VALUES(151, 'menu_conditions', 'higher', 'higher');
INSERT INTO `select_option` VALUES(152, 'menu_conditions', 'lower', 'lower');
INSERT INTO `select_option` VALUES(153, 'menu_conditions', 'all', 'all');
INSERT INTO `select_option` VALUES(154, 'days_of_week', 'Sun', 'Sunday');
INSERT INTO `select_option` VALUES(155, 'days_of_week', 'Mon', 'Monday');
INSERT INTO `select_option` VALUES(156, 'days_of_week', 'Tue', 'Tuesday');
INSERT INTO `select_option` VALUES(157, 'days_of_week', 'Wed', 'Wednesday');
INSERT INTO `select_option` VALUES(158, 'days_of_week', 'Thu', 'Thursday');
INSERT INTO `select_option` VALUES(159, 'days_of_week', 'Fri', 'Friday');
INSERT INTO `select_option` VALUES(160, 'days_of_week', 'Sat', 'Saturday');
INSERT INTO `select_option` VALUES(161, 'mailbox_routing_type', 'b', 'Busy');
INSERT INTO `select_option` VALUES(162, 'mailbox_routing_type', 'u', 'Unavailable');
INSERT INTO `select_option` VALUES(163, 'timeout_no_unlimited', '5', '5');
INSERT INTO `select_option` VALUES(164, 'timeout_no_unlimited', '10', '10');
INSERT INTO `select_option` VALUES(165, 'timeout_no_unlimited', '15', '15');
INSERT INTO `select_option` VALUES(166, 'timeout_no_unlimited', '20', '20');
INSERT INTO `select_option` VALUES(167, 'timeout_no_unlimited', '25', '25');
INSERT INTO `select_option` VALUES(168, 'timeout_no_unlimited', '30', '30');
INSERT INTO `select_option` VALUES(169, 'timeout_no_unlimited', '35', '35');
INSERT INTO `select_option` VALUES(170, 'timeout_no_unlimited', '40', '40');
INSERT INTO `select_option` VALUES(171, 'timeout_no_unlimited', '45', '45');
INSERT INTO `select_option` VALUES(172, 'timeout_no_unlimited', '50', '50');
INSERT INTO `select_option` VALUES(173, 'timeout_no_unlimited', '55', '55');
INSERT INTO `select_option` VALUES(174, 'timeout_no_unlimited', '60', '60');
INSERT INTO `select_option` VALUES(175, 'timeout_no_unlimited', '65', '65');
INSERT INTO `select_option` VALUES(176, 'timeout_no_unlimited', '70', '70');
INSERT INTO `select_option` VALUES(177, 'timeout_no_unlimited', '75', '75');
INSERT INTO `select_option` VALUES(178, 'timeout_no_unlimited', '80', '80');
INSERT INTO `select_option` VALUES(179, 'timeout_no_unlimited', '85', '85');
INSERT INTO `select_option` VALUES(180, 'timeout_no_unlimited', '90', '90');
INSERT INTO `select_option` VALUES(181, 'timeout_no_unlimited', '80', '80');
INSERT INTO `select_option` VALUES(182, 'timeout_no_unlimited', '85', '85');
INSERT INTO `select_option` VALUES(183, 'timeout_no_unlimited', '90', '90');
INSERT INTO `select_option` VALUES(184, 'states', 'AK', 'Alaska');
INSERT INTO `select_option` VALUES(185, 'states', 'AL', 'Alabama');
INSERT INTO `select_option` VALUES(186, 'states', 'AR', 'Arkansas');
INSERT INTO `select_option` VALUES(187, 'states', 'AZ', 'Arizona');
INSERT INTO `select_option` VALUES(188, 'states', 'CA', 'California');
INSERT INTO `select_option` VALUES(189, 'states', 'CO', 'Colorado');
INSERT INTO `select_option` VALUES(190, 'states', 'CT', 'Connecticut');
INSERT INTO `select_option` VALUES(191, 'states', 'DC', 'District of Columbia');
INSERT INTO `select_option` VALUES(192, 'states', 'DE', 'Delaware');
INSERT INTO `select_option` VALUES(193, 'states', 'FL', 'Florida');
INSERT INTO `select_option` VALUES(194, 'states', 'GA', 'Georgia');
INSERT INTO `select_option` VALUES(195, 'states', 'HI', 'Hawaii');
INSERT INTO `select_option` VALUES(196, 'states', 'IA', 'Iowa');
INSERT INTO `select_option` VALUES(197, 'states', 'ID', 'Idaho');
INSERT INTO `select_option` VALUES(198, 'states', 'IL', 'Illinois');
INSERT INTO `select_option` VALUES(199, 'states', 'IN', 'Indiana');
INSERT INTO `select_option` VALUES(200, 'states', 'KS', 'Kansas');
INSERT INTO `select_option` VALUES(201, 'states', 'KY', 'Kentucky');
INSERT INTO `select_option` VALUES(202, 'states', 'LA', 'Louisiana');
INSERT INTO `select_option` VALUES(203, 'states', 'MA', 'Massachusetts');
INSERT INTO `select_option` VALUES(204, 'states', 'MD', 'Maryland');
INSERT INTO `select_option` VALUES(205, 'states', 'ME', 'Maine');
INSERT INTO `select_option` VALUES(206, 'states', 'MI', 'Michigan');
INSERT INTO `select_option` VALUES(207, 'states', 'MN', 'Minnesota');
INSERT INTO `select_option` VALUES(208, 'states', 'MO', 'Missouri');
INSERT INTO `select_option` VALUES(209, 'states', 'MS', 'Mississippi');
INSERT INTO `select_option` VALUES(210, 'states', 'MT', 'Montana');
INSERT INTO `select_option` VALUES(211, 'states', 'NC', 'North Carolina');
INSERT INTO `select_option` VALUES(212, 'states', 'ND', 'North Dakota');
INSERT INTO `select_option` VALUES(213, 'states', 'NE', 'Nebraska');
INSERT INTO `select_option` VALUES(214, 'states', 'NH', 'New Hampshire');
INSERT INTO `select_option` VALUES(215, 'states', 'NJ', 'New Jersey');
INSERT INTO `select_option` VALUES(216, 'states', 'NM', 'New Mexico');
INSERT INTO `select_option` VALUES(217, 'states', 'NV', 'Nevada');
INSERT INTO `select_option` VALUES(218, 'states', 'NY', 'New York');
INSERT INTO `select_option` VALUES(219, 'states', 'OH', 'Ohio');
INSERT INTO `select_option` VALUES(220, 'states', 'OK', 'Oklahoma');
INSERT INTO `select_option` VALUES(221, 'states', 'OR', 'Oregon');
INSERT INTO `select_option` VALUES(222, 'states', 'PA', 'Pennsylvania');
INSERT INTO `select_option` VALUES(223, 'states', 'RI', 'Rhode Island');
INSERT INTO `select_option` VALUES(224, 'states', 'SC', 'South Carolina');
INSERT INTO `select_option` VALUES(225, 'states', 'SD', 'South Dakota');
INSERT INTO `select_option` VALUES(226, 'states', 'TN', 'Tennessee');
INSERT INTO `select_option` VALUES(227, 'states', 'TX', 'Texas');
INSERT INTO `select_option` VALUES(228, 'states', 'UT', 'Utah');
INSERT INTO `select_option` VALUES(229, 'states', 'VA', 'Virginia');
INSERT INTO `select_option` VALUES(230, 'states', 'VT', 'Vermont');
INSERT INTO `select_option` VALUES(231, 'states', 'WA', 'Washington');
INSERT INTO `select_option` VALUES(232, 'states', 'WI', 'Wisconsin');
INSERT INTO `select_option` VALUES(233, 'states', 'WV', 'West Virginia');
INSERT INTO `select_option` VALUES(234, 'states', 'WY', 'Wyoming');

-- --------------------------------------------------------

--
-- Table structure for table `side_menu`
--

DROP TABLE IF EXISTS `side_menu`;
CREATE TABLE IF NOT EXISTS `side_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_menu_id` tinyint(4) NOT NULL,
  `position` tinyint(4) NOT NULL,
  `element_name` varchar(50) NOT NULL,
  `label` varchar(40) NOT NULL,
  `title` varchar(100) NOT NULL,
  `func` varchar(50) NOT NULL,
  `module` varchar(20) NOT NULL,
  `allow` varchar(10) NOT NULL DEFAULT 'all',
  `allow_value` varchar(10) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `initial` tinyint(4) NOT NULL DEFAULT '0',
  `dash_admin` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `position` (`position`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=168 ;

--
-- Dumping data for table `side_menu`
--

INSERT INTO `side_menu` VALUES(1, 1, 0, 'view_myinfo_side', 'View', 'My Account Information', 'view_my_info', 'user', 'all', '1', 1, 1, 1);
INSERT INTO `side_menu` VALUES(2, 1, 1, 'change_pass_side', 'Change Password', 'Change My Password', 'change_my_pass', 'user', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(3, 1, 2, 'my_group_side', 'My Group', 'Manage My Group', 'change_my_group', 'people', 'all', '0', 0, 0, 1);
INSERT INTO `side_menu` VALUES(11, 5, 0, 'list_reports_side', 'List', 'List all reports', '', '', 'all', '0', 0, 0, 1);
INSERT INTO `side_menu` VALUES(12, 5, 1, 'search_reports_side', 'Search', 'Search reports', '', '', 'all', '0', 0, 0, 1);
INSERT INTO `side_menu` VALUES(164, 85, 1, 'search_form_side', 'Search Form', 'Search Forms', 'search_form_menu', 'natural', 'all', '0', 0, 0, 1);
INSERT INTO `side_menu` VALUES(165, 85, 2, 'create_class_side', 'Class/Forms Creator', 'Create Classes/Forms', 'show_table_list', 'natural', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(53, 46, 0, 'c_list_mycalls_side', 'List', 'List my calls', '', '', 'all', '', 0, 0, 1);
INSERT INTO `side_menu` VALUES(163, 85, 0, 'list_forms_side', 'List Forms', 'List All Menus', 'list_forms', 'natural', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(43, 28, 0, 'config_side', 'Config', 'Config', '', '', 'all', '0', 0, 0, 0);
INSERT INTO `side_menu` VALUES(44, 28, 1, 'commission_side', 'Commission Reports', 'Commission Reports', '', '', 'all', '0', 0, 0, 0);
INSERT INTO `side_menu` VALUES(45, 28, 2, 'finalcial_side', 'Financial Reports', 'Financial Reports', '', '', 'all', '0', 0, 0, 0);
INSERT INTO `side_menu` VALUES(46, 28, 3, 'ratedeck_side', 'Rate Deck', 'Manage Rate Deck', '', '', 'all', '0', 0, 0, 0);
INSERT INTO `side_menu` VALUES(47, 41, 1, 'new_acc_side', 'New Account', 'Create New Account', '', '', 'all', '', 0, 0, 0);
INSERT INTO `side_menu` VALUES(48, 28, 4, 'taxing_side', 'Taxing', 'Tax Rates', '', '', 'all', '0', 0, 0, 0);
INSERT INTO `side_menu` VALUES(49, 41, 2, 'add_service_side', 'Add Service', 'Add New Service', '', '', 'all', '', 0, 0, 0);
INSERT INTO `side_menu` VALUES(50, 41, 3, 'change_service_side', 'Change Service', 'Change Service', '', '', 'all', '0', 0, 0, 0);
INSERT INTO `side_menu` VALUES(51, 41, 0, 'track_order_side', 'Open Orders', 'Open Orders', 'order_list', 'order', 'all', '0', 1, 0, 0);
INSERT INTO `side_menu` VALUES(52, 45, 0, 'c_view_myinfo_side', 'View', 'View', 'view_customer_info', 'customer', 'all', '0', 1, 1, 0);
INSERT INTO `side_menu` VALUES(162, 84, 0, 'view_levels_side', 'View levels', 'View access levels', 'view_access_levels', 'acl', 'all', '0', 1, 0, 0);
INSERT INTO `side_menu` VALUES(54, 47, 0, 'c_list_myorder_side', 'List', 'List', '', '', 'all', '', 0, 0, 1);
INSERT INTO `side_menu` VALUES(55, 47, 1, 'c_edit_myorder_side', 'Edit', 'Edit', '', '', 'all', '', 0, 0, 1);
INSERT INTO `side_menu` VALUES(57, 50, 0, 'c_admin_user_list_side', 'List', 'List Users', 'list_users', 'user', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(58, 50, 1, 'c_admin_user_add_side', 'Add New User', 'New User', 'new_user', 'user', 'higher', '40', 1, 0, 1);
INSERT INTO `side_menu` VALUES(59, 56, 0, 'c_docs_list_side', 'List', 'List Documents', '', '', 'all', '', 0, 0, 1);
INSERT INTO `side_menu` VALUES(61, 51, 0, 'c_packages_list_side', 'List', 'List Packages', 'list_customer_packages', 'package', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(109, 34, 5, 'build_quick_list_side', 'Quick List Reactivation', 'Quick List Reactivation', 'show_quicklist_reactivation_menu', 'provisioning', 'higher', '70', 1, 0, 1);
INSERT INTO `side_menu` VALUES(63, 53, 0, 'c_ph_list_side', 'List', 'List My Phone Numbers', 'list_phone_numbers', 'phone_number', 'higher', '40', 1, 0, 1);
INSERT INTO `side_menu` VALUES(64, 61, 0, 'c_tt_list_side', 'List', 'List Trouble Tickets', '', '', 'all', '', 0, 0, 1);
INSERT INTO `side_menu` VALUES(65, 26, 0, 'admin_customer_list_side', 'List', 'List Custmers', 'customer_list', 'customer', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(68, 50, 2, 'c_admin_user_ext_side', 'Extension', 'User Extension', 'list_customer_extensions', 'extension', 'all', '0', 0, 0, 1);
INSERT INTO `side_menu` VALUES(69, 50, 3, 'c_admin_user_vm_side', 'Mailbox', 'User Mailbox', 'list_customer_mailboxes', 'mailbox', 'all', '0', 0, 0, 1);
INSERT INTO `side_menu` VALUES(70, 50, 4, 'c_admin_user_assign_device_side', 'Assign Device', 'Assign User Devices', 'assign_user_device', 'device', 'higher', '75', 1, 0, 1);
INSERT INTO `side_menu` VALUES(73, 65, 1, 'admin_new_user_side', 'Add New User', 'Add New User', 'admin_new_user', 'user', 'all', '64', 1, 0, 1);
INSERT INTO `side_menu` VALUES(72, 65, 0, 'admin_list_users_side', 'List', 'List Users', 'user_list', 'user', 'all', '60', 1, 0, 1);
INSERT INTO `side_menu` VALUES(74, 42, 0, 'Trouble Ticket', 'Open/Pending Tickets', 'Open/Pending Ticketst', 'trouble_ticket_list', 'trouble_ticket', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(75, 34, 1, 'prov_device_add', 'Add new device', 'Add new device', 'admin_new_device', 'device', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(76, 34, 2, 'prov_device_user_side', 'Assign to a User', 'Assing device to a User', 'assign_device_user', 'device', 'all', '0', 0, 0, 1);
INSERT INTO `side_menu` VALUES(77, 34, 3, 'prov_device_customer_side', 'Assign to a Customer', 'Assing device to a Customer', 'assign_device_customer', 'device', 'all', '0', 0, 0, 1);
INSERT INTO `side_menu` VALUES(78, 34, 0, 'prov_device_list_side', 'List', 'List Devices', 'device_list', 'device', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(79, 66, 0, 'route_profile_list_menu_item', 'Route Profile', 'Route Profile', 'list_route_profile', 'route_profile', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(80, 41, 4, 'order_tracking_not_open_side_menu', 'Completed/Cancelled Orders', 'Completed/Cancelled Orders', 'order_notopen_list', 'order', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(81, 34, 4, 'assign_device_side', 'Assign Device', 'Assign Device', 'select_device', 'provisioning', 'higher', '70', 1, 0, 1);
INSERT INTO `side_menu` VALUES(83, 26, 1, 'customer_export', 'Customer Export', 'Customer Export List', 'export_customers', 'customer', 'higher', '75', 0, 0, 1);
INSERT INTO `side_menu` VALUES(90, 57, 0, 'list_fax_side_cust', 'List', 'List Fax', 'media_fax_list', 'media', 'higher', '40', 1, 0, 1);
INSERT INTO `side_menu` VALUES(91, 58, 0, 'list_cr_side_cust', 'List', 'List Call Recordings', 'media_prompt_list', 'media', 'higher', '40', 1, 0, 1);
INSERT INTO `side_menu` VALUES(92, 59, 0, 'list_ap_side_cust', 'List', 'List Audio Prompts', 'audio_prompt_list', 'media', 'higher', '40', 1, 0, 1);
INSERT INTO `side_menu` VALUES(93, 59, 1, 'upload_prompt_side_cust', 'Upload Prompt', 'Upload Audio Prompt', 'audio_prompt_upload_form', 'media', 'higher', '40', 1, 0, 1);
INSERT INTO `side_menu` VALUES(94, 68, 0, 'list_vm_sideside_cust', 'List', 'List Voice Mails', 'list_voicemail', 'media', 'higher', '40', 1, 0, 1);
INSERT INTO `side_menu` VALUES(98, 71, 0, 'customer_billing_list_side', 'List', 'List', 'customer_list_payment_profile', 'payment_profile', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(99, 71, 1, 'customer_billing_new_side', 'Add Credit Card', 'Add Credit Card', 'customer_create_payment_profile_form', 'payment_profile', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(100, 73, 0, 'side_confplus_list', 'View Schedule', 'View Conference Schedule', 'list_schedule_conference', 'conference_plus', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(101, 73, 1, 'side_confplus_new', 'Schedule New', 'Schedule a new conference call', 'setup_new_conference', 'conference_plus', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(102, 71, 2, 'Credit_Limit_Side', 'Credit Limit', 'View Account Credit Limit', 'customer_current_limit_form', 'payment_profile', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(103, 71, 3, 'customer_pay_now_side', 'Pay Now', 'Pay Now', 'customer_pay_now_form', 'payment_profile', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(104, 74, 0, 'customer_transaction_side', 'List', 'List', 'customer_transaction_list', 'transaction', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(105, 74, 1, 'create_transaction_side', 'Create Transaction', 'Create Transaction', 'customer_create_transaction_form', 'transaction', 'higher', '71', 1, 0, 1);
INSERT INTO `side_menu` VALUES(106, 63, 0, 'customer_user_info', 'User Info', 'User Info', 'edit_logged_user', 'user', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(107, 63, 1, 'customer_user_password', 'Change Password', 'Change Password', 'change_my_pass', 'user', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(108, 75, 0, 'c_cdr_list_side', 'Search', 'Search for call history', 'show_cdr_search_form', 'cdr', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(110, 76, 0, 'c_directory_list', 'List', 'List', 'directory_list', 'directory', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(111, 76, 1, 'c_directory_new_side', 'New', 'New', 'directory_create_form', 'directory', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(112, 76, 2, 'c_list_uploader_side', 'List Uploader', 'List Uploader', 'list_uploader_form', 'directory', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(114, 78, 0, 'c_view_schedule_side', 'View Schedule', 'View Schedule', 'list_scheduled_conference', 'conference_plus', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(115, 78, 1, 'c_schedule_new_side', 'Schedule New', 'Schedule New', 'setup_new_conference', 'conference_plus', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(116, 79, 0, 'c_help_side', 'Description', 'Description', 'view_help', 'help', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(117, 80, 1, 'c_findme_side', 'Find me Follow me', 'Find me Follow me', 'view_findme_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(118, 80, 0, 'c_3way_side', 'Performing a 3 Way Call', 'Performing a 3 Way Call', 'view_3way_calling_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(119, 80, 2, 'c_star_code_side', 'Star Code Listing', 'Star Code Listing', 'view_star_code_listing_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(120, 80, 3, 'c_audio_attendant_side', 'Auto Attendant', 'Auto Attendant', 'view_auto_attendant_description', 'features', 'all', '', 0, 0, 1);
INSERT INTO `side_menu` VALUES(121, 80, 4, 'c_ring_group_side', 'Ring Group', 'Ring Group', 'view_ring_group_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(122, 80, 5, 'c_dial_extension_side', 'Dial Extension', 'Dial Extension', 'view_dial_extension_description', 'features', 'all', '', 0, 0, 1);
INSERT INTO `side_menu` VALUES(123, 54, 0, 'c_call_Routing_side', 'List', 'List', 'inbound_route_list', 'route_profile', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(124, 78, 2, 'c_conference_side', 'Conference', 'Conference', 'show_conference_info', 'conference_plus', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(128, 78, 3, 'conf_plus_directions_side', 'Conference Plus Directions', 'Conference Plus Directions', 'show_conf_plus_directions', 'conference_plus', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(129, 45, 1, 'change_password_side', 'Change My Password', 'Change My Current Password', 'change_my_pass', 'user', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(130, 42, 1, 'trouble_ticket_closed_list', 'Closed Tickets', 'Closed Tickets', 'trouble_ticket_closed_list', 'trouble_ticket', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(131, 82, 0, 'trouble_ticket_list_side', 'Pending Trouble Ticket', 'Pending Trouble Ticket', 'trouble_ticket_list', 'trouble_ticket', 'all', '0', 1, 0, 1);
INSERT INTO `side_menu` VALUES(132, 82, 1, 'trouble_ticket_add_side', 'Add Trouble Ticket', 'Add Trouble Ticket', 'trouble_ticket_add_new_form', 'trouble_ticket', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(133, 42, 2, 'trouble_Ticket_add_new_side', 'Add Trouble Ticket', 'Add Trouble Ticket', 'trouble_ticket_add_new_form_system', 'trouble_ticket', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(136, 53, 1, 'phone_number_available_list', 'Assign Phone Number', 'Assign Phone Number', 'phone_number_assign_form', 'phone_number', 'higher', '70', 0, 0, 1);
INSERT INTO `side_menu` VALUES(138, 80, 6, 'c_pcidblock_side', 'Persistent Caller ID Block', 'Persistent Caller ID Block', 'view_pcidblock_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(139, 80, 7, 'c_cidblock_side', 'Caller ID Block', 'Caller ID Block', 'view_cidblock_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(140, 80, 8, 'c_lastnumredial_side', 'Last Number Redial', 'Last Number Redial', 'view_lastnumredial_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(141, 80, 10, 'c_cfa_side', 'Call Forwarding Always', 'Call Forwarding Always', 'view_cfa_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(142, 80, 9, 'c_dnd_side', 'Do Not Disturb', 'Do Not Disturb', 'view_dnd_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(143, 80, 11, 'c_cfb_side', 'Call Forward on Busy', 'Call Forward on Busy', 'view_cfb_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(144, 80, 12, 'c_cfna_side', 'Call Forward on No Answer', 'Call Forward on No Answer', 'view_cfna_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(145, 80, 13, 'c_vmsetup_side', 'Voicemail Setup', 'Voicemail Setup', 'view_vmsetup_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(146, 80, 14, 'c_odcr_side', 'On-Demand Call Recording', 'On-Demand Call Recording', 'view_odcr_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(147, 80, 15, 'c_f2email_side', 'Fax-to-Email Setup', 'Fax-to-Email Setup', 'view_fax2email_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(149, 80, 17, 'c_tt_side', 'Auto-Attendant', 'Auto-Attendant', 'view_aa_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(150, 80, 18, 'c_cf_side', 'Call Forwarding', 'Call Forwarding', 'view_cf_description', 'features', 'all', '', 0, 0, 1);
INSERT INTO `side_menu` VALUES(151, 80, 19, 'c_vm2email_side', 'Voicemail-to-Email', 'Voicemail-to-Email', 'view_vm2email_description', 'features', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(166, 54, 1, 'call_flow_add_new_side', 'Add New', 'Add New', 'inbound_route_build_interface', 'route_profile', 'all', '', 1, 0, 1);
INSERT INTO `side_menu` VALUES(167, 82, 2, 'support_info_side', 'Contact Us', 'Contact Us', 'show_contact_info', 'contact', 'all', '0', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_menu`
--

DROP TABLE IF EXISTS `sub_menu`;
CREATE TABLE IF NOT EXISTS `sub_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_menu_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `element_name` varchar(50) NOT NULL,
  `label` varchar(40) NOT NULL,
  `title` varchar(100) NOT NULL,
  `func` varchar(50) NOT NULL,
  `module` varchar(20) NOT NULL,
  `allow` varchar(40) NOT NULL,
  `allow_value` varchar(10) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=Disabled and 1=Enabled',
  `initial` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=No and 1=Yes',
  `dash_admin` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `position` (`position`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

--
-- Dumping data for table `sub_menu`
--

INSERT INTO `sub_menu` VALUES(25, 16, 0, 'list_user_sub', 'List', 'List', 'user_list', 'user', 'higher', '80', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(26, 19, 0, 'customers_sub', 'Customer', 'Customer Management', 'customer_list', 'customer', 'all', '0', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(35, 17, 1, 'phone_number_sub', 'Phone Numbers', 'Phone Numbers Management', 'phone_number_list', 'phone_number', 'higher', '70', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(5, 0, 1, 'help_main', 'Help', 'Help Bug Report', '', '', 'all', '41', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(31, 3, 0, 'cluster_system_sub', 'Cluster', 'Cluster Management', '', '', 'all', '0', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(84, 4, 1, 'access_manager_sub', 'Access Manager', 'Manage User Access', 'view_access_levels', 'acl', 'higher', '80', 0, 0, 0);
INSERT INTO `sub_menu` VALUES(34, 17, 0, 'device_sub', 'Device', 'Devices Management', 'device_list', 'device', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(11, 2, 1, 'dialer_reports_sub', 'Reports', 'Dialer Reports', '', '', 'all', '0', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(32, 3, 1, 'tools_system_sub', 'Tools', 'Tools Management', '', '', 'all', '0', 1, 0, 0);
INSERT INTO `sub_menu` VALUES(33, 3, 2, 'products_system_sub', 'Products', 'Products Management', '', '', 'all', '0', 1, 0, 0);
INSERT INTO `sub_menu` VALUES(37, 18, 0, 'plan_sub', 'Plan', 'Plan Management', '', '', 'all', '0', 1, 0, 0);
INSERT INTO `sub_menu` VALUES(38, 18, 1, 'products_package_sub', 'Products', 'Products Management', '', '', 'all', '0', 1, 0, 0);
INSERT INTO `sub_menu` VALUES(36, 17, 2, 'emergencies_sub', 'E911', 'Emergencies Management', 'provisioning', 'test', 'all', '0', 0, 0, 0);
INSERT INTO `sub_menu` VALUES(21, 12, 1, 'providers_sub', 'Providers', 'Provider Management', '', '', 'all', '0', 1, 0, 0);
INSERT INTO `sub_menu` VALUES(22, 12, 2, 'rates_sub', 'Rate Table', 'Rate Management', '', '', 'all', '0', 1, 0, 0);
INSERT INTO `sub_menu` VALUES(23, 12, 3, 'rates_sub', 'Rate Table', 'Rate Management', '', '', 'all', '0', 1, 0, 0);
INSERT INTO `sub_menu` VALUES(85, 4, 2, 'form_manager_sub', 'Form Manager', 'Form Management', 'list_forms', 'natural', 'all', '0', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(28, 16, 1, 'user_add_sub', 'Add New', 'Add New', 'admin_new_user', 'user', 'higher', '80', 1, 0, 0);
INSERT INTO `sub_menu` VALUES(39, 18, 2, 'packages_package_sub', 'Package', 'Package Management', '', '', 'all', '0', 1, 0, 0);
INSERT INTO `sub_menu` VALUES(40, 18, 3, 'contract_sub', 'Contract', 'Contract Management', '', '', 'all', '0', 1, 0, 0);
INSERT INTO `sub_menu` VALUES(43, 17, 3, 'verify_prov_sub', 'Verify', 'Verify Available Numbers with Voip Inovations', 'provisioning', 'test', 'all', '0', 0, 0, 0);
INSERT INTO `sub_menu` VALUES(44, 17, 4, 'maintenance_prov_sub', 'Maintenance', 'Maintenance', 'provisioning', 'test', 'all', '0', 0, 0, 0);
INSERT INTO `sub_menu` VALUES(45, 20, 0, 'c_myinfo_sub', 'Home', 'Home', 'view_customer_info', 'customer', 'all', '0', 0, 1, 0);
INSERT INTO `sub_menu` VALUES(46, 20, 2, 'c_mycalls_sub', 'My Calls', 'Customer Calls', '', '', 'all', '0', 0, 0, 0);
INSERT INTO `sub_menu` VALUES(47, 20, 3, 'c_myorders_sub', 'My Orders', 'Customer Orders', '', '', 'all', '0', 0, 0, 0);
INSERT INTO `sub_menu` VALUES(50, 20, 1, 'c_user_sub', 'Users', 'Users', 'list_users', 'user', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(51, 21, 2, 'c_packages_sub', 'Packages', 'Packages Administration', 'list_customer_packages', 'package', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(76, 30, 1, 'c_online_rolodex_sub', 'Online Contact Management ', 'Online Contact Management ', 'directory_list', 'directory', 'all', '0', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(53, 22, 0, 'c_myphonenumbers_sub', 'My Phone Number(s)', 'My Phone Number(s)', 'list_phone_numbers', 'phone_number', 'higher', '40', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(54, 22, 1, 'c_ph_callrouting_sub', 'Call Routing', 'Call Routing', 'list_route_profile', 'route_profile', 'all', '', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(55, 22, 2, 'c_e911_sub', 'E911', 'E911', 'provisioning', 'test', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(56, 24, 0, 'c_docs_sub', 'Docs', 'Documents', '', '', 'all', '0', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(57, 25, 0, 'c_fax_sub', 'Fax', 'Fax', 'media_fax_list', 'media', 'higher', '40', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(58, 25, 1, 'c_callrec_side', 'Call Recording', 'Call Recording', 'media_prompt_list', 'media', 'higher', '40', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(59, 25, 2, 'c_audioprompt_side', 'Audio Prompt', 'Audio Prompt', 'list_audio_prompt', 'media', 'higher', '40', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(60, 23, 4, 'c_paymentmethod_side', 'Payment Method', 'Payment Method', '', '', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(61, 24, 1, 'c_tickets_side', 'Tickets', 'Trouble Tickets', '', '', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(62, 24, 2, 'c_faqs_sub', 'FAQs', 'Frequently Asked Questions', '', '', 'all', '0', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(63, 20, 4, 'customer_my_user', 'My User', 'My User', 'edit_logged_user', 'user', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(64, 21, 3, 'customer', 'Customer', 'Customer', 'customer_info', 'customer', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(68, 25, 3, 'list_vm_side_cust', 'Voice Mail', 'Manage Voice Mails', 'list_voicemail', 'media', 'higher', '40', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(71, 23, 0, 'customer_billing_sub', 'Payment Management', 'Payment Management', 'customer_list_payment_profile', 'payment_profile', 'all', '0', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(73, 20, 5, 'sub_conference_plus', 'Conference Plus', 'Conference Feature Management', 'list_schedule_conference', 'conference_plus', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(74, 23, 1, 'customer_transaction_sub', 'Transaction History', 'Transaction History', 'customer_transaction_list', 'transaction', 'higher', '40', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(75, 23, 2, 'c_cdrs_sub', 'Call History', 'Call History Detail', 'show_cdr_search_form', 'cdr', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(78, 30, 2, 'c_conference_plus_sub', 'Conference Plus', 'Conference Plus', 'list_scheduled_conference', 'conference_plus', 'higher', '40', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(79, 33, 0, 'c_help_sub', 'View', 'View', 'view_help', 'help', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(80, 30, 0, 'c_descriptions', 'Descriptions', 'Descriptions', 'view_3way_calling_description', 'features', 'all', '0', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(82, 20, 6, 'trouble_ticket_list', 'Support', 'Support', 'trouble_ticket_list', 'trouble_ticket', 'all', '0', 0, 0, 1);
INSERT INTO `sub_menu` VALUES(86, 4, 3, 'module_builder_sub', 'Module Builder', 'Build New Dialer Package', 'show_module_builder_form', 'natural', 'all', '0', 0, 0, 0);
INSERT INTO `sub_menu` VALUES(87, 4, 4, 'populate_language_sub', 'Populate Language Table', 'Populate Language Table', 'populate_language_db', 'natural', 'all', '0', 1, 0, 1);
INSERT INTO `sub_menu` VALUES(88, 16, 2, 'change_my_pass_sub', 'Change My Password', 'Change My Password', 'change_my_pass', 'user', 'all', '0', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partner_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(40) NOT NULL,
  `access_level` int(11) NOT NULL,
  `pin` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `time_zone` varchar(60) NOT NULL,
  `type` varchar(60) NOT NULL,
  `comission_id` int(11) NOT NULL,
  `default_caller_id` varchar(16) NOT NULL,
  `permit_sms` tinyint(1) NOT NULL,
  `sms_credits` int(11) NOT NULL,
  `preferred_language` varchar(2) NOT NULL,
  `interface` varchar(30) NOT NULL,
  `dashboard_1` text NOT NULL,
  `dashboard_2` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1086 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` VALUES(1, 2, 50000, 1, 'Euclides', 'Netto', 2, 'enetto', '4“TÇ\n»vHÂ[¹ªéÂæ', 81, '1234', 1, 'US/Central', 'U', 0, '2146041551', 1, 0, 'en', '', 'a:3:{i:0;a:2:{i:0;s:1:"1";i:1;s:1:"3";}i:1;a:2:{i:0;s:1:"6";i:1;s:1:"5";}i:2;a:1:{i:0;s:1:"8";}}', 'a:3:{i:0;a:1:{i:0;s:2:"10";}i:1;a:1:{i:0;s:2:"11";}i:2;a:1:{i:0;s:1:"9";}}');
INSERT INTO `user` VALUES(3, 2, 0, 0, 'Carlos', 'Granado', 1783, 'cgranado', 'eab54fb9198bc6831ce22eb47f12c055a812e6d8', 81, '1324', 1, 'US/Samoa', 'U', 0, '', 0, 0, '', '', '0', '');
INSERT INTO `user` VALUES(4, 1, 0, 0, 'DJ', 'Belieny', 1784, 'djbelieny', '47e16f887aec52e11b4cb07403728062c3183fd4', 81, '1566', 1, 'US/Central', 'U', 0, '', 0, 0, '', '', '0', '');
