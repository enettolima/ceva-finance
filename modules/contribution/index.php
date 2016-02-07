<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('contribution.controller.php');
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
    case 'contribution_list':
        echo contribution_list($_GET['row_id']);
        break;
    case 'contribution_list_pager':
        print contribution_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'contribution_list_sort':
        print contribution_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'contribution_list_search':
        print contribution_list(NULL, $_GET['search']);
        break;
    case 'contribution_create_form':
        print contribution_create_form();
        break;
    case 'contribution_create_form_submit':
        print contribution_create_form_submit($_GET);
        break;
    case 'contribution_edit_form':
        print contribution_edit_form($_GET);
        break;
    case 'contribution_edit_form_submit':
        print contribution_edit_form_submit($_GET);
        break;
    case 'contribution_delete_form':
        print contribution_delete_form($_GET);
        break;
    case 'contribution_delete_form_submit':
        print contribution_delete_form_submit($_GET);
        break;
}
?>
