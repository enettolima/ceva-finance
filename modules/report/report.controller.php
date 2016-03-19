<?php
/*
 * Function to build the reports based on the type of the report
 */
function build_filter_form($data){
	global $twig;
	switch($data['fn']){
		case 'totals_per_month_menu':
			break;
		case 'totals_per_month_menu':
			break;
		case 'member_contributions_menu':
			$menu_html = $twig->render(
				'report_monthly_menu.html',
				array(
					'links' => $menu->byLevel('main', $_SESSION['log_access_level']),
					'first' => TRUE,
				)
			);
			break;

		case 'totals_per_month_menu':
			$menu_html = $twig->render(
				'report_monthly_menu.html',
				array(
					'links' => $menu->byLevel('main', $_SESSION['log_access_level']),
					'first' => TRUE,
				)
			);
			break;
	}




	// Twig Base
	$template = $twig->loadTemplate('content.html');
	$template->display(array(
		// Dashboard - Passing default variables to content.html
		'page_title' => 'Dashboard',
		'page_subtitle' => 'Widgets',
    'content' => $menu_html //Loading dashboard widgets
	));

	//print $template;
}

/*
 * User List.
 */
function user_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
	$view = new ListView();

	// Row Id for update only row
	if (!empty($row_id)) {
		$row_id = 'id = ' . $row_id;
	} else {
		$row_id = 'id != 0';
	}

	// Sort
	if (empty($sort)) {
		$sort = 'first_name ASC';
	}

	$limit = PAGER_LIMIT; // PAGER_LIMIT
	$offset = ($page * $limit) - $limit;
	$db = DataConnection::readOnly();
	$total_records = 0;

	// Search
	if (!empty($search)) {
		$search_fields = array('id', 'first_name', 'last_name', 'username');
		$exceptions = array();
		$search_query = build_search_query($search, $search_fields, $exceptions);

		$users = $db->user()
		->where($row_id)
		->and($search_query)
		->order($sort)
		->limit($limit, $offset);
	} else {
		$users = $db->user()
		->where($row_id)
		->order($sort)
		->limit($limit, $offset);
	}

	$total_records = $db->user()->count("*");
	if (count($users) > 0) {
		// Building the header with sorter
		$headers[] = array('display' => 'Id', 'field' => 'id');
		$headers[] = array('display' => 'First Name', 'field' => 'first_name');
		$headers[] = array('display' => 'Last Name', 'field' => 'last_name');
		$headers[] = array('display' => 'Username', 'field' => 'username');
		$headers[] = array('display' => 'Edit', 'field' => NULL);
		$headers[] = array('display' => 'Delete', 'field' => NULL);
		$headers = build_sort_header('user_list', 'user', $headers, $sort);

		$i = 0;
		foreach( $users as $user ){
			$class = "";
			if($user['username'] == "admin"){
				$class = "disabled";
			}
			//This is important for the row update
			$rows[$i]['row_id'] 		= $user['id'];
			$rows[$i]['id'] 				= $user['id'];
			$rows[$i]['first_name']	= $user['first_name'];
			$rows[$i]['last_name'] 	= $user['last_name'];
			$rows[$i]['username'] 	= $user['username'];
			$rows[$i]['edit'] 			= theme_link_process_information('',
				'user_edit_form',
				'user_edit_form',
				'user',
				array('extra_value' => 'user_id|' . $user['id'],
					'response_type' => 'modal',
					'icon' => constant("NATURAL_EDIT_ICON")));
			$rows[$i]['delete'] 		= theme_link_process_information('',
				'user_delete_form',
				'user_delete_form',
				'user',
				array('extra_value' => 'user_id|' . $user['id'],
					'response_type' => 'modal',
					'icon' => constant("NATURAL_REMOVE_ICON"),
					'class' => $class));
			$i++;
		}
	}

	//count($users)
	$options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Users List'),
		'page_subtitle' => translate('Manage Users'),
		'empty_message' => translate('No user found!'),
		'table_prefix' => theme_link_process_information(translate('Create New User'),
			'user_create_form',
			'user_create_form',
			'user',
			array('response_type' => 'modal')),
		'pager_items' => build_pager('user_list', 'user', $total_records, $limit, $page),
		'page' => $page,
		'sort' => $sort,
		'search' => $search,
		'show_search' => TRUE,
		'function' => 'user_list',
		'module' => 'user',
		'update_row_id' => '',
	  'table_form_id' => '',
		'table_form_process' => '',
	);

	$listview = $view->build($rows, $headers, $options);

  return $listview;
}


?>
