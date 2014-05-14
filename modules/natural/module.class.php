<?
 /** 
* NATURAL - Copyright Open Source Mind, LLC 
* Last Modified: Date: 05-06-2014 17:23:02 -0500  $ @ Revision: $Rev: 11 $ 
* @package Natural Framework 
*/

/** 
* Manage Modules on database
*/ 

	class Module Extends DataManager{
		public function loadSingle($search_str){
      parent::dmLoadSingle(NATURAL_DBNAME . ".module",$search_str);
		}
     
    public function loadList($output, $search_str){
      parent::dmLoadList(NATURAL_DBNAME . ".module", $output, $search_str);
    }

    public function insert(){
      parent::dmInsert(NATURAL_DBNAME . ".module", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dmUpdate(NATURAL_DBNAME . ".module", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dmRemove(NATURAL_DBNAME . ".module", $rec_key);
    }
  }
  
?>