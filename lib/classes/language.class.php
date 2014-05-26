<?
/** 
* NATURAL - Copyright Open Source Mind, LLC 
* Last Modified: Date: 05-06-2014 17:23:02 -0500  $ @ Revision: $Rev: 11 $ 
* @package Natural Framework 
*/

/** 
* Language manager, this class will interact with languages table on database
*/

	class Language Extends DataManager{
		public function loadSingle($search_str){
      parent::dmLoadSingle(NATURAL_DBNAME . ".language",$search_str);
		}
     
    public function loadList($output, $search_str){
      parent::dmLoadList(NATURAL_DBNAME . ".language", $output, $search_str);
    }

    public function insert(){
      parent::dmInsert(NATURAL_DBNAME . ".language", $this);
      $this->id = $this->dbid;
    }

    public function update($upd_rule){
      parent::dmUpdate(NATURAL_DBNAME . ".language", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dmRemove(NATURAL_DBNAME . ".language", $rec_key);
    }
  }
  
?>
