<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 07-24-2009 16:38:05 -0500 (Jul-Fri-2009) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class Group Extends DataManager{
		public function load_single($search_str, $insert_log = false){
      parent::dm_load_single(NATURAL_DBNAME . ".group",$search_str);
      if($insert_log)
      {
        $stamp = date("Y-m-d H:i:s");
        $this->log_user_id    = $_SESSION['log_id'];
        $this->log_action     = "S";
        $this->log_timestamp  = $stamp;
        parent::dm_insert(NATURAL_DBLOG . ".group", $this);
      }
    }
     
    public function load_list($output, $search_str, $insert_log = false){
      parent::dm_load_list(NATURAL_DBNAME . ".group", $output, $search_str);
      if($insert_log)
      {
        $stamp = date("Y-m-d H:i:s");
        $this->log_user_id    = $_SESSION['log_id'];
        $this->log_action     = "L";
        $this->log_timestamp  = $stamp;
        parent::dm_insert(NATURAL_DBLOG . ".group", $this);
      }

    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".group", $this);
      $this->id = $this->dbid;
      
      $stamp = date("Y-m-d H:i:s");
      $this->log_user_id    = $_SESSION['log_id'];
      $this->log_action     = "I";
      $this->log_timestamp  = $stamp;
      parent::dm_insert(NATURAL_DBLOG . ".group", $this);

    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".group", $upd_rule, $this);
      
      $stamp = date("Y-m-d H:i:s");
      $this->log_user_id    = $_SESSION['log_id'];
      $this->log_action     = "U";
      $this->log_timestamp  = $stamp;
      parent::dm_insert(NATURAL_DBLOG . ".group", $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".group", $rec_key);
      
      $stamp = date("Y-m-d H:i:s");
      $this->log_user_id    = $_SESSION['log_id'];
      $this->log_action     = "R";
      $this->log_timestamp  = $stamp;
      parent::dm_insert(NATURAL_DBLOG . ".group", $this);
    }
		
		public function update_group_status($status,$customerid){
			parent::dm_custom_query("UPDATE ".NATURAL_DBNAME.".group SET status='{$status}' WHERE customer_id='{$customerid}'");	
		}
  }
  
?>
