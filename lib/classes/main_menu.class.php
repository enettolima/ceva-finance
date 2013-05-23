<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 06-27-2009 12:23:04 -0500 (Jun-Sat-2009) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/
/** 
* <insert your class documentation here> 
*/ 
	class MainMenu Extends DataManager{
		public function load_single($search_str){
      parent::dm_load_single(NATURAL_DBNAME . ".main_menu",$search_str);
    }
     
    public function load_list($output, $search_str){
      parent::dm_load_list(NATURAL_DBNAME . ".main_menu", $output, $search_str);
    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".main_menu", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".main_menu", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".main_menu", $rec_key);
    }
  }
?>
