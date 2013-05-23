<?php
  $uploaddir = 'files/';
  $uploadfile = $uploaddir . basename($_FILES['myfile']['name']);
  if ($_FILES['myfile']['size'] > 20000000) {
    print 'error1';
  }
  else {
    if (move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile)) {
      chmod($uploadfile, 0777);
      print 'success';
    }
    else {
      print 'error2';
    }
  }
?>