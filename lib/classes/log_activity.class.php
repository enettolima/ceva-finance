<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 05-17-2010 13:59:27 -0500 (May-Mon-2010) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class LogActivity Extends DataManager{
		public function load_single($search_str){
      parent::dm_load_single(NATURAL_DBNAME . ".log_activity",$search_str);
		}
     
    public function load_list($output, $search_str){
      parent::dm_load_list(NATURAL_DBNAME . ".log_activity", $output, $search_str);
    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".log_activity", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".log_activity", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".log_activity", $rec_key);
    }
  }
  
?>