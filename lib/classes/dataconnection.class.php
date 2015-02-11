<?php
/**
 *
 * @access private
 *
 */
class DataConnection {

	public function readOnly(){
			$pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);
			return new NotORM($pdo);
	}

	public function readWrite(){
			$pdo = new PDO(NATURAL_PDO_DSN_WRITE, NATURAL_PDO_USER_WRITE, NATURAL_PDO_PASS_WRITE);
			return new NotORM($pdo);
	}
}
?>
