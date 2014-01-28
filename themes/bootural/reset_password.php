<?
  require_once('bootstrap.php');
  require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
  require_once(NATURAL_CLASSES_PATH.'user.class.php');
  require_once(NATURAL_CLASSES_PATH.'contact.class.php');
  require_once(NATURAL_CLASSES_PATH.'customer.class.php');
  require_once(NATURAL_CLASSES_PATH.'reset_password.class.php');
  require_once(NATURAL_LIB_PATH.'errorcodes.lib.php');

  if($_GET['token']){
    $token = $_GET['token'];
  }else{
    $token = $_POST['token'];
  }
  
  $table = "<tr valign='top'>
    <td class='hive-login-label'><label for='u01'>E-mail *</label></td>
    <td><input id='email' type='text' name='email' value='{$email}'></td>
  </tr>
  <tr>
    <td class='hive-login-label'><label for='u01'>Account Number *</label></td>
    <td><input id='account' type='text' name='account' value='{$account}'></td>
  </tr>
  <tr>
    <td align='right' colspan='2' ><input type='submit' value='Reset'><br></td>
  </tr>";

  if($token){
    $reset = new ResetPassword();
    $reset->load_single("token='{$token}' AND created > DATE_SUB(NOW(), INTERVAL 1 DAY)");  
    if($reset->affected<1){
      $error_message = "This session has been expired. please try again!";
    }else{
      $error_message = "Please enter your new password!";

      if($_POST['password']){
        $new_pass1  = $_POST['password'];
        $new_pass2  = $_POST['password2'];

        if($new_pass1!=$new_pass2){
          $error_message = "The password you have entered does not match, please try again!";
        }else{
          $NATURAL_key   = NATURAL_MAGIC_KEY; 
          $val        = true;
          if(!$new_pass1) {
            $error_message = INVALID_NEW_PASSWORD_MESG;
            $val        = false;
          }
          if(strlen($new_pass1) < 4) {
            $error_message = INVALID_NEW_PASSWORD_LENGTH_MESG;
            $val        = false;
          }
          if($val){
            $user = new User();
            $user->load_single("id='{$reset->user_id}'");
            $user->password = $new_pass1;
            $user->update('id = ' . $reset->user_id);
            if($user->affected>0){
              $error_message = "Your password has been updated!";
              $reset->remove("token='{$token}'");  
              $contact = new Contact();
              $contact->load_single("id='{$user->contact_id}'");
              if($contact->affected>0){
                $to      = $contact->email;
                $headers = 'From: noreply@hivevoicecloud.com' . "\n" .
                     'Reply-To: noreply@hivevoicecloud.com' . "\n" .
                     'X-Mailer: PHP/' . phpversion();
                $subject = "Your password has been reset!";
                $message = "Dear ".$user->first_name." ".$user->last_name.",
This is just to inform that your password has been reset! You can log in to your account using the following:
Username: {$user->username}
Password: {$new_pass1} 

To log in please visit ".NATURAL_DOMAIN." 

Thank you, \n\r

Hive Voice Cloud Team.";
                
                mail($to, $subject, $message, $headers);
              }

              require_once(NATURAL_TEMPLATE_PATH . 'login.php');
              exit(0);
            }else{
              $error_message = "We could not save your password at this time, please try again!";
            }
          }
        }
      }

      $table = "<tr valign='top'>
        <td class='hive-login-label'><label for='u01'>Password *</label></td>
        <td><input id='password' type='password' name='password'></td>
      </tr>
      <tr>
        <td class='hive-login-label'><label for='u01'>Re-enter Password *</label></td>
        <td><input id='password' type='password' name='password2'></td>
      </tr>
      <tr>
        <td align='right' colspan='2' ><input type='submit' value='Save'><input type='hidden' name='token' id='token' value='{$token}'><br></td>
      </tr>";
    }
  }else{
    $email    = $_POST['email'];
    $account  = $_POST['account'];
    $verify   = true;
    if(!$email){
      $email = "";
      $verify   = false;
    }
    if(!$account){
      $account = "";
      $verify   = false;
    }
    if($verify){
      $customer= new Customer();
      $customer->load_single("id='{$account}'");
      if($customer->affected<1){
        $error_message = "Invalid E-mail or Account Number, please verify your account information and try it again or contact us at support@hivevoicecloud.com.";      
      }
      $user = new User();
      $user->load_list("ASSOC", "customer_id='{$account}'");
      if($user->affected>0){
        for($i=0; $i<$user->affected; $i++){
          $contact = new Contact(); 
          $contact->load_single("id='{$user->data[$i]['contact_id']}' AND email='{$email}' LIMIT 1");
          if($contact->affected>0){
            $token              = md5(date("YmdHis"));
            $reset              = new ResetPassword();
            $reset->customer_id = $account;
            $reset->user_id     = $user->data[$i]['id'];
            $reset->token       = $token;
            $reset->insert();
            
            $to      = $contact->email;
            $headers = 'From: noreply@hivevoicecloud.com' . "\n" .
                 'Reply-To: noreply@hivevoicecloud.com' . "\n" .
                 'X-Mailer: PHP/' . phpversion();
            $subject = "Hive Voice Cloud Password Reset Request!";
            $message = "Dear ".$user->data[$i]['first_name']." ".$user->data[$i]['last_name'].",
You have requested to reset your password. To continue the process use the below link.
If you did not request this password change, please contact us at support@hivevoicecloud.com.
Please note, the link will expire 24 hours after the reset password was requested


".NATURAL_DOMAIN."/reset_password.php?token=".$token."


Thank you, \n\r

Hive Voice Cloud Team.";
                
            mail($to, $subject, $message, $headers);
            $error_message = "You will receive an email with directions on how to reset your password!";      
          }else{
            $error_message = "Invalid E-mail or Account Number, please verify your account information and try it again or contact us at support@hivevoicecloud.com.";      
          }
        }
      }else{
        $error_message = "Invalid E-mail or Account Number, please verify your account information and try it again or contact us at support@hivevoicecloud.com.";      
      }
    }

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

  <form name='loginForm' id='loginForm' method='POST' action='reset_password.php'>
    <div align='center'>
      <div id='hive-loginBox'>
        <div id='hive-loginTable' align='center'><br><br><br>

          <span id='hive-login-header' align='left'><a href='http://www.hivevoicecloud.com' target='_blank'><img src='".TEMPLATE."images/hvc_logo.png' /></a></span><br><br>
          <span id='hive-login-error-msg'>{$error_message}</span><br><br>
        
          <div style='text-align: center; width: 380px;'>
            <table cellspacing='0' cellpadding='0' border='0' align='center'>
              <tbody>
                <tr>
                  <td class='loginFormTable' align='right'>
                    <table cellspacing='0' cellpadding='2' border='0'>
                    <tbody>
                      {$table}
                    </tbody>
                    </table>
                  </td>
                  </tr>
                  <tr>
                    <td align='left'>
                    <div id='hive-loginVersion' align='right'><a href='./'>Sign in</a></div>
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

?>
