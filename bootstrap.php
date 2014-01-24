<?php
  define('NATURAL_ROOT_PATH', dirname(__FILE__));
  if (file_exists(NATURAL_ROOT_PATH . '/bootstrap.dev.php')) {
    require(NATURAL_ROOT_PATH . '/bootstrap.dev.php');
  }
  else {
    /* Define system defaults and main configuration */

    //SET HIVE INTO DEVELOPMENT MODE
    //CHANGE TO FALSE WHEN RUNNING
    //IN PRODUCTION ENVIRONMENT
    define('NATURAL_DEV_MODE', FALSE);
    define('ENABLE_COLOR_CHANGE', FALSE);

    //SET APPLICATION PATHS
    define('NATURAL_WEB_ROOT', './');
    define('TITLE', 'Clean Project');
    define('NATURAL_ROOT_PATH', dirname(__FILE__));
    define('NATURAL_LIB_PATH', NATURAL_ROOT_PATH . '/lib/');
    define('NATURAL_CLASSES_PATH', NATURAL_ROOT_PATH . '/lib/classes/');
    define('NATURAL_IMAGE_PATH', NATURAL_ROOT_PATH . '/media/images/');
    define('NATURAL_911WSDL_PATH', NATURAL_ROOT_PATH . '/lib/wsdl/');
    define('NATURAL_TEMPLATE_PATH', NATURAL_ROOT_PATH . '/themes/moonlight/');
    define('TEMPLATE', 'themes/moonlight/');
    define('PAGER_LIMIT', 25);

    //Auloaders
    require_once('classloader.php');

    //SET FORMS/MENUS TABLES
    define('FORM_TABLE', 'form_parameters');
    define('FIELD_TABLE', 'field_templates');
    define('FIELDSET_TABLE', 'fieldsets');
    define('MAIN_MENU_TABLE', 'main_menu');
    define('SUB_MENU_TABLE', 'sub_menu');
    define('SIDE_MENU_TABLE', 'side_menu');
    define('MODULES_TABLE', 'module');

    //E-MAIL SENDER
    define('NATURAL_EMAIL_SENDER', 'noreply@natural.net');

    //WEBSITE DOMAIN
    define('NATURAL_DOMAIN', 'https://www.natural.net');

    //COMPANY NAME
    define('NATURAL_COMPANY', 'Open Source Mind LLC');

    //PLATFORM NAME
    define('NATURAL_PLATFORM', 'Clean Project');

    //LOAD ERROR MESSAGE LIBRARY
    require_once(NATURAL_LIB_PATH . 'errorcodes.lib.php');
    require_once(NATURAL_LIB_PATH . 'util.func.php');

    //Define primary Database Name
    define('NATURAL_DBNAME', 'clean_repo');

    //SET PRODUCTION DATABASE INFORMATION
    define('NATURAL_DBHOST', '65.99.233.14');
    define('NATURAL_DBUSER', 'hiveadmin');
    define('NATURAL_DBPASS', '090909');

    //SET MAGIC KEY
    define('NATURAL_MAGIC_KEY', '68eKAgHqaS2mY5VCfE1jdPATwEfU5DD7R0nzCJ2cdnhgA32Ym21U');

    //SET API KEY
    define('NATURAL_API_KEY', 'b1076550323b21a1652922e64dfad6d7');

    //SET HIVE REVISION FROM SVN
    $svnid = substr('$Rev: 12 $', 6);
    $svnid = intval(substr($svnid, 0, strlen($svnid) - 2));
    define('NATURAL_REVISION', $svnid);

    //SET HIVE CURRENT VERSION
    define('NATURAL_VERSION', 'Clean Project 1.0');
  }
?>
