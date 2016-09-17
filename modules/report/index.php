<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('report.controller.php');
if (!$_SESSION['logged']) {
    //Checing session to force logout
    //Processed by process_information on lib/js/controller.js
    echo "LOGOUT";
    exit(0);
}

//Getting function from the jquery call
if($_GET['fn'])  {
  $fn = $_GET['fn'];
}
else {
  $fn = $_POST['fn'];
}
/*
 * Sending calls to the view
 * Call functions on {yourmodule}.controller.php
 */
switch ($_GET['fn']) {
    case 'report_list':
        echo report_list($_GET['row_id']);
        break;
    case 'report_list_pager':
        print report_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'report_list_sort':
        print report_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'report_list_search':
        print report_list(NULL, $_GET['search']);
        break;
    case 'report_create_form':
        print report_create_form();
        break;
    case 'report_create_form_submit':
        print report_create_form_submit($_GET);
        break;
    case 'report_edit_form':
        print report_edit_form($_GET);
        break;
    case 'report_edit_form_submit':
        print report_edit_form_submit($_GET);
        break;
    case 'report_delete_form':
        print report_delete_form($_GET);
        break;
    case 'report_delete_form_submit':
        print report_delete_form_submit($_GET);
        break;
    case 'report_contribution':
        print report_contribution($_GET);
        break;
    case 'report_withdraw':
        print report_withdraw($_GET);
        break;
    case 'report_pdf':
        print report_pdf($_POST);
        break;
}
?>
