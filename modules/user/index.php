<?

/**
 * HIVE - Copyleft Open Source Mind, GP
 * Last Modified: Date: 07-18-2009 19:15:01 -0500 (Jul-Sat-2009) $ @ Revision: $Rev: 11 $
 * @package Hive
 */
session_start();
require_once('../../bootstrap.php');
require_once(NATURAL_CLASSES_PATH . 'datamanager.class.php');
require_once(NATURAL_CLASSES_PATH . 'forms.class.php');
require_once(NATURAL_CLASSES_PATH . 'user.class.php');
require_once(NATURAL_CLASSES_PATH . 'customer.class.php');
require_once(NATURAL_CLASSES_PATH . 'group.class.php');
require_once(NATURAL_CLASSES_PATH . 'acl_levels.class.php');
require_once(NATURAL_CLASSES_PATH . 'listview.class.php');
require_once(NATURAL_CLASSES_PATH . 'contact.class.php');
require_once(NATURAL_CLASSES_PATH . 'panel.class.php');
require_once(NATURAL_LIB_PATH . 'util.php');
require_once(NATURAL_LIB_PATH . 'errorcodes.lib.php');
require_once('user.func.php');


if (!$_SESSION['logged']) {
    echo "LOGOUT";
}

$fn = $_GET['fn'];
$user_id = $_GET['user_id'];

/*
 * Declare objects here
 */
$user = new User();
switch ($fn) {
    case 'user_list':
        print user_list();
        break;
    case 'user_list_pager':
        print user_list($_GET['search'], $_GET['sort'], $_GET['page']);
        break;
    case 'user_list_sort':
        print user_list($_GET['search'], $_GET['sort'], 1);
        break;
    case 'user_list_search':
        print user_list($_GET['search']);
        break;
    case 'user_admin_edit_form':
        print user_admin_edit_form($_GET['user_id']);
        break;

    case 'admin_list_users':
        admin_list_users();
        break;
    case 'new_user':
        new_user();
        break;
    case 'save_new_user':
        insert_user($_GET);
        break;
    case 'admin_new_user':
        print admin_new_user();
        break;
    case 'save_new_admin_user':
        insert_user($_GET);
        break;
    case 'reset_user_password':
        reset_user_password($user_id);
        break;
    case 'remove_user':
        print remove_user($user_id);
        break;
    case 'edit_user':
        print edit_user($user_id);
        break;
    case 'edit_logged_user':
        print edit_user_form($_SESSION['log_id']);
        break;
    case 'edit_admin_user':
        print edit_admin_user($user_id);
        break;
    case 'save_edit_user':
        save_edit_user($_GET);
        break;
    case 'save_edit_admin_user':
        save_edit_user($_GET);
        break;
    case 'change_my_pass':
        print change_my_pass();
        break;
    case 'change_my_password':
        print change_my_password($_GET);
        break;
}
?>
