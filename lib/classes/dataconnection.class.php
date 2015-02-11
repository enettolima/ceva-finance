<?php
/**
 *
 * @access private
 *
 */
class DataConnecion {

	public function readOnly(){
		$pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);
		$db = new NotORM($pdo);
		return $db;
	}
	
	public function readWrite(){
		$pdo = new PDO(NATURAL_PDO_DSN_WRITE, NATURAL_PDO_USER_WRITE, NATURAL_PDO_PASS_WRITE);
		$db = new NotORM($pdo);
		return $db;
	}
}
?>
