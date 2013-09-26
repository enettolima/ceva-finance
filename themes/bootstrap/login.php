<?php
require_once('bootstrap.php');

/*    <script src='".NATURAL_WEB_ROOT."js/jquery-1.3.2.min.js' type='text/javascript'></script>
  <script src='".NATURAL_WEB_ROOT."js/jquery-ui-1.7.1.custom.min.js' type='text/javascript'></script> */
if (!$username) {
    $username = "";
}
if (!$password) {
    $password = "";
}
?>

<!DOCTYPE html>
<html  lang="en">
    <head>
        <link REL="SHORTCUT ICON" HREF="<?php print TEMPLATE ?>img/favicon.ico"> 
        <meta http-equiv="Content-Type" content="text/html" charset=UTF-8">
        <title><?php print TITLE ?></title>
        <link rel="stylesheet" type="text/css" href="<?php print TEMPLATE ?>css/bootstrap.css" media="all">

        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                max-width: 400px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin input[type=\"text\"],
            .form-signin input[type=\"password\"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }

            #login-error-msg
            {
                font-family:arial,helvetica,sans-serif;
                font-weight:normal;
                color: red;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <form class="form-signin" name="loginForm" id="loginForm" method="POST" action="proc_login.php">
                <div class="media">
                    <a href="<?php print NATURAL_DOMAIN ?>" class="pull-left" target="_blank">
                        <img border="0" src="<?php print TEMPLATE ?>img/logo.png" />
                    </a>
                    <div class="media-body">
                        <h2 class="media-heading"><?php print NATURAL_PLATFORM ?></h2>
                    </div>
                </div>
                <p class="text-left">
                    <span id='login-error-msg'>
                        <small><?php print $error_message ?></small>
                    </span>
                </p>
                <input type="text" class="input-block-level" name="username" placeholder="Email address">
                <input type="password" class="input-block-level" name="password" placeholder="Password">
                <label class="checkbox">
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
                <button class="btn btn-large btn-primary" type="submit">Sign in</button>
                <p class="text-right">
                    <small>Powered by <?php print NATURAL_COMPANY ?></small>
                </p>
            </form>
        </div>
    </body>
</html>