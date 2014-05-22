<?php

/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('book.controller.php');


if (!$_SESSION['logged']) {
    //Checing session to force logout
    //Processed by process_information on lib/js/controller.js
    echo "LOGOUT";
    exit;
}
//Getting function from the jquery call
$fn = $_GET['fn'];

/*
 * Sending calls to the view
 */
switch ($fn) {
    case 'book_list':
        echo book_list();
        break;
    case 'book_list_pager':
        print book_list(NULL, $_GET['search_query'], $_GET['sort'], $_GET['pager_current']);
        break;
    case 'book_list_sort':
        print book_list(NULL, $_GET['search_query'], $_GET['sort'], 1);
        break;
    case 'book_list_search':
        print book_list(NULL, $_GET['search_query']);
        break;
    case 'book_edit_form':
        print book_edit_form($_GET);
        break;
    case 'book_edit':
        print book_edit($_GET);
        break;
    case 'book_add_form':
        print book_add_form($_GET);
        break;
    case 'book_add':
        print book_add($_GET);
        break;
    case 'book_delete':
        print book_delete($_GET);
        break;
}
?>
