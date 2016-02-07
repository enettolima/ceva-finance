<?php
/**
 * List items
 */
function withdraw_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
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
    $search_fields = array('id', 'withdraw_type_id', 'invoice_number');
    $exceptions = array();
    $search_query = build_search_query($search, $search_fields, $exceptions);

    $withdraws = $db->withdraw()
    ->where($row_id)
    ->and($search_query)
    ->order($sort)
    ->limit($limit, $offset);
  } else {
    $withdraws = $db->withdraw()
    ->where($row_id)
    ->order($sort)
    ->limit($limit, $offset);
  }
  $total_records = $db->withdraw()->count("*");

  $i = 0;
  if (count($withdraws)) {
    // Building the header with sorter
    //$headers[] = array('display' => 'Id', 'field' => 'id');
    //$headers[] = array('display' => 'Id', 'field' => 'id');
    $headers[] = array('display' => 'Withdraw Type', 'field' => 'withdraw_type');
    $headers[] = array('display' => 'Invoice Number', 'field' => 'invoice_number');
    $headers[] = array('display' => 'Amount', 'field' => 'amount');
    $headers[] = array('display' => 'Description', 'field' => 'description');
    $headers[] = array('display' => 'Date', 'field' => 'date');
    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers = build_sort_header('withdraw_list', 'withdraw', $headers, $sort);

    foreach( $withdraws as $withdraw ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']   = $withdraw['id'];
      /////////////////////////////////////////////
      //$rows[$j]['id']       = $withdraw['id'];
      $wraw = new WithdrawType();
      $wraw->byID($withdraw['withdraw_type_id']);
      $rows[$j]['withdraw_type']   = $wraw->name;
      $rows[$j]['invoice_number'] = $withdraw['invoice_number'];
      $rows[$j]['amount'] = $withdraw['amount'];
      $rows[$j]['description'] = $withdraw['description'];
      $rows[$j]['date'] = date("m/d/Y", strtotime($withdraw['timestamp']));
      $rows[$j]['edit']   = theme_link_process_information('',
          'withdraw_edit_form',
          'withdraw_edit_form',
          'withdraw',
          array('extra_value' => 'id|' . $withdraw['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'withdraw_delete_form',
          'withdraw_delete_form',
          'withdraw', array('extra_value' => 'id|' . $withdraw['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $i++;
    }
  }

  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('Withdraws List'),
    'page_subtitle' => translate('Manage Withdraws'),
    'empty_message' => translate('No withdraw found!'),
    'table_prefix' => theme_link_process_information(translate('Create New Withdraw'),
      'withdraw_create_form',
      'withdraw_create_form',
      'withdraw',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('withdraw_list', 'withdraw', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'withdraw_list',
    'module' => 'withdraw',
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
function withdraw_create_form() {
    $frm = new DbForm();
    $frm->timestamp = date("m/d/Y");
    return $frm->build("withdraw_create_form",$frm);
}

/*
 * Insert on table
 */
function withdraw_create_form_submit($data) {
  $error    = withdraw_validate($data);
  if (!empty($error)) {
    return FALSE;
  }
  $withdraw = new Withdraw();
  $data['timestamp'] = date("Y-m-d", strtotime($data['timestamp']));
  $response = $withdraw->create($data);
  if ( $response['id'] > 0 ) {
    return withdraw_list($response['id']);
  } else {
    return false;
  }
}

/*
 * show edit form
 */
function withdraw_edit_form($data) {
  $withdraw = new Withdraw();
  $withdraw->byID($data['id']);
  $frm = new DbForm();
  $withdraw->timestamp = date("m/d/Y", strtotime($withdraw->timestamp));
  $frm->build('withdraw_edit_form', $withdraw, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function withdraw_edit_form_submit($data) {
  $error = withdraw_validate($data);
  if (!empty($error)) {
    return FALSE;
  } else {
    $withdraw = new Withdraw();
    $data['timestamp'] = date("Y-m-d", strtotime($data['timestamp']));
    $update = $withdraw->update($data);
    if ($update['code']==200) {
      return withdraw_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function withdraw_delete_form($data) {
  $withdraw = new Withdraw();
  $withdraw->byID($data['id']);
  //$withdraw->loadSingle('id='.$data['withdraw_id']);
  if($withdraw->affected>0){
    $frm = new DbForm();
    $frm->build('withdraw_delete_form', $withdraw, $_SESSION['log_access_level']);
  }else{
    return FALSE;
  }
}

/*
 * Remove from table
 */
function withdraw_delete_form_submit($data) {
  $withdraw = new Withdraw();
  $delete = $withdraw->delete($data['id']);
  if ($delete['code']==200) {
    return $data['id'];
  } else {
    return FALSE;
  }
}

/*
 * Validate data
 */
function withdraw_validate($data) {
  $withdraw = new Withdraw();
  if (strpos($data['fn'], "edit")) {
    $type = "edit";
  }
  if (strpos($data['fn'], "delete")) {
    $type = "delete";
  }
  if (strpos($data['fn'], "create")) {
    $type = "create";
  }
  return $withdraw->_validate($data, $type, false);
}

?>
