<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('church.controller.php');
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
    case 'church_list':
        echo church_list($_GET['row_id']);
        break;
    case 'church_list_pager':
        print church_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'church_list_sort':
        print church_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'church_list_search':
        print church_list(NULL, $_GET['search']);
        break;
    case 'church_create_form':
        print church_create_form();
        break;
    case 'church_create_form_submit':
        print church_create_form_submit($_GET);
        break;
    case 'church_edit_form':
        print church_edit_form($_GET);
        break;
    case 'church_edit_form_submit':
        print church_edit_form_submit($_GET);
        break;
    case 'church_delete_form':
        print church_delete_form($_GET);
        break;
    case 'church_delete_form_submit':
        print church_delete_form_submit($_GET);
        break;
}
?>
