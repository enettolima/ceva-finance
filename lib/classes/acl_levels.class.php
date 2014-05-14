<?
/** 
* NATURAL - Copyright Open Source Mind, LLC 
* Last Modified: Date: 05-06-2014 17:23:02 -0500  $ @ Revision: $Rev: 11 $ 
* @package Natural Framework 
*/

/** 
* ACL(Access control level) responsible to provide USER level for the application
*/ 

class AclLevels Extends DataManager{
  public function loadSingle($search_str, $insert_log = false){
    parent::dmLoadSingle(NATURAL_DBNAME . ".acl_levels",$search_str);
  }
  public function loadList($output, $search_str, $insert_log = false){
    parent::dmLoadList(NATURAL_DBNAME . ".acl_levels", $output, $search_str);
  }
  public function insert(){
    parent::dmInsert(NATURAL_DBNAME . ".acl_levels", $this);
    $this->id = $this->dbid;
  }
  public function update($upd_rule){
    parent::dmUpdate(NATURAL_DBNAME . ".acl_levels", $upd_rule, $this);
  }
  public function remove($rec_key){
    parent::dmRemove(NATURAL_DBNAME . ".acl_levels", $rec_key);
  }
}
?>
