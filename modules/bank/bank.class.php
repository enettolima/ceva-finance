<?php
/**
 * All methods in this class are protected
 * @access protected
 */
class Bank {
  /**
  * Method to create a new bank
  *
  * Add a new bank
  *
  * @url POST create
  * @smart-auto-routing false
  *
  * @access public
  */
  function create($request_data) {
    //Validating data from the API call
    $this->_validate($request_data, "create");
    $bank = new Bank();
    $db = DataConnection::readWrite();
    //$u = $db->user();
    $data = array();
    unset($request_data['fn']);
    unset($request_data['id']);
    foreach ($request_data as $key => $value) {
      $bank->$key = $value;
      $data[$key] = $value;
    }
    //$bank->insert();
    $result = $db->bank()->insert($data);
    if ($result) {
      //Preparing response
      $response = array();
      $response['code'] = 201;
      $response['message'] = 'Bank has been created!';
      $response['id'] = $result['id'];
      natural_set_message($response['message'], 'success');
      return $response;
    } else {
      $error_message = 'Bank could not be created!';
      natural_set_message($error_message, 'error');
      throw new Luracast\Restler\RestException(500, $error_message);
    }
  }

  /**
  * Method to fecth Bank Record by ID
  *
  * Fech a record for a specific bank
  * by ID
  *
  * @url GET byID/{id}
  * @smart-auto-routing false
  *
  * @access public
  * @throws 404 User not found for requested id
  * @param int $id Bank to be fetched
  * @return mixed
  */
  function byID($id) {
    //If id is null
    if (is_null($id)) {
      $error_message = 'Parameter id is missing or invalid!';
      natural_set_message($error_message, 'error');
      throw new Luracast\Restler\RestException(400, $error_message);
    }
    //Get object by id
    //$this->loadSingle("id='{$id}'");
    $db = DataConnection::readOnly();
    $q = $db->bank[$id];
    //If object not found throw an error
    if(count($q) > 0) {
      $result['code'] = 200;
      foreach($q as $key => $value){
        $result[$key] = $value;
        $this->$key = $value;
      }
      $this->affected 		 = 1;
      return $result;
    }else{
      $error_message = 'Bank not found!';
      natural_set_message($error_message, 'error');
      throw new Luracast\Restler\RestException(404, $error_message);
    }
  }

  /**
  * Method to fecth All Banks
  *
  * Fech all records from the database
  *
  * @url GET fetchAll
  * @smart-auto-routing false
  *
  * @access public
  * @throws 404 Bank not found
  * @return mixed
  */
  function fetchAll() {
    $db = DataConnection::readOnly();
    $q = $db->bank();
    if(count($q) > 0) {
      foreach($q as $id => $q){
        $res[] = $q;
      }
      return $res;
    }else{
      natural_set_message('Bank not found', 'error');
      throw new Luracast\Restler\RestException(404, 'Bank not found');
    }
  }

  /**
  * Method to Update bank information
  *
  * Update bank on database
  *
  * @url PUT update
  * @smart-auto-routing false
  *
  * @access public
  * @return mixed
  */
  function update($request_data) {
    $this->_validate($request_data, "edit");
    $response = array();
    $db = DataConnection::readWrite();
    $id = $request_data['id'];
    $q  = $db->bank[$id];
    unset($request_data['fn']);
    foreach ($request_data as $key => $value) {
      $this->$key = $value;
    }

    if($q){
      if($q->update($request_data)){
        $response['code'] = 200;
        $response['message'] = 'Bank has been updated!';
        natural_set_message($response['message'], 'success');
      }else{
        //Could not update record! maybe the data is the same.
        $response['code'] = 500;
        $response['message'] = 'Could not update Bank at this time!';
        natural_set_message($response['message'], 'error');
        throw new Luracast\Restler\RestException($response['code'], $response['message']);
      }
      return $response;
    }else{
      natural_set_message('Bank not found', 'error');
      throw new Luracast\Restler\RestException(404, 'Bank not found');
    }
  }

  /**
  * Method to delete a bank
  *
  * Delete bank from database
  *
  * @url DELETE delete
  * @smart-auto-routing false
  *
  * @access public
  * @throws 404 Bank not found
  * @return mixed
  */
  function delete($id) {
    $data['id'] = $id;
    $this->_validate($data, "delete");
    $db = DataConnection::readWrite();
    $q = $db->bank[$id];

    $response = array();
    if($q && $q->delete()){
      $response['code'] = 200;
      $response['message'] = 'Bank has been removed!';
      natural_set_message($response['message'], 'success');
      return $response;
    }else{
      $response['code'] = 404;
      $response['message'] = 'Bank not found!';
      natural_set_message($response['message'], 'error');
      throw new Luracast\Restler\RestException($response['code'], $response['message']);
      return $response;
    }
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
    if ($type != "delete") {
      if (!$data['church_id']) {
        $error[] = 'Field church_id is required!';
      }
    }

    //If error exists return or throw exception if the call has been made from the API
    if (!empty($error)) {
      natural_set_message($error[0], 'error');
      if ($from_api) {
        throw new Luracast\Restler\RestException($error_code, $error[0]);
      }
      return $error;
      exit(0);
    }
  }
}
?>
