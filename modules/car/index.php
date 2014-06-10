<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('car.controller.php');
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
    case 'car_list':
        echo car_list($_GET['row_id']);
        break;
    case 'car_list_pager':
        print car_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'car_list_sort':
        print car_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'car_list_search':
        print car_list(NULL, $_GET['search']);
        break;
    case 'car_create_form':
        print car_create_form();
        break;
    case 'car_create_form_submit':
        print car_create_form_submit($_GET);
        break;
    case 'car_edit_form':
        print car_edit_form($_GET);
        break;
    case 'car_edit_form_submit':
        print car_edit_form_submit($_GET);
        break;
    case 'car_delete_form':
        print car_delete_form($_GET);
        break;
    case 'car_delete_form_submit':
        print car_delete_form_submit($_GET);
        break;
}
?>
