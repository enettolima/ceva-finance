<?php
 /** 
* NATURAL - Copyright Open Source Mind, LLC 
* Last Modified: Date: 05-06-2014 17:23:02 -0500  $ @ Revision: $Rev: 11 $ 
* @package Natural Framework 
*/

/** 
* Select Option class, to help you save listview options on database
*/ 

	class SelectOption Extends DataManager{
		public function loadSingle($search_str, $insert_log = false){
      parent::dmLoadSingle(NATURAL_DBNAME . ".select_option",$search_str);
    }
     
    public function loadList($output, $search_str, $insert_log = false){
      parent::dmLoadList(NATURAL_DBNAME . ".select_option", $output, $search_str);
    }

    public function insert(){
      parent::dmInsert(NATURAL_DBNAME . ".select_option", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dmUpdate(NATURAL_DBNAME . ".select_option", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dmRemove(NATURAL_DBNAME . ".select_option", $rec_key);
    }
  }
  
?>