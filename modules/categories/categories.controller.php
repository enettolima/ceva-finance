<?php
/**
 * List items
 */
function categories_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
  $view = new ListView();
  // Row Id for update only row
  if (!empty($row_id)) {
    $row_id = 'tt.id = ' . $row_id;
  } else {
    $row_id = 'tt.id != 0';
  }

  // Sort
  if (empty($sort)) {
    $sort = 'tt.type_id, tt.name asc';
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
      $sql = "select SQL_CALC_FOUND_ROWS tt.id, tt.name, tt.budget, (case tt.type_id when 0 then 'Income' else 'Withdraw' end) type from categories tt
              where tt.church_id = ".$_SESSION['log_church_id']." and ".$search_query." order by ".$sort." limit ".$limit." offset ".$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  } else {
      $sql = "select SQL_CALC_FOUND_ROWS tt.id, tt.name, tt.budget, (case tt.type_id when 0 then 'Income' else 'Withdraw' end) type  from categories tt
              where tt.church_id = ".$_SESSION['log_church_id']."  order by ".$sort." limit ".$limit." offset ".$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  }
  $total_records = $pdo->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);

  $i = 0;
  if (count($records)) {
    // Building the header with sorter
    $headers[] = array('display' => 'Type', 'field' => 'type');
    $headers[] = array('display' => 'Name', 'field' => 'name');
    $headers[] = array('display' => 'Budget', 'field' => 'budget');
    $headers[] = array('display' => 'Edit', 'field' => NULL);
    $headers[] = array('display' => 'Delete', 'field' => NULL);
    $headers = build_sort_header('categories_list', 'categories', $headers, $sort);

    foreach( $records as $record ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']   = $record['id'];
      /////////////////////////////////////////////
      $rows[$j]['type']   = $record['type'];
      $rows[$j]['name']   = $record['name'];
      $rows[$j]['budget'] = $record['budget'];
      $rows[$j]['edit']   = theme_link_process_information('',
          'categories_edit_form',
          'categories_edit_form',
          'categories',
          array('extra_value' => 'id|' . $record['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_EDIT_ICON));
      $rows[$j]['delete'] = theme_link_process_information('',
          'categories_delete_form',
          'categories_delete_form',
          'categories', array('extra_value' => 'id|' . $record['id'],
              'response_type' => 'modal',
              'icon' => NATURAL_REMOVE_ICON));
      $i++;
    }
  }

  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('Categories List'),
    'page_subtitle' => translate('Manage Categories'),
    'empty_message' => translate('No category found!'),
    'table_prefix' => theme_link_process_information(translate('Create New Category'),
      'categories_create_form',
      'categories_create_form',
      'categories',
      array('response_type' => 'modal')),
    'pager_items' => build_pager('categories_list', 'categories', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'categories_list',
    'module' => 'categories',
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
function categories_create_form() {
    $frm = new DbForm();
    return $frm->build("categories_create_form");
}

/*
 * Insert on table
 */
function categories_create_form_submit($data) {
  $error    = categories_validate($data);
  if (!empty($error)) {
    return FALSE;
  }
  $categories = new Categories();
  $response = $categories->create($data);
  if ( $response['id'] > 0 ) {
    return categories_list($response['id']);
  } else {
    return false;
  }
}

/*
 * show edit form
 */
function categories_edit_form($data) {
  $categories = new Categories();
  $categories->byID($data['id']);
  $frm = new DbForm();
  $frm->build('categories_edit_form', $categories, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function categories_edit_form_submit($data) {
  $error = categories_validate($data);
  if (!empty($error)) {
    return FALSE;
  } else {
    $categories = new Categories();
    $update = $categories->update($data);
    if ($update['code']==200) {
      return categories_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function categories_delete_form($data) {
  $categories = new Categories();
  $categories->byID($data['id']);
  //$categories->loadSingle('id='.$data['categories_id']);
  if($categories->affected>0){
    $frm = new DbForm();
    $frm->build('categories_delete_form', $categories, $_SESSION['log_access_level']);
  }else{
    return FALSE;
  }
}

/*
 * Remove from table
 */
function categories_delete_form_submit($data) {
  $categories = new Categories();
  $delete = $categories->delete($data['id']);
  if ($delete['code']==200) {
    return $data['id'];
  } else {
    return FALSE;
  }
}

/*
 * Validate data
 */
function categories_validate($data) {
  $categories = new Categories();
  if (strpos($data['fn'], "edit")) {
    $type = "edit";
  }
  if (strpos($data['fn'], "delete")) {
    $type = "delete";
  }
  if (strpos($data['fn'], "create")) {
    $type = "create";
  }
  return $categories->_validate($data, $type, false);
}

?>
