<?php
/**
 * List items
 */
function contribution_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
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

  $payment_types = $db->select_option->where("upstream_name = ?", "payment_type");
  foreach ($payment_types as $payment_type) {
  	$ptype[$payment_type['value']] = $payment_type['description'];
  }

  $contribution_types = $db->select_option->where("upstream_name = ?", "contribution_type");
  foreach ($contribution_types as $contribution_type) {
  	$ctype[$contribution_type['value']] = $contribution_type['description'];
  }

  // Search
  if (!empty($search)) {
    $search_fields = array('id', 'church_id', 'member_id');
    $exceptions = array();
    $search_query = build_search_query($search, $search_fields, $exceptions);

    $contributions = $db->contribution()
    ->where($row_id)
    ->and($search_query)
    ->order($sort)
    ->limit($limit, $offset);
  } else {
    $contributions = $db->contribution()
    ->where($row_id)
    ->order($sort)
    ->limit($limit, $offset);
  }
  $total_records = $db->contribution()->count("*");

  $i = 0;
  if (count($contributions)) {
    // Building the header with sorter
    //$headers[] = array('display' => 'Id', 'field' => 'id');
    //$headers[] = array('display' => 'Church', 'field' => 'church_id');
    $headers[] = array('display' => 'Church', 'field' => 'church_name');
    $headers[] = array('display' => 'Member', 'field' => 'member_name');
    $headers[] = array('display' => 'Payment Type', 'field' => 'payment_type');
    $headers[] = array('display' => 'Contribution Type', 'field' => 'contribution_type');
    $headers[] = array('display' => 'Amount', 'field' => 'amount');
    $headers[] = array('display' => 'Date', 'field' => 'date');
    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers = build_sort_header('contribution_list', 'contribution', $headers, $sort);

    foreach( $contributions as $contribution ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']   = $contribution['id'];
      /////////////////////////////////////////////
      //$rows[$j]['id']       = $contribution['id'];

      //$rows[$j]['id']       = $contribution['id'];
      $church = new Church();
      $church = $church->byID($contribution['church_id']);

      $member = new Member();
      $member->byID($contribution['member_id']);
      $rows[$j]['church_name']   = $church['name'];
      $rows[$j]['member_name'] = $member->name;
      $rows[$j]['payment_type'] = $ptype[$contribution['payment_type_id']];
      $rows[$j]['contribution_type'] = $ctype[$contribution['contribution_type_id']];
      $rows[$j]['amount'] = $contribution['amount'];
      $rows[$j]['date'] = date("m/d/Y", strtotime($contribution['timestamp'])) ;
      $rows[$j]['edit']   = theme_link_process_information('',
          'contribution_edit_form',
          'contribution_edit_form',
          'contribution',
          array('extra_value' => 'id|' . $contribution['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'contribution_delete_form',
          'contribution_delete_form',
          'contribution', array('extra_value' => 'id|' . $contribution['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $i++;
    }
  }

  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('Contributions List'),
    'page_subtitle' => translate('Manage Contributions'),
    'empty_message' => translate('No contribution found!'),
    'table_prefix' => theme_link_process_information(translate('Create New Contribution'),
      'contribution_create_form',
      'contribution_create_form',
      'contribution',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('contribution_list', 'contribution', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'contribution_list',
    'module' => 'contribution',
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
function contribution_create_form() {
    $frm = new DbForm();
    //$frm->timestamp = "02/06/2016";
    $frm->timestamp = date("m/d/Y");
    return $frm->build("contribution_create_form", $frm, $_SESSION['log_access_level']);
}

/*
 * Insert on table
 */
function contribution_create_form_submit($data) {
  $error    = contribution_validate($data);
  if (!empty($error)) {
    return FALSE;
  }
  $contribution = new Contribution();

  $data['timestamp'] = date("Y-m-d", strtotime($data['timestamp']));
  $response = $contribution->create($data);
  if ( $response['id'] > 0 ) {
    return contribution_list($response['id']);
  } else {
    return false;
  }
}

/*
 * show edit form
 */
function contribution_edit_form($data) {
  $contribution = new Contribution();
  $contribution->byID($data['id']);
  $frm = new DbForm();
  $contribution->timestamp = date("m/d/Y", strtotime($contribution->timestamp));
  $frm->build('contribution_edit_form', $contribution, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function contribution_edit_form_submit($data) {
  $error = contribution_validate($data);
  if (!empty($error)) {
    return FALSE;
  } else {

    $contribution = new Contribution();
    $data['timestamp'] = date("Y-m-d", strtotime($data['timestamp']));
    $update = $contribution->update($data);
    if ($update['code']==200) {
      return contribution_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function contribution_delete_form($data) {
  $contribution = new Contribution();
  $contribution->byID($data['id']);
  //$contribution->loadSingle('id='.$data['contribution_id']);
  if($contribution->affected>0){
    $frm = new DbForm();
    $frm->build('contribution_delete_form', $contribution, $_SESSION['log_access_level']);
  }else{
    return FALSE;
  }
}

/*
 * Remove from table
 */
function contribution_delete_form_submit($data) {
  $contribution = new Contribution();
  $delete = $contribution->delete($data['id']);
  if ($delete['code']==200) {
    return $data['id'];
  } else {
    return FALSE;
  }
}

/*
 * Validate data
 */
function contribution_validate($data) {
  $contribution = new Contribution();
  if (strpos($data['fn'], "edit")) {
    $type = "edit";
  }
  if (strpos($data['fn'], "delete")) {
    $type = "delete";
  }
  if (strpos($data['fn'], "create")) {
    $type = "create";
  }
  return $contribution->_validate($data, $type, false);
}

?>
