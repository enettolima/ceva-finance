<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 12-09-2010 15:58:15 -0500 (Dec-Thu-2010) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class Module Extends DataManager{
		public function load_single($search_str){
      parent::dm_load_single(NATURAL_DBNAME . ".module",$search_str);
		}
     
    public function load_list($output, $search_str){
      parent::dm_load_list(NATURAL_DBNAME . ".module", $output, $search_str);
    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".module", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".module", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".module", $rec_key);
    }
  }
  
?>