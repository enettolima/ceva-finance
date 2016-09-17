<?php
	require_once('bootstrap.php');
  $filename = $_GET['filename'];
	if ( ! file_exists('document/' . $filename))
	{
			echo 'file missing';
	}else{
			header('HTTP/1.1 200 OK');
			header('Cache-Control: no-cache, must-revalidate');
			header("Pragma: no-cache");
			header("Expires: 0");
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=$filename");
      if ((is_integer (strpos($user_agent, "msie"))) && (is_integer (strpos($user_agent, "win")))) {
        header( "Content-Disposition: filename=".$filename);
      } else {
        header( "Content-Disposition: attachment; filename=".$filename);
      }
      header( "Content-Description: File Transfer");
      @readfile($file_to_download);
      unlink($file_to_download);
			exit;
	}
?>
