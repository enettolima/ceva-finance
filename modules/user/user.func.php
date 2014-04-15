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
		$sort = 'u.first_name DESC';
	}

	$limit = 2; // PAGER_LIMIT
	$start = ($page * $limit) - $limit;
	// Dial List Table Object
	$user = new DataManager();
	$user->dm_load_custom_list("SELECT u.*
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
			//$rows[$j]['delete'] = theme_link_process_information('', 'user_delete_form', 'user_delete_form', 'user', array('extra_value' => 'user_id|' . $user->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON));
			$rows[$j]['delete'] = theme_link_process_information('', '', 'user_delete_form_submit', 'user', array('extra_value' => 'user_id|' . $user->data[$i]['id'], 'response_type' => 'delete_row', 'icon' => NATURAL_REMOVE_ICON, 'ask_confirm' => 'Are you sure you want to delete user: ' . $user->data[$i]['first_name'] . ' ' . $user->data[$i]['last_name']));
		}
	}

	$options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Users List'),
		'page_subtitle' => translate('Manage Users'),
		'empty_message' => translate('No users were found!'),
		'pager_items' => build_pager($function, $module, $user->total_records, $limit, $page),
		'page' => $page,
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
 * User Edit Form Builder.
 */
function user_edit_form($user_id) {
  $user = new User();
  $user->load_single('id = ' . $user_id);
  if ($user->affected > 0) {
    $frm = new DbForm();
    // Contact info
    $contact = new Contact();
    $contact->load_single('id = ' . $user->contact_id);
    foreach ($contact as $field => $value) {
      if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id') {
        $user->$field = $value;
      }
    }
    // Select the properly levels
    $access_levels = new DataManager();
    $access_levels->dm_load_custom_list('SELECT al.description, al.level FROM acl_levels al WHERE al.level <= ' . $_SESSION['log_access_level'], 'ASSOC');
    if ($access_levels->affected) {
      $items = array();
      foreach ($access_levels->data as $access_level) {
        $items[] = ucwords($access_level['description']) . '=' . $access_level['level'];
      }
      $user->access_level_options = implode(';', $items);
    }
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
  $user->load_single('id = ' . $data['id']);
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
			$msg =  'User ' . $data['first_name'] . ' ' . $data['last_name'] . ' was updated successfully!';
		  natural_set_message($msg, 'success');
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
        if (trim($value) == '') {
          $error[] = 'Field ' . $field_name . ' is required!';
        }
        break;
      case 'pin':
        if (!is_numeric($value)) {
          $error[] = 'Invalid format for ' . $field_name . '!';
        }
        if (strlen($value) != 4) {
          $error[] = 'Only 4 digits for ' . $field_name . '!';
        }
        break;
      case 'default_caller_id':
      case 'home_phone':
      case 'home_phone':
      case 'work_phone':
      case 'work_extension':
      case 'mobile_phone':
      case 'fax':
        // Mobile phone is required
        if ($value == '' && $key == 'mobile_phone') {
          $error[] = 'Field ' . $field_name . ' is required!';
        }
        // If there is a value, make the validation if is a valid 10 digits phone number
        if ($value) {
          if (!is_numeric($value)) {
            $error[] = 'Invalid format for ' . $field_name . '!';
          }
      		elseif (strlen($value) != 10 || substr($value, 0, 1) < 2) {
            $error[] = 'Invalid format for ' . $field_name . ', please insert a valid phone number!';
          }
        }
        break;
      case 'email':
        if (!(isValidEmail($value))) {
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
  $user->load_single('id = ' . $user_id);
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
  $user->load_single('id = ' . $data['user_id']);
  if ($user->affected > 0) {
    // Remove contact
    $contact = new Contact();
    //$contact->remove('id = ' . $user->contact_id);
    // Remove user
    //$user->remove('id = ' . $data['id']);
    natural_set_message('User ' . $user->first_name . ' ' . $user->last_name . ' was removed successfully!', 'success');
    return $data['user_id'];
  }
	else {
		natural_set_message('Problems removing user ' . $user->first_name . ' ' . $user->last_name . '!', 'error');
    return FALSE;
  }
}








// TODO: Review Code
/**
 * Create new users inside the account management
 */
function new_user() {
    $user = new User();
    $customer = new Customer();
    $frm = new DbForm();
    $customer->load_single('id = ' . $_SESSION['selected_customer_id']);
    $user->partner_id = $customer->partner_id;
    $user->customer_id = $customer->id;
    $user->contact_id = $customer->contact_id;
    $user->time_zone = $customer->time_zone;
    // Select the properly levels
    $access_levels = new DataManager();
    $access_levels->dm_load_custom_list('SELECT al.description, al.level FROM acl_levels al WHERE al.level <= 41 ORDER BY al.level', 'ASSOC');
    if ($access_levels->affected) {
        $items = array();
        foreach ($access_levels->data as $access_level) {
            $items[] = ucwords($access_level['description']) . '=' . $access_level['level'];
        }
        $user->access_level_options = implode(';', $items);
    }
    $form = $frm->build('customer_user_new', $user, $_SESSION['log_access_level']);
    print $form;
}

/**
 * Create new admin users
 */
function admin_new_user() {
    $user = new User();
    $customer = new Customer();
    $frm = new DbForm();
 /*
    // Select the properly levels
    $access_levels = new DataManager();
    $access_levels->dm_load_custom_list('SELECT al.description, al.level FROM acl_levels al WHERE al.level <= ' . $_SESSION['log_access_level'] . ' AND al.level > 41 ORDER BY al.level', 'ASSOC');
    if ($access_levels->affected) {
        $items = array();
        foreach ($access_levels->data as $access_level) {
            $items[] = ucwords($access_level['description']) . '=' . $access_level['level'];
        }
        $user->access_level_options = implode(';', $items);
    }
   $gt = new Geolocation();
    $gt->load_list("ASSOC", "country='US' GROUP BY timezone");
    if ($gt->affected > 0) {
        $items = array();
        for ($i = 0; $i < $gt->affected; $i++) {
            $items[] = $gt->data[$i]['timezone'] . '=' . $gt->data[$i]['timezone'];
        }
    }
    $timezone_list = implode(';', $items);
    $user->timezone_list = $timezone_list;*/
    return $frm->build('admin_user_new', $user, $_SESSION['log_access_level'], FALSE);
}

/**
 * Done by Paulo, rewritten by Lemu on October 15th, 2009
 */
function insert_user($data) {
    $user = new User();
    $contact = new Contact();
    $user->load_single('username = "' . $data['username'] . '"');
    if ($user->affected) {
        echo 'ERROR|' . USER_ALREADYEXIST_CODE . '|' . USER_ALREADYEXIST_MESG;
        exit();
    }
    $error = '';
    // List fields from the table, and get the correspondent item from  $_GET
    $user_fields = new DataManager();
    $user_fields->dm_load_custom_list('DESCRIBE user', 'ASSOC');
    foreach ($user_fields->data as $user_field) {
        $field = $user_field['Field'];
        $error .= validate_user_fields($field, $data[$field]);
        $user->$field = $data[$field];
    }
    $contact_fields = new DataManager();
    $contact_fields->dm_load_custom_list('DESCRIBE contact', 'ASSOC');
    foreach ($contact_fields->data as $contact_field) {
        $field = $contact_field['Field'];
        $error .= validate_user_fields($field, $data[$field]);
        $contact->$field = $data[$field];
    }

    if ($error != '') {
        print 'ERROR||<br>' . $error;
        exit;
    } else {
        $temp_password = $user->random();
        $user->password = $temp_password;
        $to = $contact->email;
        $headers = 'From: noreply@hivevoicecloud.com' . "\n" .
                'Reply-To: noreply@hivevoicecloud.com' . "\n" .
                'X-Mailer: PHP/' . phpversion();
        $subject = "Your User has been Created!";
        $message = "Dear " . $user->first_name . " " . $user->last_name . " Your Hive Voice Cloud login information has been created as follows:\n
                Username: " . $user->username . " \n
                Password: " . $temp_password . "\n\r

                Enjoy, \n\r

                Hive Voice Cloud Team.";

        if (mail($to, $subject, $message, $headers)) {
            $contact->insert();
            $user->status = 1;
            $user->contact_id = $contact->id;
            $user->insert();
            print 'User ' . $data['first_name'] . ' ' . $data['last_name'] . ' was saved successfully!';
            if ($_GET['fn'] == 'save_new_admin_user') {
                print admin_list_users();
            }
        } else {
            print 'ERROR||User was not created! A mail delivering problem has ocurred!';
        }
    }
}

/**
 * Build the form to change the logged user password
 */
function change_my_pass() {
    $frm = new DbForm();
    return $frm->build('change_user_pass');
}

/**
 * This function changes the password of the user, done by Paulo and reviewed by Lemu
 * October 14th, 2009
 */
function change_my_password($data) {
    $old_pass = $data['old_pass'];
    $new_pass1 = $data['pass1'];
    $new_pass2 = $data['pass2'];
    $NATURAL_key = NATURAL_MAGIC_KEY;
    if (!$new_pass1) {
        return 'ERROR|' . INVALID_NEW_PASSWORD_CODE . '|' . INVALID_NEW_PASSWORD_MESG;
    }
    if (strlen($new_pass1) < 4) {
        return 'ERROR|' . INVALID_NEW_PASSWORD_LENGTH_CODE . '|' . INVALID_NEW_PASSWORD_LENGTH_MESG;
    }
    if ($new_pass1 != $new_pass2) {
        return 'ERROR|' . INVALID_NEW_PASSWORD_CODE . '|' . INVALID_NEW_PASSWORD_MESG;
    }
    $user = new User();
    $user->load_single("id = '{$_SESSION['log_id']}' AND password=AES_ENCRYPT('{$old_pass}','{$NATURAL_key}') LIMIT 1");

    if ($user->affected < 1) {
        $user = new User();
        $user->load_single("id = " . $_SESSION['log_id'] . " AND password='" . sha1(md5(trim($old_pass))) . "' LIMIT 1");
    }
    if ($user->affected) {
        $user->password = $new_pass1;
        $user->update('id = ' . $_SESSION['log_id']);
        if ($user->error) {
            return 'ERROR|' . $people->errorcode . '|' . $people->error;
        } else {
            return PASSWORD_CHANGED_MESG;
        }
    } else {
        return 'ERROR|' . PASSWORD_NOTFOUND_CODE . '|' . PASSWORD_NOTFOUND_MESG;
    }
}

/**
 * Function Done by Paulo, Reviewed by Lemu on October 6, 2009
 * This function will be a sample for lists with twigs March 4, 2014
 */
function admin_list_users() {
  $user = new User();
  $view = new ListView();

  // Selecting users higher than 41 and lower than the actual logged user level
  $user->load_list('ASSOC', 'access_level > 41 AND access_level <= ' . $_SESSION['log_access_level']);

  $headers[] = 'ID';
  $headers[] = 'Name';
  $headers[] = 'Username';
  $headers[] = 'Timezone';
  $headers[] = 'Reset Password';
  $headers[] = 'Edit';
  $headers[] = 'Delete';

	$empty_message = '';

  if ($user->affected > 0) {
    $total = 0;
    for ($i = 0; $i < $user->affected; $i++) {
      $j = $i + 1;
      $rows[$j][0] = $user->data[$i]['id'];
      $rows[$j][1] = $user->data[$i]['first_name'] . ' ' . $user->data[$i]['last_name'];
      $rows[$j][2] = $user->data[$i]['username'];
      $rows[$j][3] = $user->data[$i]['time_zone'];
      $rows[$j][4] = '<a class="refresh-icon pointer" onclick="proccess_information(\'admin_list_users\', \'reset_user_password\', \'user\', \'Are you sure you want to reset this user`s password?\', \'user_id|' . $user->data[$i]['id'] . '\');">Reload</a>';
      //$rows[$j][5] = '<img id="edit_admin_user_'.$user->data[$i]['id'].'" class="edit_admin_user pointer" src="'.TEMPLATE.'images/edit-16x16.gif" onclick="proccess_information(\'admin_user_edit\', \'edit_admin_user\', \'user\', \'\', \'user_id|'.$user->data[$i]['id'].'\');">';
      $rows[$j][5] = '<a class="edit-icon pointer" onclick="proccess_information(\'admin_user_edit\', \'edit_admin_user\', \'user\', \'\', \'user_id|' . $user->data[$i]['id'] . '\', \'\', this, \'slide\');">Edit</a>';
      $rows[$j][6] = '<a class="delete-icon pointer" onclick="proccess_information(null, \'remove_user\', \'user\', \'Are you sure you want to remove this user?\', \'user_id|' . $user->data[$i]['id'] . '\', null, this, \'remove_row\');">Delete</a>';
      $total++;
   }
  }
	else {
		$empty_message = translate('No users were found!');
	}


	$options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Admin Users'),
		'page_subtitle' => translate('Manage All Users'),
		'empty_message' => $empty_message,
		'show_pagination' => TRUE,
	);

  $listview = $view->build($rows, $headers, $options);

  return $listview;
}

/**
 * Reset User Password
 */
function reset_user_password($user_id) {
    $user = new User();
    $user->load_single('id = ' . $user_id);
    $temp_password = $user->random();
//	$user->password = sha1(md5($temp_password));
    $user->password = $temp_password;
    $contact = new Contact();
    $contact->load_single('id = ' . $user->contact_id);

    $to = $contact->email;
    $headers = 'From: ' . NATURAL_EMAIL_SENDER . "\n" .
            'Reply-To: ' . NATURAL_EMAIL_SENDER . "\n" .
            'X-Mailer: PHP/' . phpversion();

    $subject = 'Your password has been reset!';
    $message = "Dear " . $user->first_name . " " . $user->last_name . " Your " . NATURAL_PLATFORM . " login information has been changed as follows:\n
Your Username is: " . $user->username . "
Your new password is:" . $temp_password . "\n\r

Regards, \n\r

" . NATURAL_PLATFORM;
    if (mail($to, $subject, $message, $headers)) {
        $user->update('id = ' . $user_id);
        print 'Password for the user ' . $user->first_name . ' ' . $user->last_name . ' has been reset!';
    } else {
        print 'ERROR||Problems reseting the password. A mail delivering problem has ocurred!';
    }
}

/**
 * Remove User by Lemu on October 7, 2009
 */
function remove_user($user_id) {
    $user = new User();
    $user->load_single('id = ' . $user_id);
    if ($user->affected > 0) {
        // Update extension (put 0 for user_id)
        $extensions = new Extension();
        $extensions->load_list('ASSOC', 'user_id = ' . $user_id);
        if ($extensions->affected > 0) {
            foreach ($extensions->data as $extension) {
                $ext = new Extension();
                $ext->load_single('id = ' . $extension['id']);
                $ext->user_id = 0;
                $ext->password = '';
                $ext->update('id = ' . $extension['id']);
            }
        }
        // Update mailbox (put 0 for user_id)
        $mailboxes = new Mailbox();
        $mailboxes->load_list('ASSOC', 'user_id = ' . $user_id);
        if ($mailboxes->affected > 0) {
            foreach ($mailboxes->data as $mailbox) {
                $mail = new Mailbox();
                $mail->load_single('id = ' . $mailbox['id']);
                $mail->user_id = 0;
                $mail->update('id = ' . $mailbox['id']);
            }
        }
        // Update devices (put 0 for user_id)
        $devices = new Device();
        $devices->load_list('ASSOC', 'user_id = ' . $user_id);
        if ($devices->affected > 0) {
            foreach ($devices->data as $device) {
                $dev = new Device();
                $dev->load_single('id = ' . $device['id']);
                $dev->user_id = 0;
                $dev->update('id = ' . $device['id']);
            }
        }
        // Remove contact
        $contact = new Contact();
        $contact->remove('id = ' . $user->contact_id);
        // Remove user
        $user->remove('id = ' . $user_id);
        $resp = 'User ' . $user->first_name . ' ' . $user->last_name . ' was removed successfully!';
        $panel = new Panel();
        return $panel->build_panel('', '', $resp);
    } else {
        return 'ERROR||Problems removing user ' . $user->first_name . ' ' . $user->last_name . '!';
    }
}

/**
 * Build the admin user edit form by Lemu on October 7, 2009
 */
function user_admin_edit_form($user_id) {
    $user->load_single('id = ' . $user_id);
    if ($user->affected > 0) {
        $frm = new DbForm();
        // Contact info
        $contact = new Contact();
        $contact->load_single('id = ' . $user->contact_id);
        foreach ($contact as $field => $value) {
            if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id') {
                $user->$field = $value;
            }
        }
        // Select the properly levels
        $access_levels = new DataManager();
        $access_levels->dm_load_custom_list('SELECT al.description, al.level FROM acl_levels al WHERE al.level <= ' . $_SESSION['log_access_level'] . ' AND al.level > 41', 'ASSOC');
        if ($access_levels->affected) {
            $items = array();
            foreach ($access_levels->data as $access_level) {
                $items[] = ucwords($access_level['description']) . '=' . $access_level['level'];
            }
            $user->access_level_options = implode(';', $items);
        }
        return $frm->build('admin_user_edit', $user, $_SESSION['log_access_level']);
    }
		else {
      return 'Problems loading user ' . $user_id;
    }
}


?>