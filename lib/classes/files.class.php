<?
/**
 * HIVE - Copyleft Open Source Mind, GP
 * Last Modified: Date: 07-29-2009 14:03:48 -0500 (Jul-Wed-2009) $ @ Revision: $Rev: 11 $
 * @package Hive
 */

/**
 * Files
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
        $this->fid = $this->dbid;
    }

    public function update($upd_rule) {
        parent::dm_update(NATURAL_DBNAME . ".files", $upd_rule, $this);
    }

    public function remove($rec_key) {
        parent::dm_remove(NATURAL_DBNAME . ".files", $rec_key);
    }

}
