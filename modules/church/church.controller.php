<?php
/**
 * List items
 */
function church_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
  $view = new ListView();
  // Row Id for update only row
  if (!empty($row_id)) {
    $row_id = 'id = ' . $row_id;
  } else {
    $row_id = 'id != 0';
  }

  // Sort
  if (empty($sort)) {
    $sort = 'id ASC';
  }

  $limit = PAGER_LIMIT;
  $offset = ($page * $limit) - $limit;
  $db = DataConnection::readOnly();
  $total_records = 0;

  // Search
  if (!empty($search)) {
    $search_fields = array('id', 'user_id', 'name');
    $exceptions = array();
    $search_query = build_search_query($search, $search_fields, $exceptions);

    $churchs = $db->church()
    ->where($row_id)
    ->and($search_query)
    ->order($sort)
    ->limit($limit, $offset);
  } else {
    $churchs = $db->church()
    ->where($row_id)
    ->order($sort)
    ->limit($limit, $offset);
  }
  $total_records = $db->church()->count("*");

  $i = 0;
  if (count($churchs)) {
    // Building the header with sorter
    $headers[] = array('display' => 'Id', 'field' => 'id');
    $headers[] = array('display' => 'User Id', 'field' => 'user_id');
    $headers[] = array('display' => 'Name', 'field' => 'name');
    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers = build_sort_header('church_list', 'church', $headers, $sort);

    foreach( $churchs as $church ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']   = $church['id'];
      /////////////////////////////////////////////
      $rows[$j]['id']       = $church['id'];
      $rows[$j]['user_id']   = $church['user_id'];
      $rows[$j]['name'] = $church['name'];
      $rows[$j]['edit']   = theme_link_process_information('',
          'church_edit_form',
          'church_edit_form',
          'church',
          array('extra_value' => 'id|' . $church['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'church_delete_form',
          'church_delete_form',
          'church', array('extra_value' => 'id|' . $church['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $i++;
    }
  }

  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('Churchs List'),
    'page_subtitle' => translate('Manage Churchs'),
    'empty_message' => translate('No church found!'),
    'table_prefix' => theme_link_process_information(translate('Create New Church'),
      'church_create_form',
      'church_create_form',
      'church',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('church_list', 'church', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'church_list',
    'module' => 'church',
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
function church_create_form() {
    $frm = new DbForm();
    return $frm->build("church_create_form");
}

/*
 * Insert on table
 */
function church_create_form_submit($data) {
  $data['user_id'] = $_SESSION['log_id'];
  $error    = church_validate($data);
  if (!empty($error)) {
    return FALSE;
  }
  $church = new Church();

  $response = $church->create($data);
  if ( $response['id'] > 0 ) {
    return church_list($response['id']);
  } else {
    return false;
  }
}

/*
 * show edit form
 */
function church_edit_form($data) {
  $church = new Church();
  $church->byID($data['id']);
  $frm = new DbForm();
  $frm->build('church_edit_form', $church, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function church_edit_form_submit($data) {
  $error = church_validate($data);
  if (!empty($error)) {
    return FALSE;
  } else {
    $church = new Church();
    $update = $church->update($data);
    if ($update['code']==200) {
      return church_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function church_delete_form($data) {
  $church = new Church();
  $church->byID($data['id']);
  //$church->loadSingle('id='.$data['church_id']);
  if($church->affected>0){
    $frm = new DbForm();
    $frm->build('church_delete_form', $church, $_SESSION['log_access_level']);
  }else{
    return FALSE;
  }
}

/*
 * Remove from table
 */
function church_delete_form_submit($data) {
  $church = new Church();
  $delete = $church->delete($data['id']);
  if ($delete['code']==200) {
    return $data['id'];
  } else {
    return FALSE;
  }
}

/*
 * Validate data
 */
function church_validate($data) {
  $church = new Church();
  if (strpos($data['fn'], "edit")) {
    $type = "edit";
  }
  if (strpos($data['fn'], "delete")) {
    $type = "delete";
  }
  if (strpos($data['fn'], "create")) {
    $type = "create";
  }
  return $church->_validate($data, $type, false);
}

?>
