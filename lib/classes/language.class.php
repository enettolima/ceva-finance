<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 05-18-2011 11:05:25 -0500 (May-Wed-2011) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class Language Extends DataManager{
		public function load_single($search_str){
      parent::dm_load_single(NATURAL_DBNAME . ".language",$search_str);
		}
     
    public function load_list($output, $search_str){
      parent::dm_load_list(NATURAL_DBNAME . ".language", $output, $search_str);
    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".language", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".language", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".language", $rec_key);
    }
  }
  
?>
