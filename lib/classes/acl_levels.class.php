<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 12-29-2009 15:35:21 -0500 (Dec-Tue-2009) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/
/** 
* <insert your class documentation here> 
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