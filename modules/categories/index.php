<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('categories.controller.php');
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
    case 'categories_list':
        echo categories_list($_GET['row_id']);
        break;
    case 'categories_list_pager':
        print categories_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'categories_list_sort':
        print categories_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'categories_list_search':
        print categories_list(NULL, $_GET['search']);
        break;
    case 'categories_create_form':
        print categories_create_form();
        break;
    case 'categories_create_form_submit':
        print categories_create_form_submit($_GET);
        break;
    case 'categories_edit_form':
        print categories_edit_form($_GET);
        break;
    case 'categories_edit_form_submit':
        print categories_edit_form_submit($_GET);
        break;
    case 'categories_delete_form':
        print categories_delete_form($_GET);
        break;
    case 'categories_delete_form_submit':
        print categories_delete_form_submit($_GET);
        break;
}
?>
