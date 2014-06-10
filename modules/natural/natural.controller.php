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
				$headers = build_sort_header('module_list', 'natural', $headers, $sort);
		
        $total = 0;
        for ($i = 0; $i < $modules->affected; $i++) {
            $j = $i + 1;
						//This is important for the row update/delete
            $rows[$j]['row_id'] = $modules->data[$i]['id'];
            /////////////////////////////////////////////
            $rows[$j]['id'] = $modules->data[$i]['id'];
            $rows[$j]['module'] = $modules->data[$i]['module'];
            $rows[$j]['label'] = $modules->data[$i]['label'];
						$rows[$j]['delete'] = theme_link_process_information('', 'module_delete_form', 'module_delete_form', 'natural', array('extra_value' => 'id|' . $modules->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON));
				}
    }

    $options = array(
		'show_headers' => TRUE,
		'page_title' => translate('Module List'),
		'page_subtitle' => translate('Manage Module'),
		'empty_message' => translate('No module found!'),
		'table_prefix' => theme_link_process_information(translate('Create New Module'), 'module_create_form', 'module_create_form', 'natural', array('response_type' => 'modal')),
		'pager_items' => build_pager('module_list', 'natural', $module->total_records, $limit, $page),
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
		$frm->build('module_create_form', $module, $_SESSION['log_access_level']);
}

function module_create_form_submit($data) {
    $data['project_path'] 	= NATURAL_WEB_ROOT;
    $data['project_name'] 	= NATURAL_PLATFORM;
    $data['field_1'] 				= 'b.name';
    $data['field_label_1'] 	= 'Name';
    $data['field_2'] 				= 'b.author';
    $data['field_label_2'] 	= 'Author';
		$data['module'] 				= $data['label'];
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
    //$data['path'] = NATURAL_WEB_ROOT . "modules/" . $data['module'] . "/";
    $data['path'] = '../'.$data['module'].'/';
		/*
     * Validating information on the Database
     */
		$error = validate_module_info($data);
		if ($error) {
				natural_set_message($error, 'error');
        return FALSE;
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
    $module 									= new Module();
    $module->version 					= 1;
    $module->module 					= strtolower(str_replace(" ", "_", $data['module']));
    $module->label 						= ucwords($data['label']);
    $module->description 			= ucwords($data['label']);
    $module->license_quantity = 0;
    $module->last_update 			= date("Y-m-d H:i:s");
    $module->status 					= 1;
    $module->insert();
		if($module->affected){
				natural_set_message('Module '.$data['module'].' created successfully!', 'success');	
				return module_list($module->id);
		}else{
				natural_set_message('Could not save this Module at this time', 'error');
        return false;
		}
}

function module_delete_form($data){
		$module = new Module();
    $module->loadSingle('id='.$data['id']);
		if($module->affected>0){
        $frm = new DbForm();
        $frm->build('module_delete_form', $module, $_SESSION['log_access_level']);
    }else{
        natural_set_message('Problems loading module ' . $data['id'], 'error');
        return FALSE;   
    }
}

function module_delete_form_submit($data){
		$module = new Module();
    $module->loadSingle('id='.$data['id']);
    if ($module->affected > 0) {
        $module->remove('id='.$data['id']);
        natural_set_message('Module has been removed successfully!', 'success');
        return $data['id'];
    } else {
        natural_set_message('Problems loading user ' . $data['id'], 'error');
        return FALSE;
    }
}

/*
 * Creating Module menu
 */

function create_module_menu($data) {
    //Building array of data to pass to the table
		$mn = new Menu();
		$mn->loadSingle('id>0 ORDER BY position DESC LIMIT 1');
		
		if (is_numeric($data['table_name'])) {
        $name = $data['module'];
    } else {
        $name = $data['table_name'];
    }
		
		$menu = new Menu();
		$menu->pid 					= '';
		$menu->menu_name 		= 'main';
		$menu->position  		= $mn->position + 1;
		$menu->element_name = $data['module'];
		$menu->label 				= ucwords($data['module']);
		$menu->title 				= ucwords($data['module']);
		$menu->func 				= strtolower(str_replace(" ", "_", $name.'_list'));
		$menu->module 			= $data['module'];
		$menu->allow 				= 'all';
		$menu->allow_value 	= '0';
		$menu->status 			= '1';
		$menu->icon_class 	= 'fa fa-edit';
		$menu->insert();
}

/*
 * Creating module structure
 */

function create_module_structure($data) {
    //Creating folder for the new module
    mkdir($data['path'], 0777);
    $files = array('index.php', 'class.php', 'controller.php');
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
		$data['mod_name'] = $name;
		foreach ($files as $k => $v) {
        if ($v == "index.php") {
            $file = file_get_contents("template/index.php");
        } else {
            $file = file_get_contents("template/book." . $v);
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
		update_composer_dependencies($data);
}

/*
 *Adding module to the composer dependencies
 */
function update_composer_dependencies($data){
		$file = '../../composer.json';
		$json = json_decode(file_get_contents($file), true);
		
		array_push($json['autoload']['classmap'], 'modules/'.$data['mod_name']);

		file_put_contents($file, json_encode($json));
		
		//Create the application and run it with the commands
		//Try to execute the composer update automatically
		
}
/*
 * Validating module information
 */

function validate_module_info($data, $edit = false) {
		if ($data['label']=='') {
        return 'Field Label is required!';
		}
    if (file_exists($data['path'])) {
        return 'The directory <i>' . $data['module'] . '</i> already exists!<br>Please try a different name or remove the current module!';
		}
		$module = new Module();
		$module->loadSingle('module="'.$data['module'].'" LIMIT 1');
		if($module->affected>0){
				return 'Module <i>' . $data['module'] . '</i> already exists!';
		}
    if ($data['create_forms'] == 1) {
        $query = "SELECT * FROM " . NATURAL_DBNAME . ".form_parameters WHERE form_id = '" . $data['table_name'] . "_new' 
            OR form_id = '" . $data['table_name'] . "_edit' 
            OR form_id = '" . $data['table_name'] . "_view'";
        $form = new DataManager();
        $form->dmLoadCustomList($query, 'ASSOC');
        if ($form->affected > 0) {
						return 'The form for the module <i>' . $data['module'] . '</i> already exists!';
		    }
    }
    if ($data['create_menu'] == 1) {
        $query = "SELECT * FROM " . NATURAL_DBNAME . ".menu WHERE element_name = '" . $data['module'] . "_main'";
        $form = new DataManager();
        $form->dmLoadCustomList($query, 'ASSOC');
        if ($form->affected > 0) {
            return 'Menu for the module <i>' . $data['module'] . '</i> already exists!';
		    }
    }
		return false;
}

/*
 * Create API reference on api/index.php inside of the project
 */

function create_module_api($data) {
    //Creating strings to add to the api/index.php inside 
    //$new_api = "require_once('SimpleAuth.php');\nrequire_once('../modules/" . $data['module_name'] . "/" . $data['module_name'] . ".model.php');";
    $set_api = "\$r->addAPIClass('" . $data['class_name'] . "');\n\$r->handle();";
    $file = file_get_contents('../../api/index.php');
    if (!strpos(file_get_contents('../../api/index.php'), "\$r->addAPIClass('" . $data['class_name'] . "');") !== false) {
        //If string of the API not found, include t the api/index.php
        // Do tag replacements or whatever you want
        //$file = str_replace("require_once('SimpleAuth.php');", $new_api, $file);
        $file = str_replace('$r->handle();', $set_api, $file);
        //save it back
        file_put_contents('../../api/index.php', $file);
    }
}

/**
 * Module Remove
 */
function module_remove($data) {
    $module = new DataManager();
    $module->dm_load_single(NATURAL_DBNAME . "." . MODULES_TABLE,"id='{$data['module_id']}'");
    //$module->dm_load_single($table, $search_str)
    $name = $module->name;
    if (!$module->affected) {
        return "ERROR|19109|Module Not Found, Please contact your system administrator!";
        exit(0);
    }
    $module->dm_remove(NATURAL_DBNAME . "." . MODULES_TABLE,"id='{$data['module_id']}'");
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
						$rows[$j]['id'] = $forms->data[$i]['id'];
            $rows[$j]['form_name'] = $forms->data[$i]['form_name'];
						$rows[$j]['form_title'] = $forms->data[$i]['form_title'];
						
						if($forms->data[$i]['system']==1){
								$disabled = 'disabled';
						}else{
								$disabled = '';
						}
						$rows[$j]['edit']   = theme_link_process_information('', 'form_edit_form', 'form_edit_form', 'natural', array('extra_value' => 'id|' . $forms->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_EDIT_ICON, 'class' => $disabled));
						$rows[$j]['delete'] = theme_link_process_information('', 'form_delete_form', 'form_delete_form', 'natural', array('extra_value' => 'id|' . $forms->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON, 'class' => $disabled));
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
		$form = new DataManager();
		$form->dmLoadSingle(NATURAL_DBNAME . "." . FORM_TABLE, 'id='.$data['id']);
		$frm = new DbForm();
    $frm->build("form_edit_form", $form, $_SESSION['log_access_level']);
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
								if($key!="fieldset_name"){
										$field->$key = mysql_real_escape_string($value);		
								}
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
				if ($key != 'affected' && $key != 'errorcode' && $key != 'data' && $key != 'dbid' && $key != 'id' && $key != 'fn' && $key!='fieldset_name') {
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
    $frm->build('class_form_creator_form', $dm, $_SESSION['log_access_level'], FALSE);
}

function class_form_creator_form_submit($data){
		if(count($data['type'])<1){
				natural_set_message('Please select at least one type and try again!', 'error');
				exit(0);
		}
		
		foreach($data['type'] as $k => $v){
				if($v=='class'){
						class_creator($data['table_name']);
				}
				if($v=='form'){
						create_form($data['table_name']);
				}
		}
}

function class_creator($table_name){
		$data['project_path'] = NATURAL_WEB_ROOT;
    $data['project_name'] = NATURAL_PLATFORM;
    $data['field_1'] = 'b.name';
    $data['field_label_1'] = 'Name';
    $data['field_2'] = 'b.author';
    $data['field_label_2'] = 'Author';

		$query = "DESCRIBE " . NATURAL_DBNAME . "." . $table_name . "";
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
		
		$name = $table_name;
		$class_name = str_replace("_", " ", $table_name);
    
		$class_name = ucwords($class_name);
    $data['class_name'] = str_replace(" ", "", $class_name);
		$data['path'] = NATURAL_WEB_ROOT . "modules/natural/";
		
    $file = file_get_contents("template/book.class.php");
		// Do tag replacements or whatever you want
		$file = str_replace("book", $name, $file);
		$file = str_replace("Book", $data['class_name'], $file);
		$file = str_replace("name", $data['field_1'], $file);
		$file = str_replace("Name", $data['field_label_1'], $file);
		$file = str_replace("author", $data['field_2'], $file);
		$file = str_replace("Author", $data['field_label_2'], $file);
		//save it back:
		$write = file_put_contents($name . ".class.php", $file);
		natural_set_message('Done creating the class for the table '.$data['table_name'].'!', 'success');		
}

function create_form($table_name) {
    $ft = new DataManager;
    $ff = new DataManager;
    $param = "";
    $fnm = "";

    $param['form_method'] = "POST";
		$form_add 		= $table_name.'_create_form';
		$form_edit 		= $table_name.'_edit_form';
		$form_delete 	= $table_name.'_delete_form';
		
    //Saving form parameters for the create form
    $param['form_id'] 		= $form_add;
    $param['form_name'] 	= $form_add;
    $param['form_title'] 	= 'Add New '.ucwords(str_replace("_", " ", strtolower($table_name)));
    $param['form_action'] = "javascript:process_information(\'" . $table_name . "_create_form\', \'" . $table_name . "_create_form_submit\', \'" . $table_name . "\', null, null, null, null, \'create_row\')\;";
    $ft->dmInsert(NATURAL_DBNAME . "." . FORM_TABLE, $param);
		$form_add_id = $ft->dbid;
    
    //Saving form parameters for edit form
    $param['form_id'] 		= $form_edit;
    $param['form_name'] 	= $form_edit;
    $param['form_title'] 	= 'Edit '.ucwords(str_replace("_", " ", strtolower($table_name)));
    $param['form_action'] = "javascript:process_information(\'" . $table_name . "_edit_form\', \'" . $table_name . "_edit_form_submit\', \'" . $table_name . "\', null, null, null, null, \'edit_row\')\;";
    $ft->dmInsert(NATURAL_DBNAME . "." . FORM_TABLE, $param);
		$form_edit_id = $ft->dbid;
    
    //Saving form parameters for delete form
    $param['form_id'] 		= $form_delete;
    $param['form_name'] 	= $form_delete;
    $param['form_title'] 	= 'Delete '.ucwords(str_replace("_", " ", strtolower($table_name)));
    $param['form_action'] = "javascript:process_information(\'" . $table_name . "_delete_form\', \'" . $table_name . "_delete_form_submit\', \'" . $table_name . "\', null, null, null, null, \'delete_row\')\;";
    $ft->dmInsert(NATURAL_DBNAME . "." . FORM_TABLE, $param);
		$form_delete_id = $ft->dbid;

    $dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

    if (!$dblink) {
        //die('Could not connect: ' . mysql_error());
				natural_set_message('Failed to connect with the database '.NATURAL_DBNAME.'!', 'error');		
    }
    $today = date("m-d-Y H:i:s");
    $now = date("M-D-Y");
    $query = 'SHOW COLUMNS FROM ' . NATURAL_DBNAME . '.'.$table_name;
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
            $field['form_reference'] = $form_add;
						$field['form_template_id'] = $form_add_id;
            $field['field_id'] = $row['Field'];
            $field['field_name'] = $row['Field'];
            $field['form_field_order'] = $i;
            if ($row['Field'] == "id") {
                $field['html_type'] = "hidden";
            } else {
                $field['html_type'] = "text";
            }
            $field['def_val'] = "";
            $field['def_label'] = $label;

            //Insert template new
            $ff->dmInsert(NATURAL_DBNAME . "." . FIELD_TABLE, $field);

            //Insert template edit
            $field['form_reference'] = $form_edit;
						$field['form_template_id'] = $form_edit_id;
            $field['def_val'] = "{$row['Field']}";
            $ff->dmInsert(NATURAL_DBNAME . "." . FIELD_TABLE, $field);

						if($row['Field']=='id'){
								//Insert delete id
								$field['form_reference'] 	= $form_delete;
								$field['form_template_id']= $form_delete_id;
								$field['def_val'] 				= "{$row['Field']}";
								$field['html_type'] 			= "hidden";
								$field['def_label'] 			= 'ID';
								$ff->dmInsert(NATURAL_DBNAME . "." . FIELD_TABLE, $field);		
						}
						if($i==1){
								//Insert delete message
								$field['form_reference'] 	= $form_delete;
								$field['form_template_id']= $form_delete_id;
								$field['field_id'] 				= 'message';
								$field['field_name'] 			= 'message';
				        $field['form_field_order']= $i;
								$field['def_label'] 			= '';
								$field['def_val'] 				= 'Are you sure you want to delete this '.$table_name.'?';
								$field['html_type'] 			= 'message';
								$ff->dmInsert(NATURAL_DBNAME . "." . FIELD_TABLE, $field);
								
								//Insert delete object
								$field['form_reference'] 	= $form_delete;
								$field['form_template_id']= $form_delete_id;
								$field['field_id'] 				= "{$row['Field']}";
								$field['field_name'] 			= "{$row['Field']}";
				        $field['form_field_order']= $i + 1;
								$field['def_label'] 			= '';
								$field['def_val'] 				= "{$row['Field']}";
								$field['html_type'] 			= 'message';
								$ff->dmInsert(NATURAL_DBNAME . "." . FIELD_TABLE, $field);		
						}
            $i++;
        }

        $field['form_reference'] 	= $form_add;
				$field['form_template_id']= $form_add_id;
        $field['field_id'] 				= "sub";
        $field['field_name'] 			= "sub";
        $field['form_field_order']= $i;
				$field['def_label'] 			= '';
				$field['def_val'] 				= '';
        $field['html_type'] 			= 'submit';
        $ff->dmInsert(NATURAL_DBNAME . "." . FIELD_TABLE, $field);
				
				$field['form_reference'] 	= $form_edit;
				$field['form_template_id']= $form_edit_id;
        $ff->dmInsert(NATURAL_DBNAME . "." . FIELD_TABLE, $field);
				
				$field['form_reference'] 	= $form_delete;
				$field['form_template_id']= $form_delete_id;
        $ff->dmInsert(NATURAL_DBNAME . "." . FIELD_TABLE, $field);
    }
		natural_set_message('Done creating the form for the table '.$table_name.'!', 'success');		
}


/*
 * END OF THE FORM MANAGEMENT
 */

function support_info(){
		global $twig;
		// Twig Base
		$template = $twig->loadTemplate('content.html');
		$template->display(array(
				// Dashboard - Passing default variables to content.html
				'page_title' => 'Support',
				'page_subtitle' => 'Natural',
				'content' => 'Thank you for using natural framework,
				<br>for documentation or questions please visit www.opensourcemind.net or email us at devteam@opensourcemind.net.'
		));
}

?>
