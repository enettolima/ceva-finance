<?
/** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: $Date: 2009-05-18 17:29:42 -0500 (Mon, 18 May 2009) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

  /*
   * This modules can create any class automatically with just the table name.
   * Just call NATURAL_WEB_DOMAIN/lib/classes/classes_creation/create_new_class.php?table=TABLE_NAME.
   * After this, just verify the created class to make sure to change those fields that need list box intead of text.
   * This module will create classes on the directory NATURAL_ROOT/lib/classes/classes_creation, so after verification
   * move these to NATURAL_ROOT/lib/classes/.
   * */

  require_once('../../bootstrap.php');
  require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
  $table_name = $_GET['table'];
  //$db_name    = $_GET['dbname'];
  //$module     = $_GET['module'];

  if($db_name)
  {
    $module = "full";
  }else{
    $module = "empty";
  }

  if($module=="full")
  {
    if($db_name)
    {
      $fn         = build_classes_fulldb($db_name);
    }else{
      echo "Invalid Data Base Name! Try again using dbname=dbname on the URL!";
    }
  }else{
    if($table_name)
    {
      $fn         = build_classes($table_name);
      echo $fn;
    }else{
      echo "Invalid Table Name! Try again using table=tablename on the URL!";
    }
  }

function build_classes_fulldb($db_name)
{
  if(NATURAL_DEV_MODE)
  {
    $dblink = mysql_connect (NATURAL_DBHOST_DEV, NATURAL_DBUSER_DEV, NATURAL_DBPASS_DEV);
  }else{
    $dblink = mysql_connect (NATURAL_DBHOST_PRO, NATURAL_DBUSER_PRO, NATURAL_DBPASS_PRO);
  }
             
  if(!$dblink)
  {
    die('Could not connect: ' . mysql_error());
  }
  
  $query  = "SHOW TABLES FROM {$db_name}";
  $result = mysql_query($query,$dblink);

  $build_cl = "";
  if($result)
  {
    while($row = mysql_fetch_row($result)){
      //echo "Table ".$row[0]."<br>";
      if($row[0]=="country" || $row[0]=="states" || $row[0]=="timezone" || $row[0]=="dundi_peers" || $row[0]=="queues" || $row[0]=="system")
      {
        echo "<b>Skiped {$row[0]}, this table is a template table.</b><br><br>";
      }else{
        $build_cl = build_classes($row[0]);
        echo $build_cl;
      }
    }
  }else{
    echo "DB Error, could not list tables in db {$db_name}<br>Error: ".mysql_error();
  }

}

function build_classes($table_name)
{
  $ft     = new DataManager;
  $table  = "natural.field_templates";
  if(NATURAL_DEV_MODE)
  {
    $dblink = mysql_connect (NATURAL_DBHOST_DEV, NATURAL_DBUSER_DEV, NATURAL_DBPASS_DEV);
  }else{
    $dblink = mysql_connect (NATURAL_DBHOST_PRO, NATURAL_DBUSER_PRO, NATURAL_DBPASS_PRO);
  }
             
  if(!$dblink)
  {
    die('Could not connect: ' . mysql_error());
  }
  $today  = date("m-d-Y H:i:s");
  $now    = date("M-D-Y");
//  $query  = "SHOW COLUMNS FROM ".NATURAL_DBNAME.".{$table_name}";
  $query  = "select * from natural.field_templates where f_table = '{$table_name}' ";
  $query_result = mysql_query($query,$dblink);
  $counter = 0;
  if($query_result)
  {
    $myFile = "{$table_name}.class.php";
    $fp = fopen($myFile, 'w') or die("can't open file");
    $doc = "<?
/** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: {$today} -0500 ({$now}) \$ @ Revision: \$Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ \n\n";

    fwrite($fp, $doc);

    $upper_table = ucfirst($table_name); 
    $top_class = "\tclass {$upper_table} Extends DataManager{\n";
    fwrite($fp, $top_class);
     

    $dec_var = "";
    $form_ar_edit = "";

    //Creating Insert Form
    $i = 0;
    $c = 0;
    
    while($row = mysql_fetch_assoc($query_result)){

      echo $row[f_table]." - ";
      echo $row[f_field]." - ";
      echo $row[field_type];
      echo "<br>";
      
      $exec_edit = true;
      $exec_view = true;
      $exec_new  = true;

      if($row['f_field']=="id" || $row['f_field']=="password")
      {
        $exec_new  = false;
      }else{
        $exec_new  = true;
      }

//      $search_str = "f_table='{$row['f_table']}' and f_field='{$row['f_field']}'";

//      $ft->dm_load_single( $table, $search_str );

    //  $query  = "SELECT * FROM natural.field_templates WHERE field_type='{$row['Field']}'";
      //$query_result = mysql_query($query,$dblink);
      $type       = "";
      $class      = "";
      $options    = "";
      $datatable  = "";
      $dataquery  = "";
      $datasort   = "";
      $datalabel  = "";
      $datavalue  = "";
      $values     = "";
      $defvaledit = "";
      $defvalnew  = "";
      $vertical   = "";
      $click      = "";
      $change     = "";
      $focus      = "";
      $blur       = "";
      $level      = "";
      $acl        = "";

//     if($ft->affected)
//      {
        $type       = $row['html_type'];
        $label      = $row['def_label'];
        $class      = $row['css_class'];
        $options    = $row['html_options'];
        $datatable  = $row['data_table'];
        $dataquery  = $row['data_query'];
        $datasort   = $row['data_sort'];
        $datalabel  = $row['data_label'];
        $datavalue  = $row['data_value'];
        $values     = $row['values'];
        $xx1        = $row['def_val'];
        $defvalnew  = "\"$xx1\"";
        $defvaledit = "\$data->{$row['f_field']}";
        $vertical   = $row['vertical'];
        $click      = $row['click'];
        $change     = $row['change'];
        $focus      = $row['focus'];
        $blur       = $row['blur'];
        $level      = $row['level'];
        $acl        = $row['acl'];
//      else{
/*

        echo "******* error : no field ********";
        $dec_var .= "\t\tpublic \${$row['f_field']};\n";
        $label = "";
        $nam_ar = explode("_", $row['f_field']);
        if(is_array($nam_ar))
        {
          for($x=0; $x<count($nam_ar); $x++)
          {
            $label .= ucfirst($nam_ar[$x])." ";
          }
          $label = substr($label, 0, -1);
        }else{
          $label = ucfirst($row['f_field']);
        }
        $type       = "text";
        $class      = "";
        $options    = "";
        $datatable  = "";
        $dataquery  = "";
        $datasort   = "";
        $datalabel  = "";
        $datavalue  = "";
        $values     = "";
        $defvalnew  = "\"\"";
        $defvaledit = "\$data->{$row['f_field']}";
        $vertical   = "";
        $click      = "";
        $change     = "";
        $focus      = "";
        $blur       = "";
        $level      = "";
        $acl        = "readonly";

      }
 */
        if($exec_new)
        {
          if($row['f_field']=="id" || $row['f_field']=="password")
          {
            $type="hidden";
          }

        $form_ar_new .= "
      \$this->fieldsets[0]['fields'][$c]['id']        = \"{$row['f_field']}\";
      \$this->fieldsets[0]['fields'][$c]['name']      = \"{$row['f_field']}\";
      \$this->fieldsets[0]['fields'][$c]['type']      = \"{$type}\";
      \$this->fieldsets[0]['fields'][$c]['label']     = \"{$label}\";
      \$this->fieldsets[0]['fields'][$c]['class']     = \"{$class}\";
      \$this->fieldsets[0]['fields'][$c]['options']   = \"{$options}\";
      \$this->fieldsets[0]['fields'][$c]['datatable'] = \"{$datatable}\";
			\$this->fieldsets[0]['fields'][$c]['dataquery'] = \"{$dataquery}\";
			\$this->fieldsets[0]['fields'][$c]['datasort'] 	= \"{$datasort}\";
			\$this->fieldsets[0]['fields'][$c]['datalabel'] = \"{$datalabel}\";
			\$this->fieldsets[0]['fields'][$c]['datavalue'] = \"{$datavalue}\";
			\$this->fieldsets[0]['fields'][$c]['values']    = \"{$values}\";
			\$this->fieldsets[0]['fields'][$c]['vertical']  = \"{$vertical}\";
      \$this->fieldsets[0]['fields'][$c]['defval']    = {$defvalnew};
      \$this->fieldsets[0]['fields'][$c]['click']     = \"{$click}\";
      \$this->fieldsets[0]['fields'][$c]['focus']     = \"{$focus}\";
      \$this->fieldsets[0]['fields'][$c]['blur']      = \"{$blur}\";
      \$this->fieldsets[0]['fields'][$c]['level']     = \"{$level}\";
      \$this->fieldsets[0]['fields'][$c]['change']    = \"{$change}\";
      \$this->fieldsets[0]['fields'][$c]['acl']       = \"{$acl}\";\n";

        $c++;
        }
      

      if($row['f_field']=="id" || $row['f_field']=="password")
      {
        $type="hidden";
      }

        $form_ar_edit .= "
      \$this->fieldsets[0]['fields'][$i]['id']        = \"{$row['f_field']}\";
      \$this->fieldsets[0]['fields'][$i]['name']      = \"{$row['f_field']}\";
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
      \$this->fieldsets[0]['fields'][$i]['defval']    = {$defvaledit};
			\$this->fieldsets[0]['fields'][$i]['vertical']  = \"{$vertical}\";
      \$this->fieldsets[0]['fields'][$i]['click']     = \"{$click}\";
      \$this->fieldsets[0]['fields'][$i]['focus']     = \"{$focus}\";
      \$this->fieldsets[0]['fields'][$i]['blur']      = \"{$blur}\";
      \$this->fieldsets[0]['fields'][$i]['change']    = \"{$change}\";
      \$this->fieldsets[0]['fields'][$i]['level']     = \"{$level}\";
      \$this->fieldsets[0]['fields'][$i]['acl']       = \"{$acl}\";\n";

        $form_ar_view .= "
      \$this->fieldsets[0]['fields'][$i]['id']      = \"{$row['f_field']}\";
      \$this->fieldsets[0]['fields'][$i]['name']    = \"{$row['f_field']}\";
      \$this->fieldsets[0]['fields'][$i]['type']    = \"readonly\";
      \$this->fieldsets[0]['fields'][$i]['label']   = \"{$label}\";
      \$this->fieldsets[0]['fields'][$i]['defval']  = {$defvaledit};
      \$this->fieldsets[0]['fields'][$i]['level']   = \"{$level}\";
      \$this->fieldsets[0]['fields'][$i]['acl']     = \"{$acl}\";\n";

      $i++;
    }
       $form_ar_new .= "
      \$this->fieldsets[0]['fields'][$c]['id']      = \"submit\";
      \$this->fieldsets[0]['fields'][$c]['name']    = \"submit\";
      \$this->fieldsets[0]['fields'][$c]['type']    = \"submit\";
      \$this->fieldsets[0]['fields'][$c]['label']   = \"Save\";
      \$this->fieldsets[0]['fields'][$c]['class']   = \"\";
      \$this->fieldsets[0]['fields'][$c]['options'] = \"\";
      \$this->fieldsets[0]['fields'][$c]['click']   = \"\"; ";

        $form_ar_edit .= "
      \$this->fieldsets[0]['fields'][$i]['id']      = \"submit\";
      \$this->fieldsets[0]['fields'][$i]['name']    = \"submit\";
      \$this->fieldsets[0]['fields'][$i]['type']    = \"submit\";
      \$this->fieldsets[0]['fields'][$i]['label']   = \"Save\";
      \$this->fieldsets[0]['fields'][$i]['class']   = \"\";
      \$this->fieldsets[0]['fields'][$i]['options'] = \"\";
      \$this->fieldsets[0]['fields'][$i]['click']   = \"\"; ";

    fwrite($fp, $dec_var."\n");

    $funcs1 = "\t\tpublic function load_single(\$search_str, \$insert_log = false){
      parent::dm_load_single(NATURAL_DBNAME . \".$table_name\",\$search_str);
      if(\$insert_log)
      {
        \$stamp = date(\"Y-m-d H:i:s\");
        \$this->log_user_id    = \$_SESSION['log_id'];
        \$this->log_action     = \"S\";
        \$this->log_timestamp  = \$stamp;
        parent::dm_insert(NATURAL_DBLOG . \".$table_name\", \$this);
      }
    }
     
    public function load_list(\$output, \$search_str, \$insert_log = false){
      parent::dm_load_list(NATURAL_DBNAME . \".$table_name\", \$output, \$search_str);
      if(\$insert_log)
      {
        \$stamp = date(\"Y-m-d H:i:s\");
        \$this->log_user_id    = \$_SESSION['log_id'];
        \$this->log_action     = \"L\";
        \$this->log_timestamp  = \$stamp;
        parent::dm_insert(NATURAL_DBLOG . \".$table_name\", \$this);
      }

    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . \".$table_name\", \$this);
      \$this->id = \$this->dbid;
      
      \$stamp = date(\"Y-m-d H:i:s\");
      \$this->log_user_id    = \$_SESSION['log_id'];
      \$this->log_action     = \"I\";
      \$this->log_timestamp  = \$stamp;
      parent::dm_insert(NATURAL_DBLOG . \".$table_name\", \$this);

    }

    public function update(\$upd_rule){
      parent::dm_update(NATURAL_DBNAME . \".$table_name\", \$upd_rule, \$this);
      
      \$stamp = date(\"Y-m-d H:i:s\");
      \$this->log_user_id    = \$_SESSION['log_id'];
      \$this->log_action     = \"U\";
      \$this->log_timestamp  = \$stamp;
      parent::dm_insert(NATURAL_DBLOG . \".$table_name\", \$this);
    }

    public function remove(\$rec_key){
      parent::dm_remove(NATURAL_DBNAME . \".$table_name\", \$rec_key);
      
      \$stamp = date(\"Y-m-d H:i:s\");
      \$this->log_user_id    = \$_SESSION['log_id'];
      \$this->log_action     = \"R\";
      \$this->log_timestamp  = \$stamp;
      parent::dm_insert(NATURAL_DBLOG . \".$table_name\", \$this);
    }
  }";
  
  $func2 ="  class {$upper_table}Table Extends Table{
    public \$level;
    
    public function show_new(){
      unset(\$this->options);
      unset(\$this->fieldsets);

      /*Define Form's general options*/
      \$this->options['id']            = \"New{$upper_table}Form\";
      \$this->options['name']          = \"New{$upper_table}Form\";
      \$this->options['action']        = \"javascript:proccess_information('New{$upper_table}Form', '', '{$table_name}', '');\";
      \$this->options['method']        = \"POST\";
      \$this->options['class']         = \"New{$upper_table}Form\";
      \$this->options['onsubmit']      = \"\";
      \$this->options['tips']          = \"All fields required.\";
      \$this->options['title']         = \"All fields required.\";

      /*Define fieldsets*/
      \$this->fieldsets[0]['legend'] = \"{$upper_table} Information [New]\";

    {$form_ar_new}

      return parent::build(\$this->level);
    }

    public function show_edit(\$data){
      unset(\$this->options);
      unset(\$this->fieldsets);

      /*Define Form's general options*/
      \$this->options['id']            = \"Edit{$upper_table}Form\";
      \$this->options['name']          = \"Edit{$upper_table}Form\";
      \$this->options['action']        = \"javascript:proccess_information('New{$upper_table}Form', '', '{$table_name}', '');\";
      \$this->options['method']        = \"POST\";
      \$this->options['class']         = \"Edit{$upper_table}Form\";
      \$this->options['onsubmit']      = \"\";
      \$this->options['tips']          = \"All fields required.\";
      \$this->options['title']         = \"All fields required.\";

      /*Define fieldsets*/
      \$this->fieldsets[0]['legend'] = \"{$upper_table} Information [Edit]\";

    {$form_ar_edit}

      return parent::build(\$this->level);
    } 

    public function show_view(\$data){
      unset(\$this->options);
      unset(\$this->fieldsets);

      /*Define Form's general options*/
      \$this->options['id']            = \"View{$upper_table}Form\";
      \$this->options['name']          = \"View{$upper_table}Form\";
      \$this->options['action']        = \"\";
      \$this->options['method']        = \"POST\";
      \$this->options['class']         = \"View{$upper_table}Form\";
      \$this->options['onsubmit']      = \"\";
      \$this->options['title']         = \"All fields required.\";

      /*Define fieldsets*/
      \$this->fieldsets[0]['legend'] = \"{$upper_table} Information [View]\";

    {$form_ar_view}

      return parent::build(\$this->level);
    } 
  }

?>
    ";

    fwrite($fp, $funcs1);
    fclose($fp);

    $exec = `mkdir ../{$table_name}`;
  
  $index_wr = "<?
/** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: {$today} -0500 ({$now}) \$ @ Revision: \$Rev: 11 $ 
* @package Hive 
*/

  session_start();
  require_once('../../bootstrap.php');
  require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
  require_once(NATURAL_CLASSES_PATH.'forms.class.php');
  require_once(NATURAL_CLASSES_PATH.'{$table_name}.class.php');
  require_once(NATURAL_LIB_PATH.'errorcodes.lib.php');
  require_once('{$table_name}.func.php');

  if(!\$_SESSION['logged'])
  {
    echo \"LOGOUT\";
  }

  \$fn = \$_GET['fn'];

  /*
    *Declare objects here
   */
  switch(\$fn)
  {
    case \"\":
      break;
  }
?>";

  $myIndex = "../{$table_name}/index.php";
    $fi = fopen($myIndex, 'w') or die("can't open file");
    fwrite($fi, $index_wr);
    fclose($fi);

    return "Class for table {$table_name} built successfully!<br><br>";
  }else{
    echo "We could not find any data with this search criteria " . mysql_error();
  }
}

?>
