<?php
/**
 * List items
 */
function bank_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
  $view = new ListView();
  // Row Id for update only row
  if (!empty($row_id)) {
    $row_id = 'id = ' . $row_id;
  } else {
    $row_id = 'id != 0';
  }

  // Sort
  if (empty($sort)) {
    $sort = 'bank_name asc';
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
      $sql = 'select SQL_CALC_FOUND_ROWS  * from bank where church_id = '.$_SESSION['log_church_id'].' and '.$search_query.' order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  } else {
      $sql = 'select SQL_CALC_FOUND_ROWS  * from bank where church_id = '.$_SESSION['log_church_id'].' order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  }
  $total_records = $pdo->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
  $i = 0;
  if (count($records)) {
    // Building the header with sorter
    $headers[] = array('display' => 'Id', 'field' => 'id');
    $headers[] = array('display' => 'Bank Name', 'field' => 'bank_name');
    $headers[] = array('display' => 'Account Number', 'field' => 'bank_account_number');
    $headers[] = array('display' => 'Comment', 'field' => 'comment');
    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers = build_sort_header('bank_list', 'bank', $headers, $sort);

    foreach($records as $bank ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']   = $bank['id'];
      /////////////////////////////////////////////
      $rows[$j]['id']       = $bank['id'];
      $rows[$j]['bank_name'] = $bank['bank_name'];
      $rows[$j]['account_number'] = $bank['bank_account_number'];
      $rows[$j]['comment'] = $bank['comment'];
      $rows[$j]['edit']   = theme_link_process_information('',
          'bank_edit_form',
          'bank_edit_form',
          'bank',
          array('extra_value' => 'id|' . $bank['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'bank_delete_form',
          'bank_delete_form',
          'bank', array('extra_value' => 'id|' . $bank['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $i++;
    }
  }

  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('Banks List'),
    'page_subtitle' => translate('Manage Banks'),
    'empty_message' => translate('No bank found!'),
    'table_prefix' => theme_link_process_information(translate('Create New Bank'),
      'bank_create_form',
      'bank_create_form',
      'bank',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('bank_list', 'bank', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'bank_list',
    'module' => 'bank',
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
function bank_create_form() {
    $frm = new DbForm();
    return $frm->build("bank_create_form");
}

/*
 * Insert on table
 */
function bank_create_form_submit($data) {
  $data['church_id'] = $_SESSION['log_church_id'];
  $data['date_created'] = date("Y-m-d");
  $data['date_lastchange'] = date("Y-m-d");
  $error    = bank_validate($data);
  if (!empty($error)) {
    return FALSE;
  }
  $bank = new Bank();
  $response = $bank->create($data);
  if ( $response['id'] > 0 ) {
    return bank_list($response['id']);
  } else {
    return false;
  }
}

/*
 * show edit form
 */
function bank_edit_form($data) {
  $bank = new Bank();
  $bank->byID($data['id']);
  $frm = new DbForm();
  $frm->build('bank_edit_form', $bank, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function bank_edit_form_submit($data) {
  $data['church_id'] = $_SESSION['log_church_id'];
  $data['date_lastchange'] = date("Y-m-d");
  $error = bank_validate($data);
  if (!empty($error)) {
    return FALSE;
  } else {
    $bank = new Bank();
    $update = $bank->update($data);
    if ($update['code']==200) {
      return bank_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function bank_delete_form($data) {
  $bank = new Bank();
  $bank->byID($data['id']);
  //$bank->loadSingle('id='.$data['bank_id']);
  if($bank->affected>0){
    $frm = new DbForm();
    $frm->build('bank_delete_form', $bank, $_SESSION['log_access_level']);
  }else{
    return FALSE;
  }
}

/*
 * Remove from table
 */
function bank_delete_form_submit($data) {
  $data['church_id'] = $_SESSION['log_church_id'];
  $bank = new Bank();
  $delete = $bank->delete($data['id']);
  if ($delete['code']==200) {
    return $data['id'];
  } else {
    return FALSE;
  }
}

/*
 * Validate data
 */
function bank_validate($data) {
  $bank = new Bank();
  if (strpos($data['fn'], "edit")) {
    $type = "edit";
  }
  if (strpos($data['fn'], "delete")) {
    $type = "delete";
  }
  if (strpos($data['fn'], "create")) {
    $type = "create";
  }
  return $bank->_validate($data, $type, false);
}

?>
