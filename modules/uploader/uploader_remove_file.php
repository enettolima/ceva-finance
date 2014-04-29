<?php
  /**
   * @file: uploader_remove_file.php
   * Server Side Ajax Uplader
   */
  session_start();
  require_once('../../bootstrap.php');
  require_once(NATURAL_LIB_PATH . 'util.php');
  require_once(NATURAL_CLASSES_PATH . 'datamanager.class.php');
  require_once(NATURAL_CLASSES_PATH . 'field_templates.class.php');
  require_once(NATURAL_CLASSES_PATH . 'files.class.php');


  // Load file infomartion
  $fid = $_GET['fid'];
  $file = new Files();
  $file->load_single('fid = ' . $fid);
  $filename = $file->filename;
  $uri = $file->uri;
  if (!$file->affected > 0) {
    natural_set_message('Error loading file information.', 'error');
    return FALSE;
  }

  // Remove file
  $file->remove('fid > 0');
  if ($file->affected > 0) {
    unlink(NATURAL_ROOT_PATH . '/' . $uri);
    natural_set_message('File "' . $filename . '" was removed successfully.', 'success');
    $data = array('removed' => TRUE);
    print json_encode($data);
  }
  else {
    natural_set_message('Error remove file record from database.', 'error');
    return FALSE;
  }

?>