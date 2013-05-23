<?

  session_start();
  require_once('../../bootstrap.php');
  require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
  require_once(NATURAL_CLASSES_PATH.'forms.class.php');
  require_once(NATURAL_CLASSES_PATH.'user.class.php');
  require_once(NATURAL_CLASSES_PATH.'acl_levels.class.php');
  require_once(NATURAL_CLASSES_PATH.'contact.class.php');
  require_once('acl.class.php');
  require_once('acl.func.php');

  if(!$_SESSION['logged'])
  {
    echo "LOGOUT";
    exit(0);
  }

  $acl = new Acl_levels();
  $acltb = new Acl_levelsTable();
  $fn = $_GET['fn'];

  switch($fn)
  {
    case "view_levels":
      echo view_levels();
    break;
    case "view_access_levels":
      echo view_access_levels();
    break;
    case "update_acl_levels":
      echo update_acl_levels($_GET);
    break;
    case "delete_acl_level":
      echo delete_acl_level($_GET);
    break;
    case "add_new_level":
      echo add_new_level($_GET);
    break;
    case "save_new_level":
      echo save_new_level($_GET);
    break;
  }


?>
