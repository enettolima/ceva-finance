<?php

require_once('../bootstrap.php');
require_once('SimpleAuth.php');

use Luracast\Restler\Resources;
Resources::$useFormatAsExtension = false;

use Luracast\Restler\Restler;

$r = new Restler(true, true);
$r->addAPIClass('Luracast\\Restler\\Resources'); 
$r->setSupportedFormats('JsonFormat');
$r->addAuthenticationClass('SimpleAuth');
$r->addAPIClass('User');
$r->addAPIClass('Menu');
$r->addAPIClass('Book');
$r->addAPIClass('Module');
$r->addAPIClass('DashboardWidgets');
$r->handle();
?>
