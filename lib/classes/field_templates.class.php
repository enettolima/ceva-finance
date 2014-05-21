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
		public function loadSingle($search_str, $insert_log = false){
      parent::dmLoadSingle(NATURAL_DBNAME . ".field_templates",$search_str);
    }
     
    public function loadList($output, $search_str, $insert_log = false){
      parent::dmLoadList(NATURAL_DBNAME . ".field_templates", $output, $search_str);
    }

    public function insert(){
      parent::dmInsert(NATURAL_DBNAME . ".field_templates", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dmUpdate(NATURAL_DBNAME . ".field_templates", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dmRemove(NATURAL_DBNAME . ".field_templates", $rec_key);
    }
  }
  
?>