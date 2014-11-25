<?php
/**
 * All methods in this class are protected
 * @access protected
 */
class DashboardWidgets Extends DataManager {
    /**
    * @smart-auto-routing false
    * @access private
    */
    function loadSingle($search_str) {
        parent::dmLoadSingle("dashboard_widgets", $search_str);
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function loadList($output, $search_str) {
        parent::dmLoadList("dashboard_widgets", $output, $search_str);
        return $this;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function insert() {
        parent::dmInsert("dashboard_widgets", $this);
        $this->id = $this->dbid;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function update($upd_rule) {
        parent::dmUpdate("dashboard_widgets", $upd_rule, $this);
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function remove($rec_key) {
        parent::dmRemove("dashboard_widgets", $rec_key);
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function loadCustomList($query, $output, $count) {
        parent::dmLoadCustomList($query, $output, $count);
    }
    //End of database access

    /**
    * Method to create a new dashboard_widgets
    *
    * Add a new dashboard_widgets
    *
    * @url POST create
    * @smart-auto-routing false
    * 
    * @access public
    */
    function create($request_data) {
        //Validating data from the API call
        $this->_validate($request_data, "insert");

        $dashboard_widgets = new DashboardWidgets();
        foreach ($request_data as $key => $value) {
            if ($key != "key") {
                $dashboard_widgets->$key = $value;
            }
        }
        $dashboard_widgets->insert();
        if ($dashboard_widgets->affected > 0) {
            //Preparing response
            $response = array();
            $response['code'] = 201;
            $response['message'] = 'DashboardWidgets has been created!';
            $response['id'] = $dashboard_widgets->id;
            return $response;
        } else {
            throw new Luracast\Restler\RestException(500, 'DashboardWidgets could not be created!');
        }
    }

    /**
    * Method to fecth DashboardWidgets Record by ID
    *
    * Fech a record for a specific dashboard_widgets
    * by ID
    *
    * @url GET byID/{id}
    * @url POST byID
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 User not found for requested id  
    * @param int $id DashboardWidgets to be fetched
    * @return mixed 
    */
    function byID($id) {
        //If id is null
        if (is_null($id)) {
            throw new Luracast\Restler\RestException(400, 'Parameter id is missing or invalid!');
        }
        
        //Get object by id
        $this->loadSingle("id='{$id}'");
        //If object not found throw an error
        if ($this->affected < 1) {
            throw new Luracast\Restler\RestException(404, 'DashboardWidgets not found!');
        }
        
        //Unset restler
        unset($this->restler);
        unset($this->errorcode);
        unset($this->error);
        unset($this->dbid);
        unset($this->data);
        unset($this->affected);
        $resultdata = (array) $this;
        $result['code'] = 200;
        $result['data'] = $resultdata;
        //Return response
        return $result;
    }

    /**
    * Method to fecth All DashboardWidgetss
    *
    * Fech all records from the database
    *
    * @url GET loadAll
    * @url POST loadAll
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 DashboardWidgets not found
    * @return mixed 
    */
    function loadAll() {
        $this->loadList("ASSOC", 'id>0');
        unset($this->restler);
        //parent::dm_load_list("dashboard_widgets", "ASSOC", "id>'0'");
        unset($this->errorcode);
        unset($this->error);
        unset($this->dbid);
        if ($this->affected < 1) {
            throw new Luracast\Restler\RestException(404, 'No items found!');
        }

        $resultdata = (array) $this;
        $result['code'] = 200;
        $result['data'] = $this->data;
        //Return response
        return $result;
    }

    /**
    * Method to Update dashboard_widgets information
    *
    * Update dashboard_widgets on database
    *
    * @url GET put
    * @url POST put
    * @smart-auto-routing false
    *
    * @access public
    * @throws 404 DashboardWidgets not found
    * @return mixed 
    */
    function put($request_data) {
        $this->_validate($request_data, "update");
        //Loading the object from the database
        $dashboard_widgets = new DashboardWidgets();
        $dashboard_widgets->loadSingle("id='" . $request_data['id'] . "'");
        unset($dashboard_widgets->errorcode);
        unset($dashboard_widgets->error);
        unset($dashboard_widgets->dbid);
        unset($dashboard_widgets->data);
        unset($dashboard_widgets->affected);
        //Assigning variables
        foreach ($request_data as $key => $value) {
            if ($key == "key" || $key == "id") {
                //Skipp
            } else {
                $dashboard_widgets->$key = $value;
            }
        }
        //Updating table with the new information
        $dashboard_widgets->update("id='" . $request_data['id'] . "'");
        if ($dashboard_widgets->affected > 0) {
            //Preparing response
            $response = array();
            $response['code'] = 200;
            $response['message'] = 'DashboardWidgets has been updated!';
            return $response;
        } else {
            //Could not update database table, maybe the record is the same?
            throw new Luracast\Restler\RestException(500, 'DashboardWidgets could not be updated!');
        }
    }

    /**
    * Method to delete a dashboard_widgets
    *
    * Delete dashboard_widgets from database
    *
    * @url GET delete
    * @url POST delete
    * @smart-auto-routing false
    *
    * @access public
    * @throws 404 DashboardWidgets not found
    * @return mixed 
    */
    function delete($request_data) {
        $this->_validate($request_data, "delete");
        $dashboard_widgets = new DashboardWidgets();
        $dashboard_widgets->loadSingle("id='" . $request_data['id'] . "'");
        if ($dashboard_widgets->affected < 1) {
            throw new Luracast\Restler\RestException(404, 'Item not found!');
        }
        $dashboard_widgets->remove("id='" . $request_data['id'] . "'");
        $response = array();
        $response['code'] = 200;
        $response['message'] = 'DashboardWidgets has been removed!';
        return $response;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function _validate($data, $type, $from_api = true) {
        //If the method called is an update, check if the id exists, otherwise return error
        if ($type == "update" || $type == "delete") {
            if (!$data['id']) {
              throw new Luracast\Restler\RestException(404, 'Parameter ID is required!');
            }
        }
        /*
         * check if field is empty
         * Add more fields as needed
         */

        if ($type != "delete") {
            if (!$data['title']) {
              $error[] = 'Field title is required!';
            }
        }

        //If error exists return or throw exception if the call has been made from the API
        if (!empty($error)) {
            if ($from_api) {
                throw new Luracast\Restler\RestException($error_code, $error[0]);
            }
            return $error;
            exit(0);
        }
    }
}
?>
