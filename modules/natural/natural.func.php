<?

function list_forms($data) {
    $ft = new DataManager();
    if ($data['fn'] == "proccess_search") {
        $ft->dm_load_list("ben.form_parameters", "ASSOC", "form_name LIKE '%{$data['form_name']}%' ORDER BY form_name");
    } else {
        $ft->dm_load_list("ben.form_parameters", "ASSOC", "id!='' ORDER BY form_name");
    }

    $line[0][0] = "Id";
    $line[0][1] = "Name";
    $line[0][2] = "Edit Fields";
    $line[0][3] = "Edit Parameters";
    $line[0][4] = "Delete";

    if ($ft->affected) {
        for ($i = 0; $i < $ft->affected; $i++) {
            if ($i % 2) {
                $trclass = "hive-even";
            } else {
                $trclass = "hive-odd";
            }

            if ($ft->data[$i]['form_name'] == "form_new" || $ft->data[$i]['form_name'] == "form_edit" || $ft->data[$i]['form_name'] == "add_new_field" || $ft->data[$i]['form_name'] == "edit_form_field") {
                $rm_bt = '<a class="delete-icon disabled-icon">Delete</a>';
            } else {
                $rm_bt = "<a class='delete-icon pointer' onclick=\"proccess_information('listforms', 'delete_form', 'natural', 'Are you sure you want to delete this form? By doing this the system will delete its fields as well!','formid|{$ft->data[$i]['id']}');\">Delete</a>";
            }
            $j = $i + 1;
            $line[$j][0] = $ft->data[$i]['id'];
            $line[$j][1] = $ft->data[$i]['form_name'];
            $line[$j][2] = "<a class='edit-icon pointer' onclick=\"proccess_information('listforms', 'edit_form_fields', 'natural', '', 'formid|{$ft->data[$i]['id']}');\">Edit</a>";
            $line[$j][3] = "<a class='edit-icon pointer' onclick=\"proccess_information('listforms', 'edit_form_param', 'natural', '', 'formid|{$ft->data[$i]['id']}');\">Edit</a>";
            $line[$j][4] = "{$rm_bt}<input type='hidden' id='id_{$i}' value='{$ft->data[$i]['id']}' name='id_{$i}'>";
        }

        $listview = ListView::build("cellspacing='0' cellpadding='0' border='0' width='100%'", $line);

        $main_list = "<p><h1>Natural Form Management</h1></p>\n
    <div class='hive-table'>
		<form id='listforms' name='listforms'>
		 {$listview}
      <table cellspacing='0' cellpadding='0' border='0' width='100%'>
        <tbody>
          <tr class='hive-even'>
            <td colspan='5'><input type='button' value='Add New Form' onclick=\"proccess_information('listforms', 'add_new_form', 'natural', '');\"></td>
          </tr>
        </tbody>
      </table> 
    
      </div>";
    } else {
        $main_list = "ERROR|9890|Form not found, please try a different name!";
    }
    return $main_list;
}

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
