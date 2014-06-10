<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-21-2013 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('dashboard_widgets.controller.php');
require_once('dashboard_widgets_blocks.php');
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
    case 'dashboard_widgets_load_droplets_wrapper':
        print dashboard_widgets_load_droplets_wrapper();
        break;
    case 'dashboard_widgets_load_droplets':
        print dashboard_widgets_load_droplets();
        break;
    case 'dashboard_update_list':
        dashboard_update_list($_GET);
        break;
    case 'dashboard_setup':
        print dashboard_setup($_GET);
        break;
    /*
     *Calling functions at dashboard_widgets_blocks.php
     */
    case 'donut_example':
        print donut_example($_GET);
        break;
    case 'area_graph_example':
        print area_graph_example($_GET);
        break;
    case 'bar_graph_example':
        print bar_graph_example($_GET);
        break;
    case 'line_chart_example':
        print line_chart_example($_GET);
        break;
    case 'period_chart_example':
        print period_chart_example($_GET);
        break;
    case 'bar_chart_example':
        print bar_chart_example($_GET);
        break;    
}
?>
