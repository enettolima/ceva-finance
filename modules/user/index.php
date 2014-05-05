<?php

/**
 * HIVE - Copyleft Open Source Mind, GP
 * Last Modified: Date: 07-18-2009 19:15:01 -0500 (Jul-Sat-2009) $ @ Revision: $Rev: 11 $
 * @package Hive
 */
session_start();
require_once('../../bootstrap.php');
require_once(NATURAL_CLASSES_PATH . 'datamanager.class.php');
require_once(NATURAL_CLASSES_PATH . 'forms.class.php');
require_once(NATURAL_CLASSES_PATH . 'user.class.php');
require_once(NATURAL_CLASSES_PATH . 'customer.class.php');
require_once(NATURAL_CLASSES_PATH . 'group.class.php');
require_once(NATURAL_CLASSES_PATH . 'acl_levels.class.php');
require_once(NATURAL_CLASSES_PATH . 'listview.class.php');
require_once(NATURAL_CLASSES_PATH . 'contact.class.php');
require_once(NATURAL_LIB_PATH . 'util.php');
require_once(NATURAL_LIB_PATH . 'errorcodes.lib.php');
require_once('user.func.php');

if (!$_SESSION['logged']) {
  echo "LOGOUT";
}

$user_id = $_GET['user_id'];

/*
 * Declare objects here
 */
$user = new User();
switch ($_GET['fn']) {
  case 'user_list':
    print user_list($_GET['row_id']);
    break;
  case 'user_list_pager':
    print user_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
    break;
  case 'user_list_sort':
    print user_list(NULL, $_GET['search'], $_GET['sort'], 1);
    break;
  case 'user_list_search':
    print user_list(NULL, $_GET['search']);
    break;
  case 'user_edit_form':
    print user_edit_form($_GET['user_id']);
    break;
  case 'user_edit_form_submit':
    print user_edit_form_submit($_GET);
    break;
  case 'user_delete_form':
    print user_delete_form($_GET['user_id']);
    break;
  case 'user_delete_form_submit':
    print user_delete_form_submit($_GET);
    break;
  case 'user_create_form':
    print user_create_form();
    break;
  case 'user_create_form_submit':
    print user_create_form_submit($_GET);
    break;
}
?>