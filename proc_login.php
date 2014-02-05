<?php
session_start();
require_once('bootstrap.php');
require_once(NATURAL_CLASSES_PATH . 'datamanager.class.php');
require_once(NATURAL_CLASSES_PATH . 'forms.class.php');
require_once(NATURAL_CLASSES_PATH . 'user.class.php');
require_once(NATURAL_CLASSES_PATH . 'contact.class.php');
require_once('modules/acl/acl.class.php');
require_once('modules/menu_nav/menu_nav.func.php');

$ACL = new ACL();

$ACL->username = $_POST['username'];
$ACL->password = $_POST['password'];
$ACL->login();

if ($_SESSION['logged']) {
  header('Location: ' . NATURAL_WEB_ROOT . 'dashboard.php');
}
else {
  $error_message = 'Invalid Login Information!';
  $password = '';
  $username = $_POST['username'];
  require_once(NATURAL_TEMPLATE_PATH . 'login.php');
}
?>