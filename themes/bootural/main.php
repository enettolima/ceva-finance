<?php ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php print TITLE ?></title>
    <meta charset="utf-8"
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link REL="SHORTCUT ICON" href="<?php print TEMPLATE ?>img/favicon.ico">

    <!-- Bootstrap v3.0.3 (http://getbootstrap.com) -->
    <link href="<?php print TEMPLATE ?>css/bootstrap.min.css" media="all" rel="stylesheet" type="text/css">
    <!-- Font Awesome -->
    <link href="<?php print TEMPLATE ?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="<?php print TEMPLATE ?>css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Main CSS -->
    <link href="<?php print TEMPLATE ?>css/bootural-main.css" media="all" rel="stylesheet" type="text/css">

  </head>

  <body class="skin-gray">

    <header class="header">
      <span class="logo">
        <?php print TITLE ?>
      </span>
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Button to collapse navigation -->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
          <i class="fa fa-bars"></i></a> </span>
        </a>
        <!-- Top right navigation -->
        <div class="navbar-right">
          <ul class="nav navbar-nav">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="logout.php" title="Logout" class="logout">Logout</a></li>
          </ul>
        </div>
      </div>
    </header>

    <div class="wrapper row-offcanvas row-offcanvas-left">
      <!-- Left side -->
      <aside class="left-side sidebar-offcanvas">
        <!-- Sidebar -->
        <section class="sidebar">
          <!-- Sidbear menu -->
          <ul class="sidebar-menu">
            <li class="active">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-th"></i> <span>Widgets</span> <small class="badge pull-right bg-green">new</small>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart-o"></i>
                <span>Charts</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-angle-double-right"></i> Morris</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i> Flot</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>UI Elements</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-angle-double-right"></i> General</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i> Icons</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i> Buttons</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i> Sliders</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i> Timeline</a></li>
              </ul>
            </li>
          </ul>
          <?php print $menu ?>
        </section>
      </aside>
      <!-- Right side -->
      <aside class="right-side">
        <!-- Content header  -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          Main Content
        </section>
      </aside>
    </div>


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
          <?php // print $content; ?>
        </div>
        <!-- end content -->
      </div>
      <!-- end content-inner -->
    </div>
    <!-- end content -->



    <!-- loading
    <div id="loading">
      Loading
    </div>
     end loading -->

    <!-- tooltip -->
    <div id="tooltip-box"></div>
    <!-- end tooltip -->

    <!-- Placed at the end of the document so the pages load faster -->
    <!-- jQuery 2.0.2 -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- jQuery UI 1.10.3 -->
    <script src="<?php print TEMPLATE ?>js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <!-- Bootstrap v3.0.3 (http://getbootstrap.com) -->
    <script src="<?php print TEMPLATE ?>js/bootstrap.min.js" type="text/javascript"></script>

    <!-- Bootural Main -->
    <script src="<?php print TEMPLATE ?>js/bootural-main.js" type="text/javascript"></script>

  </body>
</html>
