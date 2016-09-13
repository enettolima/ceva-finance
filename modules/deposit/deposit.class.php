<?php
/**
 * All methods in this class are protected
 * @access protected
 */
class Deposit {
  /**
  * Method to create a new deposit
  *
  * Add a new deposit
  *
  * @url POST create
  * @smart-auto-routing false
  *
  * @access public
  */
  function create($request_data) {
    //Validating data from the API call
    $this->_validate($request_data, "create");
    $deposit = new Deposit();
    $db = DataConnection::readWrite();
    //$u = $db->user();
    $data = array();
    unset($request_data['fn']);
    unset($request_data['id']);
    foreach ($request_data as $key => $value) {
      $deposit->$key = $value;
      $data[$key] = $value;
    }
    //$deposit->insert();
    $result = $db->deposit()->insert($data);
    if ($result) {
      //Preparing response
      $response = array();
      $response['code'] = 201;
      $response['message'] = 'Deposit has been created!';
      $response['id'] = $result['id'];
      natural_set_message($response['message'], 'success');
      return $response;
    } else {
      $error_message = 'Deposit could not be created!';
      natural_set_message($error_message, 'error');
      throw new Luracast\Restler\RestException(500, $error_message);
    }
  }

  /**
  * Method to fecth Deposit Record by ID
  *
  * Fech a record for a specific deposit
  * by ID
  *
  * @url GET byID/{id}
  * @smart-auto-routing false
  *
  * @access public
  * @throws 404 User not found for requested id
  * @param int $id Deposit to be fetched
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
    $q = $db->deposit[$id];
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
      $error_message = 'Deposit not found!';
      natural_set_message($error_message, 'error');
      throw new Luracast\Restler\RestException(404, $error_message);
    }
  }

  /**
  * Method to fecth All Deposits
  *
  * Fech all records from the database
  *
  * @url GET fetchAll
  * @smart-auto-routing false
  *
  * @access public
  * @throws 404 Deposit not found
  * @return mixed
  */
  function fetchAll() {
    $db = DataConnection::readOnly();
    $q = $db->deposit();
    if(count($q) > 0) {
      foreach($q as $id => $q){
        $res[] = $q;
      }
      return $res;
    }else{
      natural_set_message('Deposit not found', 'error');
      throw new Luracast\Restler\RestException(404, 'Deposit not found');
    }
  }

  /**
  * Method to Update deposit information
  *
  * Update deposit on database
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
    $q  = $db->deposit[$id];
    unset($request_data['fn']);
    foreach ($request_data as $key => $value) {
      $this->$key = $value;
    }

    if($q){
      if($q->update($request_data)){
        $response['code'] = 200;
        $response['message'] = 'Deposit has been updated!';
        natural_set_message($response['message'], 'success');
      }else{
        //Could not update record! maybe the data is the same.
        $response['code'] = 500;
        $response['message'] = 'Could not update Deposit at this time!';
        natural_set_message($response['message'], 'error');
        throw new Luracast\Restler\RestException($response['code'], $response['message']);
      }
      return $response;
    }else{
      natural_set_message('Deposit not found', 'error');
      throw new Luracast\Restler\RestException(404, 'Deposit not found');
    }
  }

  /**
  * Method to delete a deposit
  *
  * Delete deposit from database
  *
  * @url DELETE delete
  * @smart-auto-routing false
  *
  * @access public
  * @throws 404 Deposit not found
  * @return mixed
  */
  function delete($id) {
    $data['id'] = $id;
    $this->_validate($data, "delete");
    $db = DataConnection::readWrite();
    $q = $db->deposit[$id];

    $response = array();
    if($q && $q->delete()){
      $response['code'] = 200;
      $response['message'] = 'Deposit has been removed!';
      natural_set_message($response['message'], 'success');
      return $response;
    }else{
      $response['code'] = 404;
      $response['message'] = 'Deposit not found!';
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
