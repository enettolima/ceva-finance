<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('member.controller.php');
if (!$_SESSION['logged']) {
    //Checing session to force logout
    //Processed by process_information on lib/js/controller.js
    echo "LOGOUT";
    exit(0);
}

/*
 * Sending calls to the view
 * Call functions on {yourmodule}.controller.php
 */
switch ($_GET['fn']) {
    case 'member_list':
        echo member_list($_GET['row_id']);
        break;
    case 'member_list_pager':
        print member_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'member_list_sort':
        print member_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'member_list_search':
        print member_list(NULL, $_GET['search']);
        break;
    case 'member_create_form':
        print member_create_form();
        break;
    case 'member_create_form_submit':
        print member_create_form_submit($_GET);
        break;
    case 'member_edit_form':
        print member_edit_form($_GET);
        break;
    case 'member_edit_form_submit':
        print member_edit_form_submit($_GET);
        break;
    case 'member_delete_form':
        print member_delete_form($_GET);
        break;
    case 'member_delete_form_submit':
        print member_delete_form_submit($_GET);
        break;
}
?>
