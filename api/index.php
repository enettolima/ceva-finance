<?php

/*
  Title: Hello World Example.
  Tagline: Let's say hello!.
  Description: Basic hello world example to get started with Restler 2.0.
  Example 1: GET say/hello returns "Hello world!".
  Example 2: GET say/hello/restler2.0 returns "Hello Restler2.0!".
  Example 3: GET say/hello?to=R.Arul%20Kumaran returns "Hello R.Arul Kumaran!".
 */
//require_once '../../restler/restler.php';
require_once('../bootstrap.php');
require_once(NATURAL_CLASSES_PATH . 'datamanager.class.php');
require_once(NATURAL_LIB_PATH . 'restler/restler.php');
//require_once('../modules/hello/Say.php');
require_once('../modules/book/book.model.php');
require_once('SimpleAuth.php');

use Luracast\Restler\Restler;

Defaults::$useUrlBasedVersioning = true;

$r = new Restler();
$r->setAPIVersion(1);
$r->addAPIClass('Say');
$r->addAPIClass('Book');
$r->addAuthenticationClass('SimpleAuth');
$r->handle();
?>