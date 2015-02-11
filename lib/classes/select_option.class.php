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
      parent::dmLoadSingle("select_option",$search_str);
    }
     
    public function loadList($output, $search_str, $insert_log = false){
      parent::dmLoadList("select_option", $output, $search_str);
    }

    public function insert(){
      parent::dmInsert("select_option", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dmUpdate("select_option", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dmRemove("select_option", $rec_key);
    }
  }
  
?>