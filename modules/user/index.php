<?php

/**
 * HIVE - Copyleft Open Source Mind, GP
 * Last Modified: Date: 07-18-2009 19:15:01 -0500 (Jul-Sat-2009) $ @ Revision: $Rev: 11 $
 * @package Hive
 */
session_start();
require_once('../../bootstrap.php');
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

    // TODO: REVIEW
    case 'admin_list_users':
        admin_list_users();
        break;
    case 'new_user':
        new_user();
        break;
    case 'save_new_user':
        insert_user($_GET);
        break;
    case 'admin_new_user':
        print admin_new_user();
        break;
    case 'save_new_admin_user':
        insert_user($_GET);
        break;
    case 'reset_user_password':
        reset_user_password($user_id);
        break;
    case 'remove_user':
        print remove_user($user_id);
        break;
    case 'edit_user':
        print edit_user($user_id);
        break;
    case 'edit_logged_user':
        print edit_user_form($_SESSION['log_id']);
        break;
    case 'edit_admin_user':
        print edit_admin_user($user_id);
        break;
    case 'save_edit_admin_user':
        save_edit_user($_GET);
        break;
    case 'change_my_pass':
        print change_my_pass();
        break;
    case 'change_my_password':
        print change_my_password($_GET);
        break;
}
?>
