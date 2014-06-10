<?

/**
 * List items
 */
function car_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
    $view = new ListView();
    // Row Id for update only row
    if (!empty($row_id)) {
      $row_id = 'b.id = ' . $row_id;
    } else {
      $row_id = 'b.id != 0';
    }
    
    // Search
    if (!empty($search)) {
        $search_fields = array('b.id', 'b.make', 'b.model');
        $exceptions = array();
        $search_query = build_search_query($search_query, $search_fields, $exceptions);
    } else {
        $search_query = '';
    }

    // Sort
    if (empty($sort)) {
        $sort = 'b.id ASC';
    }

    $limit = PAGER_LIMIT;
    $start = ($page * $limit) - $limit;
    
    // Dial List Table Object
    $car = new DataManager();
    $car->dmLoadCustomList("SELECT b.*
    FROM " . NATURAL_DBNAME . ".car b
    WHERE $row_id  $search_query
    ORDER BY  $sort 
    LIMIT  $start, $limit", 'ASSOC', TRUE);
    
    if ($car->affected > 0) {
        // Building the header with sorter
        $headers[] = array('display' => 'Id', 'field' => 'b.id');
        $headers[] = array('display' => 'Make', 'field' => 'b.make');
        $headers[] = array('display' => 'Model', 'field' => 'b.model');
        $headers[] = array('display' => 'Edit', 'field' => NULL);
        $headers[] = array('display' => 'Delete', 'field' => NULL);
        $headers = build_sort_header('car_list', 'car', $headers, $sort);

        for ($i = 0; $i < $car->affected; $i++) {
            $j = $i + 1;
            //This is important for the row update/delete
            $rows[$j]['row_id'] = $car->data[$i]['id'];
            /////////////////////////////////////////////
            $rows[$j]['id']     = $car->data[$i]['id'];
            $rows[$j]['make']   = $car->data[$i]['make'];
            $rows[$j]['model'] = $car->data[$i]['model'];
            $rows[$j]['edit']   = theme_link_process_information('', 'car_edit_form', 'car_edit_form', 'car', array('extra_value' => 'car_id|' . $car->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_EDIT_ICON, 'class' => $disabled));
            $rows[$j]['delete'] = theme_link_process_information('', 'car_delete_form', 'car_delete_form', 'car', array('extra_value' => 'car_id|' . $car->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON, 'class' => $disabled));
        }
    }
    
    $options = array(
        'show_headers' => TRUE,
        'page_title' => translate('Users List'),
        'page_subtitle' => translate('Manage Cars'),
        'empty_message' => translate('No car found!'),
        'table_prefix' => theme_link_process_information(translate('Create New Car'), 'car_create_form', 'car_create_form', 'car', array('response_type' => 'modal')),
        'pager_items' => build_pager('car_list', 'car', $car->total_records, $limit, $page),
        'page' => $page,
        'sort' => $sort,
        'search' => $search,
        'show_search' => TRUE,
        'function' => 'car_list',
        'module' => 'car',
        'update_row_id' => '',
        'table_form_id' => '',
        'table_form_process' => '',
    );
    $listview = $view->build($rows, $headers, $options);

    return $listview;
}

/*
 * show add form
 */
function car_create_form() {
    $frm = new DbForm();
    return $frm->build("car_create_form");
}

/*
 * Insert on table
 */
function car_create_form_submit($data) {
    $car_val = new Car();
    $error    = $car_val->_validate($data, false, false);
    if (!empty($error)) {
      foreach($error as $msg) {
        natural_set_message($msg, 'error');
      }
      return FALSE;
    }
    $car = new Car();
    foreach ($data as $field => $value) {
        if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
            $car->$field = $value;
        }
    }
    $car->insert();
    if ($car->affected > 0 ) {
        natural_set_message('Car has been created!', 'success');
        return car_list($car->id);
    } else {
        natural_set_message('Could not save this Car at this time', 'error');
        return false;
    }
}

/*
 * show edit form
 */
function car_edit_form($data) {
    $car = new Car();
    $car->loadSingle('id='.$data['car_id']);
    $frm = new DbForm();
    $frm->build('car_edit_form', $car, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function car_edit_form_submit($data) {
    $error = car_validate($data);
    if (!empty($error)) {
        foreach($error as $msg) {
          natural_set_message($msg, 'error');
        }
        return FALSE;
    } else {
        $car = new Car();
        $car->loadSingle("id='" . $data['id'] . "'");
        foreach ($data as $field => $value) {
            if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
                $car->$field = $value;
            }
        }
        $car->update("id='" . $data['id'] . "'");
        if ($car->affected > 0) {
            natural_set_message('Car updated successfully!', 'success');
        }
        return car_list($data['id']);
    }
}

/*
 * show edit form
 */
function car_delete_form($data) {
    $car = new Car();
    $car->loadSingle('id='.$data['car_id']);
    if($car->affected>0){
        $frm = new DbForm();
        $frm->build('car_delete_form', $car, $_SESSION['log_access_level']);
    }else{
        natural_set_message('Problems loading car ' . $user_id, 'error');
        return FALSE;   
    }
}

/*
 * Remove from table
 */
function car_delete_form_submit($data) {
    $car = new Car();
    $car->remove('id=' . $data['id']);
    if ($car->affected > 0) {
        //return "ERROR||Could not remove!";
        $car->remove('id=' . $data['id']);
        natural_set_message('Car has been removed successfully!', 'success');
        return $data['id'];
    } else {
        natural_set_message('Problems loading user ' . $user_id, 'error');
        return FALSE;
    }
}

/*
 * Validate data
 */
function car_validate($data) {
    $car = new Car();
    $edit = false;
    if (stripos("edit", $words)) {
        $edit = true;
    }
    return $car->_validate($data, $edit, false);
}

?>