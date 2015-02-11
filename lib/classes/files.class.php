<?php
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
        parent::dmLoadSingle("files", $search_str);
    }

    public function loadList($output, $search_str) {
        parent::dmLoadList("files", $output, $search_str);
    }

    public function insert() {
        parent::dmInsert("files", $this);
        $this->id = $this->dbid;
    }

    public function update($upd_rule) {
        parent::dmUpdate("files", $upd_rule, $this);
    }

    public function remove($rec_key) {
        parent::dmRemove("files", $rec_key);
    }

}
