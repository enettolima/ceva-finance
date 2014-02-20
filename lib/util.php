<?

function generate_random_str($length = 32, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
    $chars_length = (strlen($chars) - 1);
    $string = $chars{rand(0, $chars_length)};
    for ($i = 1; $i < $length; $i = strlen($string)) {
        $r = $chars{rand(0, $chars_length)};
        if ($r != $string{$i - 1})
            $string .= $r;
    }
    return $string;
}

/* function generate_extension(){
  $create  = true;
  while($create){
  $cg  = "";
  $cg  = rand(9999, 999999);
  require_once(NATURAL_CLASSES_PATH.'en_extension.class.php');
  $extension = new EnExtension();
  $extension->load_single("extension_number='{$cg}'");
  if(!$extension->affected){
  $create = false;
  }
  }
  return $cg;
  }

  function destroy_cache(){
  $password = NATURAL_OPENFIRE_PASSW;
  $username = NATURAL_OPENFIRE_ADMIN;
  $domain = "http://localhost:9090/";
  $cookie = "./cookie_openfire.txt"; //must exist here.

  $POST = "url=%2Findex.jsp&login=true&username=".$username."&password=".$password;
  $page_ = $domain."login.jsp";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $page_);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  $data = curl_exec($ch);
  curl_close($ch);

  $this->data1 = $data;

  for($i = -1; $i<=32; $i++){
  $cacheID[] = $i;
  }

  $POST = join("&cacheID=", $cacheID);
  $POST = $POST."&clear=Clear+Selected";
  $page_ = $domain."system-cache.jsp";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $page_);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  $data = curl_exec($ch);
  curl_close($ch);
  $this->data2 = $data;
  }

  function print_debug($val){
  echo "<pre>";
  if(is_array($val)){
  print_r($val);
  }else{
  if(is_object($val)){
  print_r($val);
  }else{
  echo str_replace("\n","<br>",$val);
  }
  }
  echo "</pre>";
  }

  function format_us_phone($phone){
  return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
  } */

function isValidEmail($email) {
    return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

/*
  function isValidUsNumber($number){
  $validation = true;
  if(!is_numeric($number)){
  $validation = false;
  }
  if(strlen($number)!=10){
  $validation = false;
  }
  if(substr($number,0, 1)<2){
  $validation = false;
  }
  return $validation;
  } */

function isValidFloat($value) {
    $regex = "/^[0-9]+(?:\.[0-9]{2})?$/";
    if (preg_match($regex, $value)) {
        return true;
    } else {
        return false;
    }
}

function isValidExtensionNumber($extension) {
    $validation = true;
    if (!is_numeric($extension)) {
        $validation = false;
    }
    if (strlen($extension) < 3 || strlen($extension) > 6) {
        $validation = false;
    }
    return $validation;
}

function isValidMailboxPassword($pass) {
    $validation = true;
    if (!is_numeric($pass)) {
        $validation = false;
    }
    if (strlen($pass) < 3) {
        $validation = false;
    }
    return $validation;
}

/*
 *
 * This function gets the group_id
 */

function get_group_id_by_user_id($user_id) {
    if (!$user_id) {
        $user_id = $_SESSION['log_id'];
    }
    $user = new DataManager;
    $user->dm_load_single(NATURAL_DBNAME . '.user', 'id = ' . $user_id);
    return $user->group_id;
}

function build_group_list_by_user_id() {
    $group = new Groups();
    $group->load_list("ASSOC", "category<='{$_SESSION['log_access_level']}' AND status=1");
    if ($group->affected) {
        for ($i = 0; $i < $group->affected; $i++) {
            $items[] = $group->data[$i]['name'] . "=" . $group->data[$i]['id'];
        }
        $response = implode(';', $items);
    }
    return $response;
}

function build_category_list_by_user_id() {
    $group = new Groups();
    $group->load_single("id='{$_SESSION['log_group_id']}'");
    $so = new SelectOption();
    $so->load_list("ASSOC", "upstream_name='group_category' AND value<='{$group->category}'");
    if ($so->affected) {
        for ($i = 0; $i < $so->affected; $i++) {
            $items[] = $so->data[$i]['description'] . "=" . $so->data[$i]['value'];
        }
        $response = implode(';', $items);
    }
    return $response;
}

function build_access_level_by_user_id() {
    if ($_SESSION['log_access_level'] > 80) {
        $acl = 3;
    } else {
        $acl = substr($_SESSION['log_access_level'], -1);
    }
    $so = new SelectOption();
    $so->load_list("ASSOC", "upstream_name='access_level' AND value<='" . $acl . "'");
    if ($so->affected) {
        for ($i = 0; $i < $so->affected; $i++) {
            $items[] = $so->data[$i]['description'] . "=" . $so->data[$i]['value'];
        }
        $response = implode(';', $items);
    }
    return $response;
}

function get_group_category_by_group_id($group_id = null) {
    if (!$group_id) {
        $group_id = $_SESSION['log_group_id'];
    }
    $group = new Groups();
    $group->load_single("id='{$group_id}'");
    return $group->category;
}

/*
 * this function checks if there are any user assigned to a specific group to prevent group removal
 */

function is_group_assigned($group_id) {
    $user = new User();
    $user->load_single("group_id='{$group_id}'");
    if ($user->affected > 0) {
        return true;
    } else {
        return false;
    }
}

/**
 * This separates records by user, group and admin
 */
function set_permission_clause($level = NULL, $user_id = NULL, $table_alias = NULL, $user_table = 0, $public_test = 0) {
    $clause = '';
    if (!$level) {
        $level = $_SESSION['log_access_level'];
    }
    if (!$user_id) {
        $user_id = $_SESSION['log_id'];
    }
    if ($user_table) {
        $clause = $table_alias . 'id = ' . $user_id;
    } else {
        $clause = $table_alias . 'user_id = ' . $user_id;
    }
    /* if ($level <= 41) {
      if ($user_table) {
      $clause = $table_alias.'id = '.$user_id;
      }else{
      $clause = $table_alias.'user_id = '.$user_id;
      }
      }elseif($level <= 51) {
      $group_id = get_group_id_by_user_id($user_id);
      $clause = $table_alias.'group_id = '.$group_id;
      }
      // If there is some permission to test
      if ($clause) {
      // Public for all
      if($public_test){
      if($user_table){
      $user_clause = $table_alias.'id = '.$user_id;
      }else{
      $user_clause = $table_alias.'user_id = '.$user_id;
      }
      if($level <= 41){
      $group_id = get_group_id_by_user_id($user_id);
      $clause = 'AND ('.$table_alias.'public_access = 1 OR ('.$table_alias.'group_id = '.$group_id. ' AND ' .$table_alias.'public_access = 2)) OR '.$user_clause;
      }elseif($level <= 51){
      $clause = 'AND ('.$table_alias.'group_id = '.$group_id.' OR '.$table_alias.'public_access = 1)';
      }
      }else{
      $clause = 'AND '.$clause;
      }
      } */
    return $clause;
}

function isValidMacNumber($mac) {
    $upper_mac = strtoupper($mac);
    $validation = (preg_match("/^([A-F0-9])+$/i", ($upper_mac)) && strlen($upper_mac) == 12 ) ? true : false;
    return $validation;
}

function createMailboxNumber() {
    $mailbox = new DataManager();
    $create_mb = true;
    while ($create_mb) {
        $mb = "";
        $mb = generate_random_str(8, '123456789');
        $mailbox->dm_load_single(NATURAL_DBNAME . ".en_mailbox", "mailbox='{$mb}'");
        if (!$mailbox->affected) {
            $create_mb = false;
        }
    }
    return $mb;
}

function createConferenceRoomNumber() {
    $conference = new DataManager();
    $loop = true;
    while ($loop) {
        $room_number = "";
        $room_number = generate_random_str(6, '123456789');
        $conference->dm_load_single(NATURAL_DBNAME . '.en_conference', 'room=' . $room_number);
        if (!$conference->affected) {
            $loop = false;
        }
    }
    return $room_number;
}

/**
 * Transform seconds in hms
 */
function sec2hms($sec) {
    // holds formatted string
    $hms = "";
    $hours = intval(intval($sec) / 3600);
    $hms .= $hours . ':';
    $minutes = intval(($sec / 60) % 60);
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT) . ':';
    $seconds = intval($sec % 60);
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return $hms;
}

/* function check_module_licenses($module, $table_name){
  $md = new DataManager();
  $md->dm_check_module($module);
  $db = new DataManager();
  $db->dm_custom_query("SELECT COUNT(*) as total FROM ".NATURAL_DBNAME.".{$table_name}",true);
  if($md->status==0){
  //No License Permission for this module
  return false;
  exit(0);
  }

  if($md->license_quantity==0 && $md->status==1){
  //Unlimited License for this module
  return true;
  }else{
  if($db->total>=$md->license_quantity){
  //License expired
  return false;
  }else{
  return true;
  }
  }

  } */

/* function get_timezone_offset($remote_tz, $origin_tz = null) {
  if($origin_tz === null) {
  if(!is_string($origin_tz = date_default_timezone_get())) {
  return false; // A UTC timestamp was returned -- bail out!
  }
  }
  $origin_dtz = new DateTimeZone($origin_tz);
  $remote_dtz = new DateTimeZone($remote_tz);
  $origin_dt = new DateTime("now", $origin_dtz);
  $remote_dt = new DateTime("now", $remote_dtz);
  $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
  $offset = ($offset/60)/60;
  return $offset;
  } */

function parseUSPhone($raw_number) {
    $number = preg_replace("[\D]", "", $raw_number);

    if ($number != "") {
        $number = (substr($number, 0, 1) == "+") ? substr($number, 1) : $number;
    } else {
        $number = "0000000000";
    }
    /*  if(strlen($number)!=10)
      return "0000000000";

      $npa = substr($number,0,3);
      $nxx = substr($number,3,3);
      $thousand = substr($number,-4);

      $number = (substr($npa,0,1) != "0")? $npa : "000";
      $number = (substr($nxx,0,1) != "0")? $npa.$nxx : "000000";
      if($number == "000000")
      return "0000000000";

      $number .= $thousand; */
    return $number;
}

function parseCID($raw_number) {
    $number = preg_replace("[\D]", "", $raw_number);

    $number = (substr($number, 0, 1) == "+") ? substr($number, 1) : $number;
    if (strlen($number) != 10)
        return "0000000000";

    $npa = substr($number, 0, 3);
    $nxx = substr($number, 3, 3);
    $thousand = substr($number, -4);

    $number = (substr($npa, 0, 1) != "0") ? $npa : "000";
    $number = (substr($nxx, 0, 1) != "0") ? $npa . $nxx : "000000";
    if ($number == "000000")
        return "0000000000";

    $number .= $thousand;
    return $number;
}

/* function validateAddress($address){
  require_once(NATURAL_CLASSES_PATH.'GMaps.php');
  $search= strip_tags($address);
  $search = str_replace("#","suite",$search);
  $google_key = NATURAL_GMAPS_KEY;
  $GMap = new GMaps($google_key);
  if($GMap->getInfoLocation($search)){
  $fulladd = $GMap->getAddress();
  $country = $GMap->getCountryNameCode();
  $postal = $GMap->getPostalCode();
  }

  if(!empty($postal)){
  $resp['status'] = true;
  }else{
  $resp['status'] = false;
  }
  if($resp['status']){
  $add_arr = explode(",",$fulladd);
  $sep_state = explode(" ",$add_arr[2]);
  $resp['fullAddress'] 	= $fulladd;
  $resp['address'] 			= $add_arr[0];
  $resp['city'] 				= $add_arr[1];
  $resp['state'] 				= $sep_state[1];
  $resp['zip'] 					= $sep_state[2];
  $resp['country']			= $country;
  }
  return $resp;
  } */

/* function insertLog($message=null, $type="activity"){

  require_once(NATURAL_CLASSES_PATH.'log_error.class.php');
  require_once(NATURAL_CLASSES_PATH.'log_activity.class.php');
  require_once(NATURAL_CLASSES_PATH.'log.class.php');

  if($message==null){
  $resp['status'] = false;
  $resp['message']= "Invalid Message";
  $resp['log_id']	= 0;
  return $resp;
  exit(0);
  }
  if(strtolower($type)=="error"){
  $log = new LogError();
  }else{
  $log = new LogActivity();
  }
  $log->updated_by_uid 	= $_SESSION['log_id'];
  $log->notes	 					= $message;
  $log->insert();
  if($log->affected>0){
  $resp['status'] = true;
  $resp['message']= "Log Saved Successfully!";
  $resp['log_id']	= $log->id;
  }else{
  $resp['status'] = false;
  $resp['message']= "Log could not be saved at this time! Please try again!";
  $resp['log_id']	= 0;
  }
  return $resp;
  } */

function isValidMilTime($time) {
    //This function verifies if the time passed is on military format and if it
    //contains : to remove.
    //this function will return the correct time or false if can not verify
    $t = strtotime($time);
    $res = date("Hi", $t);
    if (is_numeric($res) && strlen($res) == 4) {
        return $res;
    } else {
        return false;
    }
    /* if(strpos($time, ":")){
      $time_correct = str_replace(":","",$time);
      }else{
      $time_correct = $time;
      }
      if(!is_numeric($time_correct)){
      return false;
      exit(0);
      }
      if($time_correct>2359){
      return false;
      exit(0);
      }
      return $time_correct; */
}

function compareMilTime($start, $end) {
    //After validating (isValidMilTime) pass 2 values to this function to verify if it is valid
    if (!$start) {
        return false;
    }
    if (!$end) {
        return false;
    }
    if ($end < $start) {
        return false;
    } else {
        return true;
    }
}

function parseDialerPhone($raw_number) {
    if (!$raw_number) {
        return "0000000000";
    }
    $num = strtolower($raw_number);
    $pos = strpos($num, "w");
    if ($pos === false) {
        return parseUSPhone($num);
    } else {
        $num_arr = explode("w", $num);
        if (parseUSPhone($num_arr[0]) == "0000000000") {
            return "0000000000";
        } else {
            return $num;
        }
    }
}

function wavDur($file) {
    $fp = fopen($file, 'r');
    if (fread($fp, 4) == "RIFF") {
        fseek($fp, 20);
        $rawheader = fread($fp, 16);
        $header = unpack('vtype/vchannels/Vsamplerate/Vbytespersec/valignment/vbits', $rawheader);
        $pos = ftell($fp);
        while (fread($fp, 4) != "data" && !feof($fp)) {
            $pos++;
            fseek($fp, $pos);
        }
        $rawheader = fread($fp, 4);
        $data = unpack('Vdatasize', $rawheader);
        $sec = $data[datasize] / $header[bytespersec];
        return $sec;
    }
}

/*
 * Function connected to HSD Manager
 */
/* function reload_asterisk_module($mod=null){
  if(ASTERISK_DEV_MODE){
  return true;
  exit(0);
  }

  if($mod){
  $counter = 1;
  $mod_arr[0] = $mod;
  if($mod=="dialPattern" || $mod=="trunk"){
  $counter=2;
  $mod_arr[0] = "trunk";
  $mod_arr[1] = "dialPattern";
  }
  $hsd = new HSDManager();
  $hsd->reload($mod_arr, $counter);
  $doc = new SimpleXmlElement($hsd->response, LIBXML_NOCDATA);
  if($doc->response!="MODULE_RELOAD_OK"){
  $dm = new DataManager();
  $dm->dm_custom_insert("INSERT INTO smartdialer.log_error SET updated_by_uid='{$_SESSION['log_id']}', notes='Reloader Failed on the following command: {$hsd->command} with the Response: ".strip_tags($hsd->response)."'");
  }else{
  $dm = new DataManager();
  $dm->dm_custom_insert("INSERT INTO smartdialer.log_activity SET updated_by_uid='{$_SESSION['log_id']}', notes='Reloader Call with the following command: {$hsd->command} with the Response: ".strip_tags($hsd->response)."'");
  }
  //print_r($doc);
  }
  }

  function remove_queue_agents($username,$password){
  if(ASTERISK_DEV_MODE){
  return true;
  exit(0);
  }
  $hsd = new HSDManager();
  $hsd->remove_agent($username,$password);
  $doc = new SimpleXmlElement($hsd->response, LIBXML_NOCDATA);
  if($doc->response!="AGENT_LOGOUT_OK"){
  $dm = new DataManager();
  $dm->dm_custom_insert("INSERT INTO smartdialer.log_error SET updated_by_uid='{$_SESSION['log_id']}', notes='Failed to remove the Agent({$username}) from the Campaign {$campaign_id} with the Response: ".strip_tags($hsd->response)."'");
  }else{
  $dm = new DataManager();
  $dm->dm_custom_insert("INSERT INTO smartdialer.log_activity SET updated_by_uid='{$_SESSION['log_id']}', notes='Agent({$username}) removed successfully from the Campaign {$campaign_id} with the Response: ".strip_tags($hsd->response)."'");
  }
  }
  //////////////////////////////

  function setSystemToReboot(){
  $system = new SystemControl();
  $system->load_single("id='1'");
  $system->need_reboot = 1;
  $system->update("id='1'");
  }

  function validateIp($ip){
  if (preg_match( "/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/", $ip)) {
  return TRUE;
  }
  else {
  return FALSE;
  }
  }

  function compareTableStructure($table1, $table2, $table2_is_live_list = false){
  $ll1 = new DataManager();
  $ll1->dm_load_custom_list("describe ".NATURAL_DBNAME.".{$table1}","ASSOC");
  for($i=0; $i<count($ll1->data); $i++){
  foreach($ll1->data[$i] as $key => $value){
  if($key=="Field"){
  $arr1[] = $value;
  }
  }
  }
  $ll2 = new DataManager();
  $ll2->dm_load_custom_list("describe ".NATURAL_DBNAME.".{$table2}","ASSOC");
  if($table2_is_live_list){
  for($i=0; $i<count($ll2->data); $i++){
  foreach($ll2->data[$i] as $key => $value){
  if($key=="Field" && !find_NATURAL_values($value)){
  $arr2[] = $value;
  }
  }
  }
  }else{
  for($i=0; $i<count($ll2->data); $i++){
  foreach($ll2->data[$i] as $key => $value){
  if($key=="Field"){
  $arr2[] = $value;
  }
  }
  }
  }
  $dif = array_diff($arr1, $arr2);
  if(empty($dif)){
  return true;
  }else{
  return false;
  }
  }

  function find_NATURAL_values($value){
  $check_arr = array("NATURAL_reference_id",
  "NATURAL_status",
  "NATURAL_phone_number",
  "NATURAL_dtmf_to_inject",
  "NATURAL_dial_timeout",
  "NATURAL_timezone",
  "NATURAL_retry_times",
  "NATURAL_attempts",
  "NATURAL_last_dial_status",
  "NATURAL_connected_agent",
  "NATURAL_talk_time",
  "NATURAL_disconnected_by",
  "NATURAL_agent_channel",
  "NATURAL_stamp",
  "NATURAL_last_pass",
  "NATURAL_ivr_response",
  "NATURAL_recorded");
  if(array_search($value, $check_arr)){
  return true;
  }else{
  return false;
  }
  }

  function table_exists($tablename, $database = false){
  if(!$database) {
  $database = NATURAL_DBNAME;
  }

  $query = "SELECT COUNT(*) AS count
  FROM information_schema.tables
  WHERE table_schema = '{$database}'
  AND table_name = '{$tablename}'";

  $dm = new DataManager();
  $dm->dm_custom_query($query, true, true);

  return $dm->count;
  } */

function wavInfo($file) {
    $format = array(
        0x0001 => 'PCM',
        0x0003 => 'IEEE Float',
        0x0006 => 'ALAW',
        0x0007 => 'MuLAW',
        0xFFFE => 'Extensible',
    );

    $fp = fopen($file, 'r');
    if (fread($fp, 4) == "RIFF") {
        fseek($fp, 20);
        $rawheader = fread($fp, 16);
        $header = unpack('vtype/vchannels/Vsamplerate/Vbytespersec/valignment/vbits', $rawheader);
        $pos = ftell($fp);
        while (fread($fp, 4) != "data" && !feof($fp)) {
            $pos++;
            fseek($fp, $pos);
        }
        $rawheader = fread($fp, 4);
        $data = unpack('Vdatasize', $rawheader);
        $sec = $data[datasize] / $header[bytespersec];
        $minutes = intval(($sec / 60) % 60);
        $seconds = intval($sec % 60);
        $header['playtime'] = str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);
        switch ($header['channels']) {
            case 1:
                $header['chan'] = "Mono";
                break;
            case 2:
                $header['chan'] = "Stereo";
                break;
        }
        $response['Message'] = "OK";
        $response['Filename'] = $file;
        $response['Format'] = $format[$header['type']];
        $response['Channels'] = $header['chan'];
        $response['SampleRate'] = $header['samplerate']; // Hz;
        $response['BitsSample'] = $header['bits'];
        $response['PlayTime'] = $header['playtime'];
    } else {
        $response['Message'] = "File not found!";
    }
    return $response;
}

function translate($string, $lang = 'en') {
    require_once(NATURAL_CLASSES_PATH . 'language.class.php');
    $lg = new Language();
    $lg->load_single("original='{$string}' AND lang='{$lang}'");
    if ($lg->affected > 0) {
        return $lg->translate;
    } else {
        return $string;
    }
}

function getCustomerPlanID() {
    $getplan = new CustomerPlan();
    $getplan->load_single("customer_id='{$_SESSION['selected_customer_id']}'");
    return $getplan->plan_id;
}

?>
