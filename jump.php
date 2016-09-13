<?php
require_once('bootstrap.php');

session_start();
$_SESSION['log_church_id']=$_GET['church_id'];

header("Location: dashboard_church.php");

?>
