<?php

/**
 * @file: messages.php
 * Responsible to handle natural's messages
 */
  session_start();
  $messages = $_SESSION['messages'];
  unset($_SESSION['messages']);
  print json_encode(array('messages' => $messages));
  exit;
?>