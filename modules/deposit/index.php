<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('deposit.controller.php');
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
    case 'deposit_list':
        echo deposit_list($_GET['row_id']);
        break;
    case 'deposit_list_pager':
        print deposit_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'deposit_list_sort':
        print deposit_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'deposit_list_search':
        print deposit_list(NULL, $_GET['search']);
        break;
    case 'deposit_create_form':
        print deposit_create_form();
        break;
    case 'deposit_create_form_submit':
        print deposit_create_form_submit($_GET);
        break;
    case 'deposit_edit_form':
        print deposit_edit_form($_GET);
        break;
    case 'deposit_edit_form_submit':
        print deposit_edit_form_submit($_GET);
        break;
    case 'deposit_delete_form':
        print deposit_delete_form($_GET);
        break;
    case 'deposit_delete_form_submit':
        print deposit_delete_form_submit($_GET);
        break;
}
?>
