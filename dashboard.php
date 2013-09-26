<?

session_cache_expire(25);
session_start();
require_once('bootstrap.php');
require_once(NATURAL_CLASSES_PATH . 'datamanager.class.php');
require_once(NATURAL_CLASSES_PATH . 'forms.class.php');
require_once(NATURAL_CLASSES_PATH . 'user.class.php');
require_once('modules/acl/acl.class.php');
require_once('modules/acl/acl.func.php');
require_once('modules/menu_nav/menu_nav.func.php');

require_once(NATURAL_CLASSES_PATH . 'widget.class.php');
require_once(NATURAL_CLASSES_PATH . 'module.class.php');
require_once(NATURAL_CLASSES_PATH . 'log.class.php');
require_once(NATURAL_CLASSES_PATH . 'log_activity.class.php');
require_once(NATURAL_CLASSES_PATH . 'log_error.class.php');
require_once(NATURAL_CLASSES_PATH . 'dashboard_widgets.class.php');
require_once(NATURAL_LIB_PATH . 'util.php');
require_once('modules/dashboard/dashboard_widgets.inc');
require_once('modules/dashboard/dashboard.func.php');

if ($_SESSION['log_username']) {
    if ($_SESSION['log_access_level'] > 41) {
        $show_dashboard = 1;
        $_SESSION['dash_type'] = 1;
        $module = new Module();
        $module->load_single("module='dashboard' LIMIT 1");
        $_SESSION['dialer-version'] = NATURAL_VERSION . ' - r.' . $module->version;
        $content = dashboard_home();
        $menu = bootstrap_menu_constructor($_SESSION['log_access_level'], $show_dashboard);
        //$menu = menu_constructor($_SESSION['log_access_level'], $show_dashboard);
        $loginname = $_SESSION['log_first_name'] . ' ' . $_SESSION['log_last_name'];
        $version = NATURAL_VERSION . ' - r.' . $module->version;
        $loginname = 'User: ' . $loginname;
        $actual_date = date('F jS, Y');
        $_SESSION['log_interface'] = "orange";
        require_once(NATURAL_TEMPLATE_PATH . 'main.php');
    } else {
        header('Location: customer_dash.php');
    }
} else {
    $error_message = 'Invalid Login Information!';
    $password = '';
    $username = $_POST['username'];
    require_once(NATURAL_TEMPLATE_PATH . 'login.php');
}
?>
