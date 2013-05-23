<?
  require_once('bootstrap.php');

/*    <script src='".NATURAL_WEB_ROOT."js/jquery-1.3.2.min.js' type='text/javascript'></script>
<script src='".NATURAL_WEB_ROOT."js/jquery-ui-1.7.1.custom.min.js' type='text/javascript'></script>*/
if(!$username){
	$username = "";
}
if(!$password){
	$password = "";
}
echo "
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<html>
<head>
  <link REL='SHORTCUT ICON' HREF='https://www.natural.net/media/images/favico.png'> 
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <title>Simply 2.0 - ITSP</title>
    <link rel='stylesheet' type='text/css' href='".TEMPLATE."css/login.css' media='all'>
</head>
<body id='natural-body'>

  <form name='loginForm' id='loginForm' method='POST' action='proc_login.php'>
    <div align='center'>
      <div id='hive-loginBox'>
        <div id='hive-loginTable' align='center'><br><br><br>

          <span id='hive-login-header' align='left'><a href='http://www.hivevoicecloud.com' target='_blank'><img border='0' src='".TEMPLATE."images/hvc_logo.png' /></a></span><br><br>
          <span id='hive-login-error-msg'>{$error_message}</span><br><br>
        
          <div style='text-align: center; width: 380px;'>
            <table cellspacing='0' cellpadding='0' border='0' align='center'>
              <tbody>
                <tr>
                  <td class='loginFormTable' align='right'>
                    <table cellspacing='0' cellpadding='2' border='0'>
                      <tbody>
                        <tr valign='top'>
                          <td class='hive-login-label'><label for='u01'>username</label></td>
                          <td class='hive-login-label'><label for='p01'>password</label></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td><input id='username' type='text' maxlength='50' size='15' name='username' value='{$username}'></td>
                          <td><input id='password' type='password' maxlength='50' size='15' name='password' value='{$password}'></td>
                          <td align='center'><input type='submit' value='Login'><br></td>
                        </tr>
                        <tr>
                          <td>&nbsp</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  </tr>
                  <tr>
                    <td align='left'>
                    <div id='hive-loginVersion' align='right'><a href='reset_password.php'>Forgot password?</a></div>
                    <div id='hive-loginVersion' align='right'>Powered by Open Source Mind</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </form>

</body>
</html>";

/*<noscript> 
                <tr> 
                  <td colspan='3'> 
                    <table cellpadding='0' cellspacing='0' border='0'> 
                      <tr valign='top'> 
                        <td><img src='images/error-16x16.gif' width='16' height='16' border='0' alt='' vspace='2'></td> 
                        <td><div class='hive-error-text'>Error: You don't have JavaScript enabled. This tool uses JavaScript and much of it will not work correctly without it enabled. Please turn JavaScript back on and reload this page.</div></td> 
                      </tr> 
                    </table> 
                  </td> 
                </tr> 
                </noscript>*/

?>
