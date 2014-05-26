<?php
/**
 * All methods in this class are protected
 * @access protected
 */
class Module Extends DataManager {
    /**
    * @smart-auto-routing false
    * @access private
    */
    function loadSingle($search_str) {
        parent::dmLoadSingle(NATURAL_DBNAME . ".module", $search_str);
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function loadList($output, $search_str) {
        parent::dmLoadList(NATURAL_DBNAME . ".module", $output, $search_str);
        return $this;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function insert() {
        parent::dmInsert(NATURAL_DBNAME . ".module", $this);
        $this->id = $this->dbid;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function update($upd_rule) {
        parent::dmUpdate(NATURAL_DBNAME . ".module", $upd_rule, $this);
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function remove($rec_key) {
        parent::dmRemove(NATURAL_DBNAME . ".module", $rec_key);
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
    * Method to create a new module
    *
    * Add a new module
    *
    * @url POST create
    * @smart-auto-routing false
    * 
    * @access public
    */
    function create($request_data) {
        //Validating data from the API call
        $this->_validate($request_data, "insert");

        $module = new Module();
        foreach ($request_data as $key => $value) {
            if ($key != "key") {
                $module->$key = $value;
            }
        }
        $module->insert();
        if ($module->affected > 0) {
            //Preparing response
            $response = array();
            $response['code'] = 201;
            $response['message'] = 'Module has been created!';
            $response['id'] = $module->id;
            return $response;
        } else {
            throw new Luracast\Restler\RestException(500, 'Module could not be created!');
        }
    }

    /**
    * Method to fecth Module Record by ID
    *
    * Fech a record for a specific module
    * by ID
    *
    * @url GET byID/{id}
    * @url POST byID
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 User not found for requested id  
    * @param int $id Module to be fetched
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
            throw new Luracast\Restler\RestException(404, 'Module not found!');
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
    * Method to fecth All Modules
    *
    * Fech all records from the database
    *
    * @url GET loadAll
    * @url POST loadAll
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 Module not found
    * @return mixed 
    */
    function loadAll() {
        $this->loadList("ASSOC", 'id>0');
        unset($this->restler);
        //parent::dm_load_list(NATURAL_DBNAME . ".module", "ASSOC", "id>'0'");
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
    * Method to Update module information
    *
    * Update module on database
    *
    * @url GET put
    * @url POST put
    * @smart-auto-routing false
    *
    * @access public
    * @throws 404 Module not found
    * @return mixed 
    */
    function put($request_data) {
        $this->_validate($request_data, "update");
        //Loading the object from the database
        $module = new Module();
        $module->loadSingle("id='" . $request_data['id'] . "'");
        unset($module->errorcode);
        unset($module->error);
        unset($module->dbid);
        unset($module->data);
        unset($module->affected);
        //Assigning variables
        foreach ($request_data as $key => $value) {
            if ($key == "key" || $key == "id") {
                //Skipp
            } else {
                $module->$key = $value;
            }
        }
        //Updating table with the new information
        $module->update("id='" . $request_data['id'] . "'");
        if ($module->affected > 0) {
            //Preparing response
            $response = array();
            $response['code'] = 200;
            $response['message'] = 'Module has been updated!';
            return $response;
        } else {
            //Could not update database table, maybe the record is the same?
            throw new Luracast\Restler\RestException(500, 'Module could not be updated!');
        }
    }

    /**
    * Method to delete a module
    *
    * Delete module from database
    *
    * @url GET delete
    * @url POST delete
    * @smart-auto-routing false
    *
    * @access public
    * @throws 404 Module not found
    * @return mixed 
    */
    function delete($request_data) {
        $this->_validate($request_data, "delete");
        $module = new Module();
        $module->loadSingle("id='" . $request_data['id'] . "'");
        if ($module->affected < 1) {
            throw new Luracast\Restler\RestException(404, 'Item not found!');
        }
        $module->remove("id='" . $request_data['id'] . "'");
        $response = array();
        $response['code'] = 200;
        $response['message'] = 'Module has been removed!';
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
            if (!$data['version']) {
                $error[] = 'Field version is required!';
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