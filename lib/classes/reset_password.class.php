<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 01-02-2012 15:25:13 -0500 (Jan-Mon-2012) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class ResetPassword Extends DataManager{
		public function load_single($search_str, $insert_log = false){
      parent::dm_load_single(NATURAL_DBNAME . ".reset_password",$search_str);
		}
     
    public function load_list($output, $search_str, $insert_log = false){
      parent::dm_load_list(NATURAL_DBNAME . ".reset_password", $output, $search_str);
    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".reset_password", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".reset_password", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".reset_password", $rec_key);
    }
  }
  
?>