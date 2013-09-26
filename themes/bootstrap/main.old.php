<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title><?php print TITLE ?></title>
  <meta name="author" content="Lemuel Santos" />
  <link REL="SHORTCUT ICON" href="<?php print TEMPLATE ?>images/favico.png"> 
  <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/reset.css" />
  <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/jquery-ui-1.8.17.custom.css"  />  
  <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/jquery.timepickr.css"  />  
  <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/system.css" />
  <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/style.css" /> 
  <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/jquery.jqplot.css" />
  <link type="text/css" rel="stylesheet" media="all" href="<?php print TEMPLATE ?>css/style_smartcart.css" />
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

<body class="<?php ($_SESSION['log_interface']) ? print $_SESSION['log_interface'] : print 'green'; ?>">

  <div id="top-header">
    <span><?php print $version.' - '.$actual_date; ?> - <a href="logout.php" title="Logout" class="logout">Logout</a></span>
  </div>

  <!-- header-wrapper -->
  <div id="header-wrapper" style="display: <?php print $closed ?>;">

    <!-- header-inner -->
  <!--  <div id="header-inner" class="clear-block">
      <div id="logo">
      </div> 
      <ul id="header-info">
        <li><?php print $version ?></li>
        <li><?php print $loginname ?></li>
        <?php if (ENABLE_COLOR_CHANGE): ?>
          <li id="style"><span id="color-actual"></span> <span id="style-info">Style: <?php print  $_SESSION['log_interface']; ?></span></li>
          <li id="colors"><a id="blue" class="color-option blue-option" alt="Blue" title="Blue"></a> <a id="gray" class="color-option gray-option" alt="Gray" title="Gray"></a> <a id="green" class="color-option green-option" alt="Green" title="Green"></a> <a id="orange" class="color-option orange-option" alt="Orange" title="Orange"></a> <a id="pink" class="color-option pink-option" alt="Pink" title="Pink"></a></li>
        <?php endif; ?>
      </ul>    
    </div>
-->  
    <!-- end header-inner 
        <li id="logout"><a href="logout.php" title="Logout">Logout</a></li>

-->  
  
  </div>
  <!-- end header -->  
  
  <!-- menu-wrapper -->
  <div id="menu-wrapper">
  
    <!-- menu-inner -->
    <div id="menu-inner" class="clear-block">
       <? print $menu ?> 
    </div>
    <!-- end menu-inner -->  
    
    <div id="menu-logo" class="clear-block">

    </div>
    <!-- end menu-logo -->  

  </div>
  <!-- end menu -->

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
      <img id="logo-footer" src="<?php print TEMPLATE ?>images/logo-footer.png" />
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
  <div id="tooltip-box">
  </div>
  <!-- end tooltip -->

</body>
</html>
