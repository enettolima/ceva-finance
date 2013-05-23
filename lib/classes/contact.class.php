<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 08-03-2009 14:12:30 -0500 (Aug-Mon-2009) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class Contact Extends DataManager{
		public function load_single($search_str, $insert_log = false){
      parent::dm_load_single(NATURAL_DBNAME . ".contact",$search_str);
      if($insert_log)
      {
        $stamp = date("Y-m-d H:i:s");
        $this->log_user_id    = $_SESSION['log_id'];
        $this->log_action     = "S";
        $this->log_timestamp  = $stamp;
        parent::dm_insert(NATURAL_DBLOG . ".contact", $this);
      }
    }
     
    public function load_list($output, $search_str, $insert_log = false){
      parent::dm_load_list(NATURAL_DBNAME . ".contact", $output, $search_str);
      if($insert_log)
      {
        $stamp = date("Y-m-d H:i:s");
        $this->log_user_id    = $_SESSION['log_id'];
        $this->log_action     = "L";
        $this->log_timestamp  = $stamp;
        parent::dm_insert(NATURAL_DBLOG . ".contact", $this);
      }

    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".contact", $this);
      $this->id = $this->dbid;
      
      $stamp = date("Y-m-d H:i:s");
      $this->log_user_id    = $_SESSION['log_id'];
      $this->log_action     = "I";
      $this->log_timestamp  = $stamp;
      parent::dm_insert(NATURAL_DBLOG . ".contact", $this);

    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".contact", $upd_rule, $this);
      
      $stamp = date("Y-m-d H:i:s");
      $this->log_user_id    = $_SESSION['log_id'];
      $this->log_action     = "U";
      $this->log_timestamp  = $stamp;
      parent::dm_insert(NATURAL_DBLOG . ".contact", $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".contact", $rec_key);
      
      $stamp = date("Y-m-d H:i:s");
      $this->log_user_id    = $_SESSION['log_id'];
      $this->log_action     = "R";
      $this->log_timestamp  = $stamp;
      parent::dm_insert(NATURAL_DBLOG . ".contact", $this);
    }
  }
  
?>