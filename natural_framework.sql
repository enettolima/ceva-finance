# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: dev.opensourcemind.us (MySQL 5.5.37-0ubuntu0.14.04.1)
# Database: natural_framework
# Generation Time: 2014-10-13 21:33:12 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table acl_levels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `acl_levels`;

CREATE TABLE `acl_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `description` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `acl_levels` WRITE;
/*!40000 ALTER TABLE `acl_levels` DISABLE KEYS */;

INSERT INTO `acl_levels` (`id`, `level`, `description`)
VALUES
	(4,41,'Customer'),
	(9,81,'Admin');

/*!40000 ALTER TABLE `acl_levels` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table book
# ------------------------------------------------------------

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `author` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;

INSERT INTO `book` (`id`, `name`, `author`)
VALUES
	(1,'Lord of the Rings','J. R. R. Tolkien'),
	(2,'The Great Gatsby','F. Scott Fitzgerald'),
	(3,'The Grapes of Wrath','John Steinbeck'),
	(4,'To the Lighthouse','Virginia Woolf'),
	(5,'Pulse','Gail McHugh'),
	(6,'Prodigy','Marie Lu'),
	(9,'Down London Road','Samantha Young'),
	(10,'The Red Pony','John Steinbeck');

/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dashboard_widgets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dashboard_widgets`;

CREATE TABLE `dashboard_widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `widget_function` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `class` varchar(100) NOT NULL DEFAULT 'full',
  `dashboard_type` int(1) NOT NULL DEFAULT '3',
  `icon` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `dashboard_widgets` WRITE;
/*!40000 ALTER TABLE `dashboard_widgets` DISABLE KEYS */;

INSERT INTO `dashboard_widgets` (`id`, `title`, `description`, `subject`, `widget_function`, `enabled`, `class`, `dashboard_type`, `icon`)
VALUES
	(1,'Donut','Example of a donut ','','donut_example',1,'ui-state-default',1,'fa fa-circle-o-notch'),
	(2,'Area Graph','This is a ticket report that shows tickets with more than 24 hours of public update','','area_graph_example',1,'ui-state-default',1,'fa fa-stumbleupon'),
	(3,'Line Chart','Line Chart Example','','line_chart_example',1,'ui-state-default',1,'fa fa-th'),
	(4,'Period Chart','Example of period chart','','period_chart_example',1,'ui-state-default',1,'fa fa-desktop'),
	(5,'Bar Graph','Example Bar Graph','','bar_graph_example',1,'ui-state-default',1,'fa fa-bar-chart-o'),
	(6,'Simple Bar Chart','Example of a simple bar chart','','bar_chart_example',1,'ui-state-default',1,'fa fa-bar-chart-o');

/*!40000 ALTER TABLE `dashboard_widgets` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table field_templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `field_templates`;

CREATE TABLE `field_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_template_id` int(11) DEFAULT NULL,
  `form_reference` varchar(100) NOT NULL DEFAULT '',
  `field_id` varchar(100) NOT NULL DEFAULT '',
  `field_name` varchar(100) NOT NULL DEFAULT '',
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
  `condition` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `field_templates` WRITE;
/*!40000 ALTER TABLE `field_templates` DISABLE KEYS */;

INSERT INTO `field_templates` (`id`, `form_template_id`, `form_reference`, `field_id`, `field_name`, `form_field_order`, `html_type`, `def_label`, `html_options`, `css_class`, `data_table`, `data_query`, `data_sort`, `data_label`, `data_value`, `field_values`, `def_val`, `vertical`, `click`, `focus`, `blur`, `level`, `acl`, `onchange`, `prefix`, `suffix`, `fieldset_name`, `tooltip`, `condition`, `required`)
VALUES
	(2094,1201,'user_edit_form','id','id',0,'hidden','Id','','','','','','','','','id','','','','','','','','','','','','',0),
	(2089,1201,'user_edit_form','first_name','first_name',1,'text','First Name','','','','','','','','','first_name','','','','','','','','','','','','',1),
	(2088,1201,'user_edit_form','last_name','last_name',2,'text','Last Name','','','','','','','','','last_name','','','','','','','','','','','','',1),
	(2086,1201,'user_edit_form','username','username',8,'hidden','Username','','','','','','','','','username','','','','','','','','','','','','',1),
	(2085,1201,'user_edit_form','password','password',9,'hidden','Password','','','','','','','','','password','','','','','71','','','','','','','',0),
	(2084,1201,'user_edit_form','access_level','access_level[]',10,'list','Access Level ','multiple','chosen-select','','','','','','access_level_options','access_level','','','','','','','','','','','','',1),
	(2082,1201,'user_edit_form','status','status',12,'list','Status','','','select_option','upstream_name=\'user_status\'','description','description','value','','status','','','','','1000','readonly','','','','','','',1),
	(2745,2000,'form_delete_form','form_delete_submit','form_delete_submit',3,'submit','','','','','','','','','','Delete','','','','','','','','','','','','',0),
	(2066,1201,'user_edit_form','email','email',3,'text','Email','','','','','','','','','email','','','','','','','','','','','','',1),
	(2761,1531,'user_create_form','avatar','avatar',100,'uploader','Avatar','','','','','','','','limit=1|type=jpg,jpeg,png|size=2M|dir=files/images/avatar|preview=true','avatar','','','','','','','','','','','Tooltip test... We only alow images on this field.','',0),
	(1417,1517,'change_user_pass','old_pass','old_pass',0,'password','Type your current password','','','','','','','','','','','','','','','','','','','','','',0),
	(1418,1517,'change_user_pass','pass1','pass1',1,'password','Type your new password','','','','','','','','','','','','','','','','','','','','','',0),
	(1419,1517,'change_user_pass','pass2','pass2',2,'password','Repeat password','','','','','','','','','','','','','','','','','','','','','',0),
	(1420,1517,'change_user_pass','','',3,'submit','Save Password','','','','','','','','','','','','','','','','','','','','','',0),
	(2760,1531,'user_create_form','password','password',5,'password','Password','','','','','','','','','','','','','','','','','','','','','access_level=41',1),
	(2483,1954,'form_edit_form','form_id','form_id',1,'text','Form Id','','','','','','','','','form_id','','','','','','','','','','','','',0),
	(2484,1954,'form_edit_form','form_name','form_name',2,'text','Form Name','','','','','','','','','form_name','','','','','','','','','','','','',0),
	(2485,1954,'form_edit_form','form_action','form_action',3,'text','Form Action','size=\'80\'','','','','','','','','form_action','','','','','','','','','','','','',0),
	(2486,1954,'form_edit_form','form_method','form_method',4,'text','Form Method','text','','','','','','','','form_method','','','','','','','','','','','','',0),
	(2487,1954,'form_edit_form','form_class','form_class',5,'text','Form Class','','','','','','','','','form_class','','','','','','','','','','','','',0),
	(2488,1954,'form_edit_form','form_title','form_title',6,'text','Title','','','','','','','','','form_title','','','','','','','','','','','','',0),
	(2489,1954,'form_edit_form','form_onsubmit','form_onsubmit',7,'text','On Submit','','','','','','','','','form_onsubmit','','','','','','','','','','','','',0),
	(2490,1954,'form_edit_form','form_tips','form_tips',8,'text','Tips','','','','','','','','','form_tips','','','','','','','','','','','','',0),
	(2491,1954,'form_edit_form','form_legend','form_legend',9,'text','Legend','','','','','','','','','form_legend','','','','','','','','','','','','',0),
	(2492,1954,'form_edit_form','id','id',0,'readonly','Id','','','','','','','','','id','','','','','','','','','','','','',0),
	(2493,1954,'form_edit_form','sub','sub',10,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(2494,1955,'form_create_form','form_id','form_id',0,'text','Form id','','','','','','','','','','','','','','','','','','','','','',0),
	(2495,1955,'form_create_form','form_name','form_name',1,'text','Form Name','','','','','','','','','','','','','','','','','','','','','',0),
	(2496,1955,'form_create_form','form_action','form_action',2,'text','Form Action','size=\'80\'','','','','','','','','javascript:process_information(\'form_name\', \'function_name\', \'module\', null, null, null, null, \'create_row\');','','','','','','','','','','','','',0),
	(2497,1955,'form_create_form','form_method','form_method',3,'text','Form Method','','','','','','','','','POST','','','','','','','','','','','','',0),
	(2498,1955,'form_create_form','form_class','form_class',4,'text','Form Class','','','','','','','','','','','','','','','','','','','','','',0),
	(2499,1955,'form_create_form','form_title','form_title',5,'text','Title','','','','','','','','','','','','','','','','','','','','','',0),
	(2500,1955,'form_create_form','form_onsubmit','form_onsubmit',6,'text','On Submit','','','','','','','','','','','','','','','','','','','','','',0),
	(2501,1955,'form_create_form','form_tips','form_tips',7,'text','Tips','','','','','','','','','','','','','','','','','','','','','',0),
	(2502,1955,'form_create_form','form_legend','form_legend',8,'text','Legend','','','','','','','','','','','','','','','','','','','','','',0),
	(2805,1955,'form_create_form','sub','sub',10,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(2510,1958,'field_create_form','id','id',0,'hidden','','','','','','','','','','','','','','','','','','','','','','',0),
	(2511,1958,'field_create_form','form_reference','form_reference',1,'list','Form','','','form_templates','id!=\'\'','form_id','form_title','id','','form_reference','','','','','','','','','','','','',0),
	(2512,1958,'field_create_form','field_id','field_id',2,'text','Field ID','','','','','','','','','','','','','','','','','','','','','',0),
	(2513,1958,'field_create_form','field_name','field_name',3,'text','Field Name','','','','','','','','','','','','','','','','','','','','','',0),
	(2514,1958,'field_create_form','form_field_order','form_field_order',4,'text','Field Order','','','','','','','','','','','','','','','','','','','','','',0),
	(2515,1958,'field_create_form','html_type','html_type',5,'list','Html Type','','','select_option','upstream_name=\'html_type\'','value','description','value','','','','','','','','','','','','','','',0),
	(2516,1958,'field_create_form','def_label','def_label',6,'text','Default Label','','','','','','','','','','','','','','','','','','','','','',0),
	(2517,1958,'field_create_form','html_options','html_options',7,'text','Html Options','','','','','','','','','','','','','','','','','','','','','',0),
	(2518,1958,'field_create_form','css_class','css_class',8,'text','Css Class','','','','','','','','','','','','','','','','','','','','','',0),
	(2519,1958,'field_create_form','data_table','data_table',9,'text','Data Table','','','','','','','','','','','','','','','','','','','','','',0),
	(2520,1958,'field_create_form','data_query','data_query',10,'text','Data Query','','','','','','','','','','','','','','','','','','','','','',0),
	(2521,1958,'field_create_form','data_sort','data_sort',11,'text','Data Sort','','','','','','','','','','','','','','','','','','','','','',0),
	(2522,1958,'field_create_form','data_label','data_label',12,'text','Data Label','','','','','','','','','','','','','','','','','','','','','',0),
	(2523,1958,'field_create_form','data_value','data_value',13,'text','Data Value','','','','','','','','','','','','','','','','','','','','','',0),
	(2524,1958,'field_create_form','field_values','field_values',14,'text','Field Values','','','','','','','','','','','','','','','','','','','','','',0),
	(2525,1958,'field_create_form','def_val','def_val',15,'text','Default Value','','','','','','','','','','','','','','','','','','','','','',0),
	(2526,1958,'field_create_form','vertical','vertical',16,'text','Vertical','','','','','','','','','','','','','','','','','','','','','',0),
	(2527,1958,'field_create_form','click','click',17,'text','Click','','','','','','','','','','','','','','','','','','','','','',0),
	(2528,1958,'field_create_form','focus','focus',18,'text','Focus','','','','','','','','','','','','','','','','','','','','','',0),
	(2529,1958,'field_create_form','blur','blur',19,'text','Blur','','','','','','','','','','','','','','','','','','','','','',0),
	(2530,1958,'field_create_form','level','level',20,'text','Level','','','','','','','','','','','','','','','','','','','','','',0),
	(2531,1958,'field_create_form','acl','acl',21,'text','Acl','','','','','','','','','','','','','','','','','','','','','',0),
	(2532,1958,'field_create_form','onchange','onchange',22,'text','OnChange','','','','','','','','','','','','','','','','','','','','','',0),
	(2533,1958,'field_create_form','prefix','prefix',23,'text','Prefix','','','','','','','','','','','','','','','','','','','','','',0),
	(2534,1958,'field_create_form','fieldset_name','fieldset_name',26,'hidden','Fieldset Name','','','fieldsets','id!=\'\'','name','name','name','default-open','','','','','','','','','','','','','',0),
	(2535,1958,'field_create_form','suffix','suffix',24,'text','Suffix','','','','','','','','','','','','','','','','','','','','','',0),
	(2536,1958,'field_create_form','sub','sub',30,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(2537,1958,'field_create_form','tooltip','tooltip',27,'text','Tootip Message','','','','','','','','','','','','','','','','','','','','','',0),
	(2538,1958,'field_create_form','required','required',28,'list','Required','','','select_option','upstream_name=\'yes_no\'','value','description','value','','0','','','','','','','','','','','','',0),
	(2768,1990,'natural_example_form','password','password',9,'hidden','Password','','','','','','','','','password','','','','','71','','','','','','','',0),
	(2767,1990,'natural_example_form','first_name','first_name',1,'text','First Name','','','','','','','','','first_name','','','','','','','','','','','','',1),
	(2766,1990,'natural_example_form','user_edit_submit','user_edit_submit',200,'submit','','','','','','','','','','Save','','','','','','','','','','','','',0),
	(2765,1990,'natural_example_form','status','status',12,'list','Status','','','select_option','upstream_name=\'user_status\'','description','description','value','','status','','','','','1000','readonly','','','','','','',1),
	(2764,1990,'natural_example_form','user_race','user_race',47,'checkbox','Race','','','select_option','upstream_name=\'user_race\'','description','description','value','','user_race','','','','','','','','','','','','',0),
	(2763,1990,'natural_example_form','hobbies','hobbies[]',10,'list','Hobbies','multiple','chosen-select','select_option','upstream_name=\'hobby\'','description','description','value','','access_level','','','','','','','','','','','','',1),
	(2762,1201,'user_edit_form','user_edit_submit','user_edit_submit',200,'submit','','','','','','','','','','Save','','','','','','','','','','','','',0),
	(2612,1965,'field_edit_form','id','id',0,'hidden','ID','','','','','','','','','id','','','','','','','','','','','','',0),
	(2613,1965,'field_edit_form','form_reference','form_reference',1,'list','Form Reference','','','form_templates','id!=\'\'','form_id','form_title','id','','form_reference','','','','','','','','','','','','',0),
	(2614,1965,'field_edit_form','field_id','field_id',2,'text','Field','','','','','','','','','field_id','','','','','','','','','','','','',0),
	(2615,1965,'field_edit_form','field_name','field_name',3,'text','Field Name','','','','','','','','','field_name','','','','','','','','','','','','',0),
	(2616,1965,'field_edit_form','form_field_order','form_field_order',4,'text','Form Field Order','','','','','','','','','form_field_order','','','','','','','','','','','','',0),
	(2617,1965,'field_edit_form','html_type','html_type',5,'list','Html Type','','','select_option','upstream_name=\'html_type\'','value','description','value','','html_type','','','','','','','','','','','','',0),
	(2618,1965,'field_edit_form','def_label','def_label',6,'text','Default Label','','','','','','','','','def_label','','','','','','','','','','','','',0),
	(2619,1965,'field_edit_form','html_options','html_options',7,'text','Html Options','','','','','','','','','html_options','','','','','','','','','','','','',0),
	(2620,1965,'field_edit_form','css_class','css_class',8,'text','Css Class','','','','','','','','','css_class','','','','','','','','','','','','',0),
	(2621,1965,'field_edit_form','data_table','data_table',9,'text','Data Table','','','','','','','','','data_table','','','','','','','','','','','','',0),
	(2622,1965,'field_edit_form','data_query','data_query',10,'text','Data Query','','','','','','','','','data_query','','','','','','','','','','','','',0),
	(2623,1965,'field_edit_form','data_sort','data_sort',11,'text','Data Sort','','','','','','','','','data_sort','','','','','','','','','','','','',0),
	(2624,1965,'field_edit_form','data_label','data_label',12,'text','Data Label','','','','','','','','','data_label','','','','','','','','','','','','',0),
	(2625,1965,'field_edit_form','data_value','data_value',13,'text','Data Value','','','','','','','','','data_value','','','','','','','','','','','','',0),
	(2626,1965,'field_edit_form','field_values','field_values',14,'text','Field Values','','','','','','','','','field_values','','','','','','','','','','','','',0),
	(2627,1965,'field_edit_form','def_val','def_val',15,'text','Default Value','','','','','','','','','def_val','','','','','','','','','','','','',0),
	(2628,1965,'field_edit_form','vertical','vertical',16,'text','Vertical','','','','','','','','','vertical','','','','','','','','','','','','',0),
	(2629,1965,'field_edit_form','click','click',17,'text','Click','','','','','','','','','click','','','','','','','','','','','','',0),
	(2630,1965,'field_edit_form','focus','focus',18,'text','Focus','','','','','','','','','focus','','','','','','','','','','','','',0),
	(2631,1965,'field_edit_form','blur','blur',19,'text','Blur','','','','','','','','','blur','','','','','','','','','','','','',0),
	(2632,1965,'field_edit_form','level','level',20,'text','Level','','','','','','','','','level','','','','','','','','','','','','',0),
	(2633,1965,'field_edit_form','acl','acl',21,'list','Acl','','','','','','','','','acl','','','','','','','','','','','','',0),
	(2634,1965,'field_edit_form','onchange','onchange',22,'text','OnChange','','','','','','','','','onchange','','','','','','','','','','','','',0),
	(2635,1965,'field_edit_form','prefix','prefix',23,'text','Prefix','','','','','','','','','prefix','','','','','','','','','','','','',0),
	(2636,1965,'field_edit_form','suffix','suffix',24,'text','Suffix','','','','','','','','','suffix','','','','','','','','','','','','',0),
	(2637,1965,'field_edit_form','fieldset_name','fieldset_name',26,'hidden','Fieldset Name','','','fieldsets','id!=\'\'','name','name','name','','fieldset_name','','','','','','','','','','','','',0),
	(2638,1965,'field_edit_form','sub','sub',30,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(2639,1965,'field_edit_form','tootip','tooltip',27,'text','Tootip Message','','','','','','','','','tooltip','','','','','','','','','','','','',0),
	(2640,1965,'field_edit_form','required','required',28,'list','Required','','','select_option','upstream_name=\'yes_no\'','value','description','value','','required','','','','','','','','','','','','',0),
	(2744,2000,'form_delete_form','id','id',0,'hidden','Id','','','','','','','','','id','','','','','','','','','','','','',0),
	(2746,1989,'user_delete_form','message','message',100,'message','','','','','','','','','','Are you sure you want to delete this user?','','','','','','','','','','','','',0),
	(2747,1989,'user_delete_form','first_last_name','first_last_name',101,'message','','','','','','','','','','first_last_name','','','','','','','','','','','','',0),
	(2749,1531,'user_create_form','last_name','last_name',2,'text','Last Name','','','','','','','','','','','','','','','','','','','','','',1),
	(2748,1531,'user_create_form','first_name','first_name',1,'text','First Name','','','','','','','','','','','','','','','','','','','','','',1),
	(2750,1531,'user_create_form','email','email',3,'text','Email','','','','','','','','','','','','','','','','','','','','','',1),
	(2751,1531,'user_create_form','access_level','access_level',6,'list','Access Level ','','','','','','','','access_level_options','','','','','','','','conditional_fields()','','','','Tooltip test, tooltip test, tooltip test, tooltip test, tooltip test, tooltip test, tooltip test...','',1),
	(2754,1531,'user_create_form','username','username',4,'text','Username','','','','','','','','','','','','','','','','','','','','','',1),
	(2755,1531,'user_create_form','sub','sub',7,'submit','','','','','','','','','','Save','','','','','','','','','','','','',0),
	(2756,1201,'user_edit_form','user_race','user_race',47,'checkbox','Race','','','select_option','upstream_name=\'user_race\'','description','description','value','','user_race','','','','','','','','','','','Tooltip test, tooltip test, tooltip test, tooltip test, tooltip test, tooltip test, tooltip test...','',0),
	(2757,1201,'user_edit_form','avatar','avatar',100,'uploader','Avatar','','','','','','','','limit=1|type=jpg,jpeg,png|size=2M|dir=files/images/avatar|preview=true|max_height=200|max_width=200','avatar','','','','','','','','','','','','',0),
	(2769,1990,'natural_example_form','username','username',8,'readonly','Username','','','','','','','','','username','','','','','','','','','','','','',1),
	(2770,1990,'natural_example_form','last_name','last_name',2,'text','Last Name','','','','','','','','','last_name','','','','','','','','','','','','',1),
	(2771,1990,'natural_example_form','password','password',9,'password','Password','','','','','','','','','password','','','','','71','','','','','','','',0),
	(2772,1990,'natural_example_form','access_level_list','access_level_list',11,'list','Access Level ','','','','','','','','access_level_options','access_level','','','','','','','','','','','','',1),
	(2773,1990,'natural_example_form','avatar','avatar',100,'uploader','Avatar','','','','','','','','limit=1|type=jpg,jpeg,png|size=2M|dir=files/images/avatar|preview=true','avatar','','','','','','','','','','','','',0),
	(2774,1991,'module_create_form','id','id',0,'hidden','','','','','','','','','','','','','','','','','','','','','','',0),
	(2775,1991,'module_create_form','version','version',1,'hidden','Version','','','','','','','','','','','','','','','','','','','','','',0),
	(2776,1991,'module_create_form','module','module',8,'hidden','Module Name','','','','','','','','','','','','','','','','','','','','','',0),
	(2777,1991,'module_create_form','label','label',3,'text','Label','','','','','','','','','','','','','','','','','','','','','',0),
	(2778,1991,'module_create_form','description','description',4,'hidden','Description','','','','','','','','','','','','','','','','','','','','','',0),
	(2779,1991,'module_create_form','license_quantity','license_quantity',5,'hidden','License Quantity','','','','','','','','','','','','','','','','','','','','','',0),
	(2780,1991,'module_create_form','last_update','last_update',6,'hidden','Last Update','','','','','','','','','','','','','','','','','','','','','',0),
	(2781,1991,'module_create_form','status','status',7,'hidden','Status','','','','','','','','','','','','','','','','','','','','','',0),
	(2782,1991,'module_create_form','table_name','table_name',2,'list','Database Table','','','','','','','','table_list','','','','','','','','','','','','','',0),
	(2783,1991,'module_create_form','structure','structure',9,'hidden','Create Structure','','','select_option','upstream_name=\'yes_no\'','value','description','value','','structure','','','','','','','','','','','','',0),
	(2784,1991,'module_create_form','create_api','create_api',10,'list','Create API','','','select_option','upstream_name=\'yes_no\'','value','description','value','','','','','','','','','','','','','','',0),
	(2785,1991,'module_create_form','create_forms','create_forms',11,'list','Create Forms','','','select_option','upstream_name=\'yes_no\'','value','description','value','','','','','','','','','','','','','','',0),
	(2786,1991,'module_create_form','create_class','create_class',12,'hidden','Create Class','','','select_option','upstream_name=\'yes_no\'','value','description','value','','','','','','','','','','','','','','',0),
	(2787,1991,'module_create_form','sub','sub',14,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(2788,1991,'module_create_form','create_menu','create_menu',13,'list','Create Menu','','','select_option','upstream_name=\'yes_no\'','value','description','value','','','','','','','','','','','','','','',0),
	(2791,1992,'book_create_form','author','author',1,'text','Author','','','','','','','','','','','','','','','','','','','','','',0),
	(2790,1531,'user_create_form','password','password',5,'password','Password','','','','','','','','','','','','','','','','','','','','','access_level=41',1),
	(2789,1992,'book_create_form','name','name',0,'text','Name','','','','','','','','','','','','','','','','','','','','','',0),
	(2792,1992,'book_create_form','sub','sub',2,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(2794,1993,'book_edit_form','name','name',1,'text','Name','','','','','','','','','name','','','','','','','','','','','','',0),
	(2795,1993,'book_edit_form','author','author',2,'text','Author','','','','','','','','','author','','','','','','','','','','','','',0),
	(2796,1993,'book_edit_form','sub','sub',3,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(2797,1993,'book_edit_form','id','id',0,'hidden','ID','','','','','','','','','id','','','','','','','','','','','','',0),
	(2798,1994,'book_delete_form','id','id',0,'hidden','ID','','','','','','','','','id','','','','','','','','','','','','',0),
	(2799,1994,'book_delete_form','message','message',1,'message','','','','','','','','','','Are you sure you want to delete this book?','','','','','','','','','','','','',0),
	(2800,1994,'book_delete_form','name','name',2,'message','','','','','','','','','','name','','','','','','','','','','','','',0),
	(2801,1989,'user_delete_form','user_delete_submit','user_delete_submit',58,'submit','','','','','','','','','','Delete','','','','','','','','','','','','',0),
	(2802,1989,'user_delete_form','id','id',0,'hidden','Id','','','','','','','','','id','','','','','','','','','','','','',0),
	(2803,2000,'form_delete_form','message','message',1,'message','','','','','','','','','','Are you sure you want to delete this form?','','','','','','','','','','','','',0),
	(2804,2000,'form_delete_form','form_title','form_title',2,'message','','','','','','','','','','form_title','','','','','','','','','','','','',0),
	(2820,2004,'class_form_create_form','type','type',0,'checkbox','Create','','','select_option','upstream_name=\'class_form_option\'','description','description','value','type','type','','','','','','','','','','','','',0),
	(2808,1958,'field_create_form','condition','condition',29,'text','Condition','','','','','','','','','','','','','','','','','','','','','',0),
	(3017,2045,'menu_create_form','label','label',5,'text','Label','','','','','','','','','','','','','','','','','','','','','',0),
	(2821,2004,'class_form_create_form','table_name','table_name',1,'list','Select a table','','','','','','','','table_options','','','','','','','','','','','','','',0),
	(2815,2003,'field_delete_form','id','id',0,'hidden','ID','','','','','','','','','id','','','','','','','','','','','','',0),
	(2816,2003,'field_delete_form','message','message',1,'message','','','','','','','','','','Are you sure you want to delete this field?','','','','','','','','','','','','',0),
	(2817,2003,'field_delete_form','field_name','field_name',2,'message','','','','','','','','','','field_name','','','','','','','','','','','','',0),
	(2818,2003,'field_delete_form','sub','sub',3,'submit','','','','','','','','','','Delete','','','','','','','','','','','','',0),
	(3013,2045,'menu_create_form','position','position',3,'text','Position','','','','','','','','','','','','','','','','','','','','','',0),
	(3014,2046,'menu_edit_form','position','position',3,'text','Position','','','','','','','','','position','','','','','','','','','','','','',0),
	(3015,2045,'menu_create_form','element_name','element_name',4,'text','Element Name','','','','','','','','','','','','','','','','','','','','','',0),
	(3010,2047,'menu_delete_form','label','label',2,'message','','','','','','','','','','label','','','','','','','','','','','','',0),
	(3011,2045,'menu_create_form','menu_name','menu_name',2,'hidden','Menu Name','','','','','','','','','main','','','','','','','','','','','','',0),
	(3009,2047,'menu_delete_form','message','message',1,'message','','','','','','','','','','Are you sure you want to delete this menu?','','','','','','','','','','','','',0),
	(3006,2047,'menu_delete_form','id','id',0,'hidden','ID','','','','','','','','','id','','','','','','','','','','','','',0),
	(3007,2045,'menu_create_form','pid','pid',1,'list','Parent','','','','','','','','pid_options','','','','','','','','','','','','','',0),
	(3008,2046,'menu_edit_form','pid','pid',1,'list','Parent','','','','','','','','pid_options','pid','','','','','','','','','','','','',0),
	(2872,2014,'module_delete_form','label','label',3,'message','','','','','','','','','','label','','','','','','','','','','','','',0),
	(2873,2014,'module_delete_form','sub','sub',4,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(3016,2046,'menu_edit_form','element_name','element_name',4,'text','Element Name','','','','','','','','','element_name','','','','','','','','','','','','',0),
	(3012,2046,'menu_edit_form','menu_name','menu_name',2,'hidden','Menu Name','','','','','','','','','menu_name','','','','','','','','','','','','',0),
	(2870,2014,'module_delete_form','id','id',0,'hidden','ID','','','','','','','','','id','','','','','','','','','','','','',0),
	(2871,2014,'module_delete_form','message','message',1,'message','','','','','','','','','','Are you sure you want to delete this module?','','','','','','','','','','','','',0),
	(3018,2046,'menu_edit_form','label','label',5,'text','Label','','','','','','','','','label','','','','','','','','','','','','',0),
	(3004,2045,'menu_create_form','id','id',0,'hidden','','','','','','','','','','','','','','','','','','','','','','',0),
	(3005,2046,'menu_edit_form','id','id',0,'hidden','','','','','','','','','','id','','','','','','','','','','','','',0),
	(3019,2045,'menu_create_form','title','title',6,'hidden','Title','','','','','','','','','','','','','','','','','','','','','',0),
	(3020,2046,'menu_edit_form','title','title',6,'hidden','Title','','','','','','','','','title','','','','','','','','','','','','',0),
	(3021,2045,'menu_create_form','func','func',7,'text','Func','','','','','','','','','','','','','','','','','','','','','',0),
	(3022,2046,'menu_edit_form','func','func',7,'text','Func','','','','','','','','','func','','','','','','','','','','','','',0),
	(3023,2045,'menu_create_form','module','module',8,'list','Module','','','module','id>\'0\'','label','label','module','','','','','','','','','','','','','','',0),
	(3024,2046,'menu_edit_form','module','module',8,'list','Module','','','module','id>\'0\'','label','label','module','','module','','','','','','','','','','','','',0),
	(3025,2045,'menu_create_form','allow','allow',9,'text','Allow','','','','','','','','','','','','','','','','','','','','','',0),
	(3026,2046,'menu_edit_form','allow','allow',9,'text','Allow','','','','','','','','','allow','','','','','','','','','','','','',0),
	(3027,2045,'menu_create_form','allow_value','allow_value',10,'text','Allow Value','','','','','','','','','','','','','','','','','','','','','',0),
	(3028,2046,'menu_edit_form','allow_value','allow_value',10,'text','Allow Value','','','','','','','','','allow_value','','','','','','','','','','','','',0),
	(3029,2045,'menu_create_form','status','status',11,'list','Status','','','select_option','upstream_name=\'enabled_disabled\'','description','description','value','','1','','','','','','','','','','','','',0),
	(3030,2046,'menu_edit_form','status','status',11,'list','Status','','','select_option','upstream_name=\'enabled_disabled\'','description','description','value','','status','','','','','','','','','','','','',0),
	(3031,2045,'menu_create_form','icon_class','icon_class',12,'text','Icon Class','','','','','','','','','','','','','','','','','','','','Refer to http://fortawesome.github.io/Font-Awesome/icons/ (i.e. fa fa-phone)','',0),
	(3032,2046,'menu_edit_form','icon_class','icon_class',12,'text','Icon Class','','','','','','','','','icon_class','','','','','','','','','','','','',0),
	(3033,2045,'menu_create_form','sub','sub',13,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(3034,2046,'menu_edit_form','sub','sub',13,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(3035,2047,'menu_delete_form','sub','sub',13,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(3036,1965,'field_edit_form','condition','condition',29,'text','Condition','','','','','','','','','condition','','','','','','','','','','','','',0),
	(3056,2051,'dashboard_widgets_create_form','description','description',2,'text','Description','','','','','','','','','','','','','','','','','','','','','',0),
	(3057,2052,'dashboard_widgets_edit_form','description','description',2,'text','Description','','','','','','','','','description','','','','','','','','','','','','',0),
	(3053,2052,'dashboard_widgets_edit_form','title','title',1,'text','Title','','','','','','','','','title','','','','','','','','','','','','',0),
	(3054,2053,'dashboard_widgets_delete_form','message','message',1,'message','','','','','','','','','','Are you sure you want to delete this dashboard_widgets?','','','','','','','','','','','','',0),
	(3055,2053,'dashboard_widgets_delete_form','title','title',2,'message','','','','','','','','','','title','','','','','','','','','','','','',0),
	(3051,2053,'dashboard_widgets_delete_form','id','id',0,'hidden','ID','','','','','','','','','id','','','','','','','','','','','','',0),
	(3052,2051,'dashboard_widgets_create_form','title','title',1,'text','Title','','','','','','','','','','','','','','','','','','','','','',0),
	(3049,2051,'dashboard_widgets_create_form','id','id',0,'hidden','','','','','','','','','','','','','','','','','','','','','','',0),
	(3050,2052,'dashboard_widgets_edit_form','id','id',0,'hidden','','','','','','','','','','id','','','','','','','','','','','','',0),
	(3058,2051,'dashboard_widgets_create_form','subject','subject',3,'hidden','Subject','','','','','','','','','','','','','','','','','','','','','',0),
	(3059,2052,'dashboard_widgets_edit_form','subject','subject',3,'hidden','Subject','','','','','','','','','subject','','','','','','','','','','','','',0),
	(3060,2051,'dashboard_widgets_create_form','widget_function','widget_function',4,'text','Widget Function','','','','','','','','','','','','','','','','','','','','','',0),
	(3061,2052,'dashboard_widgets_edit_form','widget_function','widget_function',4,'text','Widget Function','','','','','','','','','widget_function','','','','','','','','','','','','',0),
	(3062,2051,'dashboard_widgets_create_form','enabled','enabled',5,'hidden','Enabled','','','','','','','','','1','','','','','','','','','','','','',0),
	(3063,2052,'dashboard_widgets_edit_form','enabled','enabled',5,'list','Status','','','select_option','upstream_name=\'enabled_disabled\'','description','description','value','','enabled','','','','','','','','','','','','',0),
	(3064,2051,'dashboard_widgets_create_form','class','class',6,'text','Class','','','','','','','','','ui-state-default','','','','','','','','','','','','',0),
	(3065,2052,'dashboard_widgets_edit_form','class','class',6,'text','Class','','','','','','','','','class','','','','','','','','','','','','',0),
	(3066,2051,'dashboard_widgets_create_form','dashboard_type','dashboard_type',7,'hidden','Dashboard Type','','','','','','','','','1','','','','','','','','','','','','',0),
	(3067,2052,'dashboard_widgets_edit_form','dashboard_type','dashboard_type',7,'hidden','Dashboard Type','','','','','','','','','dashboard_type','','','','','','','','','','','','',0),
	(3068,2051,'dashboard_widgets_create_form','sub','sub',10,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(3069,2052,'dashboard_widgets_edit_form','sub','sub',10,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(3070,2053,'dashboard_widgets_delete_form','sub','sub',8,'submit','','','','','','','','','','','','','','','','','','','','','','',0),
	(3087,2052,'dashboard_widgets_edit_form','icon','icon',9,'text','Icon','','','','','','','','','icon','','','','','','','','','','','','',0),
	(3085,2004,'class_form_create_form','submit','submit',2,'submit','','','','','','','','','','Create','','','','','','','','','','','','',0),
	(3086,2051,'dashboard_widgets_create_form','icon','icon',9,'text','Icon','','','','','','','','','fa fa-desktop','','','','','','','','','','','Please refer to http://fortawesome.github.io/Font-Awesome/icons/','',0);

/*!40000 ALTER TABLE `field_templates` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fieldsets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fieldsets`;

CREATE TABLE `fieldsets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `css_class` varchar(50) NOT NULL,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `fieldsets` WRITE;
/*!40000 ALTER TABLE `fieldsets` DISABLE KEYS */;

INSERT INTO `fieldsets` (`id`, `position`, `name`, `css_class`, `label`)
VALUES
	(1,0,'default-open','default_open','Default Open'),
	(2,1,'default-closed','default_closed','');

/*!40000 ALTER TABLE `fieldsets` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `filemime` varchar(50) NOT NULL,
  `filesize` int(11) NOT NULL,
  `duration` varchar(20) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;

INSERT INTO `files` (`id`, `uid`, `filename`, `uri`, `filemime`, `filesize`, `duration`, `timestamp`, `status`)
VALUES
	(22,1,'user.png','files/images/avatar/user.png','image/png',2966,'',1399659950,0);

/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table form_templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `form_templates`;

CREATE TABLE `form_templates` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `form_templates` WRITE;
/*!40000 ALTER TABLE `form_templates` DISABLE KEYS */;

INSERT INTO `form_templates` (`id`, `form_id`, `form_name`, `form_action`, `form_method`, `form_class`, `form_title`, `form_onsubmit`, `form_tips`, `form_legend`, `module`, `system`)
VALUES
	(1958,'field_create_form','field_create_form','javascript:process_information(\'field_create_form\', \'field_create_form_submit\', \'natural\', null, null, null, null, \'create_row\');','POST','','Create New Field','','','Create New Field','dial_plan',1),
	(1201,'user_edit_form','user_edit_form','javascript:process_information(\'user_edit_form\', \'user_edit_form_submit\', \'user\', null, null, null, null, \'edit_row\');','POST','','Edit User','','','','',0),
	(1955,'form_create_form','form_create_form','javascript:process_information(\'form_create_form\', \'form_create_form_submit\', \'natural\', null, null, null, null, \'create_row\');','POST','','Create Form','','','Add new form','',1),
	(1954,'form_edit_form','form_edit_form','javascript:process_information(\'form_edit_form\', \'form_edit_form_submit\', \'natural\', null, null, null, null, \'edit_row\');','POST','','Edit Form','','','Edit Form Parameters','',1),
	(2000,'form_delete_form','form_delete_form','javascript:process_information(\'form_delete_form\', \'form_delete_form_submit\', \'natural\', null, null, null, null, \'delete_row\');','POST','','Delete User','','','','',0),
	(1517,'change_user_pass','change_user_pass','javascript:process_information(\'change_user_pass\', \'change_my_password\', \'user\', \'Are you sure you want to change your password?\');','POST','','Change User Password','','','','',0),
	(2053,'dashboard_widgets_delete_form','dashboard_widgets_delete_form','javascript:process_information(\'dashboard_widgets_delete_form\', \'dashboard_widgets_delete_form_submit\', \'dashboard_widgets\', null, null, null, null, \'delete_row\');','POST','','Delete Dashboard Widgets','','','','',0),
	(2051,'dashboard_widgets_create_form','dashboard_widgets_create_form','javascript:process_information(\'dashboard_widgets_create_form\', \'dashboard_widgets_create_form_submit\', \'dashboard_widgets\', null, null, null, null, \'create_row\');','POST','','Add New Dashboard Widgets','','','','',0),
	(2045,'menu_create_form','menu_create_form','javascript:process_information(\'menu_create_form\', \'menu_create_form_submit\', \'menu\', null, null, null, null, \'create_row\');','POST','','Add New Menu','','','','',0),
	(2046,'menu_edit_form','menu_edit_form','javascript:process_information(\'menu_edit_form\', \'menu_edit_form_submit\', \'menu\', null, null, null, null, \'edit_row\');','POST','','Edit Menu','','','','',0),
	(2014,'module_delete_form','module_delete_form','javascript:process_information(\'module_delete_form\', \'module_delete_form_submit\', \'natural\', null, null, null, null, \'delete_row\');','POST','','Remove Module','','','','',0),
	(2047,'menu_delete_form','menu_delete_form','javascript:process_information(\'menu_delete_form\', \'menu_delete_form_submit\', \'menu\', null, null, null, null, \'delete_row\');','POST','','Delete Menu','','','','',0),
	(2052,'dashboard_widgets_edit_form','dashboard_widgets_edit_form','javascript:process_information(\'dashboard_widgets_edit_form\', \'dashboard_widgets_edit_form_submit\', \'dashboard_widgets\', null, null, null, null, \'edit_row\');','POST','','Edit Dashboard Widgets','','','','',0),
	(1531,'user_create_form','user_create_form','javascript:process_information(\'user_create_form\', \'user_create_form_submit\', \'user\', null, null, null, null, \'create_row\');','POST','','Create New User','','','','',0),
	(1990,'natural_example_form','natural_example_form','javascript:process_information(\'natural_example_form\', \'natural_form_example_submit\', \'natural\');','POST','','Natural Form Example','','','','',0),
	(1991,'module_create_form','module_create_form','javascript:process_information(\'module_create_form\', \'module_create_form_submit\', \'natural\', null, null, null, null, \'create_row\');','POST','','Add New Module','','','','',1),
	(1992,'book_create_form','book_create_form','javascript:process_information(\'book_create_form\', \'book_create_form_submit\', \'book\', null, null, null, null, \'create_row\');','POST','','Create New Book','','','','',0),
	(1993,'book_edit_form','book_edit_form','javascript:process_information(\'book_edit_form\', \'book_edit_form_submit\', \'book\', null, null, null, null, \'edit_row\');','POST','','Edit Book','','','','',0),
	(1994,'book_delete_form','book_delete_form','javascript:process_information(\'book_delete_form\', \'book_delete_form_submit\', \'book\', null, null, null, null, \'delete_row\');','POST','','Delete Book','','','','',0),
	(1965,'field_edit_form','field_edit_form','javascript:process_information(\'field_edit_form\', \'field_edit_form_submit\', \'natural\', null, null, null, null, \'edit_row\');','POST','','Edit Field','','','','dial_plan',1),
	(2003,'field_delete_form','field_delete_form','javascript:process_information(\'field_delete_form\', \'field_delete_form_submit\', \'natural\', null, null, null, null, \'delete_row\');','POST','','Delete Field','','','','',0),
	(2004,'class_form_creator_form','class_form_creator_form','javascript:process_information(\'class_form_creator_form\', \'class_form_creator_form_submit\', \'natural\', null, null, null, \'content\', \'create_row\');','POST','','Class Form Creator','','','','',0),
	(1989,'user_delete_form','user_delete_form','javascript:process_information(\'user_delete_form\', \'user_delete_form_submit\', \'user\', null, null, null, null, \'delete_row\');','POST','','Delete User','','','','',0);

/*!40000 ALTER TABLE `form_templates` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table language
# ------------------------------------------------------------

DROP TABLE IF EXISTS `language`;

CREATE TABLE `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original` text NOT NULL,
  `translate` text NOT NULL,
  `lang` varchar(5) NOT NULL DEFAULT 'pt',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `language` WRITE;
/*!40000 ALTER TABLE `language` DISABLE KEYS */;

INSERT INTO `language` (`id`, `original`, `translate`, `lang`)
VALUES
	(1,'Dashboard','Painel','pt'),
	(2,'Admin','Admin','pt'),
	(3,'System','System','pt'),
	(4,'Natural','Natural','pt'),
	(5,'Customer Service','Servico Consumidor','pt'),
	(6,'Provisioning','Provisioning','pt'),
	(7,'Packages','Packages','pt'),
	(8,'My Account','My Account','pt'),
	(9,'Phone Number/Routing','Phone Number/Routing','pt'),
	(10,'Billing','Billing','pt'),
	(11,'Support','Support','pt'),
	(12,'Media','Media','pt'),
	(13,'Devices','Devices','pt'),
	(14,'Lines','Lines','pt'),
	(15,'Mailboxes','Mailboxes','pt'),
	(16,'Features','Features','pt'),
	(17,'Call History','Call History','pt'),
	(18,'How To','How To','pt'),
	(19,'Contact Us','Contact Us','pt'),
	(20,'My Info','My Info','pt'),
	(21,'Partners','Parceiros','pt'),
	(22,'Customer','Cliente','pt'),
	(23,'Phone Numbers','Phone Numbers','pt'),
	(24,'Help','Help','pt'),
	(25,'Menu','Menu','pt'),
	(26,'Cluster','Cluster','pt'),
	(27,'Access Manager','Access Manager','pt'),
	(28,'Device','Device','pt'),
	(29,'Reports','Reports','pt'),
	(30,'Tools','Tools','pt'),
	(31,'Products','Products','pt'),
	(32,'Plan','Plan','pt'),
	(33,'E911','E911','pt'),
	(34,'Providers','Providers','pt'),
	(35,'Rate Table','Rate Table','pt'),
	(36,'Form Manager','Form Manager','pt'),
	(37,'Package','Package','pt'),
	(38,'Contract','Contract','pt'),
	(39,'Order Tracking','Order Tracking','pt'),
	(40,'Trouble Ticket','Trouble Ticket','pt'),
	(41,'Verify','Verify','pt'),
	(42,'Maintenance','Maintenance','pt'),
	(43,'Home','Home','pt'),
	(44,'My Calls','My Calls','pt'),
	(45,'My Orders','My Orders','pt'),
	(46,'Invoices','Invoices','pt'),
	(47,'Users','Users','pt'),
	(48,'Online Contact Management ','Online Contact Management ','pt'),
	(49,'My Phone Number(s)','My Phone Number(s)','pt'),
	(50,'Call Routing','Call Routing','pt'),
	(51,'Docs','Docs','pt'),
	(52,'Fax','Fax','pt'),
	(53,'Call Recording','Call Recording','pt'),
	(54,'Audio Prompt','Audio Prompt','pt'),
	(55,'Payment Method','Payment Method','pt'),
	(56,'Tickets','Tickets','pt'),
	(57,'FAQs','FAQs','pt'),
	(58,'My User','My User','pt'),
	(59,'Admin Users','Admin Users','pt'),
	(60,'Route Profile','Route Profile','pt'),
	(61,'Account Devices','Account Devices','pt'),
	(62,'Voice Mail','Voice Mail','pt'),
	(63,'Account Lines','Account Lines','pt'),
	(64,'Account Mailboxes','Account Mailboxes','pt'),
	(65,'Payment Management','Payment Management','pt'),
	(66,'Conference Plus','Conference Plus','pt'),
	(67,'Transaction History','Transaction History','pt'),
	(68,'My History','My History','pt'),
	(69,'View','View','pt'),
	(70,'Descriptions','Descriptions','pt'),
	(71,'Billing Engine','Billing Engine','pt'),
	(72,'Module Builder','Module Builder','pt'),
	(73,'Populate Language Table','Populate Language Table','pt'),
	(74,'Change Password','Change Password','pt'),
	(75,'My Group','My Group','pt'),
	(76,'List','Listar','pt'),
	(77,'Search','Search','pt'),
	(78,'Search Form','Search Form','pt'),
	(79,'Class/Forms Creator','Class/Forms Creator','pt'),
	(80,'List Forms','List Forms','pt'),
	(81,'Config','Config','pt'),
	(82,'Commission Reports','Commission Reports','pt'),
	(83,'Financial Reports','Financial Reports','pt'),
	(84,'Rate Deck','Rate Deck','pt'),
	(85,'New Account','New Account','pt'),
	(86,'Taxing','Taxing','pt'),
	(87,'Add Service','Add Service','pt'),
	(88,'Change Service','Change Service','pt'),
	(89,'Open Orders','Open Orders','pt'),
	(90,'List SideMenu','List SideMenu','pt'),
	(91,'View levels','View levels','pt'),
	(92,'Edit','Edit','pt'),
	(93,'Add New User','Add New User','pt'),
	(94,'Quick List Reactivation','Quick List Reactivation','pt'),
	(95,'Add New Partner','Add New Partner','pt'),
	(96,'Extension','Extension','pt'),
	(97,'Mailbox','Mailbox','pt'),
	(98,'Assign Device','Assign Device','pt'),
	(99,'Open/Pending Tickets','Open/Pending Tickets','pt'),
	(100,'Add new device','Add new device','pt'),
	(101,'Assign to a User','Assign to a User','pt'),
	(102,'Assign to a Customer','Assign to a Customer','pt'),
	(103,'Completed/Cancelled Orders','Completed/Cancelled Orders','pt'),
	(104,'Customer Export','Customer Export','pt'),
	(105,'Add Phone Number','Add Phone Number','pt'),
	(106,'Add Porting Number','Add Porting Number','pt'),
	(107,'Conference Numbers','Conference Numbers','pt'),
	(108,'Mobile Access Numbers','Mobile Access Numbers','pt'),
	(109,'Upload Prompt','Upload Prompt','pt'),
	(110,'Add Credit Card','Add Credit Card','pt'),
	(111,'View Schedule','View Schedule','pt'),
	(112,'Schedule New','Schedule New','pt'),
	(113,'Credit Limit','Credit Limit','pt'),
	(114,'Pay Now','Pay Now','pt'),
	(115,'Create Transaction','Create Transaction','pt'),
	(116,'User Info','User Info','pt'),
	(117,'New','New','pt'),
	(118,'List Uploader','List Uploader','pt'),
	(119,'Description','Description','pt'),
	(120,'Find me Follow me','Find me Follow me','pt'),
	(121,'Performing a 3 Way Call','Performing a 3 Way Call','pt'),
	(122,'Star Code Listing','Star Code Listing','pt'),
	(123,'Auto Attendant','Auto Attendant','pt'),
	(124,'Ring Group','Ring Group','pt'),
	(125,'Dial Extension','Dial Extension','pt'),
	(126,'Conference','Conference','pt'),
	(127,'Logs','Logs','pt'),
	(128,'Top Ten Usage','Top Ten Usage','pt'),
	(129,'Top Ten Balance','Top Ten Balance','pt'),
	(130,'Conference Plus Directions','Conference Plus Directions','pt'),
	(131,'Change My Password','Change My Password','pt'),
	(132,'Closed Tickets','Closed Tickets','pt'),
	(133,'Manage Trouble Ticket','Manage Trouble Ticket','pt'),
	(134,'Add Trouble Ticket','Add Trouble Ticket','pt'),
	(135,'Add Multiple Phone Numbers','Add Multiple Phone Numbers','pt'),
	(136,'NPA NXX Repository','NPA NXX Repository','pt'),
	(137,'Assign Phone Number','Assign Phone Number','pt'),
	(138,'Persistent Caller ID Block','Persistent Caller ID Block','pt'),
	(139,'Caller ID Block','Caller ID Block','pt'),
	(140,'Last Number Redial','Last Number Redial','pt'),
	(141,'Call Forwarding Always','Call Forwarding Always','pt'),
	(142,'Do Not Disturb','Do Not Disturb','pt'),
	(143,'Call Forward on Busy','Call Forward on Busy','pt'),
	(144,'Call Forward on No Answer','Call Forward on No Answer','pt'),
	(145,'Voicemail Setup','Voicemail Setup','pt'),
	(146,'On-Demand Call Recording','On-Demand Call Recording','pt'),
	(147,'Fax-to-Email Setup','Fax-to-Email Setup','pt'),
	(148,'Auto-Attendant','Auto-Attendant','pt'),
	(149,'Call Forwarding','Call Forwarding','pt'),
	(150,'Voicemail-to-Email','Voicemail-to-Email','pt'),
	(151,'List SubMenu','List SubMenu','pt'),
	(152,'List Main','List Main','pt'),
	(153,'Add New Main Menu Item','Add New Main Menu Item','pt'),
	(154,'Add new form','Add new form','pt'),
	(155,'Edit Form Parameters','Edit Form Parameters','pt'),
	(156,'New User','New User','pt'),
	(157,'New Admin User','New Admin User','pt'),
	(158,'Edit Admin User','Edit Admin User','pt'),
	(159,'Device Information','Device Information','pt'),
	(160,'Device Information','Device Information','pt'),
	(161,'Select Devices','Select Devices','pt'),
	(162,'Schedule new conference call','Schedule new conference call','pt'),
	(163,'Edit Main Menu Item','Edit Main Menu Item','pt'),
	(164,'Add New Sub Menu Item','Add New Sub Menu Item','pt'),
	(165,'Edit Sub Menu Item','Edit Sub Menu Item','pt'),
	(166,'Side Menu Information','Side Menu Information','pt'),
	(167,'Side Meun Information','Side Meun Information','pt'),
	(168,'HIVE Core Module Updates','HIVE Core Module Updates','pt'),
	(169,'Select the Update Type and hit Build Core Update','Select the Update Type and hit Build Core Update','pt'),
	(170,'Partner','Parceiro','pt'),
	(171,'Group','Group','pt'),
	(172,'First Name','Primeiro Nome','pt'),
	(173,'Last Name','Last Name','pt'),
	(174,'Contact','Contact','pt'),
	(175,'Username','Username','pt'),
	(176,'Password','Password','pt'),
	(177,'Access Level','Access Level','pt'),
	(178,'Pin','Pin','pt'),
	(179,'Status','Status','pt'),
	(180,'Time Zone','Time Zone','pt'),
	(181,'Type','Type','pt'),
	(182,'Comission','Comission','pt'),
	(183,'Default Caller','Default Caller','pt'),
	(184,'Permit Sms','Permit Sms','pt'),
	(185,'Sms Credits','Sms Credits','pt'),
	(186,'Preferred Language','Preferred Language','pt'),
	(187,'Allow Vertical Code','Allow Vertical Code','pt'),
	(188,'Allow 411 Directory','Allow 411 Directory','pt'),
	(189,'Website','Website','pt'),
	(190,'Orkut','Orkut','pt'),
	(191,'MySpace','MySpace','pt'),
	(192,'Twitter','Twitter','pt'),
	(193,'Facebook','Facebook','pt'),
	(194,'IM','IM','pt'),
	(195,'ICQ','ICQ','pt'),
	(196,'MSN','MSN','pt'),
	(197,'Yahoo','Yahoo','pt'),
	(198,'Id','Id','pt'),
	(199,'Name','Name','pt'),
	(200,'Location','Location','pt'),
	(201,'Calling Group','Calling Group','pt'),
	(202,'Itsp','Itsp','pt'),
	(203,'Api Key','Api Key','pt'),
	(204,'911 House Number','911 House Number','pt'),
	(205,'Zip','Zip','pt'),
	(206,'State','State','pt'),
	(207,'City','City','pt'),
	(208,'Address','Address','pt'),
	(209,'911 House Number Suffix','911 House Number Suffix','pt'),
	(210,'911 Pre Directional','911 Pre Directional','pt'),
	(211,'911 Street','911 Street','pt'),
	(212,'911 Community','911 Community','pt'),
	(213,'911 Location','911 Location','pt'),
	(214,'Partner Name','Partner Name','pt'),
	(215,'Home Phone','Home Phone','pt'),
	(216,'Work Phone','Work Phone','pt'),
	(217,'Work Phone Extension','Work Phone Extension','pt'),
	(218,'Mobile','Mobile','pt'),
	(219,'Email','Email','pt'),
	(220,'Google Talk','Google Talk','pt'),
	(221,'Instant Messager','Instant Messager','pt'),
	(222,'Web Page','Web Page','pt'),
	(223,'Adress','Adress','pt'),
	(224,'Company','Company','pt'),
	(225,'First Name *','Primeiro Nome *','pt'),
	(226,'Last Name *','Last Name *','pt'),
	(227,'Username *','Username *','pt'),
	(228,'Access Level *','Access Level *','pt'),
	(229,'Pin *','Pin *','pt'),
	(230,'Status *','Status *','pt'),
	(231,'Time Zone *','Time Zone *','pt'),
	(232,'Update User','Update User','pt'),
	(233,'Gtalk','Gtalk','pt'),
	(234,'Email *','Email *','pt'),
	(235,'Mobile Phone *','Mobile Phone *','pt'),
	(236,'Work Extension','Work Extension','pt'),
	(237,'Type your current password','Type your current password','pt'),
	(238,'Type your new password','Type your new password','pt'),
	(239,'Repeat password','Repeat password','pt'),
	(240,'Save Password','Save Password','pt'),
	(241,'User','User','pt'),
	(242,'Allow International Calls','Allow International Calls','pt'),
	(243,'Extension Number','Extension Number','pt'),
	(244,'Caller Number','Caller Number','pt'),
	(245,'Caller Name','Caller Name','pt'),
	(246,'Permit Out of Group Calls','Permit Out of Group Calls','pt'),
	(247,'Caller ID Blocking','Caller ID Blocking','pt'),
	(248,'Protocol','Protocol','pt'),
	(249,'Nat Support','Nat Support','pt'),
	(250,'Video Support','Video Support','pt'),
	(251,'Qualify','Qualify','pt'),
	(252,'Qualify','Qualify','pt'),
	(253,'Primary Codec','Primary Codec','pt'),
	(254,'Primary Codec','Primary Codec','pt'),
	(255,'Secondary Codec','Secondary Codec','pt'),
	(256,'Simultaneous Calls Limit','Simultaneous Calls Limit','pt'),
	(257,'Time before VM Picks Up','Time before VM Picks Up','pt'),
	(258,'Context','Context','pt'),
	(259,'Context','Context','pt'),
	(260,'Ring Timeout','Ring Timeout','pt'),
	(261,'Ring Timeout','Ring Timeout','pt'),
	(262,'Mail Box','Mail Box','pt'),
	(263,'Mac','Mac','pt'),
	(264,'Vendor','Vendor','pt'),
	(265,'Model','Model','pt'),
	(266,'Provisoning Configuration','Provisoning Configuration','pt'),
	(267,'Force Greeting','Force Greeting','pt'),
	(268,'Force Name','Force Name','pt'),
	(269,'ITSP will force every new user to record his/hers name.','ITSP will force every new user to record his/hers name.','pt'),
	(270,'Auto Save or Delete','Auto Save or Delete','pt'),
	(271,'Attatch','Attatch','pt'),
	(272,'Saycid','Saycid','pt'),
	(273,'Delete Voicemail','Delete Voicemail','pt'),
	(274,'If set to \"yes\" the message will be deleted from the voicemailbox (after having been emailed). \r\nThe delete flag, when used alone (instead of with voicemail broadcast), provides functionality that allows a user to receive their voicemail via email alone.','If set to \"yes\" the message will be deleted from the voicemailbox (after having been emailed). \r\nThe delete flag, when used alone (instead of with voicemail broadcast), provides functionality that allows a user to receive their voicemail via email alone.','pt'),
	(275,'Dialout','Dialout','pt'),
	(276,'Callback','Callback','pt'),
	(277,'Review','Review','pt'),
	(278,'Operator','Operator','pt'),
	(279,'Send Voicemail','Send Voicemail','pt'),
	(280,'This setting takes a yes or no value. It enables the \"Leave a message\" menu option from the Advanced Options menu which allows the voicemail user to send a message to another voicemail user.','This setting takes a yes or no value. It enables the \"Leave a message\" menu option from the Advanced Options menu which allows the voicemail user to send a message to another voicemail user.','pt'),
	(281,'Operator Envelop','Operator Envelop','pt'),
	(282,'Operator Envelop','Operator Envelop','pt'),
	(283,'Sendvm','Sendvm','pt'),
	(284,'Envelope','Envelope','pt'),
	(285,'Envelope controls whether or not ITSP will play the message envelope (date/time) before playing the voicemail message.','Envelope controls whether or not ITSP will play the message envelope (date/time) before playing the voicemail message.','pt'),
	(286,'Deletevm','Deletevm','pt'),
	(287,'Deletevm','Deletevm','pt'),
	(288,'Nextaftercmd','Nextaftercmd','pt'),
	(289,'Nextaftercmd','Nextaftercmd','pt'),
	(290,'Forcename','Forcename','pt'),
	(291,'Forcegreeting','Forcegreeting','pt'),
	(292,'Sometimes it is nice to let a caller review their message before committing it to a mailbox. If set to yes, then the caller will be asked to review the message, or save it as is after they have pressed ','','pt'),
	(293,'Partner *','Partner *','pt'),
	(294,'Default Caller Id','Default Caller Id','pt'),
	(295,'E-mail *','E-mail *','pt'),
	(296,'Update Device','Update Device','pt'),
	(297,'Create New Device','Create New Device','pt'),
	(298,'Rule','Rule','pt'),
	(299,'Timeout','Timeout','pt'),
	(300,'Numbers','Numbers','pt'),
	(301,'Override','Override','pt'),
	(302,'OnNoAnswer','OnNoAnswer','pt'),
	(303,'OnBusy','OnBusy','pt'),
	(304,'OnUnavailable','OnUnavailable','pt'),
	(305,'Announce','Announce','pt'),
	(306,'Message','Message','pt'),
	(307,'Select Device','Select Device','pt'),
	(308,'Digit Timeout','Digit Timeout','pt'),
	(309,'Prompt','Prompt','pt'),
	(310,'Replay','Replay','pt'),
	(311,'Direct Dial','Direct Dial','pt'),
	(312,'DTMF 0','DTMF 0','pt'),
	(313,'DTMF 1','DTMF 1','pt'),
	(314,'DTMF 2','DTMF 2','pt'),
	(315,'DTMF 3','DTMF 3','pt'),
	(316,'DTMF 4','DTMF 4','pt'),
	(317,'DTMF 5','DTMF 5','pt'),
	(318,'DTMF 6','DTMF 6','pt'),
	(319,'DTMF 7','DTMF 7','pt'),
	(320,'DTMF 8','DTMF 8','pt'),
	(321,'DTMF 9','DTMF 9','pt'),
	(322,'DTMF *','DTMF *','pt'),
	(323,'Room','Room','pt'),
	(324,'Main Number','Main Number','pt'),
	(325,'Select State','Select State','pt'),
	(326,'Select one Area Code','Select one Area Code','pt'),
	(327,'Phone Number','Phone Number','pt'),
	(328,'Customer Number','Customer Number','pt'),
	(329,'Select Year','Select Year','pt'),
	(330,'Select Month','Select Month','pt'),
	(331,'Caller ID Number','Caller ID Number','pt'),
	(332,'Caller ID Name','Caller ID Name','pt'),
	(333,'Simultaneous Call Paths','Simultaneous Call Paths','pt'),
	(334,'Ringing Timeout','Ringing Timeout','pt'),
	(335,'Cid 911','Cid 911','pt'),
	(336,'Cid Block','Cid Block','pt'),
	(337,'Dnd','Dnd','pt'),
	(338,'Permit  Out of Group','Permit  Out of Group','pt'),
	(339,'Permit Long Distance','Permit Long Distance','pt'),
	(340,'Permit International','Permit International','pt'),
	(341,'Permit 411 Directory','Permit 411 Directory','pt'),
	(342,'Permit Virtual Codes','Permit Virtual Codes','pt'),
	(343,'Call Forwarding On Busy','Call Forwarding On Busy','pt'),
	(344,'Call Forwarding On No Answer','Call Forwarding On No Answer','pt'),
	(345,'Anonymous Call Rejection','Anonymous Call Rejection','pt'),
	(346,'Call Recording Beep','Call Recording Beep','pt'),
	(347,'Admin Pin','Admin Pin','pt'),
	(348,'Dial Out','Dial Out','pt'),
	(349,'Say Caller ID','Say Caller ID','pt'),
	(350,'Attach','Attach','pt'),
	(351,'Attach causes ITSP to copy a voicemail message to an audio file and send it to the user as an attachment in an e-mail voicemail notification message.','Attach causes ITSP to copy a voicemail message to an audio file and send it to the user as an attachment in an e-mail voicemail notification message.','pt'),
	(352,'Email address that will be used by ITSP to send voicemail as an audio file.','Email address that will be used by ITSP to send voicemail as an audio file.','pt'),
	(353,'Password *','Password *','pt'),
	(354,'Can be any NUMBER and will be used by the user to access their voice mail box via phone.','Can be any NUMBER and will be used by the user to access their voice mail box via phone.','pt'),
	(355,'Line 1 User ID','Line 1 User ID','pt'),
	(356,'Line 1 Display Name','Line 1 Display Name','pt'),
	(357,'Line 2 User ID','Line 2 User ID','pt'),
	(358,'Line 2 Display Name','Line 2 Display Name','pt'),
	(359,'Line 3 User ID','Line 3 User ID','pt'),
	(360,'Line 3 Display Name','Line 3 Display Name','pt'),
	(361,'Line 4 User ID','Line 4 User ID','pt'),
	(362,'Line 4 Display Name','Line 4 Display Name','pt'),
	(363,'Line 5 User ID','Line 5 User ID','pt'),
	(364,'Line 5 Display Name','Line 5 Display Name','pt'),
	(365,'Line 6 User ID','Line 6 User ID','pt'),
	(366,'Line 6 Display Name','Line 6 Display Name','pt'),
	(367,'Line 2 Display Name;','Line 2 Display Name;','pt'),
	(368,'Add Payment Profile','Add Payment Profile','pt'),
	(369,'Card Number *','Card Number *','pt'),
	(370,'Expiration Month','Expiration Month','pt'),
	(371,'Expiration Year','Expiration Year','pt'),
	(372,'Card Security Code (CVV)','Card Security Code (CVV)','pt'),
	(373,'Mobile Number','Mobile Number','pt'),
	(374,'Edit Mobile Number','Edit Mobile Number','pt'),
	(375,'Invite the following Participants \r\n<br> <sub>* Maximum of 20 Participants<br>&#8226; For each participant, you must type their number and press enter<br>&#8226; One participant per entry in either of the following formats:<br>&nbsp; &nbsp; &nbsp; &ordm; 2145559874 or John Doe,2145559874<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &sect; Example of inviting participants:<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; \r\nJohn Doe,2145559874<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; \r\n2143335963','Invite the following Participants \r\n<br> <sub>* Maximum of 20 Participants<br>&#8226; For each participant, you must type their number and press enter<br>&#8226; One participant per entry in either of the following formats:<br>&nbsp; &nbsp; &nbsp; &ordm; 2145559874 or John Doe,2145559874<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &sect; Example of inviting participants:<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; \r\nJohn Doe,2145559874<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; \r\n2143335963','pt'),
	(376,'Announce number of participants','Announce number of participants','pt'),
	(377,'Conference Time Zone','Conference Time Zone','pt'),
	(378,'Schedule','Schedule','pt'),
	(379,'Conference Time','Conference Time','pt'),
	(380,'Conference Date','Conference Date','pt'),
	(381,'Add me to the conference via','Add me to the conference via','pt'),
	(382,'Amount','Amount','pt'),
	(383,'Charge this card','Charge this card','pt'),
	(384,'Submit','Submit','pt'),
	(385,'Current Limit','Current Limit','pt'),
	(386,'Update','Update','pt'),
	(387,'If the VM box is active of canceled.','If the VM box is active of canceled.','pt'),
	(388,'Update Mailbox','Update Mailbox','pt'),
	(389,'Mailbox Name','Mailbox Name','pt'),
	(390,'Long Distance Calling','Long Distance Calling','pt'),
	(391,'911 Caller ID','911 Caller ID','pt'),
	(392,'Call Forwarding Busy','Call Forwarding Busy','pt'),
	(393,'Call Forwarding No Answer','Call Forwarding No Answer','pt'),
	(394,'Update Extension','Update Extension','pt'),
	(395,'Please type the customer Number','Please type the customer Number','pt'),
	(396,'Mobile Phone','Mobile Phone','pt'),
	(397,'New Contact','New Contact','pt'),
	(398,'Edit Contact','Edit Contact','pt'),
	(399,'Announce participant on Join/Leave','Announce participant on Join/Leave','pt'),
	(400,'Set participant(s) in \"Listen Only\" mode','Set participant(s) in \"Listen Only\" mode','pt'),
	(401,'Terminate conference when I hangup','Terminate conference when I hangup','pt'),
	(402,'<sub>Example: 2145559874 or Richard Smith, 2145559874</sub>','<sub>Example: 2145559874 or Richard Smith, 2145559874</sub>','pt'),
	(403,'Add Participants','Add Participants','pt'),
	(404,'Title','Title','pt'),
	(405,'Details','Details','pt'),
	(406,'Priority','Priority','pt'),
	(407,'Category','Category','pt'),
	(408,'Assign to','Assign to','pt'),
	(409,'Save','Save','pt'),
	(410,'Comments','Comments','pt'),
	(411,'Public','Public','pt'),
	(412,'Number','Number','pt'),
	(413,'Provider','Provider','pt'),
	(414,'Numbers <br/><sub>One number for each line</sub>','Numbers <br/><sub>One number for each line</sub>','pt'),
	(415,'NPA NXX <br/><sub>(Eg. 222555)</sub>','NPA NXX <br/><sub>(Eg. 222555)</sub>','pt'),
	(416,'NPA','NPA','pt'),
	(417,'NXX','NXX','pt'),
	(418,'Threshold','Threshold','pt'),
	(419,'Available Phone Numbers','Available Phone Numbers','pt'),
	(420,'Year','Year','pt'),
	(421,'Month','Month','pt'),
	(422,'Mailbox Type','Mailbox Type','pt'),
	(423,'Mailbox Number','Mailbox Number','pt'),
	(424,'Alternate E-mail','Alternate E-mail','pt'),
	(425,'Form Id','Form Id','pt'),
	(426,'Form Name','Form Name','pt'),
	(427,'Form Action','Form Action','pt'),
	(428,'Form Method','Form Method','pt'),
	(429,'Form Class','Form Class','pt'),
	(430,'On Submit','On Submit','pt'),
	(431,'Tips','Tips','pt'),
	(432,'Legend','Legend','pt'),
	(433,'Save Form','Save Form','pt'),
	(434,'Level','Level','pt'),
	(435,'Reference','Reference','pt'),
	(436,'Field ID','Field ID','pt'),
	(437,'Field Name','Field Name','pt'),
	(438,'Field Order','Field Order','pt'),
	(439,'Html Type','Html Type','pt'),
	(440,'Default Label','Default Label','pt'),
	(441,'Html Options','Html Options','pt'),
	(442,'Css Class','Css Class','pt'),
	(443,'Data Table','Data Table','pt'),
	(444,'Data Query','Data Query','pt'),
	(445,'Data Sort','Data Sort','pt'),
	(446,'Data Label','Data Label','pt'),
	(447,'Data Value','Data Value','pt'),
	(448,'Field Values','Field Values','pt'),
	(449,'Default Value','Default Value','pt'),
	(450,'Vertical','Vertical','pt'),
	(451,'Click','Click','pt'),
	(452,'Focus','Focus','pt'),
	(453,'Blur','Blur','pt'),
	(454,'Acl','Acl','pt'),
	(455,'OnChange','OnChange','pt'),
	(456,'Prefix','Prefix','pt'),
	(457,'Fieldset Name','Fieldset Name','pt'),
	(458,'Suffix','Suffix','pt'),
	(459,'Tootip Message','Tootip Message','pt'),
	(460,'Required','Required','pt'),
	(461,'Position','Position','pt'),
	(462,'Element Name','Element Name','pt'),
	(463,'Label','Label','pt'),
	(464,'Func','Func','pt'),
	(465,'Module','Module','pt'),
	(466,'Allow Levels','Allow Levels','pt'),
	(467,'User Level','User Level','pt'),
	(468,'Initial','Initial','pt'),
	(469,'Function','Function','pt'),
	(470,'Main Menu','Main Menu','pt'),
	(471,'Main Menu ID','Main Menu ID','pt'),
	(472,'Levels','Levels','pt'),
	(473,'Sub Menu','Sub Menu','pt'),
	(474,'Titlle','Titlle','pt'),
	(475,'Form Reference','Form Reference','pt'),
	(476,'Field','Field','pt'),
	(477,'Form Field Order','Form Field Order','pt'),
	(478,'Build Update','Build Update','pt'),
	(479,'Update Type','Update Type','pt'),
	(480,'Version','Version','pt'),
	(481,'Upload Mysql Updates','Upload Mysql Updates','pt'),
	(482,'Require System Restart','Require System Restart','pt'),
	(483,'Update Asterisk Modules','Update Asterisk Modules','pt'),
	(484,'Campaign Information (All fields are required)','Campaign Information (All fields are required)','pt'),
	(485,'Date and Time','Date and Time','pt'),
	(486,'User Information','User Information','pt'),
	(487,'More','More','pt'),
	(488,'Payment Information','Payment Information','pt'),
	(489,'Customer Information','Customer Information','pt'),
	(490,'Agent Info','Agent Info','pt'),
	(491,'Upload File','Upload File','pt'),
	(492,'Time Information (Use following formats to set the time 8am or 0800 - 9pm or 2100. Use dnc or leave blank on the Start Field for Do Not Call)','Time Information (Use following formats to set the time 8am or 0800 - 9pm or 2100. Use dnc or leave blank on the Start Field for Do Not Call)','pt'),
	(493,'Add Modifiers for Field Last Dial Status','Add Modifiers for Field Last Dial Status','pt'),
	(494,'ACD Basic','ACD Basic','pt'),
	(495,'Advanced Announcements','Advanced Announcements','pt'),
	(496,'Agent Basic','Agent Basic','pt'),
	(497,'Campaign Information','Campaign Information','pt'),
	(498,'Time Information','Time Information','pt'),
	(499,'List of Customers','Lista de Clientes','pt');

/*!40000 ALTER TABLE `language` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL COMMENT 'Parent ID',
  `menu_name` varchar(60) NOT NULL DEFAULT 'main',
  `position` tinyint(20) NOT NULL,
  `element_name` varchar(50) NOT NULL,
  `label` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `func` varchar(50) NOT NULL,
  `module` varchar(20) NOT NULL,
  `allow` varchar(20) DEFAULT 'all',
  `allow_value` varchar(20) NOT NULL DEFAULT '0',
  `status` tinyint(20) NOT NULL DEFAULT '1',
  `icon_class` varchar(60) DEFAULT NULL COMMENT 'Icon based on a specific class for the menu item.',
  `system` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;

INSERT INTO `menu` (`id`, `pid`, `menu_name`, `position`, `element_name`, `label`, `title`, `func`, `module`, `allow`, `allow_value`, `status`, `icon_class`, `system`)
VALUES
	(1,NULL,'main',0,'dashboard_main','Dashboard','Main Dashboard','dashboard_widgets_load_droplets_wrapper','dashboard_widgets','all','0',1,'fa fa-dashboard',1),
	(16,NULL,'main',5,'admin_main','Admin Users','Admin Users','user_list','user','all','0',1,'fa fa-group',1),
	(4,NULL,'main',8,'acl_main','Natural','Natural Framework','list_main_menus','menu_nav','all','0',1,'fa fa-cog',1),
	(47,4,'main',1,'modules','modules','Modules','module_list','natural','all','0',1,'fa fa-archive',1),
	(48,4,'main',2,'forms','forms','Forms','form_list','natural','all','0',1,'fa fa-edit',1),
	(49,4,'main',2,'menu','menu','Menu','menu_list','menu','all','0',1,'fa fa-bars',1),
	(50,48,'main',0,'forms_list','List Forms','List Forms','form_list','natural','all','0',1,'fa fa-edit',1),
	(24,0,'main',17,'support_menu','Support','Support','support_info','natural','all','0',1,'fa fa-phone',0),
	(51,48,'main',3,'forms_example','Form Example','Form Example','natural_form_example','natural','all','0',1,'fa fa-edit',1),
	(52,0,'main',9,'book','Books','Books','book_list','book','all','0',1,'fa fa-book',0),
	(53,48,'main',1,'field_list','List Fields','List Fields','field_list','natural','all','0',1,'fa fa-edit',1),
	(54,48,'main',2,'forms_creator','Create Class/Form','Create Class/Form','class_form_creator_form','natural','all','0',1,'fa fa-edit',1),
	(68,4,'main',3,'dash_widgets','Dashboard Widgets','','dashboard_widgets_list','dashboard_widgets','','',1,'fa fa-puzzle-piece',0);

/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `module`;

CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(40) NOT NULL,
  `module` varchar(60) NOT NULL,
  `label` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `license_quantity` int(11) NOT NULL DEFAULT '0' COMMENT '0=unlimited',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL COMMENT '0=disabled, 1=active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;

INSERT INTO `module` (`id`, `version`, `module`, `label`, `description`, `license_quantity`, `last_update`, `status`)
VALUES
	(1,'1','natural','Natural','Natural',0,'2011-05-13 13:16:14',1),
	(4,'1','acl','Access Control','Access Control',0,'2011-05-13 13:16:14',1),
	(112,'1','dashboard_widgets','Dashboard Widgets','Dashboard Widgets',0,'2014-05-26 15:08:51',1),
	(7,'1','dashboard','Dashboard','Dashboard',0,'2011-05-13 13:16:14',1),
	(14,'1','user','User Management','User Management',0,'2011-05-13 13:16:51',1),
	(109,'1','menu','Menu','Menu',0,'2014-05-25 23:52:30',1),
	(110,'1','book','Book','Book',0,'2014-05-25 21:07:40',1);

/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table select_option
# ------------------------------------------------------------

DROP TABLE IF EXISTS `select_option`;

CREATE TABLE `select_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upstream_name` varchar(40) NOT NULL,
  `value` varchar(40) NOT NULL,
  `description` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `upstream_name_value` (`upstream_name`,`value`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `select_option` WRITE;
/*!40000 ALTER TABLE `select_option` DISABLE KEYS */;

INSERT INTO `select_option` (`id`, `upstream_name`, `value`, `description`)
VALUES
	(7,'enabled_disabled','1','Enabled'),
	(8,'enabled_disabled','0','Disabled'),
	(9,'yes_no','1','Yes'),
	(10,'yes_no','0','No'),
	(78,'user_status','0','Suspended'),
	(79,'user_status','1','Active'),
	(261,'html_type','radio','Radio'),
	(260,'html_type','password','Password'),
	(259,'html_type','message','Message'),
	(258,'html_type','button','Button'),
	(149,'menu_conditions','between','between'),
	(150,'menu_conditions','equal','equal'),
	(151,'menu_conditions','higher','higher'),
	(152,'menu_conditions','lower','lower'),
	(153,'menu_conditions','all','all'),
	(154,'days_of_week','Sun','Sunday'),
	(155,'days_of_week','Mon','Monday'),
	(156,'days_of_week','Tue','Tuesday'),
	(157,'days_of_week','Wed','Wednesday'),
	(158,'days_of_week','Thu','Thursday'),
	(159,'days_of_week','Fri','Friday'),
	(160,'days_of_week','Sat','Saturday'),
	(249,'html_type','text','Text'),
	(239,'hobby','Surfing','Surfing'),
	(240,'hobby','Racing','Racing'),
	(241,'hobby','River rafting','River rafting'),
	(242,'hobby','Hunting','Hunting'),
	(243,'hobby','Scuba diving','Scuba diving'),
	(244,'hobby','Bungee jumping','Bungee jumping'),
	(245,'hobby','Skiing','Skiing'),
	(246,'hobby','Ice skating','Ice skating'),
	(247,'class_form_option','class','Class'),
	(248,'class_form_option','form','Form'),
	(257,'html_type','submit','Submit'),
	(256,'html_type','uploader','Uploader'),
	(255,'html_type','readonly','ReadOnly'),
	(254,'html_type','hidden','Hidden'),
	(253,'html_type','checkbox','Checkbox'),
	(251,'html_type','textarea','Textarea'),
	(250,'html_type','list','List'),
	(184,'states','AK','Alaska'),
	(185,'states','AL','Alabama'),
	(186,'states','AR','Arkansas'),
	(187,'states','AZ','Arizona'),
	(188,'states','CA','California'),
	(189,'states','CO','Colorado'),
	(190,'states','CT','Connecticut'),
	(191,'states','DC','District of Columbia'),
	(192,'states','DE','Delaware'),
	(193,'states','FL','Florida'),
	(194,'states','GA','Georgia'),
	(195,'states','HI','Hawaii'),
	(196,'states','IA','Iowa'),
	(197,'states','ID','Idaho'),
	(198,'states','IL','Illinois'),
	(199,'states','IN','Indiana'),
	(200,'states','KS','Kansas'),
	(201,'states','KY','Kentucky'),
	(202,'states','LA','Louisiana'),
	(203,'states','MA','Massachusetts'),
	(204,'states','MD','Maryland'),
	(205,'states','ME','Maine'),
	(206,'states','MI','Michigan'),
	(207,'states','MN','Minnesota'),
	(208,'states','MO','Missouri'),
	(209,'states','MS','Mississippi'),
	(210,'states','MT','Montana'),
	(211,'states','NC','North Carolina'),
	(212,'states','ND','North Dakota'),
	(213,'states','NE','Nebraska'),
	(214,'states','NH','New Hampshire'),
	(215,'states','NJ','New Jersey'),
	(216,'states','NM','New Mexico'),
	(217,'states','NV','Nevada'),
	(218,'states','NY','New York'),
	(219,'states','OH','Ohio'),
	(220,'states','OK','Oklahoma'),
	(221,'states','OR','Oregon'),
	(222,'states','PA','Pennsylvania'),
	(223,'states','RI','Rhode Island'),
	(224,'states','SC','South Carolina'),
	(225,'states','SD','South Dakota'),
	(226,'states','TN','Tennessee'),
	(227,'states','TX','Texas'),
	(228,'states','UT','Utah'),
	(229,'states','VA','Virginia'),
	(230,'states','VT','Vermont'),
	(231,'states','WA','Washington'),
	(232,'states','WI','Wisconsin'),
	(233,'states','WV','West Virginia'),
	(234,'states','WY','Wyoming'),
	(235,'user_race','caucasian','Caucasian'),
	(236,'user_race','african_american','African American'),
	(237,'user_race','indian','Indian'),
	(238,'user_race','asian','Asian');

/*!40000 ALTER TABLE `select_option` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(200) NOT NULL,
  `access_level` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `language` varchar(2) NOT NULL DEFAULT '',
  `dashboard_1` text NOT NULL,
  `dashboard_2` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `file_id`, `first_name`, `last_name`, `username`, `password`, `email`, `access_level`, `status`, `language`, `dashboard_1`, `dashboard_2`)
VALUES
	(1097,22,'System','Administrator','admin','k»JÓå¼pdî\rÞôò&k','admin@abc.com',81,1,'','a:2:{i:0;a:3:{i:0;s:1:\"1\";i:1;s:1:\"6\";i:2;s:1:\"5\";}i:1;a:3:{i:0;s:1:\"2\";i:1;s:1:\"4\";i:2;s:1:\"3\";}}','b:0;');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
