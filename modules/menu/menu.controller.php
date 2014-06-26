<?

/**
 * List items
 */
function menu_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
    $view = new ListView();
    // Row Id for update only row
    if (!empty($row_id)) {
      $row_id = 'b.id = ' . $row_id;
    } else {
      $row_id = 'b.id != 0';
    }
    
    // Search
    if (!empty($search)) {
        $search_fields = array('b.id', 'b.label', 'b.func', 'b.module');
        $exceptions = array();
        $search_query = build_search_query($search, $search_fields, $exceptions);
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
    $menu = new DataManager();
    $menu->dmLoadCustomList("SELECT b.*
    FROM " . NATURAL_DBNAME . ".menu b
    WHERE $row_id  $search_query
    ORDER BY  $sort 
    LIMIT  $start, $limit", 'ASSOC', TRUE);
    
    if ($menu->affected > 0) {
        // Building the header with sorter
        $headers[] = array('display' => 'Id', 'field' => 'b.id');
        $headers[] = array('display' => 'Label', 'field' => 'b.label');
        $headers[] = array('display' => 'Function', 'field' => 'b.func');
        $headers[] = array('display' => 'Module', 'field' => 'b.module');
        $headers[] = array('display' => 'Edit', 'field' => NULL);
        $headers[] = array('display' => 'Delete', 'field' => NULL);
        $headers = build_sort_header('menu_list', 'menu', $headers, $sort);

        for ($i = 0; $i < $menu->affected; $i++) {
            $j = $i + 1;
            //This is important for the row update/delete
            $rows[$j]['row_id'] = $menu->data[$i]['id'];
            /////////////////////////////////////////////
            $rows[$j]['id']     = $menu->data[$i]['id'];
            $rows[$j]['label']  = $menu->data[$i]['label'];
            $rows[$j]['func']   = $menu->data[$i]['func'];
            $rows[$j]['module'] = $menu->data[$i]['module'];
            
            if($menu->data[$i]['system']==1){
								$disabled = 'disabled';
						}else{
								$disabled = '';
						}
            $rows[$j]['edit']   = theme_link_process_information('', 'menu_edit_form', 'menu_edit_form', 'menu', array('extra_value' => 'menu_id|' . $menu->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_EDIT_ICON, 'class' => $disabled));
            $rows[$j]['delete'] = theme_link_process_information('', 'menu_delete_form', 'menu_delete_form', 'menu', array('extra_value' => 'menu_id|' . $menu->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON, 'class' => $disabled));
        }
    }
    
    $options = array(
        'show_headers' => TRUE,
        'page_title' => translate('Users List'),
        'page_subtitle' => translate('Manage Menus'),
        'empty_message' => translate('No menu found!'),
        'table_prefix' => theme_link_process_information(translate('Create New Menu'), 'menu_create_form', 'menu_create_form', 'menu', array('response_type' => 'modal')),
        'pager_items' => build_pager('menu_list', 'menu', $menu->total_records, $limit, $page),
        'page' => $page,
        'sort' => $sort,
        'search' => $search,
        'show_search' => TRUE,
        'function' => 'menu_list',
        'module' => 'menu',
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
function menu_create_form() {
    $frm = new DbForm();
    
    $menu = new Menu();
    $menu->loadList('ASSOC', 'id>0');
    if($menu->affected>0){
      $items = array();
      $items[] = 'Main Menu=0';
      foreach ($menu->data as $pid_opt) {
        $items[] = ucwords($pid_opt['label']) . '=' . $pid_opt['id'];
      }
      $frm->pid_options = implode(';', $items);
      return $frm->build("menu_create_form", $frm);  
    }else{
      natural_set_message('Could load Menu at this time', 'error');
    }
}

/*
 * Insert on table
 */
function menu_create_form_submit($data) {
    $menu_val = new Menu();
    $error    = $menu_val->_validate($data, false, false);
    if (!empty($error)) {
      foreach($error as $msg) {
        natural_set_message($msg, 'error');
      }
      return FALSE;
    }
    $menu = new Menu();
    foreach ($data as $field => $value) {
        if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
            $menu->$field = $value;
        }
    }
    $menu->insert();
    if ($menu->affected > 0 ) {
        natural_set_message('Menu has been created!', 'success');
        return menu_list($menu->id);
    } else {
        natural_set_message('Could not save this Menu at this time', 'error');
        return false;
    }
}

/*
 * show edit form
 */
function menu_edit_form($data) {
    $menu = new Menu();
    $menu->loadSingle('id='.$data['menu_id']);
    
    $mn = new Menu();
    $mn->loadList('ASSOC', 'id>0');
    if($mn->affected>0){
      $items = array();
      $items[] = 'Main Menu=0';
      foreach ($mn->data as $pid_opt) {
        $items[] = ucwords($pid_opt['label']) . '=' . $pid_opt['id'];
      }
      $menu->pid_options = implode(';', $items);
      $frm = new DbForm();
      $frm->build('menu_edit_form', $menu, $_SESSION['log_access_level']);
    }else{
      natural_set_message('Could load Menu at this time', 'error');
    }
    
    
}

/*
 * Update table
 */
function menu_edit_form_submit($data) {
    $error = menu_validate($data);
    if (!empty($error)) {
        foreach($error as $msg) {
          natural_set_message($msg, 'error');
        }
        return FALSE;
    } else {
        $menu = new Menu();
        $menu->loadSingle("id='" . $data['id'] . "'");
        foreach ($data as $field => $value) {
            if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
                $menu->$field = $value;
            }
        }
        $menu->update("id='" . $data['id'] . "'");
        if ($menu->affected > 0) {
            natural_set_message('Menu updated successfully!', 'success');
        }
        return menu_list($data['id']);
    }
}

/*
 * show edit form
 */
function menu_delete_form($data) {
    $menu = new Menu();
    $menu->loadSingle('id='.$data['menu_id']);
    if($menu->affected>0){
        $frm = new DbForm();
        $frm->build('menu_delete_form', $menu, $_SESSION['log_access_level']);
    }else{
        natural_set_message('Problems loading menu ' . $user_id, 'error');
        return FALSE;   
    }
}

/*
 * Remove from table
 */
function menu_delete_form_submit($data) {
    $menu = new Menu();
    $menu->remove('id=' . $data['id']);
    if ($menu->affected > 0) {
        //return "ERROR||Could not remove!";
        $menu->remove('id=' . $data['id']);
        natural_set_message('Menu has been removed successfully!', 'success');
        return $data['id'];
    } else {
        natural_set_message('Problems loading user ' . $user_id, 'error');
        return FALSE;
    }
}

/*
 * Validate data
 */
function menu_validate($data) {
    $menu = new Menu();
    $edit = false;
    if (stripos("edit", $words)) {
        $edit = true;
    }
    return $menu->_validate($data, $edit, false);
}

?>