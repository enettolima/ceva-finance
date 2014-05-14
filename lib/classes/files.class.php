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

    public function loadSingle($search_str) {
        parent::dmLoadSingle(NATURAL_DBNAME . ".files", $search_str);
    }

    public function loadList($output, $search_str) {
        parent::dmLoadList(NATURAL_DBNAME . ".files", $output, $search_str);
    }

    public function insert() {
        parent::dmInsert(NATURAL_DBNAME . ".files", $this);
        $this->id = $this->dbid;
    }

    public function update($upd_rule) {
        parent::dmUpdate(NATURAL_DBNAME . ".files", $upd_rule, $this);
    }

    public function remove($rec_key) {
        parent::dmRemove(NATURAL_DBNAME . ".files", $rec_key);
    }

}
