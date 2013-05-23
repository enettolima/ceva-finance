<?
    require_once('bootstrap.php');
    require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
    require_once(NATURAL_CLASSES_PATH.'forms.class.php');

    $find_company = true;
    if($find_company){
        if(isset($_SESSION['logged'])){
            session_destroy();
        }
        require_once(NATURAL_TEMPLATE_PATH . 'login.php');
    }else{
        header( 'Location: signup.php' ) ;
    }
?>
