<?
  session_start();
  require_once('../../bootstrap.php');
  require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
  require_once(NATURAL_CLASSES_PATH.'forms.class.php');
  require_once(NATURAL_CLASSES_PATH.'user.class.php');
  require_once(NATURAL_CLASSES_PATH.'main_menu.class.php');
  require_once(NATURAL_CLASSES_PATH.'sub_menu.class.php');
  require_once(NATURAL_CLASSES_PATH.'side_menu.class.php');
  require_once(NATURAL_CLASSES_PATH.'listview.class.php');
  require_once(NATURAL_LIB_PATH.'errorcodes.lib.php');
  require_once(NATURAL_LIB_PATH.'util.php');
  require_once('menu_nav.func.php');

  if(!$_SESSION['logged']) {
    echo 'LOGOUT';
    exit(0);
  }

  $fn = $_GET['fn'];
	$menu   = new MainMenu();
  $sub    = new SubMenu();
  $side   = new SideMenu();

  switch($fn) {
      case 'update_menu':
        echo update_menu($_GET);
      break;
      case 'list_main_menus':
        echo list_main_menu();
      break;
      case 'update_main_menu':
        echo update_main_menu($_GET);
      break;
      case 'edit_main_menu':
				echo edit_main_menu($_GET);
      break;
      case 'add_new_mainmenu':
				echo add_new_mainmenu();
      break;
      case 'delete_main_menu':
        echo delete_main_menu($_GET);
      break;
      case 'save_main_menu':
        echo save_main_menu($_GET);
      break;
      case 'save_main_menu_config':
        echo save_main_menu_config($_GET);
      break;
      case 'show_subupstream_options':
        echo select_upstream_submenu();
      break;
      case 'list_submenus':
        echo list_submenus($_GET);
      break;
      case 'add_new_submenu':
				echo add_new_submenu($_GET);
      break;
      case 'save_new_submenu':
        echo save_new_submenu($_GET);
      break;
      case 'edit_sub_menu':
				echo edit_sub_menu($_GET);
      break;
      case 'save_sub_menu_config':
        echo save_sub_menu_config($_GET);
      break;
      case 'delete_sub_menu':
        echo delete_sub_menu($_GET);
      break;
      case 'update_sub_menu':
        echo update_sub_menu($_GET);
      break;
      case 'show_sideupstream_options':
        echo select_upstream_sidemenu();
      break;
      case 'list_sidemenus':
        echo list_sidemenus($_GET);
      break;
      case 'add_new_sidemenu':
				echo add_new_sidemenu($_GET);
      break;
      case 'save_new_sidemenu':
        echo save_new_sidemenu($_GET);
      break;
      case 'edit_side_menu':
				echo edit_side_menu($_GET);
      break;
      case 'save_side_menu_config':
        echo save_side_menu_config($_GET);
      break;
      case 'delete_side_menu':
        echo delete_side_menu($_GET);
      break;
      case 'update_side_menu':
        echo update_side_menu($_GET);
      break;
      case 'build_dash_fullscreen_menu':
        echo build_dash_fullscreen_menu($_GET);
        break;
  }
?>
