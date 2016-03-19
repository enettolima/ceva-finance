<?php
/**
 * NATURAL - Copyright Open Source Mind, LLC
 * Last Modified: Date: 02-15-2015 19:15:01 -0500
 * @package Natural Framework
 */
session_start();
require_once('../../bootstrap.php');
require_once('report.controller.php');

if (!$_SESSION['logged']) {
  echo "LOGOUT";
  exit(0);
}

/*
 * Sending calls to the view
 * Call functions on {yourmodule}.controller.php
 */
switch ($_GET['fn']) {
  case 'user_list':
    print user_list($_GET['row_id']);
    break;
  case 'user_list_pager':
    print user_list(NULL, $_GET['search'], $_GET['sort'], $_GET['page']);
    break;
  case 'user_list_sort':
    print user_list(NULL, $_GET['search'], $_GET['sort'], 1);
    break;
  case 'user_list_search':
    print user_list(NULL, $_GET['search']);
    break;
  case 'totals_per_month_menu':
  case 'member_contributions_menu':
    print build_filter_form($_GET);
    break;
}
?>
