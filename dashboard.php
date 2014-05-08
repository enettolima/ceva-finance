<?php
session_cache_expire(25);
session_start();
require_once('bootstrap.php');

if ($_SESSION['log_username']) {
	$_SESSION['dash_type'] = 1;
	$module = new Module();
	$module->load_single("module='dashboard' LIMIT 1");
	$_SESSION['dialer-version'] = NATURAL_VERSION . ' - r.' . $module->version;
	$username = $_SESSION['log_username'];
	$user_full_name = $_SESSION['log_first_name'] . ' ' . $_SESSION['log_last_name'];
	$version = NATURAL_VERSION . ' - r.' . $module->version;
	$_SESSION['log_interface'] = 'skin-gray';

	$menu = new Menu();
	// Twig Menu
	$menu = $twig->render(
		'menu.html',
		array(
			'links' => $menu->byLevel('main', $_SESSION['log_access_level']),
			'first' => TRUE,
		)
	);

	// Twig Base
	$template = $twig->loadTemplate('base.html');
	$template->display(array(
		'project_title' => TITLE,
		'path_to_theme' => THEME_PATH,
		'company' => NATURAL_COMPANY,
		'version' => $version,
		'page' => 'dashboard',
		'menu' => $menu,
    'avatar' => $avatar,
		'user_full_name' => $user_full_name,
		'username' => $username,
		'actual_date' => date('F jS, Y'),
		// Dashboard - Passing default variables to content.html
		'page_title' => 'Dashboard',
		'page_subtitle' => 'Widgets',
		'content' => '<div id="myfirstchart"></div>', // TODO: Call function that builds dashboard widgets
	));
}
else {
  $error_message = 'Invalid Login Information!';
  $password = '';
  $username = $_POST['username'];
  require_once('index.php');
}
?>
