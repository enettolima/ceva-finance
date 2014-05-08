<?
/** 
* NATURAL - Copyright Open Source Mind, LLC 
* Last Modified: Date: 05-06-2014 17:23:02 -0500  $ @ Revision: $Rev: 11 $ 
* @package Natural Framework 
*/

/** 
* Important to manage media files on the database
*/ 
class Files Extends DataManager {

    public function load_single($search_str) {
        parent::dm_load_single(NATURAL_DBNAME . ".files", $search_str);
    }

    public function load_list($output, $search_str) {
        parent::dm_load_list(NATURAL_DBNAME . ".files", $output, $search_str);
    }

    public function insert() {
        parent::dm_insert(NATURAL_DBNAME . ".files", $this);
        $this->id = $this->dbid;
    }

    public function update($upd_rule) {
        parent::dm_update(NATURAL_DBNAME . ".files", $upd_rule, $this);
    }

    public function remove($rec_key) {
        parent::dm_remove(NATURAL_DBNAME . ".files", $rec_key);
    }

}
