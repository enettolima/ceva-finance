<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('transaction.controller.php');
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
    case 'transaction_overview':
        echo transaction_overview($_GET['row_id']);
        break;
    case 'transaction_overview_pager':
        print transaction_overview(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'transaction_overview_sort':
        print transaction_overview(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'transaction_overview_search':
        print transaction_overview(NULL, $_GET['search']);
        break;
    case 'transaction_withdraws':
        echo transaction_withdraws($_GET['row_id']);
        break;
    case 'transaction_withdraws_pager':
        print transaction_withdraws(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'transaction_withdraws_sort':
        print transaction_withdraws(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'transaction_withdraws_search':
        print transaction_withdraws(NULL, $_GET['search']);
        break;
    case 'transaction_thithes':
        echo transaction_thithes($_GET['row_id']);
        break;
    case 'transaction_thithes_pager':
        print transaction_thithes(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'transaction_thithes_sort':
        print transaction_thithes(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'transaction_thithes_search':
        print transaction_thithes(NULL, $_GET['search']);
        break;
    case 'transaction_offers':
        echo transaction_offers($_GET['row_id']);
        break;
    case 'transaction_offers_pager':
        print transaction_offers(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'transaction_offers_sort':
        print transaction_offers(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'transaction_offers_search':
        print transaction_offers(NULL, $_GET['search']);
        break;

    case 'transaction_create_form':
        print transaction_create_form();
        break;
    case 'transaction_create_form_submit':
        print transaction_create_form_submit($_GET);
        break;
    case 'transaction_edit_form':
        print transaction_edit_form($_GET);
        break;
    case 'transaction_edit_form_submit':
        print transaction_edit_form_submit($_GET);
        break;
    case 'transaction_delete_form':
        print transaction_delete_form($_GET);
        break;
    case 'transaction_delete_form_submit':
        print transaction_delete_form_submit($_GET);
        break;
}
?>
