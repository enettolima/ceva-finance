#!/usr/bin/php5 -q
<?php
  require_once('../bootstrap.php');
  try {
      $pdo_dsn = 
      $pdo = new PDO("mysql:host=127.0.0.1", NATURAL_PDO_USER_WRITE, NATURAL_PDO_PASS_WRITE);

      echo "Creating natural_framework database if it doesn't exist....\n";
      $pdo->exec("CREATE DATABASE IF NOT EXISTS `natural_framework`;"); 

      echo "Importing default database stucture and sample data....\n";
      $pdo->exec("USE natural_framework");
      $sql = file_get_contents('../natural_framework.sql');
      $qr = $pdo->exec($sql);
  } catch (PDOException $e) {
        die("DB ERROR: ". $e->getMessage());
  }	
?>
