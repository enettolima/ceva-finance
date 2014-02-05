<?php
require_once('bootstrap.php');

/**
  <script src='".NATURAL_WEB_ROOT."js/jquery-1.3.2.min.js' type='text/javascript'></script>
  <script src='".NATURAL_WEB_ROOT."js/jquery-ui-1.7.1.custom.min.js' type='text/javascript'></script>
 */

if (!$username) {
  $username = '';
}
if (!$password) {
  $password = '';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php print TITLE ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="<?php print TEMPLATE ?>img/favicon.ico">
    <!-- Bootstrap -->
    <link href="<?php print TEMPLATE ?>bootstrap/css/bootstrap.min.css" media="all" rel="stylesheet" type="text/css">
    <!-- Theme CSS -->
    <link href="<?php print TEMPLATE ?>css/style.css" media="all" rel="stylesheet" type="text/css">
  </head>
  <body class="page-login">
    <div class="row">
      <?php if (!empty($error_message)) : ?>
      <div class="col-md-4 col-md-offset-4">
        <div id='login-error-msg' class="alert alert-danger">
          <?php print $error_message ?>
        </div>
      </div>
      <?php endif; ?>
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php print NATURAL_PLATFORM ?></h3>
          </div>
          <div class="panel-body">
            <form class="form-signin" role="form" name="loginForm" id="loginForm" method="POST" action="proc_login.php">
              <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Email address">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="remember-me"> Remember me
                </label>
              </div>
              <button class="btn btn-primary btn-sm" type="submit">Sign in</button>
              <small class="pull-right">Powered by <?php print NATURAL_COMPANY ?></small>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>