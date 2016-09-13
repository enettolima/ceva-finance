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
$r->addAPIClass('Book');
$r->addAPIClass('Car');
$r->addAPIClass('Church');
$r->addAPIClass('Contribution');
$r->addAPIClass('Member');
$r->addAPIClass('Deposit');
$r->addAPIClass('Withdraw');
$r->addAPIClass('WithdrawType');
$r->addAPIClass('Bank');
$r->addAPIClass('Transaction');
$r->addAPIClass('TransactionType');
$r->addAPIClass('Report');
$r->handle();
?>
