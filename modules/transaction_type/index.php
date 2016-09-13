<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('transaction_type.controller.php');
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
    case 'transaction_type_list':
        echo transaction_type_list($_GET['row_id']);
        break;
    case 'transaction_type_list_pager':
        print transaction_type_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'transaction_type_list_sort':
        print transaction_type_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'transaction_type_list_search':
        print transaction_type_list(NULL, $_GET['search']);
        break;
    case 'transaction_type_create_form':
        print transaction_type_create_form();
        break;
    case 'transaction_type_create_form_submit':
        print transaction_type_create_form_submit($_GET);
        break;
    case 'transaction_type_edit_form':
        print transaction_type_edit_form($_GET);
        break;
    case 'transaction_type_edit_form_submit':
        print transaction_type_edit_form_submit($_GET);
        break;
    case 'transaction_type_delete_form':
        print transaction_type_delete_form($_GET);
        break;
    case 'transaction_type_delete_form_submit':
        print transaction_type_delete_form_submit($_GET);
        break;
}
?>
