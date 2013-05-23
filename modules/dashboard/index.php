<?php
  session_start();
  require_once('../../bootstrap.php');
	//HIVE CLASSES
  require_once('dashboard_widgets.inc');
  require_once('dashboard_widgets_admin.func.php');
  require_once('dashboard.func.php');
  
	if(!$_SESSION['logged']) {
    echo 'LOGOUT';
    exit(0);
  }
	
  $fn = $_GET['fn'];
  switch($fn)  {
		case 'dashboard_home':
			echo dashboard_home();
		  break;
    case 'dashboard_update_list':
      dashboard_update_list($_GET);
      break;
    case 'dashboard_setup':
      print dashboard_setup($_GET);
      break;
		case 'system_update':
			echo system_update();
		  break;
		case 'starting_update':
			echo starting_update($_GET);
		  break;
		case 'clean_update_os':
			echo clean_update_os($_GET);
		  break;
		case 'reboot_system':
			echo reboot_system();
		  break;
		case 'reboot_step1':
			echo reboot_step1();
		  break;
		case 'reboot_step2':
			echo reboot_step2();
		  break;
		case 'reboot_step3':
			echo reboot_step3();
		  break;
		case 'unzip_files':
			echo unzip_files($_GET);
		  break;
		case 'update_modules':
			echo update_modules($_GET);
		  break;
		case 'update_db':
			echo update_db($_GET);
		  break;
		case 'clean_folders':
			echo clean_folders($_GET);
		  break;
		case 'finish_update':
			echo finish_update($_GET);
		  break;
		case 'user_change_color':
		  print user_change_color($_GET);
			break;		
		case 'change_console_panel':
		  print change_console_panel($_GET);
			break;		
		case 'build_right_topic_info':
		  print build_right_topic_info($_GET);
			break;		
		case 'back_original_panel':
		  print back_original_panel($_GET);
			break;		
		case 'build_logout_button':
		  print build_logout_button($_GET);
			break;		
		case 'register_license':
		  print register_license($_GET);
			break;		
    case 'show_dashboard_fullscreen_content':
      print show_dashboard_fullscreen_content($_GET);
      break;
    case 'check_if_system_has_rebooted':
      print check_if_system_has_rebooted($_GET);
      break;
    case 'change_dup_num_status':
      print change_dup_num_status($_GET);
      break;
    case 'change_temp_dial_list':
      print change_temp_dial_list($_GET);
      break;
    
    // Admin Functions  for Dashboard Widgets
    case 'dashboard_widgets_list':
			print dashboard_widgets_list();
		break;
    case 'dashboard_widgets_list_pager':
      print dashboard_widgets_list(NULL, $_GET['search_query'], $_GET['sort'], $_GET['pager_current']);
		  break;
		case 'dashboard_widgets_list_sort':
      print dashboard_widgets_list(NULL, $_GET['search_query'], $_GET['sort'], 1);
		  break;
		case 'dashboard_widgets_list_search':
      print dashboard_widgets_list(NULL, $_GET['search_query']);
			break;

    case 'dashboard_widgets_remove':
      print dashboard_widgets_remove($_GET);
      break;

    case 'dashboard_widgets_add_new_form':
      print dashboard_widgets_add_new_form();
      break;
    case 'dashboard_widgets_add_new':
      print dashboard_widgets_add_new($_GET);
      break;
    case 'dashboard_widgets_edit_form':
      print dashboard_widgets_edit_form($_GET);
      break;
    case 'dashboard_widgets_edit':
      print dashboard_widgets_edit($_GET);
      break;  
	}


/*	$sc = new SystemControl();
	$sc->load_single("id!='0' LIMIT 1");
	$url = "license.opensourcemind.net/api.php?request_type=logUpdateDialerVersion&version={$data['new_version']}&apikey={$sc->api_key}";
				
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 0);
	$resp = curl_exec($ch);

	curl_close ($ch);*/

?>
