<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('dashboard_widgets.controller.php');
if (!$_SESSION['logged']) {
    //Checing session to force logout
    //Processed by process_information on lib/js/controller.js
    echo "LOGOUT";
    exit(0);
}

//Getting function from the jquery call
$fn = $_GET['fn'];

/*
 * Sending calls to the view
 */
switch ($fn) {
    case 'dashboard_widgets_list':
        echo dashboard_widgets_list($_GET['row_id']);
        break;
    case 'dashboard_widgets_list_pager':
        print dashboard_widgets_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'dashboard_widgets_list_sort':
        print dashboard_widgets_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'dashboard_widgets_list_search':
        print dashboard_widgets_list(NULL, $_GET['search']);
        break;
    case 'dashboard_widgets_create_form':
        print dashboard_widgets_create_form();
        break;
    case 'dashboard_widgets_create_form_submit':
        print dashboard_widgets_create_form_submit($_GET);
        break;
    case 'dashboard_widgets_edit_form':
        print dashboard_widgets_edit_form($_GET);
        break;
    case 'dashboard_widgets_edit_form_submit':
        print dashboard_widgets_edit_form_submit($_GET);
        break;
    case 'dashboard_widgets_delete_form':
        print dashboard_widgets_delete_form($_GET);
        break;
    case 'dashboard_widgets_delete_form_submit':
        print dashboard_widgets_delete_form_submit($_GET);
        break;
}
?>
