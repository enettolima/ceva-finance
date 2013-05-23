<?php
  require_once('bootstrap.php');
  require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
  require_once(NATURAL_CLASSES_PATH.'forms.class.php');
  require_once(NATURAL_LIB_PATH.'util.php');
  require_once(NATURAL_LIB_PATH.'spyc.php');
  require_once(NATURAL_CLASSES_PATH.'user.class.php');
  require_once(NATURAL_CLASSES_PATH.'log_api.class.php');
  require_once(NATURAL_CLASSES_PATH.'appliance.class.php');
  require_once(NATURAL_CLASSES_PATH.'version.class.php');
  require_once(NATURAL_CLASSES_PATH.'version_log.class.php');
  require_once(NATURAL_CLASSES_PATH.'developer_user.class.php');
  require_once(NATURAL_CLASSES_PATH.'xmlConversor.class.php');
  require_once(NATURAL_CLASSES_PATH.'location.class.php');
  require_once(NATURAL_CLASSES_PATH.'customer.class.php');
  require_once(NATURAL_CLASSES_PATH.'appliance.class.php');
  require_once('modules/integration/integration.func.php');
  require_once('modules/integration/xml_response.php');
  
switch($_GET['request_type']){
	case "AuthDeveloper":
		authenticate_developer($_GET);
		break;
	case "getLastVersion":
		getLastVersion();
		break;
	case "updateVersion":
		updateVersion($_GET);
		break;
	case "checkBenStatus":
		checkBenStatus();
		break;

	case "checkHENStatus":
		checkHENStatus($_GET);
		break;
    /*
     *Dialer Functions
     */
	case "getLastDialerVersion":
		getLastDialerVersion($_GET);
		break;
	case "updateDialerVersion":
		updateDialerVersion($_GET);
		break;
	case "getDialerLicense":
		getDialerLicense($_GET);
		break;
	case "registerLicense":
		registerLicense($_GET);
		break;
	case "setCreationDate":
		setCreationDate($_GET);
		break;
	case "isAlive":
		isAlive($_GET);
		break;
	case "logUpdateDialerVersion":
		logUpdateDialerVersion($_GET);
		break;

    /*
     * Product Update API
     */
	case "getProductLastVersion":
		getProductLastVersion($_GET);
		break;
	case "updateProductVersion":
		updateProductVersion($_GET);
		break;
	case "verifyProductLicense":
		verifyProductLicense($_GET);
		break;
	case "logProductUpdateVersion":
		logProductUpdateVersion($_GET);
		break;
  case "test_customer_product":

    $cp = new CustomerProduct();
    $cp->load_single("license_number='gty929ce36b7e9ggh89987gfhhg87987' LIMIT 1");
    echo "<pre>";
    print_r($cp);
    echo "</pre>";
    break;
	case "authApp":
		authenticate_App($_GET);
		break;
  /*
   * Hive API to setup virtual instances of the HCS
   */
  case "getMachineConfiguration":
      get_machine_config($_GET);
    break;
  case "updateInstallStatus":
      update_install_status($_GET);
    break;
		
		/*
     * Hive Reporting Tool APIs
     */
	case "registerProduct":
		registerProduct($_GET);
		break;
}
?>
