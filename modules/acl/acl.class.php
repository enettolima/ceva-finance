<?

class ACL {

    public $username;
    public $password;
    public $email;

    private function log_activity($username, $logmesg) {
        $DB = new DB_ACCESS;
        $query = "INSERT INTO cmi.access_log set username='" . $username . "', ip_address='" . $_SERVER['REMOTE_ADDR'] . "', activity='" . $logmesg . "'";
        $DB->query($query, "OBJECT", false);
    }

    public function login() {
        $user = new User();
        $contact = new Contact();
        $NATURAL_key = NATURAL_MAGIC_KEY;
        $user->load_single("username='{$this->username}' AND password=AES_ENCRYPT('{$this->password}','{$NATURAL_key}') AND status>'0' LIMIT 1");
        /*if ($user->affected < 1) {
            $user = new User();
            $user->load_single("username='{$this->username}' AND password='" . sha1(md5(trim($this->password))) . "' AND status>'0' AND access_level>=40 LIMIT 1");
        }*/
        
        //print_debug($user);

        //$user->load_single("username='{$this->username}' AND status>'0' LIMIT 1");
        if ($user->affected) {
            $contact->load_single("id='{$user->contact_id}' LIMIT 1");
            session_start();
            $_SESSION['affected'] = $user->affected;
            $_SESSION['logged'] = true;
            $_SESSION['log_id'] = $user->id;
            $_SESSION['log_partner_id'] = $user->partner_id;
            $_SESSION['log_customer_id'] = $user->customer_id;
            $_SESSION['log_email'] = $contact->email;
            $_SESSION['log_group_id'] = $user->group_id;
            $_SESSION['log_first_name'] = $user->first_name;
            $_SESSION['log_last_name'] = $user->last_name;
            $_SESSION['log_contact_id'] = $user->contact_id;
            $_SESSION['log_username'] = $user->username;
            $_SESSION['log_password'] = $user->password;
            $_SESSION['log_access_level'] = $user->access_level;
            $_SESSION['log_pin'] = $user->pin;
            $_SESSION['log_status'] = $user->status;
            $_SESSION['log_time_zone'] = $user->time_zone;
            $_SESSION['log_type'] = $user->type;
            $_SESSION['log_comission_id'] = $user->comission_id;
            $_SESSION['log_default_caller_id'] = $user->default_caller_id;
            $_SESSION['log_permit_sms'] = $user->permit_sms;
            $_SESSION['log_sms_credits'] = $user->sms_credits;
            $_SESSION['log_preferred_language'] = $user->preferred_language;
            $_SESSION['log_dash1'] = $user->dashboard_1;
            $_SESSION['sid'] = session_id();
            $_SESSION['current_customer_id'] = $user->customer_id;
            $_SESSION['dash_type'] = 1;
        } else {
            $_SESSION['logged'] = false;
        }
    }

    public function logout() {
        session_start();
        $this->log_activity($_SESSION['username'], "LOGOUT SUCCESSFUL - SESSION CLEARED");
        if (isset($_SESSION)) {
            session_destroy();
        }
    }

}

?>
