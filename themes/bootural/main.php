<?php ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php print TITLE ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link REL="SHORTCUT ICON" href="<?php print TEMPLATE ?>img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="<?php print TEMPLATE ?>assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- REVIEW THE FOLLOWING ITEMS -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php print TEMPLATE ?>assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php print TEMPLATE ?>assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php print TEMPLATE ?>assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php print TEMPLATE ?>assets/ico/apple-touch-icon-57-precomposed.png">
    <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/system.css" />
    <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/jquery-ui-1.8.17.custom.css"  />
    <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/jquery.timepickr.css"  />
    <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/jquery.jqplot.css" />
    <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/style_smartcart.css" />
    <link rel="stylesheet" type="text/css" href="<?php print TEMPLATE ?>css/bootstrap.css" media="all">

    <!-- Bootstrap -->
    <link href="<?php print TEMPLATE ?>bootstrap/css/bootstrap.min.css" media="all" rel="stylesheet" type="text/css">
    <!-- Theme CSS -->
    <link href="<?php print TEMPLATE ?>css/style.css" media="all" rel="stylesheet" type="text/css">

    <!-- REVIEW THE FOLLOWING ITEMS -->
    <!--[if IE]><script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/excanvas.js"></script><![endif]-->
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jquery-1.6.3.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jquery.history.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jquery-ui-1.7.2.custom.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jquery.timepickr.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jquery.json.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/stickyfloat.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/raphael.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/g.raphael.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/g.pie.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/g.bar.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/ajaxupload.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/controller.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jquery.timers-1.2.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/SmartCart.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jqplot.dateAxisRenderer.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jqplot.barRenderer.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jqplot.categoryAxisRenderer.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jqplot.pointLabels.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jqplot.highlighter.min.js"></script>
    <script type="text/javascript" src="<?php print NATURAL_WEB_ROOT ?>lib/js/jqplot.cursor.min.js"></script>
  </head>

  <body  class="page-main <?php ($_SESSION['log_interface']) ? print $_SESSION['log_interface']  : print 'green'; ?>">

    <header id="header" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php print $version . ' - ' . $actual_date; ?></a>
        </div>
        <div class="navbar-collapse collapse navbar-right">
          <ul class="nav navbar-nav">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="logout.php" title="Logout" class="logout">Logout</a></li>
          </ul>
        </div>
      </div>
    </header>


    <div id="account-header">
      <span id="account-topic"><?php print $account_topic; ?></span>
      <span id="back-link"><?php print $back_link; ?> </span>
    </div>

    <!-- content-wrapper -->
    <div id="content-wrapper">
      <!-- content-inner -->
      <div id="content-inner" class="clear-block">
        <div id="menu-hide-button" class="<?php print $button ?>"></div>
        <div id="status-message"></div>
        <!-- content -->
        <div id='content'>
          <?php print $content; ?>
        </div>
        <!-- end content -->
      </div>
      <!-- end content-inner -->
    </div>
    <!-- end content -->


    <!-- footer-wrapper -->
    <div id="footer-wrapper">
      <!-- footer-inner -->
      <div id="footer-inner" class="clear-block">
        <img id="logo-footer" src="<?php print TEMPLATE ?>img/logo-footer.png" />
      </div>
      <!-- end footer-inner -->
    </div>
    <!-- end footer -->

    <!-- loading -->
    <div id="loading">
      Loading
    </div>
    <!-- end loading -->

    <!-- tooltip -->
    <div id="tooltip-box"></div>
    <!-- end tooltip -->

    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php print TEMPLATE ?>js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="<?php print TEMPLATE ?>bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
