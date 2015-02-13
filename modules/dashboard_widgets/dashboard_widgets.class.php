<?php
/**
 * All methods in this class are protected
 * access protected
 */
class DashboardWidgets {

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
    public function create($request_data) {
        //Validating data from the API call
        $this->_validate($request_data, "insert");
				$data = array();
        foreach ($request_data as $key => $value) {
            if ($key != "key" && $key != "id") {
                $data[$key] = $value;
            }
				}

				$db = DataConnection::readWrite();
				$affected = $db->dashboard_widgets()->insert($data);
        if ($affected) {
            //Preparing response
            $response = array();
            $response['message'] = 'Dashboard Widget have been created!';
            $response['id'] = $db->dashboard_widgets()->insert_id();
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
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 User not found for requested id  
    * @param int $id DashboardWidgets to be fetched
    * @return mixed 
    */
    public function byID($id) {
        //If id is null
        if (is_null($id)) {
            throw new Luracast\Restler\RestException(400, 'Parameter id is missing or invalid!');
        }
        
				//Get object by id
				$db = DataConnection::readOnly();
				$widget = $db->dashboard_widgets[$id];

        if (!$widget) {
            throw new Luracast\Restler\RestException(404, 'DashboardWidgets not found!');
        }
        
				$res = array();
				foreach ($widget as $key => $value){
					$res[$key] = $value ;
					$this->{$key} = $value;
				}
        return $res;
    }

    /**
    * Method to fecth All DashboardWidgetss
    *
    * Fech all records from the database
    *
    * @url GET loadAll
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 DashboardWidgets not found
    * @return mixed 
    */
    public function loadAll() {
				$res = array();
				
				$db = DataConnection::readOnly();
				$widgets = $db->dashboard_widgets();
        if (count($widgets) < 1) {
            throw new Luracast\Restler\RestException(404, 'No items found!');
        }

				$res = array_map('iterator_to_array', iterator_to_array($widgets));

        return $res;
    }

    /**
    * Method to Update dashboard_widgets information
    *
    * Update dashboard_widgets on database
    *
    * @url PUT update
    * @smart-auto-routing false
    *
    * @access public
    * @throws 404 DashboardWidgets not found
    * @return mixed 
    */
    function update($request_data) {
        $this->_validate($request_data, "update");

				$id = $request_data['id'];

				$db = DataConnection::readWrite();
				$widget = $db->dashboard_widgets[$id];

				if($widget){
					unset($request_data['key']);
					unset($request_data['id']);

					$widget->update($request_data);
					$widget = $db->dashboard_widgets[$id];
					foreach ($widget as  $key => $value ){
							$res[$key] = $value;
					}
					return $res;
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
    * @url DELETE delete
    * @smart-auto-routing false
    *
		* @access public
		* @param $id Id of dashboard widget to be deleted
    * @throws 404 DashboardWidgets not found
    * @return mixed 
    */
    function delete($id) {
        $this->_validate($id, "delete");

				$db = DataConnection::readWrite();
				$widget = $db->dashboard_widgets[$id];
				$affected = $widget->delete();

        if ($affected > 0) {
        		$response['message'] = 'DashboardWidgets has been removed!';
       			 return $response;
				}else{
            throw new Luracast\Restler\RestException(404, 'Item not found!');
				}
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function _validate($data, $type, $from_api = true) {
        if ($type == "update") {
            if (!$data['id']) {
              throw new Luracast\Restler\RestException(404, 'Parameter ID is required!');
            }
        }
        /*
         * check if field is empty
         * Add more fields as needed
         */

        if ($type == "delete") {
            if ($data == null && $data < 0) {
              throw new Luracast\Restler\RestException(404, 'Parameter ID is required!');
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
