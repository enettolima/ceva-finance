<?

/*
 * Just to show the form example
 */
function natural_form_example(){
		$frm = new DbForm();
		
		$frm->first_name = "System";
		$frm->last_name = "Administrator";
		$frm->username = "admin";
		$frm->password = null;
		
		//Select the properly levels to show an example of the listbox
		$access_levels = new DataManager();
		$access_levels->dmLoadCustomList('SELECT al.description, al.level FROM acl_levels al WHERE al.level <= ' . $_SESSION['log_access_level'], 'ASSOC');
		if ($access_levels->affected) {
			$items = array();
			foreach ($access_levels->data as $access_level) {
				$items[] = ucwords($access_level['description']) . '=' . $access_level['level'];
			}
			$frm->access_level_options = implode(';', $items);
		}
		
		//Select the hobbies to show one example of multiple select
		$access_levels = new DataManager();
		$access_levels->dmLoadCustomList('SELECT al.description, al.level FROM acl_levels al WHERE al.level <= ' . $_SESSION['log_access_level'], 'ASSOC');
		if ($access_levels->affected) {
			$items = array();
			foreach ($access_levels->data as $access_level) {
				$items[] = ucwords($access_level['description']) . '=' . $access_level['level'];
			}
			$frm->access_level_options = implode(';', $items);
		}
		
		/*$user = new User();
		$user->load_single('username="admin"');
		$user->password = null;
		$user->access_level_options = implode(';', $items);*/
		$frm->build('natural_example_form', $frm, $_SESSION['log_access_level'], FALSE);
}

function natural_form_example_submit($data){
		echo 'Data from the form is:<br>';
		print_debug($data);
		
		return natural_set_message('Form has been submitted!', 'success');
}
/*
 * Functions for module management
 */
function module_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
		$view = new ListView();
		
		// Row Id for update only row
		if (!empty($row_id)) {
			$row_id = 'm.id = ' . $row_id;
		}
		else {
			$row_id = 'm.id != 0'; 
		}
	
		// Search
		if (!empty($search)) {
			$search_fields = array('m.module', 'm.label', 'm.id');
			$exceptions = array();
			$search_query = build_search_query($search, $search_fields, $exceptions);
		}
		else {
			$search_query = '';
		}
	
		// Sort
		if (empty($sort)) {
			$sort = 'm.label ASC';
		}
		
		$limit = PAGER_LIMIT; // PAGER_LIMIT
		$start = ($page * $limit) - $limit;
    // Module Object
    $modules = new DataManager();
    $modules->dmLoadCustomList("SELECT m.*
		FROM " . NATURAL_DBNAME . ".module m
		WHERE $row_id $search_query
		ORDER BY  $sort
		LIMIT  $start, $limit", 'ASSOC', TRUE);
		
    if ($modules->affected > 0) {
        // Building the header with sorter
				$headers[] = array('display' => 'Id', 'field' => 'm.id');
				$headers[] = array('display' => 'Module', 'field' => 'm.module');
				$headers[] = array('display' => 'Label', 'field' => 'm.label');
				$headers[] = array('display' => 'Delete', 'field' => NULL);
				$headers = build_sort_header('module_list', 'module', $headers, $sort);
		
        $total = 0;
        for ($i = 0; $i < $modules->affected; $i++) {
            $j = $i + 1;
            $rows[$j]['id'] = $modules->data[$i]['id'];
            $rows[$j]['module'] = $modules->data[$i]['module'];
            $rows[$j]['label'] = $modules->data[$i]['label'];
						$rows[$j]['delete'] = theme_link_process_information('', 'module_delete_form', 'module_delete_form', 'natural', array('extra_value' => 'module_id|' . $module->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON));
				}
    }

    $options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Module List'),
		'page_subtitle' => translate('Manage Module'),
		'empty_message' => translate('No module found!'),
		'table_prefix' => theme_link_process_information(translate('Create New Module'), 'module_create_form', 'module_create_form', 'natural', array('response_type' => 'modal')),
		'pager_items' => build_pager('form_list', 'natural', $module->total_records, $limit, $page),
		'page' => $page,
		'sort' => $sort,
		'search' => $search,
		'show_search' => TRUE,
		'function' => 'form_list',
		'module' => 'natural',
		'update_row_id' => '',
	  'table_form_id' => '',
		'table_form_process' => '',
	);

  $listview = $view->build($rows, $headers, $options);

  return $listview;
}

function module_create_form() {
    //Checking if license is expired
    $frm = new DbForm();
    $module = new Module();
    $query = "SHOW TABLES FROM " . NATURAL_DBNAME . " ";
    $module_opt = new DataManager();
    $module_opt->dmLoadCustomList($query, 'ASSOC');
    $items = array();
    //$items[] = 'Skipp table selection=0';
    if ($module_opt->affected) {
        foreach ($module_opt->data as $k => $v) {
            foreach ($v as $key => $value) {
                $items[] = $value . '=' . $value;
            }
        }
        $module->table_list = implode(';', $items);
    }

    //return $dbform->build('module_new', $module);
		$frm->build('module_create_form', $module, $_SESSION['log_access_level']);
}

function module_create_form_submit($data) {
    $data['project_path'] = NATURAL_WEB_ROOT;
    $data['project_name'] = NATURAL_PLATFORM;
    $data['field_1'] = 'b.name';
    $data['field_label_1'] = 'Name';
    $data['field_2'] = 'b.author';
    $data['field_label_2'] = 'Author';
    if (is_numeric($data['table_name'])) {
        $class_name = str_replace("_", " ", $data['module']);
        $data['module_name'] = $data['module'];
        $data['module'] = str_replace(" ", "_", strtolower($data['module']));
    } else {
        $class_name = str_replace("_", " ", $data['table_name']);
        $data['module_name'] = $data['table_name'];
        $data['module'] = str_replace(" ", "_", strtolower($data['table_name']));

        $query = "DESCRIBE " . NATURAL_DBNAME . "." . $data['table_name'] . "";

        $fields = new DataManager();
        $fields->dmLoadCustomList($query, 'ASSOC');
        if ($fields->affected > 0) {
            for ($i = 1; $i < 3; $i++) {
                $key = 'field_' . $i;
                $keylabel = 'field_label_' . $i;
                //$data[key] = 'b.name';
                $data[$key] = $fields->data[$i]['Field'];
                //$data[$keylabel] = 'Name';
                $data[$keylabel] = ucwords(str_replace("_", " ", strtolower($fields->data[$i]['Field'])));
            }
        }
    }
    $class_name = ucwords($class_name);
    $data['class_name'] = str_replace(" ", "", $class_name);
    $data['path'] = $data['project_path'] . "modules/" . $data['module'] . "/";
    /*
     * Validating information n the Database
     */
    $info = validate_module_info($data);
    if ($info) {
        return $info . '<br><br>';
        exit(0);
    }
    //Creating directory for the module
    create_module_structure($data);
    if ($data['create_api'] == 1) {
        create_module_api($data);
    }
    if ($data['create_forms'] == 1) {
        //calling function on natural module module/natural/natural.func.php
        create_form($data['module_name']);
    }
    if ($data['create_class']) {
        //create_module_class($data);
    }
    if ($data['create_menu'] == 1) {
        create_module_menu($data);
    }

    //Saving information to the Natural Database
    $module = new DataManager();
    //$module = new Module();
    $module->version = 1;
    $module->module = strtolower(str_replace(" ", "_", $data['module']));
    $module->label = $data['label'];
    $module->description = $data['label'];
    $module->license_quantity = 0;
    $module->last_update = date("Y-m-d H:i:s");
    $module->status = 1;
    //$module->insert();
    $module->dm_insert($_SESSION['project_db'] . "." . MODULES_TABLE, $module);
    return "Module Saved Successfully!" . module_list();
}

/*
 * Creating Module menu
 */

function create_module_menu($data) {
    //Building array of data to pass to the main menu creation
    $data['element_name'] = $data['module'] . "_main";
    $data['label'] = $data['class_name'];
    $data['title'] = $data['class_name'];
    $data['func'] = $data['module'] . "_list";
    $data['module'] = $data['module'];
    $data['allow'] = "all";
    $data['allow_value'] = 0;
    $data['status'] = 1;
    $data['initial'] = 0;
    //Adding main menu from modules/menu_nav/menu_nav.func.php
    save_main_menu($data);
    //Getting id of the main menu
    $menu = new MainMenu();
    $menu->load_single("element_name='" . $data['element_name'] . "'");
    $data['main_menu_id'] = $menu->id;
    $data['element_name'] = $data['module'] . "_sub";
    $data['label'] = "List";
    $data['title'] = "List";
    save_new_submenu($data);
    //Adding submenu Add for the object
    $data['func'] = $data['module'] . "_add_form";
    $data['element_name'] = $data['module'] . "_add_sub";
    $data['label'] = "Add New";
    $data['title'] = "Add New";
    save_new_submenu($data);
}

/*
 * Creating module structure
 */

function create_module_structure($data) {
    //Creating folder for the new module
    mkdir($data['path'], 0777);
    $files = array('index.php', 'view.php', 'model.php', 'controller.php');
    //Creating files
    create_module_file($files, $data);
}

/*
 * Creating module files
 */

function create_module_file($files, $data) {
    if (is_numeric($data['table_name'])) {
        $name = $data['module'];
    } else {
        $name = $data['table_name'];
    }
    foreach ($files as $k => $v) {
        if ($v == "index.php") {
            $file = file_get_contents("../../data/module_template/index.php");
        } else {
            $file = file_get_contents("../../data/module_template/book." . $v);
        }
        // Do tag replacements or whatever you want
        $file = str_replace("book", $name, $file);
        $file = str_replace("Book", $data['class_name'], $file);
        $file = str_replace("name", $data['field_1'], $file);
        $file = str_replace("Name", $data['field_label_1'], $file);
        $file = str_replace("author", $data['field_2'], $file);
        $file = str_replace("Author", $data['field_label_2'], $file);
        //save it back:
        if ($v == "index.php") {
            file_put_contents($data['path'] . "index.php", $file);
        } else {
            file_put_contents($data['path'] . $name . "." . $v, $file);
        }
    }
}

/*
 * Validating module information
 */

function validate_module_info($data, $edit = false) {
    if (!$data['module']) {
        return 'ERROR||Invalid Module Name, this field is required!';
        exit(0);
    }
    if (!$data['label']) {
        return 'ERROR||Invalid Label, this field is required!';
        exit(0);
    }
    if (file_exists($data['path'])) {
        return 'ERROR||The directory <i>' . $data['module'] . '</i> already exists!<br>Please try a different name or remove the current module!';
    }
    if ($data['create_forms'] == 1) {
        $query = "SELECT * FROM " . $_SESSION['project_db'] . ".form_parameters WHERE form_id = '" . $data['table_name'] . "_new' 
            OR form_id = '" . $data['table_name'] . "_edit' 
            OR form_id = '" . $data['table_name'] . "_view'";
        $form = new DataManager();
        $form->dmLoadCustomList($query, 'ASSOC');
        if ($form->affected > 0) {
            return 'ERROR||The form for the module <i>' . $data['module'] . '</i> already exists!';
        }
    }
    if ($data['create_menu'] == 1) {
        $query = "SELECT * FROM " . $_SESSION['project_db'] . ".main_menu WHERE element_name = '" . $data['module'] . "_main'";
        $form = new DataManager();
        $form->dmLoadCustomList($query, 'ASSOC');
        if ($form->affected > 0) {
            return 'ERROR||Menu for the module <i>' . $data['module'] . '</i> already exists!';
        }
    }
}

/*
 * Create API reference on api/index.php inside of the project
 */

function create_module_api($data) {
    //Creating strings to add to the api/index.php inside 
    $new_api = "require_once('SimpleAuth.php');\nrequire_once('../modules/" . $data['module_name'] . "/" . $data['module_name'] . ".model.php');";
    $set_api = "\$r = new Restler();\n\$r->addAPIClass('" . $data['class_name'] . "');";
    $file = file_get_contents($data['project_path'] . "api/index.php");
    if (!strpos(file_get_contents($data['project_path'] . "api/index.php"), "\$r->addAPIClass('" . $data['class_name'] . "');") !== false) {
        //If string of the API not found, include t the api/index.php
        // Do tag replacements or whatever you want
        $file = str_replace("require_once('SimpleAuth.php');", $new_api, $file);
        $file = str_replace('$r = new Restler();', $set_api, $file);
        //save it back
        file_put_contents($data['project_path'] . "api/index.php", $file);
    }
}

/**
 * Module Remove
 */
function module_remove($data) {
    $module = new DataManager();
    $module->dm_load_single($_SESSION['project_db'] . "." . MODULES_TABLE,"id='{$data['module_id']}'");
    //$module->dm_load_single($table, $search_str)
    $name = $module->name;
    if (!$module->affected) {
        return "ERROR|19109|Module Not Found, Please contact your system administrator!";
        exit(0);
    }
    $module->dm_remove($_SESSION['project_db'] . "." . MODULES_TABLE,"id='{$data['module_id']}'");
    if ($module->affected) {
        return "Module {$name} was removed successfully!<br>NOTE: Database and module structure was not removed!";
    } else {
        return "We could not remove the Module {$name} at this time, please try again!<br>If the problem persists, contact your system administrator!";
    }
}











/*
 * START OF THE FORM MANAGEMENT
 */

function form_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
		$view = new ListView();
		
		// Row Id for update only row
		if (!empty($row_id)) {
			$row_id = 'f.id = ' . $row_id;
		}
		else {
			$row_id = 'f.id != 0'; 
		}
	
		// Search
		if (!empty($search)) {
			$search_fields = array('f.form_name', 'f.form_title', 'f.id');
			$exceptions = array();
			$search_query = build_search_query($search, $search_fields, $exceptions);
		}
		else {
			$search_query = '';
		}
	
		// Sort
		if (empty($sort)) {
			$sort = 'f.form_name ASC';
		}
		
		$limit = PAGER_LIMIT; // PAGER_LIMIT
		$start = ($page * $limit) - $limit;
    // Module Object
    $forms = new DataManager();
    $forms->dmLoadCustomList("SELECT f.*
		FROM " . NATURAL_DBNAME . ".form_templates f
		WHERE $row_id $search_query
		ORDER BY  $sort
		LIMIT  $start, $limit", 'ASSOC', TRUE);
		
    if ($forms->affected > 0) {
        // Building the header with sorter
				$headers[] = array('display' => 'Id', 'field' => 'f.id');
				$headers[] = array('display' => 'Name', 'field' => 'f.form_name');
				$headers[] = array('display' => 'Title', 'field' => 'f.form_title');
				$headers[] = array('display' => 'Edit', 'field' => NULL);
				$headers[] = array('display' => 'Delete', 'field' => NULL);
				$headers = build_sort_header('form_list', 'natural', $headers, $sort);
		
        $total = 0;
        for ($i = 0; $i < $forms->affected; $i++) {
            $j = $i + 1;
						//This is important for the row update
            $rows[$j]['row_id'] = $forms->data[$i]['id'];
            //////////////////////////////////////
						
						if($forms->data[$i]['system']){
								
						}
            $rows[$j]['id'] = $forms->data[$i]['id'];
            $rows[$j]['form_name'] = $forms->data[$i]['form_name'];
						$rows[$j]['form_title'] = $forms->data[$i]['form_title'];
						$rows[$j]['edit']   = theme_link_process_information('', 'form_edit_form', 'form_edit_form', 'natural', array('extra_value' => 'id|' . $forms->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_EDIT_ICON));
            $rows[$j]['delete'] = theme_link_process_information('', 'form_delete_form', 'form_delete_form', 'natural', array('extra_value' => 'id|' . $forms->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON));
				}
    }

    $options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Form List'),
		'page_subtitle' => translate('Manage Forms'),
		'empty_message' => translate('No form found!'),
		'table_prefix' => theme_link_process_information(translate('Create New Form'), 'form_create_form', 'form_create_form', 'natural', array('response_type' => 'modal')),
		'pager_items' => build_pager('module_list', 'natural', $forms->total_records, $limit, $page),
		'page' => $page,
		'sort' => $sort,
		'search' => $search,
		'show_search' => TRUE,
		'function' => 'module_list',
		'module' => 'natural',
		'update_row_id' => '',
	  'table_form_id' => '',
		'table_form_process' => '',
	);

  $listview = $view->build($rows, $headers, $options);

  return $listview;
}

function form_create_form() {
    $frm = new DbForm();
    return $frm->build("form_create_form");
}

function form_create_form_submit($data) {
    $dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
    foreach ($data as $key => $value) {
        if ($key != "fn") {
            $query_fields .= ", {$key}='" . mysql_real_escape_string($value) . "'";
        }
    }
    //Try to find another Database with the same name.
    $check_query = "SELECT * FROM " . NATURAL_DBNAME . "." . FORM_TABLE . " WHERE form_name='{$data['form_name']}'";
    $query_check = mysql_query($check_query, $dblink) or die("ERROR|1011|We could not save this form at this time cause:" . mysql_error() . "<br>" . $check_query);
    if (mysql_affected_rows()) {
				natural_set_message('Sorry but this form name already exist, please try again with different name!', 'error');
        return false;
        exit(0);
    }

    $query_fields = substr($query_fields, 1);

    $query = "INSERT INTO " . NATURAL_DBNAME . "." . FORM_TABLE . " SET {$query_fields}";
    $query_result = mysql_query($query, $dblink) or die("ERROR|1011|We could not save this form at this time cause:" . mysql_error() . "<br>" . $query . "<br>" . $query_fields);
    $affected = mysql_affected_rows();
		//print_debug($query_result);
		if($affected>0){
				natural_set_message('Form '.$data['form_name'].' saved successfully!', 'success');
				return form_list($book->id);
		}else{
				natural_set_message('Form '.$data['form_name'].' could not be saved!', 'error');
				return false;
		}
}

function form_edit_form($data){
		//print_debug($data);
		$form = new DataManager();
		$form->dmLoadSingle(NATURAL_DBNAME . "." . FORM_TABLE, 'id='.$data['id']);
		$frm = new DbForm();
    return $frm->build("form_edit_form", $form, $_SESSION['log_access_level']);
}

function form_edit_form_submit($data){
		$dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
    foreach ($data as $key => $value) {
        if ($key=="fn" || $key=="id") {
						//skip for the query
				}else{
            $query_fields .= ", {$key}='" . mysql_real_escape_string($value) . "'";
        }
    }
		
    $query_fields = substr($query_fields, 1);
		//Updating form parameters.
    $check_query = "UPDATE " . NATURAL_DBNAME . "." . FORM_TABLE . " SET {$query_fields} WHERE id='{$data['id']}'";
		$query_check = mysql_query($check_query, $dblink) or die("ERROR|1011|We could not save this form at this time cause:" . mysql_error());
    if (mysql_affected_rows()) {
        natural_set_message('Form '.$data['form_name'].' saved successfully!', 'success');
				return form_list($data['id']);
    }
}

function form_delete_form($data){
		$form = new DataManager();
    $form->dmLoadSingle(NATURAL_DBNAME . "." . FORM_TABLE, 'id='.$data['id']);
    if($form->affected>0){
        $frm = new DbForm();
        $frm->build('form_delete_form', $form, $_SESSION['log_access_level']);
    }else{
        natural_set_message('Problems loading Form ' . $data['id'], 'error');
        return FALSE;   
    }
}

function form_delete_form_submit($data){
		$form = new DataManager();
		$form->dmLoadSingle(NATURAL_DBNAME . "." . FORM_TABLE, 'id='.$data['id']);
		$name = $form->form_title;
		$form->dmRemove(NATURAL_DBNAME . "." . FORM_TABLE, 'id='.$data['id']);
		
		$fields = new DataManager();
		$fields->dmRemove(NATURAL_DBNAME . "." . FIELD_TABLE, 'form_template_id='.$data['id']);
		if($form->affected>0){
				natural_set_message('Form '.$name.' has been removed successfully!', 'success');
				return $data['id'];
		}else{
				natural_set_message('Could not remove the form '.$name.'!', 'error');
				return FALSE;
		}
}

/*
 * FIELD MANAGEMENT
 */
function field_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
		$view = new ListView();
		
		// Row Id for update only row
		if (!empty($row_id)) {
			$row_id = 'f.id = ' . $row_id;
		}
		else {
			$row_id = 'f.id != 0'; 
		}
	
		// Search
		if (!empty($search)) {
			$search_fields = array('f.form_reference', 'f.field_name', 'f.html_type', 'f.id', 'f.def_label');
			$exceptions = array();
			$search_query = build_search_query($search, $search_fields, $exceptions);
		}
		else {
			$search_query = '';
		}
	
		// Sort
		if (empty($sort)) {
			$sort = 'f.form_reference ASC';
		}
		
		$limit = PAGER_LIMIT; // PAGER_LIMIT
		$start = ($page * $limit) - $limit;
    // Module Object
    $field = new DataManager();
    $field->dmLoadCustomList("SELECT f.*
		FROM " . NATURAL_DBNAME . ".field_templates f
		WHERE $row_id $search_query
		ORDER BY  $sort
		LIMIT  $start, $limit", 'ASSOC', TRUE);
		
    if ($field->affected > 0) {
        // Building the header with sorter
				$headers[] = array('display' => 'Id', 'field' => 'f.id');
				$headers[] = array('display' => 'Form Reference', 'field' => 'f.form_reference');
				$headers[] = array('display' => 'Position', 'field' => 'f.form_field_order');
				$headers[] = array('display' => 'Name', 'field' => 'f.field_name');
				$headers[] = array('display' => 'HTML Type', 'field' => 'f.html_type');
				$headers[] = array('display' => 'Label', 'field' => 'f.def_label');
				$headers[] = array('display' => 'Edit', 'field' => NULL);
				$headers[] = array('display' => 'Delete', 'field' => NULL);
				$headers = build_sort_header('field_list', 'natural', $headers, $sort);
		
        $total = 0;
        for ($i = 0; $i < $field->affected; $i++) {
            $j = $i + 1;
						//This is important for the row update
            $rows[$j]['row_id'] = $field->data[$i]['id'];
            //////////////////////////////////////
						$rows[$j]['id'] = $field->data[$i]['id'];
            $rows[$j]['form_reference'] = $field->data[$i]['form_reference'];
						$rows[$j]['form_field_order'] = $field->data[$i]['form_field_order'];
						$rows[$j]['field_name'] = $field->data[$i]['field_name'];
						$rows[$j]['html_type'] = $field->data[$i]['html_type'];
						$rows[$j]['def_label'] = $field->data[$i]['def_label'];
						$rows[$j]['edit']   = theme_link_process_information('', 'field_edit_form', 'field_edit_form', 'natural', array('extra_value' => 'id|' . $field->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_EDIT_ICON));
            $rows[$j]['delete'] = theme_link_process_information('', 'field_delete_form', 'field_delete_form', 'natural', array('extra_value' => 'id|' . $field->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON));
				}
    }

    $options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Field List'),
		'page_subtitle' => translate('Manage Fields'),
		'empty_message' => translate('No field found!'),
		'table_prefix' => theme_link_process_information(translate('Create New Field'), 'field_create_form', 'field_create_form', 'natural', array('response_type' => 'modal')),
		'pager_items' => build_pager('field_list', 'natural', $field->total_records, $limit, $page),
		'page' => $page,
		'sort' => $sort,
		'search' => $search,
		'show_search' => TRUE,
		'function' => 'field_list',
		'module' => 'natural',
		'update_row_id' => '',
	  'table_form_id' => '',
		'table_form_process' => '',
	);

  $listview = $view->build($rows, $headers, $options);

  return $listview;
}

function field_create_form(){
		$frm = new DbForm();
    $frm->build('field_create_form', $ref, $_SESSION['log_access_level']);
}

function field_create_form_submit($data){
		$fields = new FieldTemplates();
		$fields->loadList('ASSOC','form_template_id='.$data['form_reference']);
		$affected = $fields->affected;
		
		$field = new FieldTemplates();
		foreach ($data as $key => $value) {
        if ($key != "fn") {
            if ($key == "form_field_order") {
                $field->$key = $affected;
            } else {
                $field->$key = mysql_real_escape_string($value);
            }
        }
    }
		
		$form = new DataManager();
		$form->dmLoadSingle(NATURAL_DBNAME . "." . FORM_TABLE, 'id='.$data['form_reference']);
		$field->form_reference = $form->form_name;
		$field->form_template_id = $data['form_reference'];

    $field->insert();
		if($field->affected > 0){
				natural_set_message('Field saved successfully!', 'success');
				return field_list($field->id);
		}else{
				natural_set_message('Field could not be saved!', 'error');
				return false;
		}
}

function field_edit_form($data){
		$ff = new FieldTemplates();
    $ff->loadSingle("id='{$data['id']}'");
		$ff->form_reference = $ff->form_template_id;
    $form = new DbForm();
    $form->build("field_edit_form", $ff, $_SESSION['log_access_level']);
}

function field_edit_form_submit($data){
		$ff = new FieldTemplates();
    $ff->loadSingle("id='{$data['id']}'");
		foreach ($data as $key => $value) {
        //if ($key == "fn" || $key == "id") {
				if ($key != 'affected' && $key != 'errorcode' && $key != 'data' && $key != 'dbid' && $key != 'id' && $key != 'fn') {
						$ff->$key = mysql_real_escape_string($value);
        }
    }
		
		$form = new DataManager();
		$form->dmLoadSingle(NATURAL_DBNAME . "." . FORM_TABLE, 'id='.$data['form_reference']);
		$ff->form_reference = $form->form_name;
		$ff->form_template_id = $data['form_reference'];
		
		$ff->update("id='{$data['id']}'");
		if($ff->affected > 0){
				natural_set_message('Field saved successfully!', 'success');
				return field_list($ff->id);
		}else{
				natural_set_message('Field could not be saved!', 'error');
				return false;
		}
}

function field_delete_form($data){
		$field = new FieldTemplates();
		$field->loadSingle('id='.$data['id']);
		$frm = new DbForm();
    $frm->build('field_delete_form', $field, $_SESSION['log_access_level']);
}

function field_delete_form_submit($data){
		$field = new FieldTemplates();
		$field->loadSingle('id='.$data['id']);
		if($field->affected>0){
				$name = $field->name;
				$field->remove('id='.$data['id']);
				natural_set_message('Field '.$name.' has been removed successfully!', 'success');
        return $data['id'];
    }else{
        natural_set_message('Problems loading field ' . $data['id'], 'error');
        return FALSE;   
    }
}

function class_form_creator_form(){
		$frm = new DbForm();
		$query = "SHOW TABLES FROM " . NATURAL_DBNAME . "";
		$dm = new DataManager();
		$dm->dmLoadCustomList($query, 'ASSOC');
		if ($dm->affected) {
        foreach ($dm->data as $k => $v) {
            foreach ($v as $key => $value) {
                $items[] = $value . '=' . $value;
            }
        }
        $dm->table_options = implode(';', $items);
    }
		$dm->type = array('class', 'form');
    $frm->build('class_form_create_form', $dm, $_SESSION['log_access_level']);
}

function class_form_creator_form_submit($data){
		$ft = new DataManager;
    $table = NATURAL_DBNAME . "." . FIELD_TABLE;
    $table_name = trim($table_name);
    $class_ar = explode("_", $table_name);
    if (is_array($class_ar)) {
        for ($i = 0; $i < count($class_ar); $i++) {
            $class_name .= ucfirst($class_ar[$i]);
        }
    }
    $dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

    if (!$dblink) {
        die('Could not connect: ' . mysql_error());
    }
    $today = date("m-d-Y H:i:s");
    $now = date("M-D-Y");
    $query = "SHOW COLUMNS FROM " . NATURAL_DBNAME . ".{$table_name}";
    $query_result = mysql_query($query, $dblink);
    $counter = 0;
    if ($query_result) {
        $myFile = "{$table_name}.class.php";
        $fp = fopen($myFile, 'w') or die("can't open file");
        fwrite($fp, "<?\n");
        $doc = " /** 
* NATURAL - Created by Open Source Mind, LLC
* Last Modified: Date: {$today} -0500 ({$now}) \$ @ Revision: \$Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ \n\n";

        fwrite($fp, $doc);

        $upper_table = ucfirst($table_name);
        $top_class = "\tclass {$class_name} Extends DataManager{\n";
        fwrite($fp, $top_class);


        $dec_var = "";
        $form_ar_edit = "";

        //Creating Insert Form
        $i = 0;
        $c = 0;

        $funcs1 = "\t\tpublic function load_single(\$search_str){
      parent::dm_load_single(".NATURAL_DBNAME." . \"$table_name\",\$search_str);
		}
     
    public function load_list(\$output, \$search_str){
      parent::dm_load_list(".NATURAL_DBNAME." . \".$table_name\", \$output, \$search_str);
    }

    public function insert(){
      parent::dm_insert(".NATURAL_DBNAME." . \".$table_name\", \$this);
      \$this->id = \$this->dbid;
    }

    public function update(\$upd_rule){
      parent::dm_update(".NATURAL_DBNAME." . \".$table_name\", \$upd_rule, \$this);
    }

    public function remove(\$rec_key){
      parent::dm_remove(".NATURAL_DBNAME." . \".$table_name\", \$rec_key);
    }
  }
  
?>";

        fwrite($fp, $funcs1);

        fclose($fp);
        return "Class for table {$table_name} built successfully!<br>";
    } else {
        echo "We could not find any data with this search criteria " . mysql_error();
    }
}
/*
 * END OF THE FORM MANAGEMENT
 */




function save_new_form($data) {
    foreach ($data as $key => $value) {
        if ($key != "fn") {
            $query_fields .= ", {$key}='" . mysql_real_escape_string($value) . "'";
        }
    }
    $dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
    //Try to find another Database with the same name.
    $check_query = "SELECT * FROM " . NATURAL_DBNAME . ".form_parameters WHERE form_name='{$data['form_name']}'";
    $query_check = mysql_query($check_query, $dblink) or die("ERROR|1011|We could not save this form at this time cause:" . mysql_error());
    if (mysql_affected_rows()) {
        echo "ERROR|8899|Sorry but this form name already exist, please try again with different name!";
        exit(0);
    }

    $query_fields = substr($query_fields, 1);

    $query = "INSERT INTO " . NATURAL_DBNAME . ".form_parameters SET {$query_fields}";
    $query_result = mysql_query($query, $dblink) or die("ERROR|1011|We could not save this form at this time cause:" . mysql_error());
    $affected = mysql_affected_rows();

    echo "Form {$data['form_name']} saved successfully!<br>click on the edit button on the list to add fields to any form!";
}

function delete_form($data) {
    $dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
    //Try to find another Database with the same name.
    $check_query = "SELECT form_name FROM " . NATURAL_DBNAME . ".form_parameters WHERE id='{$data['formid']}'";
    $query_check = mysql_query($check_query, $dblink) or die("ERROR|1011|We could not save this form at this time cause:" . mysql_error());
    $row = mysql_fetch_array($query_check);
    $form_name = $row['form_name'];
    $file_name = $form_name . ".form.php";

    $del1 = "DELETE FROM " . NATURAL_DBNAME . ".form_parameters WHERE form_name='{$form_name}'";
    $query_del1 = mysql_query($del1, $dblink) or die("ERROR|1011|We could not delete this form at this time cause:" . mysql_error());

    $del1 = "DELETE FROM " . NATURAL_DBNAME . ".field_templates WHERE form_reference='{$form_name}'";
    $query_del1 = mysql_query($del1, $dblink) or die("ERROR|1011|We could not delete this form at this time cause:" . mysql_error());

    $remove_file = `rm -f ../../lib/forms/{$file_name}`;
    echo "Form {$form_name} deteled successfully!";
    echo list_forms("all");
}

function edit_form_param($data) {
    require_once(NATURAL_LIB_PATH . 'forms/form_edit.form.php');
    $frm = new Form_edit();
    $ft = new DataManager();
    $ft->dm_load_single("ben.form_parameters", "id='{$data['formid']}'");

    echo $frm->form_edit_form($ft);
}

function save_form_param($data) {
    foreach ($data as $key => $value) {
        if ($key != "fn") {
            $query_fields .= ", {$key}='" . mysql_real_escape_string($value) . "'";
        }
    }
    $dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
    $query_fields = substr($query_fields, 1);
    //Updating form parameters.
    $check_query = "UPDATE " . NATURAL_DBNAME . ".form_parameters SET {$query_fields} WHERE id='{$data['id']}'";
    $query_check = mysql_query($check_query, $dblink) or die("ERROR|1011|We could not save this form at this time cause:" . mysql_error());
    if (mysql_affected_rows()) {
        echo "Form Saved Successfully!";
//    $build_form_class = build_forms($data['form_name']);
        echo list_forms("all");
    }
}

function edit_form_fields($data) {
    $ft = new DataManager();
    $ff = new DataManager();
    $ff->dm_load_single("ben.form_parameters", "id='{$data['formid']}'");
    $formname = $ff->form_name;
    $ft->dm_load_list("ben.field_templates", "ASSOC", "form_reference='{$formname}' ORDER BY form_field_order");
    if ($ft->affected) {
        for ($i = 0; $i < $ft->affected; $i++) {
            if ($i % 2) {
                $trclass = "hive-even";
            } else {
                $trclass = "hive-odd";
            }

            $line .= "<tr class='{$trclass}'>
          <td>{$ft->data[$i]['id']} &nbsp;</td>
          <td>{$ft->data[$i]['field_name']} &nbsp;</td>
          <td><input type='text'value='{$ft->data[$i]['form_field_order']}' maxlength='2' size='3'> &nbsp;</td>
          <td>{$ft->data[$i]['html_type']} &nbsp;</td>
          <td>{$ft->data[$i]['level']} &nbsp;</td>
          <td>{$ft->data[$i]['def_val']} &nbsp;</td>
          <td><a class='edit-icon pointer' onclick=\"proccess_information('listforms', 'edit_field', 'natural', '', 'formid|{$ft->data[$i]['id']}');\">Edit</a></td>
          <td><a class='delete-icon pointer' onclick=\"proccess_information('listforms', 'delete_field', 'natural', 'Are you sure you want to delete this field?','fieldid|{$ft->data[$i]['id']}');\">Delete</a><input type='hidden' id='id_{$i}' value='{$ft->data[$i]['id']}' name='id_{$i}'></td>
        </tr>";
        }
        $main_list = "<p><h1>Fields for the form <font color='red'>{$formname}</font></h1></p>\n
    <div class='hive-table'>
      <form id='listforms' name='listforms'>
      <table cellspacing='0' cellpadding='0' border='0' width='100%'>
        <thead>
          <tr>
            <th nowrap=''>Id</th>
            <th nowrap=''>Name</th>
            <th nowrap=''>Position</th>
            <th nowrap=''>Type</th>
            <th nowrap=''>Level</th>
            <th nowrap=''>Default Value</th>
            <th nowrap=''>Edit</th>
            <th nowrap=''>Delete</th>
          </tr>
        </thead>
        <tbody>
          {$line}
          <tr class='hive-even'>
            <td colspan='7'><input type='button' value='Add New Field' onclick=\"proccess_information('listforms', 'add_new_field', 'natural', '', 'formid|{$data['formid']}');\"></td>
          </tr>
        </tbody>
      </table> 
    
      </div>";
    } else {
        $main_list = "Fields not found! Please try again later! or add a new field by clicking here! <input type='submit' value='Add New Field' onclick=\"proccess_information('listfrm', 'add_new_field', 'natural', '', 'formid|{$data['formid']}');\"><form name='listfrm' id='listfrm'></form>";
    }
    return $main_list;
}

function delete_field($data) {
    $ff = new DataManager();
    $ff->dm_load_single("ben.field_templates", "id='{$data['fieldid']}'");
    $formname = $ff->form_reference;

    $ff->dm_load_single("ben.form_parameters", "form_name='{$formname}'");
    $frmid['formid'] = $ff->id;

    $ff->dm_remove("ben.field_templates", "id='{$data['fieldid']}'");
    if ($ff->affected) {
        echo "Field removed Successfully!";
    }
    echo edit_form_fields($frmid);

    //$build_form_class = build_forms($formname);
}

function add_new_field($data) {
    require_once(NATURAL_LIB_PATH . 'forms/add_new_field.form.php');
    $frm = new Add_new_field();
    $ff = new DataManager();
    $ff->dm_load_single("ben.form_parameters", "id='{$data['formid']}'");
    echo $frm->add_new_field_form($ff);
}

function edit_field($data) {
    $ff = new DataManager();
    $ff->dm_load_single(NATURAL_DBNAME . "." . FIELD_TABLE, "id='{$data['formid']}'");
    $fp = new DataManager();
    $fp->dm_load_single(NATURAL_DBNAME . "." . FORM_TABLE, "form_id='{$ff->form_reference}'");
    echo "<h1>Edit Field from Form <font color='red'>{$fp->form_name}</font></h1>";
    $form = new DbForm();
    echo $form->build("field_templates_edit", $ff);
    /*
      require_once(NATURAL_LIB_PATH.'forms/edit_form_field.form.php');
      $frm   = new Edit_form_field();
      $ff   = new DataManager();
      $ff->dm_load_single("ben.field_templates","id='{$data['formid']}'");
      echo $frm->edit_form_field_form($ff); */
}

function add_field($data) {
    $dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
    $sel_query = "SELECT * FROM " . NATURAL_DBNAME . ".field_templates WHERE form_reference='{$data['form_reference']}'";
    $query_sel = mysql_query($sel_query, $dblink) or die("ERROR|1011|We could not save this field at this time cause:" . mysql_error());
    $aff = mysql_affected_rows();
    foreach ($data as $key => $value) {
        if ($key != "fn") {
            if ($key == "form_field_order") {
                $query_fields .= ", form_field_order='{$aff}'";
            } else {
                $query_fields .= ", {$key}='" . mysql_real_escape_string($value) . "'";
            }
        }
    }

    $query_fields = substr($query_fields, 1);
    //Try to find another Database with the same name.
    $check_query = "INSERT INTO " . NATURAL_DBNAME . ".field_templates SET {$query_fields}";
    $query_check = mysql_query($check_query, $dblink) or die("ERROR|1011|We could not save this field at this time cause:" . mysql_error());
    if (mysql_affected_rows()) {
        echo "Field Saved Successfully!";
    }

    $ft = new DataManager();
    $ft->dm_load_single("ben.form_parameters", "form_name='{$data['form_reference']}'");
    $dd['formid'] = $ft->id;
    echo edit_form_fields($dd);
    //$build_form_class = build_forms($data['form_reference']);
}

function save_form_fields($data) {
    $dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
    $sel_query = "SELECT * FROM " . NATURAL_DBNAME . ".field_templates WHERE form_reference='{$data['form_reference']}'";
    $query_sel = mysql_query($sel_query, $dblink) or die("ERROR|1011|We could not save this field at this time cause:" . mysql_error());
    $aff = mysql_affected_rows();
    foreach ($data as $key => $value) {
        if ($key == "fn" || $key == "id") {
            
        } else {
            $query_fields .= ", {$key}='" . mysql_real_escape_string($value) . "'";
        }
    }

    $query_fields = substr($query_fields, 1);
    //Updating fields.
    $check_query = "UPDATE " . NATURAL_DBNAME . ".field_templates SET {$query_fields} WHERE id='{$data['id']}'";
    $query_check = mysql_query($check_query, $dblink) or die("ERROR|1011|We could not save these fields at this time cause:" . mysql_error());
    if (mysql_affected_rows()) {
        echo "Fields Saved Successfully!";
    }

    $ft = new DataManager();
    $ft->dm_load_single("ben.form_parameters", "form_name='{$data['form_reference']}'");
    $dd['formid'] = $ft->id;
    //$build_form_class = build_forms($data['form_reference']);
    echo edit_form_fields($dd);
}

function build_forms($form_name) {
    $fparam = new DataManager;
    $ft = new DataManager;
    $fil = new DataManager;
    $form_parameters = "ben.form_parameters";
    $field_templates = "ben.field_templates";
    $table = "ben.field_templates";
    $today = date("m-d-Y H:i:s");
    $upper_form = ucfirst($form_name);

    $search_str = "form_id = '{$form_name}'";
    $fparam->dm_load_single($form_parameters, $search_str);
    $now = date("M-D-Y");

    $counter = 0;
    if ($fparam->affected) {
        $myFile = "{$form_name}.form.php";
        $fp = fopen($myFile, 'w') or die("can't open file");
        fwrite($fp, "<?\n");
        $doc = " /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: {$today} -0500 ({$now}) \$ @ Revision: \$Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ \n\n";

        fwrite($fp, $doc);

        $form_ar_edit = "";

        //Creating Insert Form
        $i = 0;
        $c = 0;

        $s_str = "form_reference = '{$form_name}' ORDER BY form_field_order";
        $ft->dm_load_list($field_templates, "ASSOC", $s_str);
        if ($ft->affected) {
            for ($i = 0; $i < $ft->affected; $i++) {

                $id = "";
                $name = "";
                $type = "";
                $class = "";
                $options = "";
                $datatable = "";
                $dataquery = "";
                $datasort = "";
                $datalabel = "";
                $datavalue = "";
                $values = "";
                $defvaledit = "";
                $defvalnew = "";
                $vertical = "";
                $click = "";
                $change = "";
                $focus = "";
                $blur = "";
                $level = "";
                $acl = "";

                $id = $ft->data[$i]['field_id'];
                $name = $ft->data[$i]['field_name'];
                $type = $ft->data[$i]['html_type'];
                $label = $ft->data[$i]['def_label'];
                $class = $ft->data[$i]['css_class'];
                $options = $ft->data[$i]['html_options'];
                $datatable = $ft->data[$i]['data_table'];
                $dataquery = $ft->data[$i]['data_query'];
                $datasort = $ft->data[$i]['data_sort'];
                $datalabel = $ft->data[$i]['data_label'];
                $datavalue = $ft->data[$i]['data_value'];
                $values = $ft->data[$i]['values'];
                $defval = $ft->data[$i]['def_val'];
                $vertical = $ft->data[$i]['vertical'];
                $click = $ft->data[$i]['click'];
                $change = $ft->data[$i]['change'];
                $focus = $ft->data[$i]['focus'];
                $blur = $ft->data[$i]['blur'];
                $level = $ft->data[$i]['level'];
                $acl = $ft->data[$i]['acl'];

                $form_ar_new .= "
      \$this->fieldsets[0]['fields'][$i]['id']        = \"{$id}\";
      \$this->fieldsets[0]['fields'][$i]['name']      = \"{$name}\";
      \$this->fieldsets[0]['fields'][$i]['type']      = \"{$type}\";
      \$this->fieldsets[0]['fields'][$i]['label']     = \"{$label}\";
      \$this->fieldsets[0]['fields'][$i]['class']     = \"{$class}\";
      \$this->fieldsets[0]['fields'][$i]['options']   = \"{$options}\";
      \$this->fieldsets[0]['fields'][$i]['datatable'] = \"{$datatable}\";
			\$this->fieldsets[0]['fields'][$i]['dataquery'] = \"{$dataquery}\";
			\$this->fieldsets[0]['fields'][$i]['datasort'] 	= \"{$datasort}\";
			\$this->fieldsets[0]['fields'][$i]['datalabel'] = \"{$datalabel}\";
			\$this->fieldsets[0]['fields'][$i]['datavalue'] = \"{$datavalue}\";
			\$this->fieldsets[0]['fields'][$i]['values']    = \"{$values}\";
			\$this->fieldsets[0]['fields'][$i]['vertical']  = \"{$vertical}\";
      \$this->fieldsets[0]['fields'][$i]['defval']    = \"{$defval}\";
      \$this->fieldsets[0]['fields'][$i]['click']     = \"{$click}\";
      \$this->fieldsets[0]['fields'][$i]['focus']     = \"{$focus}\";
      \$this->fieldsets[0]['fields'][$i]['blur']      = \"{$blur}\";
      \$this->fieldsets[0]['fields'][$i]['level']     = \"{$level}\";
      \$this->fieldsets[0]['fields'][$i]['change']    = \"{$change}\";
      \$this->fieldsets[0]['fields'][$i]['acl']       = \"{$acl}\";\n";
            }
        }

        $funcs1 = "

  class {$upper_form} Extends Table{
    public \$level;
    
    public function {$form_name}_form(\$data=null){
      unset(\$this->options);
      unset(\$this->fieldsets);

      /*Define Form's general options*/
      \$this->options['id']            = \"{$fparam->form_id}\";
      \$this->options['name']          = \"{$fparam->form_name}\";
      \$this->options['action']        = \"{$fparam->form_action}\";
      \$this->options['method']        = \"{$fparam->form_method}\";
      \$this->options['class']         = \"{$fparam->form_class}\";
      \$this->options['onsubmit']      = \"{$fparam->form_onsubmit}\";
      \$this->options['tips']          = \"{$fparam->form_tips}\";
      \$this->options['title']         = \"{$fparam->form_title}\";

      /*Define fieldsets*/
      \$this->fieldsets[0]['legend'] = \"{$fparam->form_legend}\";

    {$form_ar_new}

      return parent::build(\$this->level);
    }

  }
  
?>";

        fwrite($fp, $funcs1);

        fclose($fp);
        $remove = `rm -f ../../lib/forms/{$myFile}`;
        $move = `mv {$myFile} ../../lib/forms/`;
        return "Class for table {$form_name} built successfully!<br><br>";
    } else {
        return "We could not find any data with this search criteria " . mysql_error();
    }
}

function show_table_list() {
    $dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

    if (!$dblink) {
        die('Could not connect: ' . mysql_error());
    }

    $query = "SHOW TABLES FROM " . NATURAL_DBNAME . "";
    $result = mysql_query($query, $dblink);

    $build_cl = "";
    if ($result) {
        while ($row = mysql_fetch_row($result)) {
            //echo "Table ".$row[0]."<br>";
            $list .= "<option value='{$row[0]}'>{$row[0]}</option>";
        }
        echo "<form name='table_list' id='table_list' action=\"javascript:proccess_information('table_list', 'create_class', 'natural', 'Are you sure you want to create this class?');\"><table>
      <tr>
        <td>Create Class</td>
        <td><input type='radio' id='create' name='create' value='class' checked></td>
      </tr>
      <tr>
        <td>Create Form</td>
        <td><input type='radio' id='create' name='create' value='form'></td>
      </tr>
      <tr>
        <td>Select one database:</td>
        <td><select name='table_name' id='table_name'>{$list}</select></td>
      </tr>
      <tr>
        <td colspan='2'><input type='submit' value='Create'></td>
      </tr>
    </table></form>";
    } else {
        echo "DB Error, could not list tables in db {$db_name}<br>Error: " . mysql_error();
    }
}

function create_class($table_name) {
    $ft = new DataManager;
    $table = "natural.field_templates";
    $table_name = trim($table_name);
    $class_ar = explode("_", $table_name);
    if (is_array($class_ar)) {
        for ($i = 0; $i < count($class_ar); $i++) {
            $class_name .= ucfirst($class_ar[$i]);
        }
    }
    $dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

    if (!$dblink) {
        die('Could not connect: ' . mysql_error());
    }
    $today = date("m-d-Y H:i:s");
    $now = date("M-D-Y");
    $query = "SHOW COLUMNS FROM " . NATURAL_DBNAME . ".{$table_name}";
    $query_result = mysql_query($query, $dblink);
    $counter = 0;
    if ($query_result) {
        $myFile = "{$table_name}.class.php";
        $fp = fopen($myFile, 'w') or die("can't open file");
        fwrite($fp, "<?\n");
        $doc = " /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: {$today} -0500 ({$now}) \$ @ Revision: \$Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ \n\n";

        fwrite($fp, $doc);

        $upper_table = ucfirst($table_name);
        $top_class = "\tclass {$class_name} Extends DataManager{\n";
        fwrite($fp, $top_class);


        $dec_var = "";
        $form_ar_edit = "";

        //Creating Insert Form
        $i = 0;
        $c = 0;

        $funcs1 = "\t\tpublic function load_single(\$search_str, \$insert_log = false){
      parent::dm_load_single(NATURAL_DBNAME . \".$table_name\",\$search_str);
		}
     
    public function load_list(\$output, \$search_str, \$insert_log = false){
      parent::dm_load_list(NATURAL_DBNAME . \".$table_name\", \$output, \$search_str);
    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . \".$table_name\", \$this);
      \$this->id = \$this->dbid;
    }

    public function update(\$upd_rule){
      parent::dm_update(NATURAL_DBNAME . \".$table_name\", \$upd_rule, \$this);
    }

    public function remove(\$rec_key){
      parent::dm_remove(NATURAL_DBNAME . \".$table_name\", \$rec_key);
    }
  }
  
?>";

        fwrite($fp, $funcs1);

        fclose($fp);
        return "Class for table {$table_name} built successfully!<br>";
    } else {
        echo "We could not find any data with this search criteria " . mysql_error();
    }
}

function create_form($table_name) {
    $ft = new DataManager;
    $ff = new DataManager;
    $param = "";
    $fnm = "";

    $param['form_method'] = "POST";

    //Saving form parameters for new table
    $param['form_id'] = "{$table_name}_new";
    $param['form_name'] = "{$table_name}_new";
    $param['form_action'] = "javascript:proccess_information(\'" . $table_name . "_new\', \'save_new_" . $table_name . "\', \'" . $table_name . "\', \'\')\;";
    $ft->dm_insert(NATURAL_DBNAME . ".form_parameters", $param);
    $fnm['name'] = "{$table_name}_new";

    //Saving form parameters for edit table
    $param['form_id'] = "{$table_name}_edit";
    $param['form_name'] = "{$table_name}_edit";
    $param['form_action'] = "javascript:proccess_information(\'{$table_name}_edit\', \'save_{$table_name}\', \'{$table_name}\', \'\')\;";
    $ft->dm_insert(NATURAL_DBNAME . ".form_parameters", $param);
    $fnm['name'] = "{$table_name}_edit";

    //Saving form parameters for view table
    $param['form_id'] = "{$table_name}_view";
    $param['form_name'] = "{$table_name}_view";
    $param['form_action'] = "javascript:proccess_information(\'{$table_name}_view\', \'\', \'{$table_name}\', \'\')\;";
    $ft->dm_insert(NATURAL_DBNAME . ".form_parameters", $param);
    $fnm['name'] = "{$table_name}_view";

    echo "<br><font color='red'>Created form for " . $table_name . "</font><br>";
//  $ft->dm_load_list(NATURAL_DB_NAME.".".$table_name, "SHOW COLUMNS ");

    $dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

    if (!$dblink) {
        die('Could not connect: ' . mysql_error());
    }
    $today = date("m-d-Y H:i:s");
    $now = date("M-D-Y");
    $query = "SHOW COLUMNS FROM " . NATURAL_DBNAME . ".{$table_name}";
    $query_result = mysql_query($query, $dblink);
    $i = 0;
    if ($query_result) {
        while ($row = mysql_fetch_assoc($query_result)) {

            $label = "";
            $nam_ar = explode("_", $row['Field']);
            if (is_array($nam_ar)) {
                for ($x = 0; $x < count($nam_ar); $x++) {
                    if ($nam_ar[$x] != "id") {
                        $label .= ucfirst($nam_ar[$x]) . " ";
                    }
                }
                $label = substr($label, 0, -1);
            } else {
                $label = ucfirst($row['Field']);
            }
            $field['form_reference'] = "{$table_name}_new";
            $field['field_id'] = $row['Field'];
            $field['field_name'] = $row['Field'];
            $field['form_field_order'] = $i;
            $field['html_type'] = "text";
            $field['def_val'] = "";
            $field['def_label'] = $label;


            //Insert template new
            $ff->dm_insert(NATURAL_DBNAME . ".field_templates", $field);
            /*      $in1  = "INSERT INTO ".NATURAL_DBNAME.".field_templates SET form_reference='{$field['form_reference']}',
              field_id='{$field['field_id']}',
              field_name='{$field['field_name']}',
              form_field_order='{$field['form_field_order']}',
              html_type='{$field['html_type']}',
              def_label='{$field['def_label']}'
              ";
              $query1 = mysql_query($in1,$dblink) or die ("Query 1 error cause :".mysql_error()); */

            //Insert template edit
            $field['form_reference'] = "{$table_name}_edit";
            $field['def_val'] = "\$data->{$row['Field']}";
            $ff->dm_insert(NATURAL_DBNAME . ".field_templates", $field);
            /*      $in2  = "INSERT INTO ".NATURAL_DBNAME.".field_templates SET form_reference='{$field['form_reference']}',
              field_id='{$field['field_id']}',
              field_name='{$field['field_name']}',
              form_field_order='{$field['form_field_order']}',
              html_type='{$field['html_type']}',
              def_label='{$field['def_label']}'
              ";
              $query2 = mysql_query($in2,$dblink) or die ("Query 2 error cause :".mysql_error()); */


            //Insert template view
            $field['form_reference'] = "{$table_name}_view";
            $field['def_val'] = "\$data->{$row['Field']}";
            $field['html_type'] = "readonly";
            $ff->dm_insert(NATURAL_DBNAME . ".field_templates", $field);
            /*      $in3  = "INSERT INTO ".NATURAL_DBNAME.".field_templates SET form_reference='{$field['form_reference']}',
              field_id='{$field['field_id']}',
              field_name='{$field['field_name']}',
              form_field_order='{$field['form_field_order']}',
              html_type='{$field['html_type']}',
              def_label='{$field['def_label']}'
              ";
              $query3 = mysql_query($in3,$dblink) or die ("Query 3 error cause :".mysql_error()); */


            /* echo "<pre>";
              print_r($field);
              echo "</pre>"; */
            //echo "\t\tCreated fields ".$row['Field']."<br>";
            $i++;
        }
    }
}

function search_form_menu() {
    echo "<form name='find_form' id='find_form' action=\"javascript:proccess_information('find_form','proccess_search','natural','');\">Type the form name you want to find: <br><input type='text' name='form_name' id='form_name'><input type='submit' value='Search'></form>";

    echo "<script type='javascript/text'>
    document.getElementById('form_name').focus();
  </script>
    ";
}

?>
