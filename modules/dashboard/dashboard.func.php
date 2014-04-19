<?php
/**
 * Function dashboard_home
 */
function dashboard_home() {

  global $twig;

	$render = array(
	  'page_title' => 'Dashboard',
		'page_subtitle' => 'Widgets',
		'content' => '<div id="myfirstchart"></div>',
  );
	$template = $twig->loadTemplate('content.html');
  $template->display($render);
}

//function dashboard_home() {
//  // Checks if there is a system update
//	/*
//	 * Check if the system is enabled to do software update on system_control table
//	 * */
//  if($_SESSION['log_access_level']>70){
//    //$content  = check_update_home();
//  }
//  // Dashboard Configuration according logged user personal preferences
//  $content .= '<span class="dashboard-setup-title closed">Dashboard Setup</span><div id="dashboard-setup">' . dashboard_setup_form($_SESSION['dash_type']) . '</div>';
//  // Load the dashboard widgets according pre cofigured by the logged user
//  $content .= '<div id="dashboard-widgets">' . dashboard_widgets($_SESSION['dash_type']) . '</div>';
//	//$content .= server_dashboard();
//  return $title . $content;
//}

/*
 * Build the widgets
 */
function dashboard_widgets($dashboard_type) {
  $user = new User();
  $user->load_single('id = ' . $_SESSION['log_id']);
  //print_debug($user);
  $arr[0][0] = 1;
  $arr[0][1] = 4;
  $arr[1][0] = 3;
  $arr[2][0] = 2;
//  $user->dashboard_1 = $arr;
//  $user->update('id = ' . $_SESSION['log_id']);
  $dash_type = 'dashboard_' . $dashboard_type;
  $ct = 1;
  if ($user->$dash_type) {
    // Build the dashboard accordingly the dashboard type and if there is something recorded in his desktop
    $user_widgets = $user->$dash_type;
    if ($user_widgets) {
      for($i=0; $i<count($user_widgets); $i++) {
        for($x=0; $x<count($user_widgets[$i]); $x++){
          $widget = new DashboardWidgets();
          $widget->load_single("id = '{$user_widgets[$i][$x]}' AND dashboard_type='{$dashboard_type}'");
          if ($widget->enabled) {
            $content[$i] .= '<li id="widget_' . $widget->id . '" class="' . $widget->class . '">
                             <h1>' . $widget->title . '</h1>
                             <div id="widget_' . $widget->id . '_content" class="content">' . call_user_func($widget->widget_function , $user_widgets[$i][$x]) . '
                             </div>
                             <div class="dashboard-delete-widget" onclick="dashboard_delete_widget(\'widget_' . $widget->id . '\');" title="Close" alt="Close"></div>
                             </li>';
          }
        }
      }
    }
  }else{
    // Return the message to configure his/her dashboard
  //  $content = 'Maybe you are new here, don\'t forget to Setup your Dashboard<br/>Click on the link on the right link "Dashboard Setup" and choose which items you want to see on your dashboard.';
  }

  $content ='<ul id="sortable1" class="droptrue">
    '.$content[0].'
  </ul>

  <ul id="sortable2" class="dropfalse">
    '.$content[1].'
  </ul>

  <ul id="sortable3" class="droptrue">
    '.$content[2].'
  </ul>
  <form id="dashboard-form" name="dashboard-form">
    <input type="hidden" name="dashboard_type" id="dashboard_type" value="' . $dashboard_type . '">
  </form>';
  return $content;
}

function change_dup_num_status($data){
	$system = new SystemControl();
	$system->load_single("id>0 LIMIT 1");
	if($data['current_status']){
		$system->remove_duplicated_numbers = 0;
		$response = '<img src="themes/moonlight/images/off-dash-button.png" onclick="proccess_information(null, \'change_dup_num_status\', \'dashboard\', null, \'current_status|0\', null, \'dup-num\');">';
	}else{
		$system->remove_duplicated_numbers = 1;
		$response = '<img src="themes/moonlight/images/on-dash-button.png" onclick="proccess_information(null, \'change_dup_num_status\', \'dashboard\', null, \'current_status|1\', null, \'dup-num\');">';
	}
	$system->update("id='{$system->id}'");
	return $response;
}

function change_temp_dial_list($data){
	$system = new SystemControl();
	$system->load_single("id>0 LIMIT 1");
	if($data['current_status']){
		$system->remove_temporary_dial_list = 0;
		$response = '<img src="themes/moonlight/images/off-dash-button.png" onclick="proccess_information(null, \'change_temp_dial_list\', \'dashboard\', null, \'current_status|0\', null, \'tmp-list\');">';
	}else{
		$system->remove_temporary_dial_list = 1;
		$response = '<img src="themes/moonlight/images/on-dash-button.png" onclick="proccess_information(null, \'change_temp_dial_list\', \'dashboard\', null, \'current_status|1\', null, \'tmp-list\');">';
	}
	$system->update("id='{$system->id}'");
	return $response;
}

function dashboard_call_graph(){
	$current_month = date('m');
	$current_month_wr = strtolower(date('M'));
	if($current_month=="01"){
		$past_month = "12";
	}else{
		$past_month = $current_month - 1;
	}
  $cdr_current = new DataManager();
  $cdr_current->dm_load_custom_list("SELECT COUNT(id) as amount, disposition FROM cdr.".$current_month."_".$current_month_wr." GROUP BY disposition", 'ASSOC');
  if($cdr_current->affected>0){

	}
	//return 'current month is '.$current_month.' / past month is '.$past_month;
}

/**
 * Build the graphs (pies) to display on Dialer's Dashboard
 */
function dashboard_campaign_graphs() {
  //$content = dashboard_campaign_summary();
  $content = dashboard_campaign_info();
  return $content;
}

/**
 * Build graph with the campaign summary
 */
function dashboard_campaign_summary() {
  $campaign = new DataManager();
  $campaign->dm_load_custom_list("SELECT c.name, c.description, c.status FROM campaigns c WHERE c.id <> 0", 'ASSOC');
  $count_pause = 0;
  $count_running = 0;
  $count_completed = 0;
  for($i=0; $i<$campaign->affected; $i++) {
    switch ($campaign->data[$i]['status']) {
      case 'P':
        $count_pause = $count_pause + 1;
        break;
      case 'R':
        $count_running = $count_running + 1;
        break;
      case 'C':
        $count_completed = $count_completed + 1;
        break;
    }
  }
  $content = '<div id="campaign-summary">
                <h1>Campaigns Summary</h1>
                <div id="campaign-summary-graph"></div>
              </div>';
  $data = $count_pause . ', ' . $count_running . ', ' . $count_completed;
  $legend = '"' . $count_pause . ' Paused", "' . $count_running . ' Running", "' . $count_completed . ' Completed"';
  $script =  '<script>
	             pie_data = [' . $data . '];
			         pie_legend = [' . $legend . '];
               pie_color = ["#bedeab", "#95ca78", "#a9d492", "#d2e8c5", "#d2e8c5", "#81bf5e", "#e6f3df", "#cccccc"];
 	             make_pie("campaign-summary-graph", null, pie_data, pie_legend, pie_color, 270, 180, 90, null, null, "east");
              </script>';
  return $content . $script;
}

function dashboard_progress($campaign_id){
  $dp = new DialerProgress();
  $dp->load_single("campaign_id='{$campaign_id}'");
	$campaign = new Campaigns();
  $campaign->load_single("id='{$campaign_id}'");
  $dm = new DataManager();
  $dm->dm_load_custom_list("SELECT NATURAL_last_dial_status as Status, COUNT(*) as Items , SUM(NATURAL_attempts) as Attempts FROM {$campaign->dial_list} GROUP BY NATURAL_last_dial_status;", 'ASSOC');
  if($dm->affected>0){
    for($i=0; $i<$dm->affected; $i++){
      $sum = $sum + $dm->data[$i]['Attempts'];
      if($dm->data[$i]['Status']=="ANSWER"){
        $answer = $dm->data[$i]['Attempts'];
      }
    }
  }
  if($answer>0){
    $calc = " - ".round($sum / $answer)."/1 Success Rate";
  }else{
    $calc = "";
  }

  //get the data and calculate the percentual
  $completed = round(($dp->complete_records * 100)/$dp->total_records, 2);

  return '<div id="progress-wrapp" style="width: 100%; height:50px">
    <div id="progress-message">'.$dp->complete_records.' Completed Records('.$completed.'%)</div>
    <div id="progressbar"></div>
  </div>
  <script type="text/javascript">
    startProgress();
    updateProgress("'.$completed.'","'.$completed.'% Completed ('.$dp->complete_records.' Calls of '.$dp->total_records . $calc.')");
  </script>';

}
/**
 * Build the graph for each campaign
 */
function dashboard_campaign_info() {
  $campaign = new DataManager();
  $campaign->dm_load_custom_list("SELECT c.id, c.name, c.description, c.status FROM campaigns c WHERE c.status = 'R'", 'ASSOC');
  for($i=0; $i<$campaign->affected; $i++) {
    $info = dashboard_campaign_get_info($campaign->data[$i]['id']);
     //print_r($info);
    //$data = '40, 20, 15';
    //$legend = '"40 Trunks", "20 Dids", "15 Devices"';
    if ($info['data'] != 100) {
      $list[] =  '<li class="campaign-info pie">
                  <h1>Campaign ' . $campaign->data[$i]['name'] . '</h1>
                  <div id="campaign-info-' . $campaign->data[$i]['id'] . '" class="content"></div>
                </li>';
      $scripts[] = '<script>
                 //pie_title = "";
	                 pie_data = [' .$info['data'] . '];
			             pie_legend = [' .$info['legend'] . '];
                   pie_color = [' .$info['color'] . '];
 	                 make_pie("campaign-info-' . $campaign->data[$i]['id'] . '", null, pie_data, pie_legend, pie_color, 75, 160, 40, 180, 70, "east", false);
                </script>';
    }
    /* else {
     $list[] = '<li class="campaign-info">
                  <h1>Campaign ' . $campaign->data[$i]['name'] . '</h1>
                  <div id="campaign-info-' . $campaign->data[$i]['id'] . '" class="content"><br/>&nbsp&nbsp - ' .  str_replace('"', '', $legend) . '</div>
                </li>';
      $scripts[] = '';
    }*/
  }
  if ($list) {
    $list = implode('', $list);
    $scripts = implode('', $scripts);
    $content = '<div id="campaign-info">
                  <ul class="dashboard">
                    ' . $list . '
                   <ul>
                </div>';
  }
  else {
    $content = 'No campaigns to display.';
  }
  return $content . $scripts;
}

/**
 * This function gets the info for each campaign
 */
function dashboard_campaign_get_info($campaign_id){
	$campaign = new Campaigns();
	$campaign->load_single("id='{$campaign_id}'");

	$dp = new DialerProgress();
	$dp->load_single("campaign_id='{$campaign_id}'");

	//Removing files on this directory to avoid image caching on the browser
	//$remove = `rm -f ../../media/graphs/campaign/*.png`;

	//Defining array of possible statuses
	$status_codes = array("busy","answered","no_answer","unavailable","answering_machine","cancelled","donotcall","disconnected","invalid");

	foreach($status_codes as $key=>$code){
		$total_processed = $total_processed + $dp->{$code};
	}

	//$total = $dp->total_attempts;
	$total_listed = $dp->total_records;

  $total_pending = $total_listed - $total_processed;

  $absolute = array();
  $legend = array();
  $color = array();
	if($total_pending > 0) {
			$perc = ceil(($total_pending/$total_listed)*100);
			$absolute[] = "{$perc}";
			$legend[] = '"' . $total_pending.' Pending (' . $perc . '%)"';
      $color[] = '"#de1c1c"';
	}

	foreach($status_codes as $key=>$code){
		$check  = "";
		$perc   = "";
		$mess   = "";
		if($dp->{$code}>0){
			$check  = round(($dp->{$code}/$total_listed)*100,2);
			$perc   = ceil(($dp->{$code}/$total_listed)*100);
			$mess   = $check;
			$absolute[] = "{$perc}";
			switch ($code) {
        case 'busy':
          $legend [] = '"' . $dp->$code . ' Busy (' . $mess .'%)"';
          $color[] = '"#bf5a2f"';
          break;
        case 'answered':
          $legend [] = '"' . $dp->$code . ' Answered (' . $mess .'%)"';
          $color[] = '"#2f69bf"';
          break;
        case 'no_answer':
          $legend [] = '"' . $dp->$code . ' No Answer (' . $mess .'%)"';
          $color[] = '"#bfa22f"';
          break;
        case 'unavailable':
          $legend [] = '"' . $dp->$code . ' Unavailable (' . $mess .'%)"';
          $color[] = '"#772fbf"';
          break;
        case 'answering_machine':
          $legend [] = '"' . $dp->$code . ' Answering Machine (' . $mess .'%)"';
          $color[] = '"#a2bf2f"';
          break;
        case 'cancelled':
          $legend [] = '"' . $dp->$code . ' Cancelled (' . $mess .'%)"';
          $color[] = '"#fa286d"';
          break;
        case 'donotcall':
          $legend [] = '"' . $dp->$code . ' Do Not Call (' . $mess .'%)"';
          $color[] = '"#666666"';
          break;
        case 'disconnected':
          $legend [] = '"' . $dp->$code . ' Disconnected (' . $mess .'%)"';
          $color[] = '"#39475b"';
          break;
        case 'invalid':
          $legend [] = '"' . $dp->$code . ' Invalid (' . $mess .'%)"';
          $color[] = '"#ac0101"';
          break;
      }
	  }
	}

  $total_records      = $dp->total_records;

	if($dp->complete_records>0){
		$completed_records = ceil(($dp->complete_records/$total_records)*100);
		if($dp->total_attempts){ $average = ceil(($dp->total_attempts/$dp->complete_records)); }
	}
  else{
		$completed_records = 0;
		$average           = 0;
	}
	if($absolute){
		$absolute = implode(', ', $absolute);
		$legend   = implode(', ', $legend);
    $color   = implode(', ', $color);
    //die(print_r($color));
  }
  //die($legend);
  $response['data'] = $absolute;
  $response['legend'] = $legend;
  $response['color'] = $color;
	return $response;
}


/*function dashboard_widgets($dashboard_type) {
  $user = new User();
  $user->load_single('id = ' . $_SESSION['log_id']);
  $dash_type = 'dashboard_' . $dashboard_type;
  if ($user->$dash_type) {
    // Build the dashboard accordingly the dashboard type and if there is something recorded in his desktop
    $user_widgets = $user->$dash_type;
    if ($user_widgets) {
      $content = '<ul class="dashboard" id="dash-sortable">';
      foreach ($user_widgets as $user_widget) {
        $widget = new DashboardWidgets();
        $widget->load_single('id = ' . $user_widget);
        if ($widget->enabled) {
				  $content .= '<li id="widget_' . $widget->id . '" class="' . $widget->class . '">
					               <span class="dashboard-delete-widget" onclick="dashboard_delete_widget(\'widget_' . $widget->id . '\');" title="Close" alt="Close"></span>
                         <h1>' . $widget->title . '</h1>
                         <div id="widget_' . $widget->id . '_content" class="content">' . call_user_func($widget->widget_function , $user_widget) . '
                         </div>
                       </li>';
        }
      }
      $content .= '</ul>
                  <form id="dashboard-form" name="dashboard-form">
                     <input type="hidden" name="dashboard_type" value="' . $dashboard_type . '" />
                   </form>';
    }
  }

  else {
    // Return the message to configure his/her dashboard
  //  $content = 'Maybe you are new here, don\'t forget to Setup your Dashboard<br/>Click on the link on the right link "Dashboard Setup" and choose which items you want to see on your dashboard.';
  }

  return $content;
}*/

/**
 * Build the graph 1
 */
function dashboard_build_graph($widget) {
  // Here goes the funcion to be called to generate the data
  $data = '40, 20, 15';
  $legend = '"40 Trunks", "20 Dids", "15 Devices"';
  return dashboard_build_pie($widget, $data, $legend);
}

/**
 * Build the pies for the dash
 */
function dashboard_build_pie($widget, $data, $legend) {
 return '
   <script>
      //pie_title = "";
	    pie_data = [' . $data . '];
			pie_legend = [' . $legend . '];
 	    make_pie("widget_' . $widget . '_content", null, pie_data, pie_legend, null, 240, 180, 50, 180, 70);
   </script>';
}

/**
 * Update Dashboard List
 */
function dashboard_update_list($data) {
  if ($data['positions']) {
    $po = explode("-",$data['positions']);
    for($i=0; $i<count($po); $i++){
      $pos = '';
      $pos = str_replace('widget_', '', $po[$i]);
      $positions[$i] = explode(',', $pos);
    }
  }
  $user = new User();
	$user->load_single('id = ' . $_SESSION['log_id']);
  $dashboard_type = 'dashboard_' . $data['dashboard_type'];
  $user->$dashboard_type = $positions;
  $user->update('id = ' . $_SESSION['log_id']);
  return '';
}

/**
 * Function for the user to Setup the Dashboard
 */
function dashboard_setup_form($dashboard_type=1) {
  // Get the Dashboard Type
  $widgets = new DashboardWidgets();
  $widgets->load_list('ASSOC', 'enabled = 1 AND dashboard_type = ' . $dashboard_type);
  if ($widgets->affected) {
    // Retrieve the widgets already selected by the user
    $user = new User();
    $user->load_single('id = ' . $_SESSION['log_id']);
    $dash_type = 'dashboard_' . $dashboard_type;
    if ($user->$dash_type) {
      $user_widgets = $user->$dash_type;
    }
    $checked = '';
    for($i=0; $i<$widgets->affected; $i++) {
      for($x=0; $x<count($widgets->data[$i]); $x++){
        if ($user_widgets) {
          if (in_array($widgets->data[$i]['id'], $user_widgets[0]) || in_array($widgets->data[$i]['id'], $user_widgets[1]) || in_array($widgets->data[$i]['id'], $user_widgets[2])){
            $checked = 'checked="checked"';
          }else{
            $checked = '';
          }
        }
      }

      $inputs[] = '<div class="form-item form-checkbox">
                     <label for="input_widget_' . $widgets->data[$i]['id'] . '">
                       <input onclick="dashboard_setup()" value="' . $widgets->data[$i]['id'] . '" type="checkbox" name="widget[' . $widgets->data[$i]['id'] . ']" id="input_widget_' . $widgets->data[$i]['id'] . '" ' . $checked . ' />
                       ' . $widgets->data[$i]['title'] . '
                     </label>
                     <!--
                     <div class="widget-description"> <img src="modules/dashboard/images/' . $widgets->data[$i]['image_path'] . '" /> <br/>' . $widgets->data[$i]['description'] . '</div>
                     -->
                   </div>';
    }
  }
  if ($inputs) {
    $form = '<form id="dashboard-setup-form" name="dashboard-setup-form">
               ' . implode('', $inputs) . '
               <input type="hidden" name="dashboard_type" id="dashboard_type" value="' . $dashboard_type . '" />
             </form>';
  }
  return $form;
}

function dashboard_setup($data) {
  $user = new User();
	$user->load_single('id = ' . $_SESSION['log_id']);
  $dash_type = 'dashboard_' . $data['dashboard_type'];
  $user_widgets = $user->$dash_type;
  $nlist = array();
  $new_list = array();
  if($user_widgets && $data['widget']){
    // Remove widgets that were not selected now
    foreach($data['widget'] as $widget){
      $wgt[] = $widget;
    }
    for($i=0; $i<count($user_widgets); $i++){
      for($x=0; $x<count($user_widgets[$i]); $x++){
        if(in_array($user_widgets[$i][$x], $wgt)){
          $nlist[$i][] = $user_widgets[$i][$x];
        }else{
          $nlist[$i][] = null;
        }
      }
    }

    foreach($wgt as $v){
      if(in_array($v, $nlist[0]) || in_array($v,$nlist[1]) || in_array($v, $nlist[2])){
        //skipp setting this widget to the array cause it already exists
      }else{
        if(!$nlist[0][0]){
          $nlist[0][0] = $v;
        }else{
          if(!$nlist[1][0]){
            $nlist[1][0] = $v;
          }else{
            if(!$nlist[2][0]){
              $nlist[2][0] = $v;
            }else{
              $nlist[0][] = $v;
            }
          }
        }
      }
    }
    $new_list[0] = array();
    $new_list[1] = array();
    $new_list[2] = array();
    for($i=0; $i<3; $i++){
      $ct = 0;
      for($x=0; $x<count($nlist[$i]); $x++){
        if($nlist[$i][$x]!=null){
          $new_list[$i][$ct] = $nlist[$i][$x];
          $ct++;
        }
      }
    }
  }else{
    foreach($data['widget'] as $key => $value){
      if($value){
        $new_list[0][0] = $value;
      }
    }
  }
  //array_unshift($new_list, $widget);
  $user->$dash_type = $new_list;
  $user->update('id = ' . $_SESSION['log_id']);
  return dashboard_widgets($data['dashboard_type']);
}

/**
 * Set the new color scheme in the database
 */
function user_change_color($data) {
	$user = new User();
	$user->load_single('id = ' . $_SESSION['log_id']);
  $user->interface = $data['color'];
	$user->update('id = ' . $_SESSION['log_id']);
	$_SESSION['log_interface'] = $data['color'];
	return 'New color is ' . $data['color'];
}

function change_console_panel($data){
//	echo print_debug($data);
	if($data['customer_id']){
		$_SESSION['dash_type'] 			= 3;
		$_SESSION['console_message']= "Admin Console";
		$_SESSION['log_customer_id']= $data['customer_id'];
	}
	if($data['agent_id']){
		$_SESSION['dash_type'] 			= 2;
		$_SESSION['console_message']= "Agent Console";
		$_SESSION['log_agent_id'] 	= $data['agent_id'];
	}

	if(empty($data['agent_id']) && empty($data['customer_id'])){
			switch($_SESSION['log_access_level']){
				case 81:
				case 71:
					$_SESSION['dash_type'] = 1;
					$_SESSION['console_message'] 	= "Manager Console";
					$_SESSION['log_customer_id'] 	= null;
					$_SESSION['log_agent_id']			= null;
					break;
				case 61:
					$_SESSION['dash_type'] = 2;
					$_SESSION['console_message'] 	= "Agent Console";
					$_SESSION['log_customer_id'] 	= null;
					break;
				case 51:
					$_SESSION['dash_type'] = 3;
					$_SESSION['console_message'] = "Admin Console";
					break;
			}
	}
	header("Location: ../../dashboard.php");
}

function build_right_topic_info(){
	$loginname      = $_SESSION['log_first_name'] . ' ' .$_SESSION['log_last_name'];

	if($_SESSION['dash_type']==3){
	//	$customer = new Customer();
	//	$customer->load_single("id='{$_SESSION['log_customer_id']}'");
		if($customer->company_name){
			$account_name = $customer->company_name;
		}else{
			$account_name = $customer->contact_name;
		}
		$right_topic    = '<li>' . NATURAL_VERSION . '</li> <li>User: ' . $loginname . '</li> <li>Account: ' . $account_name . '</li>';
	}

	if($_SESSION['dash_type']==2){
		$agent = new Agent();
		$agent->load_single("id='{$_SESSION['log_agent_id']}'");
		$agent_name = $agent->name;
		$right_topic    = '<li>' . NATURAL_VERSION . '</li> <li>User: ' . $loginname . '</li> <li>Agent: ' . $agent_name . '</li>';
	}

	if($_SESSION['dash_type']==1){
		$right_topic    = '<li>' . NATURAL_VERSION . '</li> <li>User: ' . $loginname . '</li>';
	}
	return $right_topic;

}

function build_logout_button(){

/*	if($_SESSION['dash_type']==3){
		switch($_SESSION['log_access_level']){
			case 81:
			case 71:
				$back_original_panel = true;
				break;
			case 61:
				$back_original_panel = true;
				break;
			case 51:
				$back_original_panel = false;
				break;
		}
	}
	if($_SESSION['dash_type']==2){
		switch($_SESSION['log_access_level']){
			case 81:
			case 71:
				$back_original_panel = true;
				break;
			case 61:
				$back_original_panel = false;
				break;
		}
	}
	if($_SESSION['dash_type']==1){
		$back_original_panel = false;
	}

	if($back_original_panel){
		$logout_button = '<a href="modules/dashboard/index.php?fn=back_original_panel" title="back to Panel">Back To Admin | </a><a href="logout.php" title="Logout">Logout</a>';
	}else{
		$logout_button = '<a href="logout.php" title="Logout">Logout</a>';
	}*/
	$logout_button = '<a href="logout.php" title="Logout">Logout</a>';
	return $logout_button;
}

function back_original_panel(){
	switch($_SESSION['log_access_level']){
		case 81:
		case 71:
			$_SESSION['dash_type'] 				= 1;
			$_SESSION['console_message'] 	= "Manager Console";
			$_SESSION['log_customer_id'] 	= null;
			$_SESSION['log_agent_id'] 		= null;
			break;
		case 61:
			$_SESSION['dash_type'] = 2;
			$_SESSION['console_message'] = "Agent Console";
			$_SESSION['log_customer_id'] 	= null;
			break;
		case 51:
			$_SESSION['dash_type'] = 3;
			$_SESSION['console_message'] = "Admin Console";
			break;
	}
	header("Location: ../../dashboard.php");
}

/*
 * Update Modules
 */
function check_update_home(){
	$url = "license.opensourcemind.net/api.php?request_type=isAlive";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
	curl_setopt($ch, CURLOPT_POST, 0);
	$response = curl_exec($ch);

	curl_close ($ch);
	if(empty($response)){
		setCounter();
    $dash_content = "<div class='container-error' id='system_update'>";
		$dash_content .= "<p>Could not contact License Server at this time. Dialer operation may be restricted! </p>";
		$dash_content .= "<p>Please verify your internet connectivity! </p>";
		$dash_content .="</div>";
    return $dash_content;
    exit(0);
	}

	$r = validate_app();
	if($r){
		return $r;
	}

	$doc = new SimpleXmlElement($response, LIBXML_NOCDATA);

 	if($doc->command->code==1){
		//The Dialer connected with License Server with no problem
		if($_SESSION['log_access_level']>60){
      $sc = new SystemControl();
      $sc->load_single("id!='0' LIMIT 1");
      if($sc->enable_updates==1){
        $update = check_update();
      }
		}
	}else{
		setCounter();
    $dash_content = "<div class='container-error' id='system_update'>";
		$dash_content .= "<p>Could not contact License Server at this time. Dialer operation may be restricted! </p>";
		$dash_content .= "<p>Please verify your internet connectivity! </p>";
		$dash_content .="</div>";
    return $dash_content;
    exit(0);
	}
  if($update[0]=="NOLICENSE"){
    $form = new DbForm();
    $dash_content = "<div class='container-error' id='system_update'>";
    $dash_content .= "<p>".$update[1]."</p><br>";
    $dash_content .= $form->build('license_add_new');
		$dash_content .="</div>";
    return $dash_content;
    exit(0);
  }
  if($update[0]=="FAILED"){
    $dash_content = "<div class='container-error' id='system_update'>
		<p>{$update[1]}</p>
		</div>";
    return $dash_content;
    exit(0);
    $check_update = false;
  }else{
    if($update){
      $check_update = true;
    }
  }
	if($check_update){
		$campaign = new Campaigns();
		$campaign->load_single("status='R' LIMIT 1");
		if($campaign->affected>0){
			$dash_content = "<div class='container-error' id='system_update'>";
			$dash_content .= "<p>There is an Update available but you still have a Running Campaign! Please pause all your Campaigns before updating the System!</p>";
			$dash_content .="</div>";
			return $dash_content;
			exit(0);
		}

		$dash_content = "<div class='container-warning' id='system_update'>
		<form id='sys_up_form' name='sys_up_form' action=\"javascript:proccess_information('sys_up_form','system_update','dashboard','Are you sure you want to update the system now?',null,null,'system_update');\">
		<p>An Updated Version is Available  <input type='submit' value='Update Now' class='button'></p>
		</form>
		</div>";
  }else{
    //$check_reboot = check_reboot();
    $sc = new SystemControl();
    $sc->load_single("id>'0' LIMIT 1");
    if($sc->need_reboot>0){
      if($sc->need_reboot==1){
				$dash_content = "<div class='container-warning' id='system_update'>
        <form id='sys_up_form' name='sys_up_form' action=\"javascript:proccess_information('sys_up_form','reboot_system','dashboard','Restarting will cause all current calls to be disconnected and all HCS services will be momentarily disrupted. Are you sure you want to continue?',null,null,'system_update');\">
        <p>System Restart Required!</b></font><br><input type='submit' value='Restart Now' class='button'></p>
        </form>
        </div>";
      }else{
				if(file_exists("/var/hive/tmp/doServiceRestart")){
					$dash_content = "<div class='container-warning' id='system_update'>
					<p>Server Restarting! Please wait!<input type='hidden' name='reboot_checker' id='reboot_checker' value='1'></p>
					</div>";

				}else{
					$system = new SystemControl();
					$system->load_single("id>'0' LIMIT 1");
					$system->need_reboot = 0;
					$system->update("id>'0'");
					$dash_content = "<div class='container-warning' id='system_update'>
					<p>Your System has been restarted successfully!</b>
					</div>";
				}
      }
    }else{
      $dash_content = "";
    }
  }
  return $dash_content;
}

function check_reboot(){
  $system = new SystemControl();
  $system->load_single("id>'0' LIMIT 1");
  return $system->need_reboot;
}

function reboot_system(){
	/*$system = new SystemControl();
	$system->load_single("id='1'");
	$system->need_reboot = 2;
	$system->update("id='1'");
  $myFile = "/var/hive/tmp/doServiceRestart";
  $fh = fopen($myFile, 'w');
  fwrite($fh, "DoRestart=yes");
  fclose($fh);
  return "Server Restarting! Please wait!<input type='hidden' name='reboot_checker' id='reboot_checker' value='1'>";*/

  echo '<h2>Hive Service Restart</h2>
		<span id="main-message"><p>Please wait while your System is beign restarted</p></span><div id="progress-wrapp" style="width: 98%; height:100px">
		<div id="progressbar"></div><div id="progress-message"></div>
	</div>
	<script type="text/javascript">
		startProgress();
    updateProgress("12","Starting Reboot Process");
		proccess_information(null, "reboot_step1", "dashboard",null,"null",null,"progress-message");
	</script>';

}

function reboot_step1(){
  $resp = shell_exec('sudo /var/hive/bin/srvcontrol.sh HSDStopServices &');
  sleep(5);
  return 'Stoping Services<script type="text/javascript">
    updateProgress("28","Stoping Services");
    proccess_information(null, "reboot_step2", "dashboard",null,"",null,"progress-message");
  </script>';
}

function reboot_step2(){
  return 'Checking Services<script type="text/javascript">
    updateProgress("65","Checking Services");
    proccess_information(null, "reboot_step3", "dashboard",null,"",null,"progress-message");
  </script>';
}

function reboot_step3(){
  $resp = shell_exec('sudo /var/hive/bin/srvcontrol.sh HSDStartServices &');
  sleep(12);
	$system = new SystemControl();
	$system->load_single("id>'0' LIMIT 1");
	$system->need_reboot = 0;
	$system->update("id>'0'");
  return 'Restart Complete<script type="text/javascript">
            updateProgress("100","Restart Complete",true);
            $("#main-message").html("Restart Complete");
	</script>';
}

function check_if_system_has_rebooted(){
	if(file_exists('/var/hive/tmp/commandResult')){
		$myFile = "/var/hive/tmp/commandResult";
		$fh = fopen($myFile, 'r');
		$theData = fread($fh, filesize($myFile));
		fclose($fh);
		insertLog("System Restart Executed({$theData})");
		$system = new SystemControl();
		$system->load_single("id>'0' LIMIT 1");
		$system->need_reboot = 2;
		$system->update("id>'0'");

		$remove = shell_exec("rm -rf /var/hive/tmp/commandResult");
		return "REBOOTED";
	}else{
		return "REBOOTING";
	}
}

function validate_app(){
  $sc = new SystemControl();
  $sc->load_single("id!='0' LIMIT 1");
	$url = "license.opensourcemind.net/api.php?request_type=authApp&license={$sc->license_key}&api_key={$sc->api_key}";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
	curl_setopt($ch, CURLOPT_POST, 0);
	$response = curl_exec($ch);

  if($sc->affected<1){
    //disable_main_menu();
    $form = new DbForm();
		$dash_content = "<div class='container-warning' id='system_update'>";
		$dash_content .= "<p>Please add your License Key and press Save to register your HCS Product!</p>";
		$dash_content .= "<p>Please Contact us at devteam@opensourcemind.net if you have any problem! </p>";
		$dash_content .="</div>";
    $dash_content .= $form->build('license_add_new', $form);
    return $dash_content;
  }

	$doc = new SimpleXmlElement($response, LIBXML_NOCDATA);
	if($doc->command->code==1){
		$sc->call_paths 		= $doc->command->concurrent_calls;
		$sc->call_center 		= $doc->command->call_center;
		$sc->pbx 						= $doc->command->pbx;
		$sc->conference_room= $doc->command->conference;
		$sc->dialer 				= $doc->command->dialer;
		$sc->call_recording = $doc->command->call_recording;
		$sc->enable_updates = $doc->command->enable_updates;
		$sc->hosted         = $doc->command->hosted;
		$sc->update("id!='0'");
		clearCounter();
		//print_debug($doc);
		//Create function call to enable/disable modules on the system based on what was updated
		validate_modules();
	}else{
		setCounter();
		$dash_content = "<div class='container-error' id='system_update'>";
		$dash_content .= "<p>Application License changed or removed! Dialer operation may be restricted! </p>";
		$dash_content .= "<p>Please Contact us at devteam@opensourcemind.net ! </p>";
		$dash_content .="</div>";
    return $dash_content;
    exit(0);
	}
}

function validate_modules(){
  $sc = new SystemControl();
  $sc->load_single("id!='0' LIMIT 1");
	//checking if acd_group module is enabled and taking some action to block/unblock if necessary
	if($sc->call_center<1){
		//blocking main menu Call Center
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE main_menu SET status='0' WHERE element_name='call_center_manager'");
		//blocking side menu agent connect under Dialer
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE side_menu SET status='0' WHERE element_name='add_new_agent_connect_side'");
		//blocking routing profile
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE yaml_template SET type='disabled' WHERE name='acd-group'");
	}else{
		//Unblocking main menu Call Center
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE main_menu SET status='1' WHERE element_name='call_center_manager'");
		//Unblocking side menu agent connect under Dialer
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE side_menu SET status='1' WHERE element_name='add_new_agent_connect_side'");
		//Unblocking routing profile
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE yaml_template SET type='route_profile' WHERE name='acd-group'");
	}
	//checking if Dialer module is enabled and taking some action to block/unblock if necessary
	if($sc->dialer<1){
		//blocking main menu Dialer
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE main_menu SET status='0' WHERE element_name='campaign_list_main'");
		//blocking Outbound Script Sub Menu Under Call Flow
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE sub_menu SET status='0' WHERE element_name='outbound_script_sub'");
		//blocking AMD Config Under System
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE sub_menu SET status='0' WHERE element_name='amd_config_side'");
		//Pausing campaigns if any running
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE campaigns SET status='P', paused_by_user='1' WHERE status!='C'");
	}else{
		//Unblocking main menu Dialer
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE main_menu SET status='1' WHERE element_name='campaign_list_main'");
		//Unblocking Outbound Script Sub Menu Under Call Flow
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE sub_menu SET status='1' WHERE element_name='outbound_script_sub'");
		//Unblocking AMD Config Under System
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE sub_menu SET status='1' WHERE element_name='amd_config_side'");
	}
	//checking if PBX module is enabled and taking some action to block/unblock if necessary
	if($sc->pbx<1){
		//blocking main menu PBX
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE main_menu SET status='0' WHERE element_name='pbx_main'");
		//blocking route_profile
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE yaml_template SET type='disabled' WHERE name='fax2email' OR name='ring-group' OR name='voicemail' OR name='dial-exten'");
	}else{
		//Unblocking main menu PBX
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE main_menu SET status='1' WHERE element_name='pbx_main'");
		//Unblocking route_profile
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE yaml_template SET type='route_profile' WHERE name='fax2email' OR name='ring-group' OR name='voicemail' OR name='dial-exten'");
	}
	//checking if Conference module is enabled and taking some action to block/unblock if necessary
	if($sc->conference_room<1){
		//blocking main menu Conference
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE main_menu SET status='0' WHERE element_name='conference_main'");
		//blocking route_profile
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE yaml_template SET type='disabled' WHERE name='conference-bridge'");
	}else{
		//Unblocking main menu Conference
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE main_menu SET status='1' WHERE element_name='conference_main'");
		//Unblocking route_profile
		$dm = new DataManager();
		$dm->dm_custom_query("UPDATE yaml_template SET type='route_profile' WHERE name='conference-bridge'");
	}
	//checking if Call Recording module is enabled and taking some action to block/unblock if necessary
	if($sc->call_recording<1){
	}else{
	}
}
/*
 *Function used to count until 10 before locking the application
 */
function setCounter(){
  $sc = new SystemControl();
  $sc->load_single("id!='0' LIMIT 1");
	if($sc->app_lock_counter==0){
		$sc->first_warning = date("Y-m-d H:i:s");
	}
	if($sc->app_lock_counter<10){
		$sc->app_lock_counter = $sc->app_lock_counter + 1;
	}else{
		$sc->app_lock_counter = 10;
    //disable_main_menu();
	}
  $sc->update("id='{$sc->id}'");
}

function clearCounter(){
  $sc = new SystemControl();
  $sc->load_single("id!='0' LIMIT 1");
	$sc->first_warning 		= "0000-00-00 00:00:00";
	$sc->app_lock_counter = 0;
  $sc->update("id='{$sc->id}'");
	enable_main_menu();
}

function check_update(){
  $sc = new SystemControl();
  $sc->load_single("id!='0' LIMIT 1");
  if($sc->affected<1){
    //disable_main_menu();
    $resp[0] = "NOLICENSE";
    $resp[1] = "License Key Not registered, Please enter your License Key to Register this Product";
    return $resp;
    exit(0);
  }
	$url = "license.opensourcemind.net/api.php?request_type=getLastDialerVersion&license={$sc->license_key}&api_key={$sc->api_key}&devmode=".NATURAL_DEV_MODE;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_POST, 0);
	$response = curl_exec($ch);

	curl_close ($ch);

	$doc = new SimpleXmlElement($response, LIBXML_NOCDATA);

  if($sc->main_menu_disabled==1){
    enable_main_menu();
  }
  if($doc->command->code==1){
    $local_version = new DataManager();
    $local_version->dm_load_single(NATURAL_DBNAME . ".module","module='natural'");
		$current 				= $local_version->version;
  	$server_version = $doc->command->current_version;

    if($server_version > $current){
      //Check if bootstrap is set to dev mode to test the update
      //if not check if the version is a stable release
      update_license();
      if(NATURAL_DEV_MODE){
        return true;
      }else{
        if($doc->command->release==1){
          return true;
        }else{
          return false;
        }
      }
    }else{
      return false;
    }
  }else{
    $resp[0] = "FAILED";
    $resp[1] = $doc->command->message;
    if($doc->command->message!=1){
      //disable_main_menu();
    }
    return $resp;
  }
}

function update_license(){
  $sc = new SystemControl();
  $sc->load_single("id!='0' LIMIT 1");
	$url = "license.opensourcemind.net/api.php?request_type=getDialerLicense&license={$sc->license_key}&api_key={$sc->api_key}";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_POST, 0);
	$response = curl_exec($ch);

	curl_close ($ch);

	$doc = new SimpleXmlElement($response, LIBXML_NOCDATA);

  if($doc->command->code==1){
    if($sc->call_paths!=$doc->command->call_paths || $sc->campaign_limit!=$doc->command->campaigns_limit){
      $sc->call_paths=$doc->command->call_paths;
      $sc->campaign_limit=$doc->command->campaigns_limit;
      $sc->update("id>'0'");
    }
  }
}

function register_license($data){
  $url = "license.opensourcemind.net/api.php?request_type=registerLicense&license=".$data['license_key'];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_POST, 0);
	$response = curl_exec($ch);

	curl_close ($ch);

	$doc = new SimpleXmlElement($response, LIBXML_NOCDATA);
  if($doc->command->code==1){
    $sc = new SystemControl();
    $sc->license_key      = $data['license_key'];
    $sc->api_key          = $doc->command->api_key;
    $sc->call_paths       = $doc->command->call_paths;
    $sc->campaign_limit   = $doc->command->campaigns_limit;
    $sc->insert();

    $company = new Company();
    $company->name       = $doc->command->name;
    $company->address    = $doc->command->address;
    $company->city       = $doc->command->city;
    $company->state      = $doc->command->state;
    $company->zip        = $doc->command->zip;
    $company->country    = $doc->command->country;
    $company->call_group = substr(time(),0,5);
    $company->time_zone  = $doc->command->time_zone;
    $company->api_key    = $doc->command->api_key;
    $company->created    = date("Y-m-d H:i:s");
    $company->insert();
    enable_main_menu();

    $url = "license.opensourcemind.net/api.php?request_type=setCreationDate&license=".$data['license_key'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_POST, 0);
    $response = curl_exec($ch);

    curl_close ($ch);

    return "License Key Registered Successfully<br><br>
    Registered to: ".$company->name."<br>
    Call Paths: ".$doc->command->call_paths."<br>
    Campaign Limit: ".$doc->command->campaigns_limit."<br><br>
    Please refresh your page!";
  }else{
    return "ERROR||".$doc->command->message;
  }
}

function disable_main_menu(){
  $dm = new DataManager();
  $dm->dm_custom_query("UPDATE main_menu SET status='0' WHERE element_name!='network_list_main' AND element_name!='dashboard_main'");
  $dm = new DataManager();
  $dm->dm_custom_query("UPDATE system_control SET main_menu_disabled='1'");
  $dm = new DataManager();
  $dm->dm_custom_query("UPDATE campaigns SET status='P', paused_by_user='1' WHERE status!='C'");
}

function enable_main_menu(){
  $dm = new DataManager();
  $dm->dm_custom_query("UPDATE main_menu SET status='1'");
  $dm = new DataManager();
  $dm->dm_custom_query("UPDATE system_control SET main_menu_disabled='0'");
}

function system_update(){
	$url = "license.opensourcemind.net/api.php?request_type=getLastDialerVersion&devmode=".NATURAL_DEV_MODE;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_POST, 0);
	$response = curl_exec($ch);

	curl_close ($ch);

	$doc = new SimpleXmlElement($response, LIBXML_NOCDATA);

	echo '<h2>Hive System Update</h2>
		<span id="main-message"><p>Please wait while your System is beign Updated</p></span><div id="progress-wrapp" style="width: 98%; height:100px">
		<div id="progressbar"></div><div id="progress-message"></div>
	</div>
	<script type="text/javascript">
		startProgress();
		proccess_information(null, "starting_update", "dashboard",null,"new_version|'.$doc->command->current_version.'",null,"progress-message");
	</script>';

}

function starting_update($data){
  return 'Cleaning and Updating Repository<script type="text/javascript">
    updateProgress("22","Cleaning and Updating OS Repository - '.$msg.'");
    proccess_information(null, "clean_update_os", "dashboard",null,"new_version|'.$data['new_version'].'",null,"progress-message");
  </script>';

}

function clean_update_os($data){
	$unzip = shell_exec("sudo apt-get clean");
	$unzip = shell_exec("sudo apt-get update");
  return 'Downloading Packages<script type="text/javascript">
    updateProgress("48","Downloading Packages - '.$msg.'");
    proccess_information(null, "update_modules", "dashboard",null,"new_version|'.$data['new_version'].'",null,"progress-message");
  </script>';
}

function update_modules($data){
  $install = shell_exec("sudo apt-get --force-yes -y install hcs-web");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-agent-console");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-asterisk");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-cisco-spa-firmware");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-cisco-tftp-firmware");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-config");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-core");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-daemon");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-data");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-grandstream-firmware");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-manager");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-swift");
  $install .= shell_exec("sudo apt-get --force-yes -y install hcs-utils");

  //insertLog("System updated with the response: \n".$install);

  return 'Updating Database<script type="text/javascript">
              updateProgress("67","Updating Database");
	      proccess_information(null, "update_db", "dashboard",null,"new_version|'.$data['new_version'].'",null,"progress-message");
	  </script>';
}
/*
 * Functions related to the old update method
 * function starting_update($data){
	shell_exec("wget http://license.opensourcemind.net/downloads/smartdialer_update.tar.gz .");
	shell_exec("mv smartdialer_update.tar.gz ../../data/");
	if(file_exists('../../data/smartdialer_update.tar.gz')){
		return 'Uncompressing Files<script type="text/javascript">
			updateProgress("10","Downloading Packages - '.$msg.'");
			proccess_information(null, "unzip_files", "dashboard",null,"new_version|'.$data['new_version'].'",null,"progress-message");
		</script>';
	}else{
    $dash_content = "<div class='container-error' id='system_update'>";
		$dash_content .= "<p>Could not download the update at this time. Please try again later!</p>";
		$dash_content .="</div>";
    return $dash_content;
    exit(0);
	}
}

function unzip_files($data){
	$unzip = shell_exec("tar -xvzf ../../data/smartdialer_update.tar.gz");
	$chg_permission = shell_exec("chmod -R 777 data/");
	return 'Updating Modules<script type="text/javascript">
		updateProgress("18","Updating Modules");
		proccess_information(null, "update_modules", "dashboard",null,"new_version|'.$data['new_version'].'",null,"progress-message");
	</script>';
}

function update_modules($data){
  //Stopping Manager and Daemon here to prevent any issues with
  //broken reloaders and what not... campaigns should be put on pause too.
  $svcstop = shell_exec("sh /var/hive/bin/srvcontrol.sh HSDStopServices");
	$replace = shell_exec("cp -r data/build/* ../../");
  $replace = shell_exec("cp -r data/build/engine/*.sh /var/hive/bin/");
  $replace = shell_exec("cp -r data/build/engine/*.tcl /var/hive/bin/");
  $replace = shell_exec("cp -r data/build/engine/crontab /var/hive/etc/");
	$remove  = shell_exec("rm -rf /var/hive/etc/monit/monitrc");
  $replace = shell_exec("cp -r data/build/engine/monitrc /var/hive/etc/monit/");
  $permission = shell_exec('sudo chown root:root /var/hive/etc/crontab');
  return 'Updating Database<script type="text/javascript">
              updateProgress("29","Updating Database");
	      proccess_information(null, "update_db", "dashboard",null,"new_version|'.$data['new_version'].'",null,"progress-message");
	  </script>';
}*/

function update_db($data){
  //Add here the code to replace the database structure
  $exec = shell_exec("ls ".NATURAL_ROOT_PATH."/data/");
  $folders = explode("\n",$exec);

  $vs = new DataManager();
  $vs->dm_custom_query("SELECT * FROM module WHERE module='acl' LIMIT 1",true,true);
  $current 				= $vs->version + 1;
  $server_version = $data['new_version'];

  while($server_version>=$current){
      if(file_exists("../../data/sqlupdate/update_{$current}.sql")){
          $permission = shell_exec("chmod -R 777 ../../data/sqlupdate/*");
          $updatedb = shell_exec("mysql --force -u ".NATURAL_DBUSER." -p".NATURAL_DBPASS." < ../../data/sqlupdate/update_{$current}.sql");
      }
    $current++;
  }
//  write_hsdmanager_file();

  return 'Cleaning Folders<script type="text/javascript">
	      updateProgress("88","Cleaning Folders");
	      proccess_information(null, "clean_folders", "dashboard",null,"new_version|'.$data['new_version'].'",null,"progress-message");
	  </script>';
}

function clean_folders($data){
/*  $clean_build 	= shell_exec("rm -rf data/");
  $clean_tar 		= shell_exec("rm -rf ../../data/*.tar.gz");
  $clean_build	= shell_exec("rm -rf ../../data/data/");
  $clean_sql 		= shell_exec("rm -rf ../../data/*.sql");
  $clean_sql 		= shell_exec("rm -rf ../../data/sqlupdate/*.sql");
  $clean_sql 		= shell_exec("rm -rf ../downloads/*");
  $clean_sql 		= shell_exec("rm -rf ../upload/files/*");
  $clean_sql 		= shell_exec("rm -rf ../../uploads/");
  $clean_sql 		= shell_exec("rm -rf ../../dist/");*/
  $permission		= shell_exec("chmod -R 777 ../../");

  return 'Finishing Update<script type="text/javascript">
            updateProgress("95","Finishing Update");
            proccess_information(null, "finish_update", "dashboard",null,"new_version|'.$data['new_version'].'",null,"progress-message");
          </script>';
}

function finish_update($data){

  setSystemToReboot();

  $sc = new SystemControl();
  $sc->load_single("id!='0' LIMIT 1");
  $url = "license.opensourcemind.net/api.php?request_type=logUpdateDialerVersion&version={$data['new_version']}&apikey={$sc->api_key}";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_POST, 0);
  $response = curl_exec($ch);
  curl_close ($ch);

  $doc = new SimpleXmlElement($response, LIBXML_NOCDATA);

  #Starting services before update done even if restart required
//  $svcstart = shell_exec("sh /var/hive/bin/srvcontrol.sh HSDStartServices &");

  $vs = new DataManager();
  $vs->dm_custom_query("UPDATE module SET version='{$data['new_version']}'");
  return 'Update Complete <script type="text/javascript">
            updateProgress("100","Update Complete(Refresh your web page to make the update available)",true);
            $("#main-message").html("Update Completed");
	</script>';
}

function write_hsdmanager_file(){
  $head = "# Hive Smart Dialer Manager (HSDManager)
# Application copyright by OpenSourceMind LLC @ 2010
# Contact email: devteam@opensourcemind.net
# HSD Manager listening port";

  $hsd = new HsdProperties();
  $hsd->load_single("id>'0' LIMIT 1");

  $myFile = "/var/hive/etc/HSD.properties";
  $fh = fopen($myFile, 'w');

  fwrite($fh, $head);

  $content = "
HSD.Port=".$hsd->hsd_port."
# HSD Service Key
HSD.Key=".$hsd->hsd_key."
# HSD OriginateCall options
HSD.CallOutContext=".$hsd->hsd_calloutcontext."
HSD.AnsweredContext=".$hsd->hsd_answeredcontext."
HSD.AnsweredExten=".$hsd->hsd_answeredexten."
HSD.AnsweredPriority=".$hsd->hsd_answeredpriority."
#HSD Database configuration
DB.Host=".$hsd->db_host."
DB.Port=".$hsd->db_port."
DB.User=".$hsd->db_user."
DB.Pass=".$hsd->db_pass."
#HSD Applications database names
HSD.DBName=".$hsd->hsd_dbname."
#AMI Configuration
AMI.Host=".$hsd->ami_host."
AMI.Port=".$hsd->ami_port."
AMI.User=".$hsd->ami_user."
AMI.Pass=".$hsd->ami_pass."
#Application Path Configuration
HSD.TempPath=".$hsd->hsd_temp_path."
HSD.AstConfigPath=".$hsd->hsd_asterisk_path."
HSD.NetworkPath=".$hsd->hsd_network_path."
HSD.LogPath=".$hsd->hsd_logpath."
HSD.AGIPath=".$hsd->hsd_agipath."
HSD.ConfigPath=".$hsd->hsd_configpath."
HSD.DaemonPath=".$hsd->hsd_daemonpath."
#Set Debug Mode
HSD.TimeZone.Debug=".$hsd->hsd_timezonedebug."
#set the default thread sleep
##!!! DO NOT CHANGE UNLESS YOU KNOW WHAT YOU ARE DOING !!!
## A WRONG VALUE WILL BREAK THE DIALER FUNCTIONALITY
HSD.DefaultThreadSleep=".$hsd->hsd_defaultthreadsleep."
HSD.LogCalls=".$hsd->hsd_logcalls."
HSD.DBConnections=".$hsd->hsd_dbconnections."
HSD.DebugEvents=false
HSD.LogManagerActivity=".$hsd->hsd_logmanageractivity."
HSD.PluginPath=".$hsd->hsd_pluginpath."
HSD.CallFlowDispatcherDelay=".$hsd->hsd_dispatcherdelay."
";

  fwrite($fh, $content);
  fclose($fh);
}

function dash_list_agents($campaign_id){
  //Getting Live List Name
  $camp = new Campaigns();
  $camp->load_single("id='{$campaign_id}'");
  //Getting total of answered calls
  $ta = new DataManager();
  $ta->dm_custom_query("SELECT COUNT(id) as answered FROM ".$camp->dial_list." WHERE NATURAL_last_dial_status='ANSWER'",true);
  //Getting all the Agents that logged in at least once on this Campaign
  $ca = new DataManager();
  $ca->dm_load_custom_list("SELECT COUNT(id) as answered, NATURAL_connected_agent as agent, NATURAL_agent_channel as extension FROM ".$camp->dial_list." WHERE NATURAL_last_dial_status='ANSWER' AND NATURAL_connected_agent!='' GROUP BY NATURAL_connected_agent","ASSOC");
	$check 	= false;
	$end		= "NOW";
  if($ca->affected > 0){
    for($i=0; $i<$ca->affected; $i++){
      //Calculating the percentual of this Agent
      $percent = 0;
      if($ca->data[$i]['answered']>0){
        $percent = round(($ca->data[$i]['answered'] * 100) / $ta->answered, 2);
      }

      $user = new AcdAgent();
      $user->load_single("username='{$ca->data[$i]['agent']}'");

      $list .= "<tr>";
      $list .= "<td>{$ca->data[$i]['agent']}</td>";
      $list .= "<td>{$user->name}</td>";
      $list .= "<td>{$ca->data[$i]['extension']}</td>";

      $agent = new AgentsTracker();
      $agent->load_single("agent_name='{$ca->data[$i]['agent']}' LIMIT 1");
      if($agent->affected>0){
				if($camp->status=='C'){
					$list .= "<td class='loggedout'>Logged Out</td>";
					$check = false;
				}else{
					$list .= "<td class='".strtolower($agent->last_action)."'>".ucfirst(strtolower($agent->last_action))."</td>";
					$check = true;
				}
      }else{
        $list .= "<td class='loggedout'>Logged Out</td>";
				$check = false;
      }
			if($check){
				$edate = strtotime($end);
				$sdate = strtotime($agent->last_action_stamp);
				$time = $edate - $sdate;
				$time_final = sec2hms($time);
				$list .= "<td>".$time_final."</td>";
			}else{
				$list .= "<td></td>";
			}

      $list .= "<td>".$ca->data[$i]['answered']." (".$percent." %)</td>";
      $list .= "</tr>";
    }
    $resp = "<div id='dashboard-agent-name'>Connected Agents</div>
      <table class='dash-agent-list-table'>
        <thead>
          <th>Username</th>
          <th>Agent</th>
          <th>Extension</th>
          <th>Status</th>
          <th>Elapsed</th>
          <th>Answered</th>
        </thead>
        <tbody>
        {$list}
        </tbody>
      </table><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
  }else{
    if($camp->dialing_logic==0){
    	$resp = "<div id='dashboard-agent-name'>Connected Agents</div>
      <table class='dash-agent-list-table'>
        <thead>";
			$resp .= "No Agent Logged In at this time";
			$resp .= "</thead></table><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
    }else{
			$resp = "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
    }
  }
  return $resp;
}

function show_dashboard_fullscreen_content($data){
	$qc = new Campaigns();
	$qc->load_list("ASSOC","id='{$data['campaign_id']}'");
//	print_debug($qc);

	if($qc->affected<1){
		$dashtable = "No Active Campaign found at this time!";
	}else{
    switch($qc->data[0]['dialing_logic']){
      case 0:
        $type = "Progressive";
        break;
      case 1:
        $type = "Predictive";
        break;
      case 2:
        $type = "Power";
        break;
    }
    switch($qc->data[0]['status']){
      case "R":
        $status = "Running";
        break;
      case "P":
        $status = "Paused";
        break;
      case "C":
        $status = "Completed";
        break;
    }
    $dashtable = '<div id="dashboard-campaign-name">'.$qc->data[0]['name'].' ('.$type.') | Status: <span id='.$status.'>'.$status.'</span><input type="hidden" name="Campaign_id" id="campaign_id" value="'.$qc->data[0]['id'].'"></div><br>';
    $info = dashboard_campaign_get_info($qc->data[0]['id']);
    if($info['data']!=100){
      $dashtable .= '<div id="dashboard-progress">'.dashboard_progress($qc->data[0]['id']).'</div>';


      $dashtable .= '<div id="chart-agent-wrapp">';
      $dashtable .= '<div id="dash-chart"></div>
               <script>
                 pie_data = [' . $info['data']  . '];
                 pie_legend = [' . $info['legend'] . '];
                 pie_color = [' . $info['color'] . '];
                 make_pie("dash-chart", null, pie_data, pie_legend, pie_color, 100, 200, 70, 180, 60, "east", false);
               </script>';

      $dashtable .= '<div id="dash-agents">'.dash_list_agents($qc->data[0]['id']).'</div></div>';
    }else{
      $dashtable .= 'Not enough data available to draw a chart!';
    }
  }
  return $dashtable;
}
?>
