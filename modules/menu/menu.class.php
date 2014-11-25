<?php
/**
 * All methods in this class are protected
 * @access protected
 */
class Menu Extends DataManager {
    /**
    * @smart-auto-routing false
    * @access private
    */
    function loadSingle($search_str) {
        parent::dmLoadSingle("menu", $search_str);
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function loadList($output, $search_str) {
        parent::dmLoadList("menu", $output, $search_str);
        return $this;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function insert() {
        parent::dmInsert("menu", $this);
        $this->id = $this->dbid;
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function update($upd_rule) {
        parent::dmUpdate("menu", $upd_rule, $this);
    }
    /**
    * @smart-auto-routing false
    * @access private
    */
    function remove($rec_key) {
        parent::dmRemove("menu", $rec_key);
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
	 * Method to fecth Menu list by level
	 *
	 * Fech a list of menus 
	 * by level
	 *
	 * @url GET byLevel/{level}
	 * @url POST byLevel
	 * @smart-auto-routing false
	 * 
	 * @access public
	 * @throws 404 Menu not found for requested level
	 * @param string $level Menu to be fetched
	 * @return mixed 
	 */
  public function byLevel($menu_name = 'main', $level) {
    parent::dmLoadList('menu'  , 'ASSOC', 'status = 1 AND menu_name LIKE "'.$menu_name.'" ORDER BY position');
    if ($this->affected) {
      $links = array();
      foreach ($this->data as $key => $item) {
        // Test permission.
        if ($this->menuPermission($item, $level)) {
          $links[$item['id']] = $item;
        }
      }
      $tree = $this->menuBuildTree($links);
      return $tree;
    }
  }
  
  
  
  /**
	* @smart-auto-routing false
	* @access private
	* Builds a multi dimensional array based on the menu items.
  *
  * @param $links
  *   The links of the menu
  * @param $parent_id
  *   The parent_id (pid) of the menu item
  */
  public function menuBuildTree(array &$links, $parent_id = 0) {
    $branch = array();
    foreach ($links as $link) {
      if ($link['pid'] == $parent_id) {
        $children = $this->menuBuildTree($links, $link['id']);
        if ($children) {
          $link['children'] = $children;
        }
        $branch[$link['id']] = $link;
        //unset($links[$link['id']]);
      }
    }
  
    return $branch;
  }
  
  /**
	* @smart-auto-routing false
	* @access private
	*/
  public function menuPermission($menu_item, $level) {
    $build = TRUE;
    switch ($menu_item['allow']) {
      case 'all':
        $class = '';
        $build = TRUE;
        break;
  
      case 'between':
        $range = explode('and', $menu_item['allow_value']);
        if ($range[0] < $level && $level < $range[1]) {
          $build = TRUE;
        }
        else {
          $build = FALSE;
        }
        break;
  
      case 'equal':
        if ($menu_item['allow_value'] == $level) {
          $build = TRUE;
        }
        else {
          $build = FALSE;
        }
        break;
  
      case 'higher':
        if ($menu_item['allow_value'] < $level) {
          $build = TRUE;
        }
        else {
          $build = FALSE;
        }
        break;
  
      case 'lower':
        if ($menu_item['allow_value'] > $level) {
          $build = TRUE;
        }
        else {
          $build = FALSE;
        }
        break;
  
    }
    return $build;
  }
    /**
    * Method to create a new menu
    *
    * Add a new menu
    *
    * @url POST create
    * @smart-auto-routing false
    * 
    * @access public
    */
    function create($request_data) {
        //Validating data from the API call
        $this->_validate($request_data, "insert");

        $menu = new Menu();
        foreach ($request_data as $key => $value) {
            if ($key != "key") {
                $menu->$key = $value;
            }
        }
        $menu->insert();
        if ($menu->affected > 0) {
            //Preparing response
            $response = array();
            $response['code'] = 201;
            $response['message'] = 'Menu has been created!';
            $response['id'] = $menu->id;
            return $response;
        } else {
            throw new Luracast\Restler\RestException(500, 'Menu could not be created!');
        }
    }

    /**
    * Method to fecth Menu Record by ID
    *
    * Fech a record for a specific menu
    * by ID
    *
    * @url GET byID/{id}
    * @url POST byID
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 User not found for requested id  
    * @param int $id Menu to be fetched
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
            throw new Luracast\Restler\RestException(404, 'Menu not found!');
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
    * Method to fecth All Menus
    *
    * Fech all records from the database
    *
    * @url GET loadAll
    * @url POST loadAll
    * @smart-auto-routing false
    * 
    * @access public
    * @throws 404 Menu not found
    * @return mixed 
    */
    function loadAll() {
        $this->loadList("ASSOC", 'id>0');
        unset($this->restler);
        //parent::dm_load_list(NATURAL_DBNAME . ".menu", "ASSOC", "id>'0'");
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
    * Method to Update menu information
    *
    * Update menu on database
    *
    * @url GET put
    * @url POST put
    * @smart-auto-routing false
    *
    * @access public
    * @throws 404 Menu not found
    * @return mixed 
    */
    function put($request_data) {
        $this->_validate($request_data, "update");
        //Loading the object from the database
        $menu = new Menu();
        $menu->loadSingle("id='" . $request_data['id'] . "'");
        unset($menu->errorcode);
        unset($menu->error);
        unset($menu->dbid);
        unset($menu->data);
        unset($menu->affected);
        //Assigning variables
        foreach ($request_data as $key => $value) {
            if ($key == "key" || $key == "id") {
                //Skipp
            } else {
                $menu->$key = $value;
            }
        }
        //Updating table with the new information
        $menu->update("id='" . $request_data['id'] . "'");
        if ($menu->affected > 0) {
            //Preparing response
            $response = array();
            $response['code'] = 200;
            $response['message'] = 'Menu has been updated!';
            return $response;
        } else {
            //Could not update database table, maybe the record is the same?
            throw new Luracast\Restler\RestException(500, 'Menu could not be updated!');
        }
    }

    /**
    * Method to delete a menu
    *
    * Delete menu from database
    *
    * @url GET delete
    * @url POST delete
    * @smart-auto-routing false
    *
    * @access public
    * @throws 404 Menu not found
    * @return mixed 
    */
    function delete($request_data) {
        $this->_validate($request_data, "delete");
        $menu = new Menu();
        $menu->loadSingle("id='" . $request_data['id'] . "'");
        if ($menu->affected < 1) {
            throw new Luracast\Restler\RestException(404, 'Item not found!');
        }
        $menu->remove("id='" . $request_data['id'] . "'");
        $response = array();
        $response['code'] = 200;
        $response['message'] = 'Menu has been removed!';
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
            if (!$data['position']) {
              $error[] = 'Field position is required!';
            }
						if (!is_numeric($data['position'])) {
              $error[] = 'Field position must be numeric!';
            }
						if (!$data['element_name']) {
              $error[] = 'Field Element Name is required!';
            }
						if (!$data['label']) {
              $error[] = 'Field Label is required!';
            }
						if (!$data['func']) {
              $error[] = 'Field Function is required!';
            }
						$menu = new Menu();
						if($data['fn']=='menu_edit_form_submit'){
								$menu->loadSingle("element_name='".$data['element_name']."' AND id!='".$data['id']."'");		
						}else{
								$menu->loadSingle("element_name='".$data['element_name']."'");
						}
						if($menu->affected>0){
							$error[] = 'Element name already in use, please try with a different element name!';
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
