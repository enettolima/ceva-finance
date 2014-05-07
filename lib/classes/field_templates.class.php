<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 07-22-2009 14:16:49 -0500 (Jul-Wed-2009) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* Responsible to get fields to show on a form
*/ 

	class FieldTemplates Extends DataManager{
		public function load_single($search_str, $insert_log = false){
      parent::dm_load_single(NATURAL_DBNAME . ".field_templates",$search_str);
    }
     
    public function load_list($output, $search_str, $insert_log = false){
      parent::dm_load_list(NATURAL_DBNAME . ".field_templates", $output, $search_str);
    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".field_templates", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".field_templates", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".field_templates", $rec_key);
    }
  }
  
?>