<?
  session_start();
  require_once('bootstrap.php');
  require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
  require_once(NATURAL_CLASSES_PATH.'forms.class.php');
  require_once(NATURAL_CLASSES_PATH.'user.class.php');
  require_once('modules/acl/acl.class.php');

  if(isset($_SESSION['log_id']))
  {
    session_destroy();
  }

  $password       = "";
  $username       = "";
  $error_message  = "Your session expired! You have been logged out";
	require_once(NATURAL_TEMPLATE_PATH . 'login.php');

?>
