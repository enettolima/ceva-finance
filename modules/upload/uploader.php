<?php
  session_start();
  require_once('../../bootstrap.php');
  require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
  require_once(NATURAL_LIB_PATH . 'util.php');

  // Based on the button id $_GET['button_id'] we can perform validations TODO: also uplaoded to a specifc directory

  $uploaddir = 'tmp_files/';
  $uploadfile = $uploaddir . basename($_FILES['myfile']['name']);
  if ($_FILES['myfile']['size'] > 20000000) {
    natural_set_message('File is too big.', 'error');
    return FALSE;
  }
  else {
    //die(print_r($_FILES));
    if (move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile)) {
      chmod($uploadfile, 0777);
      natural_set_message('File "' . $_FILES['myfile']['name'] . '" was uploaded successfully!', 'success');
      print 'uploaded';
    }
    else {
      natural_set_message('File was not uploaded.', 'error');
      return FALSE;
    }
  }
?>