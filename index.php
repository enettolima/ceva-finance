<?php
  require_once('bootstrap.php');
  require_once(NATURAL_CLASSES_PATH . 'datamanager.class.php');
  require_once(NATURAL_CLASSES_PATH . 'forms.class.php');

  $find_company = TRUE;
  if ($find_company) {
    if (isset($_SESSION['logged'])) {
      session_destroy();
    }

    // Twig Login
    $template = $twig->loadTemplate('login.html');
    $template->display(array(
      'project_title' => TITLE,
      'path_to_theme' => THEME_PATH,
      'company' => NATURAL_COMPANY,
      'page' => 'login',

    ));

  }
  else{
    header('Location: signup.php');
  }
?>
