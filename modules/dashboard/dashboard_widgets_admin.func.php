<?
/**
 * List of Dashboard Widgets
 */
function dashboard_widgets_list($row_id=null, $search_query = NULL, $sort = NULL, $pager_current = 1) {
  $title = '<h1>Dashboard Widgets Management</h1>';
  $view = new ListView();

  // Default Values for Enabled
  $enabled = array('No', 'Yes');
	
	if ($search_query) {
		$search_fields = array('dw.id', 'dw.title', 'dw.description', 'dw.widget_function', 'dw.class', 'dw.dashboard_type', 'dw.enabled');
		$exceptions = array('dw.enabled' => $enabled);
		$search_query = build_search_query($search_query, $search_fields, $exceptions);
	}
  if($row_id) {
		$clause = 'dw.id = '. $row_id;
	}
  else {
    $clause = 'dw.id <> 0';
  }

  // Sort
	if (!$sort) {
		$sort = 'dw.id ASC';
	}

	$limit = PAGER_LIMIT;
	$start = ($pager_current * $limit) - $limit;
  // Dial List Table Object
  $dashboard_widgets = new DataManager();
	$dashboard_widgets->dm_load_custom_list("SELECT dw.id, dw.title, dw.description, dw.widget_function, dw.class, dw.dashboard_type, dw.enabled
                               FROM ".NATURAL_DBNAME.".dashboard_widgets dw
                               WHERE $clause  $search_query
                               ORDER BY  $sort
														   LIMIT  $start, $limit", 'ASSOC', TRUE);
  if($dashboard_widgets->affected>0){
    // Building the header with sorter
    $fields[] = array('display' => 'Id', 'field' => 'dw.id');
    $fields[] = array('display' => 'Title', 'field' => 'dw.title');
    $fields[] = array('display' => 'Description', 'field' => 'dw.description');
    $fields[] = array('display' => 'Function', 'field' => 'dw.widget_function');
    $fields[] = array('display' => 'Class(es)', 'field' => 'dw.class');
    $fields[] = array('display' => 'Dashboard Type', 'field' => 'dw.dashboard_type');
    $fields[] = array('display' => 'Enabled', 'field' => 'dw.enabled');
    $fields[] = array('display' => 'Edit', 'field' => NULL);
    $fields[] = array('display' => 'Delete', 'field' => null);
    $line[0] = build_sort_header('dashboard_widgets_list', 'dashboard', $fields, $sort);

		$total=0;
    for($i=0; $i < $dashboard_widgets->affected; $i++){
      $j = $i+1;
      $line[$j][0] = $dashboard_widgets->data[$i]['id'];
      $line[$j][1] = $dashboard_widgets->data[$i]['title'];
      $line[$j][2] = $dashboard_widgets->data[$i]['description'];
      $line[$j][3] = $dashboard_widgets->data[$i]['widget_function'];
      $line[$j][4] = $dashboard_widgets->data[$i]['class'];
      $line[$j][5] = $dashboard_widgets->data[$i]['dashboard_type'];
			$line[$j][6] = $enabled[$dashboard_widgets->data[$i]['enabled']];
			$line[$j][7] = '<a title="Edit" class="edit-icon pointer" onclick="proccess_information(null, \'dashboard_widgets_edit_form\', \'dashboard\', null, \'dashboard_widgets_id|'.$dashboard_widgets->data[$i]['id'].'\', null, this, \'slide\');">Edit</a>';
      $line[$j][8] = '<a title="Delete" class="delete-icon pointer" onclick="proccess_information(null, \'dashboard_widgets_remove\', \'dashboard\', \'Are you sure you want to remove this Dashboard Widget?\', \'dashboard_widgets_id|' . $dashboard_widgets->data[$i]['id'] . '\', null, this, \'remove_row\');">Delete</a>';
			$total++;
    }
		if($row_id){
			$main_list = '<td>'.$line[1][0].'</td><td>'.$line[1][1].'</td><td>'.$line[1][2].'</td><td>'.$line[1][3].'</td><td>'.$line[1][4].'</td><td>'.$line[1][5].'</td><td>'.$line[1][6].'</td><td>'.$line[1][7].'</td><td>'.$line[1][8].'</td>';
		}
    else{
		 	$main_list = $title . $view->realbuild(NULL, $line, 'dashboard_widgets_list', 'dashboard', $dashboard_widgets->total_records, $limit, $pager_current, $sort, $search_query);
		}
  }
  else{
    $main_list = $title .  build_search_form('dashboard_widgets_list', 'dashboard') . 'No Dashboard Widgets to display.';
  }
  return $main_list;
}

/*
 * Remove Dashboard Widgets
 */
function dashboard_widgets_remove($data){
  $dashboard_widgets = new DashboardWidgets();
  $dashboard_widgets->load_single('id = ' . $data['dashboard_widgets_id']);
	if($dashboard_widgets->affected) {
    $dashboard_widgets->remove('id = ' . $data['dashboard_widgets_id']);
    $resp = 'Dashboard Widget '. $data['dashboard_widgets_id'] . ' was removed sucessfully.';
	  $panel = new Panel();
	  return 	$panel->build_panel('', $resp);
  }
  else {
    return 'ERROR||Problems removing Dashboard Widget ' . $data['dashboard_widgets_id'] . '.';
  }
}

/*
 * Build the form to add a new dashboard widgets
 */
function dashboard_widgets_add_new_form() {
  $form = new DbForm();
  return $form->build('dashboard_widgets_add_new', $form);
}

/*
 * Process fields from dashboard_widgets_add_new form
 */
function dashboard_widgets_add_new($data) {
  $error = '';
  $dashboard_widgets = new DashboardWidgets();

   foreach ($data as $field => $value) {
    if ($field != 'fn') {
      $error .= dashboard_widgets_validate_fields($field, $value);
      $dashboard_widgets->$field = $value;
    }
  }
  if ($error == '') {
    $dashboard_widgets->insert();
    if ($dashboard_widgets->affected > 0) {
      return 'Dashboard widget added successfully.';
    }
    else {
      return 'ERROR||Problems to add the dashboard widget.';
    }
  }
  else {
    return 'ERROR||' . $error;
  }
}

/**
 * This function builds the dashboard widget form to edit
 */
function dashboard_widgets_edit_form($data) {
  $dashboard_widgets = new DashboardWidgets();
  $dashboard_widgets->load_single('id = ' . $data['dashboard_widgets_id']);
  if ($dashboard_widgets->affected) {
    $form = new DbForm();
    $resp = $form->build('dashboard_widgets_edit', $dashboard_widgets);
    $panel = new Panel();
	  return 	$panel->build_panel('', $resp, '');
  }
  else {
    return 'ERROR||Problems editing Dashboard Widget ' . $data['dashboard_widgets_id'] . '.';
  }
}

/**
 * Dashboard Widgets Edit
 */
function dashboard_widgets_edit($data) {
  $dashboard_widgets = new DashboardWidgets();
  $dashboard_widgets->load_single('id = ' . $data['id']);
  if ($dashboard_widgets->affected) {
    $error = '';
    foreach ($data as $field => $value) {
		  if (property_exists($dashboard_widgets, $field)) {
			  $dashboard_widgets->$field = $data[$field];
			}
			$error .= dashboard_widgets_validate_fields($field, $value);
		}
		if ($error == '') {
      $dashboard_widgets->update('id = ' . $data['id']);
      return 'Dashboard Widget ' . $data['id'] . ' was updated successfully. ||' . dashboard_widgets_list($data['id']);
    }
    else {
      return 'ERROR||' . $error;
    }
  }
  else {
    return 'ERROR||Problems editing Dashboard Widget ' . $data['id'] . '.';
  }
}

/**
 * Fields validation for dashboard_widgets
 */
function dashboard_widgets_validate_fields($field, $value) {
	$field_name = ucwords(str_replace('_', ' ', $field));
	switch ($field) {
		case 'title':
    case 'description':
    case 'widget_function':
    case 'class':
    case 'dashboard_type':
			if ($value == '') {
				return '<br/>Value is required for ' . $field_name . '.';
			}
	    break;
	}
}
?>
