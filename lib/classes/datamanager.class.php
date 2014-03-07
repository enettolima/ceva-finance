<?php
 /*
 * HIVE - Copyleft Open Source Mind, GP
 * Last Modified: $Date: 2009-05-18 17:29:42 -0500 (Mon, 18 May 2009) $ @ Revision: $Rev: 11 $
 */

 class DataManager{
  public $affected;
  public $errorcode = 0 ;
  public $error = "";
  public $data;
  public $dbid;

  public function dm_load_single( $table, $search_str ){
     //Use configuration from bootstrap
		 $dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

     $query = "SELECT * FROM {$table} WHERE {$search_str}";
     $query_result = mysql_query($query,$dblink);

     if($query_result)
       $this->affected = mysql_affected_rows();

     if(!$this->affected)
     {
        $this->errorcode = RECORD_NOT_FOUND_CODE;
        $this->error = RECORD_NOT_FOUND_MESG;
        return;
     }else if($this->affected > 1){
        $this->errorcode = QUERY_RETURNED_MULTIPLE_RECORDS_CODE;
        $this->error = QUERY_RETURNED_MULTIPLE_RECORDS_MESG;
        return;
     }

     $cols = mysql_num_fields($query_result);
     while($row = mysql_fetch_array($query_result))
     {
         for($i = 0; $i <= $cols-1; $i++)
         {
              $field = mysql_field_name($query_result,$i);
              $this->{$field} = $row[$i];
         }
     }
     mysql_close($dblink);
     $dblink = null ;
  }

  public function dm_load_list($table, $output, $search_str, $count = FALSE, $count_query = NULL){
     //Use configuration from bootstrap
		 $dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

     $query = "SELECT * FROM {$table} WHERE {$search_str}";
		 //die($query);
		if ($count && !isset($count_query)) {
			$count_query = preg_replace(array('/SELECT.*?FROM/As', '/ORDER BY .*/', '/LIMIT .*/'), array('SELECT COUNT(*) FROM', '', ''), $query);
		  $total_records = mysql_fetch_row(mysql_query($count_query, $dblink));
			$this->total_records = $total_records[0];
		}
		elseif ($count && isset($count_query)) {
			/**
			 * if you want to page the query "SELECT COUNT(*), TYPE FROM table GROUP BY field", the above code would invoke the incorrect query "SELECT COUNT(*) FROM table GROUP BY field".
			 * So instead, you should pass "SELECT COUNT(DISTINCT(field)) FROM table" as the optional $count_query parameter
			 */
			$total_records = mysql_fetch_row(mysql_query($count_query, $dblink));
			$this->total_records = $total_records[0];
		}
		 $query_result = mysql_query($query,$dblink);
     $this->affected = mysql_affected_rows();
     if(!$this->affected)
     {
        $this->errorcode = RECORD_NOT_FOUND_CODE;
        $this->error = RECORD_NOT_FOUND_MESG;
        return;
     }
     switch(strtoupper($output))
     {
         case "ASSOC":
                 $cols = mysql_num_fields($query_result);
                 $row_num = 0 ;
                 while($row = mysql_fetch_array($query_result, MYSQL_ASSOC))
                     {
                     for($i = 0; $i <= $cols-1; $i++)
                     {
                         $field = mysql_field_name($query_result,$i);
                         $this->data[$row_num][$field] = $row[$field];
                     }

                     $row_num++ ;
                 }
             break;
         case "NUM":
                 $cols = mysql_num_fields($query_result);
                 $row_num = 0 ;
                 while($row = mysql_fetch_array($query_result, MYSQL_NUM))
                 {
                     for($i = 0; $i <= $cols-1; $i++)
                     {
                         $this->data[$row_num][$i] = $row[$i];
                     }

                     $row_num++ ;
                 }
             break;
     }
     mysql_close($dblink);
     $dblink = null ;
  }

  public function dm_load_custom_list($query, $output, $count = FALSE, $count_query = NULL){
		//Use configuration from bootstrap
		$dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

		mysql_select_db(NATURAL_DBNAME);

	  if ($count && !isset($count_query)) {
			$count_query = preg_replace(array('/SELECT.*?FROM/As', '/ORDER BY .*/', '/LIMIT .*/'), array('SELECT COUNT(*) FROM', '', ''), $query);
		  $total_records = mysql_fetch_row(mysql_query($count_query, $dblink));
			$this->total_records = $total_records[0];
  	}
		elseif ($count && isset($count_query)) {
			/**
			 * if you want to page the query "SELECT COUNT(*), TYPE FROM table GROUP BY field", the above code would invoke the incorrect query "SELECT COUNT(*) FROM table GROUP BY field".
			 * So instead, you should pass "SELECT COUNT(DISTINCT(field)) FROM table" as the optional $count_query parameter
			 */
			$total_records = mysql_fetch_row(mysql_query($count_query, $dblink));
			$this->total_records = $total_records[0];
		}

	  //die($query);
		$query_result = mysql_query($query, $dblink);
   	$this->affected = mysql_affected_rows();
    if(!$this->affected) {
     // $this->errorcode = RECORD_NOT_FOUND_CODE;
     // $this->error = RECORD_NOT_FOUND_MESG;
      return;
    }

    switch(strtoupper($output)) {
      case "ASSOC":
        $cols = mysql_num_fields($query_result);
        $row_num = 0 ;
        while($row = mysql_fetch_array($query_result, MYSQL_ASSOC)) {
          for($i = 0; $i <= $cols-1; $i++) {
            $field = mysql_field_name($query_result,$i);
            $this->data[$row_num][$field] = $row[$field];
          }
          $row_num++ ;
        }
        break;
      case "NUM":
        $cols = mysql_num_fields($query_result);
        $row_num = 0 ;
        while($row = mysql_fetch_array($query_result, MYSQL_NUM)) {
          for($i = 0; $i <= $cols-1; $i++) {
            $this->data[$row_num][$i] = $row[$i];
          }
          $row_num++ ;
        }
        break;
    }
    mysql_close($dblink);
    $dblink = null ;
  }

  public function dm_insert($table, $fields){

    //Use configuration from bootstrap
		$dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

    /*Loop through the fields to build insert query*/
    foreach($fields as $key => $value)
    {
      if(!($key == 'dblink' || $key == 'affected' || $key == 'errorcode' || $key == 'error' || $key == 'data' || $key == 'dbid')){
        $query_fields .= ",`{$key}`='{$value}'";
      }
    }

    $query_fields = substr($query_fields,1);
    $query = "INSERT INTO {$table} SET {$query_fields}";
    $query_result = mysql_query($query,$dblink);
    $this->affected = mysql_affected_rows();
    if(!$this->affected){
      $this->errorcode = MYSQL_INSERT_ERROR_CODE ;
      $this->error = MYSQL_INSERT_ERROR_MESG." : ".(mysql_error($this->dblink)?mysql_errno():0);
    }else{
      $this->dbid = mysql_insert_id($dblink);
    }
    mysql_close($dblink);
    $dblink = null ;
  }

  public function dm_remove($table, $record_key){
		$dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

		$query = "DELETE FROM {$table} WHERE {$record_key}";
    $query_result = mysql_query($query,$dblink);
    $this->affected = mysql_affected_rows();
    if(!$this->affected){
      $this->errorcode = MYSQL_DELETE_ERROR_CODE ;
      $this->error = MYSQL_DELETE_ERROR_MESG." : ".(mysql_error());
    }
    mysql_close($dblink);
    $dblink = null ;
  }

  public function dm_update($table, $update_rule, $fields){
    //Use configuration from bootstrap
		$dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

    /*Loop through the fields to build insert query*/
    foreach($fields as $key => $value)
    {
      if(!($key == 'dblink' || $key == 'affected' || $key == 'errorcode' || $key == 'error' || $key == 'data' || $key == 'dbid' || $key == 'id' || $key == 'function')){
        $query_fields .= ", `{$key}`='{$value}'";
      }
    }

    $query_fields = substr($query_fields,1);
    $query = "UPDATE {$table} SET {$query_fields} WHERE {$update_rule}";
   //print $query;
    $query_result = mysql_query($query,$dblink);
    $this->affected = mysql_affected_rows();
    if(!$this->affected){
      $this->errorcode = MYSQL_UPDATE_ERROR_CODE ;
      $this->error = MYSQL_UPDATE_ERROR_MESG ;
      //$this->error = MYSQL_UPDATE_ERROR_MESG." : ".(mysql_error($this->dblink)?mysql_errno():0);
    }else{
      $this->dbid = mysql_insert_id($dblink);
    }

    mysql_close($dblink);
    $dblink = null ;
  }

    public function dm_random($alpha = false, $length = 6){
      if($alpha){
        $random_key = substr(md5(rand().rand()), 0, $length);
      }else{
        $random_key = substr(mt_rand(), 0, $length);
      }
      return $random_key;
    }

	public function dm_custom_query($query, $return_object=false, $return_id=false){
		//Use configuration from bootstrap
		$dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

		mysql_select_db(NATURAL_DBNAME);

   	$query_result = mysql_query($query, $dblink);

		if (!$query_result) {
			$this->message  = 'Invalid query: ' . mysql_error() . "\n";
			$this->message .= 'Whole query: ' . $query;
		}
    else{
			$this->affected = mysql_affected_rows();
			if($this->affected>0 && $return_object==true){
				$cols = mysql_num_fields($query_result);
				while($row = mysql_fetch_array($query_result)){
					for($i = 0; $i <= $cols-1; $i++){
						$field = mysql_field_name($query_result,$i);
						$this->{$field} = $row[$i];
					}
				}
			}
		}
		if($return_id) {
			$this->dbid = mysql_insert_id($dblink);
		}
		mysql_close($dblink);
		$dblink = null ;
	}

	public function dm_check_module($module){
		//Use configuration from bootstrap
		$dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
		mysql_select_db(NATURAL_DBNAME);
		$query = "SELECT * FROM ".NATURAL_DBNAME.".".MODULES_TABLE." WHERE module='{$module}' LIMIT 1";
   	$query_result = mysql_query($query, $dblink);

		if($query_result)
       $this->affected = mysql_affected_rows();

     if(!$this->affected){
        $this->errorcode = RECORD_NOT_FOUND_CODE;
        $this->error = RECORD_NOT_FOUND_MESG;
        return;
     }else if($this->affected > 1){
        $this->errorcode = QUERY_RETURNED_MULTIPLE_RECORDS_CODE;
        $this->error = QUERY_RETURNED_MULTIPLE_RECORDS_MESG;
        return;
     }

     $cols = mysql_num_fields($query_result);
     while($row = mysql_fetch_array($query_result)){
			 for($i = 0; $i <= $cols-1; $i++){
				 $field = mysql_field_name($query_result,$i);
				 $this->{$field} = $row[$i];
			 }
     }
     mysql_close($dblink);
     $dblink = null ;
/*
		if (!$query_result) {
			$this->message  = 'Invalid query: ' . mysql_error() . "\n";
			$this->message .= 'Whole query: ' . $query;
		}else{
			$this->affected = mysql_affected_rows();
			$cols = mysql_num_fields($query_result);
			while($row = mysql_fetch_array($query_result)){
				for($i = 0; $i <= $cols-1; $i++){
					$field = mysql_field_name($query_result,$i);
					$this->{$field} = $row[$i];
				}
			}
			mysql_close($dblink);
			$dblink = null ;
		}*/
	}

  public function dm_custom_insert($query){

    //Use configuration from bootstrap
		$dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

    $query_result = mysql_query($query,$dblink);
    $this->affected = mysql_affected_rows();
    if(!$this->affected){
      $this->errorcode = MYSQL_INSERT_ERROR_CODE ;
      $this->error = MYSQL_INSERT_ERROR_MESG." : ".(mysql_error($this->dblink)?mysql_errno():0);
    }else{
      $this->dbid = mysql_insert_id($dblink);
    }
    mysql_close($dblink);
    $dblink = null ;
  }
  public function dm_custom_update($query){
    //Use configuration from bootstrap
		$dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

    $query_result = mysql_query($query,$dblink);
    $this->affected = mysql_affected_rows();
    if(!$this->affected){
      $this->errorcode = MYSQL_UPDATE_ERROR_CODE ;
      $this->error = MYSQL_UPDATE_ERROR_MESG ;
      //$this->error = MYSQL_UPDATE_ERROR_MESG." : ".(mysql_error($this->dblink)?mysql_errno():0);
    }else{
      $this->dbid = mysql_insert_id($dblink);
    }

    mysql_close($dblink);
    $dblink = null ;
  }
 }
?>
