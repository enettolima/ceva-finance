<?

/**
 * HIVE - Copyleft Open Source Mind, GP 
 * Last Modified: Date: 07-18-2009 19:15:01 -0500 (Jul-Sat-2009) $ @ Revision: $Rev: 11 $ 
 * @package Hive 
 */
session_start();
require_once('../../bootstrap.php');
require_once('natural.func.php');

if (!$_SESSION['logged']) {
    echo "LOGOUT";
    exit(0);
}

$fn = $_GET['fn'];

/*
 * Declare objects here
 */
$frm = new DbForm();
switch ($fn) {
    case "list_forms":
        echo list_forms($_GET);
        break;
    case "add_new_form":
        echo $frm->build("form_new");
        break;
    case "save_new_form":
        echo save_new_form($_GET);
        break;
    case "edit_form_param":
        echo edit_form_param($_GET);
        break;
    case "save_form_param":
        echo save_form_param($_GET);
        break;
    case "delete_form":
        echo delete_form($_GET);
        break;
    case "edit_form_fields":
        echo edit_form_fields($_GET);
        break;
    case "add_new_field":
        echo add_new_field($_GET);
        break;
    case "add_field":
        echo add_field($_GET);
        break;
    case "edit_field":
        echo edit_field($_GET);
        break;
    case "save_form_fields":
        echo save_form_fields($_GET);
        break;
    case "delete_field":
        echo delete_field($_GET);
        break;
    case "show_table_list":
        echo show_table_list();
        break;
    case "create_class":
        if ($_GET['create'] == "class") {
            echo create_class($_GET['table_name']);
        } else {
            echo create_form($_GET['table_name']);
        }
        break;
    case "delete_field":
        echo build_classes($_GET['table_name']);
        break;
    case "search_form_menu":
        echo search_form_menu();
        break;
    case "proccess_search":
        echo list_forms($_GET);
        break;
}
?>
