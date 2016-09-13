<?php
/**
 * User List.
 */
function user_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
	$view = new ListView();
  // Row Id for update only row
  if (!empty($row_id)) {
    $row_id = 'u.id = ' . $row_id;
  } else {
    $row_id = 'u.id != 0';
  }

  // Sort
  if (empty($sort)) {
    $sort = 'u.first_name, u.last_name asc';
  }

  $limit = PAGER_LIMIT;
  $offset = ($page * $limit) - $limit;
  $total_records = 0;
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);

  // Search
  if (!empty($search)) {
      $search_fields = array('u.id', 'u.first_name', 'u.last_name', 'u.phone_number', 'u.email');
      $exceptions = array();
      $search_query = build_search_query($search, $search_fields, $exceptions);
      $sql = 'select SQL_CALC_FOUND_ROWS  u.`id`, u.`first_name`, u.`last_name`, u.`username`, u.`email`, u.`phone_number`, al.description, al.access_level
						       from church_link cl
									 left outer join users u on u.id = cl.user_id
									 left outer join acl_levels al on al.id = cl.acl_levels_id
						       where cl.church_id = '.$_SESSION['log_church_id'].' and cl.acl_levels_id = 1 and '.$search_query.' order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  } else {
      $sql = 'select SQL_CALC_FOUND_ROWS  u.`id`, u.`first_name`, u.`last_name`, u.`username`, u.`email`, u.`phone_number`, al.description, al.access_level
						       from church_link cl
									 left outer join users u on u.id = cl.user_id
									 left outer join acl_levels al on al.id = cl.acl_levels_id
						       where cl.church_id = '.$_SESSION['log_church_id'].' and cl.acl_levels_id = 1 order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  }
  $total_records = $pdo->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
	if (count($records)) {
		// Building the header with sorter
		$headers[] = array('display' => 'Id', 'field' => 'id');
		$headers[] = array('display' => 'First Name', 'field' => 'first_name');
		$headers[] = array('display' => 'Last Name', 'field' => 'last_name');
		$headers[] = array('display' => 'User Name', 'field' => 'username');
		$headers[] = array('display' => 'Email', 'field' => 'email');
		$headers[] = array('display' => 'Rule', 'field' => 'description');
		$headers[] = array('display' => 'Level', 'field' => 'access_level');
		$headers[] = array('display' => 'Edit', 'field' => NULL);
		$headers[] = array('display' => 'Delete', 'field' => NULL);
		$headers = build_sort_header('church_list', 'church', $headers, $sort);

		foreach( $records as $record ){
			$j = $i + 1;
			//This is important for the row update/delete
			$rows[$j]['row_id']   = $record['id'];
			/////////////////////////////////////////////
			$rows[$j]['id']       = $record['id'];
			$rows[$j]['first_name']     = $record['first_name'];
			$rows[$j]['last_name'] = $record['last_name'];
			$rows[$j]['username']  = $record['username'];
			$rows[$j]['email']  = $record['email'];
			$rows[$j]['description'] = $record['description'];
			$rows[$j]['level'] = $record['access_level'];
			$rows[$j]['edit'] 			= theme_link_process_information('',
				'user_edit_form',
				'user_edit_form',
				'user',
				array('extra_value' => 'user_id|' . $record['id'],
					'response_type' => 'modal',
					'icon' => constant("NATURAL_EDIT_ICON")));
			$rows[$j]['delete'] 		= theme_link_process_information('',
				'user_delete_form',
				'user_delete_form',
				'user',
				array('extra_value' => 'user_id|' . $record['id'],
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

/**
 * User List.
 */
function user_list_visitors($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
	$view = new ListView();
  // Row Id for update only row
  if (!empty($row_id)) {
    $row_id = 'u.id = ' . $row_id;
  } else {
    $row_id = 'u.id != 0';
  }

  // Sort
  if (empty($sort)) {
    $sort = 'u.first_name, u.last_name asc';
  }

  $limit = PAGER_LIMIT;
  $offset = ($page * $limit) - $limit;
  $total_records = 0;
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);

  // Search
  if (!empty($search)) {
      $search_fields = array('u.id', 'u.first_name', 'u.last_name', 'u.phone_number', 'u.email');
      $exceptions = array();
      $search_query = build_search_query($search, $search_fields, $exceptions);
      $sql = 'select SQL_CALC_FOUND_ROWS  u.`id`, u.`first_name`, u.`last_name`, u.`username`, u.`email`, u.`phone_number`, al.description, al.access_level
						       from church_link cl
									 left outer join user u on u.id = cl.user_id
									 left outer join acl_levels al on al.id = cl.acl_levels_id
						       where cl.church_id = '.$_SESSION['log_church_id'].' and cl.acl_levels_id = 1 and '.$search_query.' order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  } else {
      $sql = 'select SQL_CALC_FOUND_ROWS  u.`id`, u.`first_name`, u.`last_name`, u.`username`, u.`email`, u.`phone_number`, al.description, al.access_level
						       from church_link cl
									 left outer join user u on u.id = cl.user_id
									 left outer join acl_levels al on al.id = cl.acl_levels_id
						       where cl.church_id = '.$_SESSION['log_church_id'].' and cl.acl_levels_id = 1 order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  }
  $total_records = $pdo->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
	if (count($records)) {
		// Building the header with sorter
		$headers[] = array('display' => 'Id', 'field' => 'id');
		$headers[] = array('display' => 'First Name', 'field' => 'first_name');
		$headers[] = array('display' => 'Last Name', 'field' => 'last_name');
		$headers[] = array('display' => 'User Name', 'field' => 'username');
		$headers[] = array('display' => 'Email', 'field' => 'email');
		$headers[] = array('display' => 'Phone', 'field' => 'phone_number');
		$headers[] = array('display' => 'Rule', 'field' => 'description');
		$headers[] = array('display' => 'Level', 'field' => 'access_level');
		$headers[] = array('display' => 'Edit', 'field' => NULL);
		$headers[] = array('display' => 'Delete', 'field' => NULL);
		$headers = build_sort_header('user_list_visitors', 'user', $headers, $sort);

		foreach( $records as $record ){
			$j = $i + 1;
			//This is important for the row update/delete
			$rows[$j]['row_id']   = $record['id'];
			/////////////////////////////////////////////
			$rows[$j]['id']       = $record['id'];
			$rows[$j]['first_name']     = $record['first_name'];
			$rows[$j]['last_name'] = $record['last_name'];
			$rows[$j]['username']  = $record['username'];
			$rows[$j]['email']  = $record['email'];
			$rows[$j]['phone_number']  = $record['phone_number'];
			$rows[$j]['description'] = $record['description'];
			$rows[$j]['level'] = $record['access_level'];
			$rows[$j]['edit'] 			= theme_link_process_information('',
				'user_edit_form',
				'user_edit_form',
				'user',
				array('extra_value' => 'user_id|' . $record['id'],
					'response_type' => 'modal',
					'icon' => constant("NATURAL_EDIT_ICON")));
			$rows[$j]['delete'] 		= theme_link_process_information('',
				'user_delete_form',
				'user_delete_form',
				'user',
				array('extra_value' => 'user_id|' . $record['id'],
					'response_type' => 'modal',
					'icon' => constant("NATURAL_REMOVE_ICON"),
					'class' => $class));
	    $i++;
		}
	}
	//count($users)
	$options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Visitors List'),
		'page_subtitle' => translate('Manage Visitors'),
		'empty_message' => translate('No user found!'),
		'table_prefix' => theme_link_process_information(translate('Create New Visitor'),
			'user_create_form',
			'user_create_form',
			'user',
			array('response_type' => 'modal')),
		'pager_items' => build_pager('user_list_visitors', 'user', $total_records, $limit, $page),
		'page' => $page,
		'sort' => $sort,
		'search' => $search,
		'show_search' => TRUE,
		'function' => 'user_list_visitors',
		'module' => 'user',
		'update_row_id' => '',
	  'table_form_id' => '',
		'table_form_process' => '',
	);

	$listview = $view->build($rows, $headers, $options);

  return $listview;
}

/**
 * User List.
 */
function user_list_members($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
	$view = new ListView();
  // Row Id for update only row
  if (!empty($row_id)) {
    $row_id = 'u.id = ' . $row_id;
  } else {
    $row_id = 'u.id != 0';
  }

  // Sort
  if (empty($sort)) {
    $sort = 'u.first_name, u.last_name asc';
  }

  $limit = PAGER_LIMIT;
  $offset = ($page * $limit) - $limit;
  $total_records = 0;
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);

  // Search
  if (!empty($search)) {
      $search_fields = array('u.id', 'u.first_name', 'u.last_name', 'u.phone_number', 'u.email');
      $exceptions = array();
      $search_query = build_search_query($search, $search_fields, $exceptions);
      $sql = 'select SQL_CALC_FOUND_ROWS  u.`id`, u.`first_name`, u.`last_name`, u.`username`, u.`email`, u.`phone_number`, al.description, al.access_level
						       from church_link cl
									 left outer join user u on u.id = cl.user_id
									 left outer join acl_levels al on al.id = cl.acl_levels_id
						       where cl.church_id = '.$_SESSION['log_church_id'].' and cl.acl_levels_id = 2 and '.$search_query.' order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  } else {
      $sql = 'select SQL_CALC_FOUND_ROWS  u.`id`, u.`first_name`, u.`last_name`, u.`username`, u.`email`, u.`phone_number`, al.description, al.access_level
						       from church_link cl
									 left outer join user u on u.id = cl.user_id
									 left outer join acl_levels al on al.id = cl.acl_levels_id
						       where cl.church_id = '.$_SESSION['log_church_id'].' and cl.acl_levels_id = 2 order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  }
  $total_records = $pdo->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
	if (count($records)) {
		// Building the header with sorter
		$headers[] = array('display' => 'Id', 'field' => 'id');
		$headers[] = array('display' => 'First Name', 'field' => 'first_name');
		$headers[] = array('display' => 'Last Name', 'field' => 'last_name');
		$headers[] = array('display' => 'User Name', 'field' => 'username');
		$headers[] = array('display' => 'Email', 'field' => 'email');
		$headers[] = array('display' => 'Phone', 'field' => 'phone_number');
		$headers[] = array('display' => 'Rule', 'field' => 'description');
		$headers[] = array('display' => 'Level', 'field' => 'access_level');
		$headers[] = array('display' => 'Edit', 'field' => NULL);
		$headers[] = array('display' => 'Delete', 'field' => NULL);
		$headers = build_sort_header('user_list_members', 'user', $headers, $sort);

		foreach( $records as $record ){
			$j = $i + 1;
			//This is important for the row update/delete
			$rows[$j]['row_id']   = $record['id'];
			/////////////////////////////////////////////
			$rows[$j]['id']       = $record['id'];
			$rows[$j]['first_name']     = $record['first_name'];
			$rows[$j]['last_name'] = $record['last_name'];
			$rows[$j]['username']  = $record['username'];
			$rows[$j]['email']  = $record['email'];
			$rows[$j]['phone_number']  = $record['phone_number'];
			$rows[$j]['description'] = $record['description'];
			$rows[$j]['level'] = $record['access_level'];
			$rows[$j]['edit'] 			= theme_link_process_information('',
				'user_edit_form',
				'user_edit_form',
				'user',
				array('extra_value' => 'user_id|' . $record['id'],
					'response_type' => 'modal',
					'icon' => constant("NATURAL_EDIT_ICON")));
			$rows[$j]['delete'] 		= theme_link_process_information('',
				'user_delete_form',
				'user_delete_form',
				'user',
				array('extra_value' => 'user_id|' . $record['id'],
					'response_type' => 'modal',
					'icon' => constant("NATURAL_REMOVE_ICON"),
					'class' => $class));
	    $i++;
		}
	}
	//count($users)
	$options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Members List'),
		'page_subtitle' => translate('Manage Members'),
		'empty_message' => translate('No member found!'),
		'table_prefix' => theme_link_process_information(translate('Create New Member'),
			'user_create_form',
			'user_create_form',
			'user',
			array('response_type' => 'modal')),
		'pager_items' => build_pager('user_list_members', 'user', $total_records, $limit, $page),
		'page' => $page,
		'sort' => $sort,
		'search' => $search,
		'show_search' => TRUE,
		'function' => 'user_list_members',
		'module' => 'user',
		'update_row_id' => '',
	  'table_form_id' => '',
		'table_form_process' => '',
	);

	$listview = $view->build($rows, $headers, $options);

  return $listview;
}


/**
 * User List.
 */
function user_list_leaders($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
	$view = new ListView();
  // Row Id for update only row
  if (!empty($row_id)) {
    $row_id = 'u.id = ' . $row_id;
  } else {
    $row_id = 'u.id != 0';
  }

  // Sort
  if (empty($sort)) {
    $sort = 'u.first_name, u.last_name asc';
  }

  $limit = PAGER_LIMIT;
  $offset = ($page * $limit) - $limit;
  $total_records = 0;
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);

  // Search
  if (!empty($search)) {
      $search_fields = array('u.id', 'u.first_name', 'u.last_name', 'u.phone_number', 'u.email');
      $exceptions = array();
      $search_query = build_search_query($search, $search_fields, $exceptions);
      $sql = 'select SQL_CALC_FOUND_ROWS  u.`id`, u.`first_name`, u.`last_name`, u.`username`, u.`email`, u.`phone_number`, al.description, al.access_level
						       from church_link cl
									 left outer join user u on u.id = cl.user_id
									 left outer join acl_levels al on al.id = cl.acl_levels_id
						       where cl.church_id = '.$_SESSION['log_church_id'].' and cl.acl_levels_id > 2 and '.$search_query.' order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  } else {
      $sql = 'select SQL_CALC_FOUND_ROWS  u.`id`, u.`first_name`, u.`last_name`, u.`username`, u.`email`, u.`phone_number`, al.description, al.access_level
						       from church_link cl
									 left outer join user u on u.id = cl.user_id
									 left outer join acl_levels al on al.id = cl.acl_levels_id
						       where cl.church_id = '.$_SESSION['log_church_id'].' and cl.acl_levels_id > 2 order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  }
  $total_records = $pdo->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
	if (count($records)) {
		// Building the header with sorter
		$headers[] = array('display' => 'Id', 'field' => 'id');
		$headers[] = array('display' => 'First Name', 'field' => 'first_name');
		$headers[] = array('display' => 'Last Name', 'field' => 'last_name');
		$headers[] = array('display' => 'User Name', 'field' => 'username');
		$headers[] = array('display' => 'Email', 'field' => 'email');
		$headers[] = array('display' => 'Phone', 'field' => 'phone_number');
		$headers[] = array('display' => 'Rule', 'field' => 'description');
		$headers[] = array('display' => 'Level', 'field' => 'access_level');
		$headers[] = array('display' => 'Edit', 'field' => NULL);
		$headers[] = array('display' => 'Delete', 'field' => NULL);
		$headers = build_sort_header('user_list_leaders', 'user', $headers, $sort);

		foreach( $records as $record ){
			$j = $i + 1;
			//This is important for the row update/delete
			$rows[$j]['row_id']   = $record['id'];
			/////////////////////////////////////////////
			$rows[$j]['id']       = $record['id'];
			$rows[$j]['first_name']     = $record['first_name'];
			$rows[$j]['last_name'] = $record['last_name'];
			$rows[$j]['username']  = $record['username'];
			$rows[$j]['email']  = $record['email'];
			$rows[$j]['phone_number']  = $record['phone_number'];
			$rows[$j]['description'] = $record['description'];
			$rows[$j]['level'] = $record['access_level'];
			$rows[$j]['edit'] 			= theme_link_process_information('',
				'user_edit_form',
				'user_edit_form',
				'user',
				array('extra_value' => 'user_id|' . $record['id'],
					'response_type' => 'modal',
					'icon' => constant("NATURAL_EDIT_ICON")));
			$rows[$j]['delete'] 		= theme_link_process_information('',
				'user_delete_form',
				'user_delete_form',
				'user',
				array('extra_value' => 'user_id|' . $record['id'],
					'response_type' => 'modal',
					'icon' => constant("NATURAL_REMOVE_ICON"),
					'class' => $class));
	    $i++;
		}
	}
	//count($users)
	$options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Leaders List'),
		'page_subtitle' => translate('Manage Leaders'),
		'empty_message' => translate('No leader found!'),
		'table_prefix' => theme_link_process_information(translate('Create New Leader'),
			'user_create_form',
			'user_create_form',
			'user',
			array('response_type' => 'modal')),
		'pager_items' => build_pager('user_list_leaders', 'user', $total_records, $limit, $page),
		'page' => $page,
		'sort' => $sort,
		'search' => $search,
		'show_search' => TRUE,
		'function' => 'user_list_leaders',
		'module' => 'user',
		'update_row_id' => '',
	  'table_form_id' => '',
		'table_form_process' => '',
	);

	$listview = $view->build($rows, $headers, $options);

  return $listview;
}


/**
 * User List.
 */
function user_list_vendors($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
	$view = new ListView();
  // Row Id for update only row
  if (!empty($row_id)) {
    $row_id = 'u.id = ' . $row_id;
  } else {
    $row_id = 'u.id != 0';
  }

  // Sort
  if (empty($sort)) {
    $sort = 'u.first_name, u.last_name asc';
  }

  $limit = PAGER_LIMIT;
  $offset = ($page * $limit) - $limit;
  $total_records = 0;
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);

  // Search
  if (!empty($search)) {
      $search_fields = array('u.id', 'u.first_name', 'u.last_name', 'u.phone_number', 'u.email');
      $exceptions = array();
      $search_query = build_search_query($search, $search_fields, $exceptions);
      $sql = 'select SQL_CALC_FOUND_ROWS  u.`id`, u.`first_name`, u.`last_name`, u.`username`, u.`email`, u.`phone_number`, al.description, al.access_level
						       from church_link cl
									 left outer join user u on u.id = cl.user_id
									 left outer join acl_levels al on al.id = cl.acl_levels_id
						       where cl.church_id = '.$_SESSION['log_church_id'].' and u.vendor = 1 and '.$search_query.' order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  } else {
      $sql = 'select SQL_CALC_FOUND_ROWS  u.`id`, u.`first_name`, u.`last_name`, u.`username`, u.`email`, u.`phone_number`, al.description, al.access_level
						       from church_link cl
									 left outer join user u on u.id = cl.user_id
									 left outer join acl_levels al on al.id = cl.acl_levels_id
						       where cl.church_id = '.$_SESSION['log_church_id'].' and u.vendor = 1 order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  }
  $total_records = $pdo->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
	if (count($records)) {
		// Building the header with sorter
		$headers[] = array('display' => 'Id', 'field' => 'id');
		$headers[] = array('display' => 'First Name', 'field' => 'first_name');
		$headers[] = array('display' => 'Last Name', 'field' => 'last_name');
		$headers[] = array('display' => 'User Name', 'field' => 'username');
		$headers[] = array('display' => 'Email', 'field' => 'email');
		$headers[] = array('display' => 'Phone', 'field' => 'phone_number');
		$headers[] = array('display' => 'Rule', 'field' => 'description');
		$headers[] = array('display' => 'Level', 'field' => 'access_level');
		$headers[] = array('display' => 'Edit', 'field' => NULL);
		$headers[] = array('display' => 'Delete', 'field' => NULL);
		$headers = build_sort_header('user_list_vendors', 'user', $headers, $sort);

		foreach( $records as $record ){
			$j = $i + 1;
			//This is important for the row update/delete
			$rows[$j]['row_id']   = $record['id'];
			/////////////////////////////////////////////
			$rows[$j]['id']       = $record['id'];
			$rows[$j]['first_name']     = $record['first_name'];
			$rows[$j]['last_name'] = $record['last_name'];
			$rows[$j]['username']  = $record['username'];
			$rows[$j]['email']  = $record['email'];
			$rows[$j]['phone_number']  = $record['phone_number'];
			$rows[$j]['description'] = $record['description'];
			$rows[$j]['level'] = $record['access_level'];
			$rows[$j]['edit'] 			= theme_link_process_information('',
				'user_edit_form',
				'user_edit_form',
				'user',
				array('extra_value' => 'user_id|' . $record['id'],
					'response_type' => 'modal',
					'icon' => constant("NATURAL_EDIT_ICON")));
			$rows[$j]['delete'] 		= theme_link_process_information('',
				'user_delete_form',
				'user_delete_form',
				'user',
				array('extra_value' => 'user_id|' . $record['id'],
					'response_type' => 'modal',
					'icon' => constant("NATURAL_REMOVE_ICON"),
					'class' => $class));
	    $i++;
		}
	}
	//count($users)
	$options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Vendors List'),
		'page_subtitle' => translate('Manage Vendors'),
		'empty_message' => translate('No vendor found!'),
		'table_prefix' => theme_link_process_information(translate('Create New Vendor'),
			'user_create_form',
			'user_create_form',
			'user',
			array('response_type' => 'modal')),
		'pager_items' => build_pager('user_list_vendors', 'user', $total_records, $limit, $page),
		'page' => $page,
		'sort' => $sort,
		'search' => $search,
		'show_search' => TRUE,
		'function' => 'user_list_vendors',
		'module' => 'user',
		'update_row_id' => '',
	  'table_form_id' => '',
		'table_form_process' => '',
	);

	$listview = $view->build($rows, $headers, $options);

  return $listview;
}



/**
 * User Create Form.
 */
function user_create_form() {
	$frm = new DbForm();

  // Select the proper levels
	$db = DataConnection::readOnly();
	$access_levels = $db->acl_levels()
		->select('description, level')
		->where('level <= ? ',  $_SESSION['log_access_level']);

	if (count($access_levels) > 0) {
		$items = array();
		foreach ($access_levels as $access_level) {
			$items[] = ucwords($access_level['description']) . '=' . $access_level['level'];
		}
		$frm->access_level_options = implode(';', $items);
	}
  $frm->build('user_create_form', $frm, $_SESSION['log_access_level']);
}

/**
 * User Create Form Submit.
 */
function user_create_form_submit($data) {
  $user = new User();
	// Validate User Fields
	$error = user_validate_fields($data);
  if (!empty($error)) {
		foreach($error as $msg) {
		  natural_set_message($msg, 'error');
		}
    return FALSE;
  }
	else {
		// Verify Username
		$user->byUsername($data['username']);
    if ($user->affected) {
		  natural_set_message('Username "' . $data['username'] . '" already taken.', 'error');
      return FALSE;
    }

		// Adding values
		if($data['password']){
			$user->password 	= $data['password'];
			$gen_pass = false;
		}else{
			$gen_pass = true;
		}

		$res = $user->create(false, $gen_pass, $data);
		if ($res) {
	    natural_set_message('User ' . $data['first_name'] . ' ' . $data['last_name'] . ' was created successfully!', 'success');
	  }
	  return user_list($res->id);
	}
}

/**
 * User Edit Form Builder.
 */
function user_edit_form($user_id) {
  $user = new User();
  $user->byID($user_id);
  if ($user->affected > 0) {
    $frm = new DbForm();
    // Select the properly levels
  	$db = DataConnection::readOnly();
		$access_levels = $db->acl_levels()
			->select('description, level')
			->where('level <= ? ',  $_SESSION['log_access_level']);

		if (count($access_levels) > 0) {
			$items = array();
			foreach ($access_levels as $access_level) {
				$items[] = ucwords($access_level['description']) . '=' . $access_level['level'];
			}

			$user->access_level_options = implode(';', $items);
    }
		// Testing chekboxes
		$user->user_race = array('caucasian', 'asian', 'indian');
		// Testing radio buttons
		//$user->user_race = 'asian';
		// Testing uploader - avatar field with fids
		$user->avatar = array($user->file_id);
    $frm->build('user_edit_form', $user, $_SESSION['log_access_level']);
  }
  else {
		natural_set_message('Problems loading user ' . $user_id, 'error');
	  return FALSE;
  }
}

/**
 * User Edit Form Submit.
 */
function user_edit_form_submit($data) {
	$user = new User();
	$user->byID($data['id']);
  // Validate User Fields
	$error = user_validate_fields($data);
  if (!empty($error)) {
		foreach($error as $msg) {
		  natural_set_message($msg, 'error');
		}
    return FALSE;
  }
	else {
		foreach ($user as $field => $value) {
			if($field != 'dashboard_1' && $field != 'dashboard_2' && $field != 'id') {
				$user->$field = $data[$field];
			}
		}
		$user->dashboard_1 = $user->dashboard_1;
		$user->dashboard_2 = $user->dashboard_2;
		$update = $user->update($data['id']);
		if ($update['code']==200) {
		  natural_set_message('User ' . $data['first_name'] . ' ' . $data['last_name'] . ' was updated successfully!', 'success');
			return user_list($data['id']);
		}else{
			natural_set_message($update['message'], 'error');
		}
	}
}

/**
 * User Validate Fields.
 */
function user_validate_fields($fields) {
	$error = array();
	foreach ($fields as $key => $value) {
	  $field_name = ucwords(str_replace('_', ' ', $key));
    switch ($key) {
      case 'first_name':
      case 'last_name':
			case 'username':
        if (trim($value) == '') {
          $error[] = 'Field ' . $field_name . ' is required!';
        }
        break;
      case 'email':
        if (!(filter_var($value, FILTER_VALIDATE_EMAIL))) {
          $error[] = 'Invalid format for ' . $field_name . ', please insert a valid email!';
        }
        break;
    }
	}
	return $error;
}

/**
 * User Delete Form Builder.
 */
function user_delete_form($user_id) {
	$user = new User();
  $user->byID($user_id);
  if ($user->affected > 0) {
    $frm = new DbForm();
		$user->first_last_name = $user->first_name . ' ' . $user->last_name;
    $frm->build('user_delete_form', $user, $_SESSION['log_access_level']);
  }
  else {
		natural_set_message('Problems loading user ' . $user_id, 'error');
	  return FALSE;
  }
}

/**
 * User Delete Form Submit.
 */
function user_delete_form_submit($data) {
  //$user = new User();
  //$user->loadSingle('id = ' . $data['id']);
	$user = new User();
  $user->byID($data['id']);
  if ($user->affected > 0) {
    // Remove user
    $user->delete($data['id']);
    natural_set_message('User ' . $user->first_name . ' ' . $user->last_name . ' was removed successfully!', 'success');
    return $data['id'];
  }
	else {
		natural_set_message('Problems removing user ' . $user->first_name . ' ' . $user->last_name . '!', 'error');
    return FALSE;
  }
}

?>
