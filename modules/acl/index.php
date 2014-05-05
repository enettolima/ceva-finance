<?

  session_start();
  require_once('../../bootstrap.php');
  require_once('acl.func.php');

  if(!$_SESSION['logged'])
  {
    echo "LOGOUT";
    exit(0);
  }

  $acl = new AclLevels();
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
