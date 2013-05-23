<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 01-08-2011 14:52:48 -0500 (Jan-Sat-2011) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class DashboardWidgets Extends DataManager{
		public function load_single($search_str){
      parent::dm_load_single(NATURAL_DBNAME . ".dashboard_widgets",$search_str);
		}
     
    public function load_list($output, $search_str){
      parent::dm_load_list(NATURAL_DBNAME . ".dashboard_widgets", $output, $search_str);
    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".dashboard_widgets", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".dashboard_widgets", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".dashboard_widgets", $rec_key);
    }
  }
  
?>
