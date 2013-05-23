<?
/** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 07-18-2009 19:15:01 -0500 (Jul-Sat-2009) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class User Extends DataManager{
		public function load_single($search_str){
			$NATURAL_key = NATURAL_MAGIC_KEY;
      parent::dm_custom_query("SELECT id, partner_id, customer_id, group_id, first_name, last_name, contact_id, username, AES_DECRYPT(password,'{$NATURAL_key}') as password, access_level, status, time_zone, interface, dashboard_1, dashboard_2, preferred_language FROM ".NATURAL_DBNAME.".user WHERE ".$search_str, true);
			$this->dashboard_1 = unserialize($this->dashboard_1);
			$this->dashboard_2 = unserialize($this->dashboard_2);
    }
    public function load_list($output, $search_str, $insert_log = false){
      parent::dm_load_list(NATURAL_DBNAME . ".user", $output, $search_str);
    }
		public function insert($show_password=false, $auto_gen_pass=true){
			if($auto_gen_pass){
				$temp_password = parent::dm_random(true, 6);
			}else{
				$temp_password = $this->password;
			}
			$NATURAL_key = NATURAL_MAGIC_KEY;
			parent::dm_custom_insert("INSERT INTO ".NATURAL_DBNAME.".user SET group_id='{$this->group_id}',
      partner_id='{$this->partner_id}',
      customer_id='{$this->customer_id}',
			first_name='{$this->first_name}',
			last_name='{$this->last_name}', 
			contact_id='{$this->contact_id}', 
			username='{$this->username}', 
			password=AES_ENCRYPT('{$temp_password}','{$NATURAL_key}'), 
			access_level='{$this->access_level}', 
			status='{$this->status}', 
			time_zone='{$this->time_zone}', 
			interface='{$this->interface}',
			preferred_language='{$this->preferred_language}',
      dashboard_1='".serialize($this->dashboard_1)."',
      dashboard_2='".serialize($this->dashboard_2)."'");
      $this->id = $this->dbid;
			if($show_password){
				$this->temp_password = $temp_password;
			}
    }
		public function update($upd_rule){
			$NATURAL_key = NATURAL_MAGIC_KEY;
			parent::dm_custom_update("UPDATE ".NATURAL_DBNAME.".user SET group_id='{$this->group_id}',
			first_name='{$this->first_name}',
			last_name='{$this->last_name}', 
			contact_id='{$this->contact_id}', 
			username='{$this->username}', 
			password=AES_ENCRYPT('{$this->password}','{$NATURAL_key}'), 
			access_level='{$this->access_level}', 
			status='{$this->status}', 
			time_zone='{$this->time_zone}', 
			interface='{$this->interface}',
			preferred_language='{$this->preferred_language}',
      dashboard_1='".serialize($this->dashboard_1)."',
      dashboard_2='".serialize($this->dashboard_2)."' WHERE ".$upd_rule);
      $this->id = $this->dbid;
    }
    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".user", $rec_key);
    }
	  public function random() {
       return parent::dm_random(true, 6);
		}
		public function update_user_status($status,$customerid){
			parent::dm_custom_query("UPDATE ".NATURAL_DBNAME.".user SET status='{$status}' WHERE customer_id='{$customerid}'");	
		}
  }
?>
