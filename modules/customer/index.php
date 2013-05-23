<?
/** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 07-18-2009 19:15:01 -0500 (Jul-Sat-2009) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

  session_start();
  require_once('../../bootstrap.php');
  require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
  require_once(NATURAL_CLASSES_PATH.'contact.class.php');
  require_once(NATURAL_CLASSES_PATH.'listview.class.php');
  require_once(NATURAL_LIB_PATH.'util.php');
  require_once(NATURAL_LIB_PATH.'errorcodes.lib.php');
  require_once('../dashboard/dashboard_widgets.inc');
  require_once('../dashboard/dashboard.func.php');
  require_once('customer.func.php');
  
  if(!$_SESSION['logged'])  {
    echo "LOGOUT";
    exit;
  }

  $fn = $_GET['fn'];
//	$customer_id = $_GET['customer_id'];
//  $form_name = $_GET['form_name'];
  $type = $_GET['type'];
	$form_values = $_GET['form_values'];

  /*
    *Declare objects here
   */

  switch($fn)  {
    case 'customer_list':
			echo customer_list();
      break;
    case 'customer_list_pager':
      print customer_list(NULL, $_GET['search_query'], $_GET['sort'], $_GET['pager_current']);
		  break;
		case 'customer_list_sort':
      print customer_list(NULL, $_GET['search_query'], $_GET['sort'], 1);
		  break;
		case 'customer_list_search':
      print customer_list(NULL, $_GET['search_query']);
			break;
    case 'delete_customer':
      echo delete_customer($_GET);
      break;
    case 'export_customers':
      echo export_customers();
      break;
    case 'update_customer_status':
      echo update_customer_status($_GET);
      break;
    case "view_customer_info":
      echo view_customer_info();
      break;
    case "auth_wowwe_customer":
      echo auth_wowwe_customer($_GET);
      break;
    case 'customer_account_form_save':
		  $data = customer_account_form_save($type, $form_values);
			print json_encode($data);
	    break;
    case "edit_contact_information":
      echo edit_contact_information($_GET);
      break;
    case "update_contact_info":
      echo update_contact_info($_GET);
      break;
  }
?>
