<?php
/**
 * List items
 */
function transaction_type_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
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
    $search_fields = array('id', 'type_id', 'name');
    $exceptions = array();
    $search_query = build_search_query($search, $search_fields, $exceptions);
    
    $transaction_types = $db->transaction_type()
    ->where($row_id)
    ->and($search_query)
    ->order($sort)
    ->limit($limit, $offset);
  } else {
    $transaction_types = $db->transaction_type()
    ->where($row_id)
    ->order($sort)
    ->limit($limit, $offset);
  }
  $total_records = $db->transaction_type()->count("*");
  
  $i = 0;
  if (count($transaction_types)) {
    // Building the header with sorter
    $headers[] = array('display' => 'Id', 'field' => 'id');
    $headers[] = array('display' => 'Type Id', 'field' => 'type_id');
    $headers[] = array('display' => 'Name', 'field' => 'name');
    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers = build_sort_header('transaction_type_list', 'transaction_type', $headers, $sort);

    foreach( $transaction_types as $transaction_type ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']   = $transaction_type['id'];
      /////////////////////////////////////////////
      $rows[$j]['id']       = $transaction_type['id'];
      $rows[$j]['type_id']   = $transaction_type['type_id'];
      $rows[$j]['name'] = $transaction_type['name'];
      $rows[$j]['edit']   = theme_link_process_information('',
          'transaction_type_edit_form',
          'transaction_type_edit_form',
          'transaction_type',
          array('extra_value' => 'id|' . $transaction_type['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'transaction_type_delete_form',
          'transaction_type_delete_form',
          'transaction_type', array('extra_value' => 'id|' . $transaction_type['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $i++;
    }
  }
  
  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('TransactionTypes List'),
    'page_subtitle' => translate('Manage TransactionTypes'),
    'empty_message' => translate('No transaction_type found!'),
    'table_prefix' => theme_link_process_information(translate('Create New TransactionType'),
      'transaction_type_create_form',
      'transaction_type_create_form',
      'transaction_type',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('transaction_type_list', 'transaction_type', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'transaction_type_list',
    'module' => 'transaction_type',
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
function transaction_type_create_form() {
    $frm = new DbForm();
    return $frm->build("transaction_type_create_form");
}

/*
 * Insert on table
 */
function transaction_type_create_form_submit($data) {
  $error    = transaction_type_validate($data);
  if (!empty($error)) {
    return FALSE;
  }
  $transaction_type = new TransactionType();
  $response = $transaction_type->create($data);
  if ( $response['id'] > 0 ) {
    return transaction_type_list($response['id']);
  } else {
    return false;
  }
}

/*
 * show edit form
 */
function transaction_type_edit_form($data) {
  $transaction_type = new TransactionType();
  $transaction_type->byID($data['id']);
  $frm = new DbForm();
  $frm->build('transaction_type_edit_form', $transaction_type, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function transaction_type_edit_form_submit($data) {
  $error = transaction_type_validate($data);
  if (!empty($error)) {
    return FALSE;
  } else {
    $transaction_type = new TransactionType();
    $update = $transaction_type->update($data);
    if ($update['code']==200) {
      return transaction_type_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function transaction_type_delete_form($data) {
  $transaction_type = new TransactionType();
  $transaction_type->byID($data['id']);
  //$transaction_type->loadSingle('id='.$data['transaction_type_id']);
  if($transaction_type->affected>0){
    $frm = new DbForm();
    $frm->build('transaction_type_delete_form', $transaction_type, $_SESSION['log_access_level']);
  }else{
    return FALSE;   
  }
}

/*
 * Remove from table
 */
function transaction_type_delete_form_submit($data) {
  $transaction_type = new TransactionType();
  $delete = $transaction_type->delete($data['id']);
  if ($delete['code']==200) {
    return $data['id'];
  } else {
    return FALSE;
  }
}

/*
 * Validate data
 */
function transaction_type_validate($data) {
  $transaction_type = new TransactionType();
  if (strpos($data['fn'], "edit")) {
    $type = "edit";
  }
  if (strpos($data['fn'], "delete")) {
    $type = "delete";
  }
  if (strpos($data['fn'], "create")) {
    $type = "create";
  }
  return $transaction_type->_validate($data, $type, false);
}

?>
