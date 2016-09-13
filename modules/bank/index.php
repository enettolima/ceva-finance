<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('bank.controller.php');
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
    case 'bank_list':
        echo bank_list($_GET['row_id']);
        break;
    case 'bank_list_pager':
        print bank_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'bank_list_sort':
        print bank_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'bank_list_search':
        print bank_list(NULL, $_GET['search']);
        break;
    case 'bank_create_form':
        print bank_create_form();
        break;
    case 'bank_create_form_submit':
        print bank_create_form_submit($_GET);
        break;
    case 'bank_edit_form':
        print bank_edit_form($_GET);
        break;
    case 'bank_edit_form_submit':
        print bank_edit_form_submit($_GET);
        break;
    case 'bank_delete_form':
        print bank_delete_form($_GET);
        break;
    case 'bank_delete_form_submit':
        print bank_delete_form_submit($_GET);
        break;
}
?>
