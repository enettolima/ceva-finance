<?php
/**
 * List items
 */
function report_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
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
    $search_fields = array('id', 'report_name', 'report_content');
    $exceptions = array();
    $search_query = build_search_query($search, $search_fields, $exceptions);

    $reports = $db->report()
    ->where($row_id)
    ->and($search_query)
    ->order($sort)
    ->limit($limit, $offset);
  } else {
    $reports = $db->report()
    ->where($row_id)
    ->order($sort)
    ->limit($limit, $offset);
  }
  $total_records = $db->report()->count("*");

  $i = 0;
  if (count($reports)) {
    // Building the header with sorter
    $headers[] = array('display' => 'Id', 'field' => 'id');
    $headers[] = array('display' => 'Report Name', 'field' => 'report_name');
    $headers[] = array('display' => 'Pdf', 'field' => NULL);
    $headers = build_sort_header('report_list', 'report', $headers, $sort);

    foreach( $reports as $report ){
      $j = $i + 1;
      //This is important for the row update/delete
      $rows[$j]['row_id']   = $report['id'];
      /////////////////////////////////////////////
      $rows[$j]['id']       = $report['id'];
      $rows[$j]['report_name']   = $report['report_name'];
      $rows[$j]['Pdf']   = theme_link_process_information('Pdf',
          'report_pdf',
          'report_pdf',
          'report',
          array('extra_value' => 'id|' . $report['id'],
              'response_type' => 'modal'));
      $i++;
    }
  }

  $options = array(
    'show_headers' => TRUE,
    'page_title' => translate('Reports List'),
    'page_subtitle' => translate('Generate Reports'),
    'empty_message' => translate('No report found!'),
    'pager_items' => build_pager('report_list', 'report', $total_records, $limit, $page),
    'page' => $page,
    'sort' => $sort,
    'search' => $search,
    'show_search' => TRUE,
    'function' => 'report_list',
    'module' => 'report',
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
function report_create_form() {
    $frm = new DbForm();
    return $frm->build("report_create_form");
}

/*
 * Insert on table
 */
function report_create_form_submit($data) {
  $error    = report_validate($data);
  if (!empty($error)) {
    return FALSE;
  }
  $report = new Report();
  $response = $report->create($data);
  if ( $response['id'] > 0 ) {
    return report_list($response['id']);
  } else {
    return false;
  }
}

/*
 * show edit form
 */
function report_edit_form($data) {
  $report = new Report();
  $report->byID($data['id']);
  $frm = new DbForm();
  $frm->build('report_edit_form', $report, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function report_edit_form_submit($data) {
  $error = report_validate($data);
  if (!empty($error)) {
    return FALSE;
  } else {
    $report = new Report();
    $update = $report->update($data);
    if ($update['code']==200) {
      return report_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function report_delete_form($data) {
  $report = new Report();
  $report->byID($data['id']);
  //$report->loadSingle('id='.$data['report_id']);
  if($report->affected>0){
    $frm = new DbForm();
    $frm->build('report_delete_form', $report, $_SESSION['log_access_level']);
  }else{
    return FALSE;
  }
}

/*
 * Remove from table
 */
function report_delete_form_submit($data) {
  $report = new Report();
  $delete = $report->delete($data['id']);
  if ($delete['code']==200) {
    return $data['id'];
  } else {
    return FALSE;
  }
}

/*
 * Validate data
 */
function report_validate($data) {
  $report = new Report();
  if (strpos($data['fn'], "edit")) {
    $type = "edit";
  }
  if (strpos($data['fn'], "delete")) {
    $type = "delete";
  }
  if (strpos($data['fn'], "create")) {
    $type = "create";
  }
  return $report->_validate($data, $type, false);
}

?>
