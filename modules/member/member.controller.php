<?php
/**
 * List items
 */
function member_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
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
    $search_fields = array('id', 'church_id', 'name');
    $exceptions = array();
    $search_query = build_search_query($search, $search_fields, $exceptions);
    
    $members = $db->member()
    ->where($row_id)
    ->and($search_query)
    ->order($sort)
    ->limit($limit, $offset);
  } else {
    $members = $db->member()
    ->where($row_id)
    ->order($sort)
    ->limit($limit, $offset);
  }
  $total_records = $db->member()->count("*");
  
  $i = 0;
  if (count($members)) {
    // Building the header with sorter
    $headers[] = array('display' => 'Id', 'field' => 'id');
    $headers[] = array('display' => 'Church Id', 'field' => 'church_id');
    $headers[] = array('display' => 'Name', 'field' => 'name');
    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers = build_sort_header('member_list', 'member', $headers, $sort);

    foreach( $members as $member ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']   = $member['id'];
      /////////////////////////////////////////////
      $rows[$j]['id']       = $member['id'];
      $rows[$j]['church_id']   = $member['church_id'];
      $rows[$j]['name'] = $member['name'];
      $rows[$j]['edit']   = theme_link_process_information('',
          'member_edit_form',
          'member_edit_form',
          'member',
          array('extra_value' => 'id|' . $member['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'member_delete_form',
          'member_delete_form',
          'member', array('extra_value' => 'id|' . $member['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $i++;
    }
  }
  
  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('Members List'),
    'page_subtitle' => translate('Manage Members'),
    'empty_message' => translate('No member found!'),
    'table_prefix' => theme_link_process_information(translate('Create New Member'),
      'member_create_form',
      'member_create_form',
      'member',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('member_list', 'member', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'member_list',
    'module' => 'member',
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
function member_create_form() {
    $frm = new DbForm();
    return $frm->build("member_create_form");
}

/*
 * Insert on table
 */
function member_create_form_submit($data) {
  $error    = member_validate($data);
  if (!empty($error)) {
    return FALSE;
  }
  $member = new Member();
  $response = $member->create($data);
  if ( $response['id'] > 0 ) {
    return member_list($response['id']);
  } else {
    return false;
  }
}

/*
 * show edit form
 */
function member_edit_form($data) {
  $member = new Member();
  $member->byID($data['id']);
  $frm = new DbForm();
  $frm->build('member_edit_form', $member, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function member_edit_form_submit($data) {
  $error = member_validate($data);
  if (!empty($error)) {
    return FALSE;
  } else {
    $member = new Member();
    $update = $member->update($data);
    if ($update['code']==200) {
      return member_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function member_delete_form($data) {
  $member = new Member();
  $member->byID($data['id']);
  //$member->loadSingle('id='.$data['member_id']);
  if($member->affected>0){
    $frm = new DbForm();
    $frm->build('member_delete_form', $member, $_SESSION['log_access_level']);
  }else{
    return FALSE;   
  }
}

/*
 * Remove from table
 */
function member_delete_form_submit($data) {
  $member = new Member();
  $delete = $member->delete($data['id']);
  if ($delete['code']==200) {
    return $data['id'];
  } else {
    return FALSE;
  }
}

/*
 * Validate data
 */
function member_validate($data) {
  $member = new Member();
  if (strpos($data['fn'], "edit")) {
    $type = "edit";
  }
  if (strpos($data['fn'], "delete")) {
    $type = "delete";
  }
  if (strpos($data['fn'], "create")) {
    $type = "create";
  }
  return $member->_validate($data, $type, false);
}

?>
