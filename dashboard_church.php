<?php
session_cache_expire(25);
session_start();
require_once('bootstrap.php');
require_once('modules/dashboard_widgets/dashboard_widgets.controller.php');
require_once('modules/dashboard_widgets/dashboard_widgets_blocks.php');

$username = $_SESSION['log_username'];
$version = NATURAL_VERSION;
$_SESSION['dash_type'] = 2;

$church = new Church();
$church->byID($_SESSION['log_church_id']);
$user_full_name = $_SESSION['log_first_name'] . ' ' . $_SESSION['log_last_name'] . ' ('.$church->name.')';

$db = DataConnection::readOnly();
$q = $db->files[$_SESSION['log_file_id']];
if(count($q) > 0) {
	$avatar = $q['uri'];
}else{
	$avatar = "files/images/avatar/user.png";
}

$menu = new Menu();
$menu_html = $twig->render(
			'menu.html',
			array(
				'links' => $menu->byLevel('church', $_SESSION['log_access_level']),
				'first' => TRUE,
			)
		);

$template = $twig->loadTemplate('base.html');
$template->display(array(
			'project_title' => TITLE,
			'path_to_theme' => THEME_PATH,
			'company' => NATURAL_COMPANY,
			'version' => $version,
			'page' => 'dashboard-main',
			'menu' => $menu_html,
	    	'avatar' => $avatar,
			'admin' => true,
			'skin' => 'skin-light-blue',
			'show_profile_button' => true,
			'admin_profile_button' => false,
			'user_header' => 'user-header-company',
			'skin_profile' => 'bg-light-blue',
			'user_full_name' => $user_full_name,
			'username' => $username,
			'actual_date' => date('F jS, Y'),
			// Dashboard - Passing default variables to content.html
			'page_title' => 'Dashboard',
			'page_subtitle' => 'Widgets',
			'content' =>  dashboard_content() //Loading dashboard widgets from modules/dashboard_widgets/dashboard_widgets.controller.php
		));
?>
