<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 05-06-2014 17:23:02 -0500 $ @ Revision: $Rev: 11 $
 * @package Natural Framework */

/**
 *
 * @access private
 *
 */
class DataManager {
	public $affected;
	public $errorcode = 0;
	public $error = "";
	public $data;
	public $dbid;

	/**
	 *
	 * @access private
	 *
	 */
	public function dmLoadSingle($table, $search_str) {
		$db = DataConnection::readOnly();

		$q = $db->{$table}()->where($search_str)->limit(1);

		$this->affected = count($q);

		if (!$this->affected) {
			$this->errorcode = RECORD_NOT_FOUND_CODE;
			$this->error = RECORD_NOT_FOUND_MESG;

			return;
		}

		foreach ($q as $id => $r) {
			foreach ($r as $field => $value) {
				$this->{$field} = $value;
			}
		}
	}

	/**
	 *
	 * @access private
	 *
	 */
	public function dmLoadList($table, $output, $search_str, $count = false,
		$count_query = null) {
		$db = DataConnection::readOnly();

		//Total records count used in pagination
		$this->total_records = $db->{$table}()->count('*');

		$q = $db->{$table}()
		        ->where($search_str);

		$this->affected = count($q);

		if (!$this->affected) {
			$this->errorcode = RECORD_NOT_FOUND_CODE;
			$this->error = RECORD_NOT_FOUND_MESG;

			return;
		}

		switch (strtoupper($output)) {
			case "ASSOC":
				foreach ($q as $id => $r) {
					foreach ($r as $field => $value) {
						$this->data[$id][$field] = $value;
					}
				}
				break;
			case "NUM":
				foreach ($q as $id => $r) {
					$i = 0;
					foreach ($r as $field => $value) {
						$this->data[$id][$i] = $value;
						$i++;
					}
				}
				break;
		}
	}

	/**
	 *
	 * @access private
	 *
	 */
	public function dmLoadCustomList($query, $output, $count = false, $count_query
		= null) {

		$db = DataConnection::readOnly();

		//Total records count used in pagination
		$this->total_records = $db->{$table}()->count('*');

		$q = $db->{$table}()
		        ->where($query);

		$this->affected = count($q);

		if (!$this->affected) {
			$this->errorcode = RECORD_NOT_FOUND_CODE;
			$this->error = RECORD_NOT_FOUND_MESG;

			return;
		}

		switch (strtoupper($output)) {
			case "ASSOC":
				foreach ($q as $id => $r) {
					foreach ($r as $field => $value) {
						$this->data[$id][$field] = $value;
					}
				}
				break;
			case "NUM":
				foreach ($q as $id => $r) {
					$i = 0;
					foreach ($r as $field => $value) {
						$this->data[$id][$i] = $value;
						$i++;
					}
				}
				break;
		}

	}

	/**
	 *
	 * @access private
	 *
	 */
	public function dmInsert($table, $fields) {
	
			/*Loop through the fields to remove object items from field*/
			foreach ($fields as $key => $value) {
				if (($key == 'dblink' || $key == 'affected' || $key == 'errorcode' || $key
					== 'error' || $key == 'data' || $key == 'dbid')) {
					unset($fields[$key]);
				}
			}

		$db = DataConnection::readWrite();

		$q = $db->{$table}()->insert($fields);

		$this->affected = count($q);

		if (!$this->affected) {
			$this->errorcode = MYSQL_INSERT_ERROR_CODE;
			$this->error = MYSQL_INSERT_ERROR_MESG ;
			return;
		}else{
			$this->dbid = $db->{$table}()->insert_id();
		}
	}

	/**
	 *
	 * @access private
	 *
	 */
	public function dmRemove($table, $record_key) {
	
		$db = DataConnection::readWrite();

		$q = $db->{$table}()->where($record_key)->delete();

		$this->affected = count($q);

		if (!$this->affected) {
			$this->errorcode = MYSQL_DELETE_ERROR_CODE;
			$this->error = MYSQL_DELETE_ERROR_MESG;
		}
	}

	/**
	 *
	 * @access private
	 *
	 */
	public function dmUpdate($table, $update_rule, $fields) {
		/*Loop through the fields to remove object items from field*/
			foreach ($fields as $key => $value) {
				if (($key == 'dblink' || $key == 'affected' || $key == 'errorcode' || $key
					== 'error' || $key == 'data' || $key == 'dbid' || $key == 'id' || $key == 'function' || $key == 'fn')) {
					unset($fields[$key]);
				}
			}

		$db = DataConnection::readWrite();

		$q = $db->{$table}()->where($update_rule)->update($fields);

		$this->affected = count($q);

		if (!$this->affected) {
			$this->errorcode = MYSQL_UPDATE_ERROR_CODE;
			$this->error = MYSQL_UPDATE_ERROR_MESG;
			return;
		}else{
			$this->dbid = $db->{$table}()->insert_id();
		}
	}

	/**
	 *
	 * @access private
	 *
	 */
	public function dmRandom($alpha = false, $length = 6) {
		if ($alpha) {
			$random_key = substr(md5(rand() . rand()), 0, $length);
		} else {
			$random_key = substr(mt_rand(), 0, $length);
		}

		return $random_key;
	}

	/**
	 *
	 * @access private
	 *
	 */
	public function dmCheckModule($module) {

		$db = DataConnection::readOnly();

		$table = MODULES_TABLE;

		$q = $db->{$table}()->where('module', $module)->limit(1);

		$this->affected = count($q);

		if (!$this->affected) {
			$this->errorcode = RECORD_NOT_FOUND_CODE;
			$this->error =
			RECORD_NOT_FOUND_MESG;

			return;
		} elseif ($this->affected > 1) {
			$this->errorcode = QUERY_RETURNED_MULTIPLE_RECORDS_CODE;
			$this->error =
			QUERY_RETURNED_MULTIPLE_RECORDS_MESG;

			return;
		}

		foreach ($q as $id => $r) {
			foreach ($r as $field => $value) {
				$this->{$field} = $value;
			}
		}
	}


	/** 
	 * Should we translate the methods below
	 * to use not orm or should we just do
	 * away with them and use not orm directly ?
	 */ 

	/**
	 *
	 * @access private
	 *
	 */
	public function dmCustomQuery($query, $return_object = false,
		$return_id = false) {
		//Use configuration from bootstrap
		$dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER,
			NATURAL_DBPASS);

		mysql_select_db(NATURAL_DBNAME);

		$query_result = mysql_query($query, $dblink);

		if (!$query_result) {
			$this->message = 'Invalid query: ' . mysql_error() .
			"\n";
			$this->message .= 'Whole query: ' . $query;
		} else {
			$this->affected = mysql_affected_rows();
			if ($this->affected > 0 && $return_object == true) {
				$cols = mysql_num_fields($query_result);
				while ($row = mysql_fetch_array($query_result)) {
					for ($i = 0; $i <= $cols - 1; $i++) {
						$field =
						mysql_field_name($query_result, $i);
						$this->{$field} = $row[$i];
					}
				}
			}
		}
		if ($return_id) {
			$this->dbid = mysql_insert_id($dblink);
		}
		mysql_close($dblink);
		$dblink = null;
	}

	/**
	 *
	 * @access private
	 *
	 */
	public function dmCustomInsert($query) {

		//Use configuration from bootstrap
		$dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER,
			NATURAL_DBPASS);

		$query_result = mysql_query($query, $dblink);
		$this->affected =
		mysql_affected_rows();
		if (!$this->affected) {
			$this->errorcode = MYSQL_INSERT_ERROR_CODE;
			$this->error =
			MYSQL_INSERT_ERROR_MESG . " :
      " . (mysql_error($this->dblink) ? mysql_errno() : 0);
		} else {
			$this->dbid = mysql_insert_id($dblink);
		}
		mysql_close($dblink);
		$dblink = null;
	}

	/**
	 *
	 * @access private
	 *
	 */
	public function dmCustomUpdate($query) {
		//Use configuration from bootstrap
		$dblink = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER,
			NATURAL_DBPASS);

		$query_result = mysql_query($query, $dblink);
		$this->affected =
		mysql_affected_rows();
		if (!$this->affected) {
			$this->errorcode = MYSQL_UPDATE_ERROR_CODE;
			$this->error =
			MYSQL_UPDATE_ERROR_MESG;
			//$this->error = MYSQL_UPDATE_ERROR_MESG." :
			//".(mysql_error($this->dblink)?mysql_errno():0);
		} else {
			$this->dbid = mysql_insert_id($dblink);
		}

		mysql_close($dblink);
		$dblink = null;
	}
}
