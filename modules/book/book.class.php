<?php
/**
 * All methods in this class are protected
 * @access protected
 */
class Book Extends DataManager {
    /**
    * @smart-auto-routing false
    * @access private
    */
    function loadSingle($search_str) {
        parent::dmLoadSingle("book", $search_str);
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function loadList($output, $search_str) {
        parent::dmLoadList("book", $output, $search_str);
        return $this;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function insert() {
        parent::dmInsert("book", $this);
        $this->id = $this->dbid;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function update($upd_rule) {
        parent::dmUpdate("book", $upd_rule, $this);
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function remove($rec_key) {
        parent::dmRemove("book", $rec_key);
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
    * Method to create a new book
    *
    * Add a new book
    *
    * @url POST create
    * @smart-auto-routing false
    * 
    * @access public
    */
    function create($request_data) {
        //Validating data from the API call
        $this->_validate($request_data, "insert");

        $book = new Book();
        foreach ($request_data as $key => $value) {
            if ($key != "key") {
                $book->$key = $value;
            }
        }
        $book->insert();
        if ($book->affected > 0) {
            //Preparing response
            $response = array();
            $response['code'] = 201;
            $response['message'] = 'Book has been created!';
            $response['id'] = $book->id;
            return $response;
        } else {
            throw new Luracast\Restler\RestException(500, 'Book could not be created!');
        }
    }

    /**
    * Method to fecth Book Record by ID
    *
    * Fech a record for a specific book
    * by ID
    *
    * @url GET byID/{id}
    * @url POST byID
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 User not found for requested id  
    * @param int $id Book to be fetched
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
            throw new Luracast\Restler\RestException(404, 'Book not found!');
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
        
        foreach($resultdata as $key => $value){
            $result[$key] = $value;
        }
        //$result['data'] = $resultdata;
        //Return response
        return $result;
    }

    /**
    * Method to fecth All Books
    *
    * Fech all records from the database
    *
    * @url GET loadAll
    * @url POST loadAll
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 Book not found
    * @return mixed 
    */
    function loadAll() {
        $this->loadList("ASSOC", 'id>0');
        unset($this->restler);
        //parent::dm_load_list("book", "ASSOC", "id>'0'");
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
    * Method to Update book information
    *
    * Update book on database
    *
    * @url GET put
    * @url POST put
    * @smart-auto-routing false
    *
    * @access public
    * @throws 404 Book not found
    * @return mixed 
    */
    function put($request_data) {
        $this->_validate($request_data, "update");
        //Loading the object from the database
        $book = new Book();
        $book->loadSingle("id='" . $request_data['id'] . "'");
        unset($book->errorcode);
        unset($book->error);
        unset($book->dbid);
        unset($book->data);
        unset($book->affected);
        //Assigning variables
        foreach ($request_data as $key => $value) {
            if ($key == "key" || $key == "id") {
                //Skipp
            } else {
                $book->$key = $value;
            }
        }
        //Updating table with the new information
        $book->update("id='" . $request_data['id'] . "'");
        if ($book->affected > 0) {
            //Preparing response
            $response = array();
            $response['code'] = 200;
            $response['message'] = 'Book has been updated!';
            return $response;
        } else {
            //Could not update database table, maybe the record is the same?
            throw new Luracast\Restler\RestException(500, 'Book could not be updated!');
        }
    }

    /**
    * Method to delete a book
    *
    * Delete book from database
    *
    * @url GET delete
    * @url POST delete
    * @smart-auto-routing false
    *
    * @access public
    * @throws 404 Book not found
    * @return mixed 
    */
    function delete($request_data) {
        $this->_validate($request_data, "delete");
        $book = new Book();
        $book->loadSingle("id='" . $request_data['id'] . "'");
        if ($book->affected < 1) {
            throw new Luracast\Restler\RestException(404, 'Item not found!');
        }
        $book->remove("id='" . $request_data['id'] . "'");
        $response = array();
        $response['code'] = 200;
        $response['message'] = 'Book has been removed!';
        return $response;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function _validate($data, $type, $from_api = true) {
        //If the method called is an update, check if the id exists, otherwise return error
        $error_code = 400;
        if ($type == "update" || $type == "delete") {
            if (!$data['id']) {
                $error[] = 'Parameter ID is required!';
            }
        }
        /*
         * check if field is empty
         * Add more fields as needed
         */

        if ($type == "edit"){
            $this->loadSingle("name='{$data['name']}' AND id!='{$data['id']}'");
            if($this->affected>0){
                $error[] = 'This book name already exists!';
            }
        }
        
        if ($type == "create"){
            $this->loadSingle("name='{$data['name']}'");
            if($this->affected>0){
                $error[] = 'This book name already exists!';
            }
        }
        
        if ($type != "delete") {
            if (!$data['name']) {
              $error[] = 'Field name is required!';
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