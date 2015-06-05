#!/usr/bin/php5 -q
<?php
  require_once('../bootstrap.php');
  try {
      $pdo_dsn =
      $pdo = new PDO(NATURAL_PDO_DSN_WRITE, NATURAL_PDO_USER_WRITE, NATURAL_PDO_PASS_WRITE);

      echo "Delete current ".NATURAL_DBNAME." database....\n";
      $pdo->exec("DROP DATABASE `".NATURAL_DBNAME."`;");

      echo "Creating ".NATURAL_DBNAME." database if it doesn't exist....\n";
      $pdo->exec("CREATE DATABASE IF NOT EXISTS `".NATURAL_DBNAME."`;");

      echo "Importing default database stucture and sample data....\n";
      $pdo->exec("USE ".NATURAL_DBNAME);
      $filename = "../".NATURAL_DBNAME.".sql";
      $sql = file_get_contents($filename);
      $qr = $pdo->exec($sql);
  } catch (PDOException $e) {
        die("DB ERROR: ". $e->getMessage());
  }
?>
