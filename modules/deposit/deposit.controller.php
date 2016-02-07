<?php
/**
 * List items
 */
function deposit_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
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
    $search_fields = array('id', 'bank_name', 'transaction_number');
    $exceptions = array();
    $search_query = build_search_query($search, $search_fields, $exceptions);

    $deposits = $db->deposit()
    ->where($row_id)
    ->and($search_query)
    ->order($sort)
    ->limit($limit, $offset);
  } else {
    $deposits = $db->deposit()
    ->where($row_id)
    ->order($sort)
    ->limit($limit, $offset);
  }
  $total_records = $db->deposit()->count("*");

  $i = 0;
  if (count($deposits)) {
    // Building the header with sorter
    //$headers[] = array('display' => 'Id', 'field' => 'id');
    $headers[] = array('display' => 'Bank Name', 'field' => 'bank_name');
    $headers[] = array('display' => 'Transaction Number', 'field' => 'transaction_number');
    $headers[] = array('display' => 'Account Number', 'field' => 'account_number');
    $headers[] = array('display' => 'Check Amount', 'field' => 'check_amount');
    $headers[] = array('display' => 'Cash Amount', 'field' => 'cash_amount');
    $headers[] = array('display' => 'Date', 'field' => 'date');
    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers = build_sort_header('deposit_list', 'deposit', $headers, $sort);

    foreach( $deposits as $deposit ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']   = $deposit['id'];
      /////////////////////////////////////////////
      //$rows[$j]['id']       = $deposit['id'];
      $rows[$j]['bank_name']   = $deposit['bank_name'];
      $rows[$j]['transaction_number'] = $deposit['transaction_number'];
      $rows[$j]['account_number'] = $deposit['account_number'];
      $rows[$j]['check_amount'] = $deposit['check_amount'];
      $rows[$j]['cash_amount'] = $deposit['cash_amount'];
      $rows[$j]['date'] = date("m/d/Y", strtotime($deposit['date']));
      $rows[$j]['edit']   = theme_link_process_information('',
          'deposit_edit_form',
          'deposit_edit_form',
          'deposit',
          array('extra_value' => 'id|' . $deposit['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'deposit_delete_form',
          'deposit_delete_form',
          'deposit', array('extra_value' => 'id|' . $deposit['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $i++;
    }
  }

  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('Deposits List'),
    'page_subtitle' => translate('Manage Deposits'),
    'empty_message' => translate('No deposit found!'),
    'table_prefix' => theme_link_process_information(translate('Create New Deposit'),
      'deposit_create_form',
      'deposit_create_form',
      'deposit',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('deposit_list', 'deposit', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'deposit_list',
    'module' => 'deposit',
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
function deposit_create_form() {
    $frm = new DbForm;
    $frm->date = date("m/d/Y");
    return $frm->build("deposit_create_form",$frm);
}

/*
 * Insert on table
 */
function deposit_create_form_submit($data) {
  $error    = deposit_validate($data);
  if (!empty($error)) {
    return FALSE;
  }
  $deposit = new Deposit();
  $data['date'] = date("Y-m-d", strtotime($data['date']));
  $response = $deposit->create($data);
  if ( $response['id'] > 0 ) {
    return deposit_list($response['id']);
  } else {
    return false;
  }
}

/*
 * show edit form
 */
function deposit_edit_form($data) {
  $deposit = new Deposit();
  $deposit->byID($data['id']);
  $frm = new DbForm();
  $deposit->date = date("m/d/Y", strtotime($deposit->date));
  $frm->build('deposit_edit_form', $deposit, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function deposit_edit_form_submit($data) {
  $error = deposit_validate($data);
  if (!empty($error)) {
    return FALSE;
  } else {
    $deposit = new Deposit();
    $data['date'] = date("Y-m-d", strtotime($data['date']));
    $update = $deposit->update($data);
    if ($update['code']==200) {
      return deposit_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function deposit_delete_form($data) {
  $deposit = new Deposit();
  $deposit->byID($data['id']);
  //$deposit->loadSingle('id='.$data['deposit_id']);
  if($deposit->affected>0){
    $frm = new DbForm();
    $frm->build('deposit_delete_form', $deposit, $_SESSION['log_access_level']);
  }else{
    return FALSE;
  }
}

/*
 * Remove from table
 */
function deposit_delete_form_submit($data) {
  $deposit = new Deposit();
  $delete = $deposit->delete($data['id']);
  if ($delete['code']==200) {
    return $data['id'];
  } else {
    return FALSE;
  }
}

/*
 * Validate data
 */
function deposit_validate($data) {
  $deposit = new Deposit();
  if (strpos($data['fn'], "edit")) {
    $type = "edit";
  }
  if (strpos($data['fn'], "delete")) {
    $type = "delete";
  }
  if (strpos($data['fn'], "create")) {
    $type = "create";
  }
  return $deposit->_validate($data, $type, false);
}

?>
