<?php
  require_once('bootstrap.php');
  require_once(NATURAL_CLASSES_PATH . 'datamanager.class.php');
  require_once(NATURAL_CLASSES_PATH . 'forms.class.php');

  $find_company = TRUE;
  if ($find_company) {
    if (isset($_SESSION['logged'])) {
      session_destroy();
    }

    if (!empty($_GET['login']) && $_GET['login'] == 'error') {
      $error_message = 'Invalid Login Information!';
    }
    elseif (!empty($_GET['login']) && $_GET['login'] == 'expired') {
      $error_message = 'Your session expired! You have been logged out.';
    }
    else {
      $error_message = '';
    }

    // Twig Login
    $template = $twig->loadTemplate('login.html');
    $template->display(array(
      'project_title' => TITLE,
      'path_to_theme' => THEME_PATH,
      'company' => NATURAL_COMPANY,
      'page' => 'login',
      'error_message' => $error_message,
    ));

  }
  else{
    header('Location: signup.php');
  }
?>
