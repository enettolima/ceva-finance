<?
/** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 07-18-2009 19:15:01 -0500 (Jul-Sat-2009) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/

/** 
* <insert your class documentation here> 
*/ 

	class Natural Extends DataManager{

		public function load_single($search_str, $insert_log = false){
      parent::dm_load_single("natural.user",$search_str);
      if($insert_log)
      {
        $stamp = date("Y-m-d H:i:s");
        $this->log_user_id    = $_SESSION['log_id'];
        $this->log_action     = "S";
        $this->log_timestamp  = $stamp;
        parent::dm_insert(NATURAL_DBLOG . ".user", $this);
      }
    }
     
    public function load_list($output, $search_str, $insert_log = false){
      parent::dm_load_list(NATURAL_DBNAME . ".user", $output, $search_str);
      if($insert_log)
      {
        $stamp = date("Y-m-d H:i:s");
        $this->log_user_id    = $_SESSION['log_id'];
        $this->log_action     = "L";
        $this->log_timestamp  = $stamp;
        parent::dm_insert(NATURAL_DBLOG . ".user", $this);
      }

    }

    public function insert(){
      parent::dm_insert(NATURAL_DBNAME . ".user", $this);
      $this->id = $this->dbid;
      
      $stamp = date("Y-m-d H:i:s");
      $this->log_user_id    = $_SESSION['log_id'];
      $this->log_action     = "I";
      $this->log_timestamp  = $stamp;
      parent::dm_insert(NATURAL_DBLOG . ".user", $this);

    }

    public function update($upd_rule){
      parent::dm_update(NATURAL_DBNAME . ".user", $upd_rule, $this);
      
      $stamp = date("Y-m-d H:i:s");
      $this->log_user_id    = $_SESSION['log_id'];
      $this->log_action     = "U";
      $this->log_timestamp  = $stamp;
      parent::dm_insert(NATURAL_DBLOG . ".user", $this);
    }

    public function remove($rec_key){
      parent::dm_remove(NATURAL_DBNAME . ".user", $rec_key);
      
      $stamp = date("Y-m-d H:i:s");
      $this->log_user_id    = $_SESSION['log_id'];
      $this->log_action     = "R";
      $this->log_timestamp  = $stamp;
      parent::dm_insert(NATURAL_DBLOG . ".user", $this);
    }
  }
  
    class UserTable Extends Table{
    public $level;
    
    public function show_new(){
      unset($this->options);
      unset($this->fieldsets);

      /*Define Form's general options*/
      $this->options['id']            = "NewUserForm";
      $this->options['name']          = "NewUserForm";
      $this->options['action']        = "javascript:proccess_information('NewUserForm', '', 'user', '');";
      $this->options['method']        = "POST";
      $this->options['class']         = "NewUserForm";
      $this->options['onsubmit']      = "";
      $this->options['tips']          = "All fields required.";
      $this->options['title']         = "All fields required.";

      /*Define fieldsets*/
      $this->fieldsets[0]['legend'] = "User Information [New]";

    
      $this->fieldsets[0]['fields'][0]['id']        = "id  ";
      $this->fieldsets[0]['fields'][0]['name']      = "id  ";
      $this->fieldsets[0]['fields'][0]['type']      = "list";
      $this->fieldsets[0]['fields'][0]['label']     = "Id  ";
      $this->fieldsets[0]['fields'][0]['class']     = "";
      $this->fieldsets[0]['fields'][0]['options']   = "";
      $this->fieldsets[0]['fields'][0]['datatable'] = "";
			$this->fieldsets[0]['fields'][0]['dataquery'] = "";
			$this->fieldsets[0]['fields'][0]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][0]['datalabel'] = "";
			$this->fieldsets[0]['fields'][0]['datavalue'] = "";
			$this->fieldsets[0]['fields'][0]['values']    = "";
			$this->fieldsets[0]['fields'][0]['vertical']  = "";
      $this->fieldsets[0]['fields'][0]['defval']    = "";
      $this->fieldsets[0]['fields'][0]['click']     = "";
      $this->fieldsets[0]['fields'][0]['focus']     = "";
      $this->fieldsets[0]['fields'][0]['blur']      = "";
      $this->fieldsets[0]['fields'][0]['level']     = "";
      $this->fieldsets[0]['fields'][0]['change']    = "";
      $this->fieldsets[0]['fields'][0]['acl']       = "";

      $this->fieldsets[0]['fields'][1]['id']        = "partner_id ";
      $this->fieldsets[0]['fields'][1]['name']      = "partner_id ";
      $this->fieldsets[0]['fields'][1]['type']      = "list";
      $this->fieldsets[0]['fields'][1]['label']     = "Partner";
      $this->fieldsets[0]['fields'][1]['class']     = "";
      $this->fieldsets[0]['fields'][1]['options']   = "";
      $this->fieldsets[0]['fields'][1]['datatable'] = "";
			$this->fieldsets[0]['fields'][1]['dataquery'] = "";
			$this->fieldsets[0]['fields'][1]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][1]['datalabel'] = "";
			$this->fieldsets[0]['fields'][1]['datavalue'] = "";
			$this->fieldsets[0]['fields'][1]['values']    = "";
			$this->fieldsets[0]['fields'][1]['vertical']  = "";
      $this->fieldsets[0]['fields'][1]['defval']    = "";
      $this->fieldsets[0]['fields'][1]['click']     = "";
      $this->fieldsets[0]['fields'][1]['focus']     = "";
      $this->fieldsets[0]['fields'][1]['blur']      = "";
      $this->fieldsets[0]['fields'][1]['level']     = "";
      $this->fieldsets[0]['fields'][1]['change']    = "";
      $this->fieldsets[0]['fields'][1]['acl']       = "";

      $this->fieldsets[0]['fields'][2]['id']        = "customer_id ";
      $this->fieldsets[0]['fields'][2]['name']      = "customer_id ";
      $this->fieldsets[0]['fields'][2]['type']      = "list";
      $this->fieldsets[0]['fields'][2]['label']     = "Customer";
      $this->fieldsets[0]['fields'][2]['class']     = "";
      $this->fieldsets[0]['fields'][2]['options']   = "";
      $this->fieldsets[0]['fields'][2]['datatable'] = "";
			$this->fieldsets[0]['fields'][2]['dataquery'] = "";
			$this->fieldsets[0]['fields'][2]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][2]['datalabel'] = "";
			$this->fieldsets[0]['fields'][2]['datavalue'] = "";
			$this->fieldsets[0]['fields'][2]['values']    = "";
			$this->fieldsets[0]['fields'][2]['vertical']  = "";
      $this->fieldsets[0]['fields'][2]['defval']    = "";
      $this->fieldsets[0]['fields'][2]['click']     = "";
      $this->fieldsets[0]['fields'][2]['focus']     = "";
      $this->fieldsets[0]['fields'][2]['blur']      = "";
      $this->fieldsets[0]['fields'][2]['level']     = "";
      $this->fieldsets[0]['fields'][2]['change']    = "";
      $this->fieldsets[0]['fields'][2]['acl']       = "";

      $this->fieldsets[0]['fields'][3]['id']        = "company_id ";
      $this->fieldsets[0]['fields'][3]['name']      = "company_id ";
      $this->fieldsets[0]['fields'][3]['type']      = "list";
      $this->fieldsets[0]['fields'][3]['label']     = "Company";
      $this->fieldsets[0]['fields'][3]['class']     = "";
      $this->fieldsets[0]['fields'][3]['options']   = "";
      $this->fieldsets[0]['fields'][3]['datatable'] = "";
			$this->fieldsets[0]['fields'][3]['dataquery'] = "";
			$this->fieldsets[0]['fields'][3]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][3]['datalabel'] = "";
			$this->fieldsets[0]['fields'][3]['datavalue'] = "";
			$this->fieldsets[0]['fields'][3]['values']    = "";
			$this->fieldsets[0]['fields'][3]['vertical']  = "";
      $this->fieldsets[0]['fields'][3]['defval']    = "";
      $this->fieldsets[0]['fields'][3]['click']     = "";
      $this->fieldsets[0]['fields'][3]['focus']     = "";
      $this->fieldsets[0]['fields'][3]['blur']      = "";
      $this->fieldsets[0]['fields'][3]['level']     = "";
      $this->fieldsets[0]['fields'][3]['change']    = "";
      $this->fieldsets[0]['fields'][3]['acl']       = "";

      $this->fieldsets[0]['fields'][4]['id']        = "group_id ";
      $this->fieldsets[0]['fields'][4]['name']      = "group_id ";
      $this->fieldsets[0]['fields'][4]['type']      = "list";
      $this->fieldsets[0]['fields'][4]['label']     = "Group";
      $this->fieldsets[0]['fields'][4]['class']     = "";
      $this->fieldsets[0]['fields'][4]['options']   = "";
      $this->fieldsets[0]['fields'][4]['datatable'] = "";
			$this->fieldsets[0]['fields'][4]['dataquery'] = "";
			$this->fieldsets[0]['fields'][4]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][4]['datalabel'] = "";
			$this->fieldsets[0]['fields'][4]['datavalue'] = "";
			$this->fieldsets[0]['fields'][4]['values']    = "";
			$this->fieldsets[0]['fields'][4]['vertical']  = "";
      $this->fieldsets[0]['fields'][4]['defval']    = "";
      $this->fieldsets[0]['fields'][4]['click']     = "";
      $this->fieldsets[0]['fields'][4]['focus']     = "";
      $this->fieldsets[0]['fields'][4]['blur']      = "";
      $this->fieldsets[0]['fields'][4]['level']     = "";
      $this->fieldsets[0]['fields'][4]['change']    = "";
      $this->fieldsets[0]['fields'][4]['acl']       = "";

      $this->fieldsets[0]['fields'][5]['id']        = "first_name ";
      $this->fieldsets[0]['fields'][5]['name']      = "first_name ";
      $this->fieldsets[0]['fields'][5]['type']      = "text";
      $this->fieldsets[0]['fields'][5]['label']     = "First Name";
      $this->fieldsets[0]['fields'][5]['class']     = "";
      $this->fieldsets[0]['fields'][5]['options']   = "";
      $this->fieldsets[0]['fields'][5]['datatable'] = "";
			$this->fieldsets[0]['fields'][5]['dataquery'] = "";
			$this->fieldsets[0]['fields'][5]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][5]['datalabel'] = "";
			$this->fieldsets[0]['fields'][5]['datavalue'] = "";
			$this->fieldsets[0]['fields'][5]['values']    = "";
			$this->fieldsets[0]['fields'][5]['vertical']  = "";
      $this->fieldsets[0]['fields'][5]['defval']    = "";
      $this->fieldsets[0]['fields'][5]['click']     = "";
      $this->fieldsets[0]['fields'][5]['focus']     = "";
      $this->fieldsets[0]['fields'][5]['blur']      = "";
      $this->fieldsets[0]['fields'][5]['level']     = "";
      $this->fieldsets[0]['fields'][5]['change']    = "";
      $this->fieldsets[0]['fields'][5]['acl']       = "";

      $this->fieldsets[0]['fields'][6]['id']        = "last_name ";
      $this->fieldsets[0]['fields'][6]['name']      = "last_name ";
      $this->fieldsets[0]['fields'][6]['type']      = "text";
      $this->fieldsets[0]['fields'][6]['label']     = "Last Name";
      $this->fieldsets[0]['fields'][6]['class']     = "";
      $this->fieldsets[0]['fields'][6]['options']   = "";
      $this->fieldsets[0]['fields'][6]['datatable'] = "";
			$this->fieldsets[0]['fields'][6]['dataquery'] = "";
			$this->fieldsets[0]['fields'][6]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][6]['datalabel'] = "";
			$this->fieldsets[0]['fields'][6]['datavalue'] = "";
			$this->fieldsets[0]['fields'][6]['values']    = "";
			$this->fieldsets[0]['fields'][6]['vertical']  = "";
      $this->fieldsets[0]['fields'][6]['defval']    = "";
      $this->fieldsets[0]['fields'][6]['click']     = "";
      $this->fieldsets[0]['fields'][6]['focus']     = "";
      $this->fieldsets[0]['fields'][6]['blur']      = "";
      $this->fieldsets[0]['fields'][6]['level']     = "";
      $this->fieldsets[0]['fields'][6]['change']    = "";
      $this->fieldsets[0]['fields'][6]['acl']       = "";

      $this->fieldsets[0]['fields'][7]['id']        = "contact_id ";
      $this->fieldsets[0]['fields'][7]['name']      = "contact_id ";
      $this->fieldsets[0]['fields'][7]['type']      = "list";
      $this->fieldsets[0]['fields'][7]['label']     = "Contact";
      $this->fieldsets[0]['fields'][7]['class']     = "";
      $this->fieldsets[0]['fields'][7]['options']   = "";
      $this->fieldsets[0]['fields'][7]['datatable'] = "";
			$this->fieldsets[0]['fields'][7]['dataquery'] = "";
			$this->fieldsets[0]['fields'][7]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][7]['datalabel'] = "";
			$this->fieldsets[0]['fields'][7]['datavalue'] = "";
			$this->fieldsets[0]['fields'][7]['values']    = "";
			$this->fieldsets[0]['fields'][7]['vertical']  = "";
      $this->fieldsets[0]['fields'][7]['defval']    = "";
      $this->fieldsets[0]['fields'][7]['click']     = "";
      $this->fieldsets[0]['fields'][7]['focus']     = "";
      $this->fieldsets[0]['fields'][7]['blur']      = "";
      $this->fieldsets[0]['fields'][7]['level']     = "";
      $this->fieldsets[0]['fields'][7]['change']    = "";
      $this->fieldsets[0]['fields'][7]['acl']       = "";

      $this->fieldsets[0]['fields'][8]['id']        = "username ";
      $this->fieldsets[0]['fields'][8]['name']      = "username ";
      $this->fieldsets[0]['fields'][8]['type']      = "text";
      $this->fieldsets[0]['fields'][8]['label']     = "User Name";
      $this->fieldsets[0]['fields'][8]['class']     = "";
      $this->fieldsets[0]['fields'][8]['options']   = "";
      $this->fieldsets[0]['fields'][8]['datatable'] = "";
			$this->fieldsets[0]['fields'][8]['dataquery'] = "";
			$this->fieldsets[0]['fields'][8]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][8]['datalabel'] = "";
			$this->fieldsets[0]['fields'][8]['datavalue'] = "";
			$this->fieldsets[0]['fields'][8]['values']    = "";
			$this->fieldsets[0]['fields'][8]['vertical']  = "";
      $this->fieldsets[0]['fields'][8]['defval']    = "";
      $this->fieldsets[0]['fields'][8]['click']     = "";
      $this->fieldsets[0]['fields'][8]['focus']     = "";
      $this->fieldsets[0]['fields'][8]['blur']      = "";
      $this->fieldsets[0]['fields'][8]['level']     = "";
      $this->fieldsets[0]['fields'][8]['change']    = "";
      $this->fieldsets[0]['fields'][8]['acl']       = "";

      $this->fieldsets[0]['fields'][9]['id']        = "password ";
      $this->fieldsets[0]['fields'][9]['name']      = "password ";
      $this->fieldsets[0]['fields'][9]['type']      = "password";
      $this->fieldsets[0]['fields'][9]['label']     = "Password";
      $this->fieldsets[0]['fields'][9]['class']     = "";
      $this->fieldsets[0]['fields'][9]['options']   = "";
      $this->fieldsets[0]['fields'][9]['datatable'] = "";
			$this->fieldsets[0]['fields'][9]['dataquery'] = "";
			$this->fieldsets[0]['fields'][9]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][9]['datalabel'] = "";
			$this->fieldsets[0]['fields'][9]['datavalue'] = "";
			$this->fieldsets[0]['fields'][9]['values']    = "";
			$this->fieldsets[0]['fields'][9]['vertical']  = "";
      $this->fieldsets[0]['fields'][9]['defval']    = "";
      $this->fieldsets[0]['fields'][9]['click']     = "";
      $this->fieldsets[0]['fields'][9]['focus']     = "";
      $this->fieldsets[0]['fields'][9]['blur']      = "";
      $this->fieldsets[0]['fields'][9]['level']     = "";
      $this->fieldsets[0]['fields'][9]['change']    = "";
      $this->fieldsets[0]['fields'][9]['acl']       = "";

      $this->fieldsets[0]['fields'][10]['id']        = "access_level ";
      $this->fieldsets[0]['fields'][10]['name']      = "access_level ";
      $this->fieldsets[0]['fields'][10]['type']      = "";
      $this->fieldsets[0]['fields'][10]['label']     = "Access Level";
      $this->fieldsets[0]['fields'][10]['class']     = "";
      $this->fieldsets[0]['fields'][10]['options']   = "";
      $this->fieldsets[0]['fields'][10]['datatable'] = "";
			$this->fieldsets[0]['fields'][10]['dataquery'] = "";
			$this->fieldsets[0]['fields'][10]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][10]['datalabel'] = "";
			$this->fieldsets[0]['fields'][10]['datavalue'] = "";
			$this->fieldsets[0]['fields'][10]['values']    = "";
			$this->fieldsets[0]['fields'][10]['vertical']  = "";
      $this->fieldsets[0]['fields'][10]['defval']    = "";
      $this->fieldsets[0]['fields'][10]['click']     = "";
      $this->fieldsets[0]['fields'][10]['focus']     = "";
      $this->fieldsets[0]['fields'][10]['blur']      = "";
      $this->fieldsets[0]['fields'][10]['level']     = "";
      $this->fieldsets[0]['fields'][10]['change']    = "";
      $this->fieldsets[0]['fields'][10]['acl']       = "";

      $this->fieldsets[0]['fields'][11]['id']        = "pin ";
      $this->fieldsets[0]['fields'][11]['name']      = "pin ";
      $this->fieldsets[0]['fields'][11]['type']      = "text";
      $this->fieldsets[0]['fields'][11]['label']     = "PIN";
      $this->fieldsets[0]['fields'][11]['class']     = "";
      $this->fieldsets[0]['fields'][11]['options']   = "";
      $this->fieldsets[0]['fields'][11]['datatable'] = "";
			$this->fieldsets[0]['fields'][11]['dataquery'] = "";
			$this->fieldsets[0]['fields'][11]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][11]['datalabel'] = "";
			$this->fieldsets[0]['fields'][11]['datavalue'] = "";
			$this->fieldsets[0]['fields'][11]['values']    = "";
			$this->fieldsets[0]['fields'][11]['vertical']  = "";
      $this->fieldsets[0]['fields'][11]['defval']    = "";
      $this->fieldsets[0]['fields'][11]['click']     = "";
      $this->fieldsets[0]['fields'][11]['focus']     = "";
      $this->fieldsets[0]['fields'][11]['blur']      = "";
      $this->fieldsets[0]['fields'][11]['level']     = "";
      $this->fieldsets[0]['fields'][11]['change']    = "";
      $this->fieldsets[0]['fields'][11]['acl']       = "";

      $this->fieldsets[0]['fields'][12]['id']        = "status ";
      $this->fieldsets[0]['fields'][12]['name']      = "status ";
      $this->fieldsets[0]['fields'][12]['type']      = "";
      $this->fieldsets[0]['fields'][12]['label']     = "Status";
      $this->fieldsets[0]['fields'][12]['class']     = "";
      $this->fieldsets[0]['fields'][12]['options']   = "";
      $this->fieldsets[0]['fields'][12]['datatable'] = "";
			$this->fieldsets[0]['fields'][12]['dataquery'] = "";
			$this->fieldsets[0]['fields'][12]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][12]['datalabel'] = "";
			$this->fieldsets[0]['fields'][12]['datavalue'] = "";
			$this->fieldsets[0]['fields'][12]['values']    = "";
			$this->fieldsets[0]['fields'][12]['vertical']  = "";
      $this->fieldsets[0]['fields'][12]['defval']    = "";
      $this->fieldsets[0]['fields'][12]['click']     = "";
      $this->fieldsets[0]['fields'][12]['focus']     = "";
      $this->fieldsets[0]['fields'][12]['blur']      = "";
      $this->fieldsets[0]['fields'][12]['level']     = "";
      $this->fieldsets[0]['fields'][12]['change']    = "";
      $this->fieldsets[0]['fields'][12]['acl']       = "";

      $this->fieldsets[0]['fields'][13]['id']        = "time_zone ";
      $this->fieldsets[0]['fields'][13]['name']      = "time_zone ";
      $this->fieldsets[0]['fields'][13]['type']      = "list";
      $this->fieldsets[0]['fields'][13]['label']     = "Time Zone";
      $this->fieldsets[0]['fields'][13]['class']     = "";
      $this->fieldsets[0]['fields'][13]['options']   = "";
      $this->fieldsets[0]['fields'][13]['datatable'] = "timezone";
			$this->fieldsets[0]['fields'][13]['dataquery'] = "zone!='' ORDER BY zone DESC";
			$this->fieldsets[0]['fields'][13]['datasort'] 	= "zone";
			$this->fieldsets[0]['fields'][13]['datalabel'] = "zone";
			$this->fieldsets[0]['fields'][13]['datavalue'] = "zone";
			$this->fieldsets[0]['fields'][13]['values']    = "zone";
			$this->fieldsets[0]['fields'][13]['vertical']  = "";
      $this->fieldsets[0]['fields'][13]['defval']    = "US/Central";
      $this->fieldsets[0]['fields'][13]['click']     = "";
      $this->fieldsets[0]['fields'][13]['focus']     = "";
      $this->fieldsets[0]['fields'][13]['blur']      = "";
      $this->fieldsets[0]['fields'][13]['level']     = "";
      $this->fieldsets[0]['fields'][13]['change']    = "";
      $this->fieldsets[0]['fields'][13]['acl']       = "";

      $this->fieldsets[0]['fields'][14]['id']        = "type ";
      $this->fieldsets[0]['fields'][14]['name']      = "type ";
      $this->fieldsets[0]['fields'][14]['type']      = "";
      $this->fieldsets[0]['fields'][14]['label']     = "Type ";
      $this->fieldsets[0]['fields'][14]['class']     = "";
      $this->fieldsets[0]['fields'][14]['options']   = "";
      $this->fieldsets[0]['fields'][14]['datatable'] = "";
			$this->fieldsets[0]['fields'][14]['dataquery'] = "";
			$this->fieldsets[0]['fields'][14]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][14]['datalabel'] = "";
			$this->fieldsets[0]['fields'][14]['datavalue'] = "";
			$this->fieldsets[0]['fields'][14]['values']    = "";
			$this->fieldsets[0]['fields'][14]['vertical']  = "";
      $this->fieldsets[0]['fields'][14]['defval']    = "";
      $this->fieldsets[0]['fields'][14]['click']     = "";
      $this->fieldsets[0]['fields'][14]['focus']     = "";
      $this->fieldsets[0]['fields'][14]['blur']      = "";
      $this->fieldsets[0]['fields'][14]['level']     = "";
      $this->fieldsets[0]['fields'][14]['change']    = "";
      $this->fieldsets[0]['fields'][14]['acl']       = "";

      $this->fieldsets[0]['fields'][15]['id']        = "comission_id ";
      $this->fieldsets[0]['fields'][15]['name']      = "comission_id ";
      $this->fieldsets[0]['fields'][15]['type']      = "list";
      $this->fieldsets[0]['fields'][15]['label']     = "Comission";
      $this->fieldsets[0]['fields'][15]['class']     = "";
      $this->fieldsets[0]['fields'][15]['options']   = "";
      $this->fieldsets[0]['fields'][15]['datatable'] = "";
			$this->fieldsets[0]['fields'][15]['dataquery'] = "";
			$this->fieldsets[0]['fields'][15]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][15]['datalabel'] = "";
			$this->fieldsets[0]['fields'][15]['datavalue'] = "";
			$this->fieldsets[0]['fields'][15]['values']    = "";
			$this->fieldsets[0]['fields'][15]['vertical']  = "";
      $this->fieldsets[0]['fields'][15]['defval']    = "";
      $this->fieldsets[0]['fields'][15]['click']     = "";
      $this->fieldsets[0]['fields'][15]['focus']     = "";
      $this->fieldsets[0]['fields'][15]['blur']      = "";
      $this->fieldsets[0]['fields'][15]['level']     = "";
      $this->fieldsets[0]['fields'][15]['change']    = "";
      $this->fieldsets[0]['fields'][15]['acl']       = "";

      $this->fieldsets[0]['fields'][16]['id']        = "default_caller_id ";
      $this->fieldsets[0]['fields'][16]['name']      = "default_caller_id ";
      $this->fieldsets[0]['fields'][16]['type']      = "list";
      $this->fieldsets[0]['fields'][16]['label']     = "Default Caller";
      $this->fieldsets[0]['fields'][16]['class']     = "";
      $this->fieldsets[0]['fields'][16]['options']   = "";
      $this->fieldsets[0]['fields'][16]['datatable'] = "";
			$this->fieldsets[0]['fields'][16]['dataquery'] = "";
			$this->fieldsets[0]['fields'][16]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][16]['datalabel'] = "";
			$this->fieldsets[0]['fields'][16]['datavalue'] = "";
			$this->fieldsets[0]['fields'][16]['values']    = "";
			$this->fieldsets[0]['fields'][16]['vertical']  = "";
      $this->fieldsets[0]['fields'][16]['defval']    = "";
      $this->fieldsets[0]['fields'][16]['click']     = "";
      $this->fieldsets[0]['fields'][16]['focus']     = "";
      $this->fieldsets[0]['fields'][16]['blur']      = "";
      $this->fieldsets[0]['fields'][16]['level']     = "";
      $this->fieldsets[0]['fields'][16]['change']    = "";
      $this->fieldsets[0]['fields'][16]['acl']       = "";

      $this->fieldsets[0]['fields'][17]['id']        = "permit_sms ";
      $this->fieldsets[0]['fields'][17]['name']      = "permit_sms ";
      $this->fieldsets[0]['fields'][17]['type']      = "";
      $this->fieldsets[0]['fields'][17]['label']     = "Permit SMS";
      $this->fieldsets[0]['fields'][17]['class']     = "";
      $this->fieldsets[0]['fields'][17]['options']   = "";
      $this->fieldsets[0]['fields'][17]['datatable'] = "";
			$this->fieldsets[0]['fields'][17]['dataquery'] = "";
			$this->fieldsets[0]['fields'][17]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][17]['datalabel'] = "";
			$this->fieldsets[0]['fields'][17]['datavalue'] = "";
			$this->fieldsets[0]['fields'][17]['values']    = "";
			$this->fieldsets[0]['fields'][17]['vertical']  = "";
      $this->fieldsets[0]['fields'][17]['defval']    = "";
      $this->fieldsets[0]['fields'][17]['click']     = "";
      $this->fieldsets[0]['fields'][17]['focus']     = "";
      $this->fieldsets[0]['fields'][17]['blur']      = "";
      $this->fieldsets[0]['fields'][17]['level']     = "";
      $this->fieldsets[0]['fields'][17]['change']    = "";
      $this->fieldsets[0]['fields'][17]['acl']       = "";

      $this->fieldsets[0]['fields'][18]['id']        = "sms_credits ";
      $this->fieldsets[0]['fields'][18]['name']      = "sms_credits ";
      $this->fieldsets[0]['fields'][18]['type']      = "";
      $this->fieldsets[0]['fields'][18]['label']     = "SMS Credits";
      $this->fieldsets[0]['fields'][18]['class']     = "";
      $this->fieldsets[0]['fields'][18]['options']   = "";
      $this->fieldsets[0]['fields'][18]['datatable'] = "";
			$this->fieldsets[0]['fields'][18]['dataquery'] = "";
			$this->fieldsets[0]['fields'][18]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][18]['datalabel'] = "";
			$this->fieldsets[0]['fields'][18]['datavalue'] = "";
			$this->fieldsets[0]['fields'][18]['values']    = "";
			$this->fieldsets[0]['fields'][18]['vertical']  = "";
      $this->fieldsets[0]['fields'][18]['defval']    = "";
      $this->fieldsets[0]['fields'][18]['click']     = "";
      $this->fieldsets[0]['fields'][18]['focus']     = "";
      $this->fieldsets[0]['fields'][18]['blur']      = "";
      $this->fieldsets[0]['fields'][18]['level']     = "";
      $this->fieldsets[0]['fields'][18]['change']    = "";
      $this->fieldsets[0]['fields'][18]['acl']       = "";

      $this->fieldsets[0]['fields'][19]['id']        = "preferred_language ";
      $this->fieldsets[0]['fields'][19]['name']      = "preferred_language ";
      $this->fieldsets[0]['fields'][19]['type']      = "";
      $this->fieldsets[0]['fields'][19]['label']     = "Preferred Language";
      $this->fieldsets[0]['fields'][19]['class']     = "";
      $this->fieldsets[0]['fields'][19]['options']   = "";
      $this->fieldsets[0]['fields'][19]['datatable'] = "";
			$this->fieldsets[0]['fields'][19]['dataquery'] = "";
			$this->fieldsets[0]['fields'][19]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][19]['datalabel'] = "";
			$this->fieldsets[0]['fields'][19]['datavalue'] = "";
			$this->fieldsets[0]['fields'][19]['values']    = "";
			$this->fieldsets[0]['fields'][19]['vertical']  = "";
      $this->fieldsets[0]['fields'][19]['defval']    = "EN";
      $this->fieldsets[0]['fields'][19]['click']     = "";
      $this->fieldsets[0]['fields'][19]['focus']     = "";
      $this->fieldsets[0]['fields'][19]['blur']      = "";
      $this->fieldsets[0]['fields'][19]['level']     = "";
      $this->fieldsets[0]['fields'][19]['change']    = "";
      $this->fieldsets[0]['fields'][19]['acl']       = "";

      $this->fieldsets[0]['fields'][20]['id']      = "submit";
      $this->fieldsets[0]['fields'][20]['name']    = "submit";
      $this->fieldsets[0]['fields'][20]['type']    = "submit";
      $this->fieldsets[0]['fields'][20]['label']   = "Save";
      $this->fieldsets[0]['fields'][20]['class']   = "";
      $this->fieldsets[0]['fields'][20]['options'] = "";
      $this->fieldsets[0]['fields'][20]['click']   = ""; 

      return parent::build($this->level);
    }

    public function show_edit($data){
      unset($this->options);
      unset($this->fieldsets);

      /*Define Form's general options*/
      $this->options['id']            = "EditUserForm";
      $this->options['name']          = "EditUserForm";
      $this->options['action']        = "javascript:proccess_information('NewUserForm', '', 'user', '');";
      $this->options['method']        = "POST";
      $this->options['class']         = "EditUserForm";
      $this->options['onsubmit']      = "";
      $this->options['tips']          = "All fields required.";
      $this->options['title']         = "All fields required.";

      /*Define fieldsets*/
      $this->fieldsets[0]['legend'] = "User Information [Edit]";

    
      $this->fieldsets[0]['fields'][0]['id']        = "id  ";
      $this->fieldsets[0]['fields'][0]['name']      = "id  ";
      $this->fieldsets[0]['fields'][0]['type']      = "list";
      $this->fieldsets[0]['fields'][0]['label']     = "Id  ";
      $this->fieldsets[0]['fields'][0]['class']     = "";
      $this->fieldsets[0]['fields'][0]['options']   = "";
      $this->fieldsets[0]['fields'][0]['datatable'] = "";
			$this->fieldsets[0]['fields'][0]['dataquery'] = "";
			$this->fieldsets[0]['fields'][0]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][0]['datalabel'] = "";
			$this->fieldsets[0]['fields'][0]['datavalue'] = "";
			$this->fieldsets[0]['fields'][0]['values']    = "";
      $this->fieldsets[0]['fields'][0]['defval']    = $data->id  ;
			$this->fieldsets[0]['fields'][0]['vertical']  = "";
      $this->fieldsets[0]['fields'][0]['click']     = "";
      $this->fieldsets[0]['fields'][0]['focus']     = "";
      $this->fieldsets[0]['fields'][0]['blur']      = "";
      $this->fieldsets[0]['fields'][0]['change']    = "";
      $this->fieldsets[0]['fields'][0]['level']     = "";
      $this->fieldsets[0]['fields'][0]['acl']       = "";

      $this->fieldsets[0]['fields'][1]['id']        = "partner_id ";
      $this->fieldsets[0]['fields'][1]['name']      = "partner_id ";
      $this->fieldsets[0]['fields'][1]['type']      = "list";
      $this->fieldsets[0]['fields'][1]['label']     = "Partner";
      $this->fieldsets[0]['fields'][1]['class']     = "";
      $this->fieldsets[0]['fields'][1]['options']   = "";
      $this->fieldsets[0]['fields'][1]['datatable'] = "";
			$this->fieldsets[0]['fields'][1]['dataquery'] = "";
			$this->fieldsets[0]['fields'][1]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][1]['datalabel'] = "";
			$this->fieldsets[0]['fields'][1]['datavalue'] = "";
			$this->fieldsets[0]['fields'][1]['values']    = "";
      $this->fieldsets[0]['fields'][1]['defval']    = $data->partner_id ;
			$this->fieldsets[0]['fields'][1]['vertical']  = "";
      $this->fieldsets[0]['fields'][1]['click']     = "";
      $this->fieldsets[0]['fields'][1]['focus']     = "";
      $this->fieldsets[0]['fields'][1]['blur']      = "";
      $this->fieldsets[0]['fields'][1]['change']    = "";
      $this->fieldsets[0]['fields'][1]['level']     = "";
      $this->fieldsets[0]['fields'][1]['acl']       = "";

      $this->fieldsets[0]['fields'][2]['id']        = "customer_id ";
      $this->fieldsets[0]['fields'][2]['name']      = "customer_id ";
      $this->fieldsets[0]['fields'][2]['type']      = "list";
      $this->fieldsets[0]['fields'][2]['label']     = "Customer";
      $this->fieldsets[0]['fields'][2]['class']     = "";
      $this->fieldsets[0]['fields'][2]['options']   = "";
      $this->fieldsets[0]['fields'][2]['datatable'] = "";
			$this->fieldsets[0]['fields'][2]['dataquery'] = "";
			$this->fieldsets[0]['fields'][2]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][2]['datalabel'] = "";
			$this->fieldsets[0]['fields'][2]['datavalue'] = "";
			$this->fieldsets[0]['fields'][2]['values']    = "";
      $this->fieldsets[0]['fields'][2]['defval']    = $data->customer_id ;
			$this->fieldsets[0]['fields'][2]['vertical']  = "";
      $this->fieldsets[0]['fields'][2]['click']     = "";
      $this->fieldsets[0]['fields'][2]['focus']     = "";
      $this->fieldsets[0]['fields'][2]['blur']      = "";
      $this->fieldsets[0]['fields'][2]['change']    = "";
      $this->fieldsets[0]['fields'][2]['level']     = "";
      $this->fieldsets[0]['fields'][2]['acl']       = "";

      $this->fieldsets[0]['fields'][3]['id']        = "company_id ";
      $this->fieldsets[0]['fields'][3]['name']      = "company_id ";
      $this->fieldsets[0]['fields'][3]['type']      = "list";
      $this->fieldsets[0]['fields'][3]['label']     = "Company";
      $this->fieldsets[0]['fields'][3]['class']     = "";
      $this->fieldsets[0]['fields'][3]['options']   = "";
      $this->fieldsets[0]['fields'][3]['datatable'] = "";
			$this->fieldsets[0]['fields'][3]['dataquery'] = "";
			$this->fieldsets[0]['fields'][3]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][3]['datalabel'] = "";
			$this->fieldsets[0]['fields'][3]['datavalue'] = "";
			$this->fieldsets[0]['fields'][3]['values']    = "";
      $this->fieldsets[0]['fields'][3]['defval']    = $data->company_id ;
			$this->fieldsets[0]['fields'][3]['vertical']  = "";
      $this->fieldsets[0]['fields'][3]['click']     = "";
      $this->fieldsets[0]['fields'][3]['focus']     = "";
      $this->fieldsets[0]['fields'][3]['blur']      = "";
      $this->fieldsets[0]['fields'][3]['change']    = "";
      $this->fieldsets[0]['fields'][3]['level']     = "";
      $this->fieldsets[0]['fields'][3]['acl']       = "";

      $this->fieldsets[0]['fields'][4]['id']        = "group_id ";
      $this->fieldsets[0]['fields'][4]['name']      = "group_id ";
      $this->fieldsets[0]['fields'][4]['type']      = "list";
      $this->fieldsets[0]['fields'][4]['label']     = "Group";
      $this->fieldsets[0]['fields'][4]['class']     = "";
      $this->fieldsets[0]['fields'][4]['options']   = "";
      $this->fieldsets[0]['fields'][4]['datatable'] = "";
			$this->fieldsets[0]['fields'][4]['dataquery'] = "";
			$this->fieldsets[0]['fields'][4]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][4]['datalabel'] = "";
			$this->fieldsets[0]['fields'][4]['datavalue'] = "";
			$this->fieldsets[0]['fields'][4]['values']    = "";
      $this->fieldsets[0]['fields'][4]['defval']    = $data->group_id ;
			$this->fieldsets[0]['fields'][4]['vertical']  = "";
      $this->fieldsets[0]['fields'][4]['click']     = "";
      $this->fieldsets[0]['fields'][4]['focus']     = "";
      $this->fieldsets[0]['fields'][4]['blur']      = "";
      $this->fieldsets[0]['fields'][4]['change']    = "";
      $this->fieldsets[0]['fields'][4]['level']     = "";
      $this->fieldsets[0]['fields'][4]['acl']       = "";

      $this->fieldsets[0]['fields'][5]['id']        = "first_name ";
      $this->fieldsets[0]['fields'][5]['name']      = "first_name ";
      $this->fieldsets[0]['fields'][5]['type']      = "text";
      $this->fieldsets[0]['fields'][5]['label']     = "First Name";
      $this->fieldsets[0]['fields'][5]['class']     = "";
      $this->fieldsets[0]['fields'][5]['options']   = "";
      $this->fieldsets[0]['fields'][5]['datatable'] = "";
			$this->fieldsets[0]['fields'][5]['dataquery'] = "";
			$this->fieldsets[0]['fields'][5]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][5]['datalabel'] = "";
			$this->fieldsets[0]['fields'][5]['datavalue'] = "";
			$this->fieldsets[0]['fields'][5]['values']    = "";
      $this->fieldsets[0]['fields'][5]['defval']    = $data->first_name ;
			$this->fieldsets[0]['fields'][5]['vertical']  = "";
      $this->fieldsets[0]['fields'][5]['click']     = "";
      $this->fieldsets[0]['fields'][5]['focus']     = "";
      $this->fieldsets[0]['fields'][5]['blur']      = "";
      $this->fieldsets[0]['fields'][5]['change']    = "";
      $this->fieldsets[0]['fields'][5]['level']     = "";
      $this->fieldsets[0]['fields'][5]['acl']       = "";

      $this->fieldsets[0]['fields'][6]['id']        = "last_name ";
      $this->fieldsets[0]['fields'][6]['name']      = "last_name ";
      $this->fieldsets[0]['fields'][6]['type']      = "text";
      $this->fieldsets[0]['fields'][6]['label']     = "Last Name";
      $this->fieldsets[0]['fields'][6]['class']     = "";
      $this->fieldsets[0]['fields'][6]['options']   = "";
      $this->fieldsets[0]['fields'][6]['datatable'] = "";
			$this->fieldsets[0]['fields'][6]['dataquery'] = "";
			$this->fieldsets[0]['fields'][6]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][6]['datalabel'] = "";
			$this->fieldsets[0]['fields'][6]['datavalue'] = "";
			$this->fieldsets[0]['fields'][6]['values']    = "";
      $this->fieldsets[0]['fields'][6]['defval']    = $data->last_name ;
			$this->fieldsets[0]['fields'][6]['vertical']  = "";
      $this->fieldsets[0]['fields'][6]['click']     = "";
      $this->fieldsets[0]['fields'][6]['focus']     = "";
      $this->fieldsets[0]['fields'][6]['blur']      = "";
      $this->fieldsets[0]['fields'][6]['change']    = "";
      $this->fieldsets[0]['fields'][6]['level']     = "";
      $this->fieldsets[0]['fields'][6]['acl']       = "";

      $this->fieldsets[0]['fields'][7]['id']        = "contact_id ";
      $this->fieldsets[0]['fields'][7]['name']      = "contact_id ";
      $this->fieldsets[0]['fields'][7]['type']      = "list";
      $this->fieldsets[0]['fields'][7]['label']     = "Contact";
      $this->fieldsets[0]['fields'][7]['class']     = "";
      $this->fieldsets[0]['fields'][7]['options']   = "";
      $this->fieldsets[0]['fields'][7]['datatable'] = "";
			$this->fieldsets[0]['fields'][7]['dataquery'] = "";
			$this->fieldsets[0]['fields'][7]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][7]['datalabel'] = "";
			$this->fieldsets[0]['fields'][7]['datavalue'] = "";
			$this->fieldsets[0]['fields'][7]['values']    = "";
      $this->fieldsets[0]['fields'][7]['defval']    = $data->contact_id ;
			$this->fieldsets[0]['fields'][7]['vertical']  = "";
      $this->fieldsets[0]['fields'][7]['click']     = "";
      $this->fieldsets[0]['fields'][7]['focus']     = "";
      $this->fieldsets[0]['fields'][7]['blur']      = "";
      $this->fieldsets[0]['fields'][7]['change']    = "";
      $this->fieldsets[0]['fields'][7]['level']     = "";
      $this->fieldsets[0]['fields'][7]['acl']       = "";

      $this->fieldsets[0]['fields'][8]['id']        = "username ";
      $this->fieldsets[0]['fields'][8]['name']      = "username ";
      $this->fieldsets[0]['fields'][8]['type']      = "text";
      $this->fieldsets[0]['fields'][8]['label']     = "User Name";
      $this->fieldsets[0]['fields'][8]['class']     = "";
      $this->fieldsets[0]['fields'][8]['options']   = "";
      $this->fieldsets[0]['fields'][8]['datatable'] = "";
			$this->fieldsets[0]['fields'][8]['dataquery'] = "";
			$this->fieldsets[0]['fields'][8]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][8]['datalabel'] = "";
			$this->fieldsets[0]['fields'][8]['datavalue'] = "";
			$this->fieldsets[0]['fields'][8]['values']    = "";
      $this->fieldsets[0]['fields'][8]['defval']    = $data->username ;
			$this->fieldsets[0]['fields'][8]['vertical']  = "";
      $this->fieldsets[0]['fields'][8]['click']     = "";
      $this->fieldsets[0]['fields'][8]['focus']     = "";
      $this->fieldsets[0]['fields'][8]['blur']      = "";
      $this->fieldsets[0]['fields'][8]['change']    = "";
      $this->fieldsets[0]['fields'][8]['level']     = "";
      $this->fieldsets[0]['fields'][8]['acl']       = "";

      $this->fieldsets[0]['fields'][9]['id']        = "password ";
      $this->fieldsets[0]['fields'][9]['name']      = "password ";
      $this->fieldsets[0]['fields'][9]['type']      = "password";
      $this->fieldsets[0]['fields'][9]['label']     = "Password";
      $this->fieldsets[0]['fields'][9]['class']     = "";
      $this->fieldsets[0]['fields'][9]['options']   = "";
      $this->fieldsets[0]['fields'][9]['datatable'] = "";
			$this->fieldsets[0]['fields'][9]['dataquery'] = "";
			$this->fieldsets[0]['fields'][9]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][9]['datalabel'] = "";
			$this->fieldsets[0]['fields'][9]['datavalue'] = "";
			$this->fieldsets[0]['fields'][9]['values']    = "";
      $this->fieldsets[0]['fields'][9]['defval']    = $data->password ;
			$this->fieldsets[0]['fields'][9]['vertical']  = "";
      $this->fieldsets[0]['fields'][9]['click']     = "";
      $this->fieldsets[0]['fields'][9]['focus']     = "";
      $this->fieldsets[0]['fields'][9]['blur']      = "";
      $this->fieldsets[0]['fields'][9]['change']    = "";
      $this->fieldsets[0]['fields'][9]['level']     = "";
      $this->fieldsets[0]['fields'][9]['acl']       = "";

      $this->fieldsets[0]['fields'][10]['id']        = "access_level ";
      $this->fieldsets[0]['fields'][10]['name']      = "access_level ";
      $this->fieldsets[0]['fields'][10]['type']      = "";
      $this->fieldsets[0]['fields'][10]['label']     = "Access Level";
      $this->fieldsets[0]['fields'][10]['class']     = "";
      $this->fieldsets[0]['fields'][10]['options']   = "";
      $this->fieldsets[0]['fields'][10]['datatable'] = "";
			$this->fieldsets[0]['fields'][10]['dataquery'] = "";
			$this->fieldsets[0]['fields'][10]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][10]['datalabel'] = "";
			$this->fieldsets[0]['fields'][10]['datavalue'] = "";
			$this->fieldsets[0]['fields'][10]['values']    = "";
      $this->fieldsets[0]['fields'][10]['defval']    = $data->access_level ;
			$this->fieldsets[0]['fields'][10]['vertical']  = "";
      $this->fieldsets[0]['fields'][10]['click']     = "";
      $this->fieldsets[0]['fields'][10]['focus']     = "";
      $this->fieldsets[0]['fields'][10]['blur']      = "";
      $this->fieldsets[0]['fields'][10]['change']    = "";
      $this->fieldsets[0]['fields'][10]['level']     = "";
      $this->fieldsets[0]['fields'][10]['acl']       = "";

      $this->fieldsets[0]['fields'][11]['id']        = "pin ";
      $this->fieldsets[0]['fields'][11]['name']      = "pin ";
      $this->fieldsets[0]['fields'][11]['type']      = "text";
      $this->fieldsets[0]['fields'][11]['label']     = "PIN";
      $this->fieldsets[0]['fields'][11]['class']     = "";
      $this->fieldsets[0]['fields'][11]['options']   = "";
      $this->fieldsets[0]['fields'][11]['datatable'] = "";
			$this->fieldsets[0]['fields'][11]['dataquery'] = "";
			$this->fieldsets[0]['fields'][11]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][11]['datalabel'] = "";
			$this->fieldsets[0]['fields'][11]['datavalue'] = "";
			$this->fieldsets[0]['fields'][11]['values']    = "";
      $this->fieldsets[0]['fields'][11]['defval']    = $data->pin ;
			$this->fieldsets[0]['fields'][11]['vertical']  = "";
      $this->fieldsets[0]['fields'][11]['click']     = "";
      $this->fieldsets[0]['fields'][11]['focus']     = "";
      $this->fieldsets[0]['fields'][11]['blur']      = "";
      $this->fieldsets[0]['fields'][11]['change']    = "";
      $this->fieldsets[0]['fields'][11]['level']     = "";
      $this->fieldsets[0]['fields'][11]['acl']       = "";

      $this->fieldsets[0]['fields'][12]['id']        = "status ";
      $this->fieldsets[0]['fields'][12]['name']      = "status ";
      $this->fieldsets[0]['fields'][12]['type']      = "";
      $this->fieldsets[0]['fields'][12]['label']     = "Status";
      $this->fieldsets[0]['fields'][12]['class']     = "";
      $this->fieldsets[0]['fields'][12]['options']   = "";
      $this->fieldsets[0]['fields'][12]['datatable'] = "";
			$this->fieldsets[0]['fields'][12]['dataquery'] = "";
			$this->fieldsets[0]['fields'][12]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][12]['datalabel'] = "";
			$this->fieldsets[0]['fields'][12]['datavalue'] = "";
			$this->fieldsets[0]['fields'][12]['values']    = "";
      $this->fieldsets[0]['fields'][12]['defval']    = $data->status ;
			$this->fieldsets[0]['fields'][12]['vertical']  = "";
      $this->fieldsets[0]['fields'][12]['click']     = "";
      $this->fieldsets[0]['fields'][12]['focus']     = "";
      $this->fieldsets[0]['fields'][12]['blur']      = "";
      $this->fieldsets[0]['fields'][12]['change']    = "";
      $this->fieldsets[0]['fields'][12]['level']     = "";
      $this->fieldsets[0]['fields'][12]['acl']       = "";

      $this->fieldsets[0]['fields'][13]['id']        = "time_zone ";
      $this->fieldsets[0]['fields'][13]['name']      = "time_zone ";
      $this->fieldsets[0]['fields'][13]['type']      = "list";
      $this->fieldsets[0]['fields'][13]['label']     = "Time Zone";
      $this->fieldsets[0]['fields'][13]['class']     = "";
      $this->fieldsets[0]['fields'][13]['options']   = "";
      $this->fieldsets[0]['fields'][13]['datatable'] = "timezone";
			$this->fieldsets[0]['fields'][13]['dataquery'] = "zone!='' ORDER BY zone DESC";
			$this->fieldsets[0]['fields'][13]['datasort'] 	= "zone";
			$this->fieldsets[0]['fields'][13]['datalabel'] = "zone";
			$this->fieldsets[0]['fields'][13]['datavalue'] = "zone";
			$this->fieldsets[0]['fields'][13]['values']    = "zone";
      $this->fieldsets[0]['fields'][13]['defval']    = $data->time_zone ;
			$this->fieldsets[0]['fields'][13]['vertical']  = "";
      $this->fieldsets[0]['fields'][13]['click']     = "";
      $this->fieldsets[0]['fields'][13]['focus']     = "";
      $this->fieldsets[0]['fields'][13]['blur']      = "";
      $this->fieldsets[0]['fields'][13]['change']    = "";
      $this->fieldsets[0]['fields'][13]['level']     = "";
      $this->fieldsets[0]['fields'][13]['acl']       = "";

      $this->fieldsets[0]['fields'][14]['id']        = "type ";
      $this->fieldsets[0]['fields'][14]['name']      = "type ";
      $this->fieldsets[0]['fields'][14]['type']      = "";
      $this->fieldsets[0]['fields'][14]['label']     = "Type ";
      $this->fieldsets[0]['fields'][14]['class']     = "";
      $this->fieldsets[0]['fields'][14]['options']   = "";
      $this->fieldsets[0]['fields'][14]['datatable'] = "";
			$this->fieldsets[0]['fields'][14]['dataquery'] = "";
			$this->fieldsets[0]['fields'][14]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][14]['datalabel'] = "";
			$this->fieldsets[0]['fields'][14]['datavalue'] = "";
			$this->fieldsets[0]['fields'][14]['values']    = "";
      $this->fieldsets[0]['fields'][14]['defval']    = $data->type ;
			$this->fieldsets[0]['fields'][14]['vertical']  = "";
      $this->fieldsets[0]['fields'][14]['click']     = "";
      $this->fieldsets[0]['fields'][14]['focus']     = "";
      $this->fieldsets[0]['fields'][14]['blur']      = "";
      $this->fieldsets[0]['fields'][14]['change']    = "";
      $this->fieldsets[0]['fields'][14]['level']     = "";
      $this->fieldsets[0]['fields'][14]['acl']       = "";

      $this->fieldsets[0]['fields'][15]['id']        = "comission_id ";
      $this->fieldsets[0]['fields'][15]['name']      = "comission_id ";
      $this->fieldsets[0]['fields'][15]['type']      = "list";
      $this->fieldsets[0]['fields'][15]['label']     = "Comission";
      $this->fieldsets[0]['fields'][15]['class']     = "";
      $this->fieldsets[0]['fields'][15]['options']   = "";
      $this->fieldsets[0]['fields'][15]['datatable'] = "";
			$this->fieldsets[0]['fields'][15]['dataquery'] = "";
			$this->fieldsets[0]['fields'][15]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][15]['datalabel'] = "";
			$this->fieldsets[0]['fields'][15]['datavalue'] = "";
			$this->fieldsets[0]['fields'][15]['values']    = "";
      $this->fieldsets[0]['fields'][15]['defval']    = $data->comission_id ;
			$this->fieldsets[0]['fields'][15]['vertical']  = "";
      $this->fieldsets[0]['fields'][15]['click']     = "";
      $this->fieldsets[0]['fields'][15]['focus']     = "";
      $this->fieldsets[0]['fields'][15]['blur']      = "";
      $this->fieldsets[0]['fields'][15]['change']    = "";
      $this->fieldsets[0]['fields'][15]['level']     = "";
      $this->fieldsets[0]['fields'][15]['acl']       = "";

      $this->fieldsets[0]['fields'][16]['id']        = "default_caller_id ";
      $this->fieldsets[0]['fields'][16]['name']      = "default_caller_id ";
      $this->fieldsets[0]['fields'][16]['type']      = "list";
      $this->fieldsets[0]['fields'][16]['label']     = "Default Caller";
      $this->fieldsets[0]['fields'][16]['class']     = "";
      $this->fieldsets[0]['fields'][16]['options']   = "";
      $this->fieldsets[0]['fields'][16]['datatable'] = "";
			$this->fieldsets[0]['fields'][16]['dataquery'] = "";
			$this->fieldsets[0]['fields'][16]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][16]['datalabel'] = "";
			$this->fieldsets[0]['fields'][16]['datavalue'] = "";
			$this->fieldsets[0]['fields'][16]['values']    = "";
      $this->fieldsets[0]['fields'][16]['defval']    = $data->default_caller_id ;
			$this->fieldsets[0]['fields'][16]['vertical']  = "";
      $this->fieldsets[0]['fields'][16]['click']     = "";
      $this->fieldsets[0]['fields'][16]['focus']     = "";
      $this->fieldsets[0]['fields'][16]['blur']      = "";
      $this->fieldsets[0]['fields'][16]['change']    = "";
      $this->fieldsets[0]['fields'][16]['level']     = "";
      $this->fieldsets[0]['fields'][16]['acl']       = "";

      $this->fieldsets[0]['fields'][17]['id']        = "permit_sms ";
      $this->fieldsets[0]['fields'][17]['name']      = "permit_sms ";
      $this->fieldsets[0]['fields'][17]['type']      = "";
      $this->fieldsets[0]['fields'][17]['label']     = "Permit SMS";
      $this->fieldsets[0]['fields'][17]['class']     = "";
      $this->fieldsets[0]['fields'][17]['options']   = "";
      $this->fieldsets[0]['fields'][17]['datatable'] = "";
			$this->fieldsets[0]['fields'][17]['dataquery'] = "";
			$this->fieldsets[0]['fields'][17]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][17]['datalabel'] = "";
			$this->fieldsets[0]['fields'][17]['datavalue'] = "";
			$this->fieldsets[0]['fields'][17]['values']    = "";
      $this->fieldsets[0]['fields'][17]['defval']    = $data->permit_sms ;
			$this->fieldsets[0]['fields'][17]['vertical']  = "";
      $this->fieldsets[0]['fields'][17]['click']     = "";
      $this->fieldsets[0]['fields'][17]['focus']     = "";
      $this->fieldsets[0]['fields'][17]['blur']      = "";
      $this->fieldsets[0]['fields'][17]['change']    = "";
      $this->fieldsets[0]['fields'][17]['level']     = "";
      $this->fieldsets[0]['fields'][17]['acl']       = "";

      $this->fieldsets[0]['fields'][18]['id']        = "sms_credits ";
      $this->fieldsets[0]['fields'][18]['name']      = "sms_credits ";
      $this->fieldsets[0]['fields'][18]['type']      = "";
      $this->fieldsets[0]['fields'][18]['label']     = "SMS Credits";
      $this->fieldsets[0]['fields'][18]['class']     = "";
      $this->fieldsets[0]['fields'][18]['options']   = "";
      $this->fieldsets[0]['fields'][18]['datatable'] = "";
			$this->fieldsets[0]['fields'][18]['dataquery'] = "";
			$this->fieldsets[0]['fields'][18]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][18]['datalabel'] = "";
			$this->fieldsets[0]['fields'][18]['datavalue'] = "";
			$this->fieldsets[0]['fields'][18]['values']    = "";
      $this->fieldsets[0]['fields'][18]['defval']    = $data->sms_credits ;
			$this->fieldsets[0]['fields'][18]['vertical']  = "";
      $this->fieldsets[0]['fields'][18]['click']     = "";
      $this->fieldsets[0]['fields'][18]['focus']     = "";
      $this->fieldsets[0]['fields'][18]['blur']      = "";
      $this->fieldsets[0]['fields'][18]['change']    = "";
      $this->fieldsets[0]['fields'][18]['level']     = "";
      $this->fieldsets[0]['fields'][18]['acl']       = "";

      $this->fieldsets[0]['fields'][19]['id']        = "preferred_language ";
      $this->fieldsets[0]['fields'][19]['name']      = "preferred_language ";
      $this->fieldsets[0]['fields'][19]['type']      = "";
      $this->fieldsets[0]['fields'][19]['label']     = "Preferred Language";
      $this->fieldsets[0]['fields'][19]['class']     = "";
      $this->fieldsets[0]['fields'][19]['options']   = "";
      $this->fieldsets[0]['fields'][19]['datatable'] = "";
			$this->fieldsets[0]['fields'][19]['dataquery'] = "";
			$this->fieldsets[0]['fields'][19]['datasort'] 	= "";
			$this->fieldsets[0]['fields'][19]['datalabel'] = "";
			$this->fieldsets[0]['fields'][19]['datavalue'] = "";
			$this->fieldsets[0]['fields'][19]['values']    = "";
      $this->fieldsets[0]['fields'][19]['defval']    = $data->preferred_language ;
			$this->fieldsets[0]['fields'][19]['vertical']  = "";
      $this->fieldsets[0]['fields'][19]['click']     = "";
      $this->fieldsets[0]['fields'][19]['focus']     = "";
      $this->fieldsets[0]['fields'][19]['blur']      = "";
      $this->fieldsets[0]['fields'][19]['change']    = "";
      $this->fieldsets[0]['fields'][19]['level']     = "";
      $this->fieldsets[0]['fields'][19]['acl']       = "";

      $this->fieldsets[0]['fields'][20]['id']      = "submit";
      $this->fieldsets[0]['fields'][20]['name']    = "submit";
      $this->fieldsets[0]['fields'][20]['type']    = "submit";
      $this->fieldsets[0]['fields'][20]['label']   = "Save";
      $this->fieldsets[0]['fields'][20]['class']   = "";
      $this->fieldsets[0]['fields'][20]['options'] = "";
      $this->fieldsets[0]['fields'][20]['click']   = ""; 

      return parent::build($this->level);
    } 

    public function show_view($data){
      unset($this->options);
      unset($this->fieldsets);

      /*Define Form's general options*/
      $this->options['id']            = "ViewUserForm";
      $this->options['name']          = "ViewUserForm";
      $this->options['action']        = "";
      $this->options['method']        = "POST";
      $this->options['class']         = "ViewUserForm";
      $this->options['onsubmit']      = "";
      $this->options['title']         = "All fields required.";

      /*Define fieldsets*/
      $this->fieldsets[0]['legend'] = "User Information [View]";

    
      $this->fieldsets[0]['fields'][0]['id']      = "id  ";
      $this->fieldsets[0]['fields'][0]['name']    = "id  ";
      $this->fieldsets[0]['fields'][0]['type']    = "readonly";
      $this->fieldsets[0]['fields'][0]['label']   = "Id  ";
      $this->fieldsets[0]['fields'][0]['defval']  = $data->id  ;
      $this->fieldsets[0]['fields'][0]['level']   = "";
      $this->fieldsets[0]['fields'][0]['acl']     = "";

      $this->fieldsets[0]['fields'][1]['id']      = "partner_id ";
      $this->fieldsets[0]['fields'][1]['name']    = "partner_id ";
      $this->fieldsets[0]['fields'][1]['type']    = "readonly";
      $this->fieldsets[0]['fields'][1]['label']   = "Partner";
      $this->fieldsets[0]['fields'][1]['defval']  = $data->partner_id ;
      $this->fieldsets[0]['fields'][1]['level']   = "";
      $this->fieldsets[0]['fields'][1]['acl']     = "";

      $this->fieldsets[0]['fields'][2]['id']      = "customer_id ";
      $this->fieldsets[0]['fields'][2]['name']    = "customer_id ";
      $this->fieldsets[0]['fields'][2]['type']    = "readonly";
      $this->fieldsets[0]['fields'][2]['label']   = "Customer";
      $this->fieldsets[0]['fields'][2]['defval']  = $data->customer_id ;
      $this->fieldsets[0]['fields'][2]['level']   = "";
      $this->fieldsets[0]['fields'][2]['acl']     = "";

      $this->fieldsets[0]['fields'][3]['id']      = "company_id ";
      $this->fieldsets[0]['fields'][3]['name']    = "company_id ";
      $this->fieldsets[0]['fields'][3]['type']    = "readonly";
      $this->fieldsets[0]['fields'][3]['label']   = "Company";
      $this->fieldsets[0]['fields'][3]['defval']  = $data->company_id ;
      $this->fieldsets[0]['fields'][3]['level']   = "";
      $this->fieldsets[0]['fields'][3]['acl']     = "";

      $this->fieldsets[0]['fields'][4]['id']      = "group_id ";
      $this->fieldsets[0]['fields'][4]['name']    = "group_id ";
      $this->fieldsets[0]['fields'][4]['type']    = "readonly";
      $this->fieldsets[0]['fields'][4]['label']   = "Group";
      $this->fieldsets[0]['fields'][4]['defval']  = $data->group_id ;
      $this->fieldsets[0]['fields'][4]['level']   = "";
      $this->fieldsets[0]['fields'][4]['acl']     = "";

      $this->fieldsets[0]['fields'][5]['id']      = "first_name ";
      $this->fieldsets[0]['fields'][5]['name']    = "first_name ";
      $this->fieldsets[0]['fields'][5]['type']    = "readonly";
      $this->fieldsets[0]['fields'][5]['label']   = "First Name";
      $this->fieldsets[0]['fields'][5]['defval']  = $data->first_name ;
      $this->fieldsets[0]['fields'][5]['level']   = "";
      $this->fieldsets[0]['fields'][5]['acl']     = "";

      $this->fieldsets[0]['fields'][6]['id']      = "last_name ";
      $this->fieldsets[0]['fields'][6]['name']    = "last_name ";
      $this->fieldsets[0]['fields'][6]['type']    = "readonly";
      $this->fieldsets[0]['fields'][6]['label']   = "Last Name";
      $this->fieldsets[0]['fields'][6]['defval']  = $data->last_name ;
      $this->fieldsets[0]['fields'][6]['level']   = "";
      $this->fieldsets[0]['fields'][6]['acl']     = "";

      $this->fieldsets[0]['fields'][7]['id']      = "contact_id ";
      $this->fieldsets[0]['fields'][7]['name']    = "contact_id ";
      $this->fieldsets[0]['fields'][7]['type']    = "readonly";
      $this->fieldsets[0]['fields'][7]['label']   = "Contact";
      $this->fieldsets[0]['fields'][7]['defval']  = $data->contact_id ;
      $this->fieldsets[0]['fields'][7]['level']   = "";
      $this->fieldsets[0]['fields'][7]['acl']     = "";

      $this->fieldsets[0]['fields'][8]['id']      = "username ";
      $this->fieldsets[0]['fields'][8]['name']    = "username ";
      $this->fieldsets[0]['fields'][8]['type']    = "readonly";
      $this->fieldsets[0]['fields'][8]['label']   = "User Name";
      $this->fieldsets[0]['fields'][8]['defval']  = $data->username ;
      $this->fieldsets[0]['fields'][8]['level']   = "";
      $this->fieldsets[0]['fields'][8]['acl']     = "";

      $this->fieldsets[0]['fields'][9]['id']      = "password ";
      $this->fieldsets[0]['fields'][9]['name']    = "password ";
      $this->fieldsets[0]['fields'][9]['type']    = "readonly";
      $this->fieldsets[0]['fields'][9]['label']   = "Password";
      $this->fieldsets[0]['fields'][9]['defval']  = $data->password ;
      $this->fieldsets[0]['fields'][9]['level']   = "";
      $this->fieldsets[0]['fields'][9]['acl']     = "";

      $this->fieldsets[0]['fields'][10]['id']      = "access_level ";
      $this->fieldsets[0]['fields'][10]['name']    = "access_level ";
      $this->fieldsets[0]['fields'][10]['type']    = "readonly";
      $this->fieldsets[0]['fields'][10]['label']   = "Access Level";
      $this->fieldsets[0]['fields'][10]['defval']  = $data->access_level ;
      $this->fieldsets[0]['fields'][10]['level']   = "";
      $this->fieldsets[0]['fields'][10]['acl']     = "";

      $this->fieldsets[0]['fields'][11]['id']      = "pin ";
      $this->fieldsets[0]['fields'][11]['name']    = "pin ";
      $this->fieldsets[0]['fields'][11]['type']    = "readonly";
      $this->fieldsets[0]['fields'][11]['label']   = "PIN";
      $this->fieldsets[0]['fields'][11]['defval']  = $data->pin ;
      $this->fieldsets[0]['fields'][11]['level']   = "";
      $this->fieldsets[0]['fields'][11]['acl']     = "";

      $this->fieldsets[0]['fields'][12]['id']      = "status ";
      $this->fieldsets[0]['fields'][12]['name']    = "status ";
      $this->fieldsets[0]['fields'][12]['type']    = "readonly";
      $this->fieldsets[0]['fields'][12]['label']   = "Status";
      $this->fieldsets[0]['fields'][12]['defval']  = $data->status ;
      $this->fieldsets[0]['fields'][12]['level']   = "";
      $this->fieldsets[0]['fields'][12]['acl']     = "";

      $this->fieldsets[0]['fields'][13]['id']      = "time_zone ";
      $this->fieldsets[0]['fields'][13]['name']    = "time_zone ";
      $this->fieldsets[0]['fields'][13]['type']    = "readonly";
      $this->fieldsets[0]['fields'][13]['label']   = "Time Zone";
      $this->fieldsets[0]['fields'][13]['defval']  = $data->time_zone ;
      $this->fieldsets[0]['fields'][13]['level']   = "";
      $this->fieldsets[0]['fields'][13]['acl']     = "";

      $this->fieldsets[0]['fields'][14]['id']      = "type ";
      $this->fieldsets[0]['fields'][14]['name']    = "type ";
      $this->fieldsets[0]['fields'][14]['type']    = "readonly";
      $this->fieldsets[0]['fields'][14]['label']   = "Type ";
      $this->fieldsets[0]['fields'][14]['defval']  = $data->type ;
      $this->fieldsets[0]['fields'][14]['level']   = "";
      $this->fieldsets[0]['fields'][14]['acl']     = "";

      $this->fieldsets[0]['fields'][15]['id']      = "comission_id ";
      $this->fieldsets[0]['fields'][15]['name']    = "comission_id ";
      $this->fieldsets[0]['fields'][15]['type']    = "readonly";
      $this->fieldsets[0]['fields'][15]['label']   = "Comission";
      $this->fieldsets[0]['fields'][15]['defval']  = $data->comission_id ;
      $this->fieldsets[0]['fields'][15]['level']   = "";
      $this->fieldsets[0]['fields'][15]['acl']     = "";

      $this->fieldsets[0]['fields'][16]['id']      = "default_caller_id ";
      $this->fieldsets[0]['fields'][16]['name']    = "default_caller_id ";
      $this->fieldsets[0]['fields'][16]['type']    = "readonly";
      $this->fieldsets[0]['fields'][16]['label']   = "Default Caller";
      $this->fieldsets[0]['fields'][16]['defval']  = $data->default_caller_id ;
      $this->fieldsets[0]['fields'][16]['level']   = "";
      $this->fieldsets[0]['fields'][16]['acl']     = "";

      $this->fieldsets[0]['fields'][17]['id']      = "permit_sms ";
      $this->fieldsets[0]['fields'][17]['name']    = "permit_sms ";
      $this->fieldsets[0]['fields'][17]['type']    = "readonly";
      $this->fieldsets[0]['fields'][17]['label']   = "Permit SMS";
      $this->fieldsets[0]['fields'][17]['defval']  = $data->permit_sms ;
      $this->fieldsets[0]['fields'][17]['level']   = "";
      $this->fieldsets[0]['fields'][17]['acl']     = "";

      $this->fieldsets[0]['fields'][18]['id']      = "sms_credits ";
      $this->fieldsets[0]['fields'][18]['name']    = "sms_credits ";
      $this->fieldsets[0]['fields'][18]['type']    = "readonly";
      $this->fieldsets[0]['fields'][18]['label']   = "SMS Credits";
      $this->fieldsets[0]['fields'][18]['defval']  = $data->sms_credits ;
      $this->fieldsets[0]['fields'][18]['level']   = "";
      $this->fieldsets[0]['fields'][18]['acl']     = "";

      $this->fieldsets[0]['fields'][19]['id']      = "preferred_language ";
      $this->fieldsets[0]['fields'][19]['name']    = "preferred_language ";
      $this->fieldsets[0]['fields'][19]['type']    = "readonly";
      $this->fieldsets[0]['fields'][19]['label']   = "Preferred Language";
      $this->fieldsets[0]['fields'][19]['defval']  = $data->preferred_language ;
      $this->fieldsets[0]['fields'][19]['level']   = "";
      $this->fieldsets[0]['fields'][19]['acl']     = "";


      return parent::build($this->level);
    } 
  }
?>
