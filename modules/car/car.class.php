<?php
/**
 * All methods in this class are protected
 * @access protected
 */
class Car Extends DataManager {
    /**
    * @smart-auto-routing false
    * @access private
    */
    function loadSingle($search_str) {
        parent::dmLoadSingle(NATURAL_DBNAME . ".car", $search_str);
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function loadList($output, $search_str) {
        parent::dmLoadList(NATURAL_DBNAME . ".car", $output, $search_str);
        return $this;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function insert() {
        parent::dmInsert(NATURAL_DBNAME . ".car", $this);
        $this->id = $this->dbid;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function update($upd_rule) {
        parent::dmUpdate(NATURAL_DBNAME . ".car", $upd_rule, $this);
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function remove($rec_key) {
        parent::dmRemove(NATURAL_DBNAME . ".car", $rec_key);
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
    * Method to create a new car
    *
    * Add a new car
    *
    * @url POST create
    * @smart-auto-routing false
    * 
    * @access public
    */
    function create($request_data) {
        //Validating data from the API call
        $this->_validate($request_data, "insert");

        $car = new Car();
        foreach ($request_data as $key => $value) {
            if ($key != "key") {
                $car->$key = $value;
            }
        }
        $car->insert();
        if ($car->affected > 0) {
            //Preparing response
            $response = array();
            $response['code'] = 201;
            $response['message'] = 'Car has been created!';
            $response['id'] = $car->id;
            return $response;
        } else {
            throw new Luracast\Restler\RestException(500, 'Car could not be created!');
        }
    }

    /**
    * Method to fecth Car Record by ID
    *
    * Fech a record for a specific car
    * by ID
    *
    * @url GET byID/{id}
    * @url POST byID
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 User not found for requested id  
    * @param int $id Car to be fetched
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
            throw new Luracast\Restler\RestException(404, 'Car not found!');
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
    * Method to fecth All Cars
    *
    * Fech all records from the database
    *
    * @url GET loadAll
    * @url POST loadAll
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 Car not found
    * @return mixed 
    */
    function loadAll() {
        $this->loadList("ASSOC", 'id>0');
        unset($this->restler);
        //parent::dm_load_list(NATURAL_DBNAME . ".car", "ASSOC", "id>'0'");
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
    * Method to Update car information
    *
    * Update car on database
    *
    * @url GET put
    * @url POST put
    * @smart-auto-routing false
    *
    * @access public
    * @throws 404 Car not found
    * @return mixed 
    */
    function put($request_data) {
        $this->_validate($request_data, "update");
        //Loading the object from the database
        $car = new Car();
        $car->loadSingle("id='" . $request_data['id'] . "'");
        unset($car->errorcode);
        unset($car->error);
        unset($car->dbid);
        unset($car->data);
        unset($car->affected);
        //Assigning variables
        foreach ($request_data as $key => $value) {
            if ($key == "key" || $key == "id") {
                //Skipp
            } else {
                $car->$key = $value;
            }
        }
        //Updating table with the new information
        $car->update("id='" . $request_data['id'] . "'");
        if ($car->affected > 0) {
            //Preparing response
            $response = array();
            $response['code'] = 200;
            $response['message'] = 'Car has been updated!';
            return $response;
        } else {
            //Could not update database table, maybe the record is the same?
            throw new Luracast\Restler\RestException(500, 'Car could not be updated!');
        }
    }

    /**
    * Method to delete a car
    *
    * Delete car from database
    *
    * @url GET delete
    * @url POST delete
    * @smart-auto-routing false
    *
    * @access public
    * @throws 404 Car not found
    * @return mixed 
    */
    function delete($request_data) {
        $this->_validate($request_data, "delete");
        $car = new Car();
        $car->loadSingle("id='" . $request_data['id'] . "'");
        if ($car->affected < 1) {
            throw new Luracast\Restler\RestException(404, 'Item not found!');
        }
        $car->remove("id='" . $request_data['id'] . "'");
        $response = array();
        $response['code'] = 200;
        $response['message'] = 'Car has been removed!';
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
            if (!$data['make']) {
              $error[] = 'Field make is required!';
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