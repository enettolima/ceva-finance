<?

/**
 * List items
 */
function dashboard_widgets_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
    $view = new ListView();
    // Row Id for update only row
    if (!empty($row_id)) {
      $row_id = 'b.id = ' . $row_id;
    } else {
      $row_id = 'b.id != 0';
    }
    
    // Search
    if (!empty($search)) {
        $search_fields = array('b.id', 'b.title', 'b.description');
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
    $dashboard_widgets = new DataManager();
    $dashboard_widgets->dmLoadCustomList("SELECT b.*
    FROM " . NATURAL_DBNAME . ".dashboard_widgets b
    WHERE $row_id  $search_query
    ORDER BY  $sort 
    LIMIT  $start, $limit", 'ASSOC', TRUE);
    
    if ($dashboard_widgets->affected > 0) {
        // Building the header with sorter
        $headers[] = array('display' => 'Id', 'field' => 'b.id');
        $headers[] = array('display' => 'Title', 'field' => 'b.title');
        $headers[] = array('display' => 'Description', 'field' => 'b.description');
        $headers[] = array('display' => 'Edit', 'field' => NULL);
        $headers[] = array('display' => 'Delete', 'field' => NULL);
        $headers = build_sort_header('dashboard_widgets_list', 'dashboard_widgets', $headers, $sort);

        for ($i = 0; $i < $dashboard_widgets->affected; $i++) {
            $j = $i + 1;
            //This is important for the row update/delete
            $rows[$j]['row_id'] = $dashboard_widgets->data[$i]['id'];
            /////////////////////////////////////////////
            $rows[$j]['id']     = $dashboard_widgets->data[$i]['id'];
            $rows[$j]['title']   = $dashboard_widgets->data[$i]['title'];
            $rows[$j]['description'] = $dashboard_widgets->data[$i]['description'];
            $rows[$j]['edit']   = theme_link_process_information('', 'dashboard_widgets_edit_form', 'dashboard_widgets_edit_form', 'dashboard_widgets', array('extra_value' => 'dashboard_widgets_id|' . $dashboard_widgets->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_EDIT_ICON, 'class' => $disabled));
            $rows[$j]['delete'] = theme_link_process_information('', 'dashboard_widgets_delete_form', 'dashboard_widgets_delete_form', 'dashboard_widgets', array('extra_value' => 'dashboard_widgets_id|' . $dashboard_widgets->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON, 'class' => $disabled));
        }
    }
    
    $options = array(
        'show_headers' => TRUE,
        'page_title' => translate('Users List'),
        'page_subtitle' => translate('Manage DashboardWidgetss'),
        'empty_message' => translate('No dashboard_widgets found!'),
        'table_prefix' => theme_link_process_information(translate('Create New DashboardWidgets'), 'dashboard_widgets_create_form', 'dashboard_widgets_create_form', 'dashboard_widgets', array('response_type' => 'modal')),
        'pager_items' => build_pager('dashboard_widgets_list', 'dashboard_widgets', $dashboard_widgets->total_records, $limit, $page),
        'page' => $page,
        'sort' => $sort,
        'search' => $search,
        'show_search' => TRUE,
        'function' => 'dashboard_widgets_list',
        'module' => 'dashboard_widgets',
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
function dashboard_widgets_create_form() {
    $frm = new DbForm();
    return $frm->build("dashboard_widgets_create_form");
}

/*
 * Insert on table
 */
function dashboard_widgets_create_form_submit($data) {
    $dashboard_widgets_val = new DashboardWidgets();
    $error    = $dashboard_widgets_val->_validate($data, false, false);
    if (!empty($error)) {
      foreach($error as $msg) {
        natural_set_message($msg, 'error');
      }
      return FALSE;
    }
    $dashboard_widgets = new DashboardWidgets();
    foreach ($data as $field => $value) {
        if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
            $dashboard_widgets->$field = $value;
        }
    }
    $dashboard_widgets->insert();
    if ($dashboard_widgets->affected > 0 ) {
        natural_set_message('DashboardWidgets has been created!', 'success');
        return dashboard_widgets_list($dashboard_widgets->id);
    } else {
        natural_set_message('Could not save this DashboardWidgets at this time', 'error');
        return false;
    }
}

/*
 * show edit form
 */
function dashboard_widgets_edit_form($data) {
    $dashboard_widgets = new DashboardWidgets();
    $dashboard_widgets->loadSingle('id='.$data['dashboard_widgets_id']);
    $frm = new DbForm();
    $frm->build('dashboard_widgets_edit_form', $dashboard_widgets, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function dashboard_widgets_edit_form_submit($data) {
    $error = dashboard_widgets_validate($data);
    if (!empty($error)) {
        foreach($error as $msg) {
          natural_set_message($msg, 'error');
        }
        return FALSE;
    } else {
        $dashboard_widgets = new DashboardWidgets();
        $dashboard_widgets->loadSingle("id='" . $data['id'] . "'");
        foreach ($data as $field => $value) {
            if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
                $dashboard_widgets->$field = $value;
            }
        }
        $dashboard_widgets->update("id='" . $data['id'] . "'");
        if ($dashboard_widgets->affected > 0) {
            natural_set_message('DashboardWidgets updated successfully!', 'success');
        }
        return dashboard_widgets_list($data['id']);
    }
}

/*
 * show edit form
 */
function dashboard_widgets_delete_form($data) {
    $dashboard_widgets = new DashboardWidgets();
    $dashboard_widgets->loadSingle('id='.$data['dashboard_widgets_id']);
    if($dashboard_widgets->affected>0){
        $frm = new DbForm();
        $frm->build('dashboard_widgets_delete_form', $dashboard_widgets, $_SESSION['log_access_level']);
    }else{
        natural_set_message('Problems loading dashboard_widgets ' . $user_id, 'error');
        return FALSE;   
    }
}

/*
 * Remove from table
 */
function dashboard_widgets_delete_form_submit($data) {
    $dashboard_widgets = new DashboardWidgets();
    $dashboard_widgets->remove('id=' . $data['id']);
    if ($dashboard_widgets->affected > 0) {
        //return "ERROR||Could not remove!";
        $dashboard_widgets->remove('id=' . $data['id']);
        natural_set_message('DashboardWidgets has been removed successfully!', 'success');
        return $data['id'];
    } else {
        natural_set_message('Problems loading user ' . $user_id, 'error');
        return FALSE;
    }
}

/*
 * Validate data
 */
function dashboard_widgets_validate($data) {
    $dashboard_widgets = new DashboardWidgets();
    $edit = false;
    if (stripos("edit", $words)) {
        $edit = true;
    }
    return $dashboard_widgets->_validate($data, $edit, false);
}

?>