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
    $sort = 'c.name asc';
  }

  $limit = PAGER_LIMIT;
  $offset = ($page * $limit) - $limit;
  $total_records = 0;
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);

  // Search
  if (!empty($search)) {
      $search_fields = array('id', 'name', 'rowcount');
      $exceptions = array();
      $search_query = build_search_query($search, $search_fields, $exceptions);
      $sql = 'select SQL_CALC_FOUND_ROWS c.id, c.name,
                 (select count(id) from church_link where church_id = c.id and acl_levels_id = 1) visitors,
                 (select count(id) from church_link where church_id = c.id and acl_levels_id = 2) members,
                 (select count(id) from church_link where church_id = c.id and acl_levels_id = 3) pastors,
                 (select count(id) from church_link where church_id = c.id and acl_levels_id = 4) treasurers,
                 (select count(id) from church_link where church_id = c.id and acl_levels_id = 5) administrators
       from church_link cl
       left outer join church c on c.id = cl.church_id
       where cl.user_id = '.$_SESSION['log_id'].' '.$search_query.' order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  } else {
      $sql = 'select SQL_CALC_FOUND_ROWS c.id, c.name,
                   (select count(id) from church_link where church_id = c.id and acl_levels_id = 1) visitors,
                   (select count(id) from church_link where church_id = c.id and acl_levels_id = 2) members,
                   (select count(id) from church_link where church_id = c.id and acl_levels_id = 3) pastors,
                   (select count(id) from church_link where church_id = c.id and acl_levels_id = 4) treasurers,
                   (select count(id) from church_link where church_id = c.id and acl_levels_id = 5) administrators
              from church_link cl
              left outer join church c on c.id = cl.church_id
              where cl.user_id = '.$_SESSION['log_id'].' order by '.$sort.' limit '.$limit.' offset '.$offset;
      $records = $pdo->prepare($sql);
      $records->execute();
  }
  $total_records = $pdo->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
  $i = 0;
  if (count($records)) {
    // Building the header with sorter
    $headers[] = array('display' => 'Id', 'field' => 'id');
    $headers[] = array('display' => 'Church', 'field' => 'name');
    $headers[] = array('display' => 'Visitors', 'field' => 'visitors');
    $headers[] = array('display' => 'Members', 'field' => 'members');
    $headers[] = array('display' => 'Pastors', 'field' => 'pastors');
    $headers[] = array('display' => 'Treasurers', 'field' => 'treasurers');
    $headers[] = array('display' => 'Administrators', 'field' => 'administrators');
    $headers[] = array('display' => 'Access', 'field' => NULL);
    $headers = build_sort_header('church_list', 'church', $headers, $sort);

    foreach( $records as $record ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']   = $record['id'];
      /////////////////////////////////////////////
      $rows[$j]['id']       = $record['id'];
      $rows[$j]['name']     = $record['name'];
      $rows[$j]['visitors'] = $record['visitors'];
      $rows[$j]['members']  = $record['members'];
      $rows[$j]['pastors']  = $record['pastors'];
      $rows[$j]['treasurers'] = $record['treasurers'];
      $rows[$j]['administrators'] = $record['administrators'];
      $rows[$j]['account_management'] = theme_link_process_information('Manage', '', '', 'church', array('response_type' => null,
                'href' => 'jump.php?url=dashboard_church.php&church_id='.$record['id']));

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
