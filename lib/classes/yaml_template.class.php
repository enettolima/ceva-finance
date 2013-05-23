<?
 /** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 08-05-2009 00:54:57 -0500 (Aug-Wed-2009) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class YamlTemplate Extends DataManager{
		public function load_single($search_str, $insert_log = false){
      parent::dm_load_single(NATURAL_DBNAME . ".yaml_template",$search_str);
      $this->yaml = Spyc::YAMLLoad($this->yaml);
    }
     
    public function load_list($output, $search_str, $insert_log = false){
      parent::dm_load_list(NATURAL_DBNAME . ".yaml_template", $output, $search_str);
    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".yaml_template", $this);
      $this->id = $this->dbid;
    }
    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".yaml_template", $upd_rule, $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".yaml_template", $rec_key);
    }
  }
  
?>
