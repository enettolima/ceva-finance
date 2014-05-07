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
  public function load_single($search_str, $insert_log = false){
    parent::dm_load_single(NATURAL_DBNAME . ".acl_levels",$search_str);
  }
  public function load_list($output, $search_str, $insert_log = false){
    parent::dm_load_list(NATURAL_DBNAME . ".acl_levels", $output, $search_str);
  }
  public function insert(){
    parent::dm_insert(NATURAL_DBNAME . ".acl_levels", $this);
    $this->id = $this->dbid;
  }
  public function update($upd_rule){
    parent::dm_update(NATURAL_DBNAME . ".acl_levels", $upd_rule, $this);
  }
  public function remove($rec_key){
    parent::dm_remove(NATURAL_DBNAME . ".acl_levels", $rec_key);
  }
}
?>
