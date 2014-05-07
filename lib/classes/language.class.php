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
