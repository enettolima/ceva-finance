<?php

class User Extends DataManager{
	/**
	 * Method to fecth Authenticate user
	 *
	 * Fech a record for a specific authenticated user
	 * by Username and password
	 *
	 * @url GET authenticate/{username}/{password}
	 * @url POST authenticate
	 * @smart-auto-routing false
	 * 
	 * @access public
	 * @throws 403 User cannot be authenticated 
	 * @param string $username User to be fetched
	 * @param string $password Authentication Password
	 * @return mixed 
	 */

	public function authenticate($username,$password) {
	  $db = DataConnection::readOnly();
	  $u = $db->user()
    		->select("*")
    		->where("username", $username)
				->and("password=AES_ENCRYPT( ? , ? )", $password, NATURAL_MAGIC_KEY )
				->and("status > ?", 0)
    		->limit(1)
				->fetch();

	  if(count($u)>0){
	  	foreach ($u as $field => $value){
	  		$this->$field = $value ;
  	  }
	
	  $this->granted = true;

	   $res = array ( 'accessGranted' => true,
			  'firstName' =>$u[first_name],
			  'lastName' => $u[last_name],
			  'status' => $u[status]
	  );
	  return $res;
	  }else{
		$this->granted = false;
		throw new Luracast\Restler\RestException(403, 'Unable to authenticate user');	
	  }

	}


	/**
	 * Method to fecth User Record by Username
	 *
	 * Fech a record for a specific Natural user
	 * by Username
	 *
	 * @url GET byUsername/{username}
	 * @url POST byUsername
	 * @smart-auto-routing false
	 * 
	 * @access public
	 * @throws 404 User not found for requested username  
	 * @param string $username User to be fetched
	 * @return mixed 
	 */

	public function byUsername($username) {		
	  parent::dmLoadSingle("user","username='{$username}'");
		if($this->affected > 0) {
				$res = array (	'id' => $this->id,
					'firstName' => $this->first_name,
					'lastName' => $this->last_name,
					'status' => $this->status
				);

			return $res;
		}else{
		   throw new Luracast\Restler\RestException(404, 'User not found');
		}
	}	
	
	/**
	* @smart-auto-routing false
	* @access private
	*/
	public function loadSingle($search_str){
		parent::dmLoadSingle("user", $search_str);
		$this->dashboard_1 = unserialize($this->dashboard_1);
		$this->dashboard_2 = unserialize($this->dashboard_2);
    	}
	
	/**
	* @smart-auto-routing false
	* @access private
	*/
	public function loadList($output, $search_str, $insert_log = false){
		parent::dmLoadList("user", $output, $search_str);
	}
	
	/**
	* @smart-auto-routing false
	* @access private
	*/
	public function insert($show_password=false, $auto_gen_pass=true){
			if($auto_gen_pass){
				$temp_password = parent::dmRandom(true, 6);
			}else{
				$temp_password = $this->password;
			}
			$NATURAL_key = NATURAL_MAGIC_KEY;
			parent::dmCustomInsert("INSERT INTO ".NATURAL_DBNAME.".user SET file_id='{$this->file_id}',
			first_name='{$this->first_name}',
			last_name='{$this->last_name}',
			username='{$this->username}',
			password=AES_ENCRYPT('{$temp_password}','{$NATURAL_key}'),
			email='{$this->email}',
			access_level='{$this->access_level}',
			status='{$this->status}',
			language='{$this->preferred_language}',
      dashboard_1='".serialize($this->dashboard_1)."',
      dashboard_2='".serialize($this->dashboard_2)."'");
      $this->id = $this->dbid;
			if($show_password){
				$this->temp_password = $temp_password;
			}
    }
	
	/**
	* @smart-auto-routing false
	* @access private
	*/
	public function update($upd_rule){
			$NATURAL_key = NATURAL_MAGIC_KEY;
			parent::dmCustomUpdate("UPDATE ".NATURAL_DBNAME.".user SET file_id='{$this->file_id}',
			first_name='{$this->first_name}',
			last_name='{$this->last_name}',
			username='{$this->username}',
			password=AES_ENCRYPT('{$this->password}','{$NATURAL_key}'),
			email='{$this->email}',
			access_level='{$this->access_level}',
			status='{$this->status}',
			language='{$this->preferred_language}',
      dashboard_1='".serialize($this->dashboard_1)."',
      dashboard_2='".serialize($this->dashboard_2)."' WHERE ".$upd_rule);
      //$this->id = $this->dbid;
    }
	
	/**
	* @smart-auto-routing false
	* @access private
	*/
	public function remove($rec_key){
		parent::dmRemove("user", $rec_key);
	}
	
	/**
	* @smart-auto-routing false
	* @access private
	*/
	public function random() {
		return parent::dmRandom(true, 6);
	}
	
	/**
	* @smart-auto-routing false
	* @access private
	*/
	public function updateUserStatus($status,$customerid){
		parent::dmCustomQuery("UPDATE ".NATURAL_DBNAME.".user SET status='{$status}' WHERE customer_id='{$customerid}'");
	}
}
?>
