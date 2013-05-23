<?

  session_start();
  require_once('bootstrap.php');
  require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
  require_once(NATURAL_LIB_PATH.'util.php');
	require_once('modules/acl/acl.class.php');
  require_once('modules/acl/acl.func.php');
	
	// In order to get the functions used for billing
  require_once('modules/menu_nav/menu_nav.func.php');
	require_once('modules/dashboard/dashboard_widgets.inc');
  require_once('modules/dashboard/dashboard.func.php');
	require_once('modules/customer/customer.func.php');

  $user   = new User();
  $selected_customer   = new Customer();
  $frm    = new DbForm();
  $show_dashboard = 0;
  //$usertb = new UserTable();

  if($_SESSION['log_username']){
		$module         = new Module();
		$module->load_single("module='dashboard' LIMIT 1");
		$_SESSION['dialer-version'] = NATURAL_VERSION . ' - r.' . $module->version;
//		$content 				= dashboard_home();
		$menu 					= menu_constructor($_SESSION['log_access_level'], $show_dashboard);
		$loginname      = $_SESSION['log_first_name'] . ' ' .$_SESSION['log_last_name'];
		$version        = NATURAL_VERSION . ' - r.' . $module->version;
		$loginname      = 'User: ' . $loginname;
    $actual_date    = date('F jS, Y');
		$_SESSION['log_interface'] = "orange";
    $_SESSION['dash_type']     = 2;

/*    $menu_main_left = build_login_mainmenu($_SESSION['log_access_level'], $show_dashboard);
    $menu_submenu   = build_login_submenu($_SESSION['log_access_level'], $show_dashboard);
		$menu_side_menu = build_login_sidemenu($_SESSION['log_access_level'], $show_dashboard);*/
    
    //$user->load_single("id='{$_SESSION['log_id']}'");
    //$user->dataquery = "id=\'1\'";

    //$content        = $frm->build("user_view",$user, $_SESSION['log_access_level']);

		$selected_customer->load_single("id='{$_SESSION['selected_customer_id']}'");

    if($_SESSION['log_access_level']>42 && substr($_SERVER['SCRIPT_NAME'],-8)=="dash.php"){
			
			switch($selected_customer->status){
				case 0:
					$status_name = "Cancelled";
					break;
				case 1:
					$status_name = "Active";
					break;
				case 2:
					$status_name = "Suspended";
					break;
				case 3:
					$status_name = "House";
					break;
			}

			$account_topic    = "Account Number: {$_SESSION['selected_customer_id']} / Account Name: {$selected_customer->name} / Account Status: {$status_name}";
      $back_link      = "<a href='dashboard.php'>Back to Admin</a>";
      $content        = view_customer_info();
    }elseif(is_customer_suspended()){
			$account_topic    = "Account Number: {$_SESSION['selected_customer_id']} / Account Name: {$selected_customer->name} / Account Status: {$status_name}";
      //$back_link      = "<a href='dashboard.php'>Back to Admin</a>";
      $content = customer_suspended_interface();
		}else{
      $_SESSION['selected_customer_id'] = $_SESSION['log_customer_id'];
      $selected_customer->load_single("id='{$_SESSION['selected_customer_id']}'");
      //$back_link = "Account Number:".$_SESSION['selected_customer_id']." Account Name: ".$selected_customer->name." Account Status {$status_name} <a href='dashboard.php'>Back to Admin</a>";
//    $back_link      = "<a href='dashboard.php'>Back to Admin</a>";
      //$back_link = "Account Number: ".$_SESSION['selected_customer_id']." - Account Name: ".$selected_customer->name;
			$account_topic    = "Account Number: {$_SESSION['selected_customer_id']} / Account Name: {$selected_customer->name} / Account Status: {$status_name}";
      $content        = view_customer_info();
    }
		require_once(NATURAL_TEMPLATE_PATH . 'main.php');
  }else{
    $error_message  = "Invalid Login Information!";
    $password       = "";
    $username       = $_POST['username'];
    //header( 'Location: index.php' ) ;
		require_once(NATURAL_TEMPLATE_PATH . 'login.php');
  }

?>
