<?php

class User {
	/**
	 * Method to fetch Authenticated user
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
	  $user = $db->user()
    		->where("username", $username)
				->and("status > ?", 0)
				->limit(1)
				->fetch();

		if(count($user)>0){
			//Authenticating password
			$pwHasher = new Phpass\PasswordHash(8,false);
			$passed = $pwHasher->CheckPassword($password, $user['password']);	

			if($passed){
				$res = array();
				foreach ($user as $field => $value){
					if($field != "password"){
						$res[$field] = $value;
					}
					$this->{$field} = $value ;
				}
				$res['granted'] = true;
				$this->granted  = true;

				return $res;
			}else{
			$this->granted = false;
			throw new Luracast\Restler\RestException(403, 'Unable to authenticate user');	
			}
	  }else{
			$this->granted = false;
			throw new Luracast\Restler\RestException(403, 'Unable to authenticate user');	
	  }
	}
	
	/**
	 * Method to fecth all User Records
	 *
	 * Fech a record for all  Natural users
	 *
	 * @url GET fetchAll
	 * @smart-auto-routing false
	 * 
	 * @access public
	 * @throws 404 User not found for requested user id  
	 * @return mixed 
	 */

	public function fetchAll() {		
		$db = DataConnection::readOnly();
		$users = $db->user();

		if(count($users) > 0) {
			foreach($users as $id => $u){
				//setting response for api calls
				$res[$id]= array( 'id'			 => $u['id'], 
											'file_id'      => $u['file_id'],
										  'first_name'   => $u['first_name'],
											'last_name'    => $u['last_name'],
											'username'     => $u['username'],
											'email'        => $u['email'],
											'access_level' => $u['access_level'],
											'status'       => $u['status'],
											'language'     => $u['preferred_language'],
											'dashboard_1'  => unserialize($u['dashboard_1']),
											'dashboard_2'  => unserialize($u['dashboard_2']));
			}
			return $res;
		}else{
		   throw new Luracast\Restler\RestException(404, 'User not found');
		}
	}	
	

	/**
	 * Method to fecth User Record by database Id
	 *
	 * Fech a record for a specific Natural user
	 * by database Id
	 *
	 * @url GET byId/{userid}
	 * @smart-auto-routing false
	 * 
	 * @access public
	 * @throws 404 User not found for requested user id  
	 * @param string $userid User to be fetched
	 * @return mixed 
	 */

	public function byId($userid) {		
		$db = DataConnection::readOnly();
		$u = $db->user[$userid];
	
		if(count($u) > 0) {
				//setting object properties for in app use
				$this->id 					 = $u['id']; 
				$this->file_id       = $u['file_id'];
				$this->first_name    = $u['first_name'];
				$this->last_name     = $u['last_name'];
				$this->username      = $u['username'];
				$this->email         = $u['email'];
				$this->access_level  = $u['access_level'];
				$this->status        = $u['status'];
				$this->language      = $u['preferred_language'];
				$this->dashboard_1   = unserialize($u['dashboard_1']);
				$this->dashboard_2   = unserialize($u['dashboard_2']);
				$this->affected 		 = 1;

				//setting response for api calls
				$res = array( 'id'					 => $u['id'], 
											'file_id'      => $u['file_id'],
										  'first_name'   => $u['first_name'],
											'last_name'    => $u['last_name'],
											'username'     => $u['username'],
											'email'        => $u['email'],
											'access_level' => $u['access_level'],
											'status'       => $u['status'],
											'language'     => $u['preferred_language'],
											'dashboard_1'  => unserialize($u['dashboard_1']),
											'dashboard_2'  => unserialize($u['dashboard_2']));
			return $res;
		}else{
		   throw new Luracast\Restler\RestException(404, 'User not found');
		}
	}	
	
	/**
	 * Method to fecth User Record by Username
	 *
	 * Fech a record for a specific Natural user
	 * by Username
	 *
	 * @url GET byUsername/{username}
	 * @smart-auto-routing false
	 * 
	 * @access public
	 * @throws 404 User not found for requested username  
	 * @param string $username User to be fetched
	 * @return mixed 
	 */

	public function byUsername($username) {		
		$db = DataConnection::readOnly();
		$u = $db->user()
			->where("username", $username)
			->limit(1)
			->fetch();

		if(count($u) > 0) {
				//setting object properties for in app use
				$this->id 					 = $u['id']; 
				$this->file_id       = $u['file_id'];
				$this->first_name    = $u['first_name'];
				$this->last_name     = $u['last_name'];
				$this->username      = $u['username'];
				$this->email         = $u['email'];
				$this->access_level  = $u['access_level'];
				$this->status        = $u['status'];
				$this->language      = $u['preferred_language'];
				$this->dashboard_1   = unserialize($u['dashboard_1']);
				$this->dashboard_2   = unserialize($u['dashboard_2']);

				//setting response for api calls
				$res = array( 'id'					 => $u['id'], 
											'file_id'      => $u['file_id'],
										  'first_name'   => $u['first_name'],
											'last_name'    => $u['last_name'],
											'username'     => $u['username'],
											'email'        => $u['email'],
											'access_level' => $u['access_level'],
											'status'       => $u['status'],
											'language'     => $u['preferred_language'],
											'dashboard_1'  => unserialize($u['dashboard_1']),
											'dashboard_2'  => unserialize($u['dashboard_2']));
			return $res;
		}else{
		   throw new Luracast\Restler\RestException(404, 'User not found');
		}
	}	
	
	/**
	* @smart-auto-routing false
	* @access private
	*/
	public function create($show_password=false, $auto_gen_pass=true, $data = null){
			if($auto_gen_pass){
				$temp_password = parent::dmRandom(true, 6);
			}else{
				$temp_password = $this->password;
			}

			$hasher = new Phpass\PasswordHash(8,false);
			$hashed_pass = $hasher->HashPassword($temp_password);

			
			$db = DataConnection::readWrite();
			$u = $db->user();

			if($data == null) {
				$data = array(  'file_id'      => $this->file_id,
											  'first_name'   => $this->first_name,
												'last_name'    => $this->last_name,
												'username'     => $this->username,
												'email'        => $this->email,
												'access_level' => $this->access_level,
												'status'       => $this->status,
												'language'     => $this->preferred_language,
												'dashboard_1'  => serialize($this->dashboard_1),
												'dashboard_2'  => serialize($this->dashboard_2));
			}else{
				$data['dashboard_1']  = serialize($data['dashboard_1']);
				$data['dashboard_2']  = serialize($data['dashboard_2']);
			}

			if(!isset($data['status'])){
					$data['status'] = 1;
			}

			if(!isset($data['language'])){
					$data['language'] = 'en';
			}

			$data['password'] = $hashed_password;

			$affected = $u->insert($data);

			foreach($data as $key => $value){
				$this->{$key} = $value;
			}

			$this->id = $u->insert_id();
			if($show_password){
				$this->temp_password = $temp_password;
			}
			return $affected;
    }
	
	/**
	* @smart-auto-routing false
	* @access private
	*/
	public function update($upd_rule){
			$NATURAL_key = NATURAL_MAGIC_KEY;

			$db = DataConnection::readWrite();
			$u = $db->user()->where($upd_rule);
			if($u){
				$data = array('file_id'      => $this->file_id,
										  'first_name'   => $this->first_name,
											'last_name'    => $this->last_name,
											'username'     => $this->username,
											'email'        => $this->email,
											'access_level' => $this->access_level,
											'status'       => $this->status,
											'language'     => $this->preferred_language,
											'dashboard_1'  => serialize($this->dashboard_1),
											'dashboard_2'  => serialize($this->dashboard_2));
				$affected = $u->update($data);
			}
    }
	
	/**
	* @smart-auto-routing false
	* @access private
	*/
	public function remove($rec_key){
			$db = DataConnection::readWrite();
			$u = $db->user[$rec_key];
			if($u && $u->delete()){
				//print_debug('User deleted succesfuly');
			}
	}
	
	/**
	* @smart-auto-routing false
	* @access private
	*/
	public function updateUserStatus($status,$user_id){
		$db = DataConnection::readWrite();
		$u = $db->user[$user_id];
		if($u){
			$data = array ('status' => $status);
			$affected = $u->update($data);
		}
	}
}
?>
