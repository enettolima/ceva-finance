<?php
/** 
* NATURAL - Copyright Open Source Mind, LLC 
* Last Modified: Date: 05-06-2014 17:23:02 -0500  $ @ Revision: $Rev: 11 $ 
* @package Natural Framework 
*/

/** 
* DataManager is responsible to interact with your database
*/ 
/**
 *
 * @access private
 *
 */
 class DataManager{
  public $affected;
  public $errorcode = 0 ;
  public $error = "";
  public $data;
  public $dbid;

 /**
 *
 * @access private
 *
 */
  public function dmLoadSingle($table, $search_str) {
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
  
/**
 *
 * @access private
 *
 */
  public function dmLoadList($table, $output, $search_str, $count = FALSE, $count_query = NULL){
     //Use configuration from bootstrap
		 $dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

     $query = "SELECT * FROM {$table} WHERE {$search_str}";

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

 /**
 *
 * @access private
 *
 */
  
  public function dmLoadCustomList($query, $output, $count = FALSE, $count_query = NULL){
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

	  //print($query);
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

 /**
 *
 * @access private
 *
 */
  
  public function dmInsert($table, $fields){

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

 /**
 *
 * @access private
 *
 */
  
  public function dmRemove($table, $record_key){
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

 /**
 *
 * @access private
 *
 */

  public function dmUpdate($table, $update_rule, $fields){
    //Use configuration from bootstrap
		$dblink = mysql_connect (NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);

    /*Loop through the fields to build insert query*/
    foreach($fields as $key => $value)
    {
      if(!($key == 'dblink' || $key == 'affected' || $key == 'errorcode' || $key == 'error' || $key == 'data' || $key == 'dbid' || $key == 'id' || $key == 'function' || $key == 'fn')){
        $query_fields .= ", `{$key}`='{$value}'";
      }
    }

    $query_fields = substr($query_fields,1);
    $query = "UPDATE {$table} SET {$query_fields} WHERE {$update_rule}";

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

 /**
 *
 * @access private
 *
 */

	public function dmRandom($alpha = false, $length = 6){
		if($alpha){
			$random_key = substr(md5(rand().rand()), 0, $length);
		}else{
			$random_key = substr(mt_rand(), 0, $length);
		}
		return $random_key;
	}

 /**
 *
 * @access private
 *
 */

	public function dmCustomQuery($query, $return_object=false, $return_id=false){
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

 /**
 *
 * @access private
 *
 */

	public function dmCheckModule($module){
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

 /**
 *
 * @access private
 *
 */

  public function dmCustomInsert($query){

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
  
 /**
 *
 * @access private
 *
 */

  public function dmCustomUpdate($query){
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
