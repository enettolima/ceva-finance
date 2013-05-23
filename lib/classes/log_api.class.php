<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 02-16-2012 19:27:01 -0500 (Feb-Thu-2012) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class LogApi Extends DataManager{
		public function load_single($search_str, $insert_log = false){
      parent::dm_load_single(NATURAL_DBNAME . ".log_api",$search_str);
		}
     
    public function load_list($output, $search_str, $insert_log = false){
      parent::dm_load_list(NATURAL_DBNAME . ".log_api", $output, $search_str);
    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".log_api", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".log_api", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".log_api", $rec_key);
    }
  }
  
?>