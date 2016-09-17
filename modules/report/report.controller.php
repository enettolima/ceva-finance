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

function report_contribution($data){
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);
  if (!empty($data['filter_from'])) {
      $sql = "select c.name as `category`, COALESCE(t.amount, 0) as `contribution`, c.budget from categories c
                left join (select sum(amount_value) amount, category_id from `transaction` where church_id = ".$_SESSION['log_church_id']." and `date_created` >= '".date("Y-m-d", strtotime($data['filter_from']))."' and `date_created` <= '".date("Y-m-d", strtotime($data['filter_to']))."' group by category_id) as t on t.category_id = c.id
              where c.church_id = ".$_SESSION['log_church_id']." and c.type_id = 0 order by  t.amount desc";
      $sql_users = "select  concat(u.first_name, ' ', u.last_name) fullname, COALESCE(thithe.amount, 0) thithes, COALESCE(offerings.amount, 0) offerings, COALESCE(missions.amount, 0) missions from user u
                       left join church_link cl on cl.user_id = u.id
                       left join (select sum(amount_value) amount, user_id from `transaction` where church_id = ".$_SESSION['log_church_id']." and type_id = 0 and category_id = 1001 and `date_created` >= '".date("Y-m-d", strtotime($data['filter_from']))."' and `date_created` <= '".date("Y-m-d", strtotime($data['filter_to']))."' group by user_id) as thithe on thithe.user_id = u.id
                       left join (select sum(amount_value) amount, user_id from `transaction` where church_id = ".$_SESSION['log_church_id']." and type_id = 0 and category_id = 1002 and `date_created` >= '".date("Y-m-d", strtotime($data['filter_from']))."' and `date_created` <= '".date("Y-m-d", strtotime($data['filter_to']))."' group by user_id) as offerings on offerings.user_id = u.id
                       left join (select sum(amount_value) amount, user_id from `transaction` where church_id = ".$_SESSION['log_church_id']." and type_id = 0 and category_id = 1003 and `date_created` >= '".date("Y-m-d", strtotime($data['filter_from']))."' and `date_created` <= '".date("Y-m-d", strtotime($data['filter_to']))."' group by user_id) as missions on missions.user_id = u.id
                   where cl.church_id = ".$_SESSION['log_church_id']." order by u.first_name, u.last_name";
      $sql_contributiontype = "select so.description Description, COALESCE(sum(t.amount_value), 0) Amount from `transaction` t
          left outer join select_option so on so.upstream_name = 'payment_type' and so.value = t.amount_type
          where t.church_id = ".$_SESSION['log_church_id']." and t.type_id = 0 and t.`date_created` >= '".date("Y-m-d", strtotime($data['filter_from']))."' and t.`date_created` <= '".date("Y-m-d", strtotime($data['filter_to']))."' group by t.amount_type order by amount desc";
  } else {
      $sql = "select c.name as `category`, COALESCE(t.amount, 0) as `contribution`, c.budget from categories c
            left join (select sum(amount_value) amount, category_id from `transaction` where church_id = ".$_SESSION['log_church_id']." and `date_created` >= LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH group by category_id) as t on t.category_id = c.id
              where c.church_id = ".$_SESSION['log_church_id']." and c.type_id = 0 order by t.amount desc";
      $sql_users = "select  concat(u.first_name, ' ', u.last_name) fullname, COALESCE(thithe.amount, 0) thithes, COALESCE(offerings.amount, 0) offerings, COALESCE(missions.amount, 0) missions from user u
                       left join church_link cl on cl.user_id = u.id
                       left join (select sum(amount_value) amount, user_id from `transaction` where church_id = ".$_SESSION['log_church_id']." and type_id = 0 and category_id = 1001 group by user_id) as thithe on thithe.user_id = u.id
                       left join (select sum(amount_value) amount, user_id from `transaction` where church_id = ".$_SESSION['log_church_id']." and type_id = 0 and category_id = 1002 group by user_id) as offerings on offerings.user_id = u.id
                       left join (select sum(amount_value) amount, user_id from `transaction` where church_id = ".$_SESSION['log_church_id']." and type_id = 0 and category_id = 1003 group by user_id) as missions on missions.user_id = u.id
                   where cl.church_id = ".$_SESSION['log_church_id']." order by u.first_name, u.last_name";
      $sql_contributiontype = "select so.description Description, COALESCE(sum(t.amount_value), 0) Amount from `transaction` t
          left outer join select_option so on so.upstream_name = 'payment_type' and so.value = t.amount_type
          where t.church_id = ".$_SESSION['log_church_id']." and t.type_id = 0 and t.`date_created` >= LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH group by t.amount_type order by amount desc";
  }
  $records = $pdo->prepare($sql);
  $records->execute();
  $users = $pdo->prepare($sql_users);
  $users->execute();
  $contributiontype = $pdo->prepare($sql_contributiontype);
  $contributiontype->execute();
  if (!empty($data['export'])) {
    if($records){
      switch ($data['export']) {
        case 'csv':
            $rows = $records->fetchAll(PDO::FETCH_ASSOC);
            $filename = $_SESSION['log_church_id'].'-'.date("Y-m-d", strtotime($data['filter_from'])).'-to-'.date("Y-m-d", strtotime($data['filter_to'])).'.csv';
            $output = fopen('/var/www/documents/'.$filename, 'w');
            // get header from keys
            fputcsv($output, array_keys($rows[0]));
            foreach ($rows as $row) {
                 fputcsv($output, $row); // here you can change delimiter/enclosure
            }
            fclose($output);
            header('HTTP/1.1 200 OK');
            header('Cache-Control: no-cache, must-revalidate');
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$filename);
            readfile('/var/www/documents/'.$filename);
            unlink('/var/www/documents/'.$filename);
          break;

        default:
          # code...
          break;
      }
    }
  }else{
      $options = array(
        'page_title' => translate('Report'),
        'page_subtitle' => translate('Contribution Report'),
        'categories' => $records->fetchAll(PDO::FETCH_ASSOC),
        'users' => $users->fetchAll(PDO::FETCH_ASSOC),
        'contributiontype' => $contributiontype->fetchAll(PDO::FETCH_ASSOC),
        'msg_nocategorie' => translate('You do not have categories setuped yet.'),
        'msg_contribution_categories' => translate('Contribution Categories'),
        'msg_categories' => translate('Contribution Categories'),
        'msg_contribution_in_that_period' => translate('Contribution in that period'),
        'msg_range_selected' => translate('Range Selected'),
        'msg_from' => translate('from'),
        'msg_fullname' => translate('Full Name'),
        'msg_thithe' => translate('Thithes'),
        'msg_offerings' => translate('Offerings'),
        'msg_missions' => translate('Missions'),
        'function' => 'report_list'
      );
      global $twig;
      $template = $twig->loadTemplate('report-contribution.html');
      $listview = $template->display($options);
      return $listview;
  }
}

function report_withdraw($data){
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);
  if (!empty($data['filter_from'])) {
      $sql = "select c.name as `category`, COALESCE(t.amount, 0) as `spent`, c.budget from categories c
            left join (select (sum(amount_value) * -1) amount, category_id from `transaction` where church_id = ".$_SESSION['log_church_id']." and `date_created` >= '".date("Y-m-d", strtotime($data['filter_from']))."' and `date_created` <= '".date("Y-m-d", strtotime($data['filter_to']))."' group by category_id) as t on t.category_id = c.id
              where c.church_id = ".$_SESSION['log_church_id']." and c.type_id = 1 order by  t.amount desc";
  } else {
      $sql = "select c.name as `category`, COALESCE(t.amount, 0) as `spent`, c.budget from categories c
            left join (select (sum(amount_value) * -1) amount, category_id from `transaction` where church_id = ".$_SESSION['log_church_id']." and `date_created` >= LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH group by category_id) as t on t.category_id = c.id
              where c.church_id = ".$_SESSION['log_church_id']." and c.type_id = 1 order by t.amount desc";
  }
  $records = $pdo->prepare($sql);
  $records->execute();
  if (!empty($data['export'])) {
    if($records){
      switch ($data['export']) {
        case 'csv':
            $rows = $records->fetchAll(PDO::FETCH_ASSOC);
            $filename = $_SESSION['log_church_id'].'-'.date("Y-m-d", strtotime($data['filter_from'])).'-to-'.date("Y-m-d", strtotime($data['filter_to'])).'.csv';
            $output = fopen('/var/www/documents/'.$filename, 'w');
            // get header from keys
            fputcsv($output, array_keys($rows[0]));
            foreach ($rows as $row) {
                 fputcsv($output, $row); // here you can change delimiter/enclosure
            }
            fclose($output);
            header('HTTP/1.1 200 OK');
            header('Cache-Control: no-cache, must-revalidate');
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$filename);
            readfile('/var/www/documents/'.$filename);
            unlink('/var/www/documents/'.$filename);
          break;

        default:
          # code...
          break;
      }
    }
  }else{
      $options = array(
        'page_title' => translate('Report'),
        'page_subtitle' => translate('Withdraw Report'),
        'categories' => $records->fetchAll(PDO::FETCH_ASSOC),
        'msg_nocategorie' => translate('You do not have categories setuped yet.'),
        'msg_withdraw_categories' => translate('Withdraw Categories'),
        'msg_categories' => translate('Withdraw Categories'),
        'msg_spent_in_that_period' => translate('Spent in that period'),
        'msg_monthly_budget' => translate('Monthly Budget'),
        'msg_range_selected' => translate('Range Selected'),
        'msg_from' => translate('from'),
        'msg_to' => translate('to'),
        'function' => 'report_list'
      );
      global $twig;
      $template = $twig->loadTemplate('report-withdraw.html');
      $listview = $template->display($options);
      return $listview;
  }
}


function report_pdf($data)
{
  //global $twig;
  //$template = $twig->loadTemplate('report_'.$data['id'].'.html');
  //$template->display($data);

  $filename = NATURAL_ROOT_PATH.'/documents/pdf/' . md5(microtime()) . '.pdf';
  //Go to /tcpdf/include/tcpdf_static.php
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
  $pdf->SetTitle($data['report_name']);
  $pdf->SetSubject($data['report_name']);
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
  $pdf->AddPage();
  $pdf->writeHTML(file_get_contents('/var/www/test.html', FILE_USE_INCLUDE_PATH), true, false, true, false, '');
  $pdf->Output($filename, 'F');
}

?>
