<?

/**
 * HIVE - Copyleft Open Source Mind, GP 
 * Last Modified: Date: 07-18-2009 19:15:01 -0500 (Jul-Sat-2009) $ @ Revision: $Rev: 11 $ 
 * @package Hive 
 */
session_start();
require_once('../../bootstrap.php');
require_once('natural.controller.php');

if (!$_SESSION['logged']) {
    echo "LOGOUT";
    exit(0);
}

//Getting function
$fn = $_GET['fn'];
switch ($fn) {
    
    case 'natural_form_example':
        print natural_form_example();
        break;
    case 'natural_form_example_submit':
        print natural_form_example_submit($_GET);
        break;
    
    /*
     *For module management
     */
    case "module_list":
        print module_list();
        break;
    case 'module_list_pager':
        print module_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'module_list_sort':
        print module_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'module_list_search':
        print module_list(NULL, $_GET['search']);
        break;
    case 'module_create_form':
        print module_create_form();
        break;
    case 'module_create_form_submit':
        print module_create_form_submit($_GET);
        break;
    case 'module_delete_form':
        print module_delete_form($_GET);
        break;
    case 'module_delete_form_submit':
        print module_delete_form_submit($_GET);
        break;
    
    /*
     * Form management
     */
    case "form_list":
        print form_list();
        break;
    case 'form_list_pager':
        print form_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'form_list_sort':
        print form_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'form_list_search':
        print form_list(NULL, $_GET['search']);
        break;
    case 'form_create_form':
        print form_create_form();
        break;
    case 'form_create_form_submit':
        print form_create_form_submit($_GET);
        break;
    case 'form_edit_form':
        print form_edit_form($_GET);
        break;
    case 'form_edit_form_submit':
        print form_edit_form_submit($_GET);
        break;
    case 'form_delete_form':
        print form_delete_form($_GET);
        break;
    case 'form_delete_form_submit':
        print form_delete_form_submit($_GET);
        break;
    /*
     * Field management
     */
    case "field_list":
        print field_list();
        break;
    case 'field_list_pager':
        print field_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'field_list_sort':
        print field_list(NULL, $_GET['search'], $_GET['sort'], 1);
        break;
    case 'field_list_search':
        print field_list(NULL, $_GET['search']);
        break;
    case 'field_create_form':
        print field_create_form();
        break;
    case 'field_create_form_submit':
        print field_create_form_submit($_GET);
        break;
    case 'field_edit_form':
        print field_edit_form($_GET);
        break;
    case 'field_edit_form_submit':
        print field_edit_form_submit($_GET);
        break;
    case 'field_delete_form':
        print field_delete_form($_GET);
        break;
    case 'field_delete_form_submit':
        print field_delete_form_submit($_GET);
        break;
    case 'class_form_creator_form':
        print class_form_creator_form();
        break;
    case 'class_form_creator_form_submit':
        print class_form_creator_form_submit($_GET);
        break;
    
    /*
     *Old Functions 
     */
    case "add_new_form":
        print $frm->build("form_new");
        break;
    case "save_new_form":
        print save_new_form($_GET);
        break;
    case "edit_form_param":
        print edit_form_param($_GET);
        break;
    case "save_form_param":
        print save_form_param($_GET);
        break;
    case "delete_form":
        print delete_form($_GET);
        break;
    case "edit_form_fields":
        print edit_form_fields($_GET);
        break;
    case "add_new_field":
        print add_new_field($_GET);
        break;
    case "add_field":
        print add_field($_GET);
        break;
    case "edit_field":
        print edit_field($_GET);
        break;
    case "save_form_fields":
        print save_form_fields($_GET);
        break;
    case "delete_field":
        print delete_field($_GET);
        break;
    case "show_table_list":
        print show_table_list();
        break;
    case "create_class":
        if ($_GET['create'] == "class") {
            print create_class($_GET['table_name']);
        } else {
            print create_form($_GET['table_name']);
        }
        break;
    case "delete_field":
        print build_classes($_GET['table_name']);
        break;
    case "search_form_menu":
        print search_form_menu();
        break;
    case "proccess_search":
        print list_forms($_GET);
        break;
}
?>
