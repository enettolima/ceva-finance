<?

  session_start();
  require_once('../../bootstrap.php');
  require_once(NATURAL_LIB_PATH.'errorcodes.lib.php');
  require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
  require_once(NATURAL_LIB_PATH.'spyc.php');
  require_once(NATURAL_LIB_PATH.'util.php');
  require_once('widgets.func.php');

  if(!$_SESSION['logged'])  {
    echo "LOGOUT";
    exit(0);
  }

  if($_GET['fn'])  {
    $fn = $_GET['fn'];
  }
  else {
    $fn = $_POST['fn'];
  }

  switch($fn){
    case 'multiple_select_update_field':
      print multiple_select_update_field($_GET);
      break;
  }


?>
