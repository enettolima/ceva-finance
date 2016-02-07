<?php
/**
 * List items
 */
function withdraw_type_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
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
    $search_fields = array('id', 'name', '');
    $exceptions = array();
    $search_query = build_search_query($search, $search_fields, $exceptions);
    
    $withdraw_types = $db->withdraw_type()
    ->where($row_id)
    ->and($search_query)
    ->order($sort)
    ->limit($limit, $offset);
  } else {
    $withdraw_types = $db->withdraw_type()
    ->where($row_id)
    ->order($sort)
    ->limit($limit, $offset);
  }
  $total_records = $db->withdraw_type()->count("*");
  
  $i = 0;
  if (count($withdraw_types)) {
    // Building the header with sorter
    $headers[] = array('display' => 'Id', 'field' => 'id');
    $headers[] = array('display' => 'Name', 'field' => 'name');
    $headers[] = array('display' => '', 'field' => '');
    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers = build_sort_header('withdraw_type_list', 'withdraw_type', $headers, $sort);

    foreach( $withdraw_types as $withdraw_type ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']   = $withdraw_type['id'];
      /////////////////////////////////////////////
      $rows[$j]['id']       = $withdraw_type['id'];
      $rows[$j]['name']   = $withdraw_type['name'];
      $rows[$j][''] = $withdraw_type[''];
      $rows[$j]['edit']   = theme_link_process_information('',
          'withdraw_type_edit_form',
          'withdraw_type_edit_form',
          'withdraw_type',
          array('extra_value' => 'id|' . $withdraw_type['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'withdraw_type_delete_form',
          'withdraw_type_delete_form',
          'withdraw_type', array('extra_value' => 'id|' . $withdraw_type['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $i++;
    }
  }
  
  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('WithdrawTypes List'),
    'page_subtitle' => translate('Manage WithdrawTypes'),
    'empty_message' => translate('No withdraw_type found!'),
    'table_prefix' => theme_link_process_information(translate('Create New WithdrawType'),
      'withdraw_type_create_form',
      'withdraw_type_create_form',
      'withdraw_type',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('withdraw_type_list', 'withdraw_type', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'withdraw_type_list',
    'module' => 'withdraw_type',
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
function withdraw_type_create_form() {
    $frm = new DbForm();
    return $frm->build("withdraw_type_create_form");
}

/*
 * Insert on table
 */
function withdraw_type_create_form_submit($data) {
  $error    = withdraw_type_validate($data);
  if (!empty($error)) {
    return FALSE;
  }
  $withdraw_type = new WithdrawType();
  $response = $withdraw_type->create($data);
  if ( $response['id'] > 0 ) {
    return withdraw_type_list($response['id']);
  } else {
    return false;
  }
}

/*
 * show edit form
 */
function withdraw_type_edit_form($data) {
  $withdraw_type = new WithdrawType();
  $withdraw_type->byID($data['id']);
  $frm = new DbForm();
  $frm->build('withdraw_type_edit_form', $withdraw_type, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function withdraw_type_edit_form_submit($data) {
  $error = withdraw_type_validate($data);
  if (!empty($error)) {
    return FALSE;
  } else {
    $withdraw_type = new WithdrawType();
    $update = $withdraw_type->update($data);
    if ($update['code']==200) {
      return withdraw_type_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function withdraw_type_delete_form($data) {
  $withdraw_type = new WithdrawType();
  $withdraw_type->byID($data['id']);
  //$withdraw_type->loadSingle('id='.$data['withdraw_type_id']);
  if($withdraw_type->affected>0){
    $frm = new DbForm();
    $frm->build('withdraw_type_delete_form', $withdraw_type, $_SESSION['log_access_level']);
  }else{
    return FALSE;   
  }
}

/*
 * Remove from table
 */
function withdraw_type_delete_form_submit($data) {
  $withdraw_type = new WithdrawType();
  $delete = $withdraw_type->delete($data['id']);
  if ($delete['code']==200) {
    return $data['id'];
  } else {
    return FALSE;
  }
}

/*
 * Validate data
 */
function withdraw_type_validate($data) {
  $withdraw_type = new WithdrawType();
  if (strpos($data['fn'], "edit")) {
    $type = "edit";
  }
  if (strpos($data['fn'], "delete")) {
    $type = "delete";
  }
  if (strpos($data['fn'], "create")) {
    $type = "create";
  }
  return $withdraw_type->_validate($data, $type, false);
}

?>
