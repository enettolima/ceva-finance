<?php

  session_start();
  require_once('../../bootstrap.php');
  require_once('acl.func.php');

  if(!$_SESSION['logged'])
  {
    echo "LOGOUT";
    exit(0);
  }

  $acl = new AclLevels();
  $fn = $_GET['fn'];

  switch($fn)
  {
    default:
      echo "Loading ACL";
    break;
  }


?>
