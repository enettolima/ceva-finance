<?php
/**
 * List items
 */
function transaction_overview($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
  $view = new ListView();
  // Row Id for update only row
  if (!empty($row_id)) {
    $row_id = 't.id = ' . $row_id;
  } else {
    $row_id = 't.id != 0';
  }

  // Sort
  if (empty($sort)) {
    $sort = 't.date_created desc';
  }

  $limit = PAGER_LIMIT;
  $offset = ($page * $limit) - $limit;
  $total_records = 0;
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);

  // Search
  if (!empty($search)) {
      $search_fields = array('id', 'bank_name', 'account_number', 'comment');
      $exceptions = array();
      $search_query = build_search_query($search, $search_fields, $exceptions);
      $sql = "select SQL_CALC_FOUND_ROWS  t.id, t.type_id, tt.name as `Category`, u.first_name, u.last_name, t.amount_value, so.description as amount_type, t.amount_identification, t.date_created, t.date_lastchange, b.bank_name, b.bank_account_number, t.comment  FROM church_finance.transaction t
                   left outer join categories tt on tt.id = t.subtype_id
                   left outer join bank b on b.id = t.bank_id
                   left outer join user u on u.id = t.user_id
                   left outer join select_option so on so.upstream_name = 'payment_type' and so.value = t.amount_type
              where t.church_id = ".$_SESSION['log_church_id']." and ".$search_query." order by ".$sort." limit ".$limit." offset ".$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  } else {
      $sql = "select SQL_CALC_FOUND_ROWS t.id, t.type_id, tt.name as `Category`, u.first_name, u.last_name, t.amount_value, so.description as amount_type, t.amount_identification, t.date_created, t.date_lastchange, b.bank_name, b.bank_account_number, t.comment  FROM church_finance.transaction t
                   left outer join categories tt on tt.id = t.subtype_id
                   left outer join bank b on b.id = t.bank_id
                   left outer join user u on u.id = t.user_id
                   left outer join select_option so on so.upstream_name = 'payment_type' and so.value = t.amount_type
              where t.church_id = ".$_SESSION['log_church_id']." order by ".$sort." limit ".$limit." offset ".$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  }
  $total_records = $pdo->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);

  $i = 0;
  if (count($records)) {
    // Building the header with sorter

    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers[] = array('display' => 'Created', 'field' => 'date_created');
    $headers[] = array('display' => 'Category', 'field' => 'Category');
    $headers[] = array('display' => 'First Name', 'field' => 'first_name');
    $headers[] = array('display' => 'Last Name', 'field' => 'last_name');
    $headers[] = array('display' => 'Comment', 'field' => 'comment');
    $headers[] = array('display' => 'Amount Type', 'field' => 'amount_type');
    $headers[] = array('display' => 'Amount', 'field' => 'amount_value');
    $headers = build_sort_header('transaction_overview', 'transaction', $headers, $sort);

    foreach($records as $transaction ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']                = $transaction['id'];
      /////////////////////////////////////////////
      $rows[$j]['edit']   = theme_link_process_information('',
          'transaction_edit_form',
          'transaction_edit_form',
          'transaction',
          array('extra_value' => 'id|' . $transaction['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'transaction_delete_form',
          'transaction_delete_form',
          'transaction', array('extra_value' => 'id|' . $transaction['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $rows[$j]['date_created']          = $transaction['date_created'];
      $rows[$j]['Category']               = $transaction['Category'];
      $rows[$j]['first_name']            = $transaction['first_name'];
      $rows[$j]['last_name']             = $transaction['last_name'];
      $rows[$j]['comment']               = $transaction['comment'];
      $rows[$j]['amount_type']           = $transaction['amount_type'];
      $rows[$j]['amount_value']          = $transaction['amount_value'];
      if($transaction['amount_value'] < 0){
         $rows[$j]['listview_row_style'] = 'color:red;';
      }
      $i++;
    }
  }

  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('Transactions Overview'),
    'page_subtitle' => translate('Manage Transactions'),
    'empty_message' => translate('No transaction found!'),
    'table_prefix' => theme_link_process_information(translate('Create New Transaction'),
      'transaction_create_form',
      'transaction_create_form',
      'transaction',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('transaction_overview', 'transaction', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'transaction_overview',
    'module' => 'transaction',
    'update_row_id' => '',
    'table_form_id' => '',
    'table_form_process' => '',
  );
  $listview = $view->build($rows, $headers, $options);
  return $listview;
}

function transaction_withdraws($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
  $view = new ListView();
  // Row Id for update only row
  if (!empty($row_id)) {
    $row_id = 't.id = ' . $row_id;
  } else {
    $row_id = 't.id != 0';
  }

  // Sort
  if (empty($sort)) {
    $sort = 't.date_created desc';
  }

  $limit = PAGER_LIMIT;
  $offset = ($page * $limit) - $limit;
  $total_records = 0;
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);

  // Search
  if (!empty($search)) {
      $search_fields = array('id', 'bank_name', 'account_number', 'comment');
      $exceptions = array();
      $search_query = build_search_query($search, $search_fields, $exceptions);
      $sql = "select SQL_CALC_FOUND_ROWS  t.id, t.type_id, tt.name as `Category`, u.first_name, u.last_name, t.amount_value, so.description as amount_type, t.amount_identification, t.date_created, t.date_lastchange, b.bank_name, b.bank_account_number, t.comment  FROM church_finance.transaction t
                   left outer join categories tt on tt.id = t.subtype_id
                   left outer join bank b on b.id = t.bank_id
                   left outer join user u on u.id = t.user_id
                   left outer join select_option so on so.upstream_name = 'payment_type' and so.value = t.amount_type
              where t.church_id = ".$_SESSION['log_church_id']." and t.type_id = 1 and ".$search_query." order by ".$sort." limit ".$limit." offset ".$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  } else {
      $sql = "select SQL_CALC_FOUND_ROWS t.id, t.type_id, tt.name as `Category`, u.first_name, u.last_name, t.amount_value, so.description as amount_type, t.amount_identification, t.date_created, t.date_lastchange, b.bank_name, b.bank_account_number, t.comment  FROM church_finance.transaction t
                   left outer join categories tt on tt.id = t.subtype_id
                   left outer join bank b on b.id = t.bank_id
                   left outer join user u on u.id = t.user_id
                   left outer join select_option so on so.upstream_name = 'payment_type' and so.value = t.amount_type
              where t.church_id = ".$_SESSION['log_church_id']."  and t.type_id = 1 order by ".$sort." limit ".$limit." offset ".$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  }
  $total_records = $pdo->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);

  $i = 0;
  if (count($records)) {
    // Building the header with sorter

    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers[] = array('display' => 'Created', 'field' => 'date_created');
    $headers[] = array('display' => 'Category', 'field' => 'Category');
    $headers[] = array('display' => 'First Name', 'field' => 'first_name');
    $headers[] = array('display' => 'Last Name', 'field' => 'last_name');
    $headers[] = array('display' => 'Comment', 'field' => 'comment');
    $headers[] = array('display' => 'Amount Type', 'field' => 'amount_type');
    $headers[] = array('display' => 'Amount', 'field' => 'amount_value');
    $headers = build_sort_header('transaction_withdraws', 'transaction', $headers, $sort);

    foreach($records as $transaction ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']                = $transaction['id'];
      /////////////////////////////////////////////
      $rows[$j]['edit']   = theme_link_process_information('',
          'transaction_edit_form',
          'transaction_edit_form',
          'transaction',
          array('extra_value' => 'id|' . $transaction['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'transaction_delete_form',
          'transaction_delete_form',
          'transaction', array('extra_value' => 'id|' . $transaction['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $rows[$j]['date_created']          = $transaction['date_created'];
      $rows[$j]['Category']               = $transaction['Category'];
      $rows[$j]['first_name']            = $transaction['first_name'];
      $rows[$j]['last_name']             = $transaction['last_name'];
      $rows[$j]['comment']               = $transaction['comment'];
      $rows[$j]['amount_type']           = $transaction['amount_type'];
      $rows[$j]['amount_value']          = $transaction['amount_value'];
      if($transaction['amount_value'] < 0){
         $rows[$j]['listview_row_style'] = 'color:red;';
      }
      $i++;
    }
  }

  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('Withdraws Overview'),
    'page_subtitle' => translate('Manage Withdraws'),
    'empty_message' => translate('No transaction found!'),
    'table_prefix' => theme_link_process_information(translate('Create New Transaction'),
      'transaction_create_form',
      'transaction_create_form',
      'transaction',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('transaction_withdraws', 'transaction', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'transaction_withdraws',
    'module' => 'transaction',
    'update_row_id' => '',
    'table_form_id' => '',
    'table_form_process' => '',
  );
  $listview = $view->build($rows, $headers, $options);
  return $listview;
}


function transaction_income($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
  $view = new ListView();
  // Row Id for update only row
  if (!empty($row_id)) {
    $row_id = 't.id = ' . $row_id;
  } else {
    $row_id = 't.id != 0';
  }

  // Sort
  if (empty($sort)) {
    $sort = 't.date_created desc';
  }

  $limit = PAGER_LIMIT;
  $offset = ($page * $limit) - $limit;
  $total_records = 0;
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);

  // Search
  if (!empty($search)) {
      $search_fields = array('id', 'bank_name', 'account_number', 'comment');
      $exceptions = array();
      $search_query = build_search_query($search, $search_fields, $exceptions);
      $sql = "select SQL_CALC_FOUND_ROWS  t.id, t.type_id, tt.name as `Category`, u.first_name, u.last_name, t.amount_value, so.description as amount_type, t.amount_identification, t.date_created, t.date_lastchange, b.bank_name, b.bank_account_number, t.comment  FROM church_finance.transaction t
                   left outer join categories tt on tt.id = t.subtype_id
                   left outer join bank b on b.id = t.bank_id
                   left outer join user u on u.id = t.user_id
                   left outer join select_option so on so.upstream_name = 'payment_type' and so.value = t.amount_type
              where t.church_id = ".$_SESSION['log_church_id']." and t.type_id = 0 and ".$search_query." order by ".$sort." limit ".$limit." offset ".$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  } else {
      $sql = "select SQL_CALC_FOUND_ROWS t.id, t.type_id, tt.name as `Category`, u.first_name, u.last_name, t.amount_value, so.description as amount_type, t.amount_identification, t.date_created, t.date_lastchange, b.bank_name, b.bank_account_number, t.comment  FROM church_finance.transaction t
                   left outer join categories tt on tt.id = t.subtype_id
                   left outer join bank b on b.id = t.bank_id
                   left outer join user u on u.id = t.user_id
                   left outer join select_option so on so.upstream_name = 'payment_type' and so.value = t.amount_type
              where t.church_id = ".$_SESSION['log_church_id']."  and t.type_id = 0 order by ".$sort." limit ".$limit." offset ".$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  }
  $total_records = $pdo->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);

  $i = 0;
  if (count($records)) {
    // Building the header with sorter

    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers[] = array('display' => 'Created', 'field' => 'date_created');
    $headers[] = array('display' => 'Category', 'field' => 'Category');
    $headers[] = array('display' => 'First Name', 'field' => 'first_name');
    $headers[] = array('display' => 'Last Name', 'field' => 'last_name');
    $headers[] = array('display' => 'Comment', 'field' => 'comment');
    $headers[] = array('display' => 'Amount Type', 'field' => 'amount_type');
    $headers[] = array('display' => 'Amount', 'field' => 'amount_value');
    $headers = build_sort_header('transaction_income', 'transaction', $headers, $sort);

    foreach($records as $transaction ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']                = $transaction['id'];
      /////////////////////////////////////////////
      $rows[$j]['edit']   = theme_link_process_information('',
          'transaction_edit_form',
          'transaction_edit_form',
          'transaction',
          array('extra_value' => 'id|' . $transaction['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'transaction_delete_form',
          'transaction_delete_form',
          'transaction', array('extra_value' => 'id|' . $transaction['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $rows[$j]['date_created']          = $transaction['date_created'];
      $rows[$j]['Category']               = $transaction['Category'];
      $rows[$j]['first_name']            = $transaction['first_name'];
      $rows[$j]['last_name']             = $transaction['last_name'];
      $rows[$j]['comment']               = $transaction['comment'];
      $rows[$j]['amount_type']           = $transaction['amount_type'];
      $rows[$j]['amount_value']          = $transaction['amount_value'];
      if($transaction['amount_value'] < 0){
         $rows[$j]['listview_row_style'] = 'color:red;';
      }
      $i++;
    }
  }

  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('Income Overview'),
    'page_subtitle' => translate('Manage Income'),
    'empty_message' => translate('No transaction found!'),
    'table_prefix' => theme_link_process_information(translate('Create New Transaction'),
      'transaction_create_form',
      'transaction_create_form',
      'transaction',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('transaction_income', 'transaction', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'transaction_income',
    'module' => 'transaction',
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
function transaction_create_form() {
    $frm = new DbForm();
    return $frm->build("transaction_create_form");
}

/*
 * Insert on table
 */
function transaction_create_form_submit($data) {
  $error    = transaction_validate($data);
  if (!empty($error)) {
    return FALSE;
  }
  $transaction = new Transaction();
  $response = $transaction->create($data);
  if ( $response['id'] > 0 ) {
    return transaction_list($response['id']);
  } else {
    return false;
  }
}

/*
 * show edit form
 */
function transaction_edit_form($data) {
  $transaction = new Transaction();
  $transaction->byID($data['id']);
  $frm = new DbForm();
  $frm->build('transaction_edit_form', $transaction, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function transaction_edit_form_submit($data) {
  $error = transaction_validate($data);
  if (!empty($error)) {
    return FALSE;
  } else {
    $transaction = new Transaction();
    $update = $transaction->update($data);
    if ($update['code']==200) {
      return transaction_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function transaction_delete_form($data) {
  $transaction = new Transaction();
  $transaction->byID($data['id']);
  //$transaction->loadSingle('id='.$data['transaction_id']);
  if($transaction->affected>0){
    $frm = new DbForm();
    $frm->build('transaction_delete_form', $transaction, $_SESSION['log_access_level']);
  }else{
    return FALSE;
  }
}

/*
 * Remove from table
 */
function transaction_delete_form_submit($data) {
  $transaction = new Transaction();
  $delete = $transaction->delete($data['id']);
  if ($delete['code']==200) {
    return $data['id'];
  } else {
    return FALSE;
  }
}

/*
 * Validate data
 */
function transaction_validate($data) {
  $transaction = new Transaction();
  if (strpos($data['fn'], "edit")) {
    $type = "edit";
  }
  if (strpos($data['fn'], "delete")) {
    $type = "delete";
  }
  if (strpos($data['fn'], "create")) {
    $type = "create";
  }
  return $transaction->_validate($data, $type, false);
}

?>
