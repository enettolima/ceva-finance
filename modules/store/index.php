<?

/**
 * HIVE - Copyleft Open Source Mind, GP 
 * Last Modified: Date: 07-18-2009 19:15:01 -0500 (Jul-Sat-2009) $ @ Revision: $Rev: 11 $ 
 * @package Hive 
 */
session_start();
require_once('../../bootstrap.php');
require_once('store.func.php');

if (!$_SESSION['logged']) {
    echo "LOGOUT";
    exit(0);
}

$fn = $_GET['fn'];
switch ($fn) {
    case 'load_store_menu':
        print load_store_menu();
        break;
    case 'confirm_order':
        print confirm_order($_GET);
        break;
    case 'back_to_cart':
        print back_to_cart($_GET);
        break;
    case 'process_order':
        print process_order($_GET);
        break;
}
?>
