<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 04-20-2010 18:00:06 -0500 (Apr-Tue-2010) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class Log Extends DataManager{
		public function load_single($search_str){
      parent::dm_load_single(NATURAL_DBNAME . ".log",$search_str);
		}
     
    public function load_list($output, $search_str){
      parent::dm_load_list(NATURAL_DBNAME . ".log", $output, $search_str);
    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".log", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".log", $upd_rule, $this);
		}

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".log", $rec_key);
    }
  }
  
?>
