<?php
    /**
     * NATURAL - Copyright Open Source Mind, LLC
     * Last Modified: Date: 05-06-2014 17:23:02 -0500  $ @ Revision: $Rev: 11 $
     * @package Natural Framework
     */

    /**
     * Dashboard widgets class
     */
    class DashboardWidgets extends DataManager
    {
        public function loadSingle($search_str)
        {
            parent::dmLoadSingle("dashboard_widgets", $search_str);
        }

        public function loadList($output, $search_str)
        {
            parent::dmLoadlist("dashboard_widgets", $output, $search_str);
        }

        public function insert()
        {
            parent::dmInsert("dashboard_widgets", $this);
            $this->id = $this->dbid;
        }

        public function update($upd_rule)
        {
            parent::dmUpdate("dashboard_widgets", $upd_rule, $this);
        }

        public function remove($rec_key)
        {
            parent::dmRemove("dashboard_widgets", $rec_key);
        }
    }
