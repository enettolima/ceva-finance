<?
/**
 * User List.
 */
function user_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
	$module = 'user';
	$function = 'user_list';
	$view = new ListView();

	// Row Id for update only row
	if (!empty($row_id)) {
		$row_id = 'u.id = ' . $row_id;
	}
	else {
		$row_id = 'u.id != 0';
	}

	// Search
	if (!empty($search)) {
		$search_fields = array('u.id', 'u.first_name', 'u.last_name', 'u.username');
		$exceptions = array();
		$search_query = build_search_query($search, $search_fields, $exceptions);
	}
	else {
		$search_query = '';
	}

	// Sort
	if (empty($sort)) {
		$sort = 'u.first_name ASC';
	}

	$limit = PAGER_LIMIT; // PAGER_LIMIT
	$start = ($page * $limit) - $limit;

	// Dial List Table Object
	$user = new DataManager();
	$user->dmLoadCustomList("SELECT u.*
		FROM " . NATURAL_DBNAME . ".user u
		WHERE $row_id $search_query
		ORDER BY  $sort
		LIMIT  $start, $limit", 'ASSOC', TRUE);

	if ($user->affected > 0) {
		// Building the header with sorter
		$headers[] = array('display' => 'Id', 'field' => 'u.id');
		$headers[] = array('display' => 'First Name', 'field' => 'u.first_name');
		$headers[] = array('display' => 'Last Name', 'field' => 'u.last_name');
		$headers[] = array('display' => 'Username', 'field' => 'u.username');
		$headers[] = array('display' => 'Edit', 'field' => NULL);
		$headers[] = array('display' => 'Delete', 'field' => NULL);
		$headers = build_sort_header('user_list', 'user', $headers, $sort);

		for ($i = 0; $i < $user->affected; $i++) {
			$j = $i + 1;
			$rows[$j]['row_id'] = $user->data[$i]['id'];
			$rows[$j]['id'] = $user->data[$i]['id'];
			$rows[$j]['first_name'] = $user->data[$i]['first_name'];
			$rows[$j]['last_name'] = $user->data[$i]['last_name'];
			$rows[$j]['username'] = $user->data[$i]['username'];
			$rows[$j]['edit'] = theme_link_process_information('', 'user_edit_form', 'user_edit_form', 'user', array('extra_value' => 'user_id|' . $user->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_EDIT_ICON));
			$rows[$j]['delete'] = theme_link_process_information('', 'user_delete_form', 'user_delete_form', 'user', array('extra_value' => 'user_id|' . $user->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON));
		}
	}

	$options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Users List'),
		'page_subtitle' => translate('Manage Users'),
		'empty_message' => translate('No users were found!'),
		'table_prefix' => theme_link_process_information(translate('Create New User'), 'user_create_form', 'user_create_form', 'user', array('response_type' => 'modal')),
		'pager_items' => build_pager($function, $module, $user->total_records, $limit, $page),
		'page' => $page,
		'sort' => $sort,
		'search' => $search,
		'show_search' => TRUE,
		'function' => $function,
		'module' => $module,
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
  // Select the properly levels
	$access_levels = new DataManager();
	$access_levels->dmLoadCustomList('SELECT al.description, al.level FROM acl_levels al WHERE al.level <= ' . $_SESSION['log_access_level'], 'ASSOC');
	if ($access_levels->affected) {
		$items = array();
		foreach ($access_levels->data as $access_level) {
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
		$user->loadSingle('username = "' . $data['username'] . '"');
    if ($user->affected) {
		  natural_set_message('Username "' . $data['username'] . '" already taken.', 'error');
      return FALSE;
    }
		// Adding values
		$user->first_name 	= $data['first_name'];
		$user->last_name 		= $data['last_name'];
		$user->email 				= $data['email'];
		$user->username 		= $data['username'];
		$user->access_level = $data['access_level'];
		$user->language 		= "en";
		$user->file_id 			= $data["avatar"][0];
		$user->status 			= 1;

		if($data['password']){
			$user->password 	= $data['password'];
			$user->insert(false,false);
			$temp_pass 	      = $data['password'];
		}else{
			$user->insert(true);
			$temp_pass 	      = $user->temp_password;
		}
    if ($user->affected > 0) {
	    natural_set_message('User ' . $data['first_name'] . ' ' . $data['last_name'] . ' was created successfully!', 'success');
	  }
	  return user_list($user->id);
	}
}

/**
 * User Edit Form Builder.
 */
function user_edit_form($user_id) {
  $user = new User();
  $user->loadSingle('id = ' . $user_id);
  if ($user->affected > 0) {
    $frm = new DbForm();
    // Select the properly levels
    $access_levels = new DataManager();
    $access_levels->dmLoadCustomList('SELECT al.description, al.level FROM acl_levels al WHERE al.level <= ' . $_SESSION['log_access_level'], 'ASSOC');
    if ($access_levels->affected) {
      $items = array();
      foreach ($access_levels->data as $access_level) {
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
  $user->loadSingle('id = ' . $data['id']);
  $contact = new Contact();
  $contact->load_single('id = ' . $data['contact_id']);
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
			if($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id') {
				$user->$field = $data[$field];
			}
		}
		foreach ($contact as $field => $value) {
			if($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id') {
				$contact->$field = $data[$field];
			}
		}
    $user->update('id = ' . $data['id']);
		$contact->update('id = ' . $data['contact_id']);
		if ($user->affected > 0) {
		  natural_set_message('User ' . $data['first_name'] . ' ' . $data['last_name'] . ' was updated successfully!', 'success');
		}
		return user_list($data['id']);
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
  $user->loadSingle('id = ' . $user_id);
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
  $user = new User();
  $user->loadSingle('id = ' . $data['id']);
  if ($user->affected > 0) {
    // Remove user
    //$user->remove('id = ' . $data['id']);
    natural_set_message('User ' . $user->first_name . ' ' . $user->last_name . ' was removed successfully!', 'success');
    return $data['id'];
  }
	else {
		natural_set_message('Problems removing user ' . $user->first_name . ' ' . $user->last_name . '!', 'error');
    return FALSE;
  }
}

?>
