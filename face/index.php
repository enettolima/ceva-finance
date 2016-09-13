<?php
//require_once( NATURAL_ROOT_PATH . '/vendor/autoload.php');
require_once "/var/www/face/FaceDetector.php";

$detector = new FaceDetector('detection.dat');
$detector->faceDetect('/var/www/face/DSC_0573.jpg');
$detector->toJpeg();
