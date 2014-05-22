<?php

/*
 * Before function name:
 * Use protected to make the API verify the API key
 * Use private to block the method
 * NATURAL_API_KEY is stored on bootstrap.php and/or bootstrap.dev.php
 */

/**
 * @access protected
 */
class Book Extends DataManager {
    /*
     * Database access
     */

    function load_single($search_str) {
        parent::dm_load_single(NATURAL_DBNAME . ".book", $search_str);
    }

    function load_list($output, $search_str) {
        parent::dm_load_list(NATURAL_DBNAME . ".book", $output, $search_str);
        return $this;
    }

    function insert() {
        parent::dm_insert(NATURAL_DBNAME . ".book", $this);
        $this->id = $this->dbid;
    }

    function update($upd_rule) {
        parent::dm_update(NATURAL_DBNAME . ".book", $upd_rule, $this);
    }

    function remove($rec_key) {
        parent::dm_remove(NATURAL_DBNAME . ".book", $rec_key);
    }

    function load_custom_list($query, $output, $count) {
        parent::dm_load_custom_list($query, $output, $count);
    }

    //End of database access

    /*
     * API methods
     */
    protected function getadd($request_data) {
        return $this->add($request_data);
    }

    protected function postadd($request_data) {
        return $this->add($request_data);
    }

    protected function getupdate($request_data) {
        return $this->updateInfo($request_data);
    }

    protected function postupdate($request_data) {
        return $this->updateInfo($request_data);
    }

    function getbyId($request_data) {
        return $this->findByID($request_data);
    }

    protected function postbyId($request_data) {
        return $this->findByID($request_data);
    }

    protected function getall($request_data) {
        return $this->loadAll();
    }

    protected function postall($request_data) {
        return $this->loadAll();
    }

    protected function getremove($request_data) {
        return $this->delete($request_data);
    }

    protected function postremove($request_data) {
        return $this->delete($request_data);
    }

    /*
     * Add new book
     */

    private function add($data) {
        //Validating data from the API call
        $this->_validate($data, "insert");

        $book = new Book();
        foreach ($data as $key => $value) {
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
            throw new RestException(500, 'Book could not be created!');
        }
    }

    /*
     * Getting book by id
     */

    private function findByID($data) {
        //If id is null
        if (is_null($data['id']))
            throw new RestException(400, 'Parameter id is missing or invalid!');
        //Get object by id
        parent::dm_load_single(NATURAL_DBNAME . ".book", "id='{$data['id']}'");
        //If object not found throw an error
        if ($this->affected < 1)
            throw new RestException(404, 'Book not found!');
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

    /*
     * Get all the books
     */

    private function loadAll() {
        unset($this->restler);
        parent::dm_load_list(NATURAL_DBNAME . ".book", "ASSOC", "id>'0'");
        unset($this->errorcode);
        unset($this->error);
        unset($this->dbid);
        if ($this->affected < 1)
            throw new RestException(404, 'No items found!');

        $this->code = 200;
        return $this;
    }

    /*
     * Updating book data
     */

    protected function updateInfo($data) {
        $this->_validate($data, "update");
        //Loading the object from the database
        $book = new Book();
        $book->load_single("id='" . $data['id'] . "'");
        unset($book->errorcode);
        unset($book->error);
        unset($book->dbid);
        unset($book->data);
        unset($book->affected);
        //Assigning variables
        foreach ($data as $key => $value) {
            if ($key == "key" || $key == "id") {
                //Skipp
            } else {
                $book->$key = $value;
            }
        }
        //Updating table with the new information
        $book->update("id='" . $data['id'] . "'");
        if ($book->affected > 0) {
            //Preparing response
            $response = array();
            $response['code'] = 200;
            $response['message'] = 'Book has been updated!';
            return $response;
        } else {
            //Could not update database table, maybe the record is the same?
            throw new RestException(500, 'Book could not be updated!');
        }
    }

    /*
     * Removing book
     */

    private function delete($data) {
        $this->_validate($data, "delete");
        $book = new Book();
        $book->load_single("id='" . $data['id'] . "'");
        if ($book->affected < 1)
            throw new RestException(404, 'Item not found!');

        $book->remove("id='" . $data['id'] . "'");
        $response = array();
        $response['code'] = 200;
        $response['message'] = 'Book has been removed!';
        return $response;
    }

    /*
     * Validating book data
     */

    function _validate($data, $type, $from_api = true) {
        //If the method called is an update, check if the id exists, otherwise return error
        if ($type == "update" || $type == "delete") {
            if (!$data['id']) {
                throw new RestException(404, 'Parameter ID is required!');
            }
        }
        /*
         * check if field is empty
         * Add more fields as needed
         */

        if ($type != "delete") {
            if (!$data['name']) {
                $error = 'Field name is required';
                $error_code = 404;
            }
        }

        //If error exists return or throw exception if the call has been made from the API
        if ($error) {
            if ($from_api) {
                throw new RestException($error_code, $error);
            }
            return $error;
            exit(0);
        }
    }

}

?>