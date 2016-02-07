<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('withdraw.controller.php');
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
    case 'withdraw_list':
        echo withdraw_list($_GET['row_id']);
        break;
    case 'withdraw_list_pager':
        print withdraw_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'withdraw_list_sort':
        print withdraw_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'withdraw_list_search':
        print withdraw_list(NULL, $_GET['search']);
        break;
    case 'withdraw_create_form':
        print withdraw_create_form();
        break;
    case 'withdraw_create_form_submit':
        print withdraw_create_form_submit($_GET);
        break;
    case 'withdraw_edit_form':
        print withdraw_edit_form($_GET);
        break;
    case 'withdraw_edit_form_submit':
        print withdraw_edit_form_submit($_GET);
        break;
    case 'withdraw_delete_form':
        print withdraw_delete_form($_GET);
        break;
    case 'withdraw_delete_form_submit':
        print withdraw_delete_form_submit($_GET);
        break;
}
?>
