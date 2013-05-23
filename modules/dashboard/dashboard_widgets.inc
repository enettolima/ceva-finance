<?php
/**
 * This file is used to organize and display the dashboard widgets
 */

 

/**
 * Dashboard Widget - Server Properties
 */ 
function server_properties() {
	$data 		= shell_exec('uptime');
	$uptime 	= explode(' up ', $data);
	$uptime 	= explode(',', $uptime[1]);
	$osversion= explode(';', $_SERVER['HTTP_USER_AGENT']);
	$disk			= exec('df --total');
	$line 		= explode(' ',$disk);
	foreach($line as $key =>$val){
		if(strpos($val, "%")){
			$used 		= $val;
		}
	}
	$total 		= ceil(($line[16]/1024)/1024);
	$used_abs	= ceil(($line[18]/1024)/1024);
	$free_abs	= ceil(($line[19]/1024)/1024);
	$free			= 100-$used;

	$chart_info = str_replace('%','',$used).','.$free;
	$legend			= '"'.$used.' Used","'.$free.'% Free"';

      $response = '<table class="dash-table">
          <tr class="even">
            <td>Server Uptime:</td>
            <td>'.$uptime[0].'</td>
          </tr>
          <tr class="odd">
            <td>Server Date:</td>
            <td>' . date('l jS \of F Y') . '</td>
          </tr>
          <tr class="even">
            <td>Server Time:</td>
            <td>'. date('h:i:s A') .'</td>
          </tr>
          <tr class="odd">
            <td>Timezone:</td>
            <td>'.date('T (O)').'</td>
          </tr>
          <tr class="even">
            <td>Disk Utilization:</td>
            <td>Total: '.$total.'Gb / ' . $used . ' Used (' . $free . '% Available)</td>
          </tr>
          <tr class="odd">
            <td colspan="2"><div id="disk-util" class="small-pie"></div><td>
          </tr>
          </table>
           <script>
			pie_data = [' . $chart_info  . '];
			pie_legend = [' . $legend . '];
			pie_color = [' . $color . '];
			make_pie("disk-util", null, pie_data, pie_legend, pie_color, 40, 38, 30, 120, 60, "east", false);
		</script>
          ';
	return $response;
}
 	
 /**
 * Dashboard Widget - Server Environment
 */ 
function server_environment() {
  $dm = new Datamanager();
	$dm->dm_load_custom_list("SHOW VARIABLES","ASSOC");
	if($dm->affected>0){
		for($i=0; $i<$dm->affected; $i++){
			switch($dm->data[$i]['Variable_name']){
				case "wait_timeout":
					$timeout= $dm->data[$i]['Value'];
					break;
				case "max_connections":
					$maxcon	= $dm->data[$i]['Value'];
					break;
				case "connect_timeout":
					$contimeout	= $dm->data[$i]['Value'];
					break;
			}
		}
	}
	
	$st = new Datamanager();
	$st->dm_load_custom_list("SHOW STATUS","ASSOC");
	if($st->affected>0){
		for($i=0; $i<$st->affected; $i++){
			switch($st->data[$i]['Variable_name']){
				case "Threads_connected":
					$t_connected= $st->data[$i]['Value'];
					break;
				case "Threads_created":
					$t_created	= $st->data[$i]['Value'];
					break;
				case "Threads_running":
					$t_running	= $st->data[$i]['Value'];
					break;
			}
		}
	}
	$pl = new Datamanager();
	$pl->dm_load_custom_list("SHOW PROCESSLIST","ASSOC");
	if($pl->affected>0){
		for($i=0; $i<$pl->affected; $i++){
			$proc_list .= "<tr>
				<td>".$pl->data[$i]['Id']."</td>
				<td>".$pl->data[$i]['Host']."</td>
				<td>".$pl->data[$i]['Time']."</td>
			</tr>";
		}
	}
	
	$system = new SystemControl();
	$system->load_single("id>0 LIMIT 1");
	if($system->remove_duplicated_numbers){
		$img_dup_num = '<img src="themes/moonlight/images/on-dash-button.png" onclick="proccess_information(null, \'change_dup_num_status\', \'dashboard\', null, \'current_status|1\', null, \'dup-num\');">';
	}else{
		$img_dup_num = '<img src="themes/moonlight/images/off-dash-button.png" onclick="proccess_information(null, \'change_dup_num_status\', \'dashboard\', null, \'current_status|0\', null, \'dup-num\');">';
	}
	
	if($system->remove_temporary_dial_list){
		$img_tmp_list = '<img src="themes/moonlight/images/on-dash-button.png" onclick="proccess_information(null, \'change_temp_dial_list\', \'dashboard\', null, \'current_status|1\', null, \'tmp-list\');">';
	}else{
		$img_tmp_list = '<img src="themes/moonlight/images/off-dash-button.png" onclick="proccess_information(null, \'change_temp_dial_list\', \'dashboard\', null, \'current_status|0\', null, \'tmp-list\');">';
	}
	$ftp = new FtpAutoExport();
	$ftp->load_single("id>0 LIMIT 1");
	if($ftp->enabled){
		$ftpstatus = "Enabled";
		$ftpclass  = '';
	}else{
		$ftpstatus = "Disabled";
		$ftpclass  = 'class="disabled"';
	} 
$response = '<table class="dash-table">
          <tr class="even">
            <td>Database Thread Timeout:</td>
            <td>'.$timeout.'</td>
          </tr>
          <tr class="odd">
            <td>Database Connection Timeout:</td>
            <td>' . $contimeout. '</td>
          </tr>
          <tr class="even">
            <td>Database connection Limit:</td>
            <td>'. $maxcon .'</td>
          </tr>
          <tr class="odd">
            <td>Threads Connected:</td>
            <td>'.$t_connected.'</td>
            </tr>
          </table>';
	return $response;

}

/**
 * Dashboard Widget - Server Logs
 */ 
function activity_logs() {
  $logs = new DataManager();
	$logs->dm_load_custom_list("SELECT * FROM ".NATURAL_DBNAME.".log_error ORDER BY id DESC LIMIT 4","ASSOC");
	if($logs->affected>0){
		for($i=0; $i<$logs->affected; $i++){
      if($i%2){
        $class='even';
      }else{
        $class='odd';
      }
      if(strlen($logs->data[$i]['notes'])>40){
        $logcontent = substr($logs->data[$i]['notes'], 0, 40).'...';
      }else{
        $logcontent = $logs->data[$i]['notes'];
      }
			$log .= "<tr class='{$class}'>
				<td><div class='log-image'></div><div class='log-message'>".$logcontent."</div></td>
				<td>".$logs->data[$i]['timestamp']."</td>
				</tr>";
		}
	} 
  $response = '
		<table class="tablelog">
		  <thead>
				<th>Notes</th>
				<th>Timestamp</th>
      </thead>
			<tbody class="red">
			  ' . $log . '
      </tbody>
    </table><div class="extra-function"><a onclick="proccess_information(null, \'log_list\', \'system\');">View More...</a></div>'; 
  return $response;
}
 
function show_inbound_outbound() {
  $dm = new DataManager();
  $dm->dm_load_custom_list("SELECT count(src) AS total FROM cdrs.raw_cdr WHERE calldate BETWEEN '2011-09-10' AND '2011-10-10' AND (dcontext='trunkRoutes' OR dcontext='hcs-local-exten')", "ASSOC");
  $total 		  = $dm->data[0]['total'];
  $dm = new DataManager();
  $dm->dm_load_custom_list("SELECT count(src) AS outbound FROM cdrs.raw_cdr WHERE calldate BETWEEN '2011-09-10' AND '2011-10-10' AND dcontext='trunkRoutes'", "ASSOC");
  $outbound   = $dm->data[0]['outbound'];
	$inbound	  = $total - $outbound;
  $outbound_p = ceil(($outbound/$total)*100);
  $inbound_p  = ceil(($inbound/$total)*100);

	$chart_info = str_replace('%','',$outbound_p).','.$inbound_p;
	$legend			= '"'.$outbound_p.'% Outbound('.$outbound.')","'.$inbound_p.'% Inbound('.$inbound.')"';

  $response = '<table class="dash-table">
    <tr class="even">
      <td>Total Calls processed in the last 30 days:</td>
      <td>'.$total.'</td>
    </tr>
    <tr class="odd">
      <td colspan="2"><div id="inbound-outbound" class="small-pie"></div><td>
    </tr>
  </table>
  <script>
    pie_data = [' . $chart_info  . '];
    pie_legend = [' . $legend . '];
    pie_color = [' . $color . '];
    make_pie("inbound-outbound", null, pie_data, pie_legend, pie_color, 40, 38, 30, 120, 60, "east", false);
  </script>';
  return $response;
}

function show_calls_by_hour(){
  //$today      = "2011-10-11";
  $today      = date("Y-m-d");
  for($i=0; $i<6; $i++){
    $total      = 0;
    $hourlabel  = date("G",strtotime("-".$i." hour"));
    $hour       = date("G",strtotime("-".$i." hour"));
    $dm         = new DataManager();
    $dm->dm_load_custom_list("SELECT count(src) AS total FROM cdrs.raw_cdr WHERE calldate BETWEEN '".$today." ".$hour.":00:00' AND '".$today." ".$hour.":59:59' AND (dcontext='trunkRoutes' OR dcontext='hcs-local-exten')", "ASSOC");
    $total      = $dm->data[0]['total'];
    $info[]     = "['{$hour}:00',{$total}]";
    $average_total = $average_total + $total;
  }
  $cinfo      = array_reverse($info);
  //$chart_info = "['2011-10-07 4:00PM',4], ['2011-10-08 4:00PM',18], ['2011-10-09 4:00PM',23], ['2011-10-10 4:00PM',55], ['2011-10-11 4:00PM',15]";
  $chart_info = implode(",",$cinfo);
  $average  = ceil($average_total/6);
  $response = '<table class="dash-table">
    <tr class="even">
      <td><i>Average calls/hour(last 6 hours):</i></td>
      <td>'.$average.'</td>
    </tr>
    <tr class="odd">
      <td colspan="2"><div id="trunks-max" class="max-trunks"></div><td>
    </tr>
  </table>
  <script>
    chart_data = [' . $chart_info  . '];
    make_line_chart("trunks-max", "Total Calls/Hour", chart_data, true, false, "%#H:%S");
  </script>';
  return $response;
}

function outbound_dialer_report(){
  $dm = new DataManager();
  $dm->dm_load_custom_list("SELECT count(src) AS total FROM cdrs.raw_cdr WHERE calldate BETWEEN '2011-09-10' AND '2011-10-10' AND dcontext='trunkRoutes'", "ASSOC");
  $total      = $dm->data[0]['total'];
  $dm = new DataManager();
  $dm->dm_load_custom_list("SELECT count(src) AS dialer FROM cdrs.raw_cdr WHERE calldate BETWEEN '2011-09-10' AND '2011-10-10' AND origin='Dialer'", "ASSOC");
  $dialer     = $dm->data[0]['dialer'];
	$exten  	  = $total - $dialer;
  $dialer_p   = ceil(($dialer/$total)*100);
  $exten_p    = ceil(($exten/$total)*100);

	$chart_info = $dialer_p.','.$exten_p;
	$legend			= '"'.$dialer_p.'% By Agents","'.$exten_p.'% By Dialer"';
  if($dialer==0){
    $chart_info = '100,0';
    $legend			= '"'.$exten_p.'% By Agents","No calls made by the Dialer"';
  }elseif($exten==0){
    $chart_info = '100,0';
    $legend			= '"'.$dialer_p.'% By dialer","No calls made by Agents"';
  }

  $response = '<table class="dash-table">
    <tr class="even">
      <td>Total Outbound Calls in the last 30 days:</td>
      <td>'.$total.'</td>
    </tr>
      <tr class="odd">
      <td colspan="2"><div id="outbound-dialer" class="small-pie"></div><td>
    </tr>
  </table>
  <script>
    pie_data = [' . $chart_info  . '];
    pie_legend = [' . $legend . '];
    pie_color = [' . $color . '];
    make_pie("outbound-dialer", null, pie_data, pie_legend, pie_color, 40, 38, 30, 120, 60, "east", false);
  </script>';
  return $response;
}

function total_calls_by_month(){
  for($i=0; $i<6; $i++){
    $total      = 0;
    $monthlabel = date("M",strtotime("-".$i." month"));
    $month      = date("m",strtotime("-".$i." month"));
    $dm         = new DataManager();
    $dm->dm_load_custom_list("SELECT count(src) AS total FROM cdrs.raw_cdr WHERE calldate BETWEEN '2011-".$month."-01' AND '2011-".$month."-31' AND (dcontext='trunkRoutes' OR dcontext='hcs-local-exten')", "ASSOC");
    $total      = $dm->data[0]['total'];
    $info[]     = "['{$monthlabel}',{$total}]";
    if($i==0 || $i==1){
      $average_total = $average_total + $total;
    }
  }
  $cinfo      = array_reverse($info);
  $chart_info = implode(",",$cinfo);
  $average    = ceil($average_total/2);
  $response   = '<table class="dash-table">
    <tr class="even">
      <td>Average Calls by Month(last 60 days):</td>
      <td>'.$average.'</td>
    </tr>
    <tr class="odd">
      <td colspan="2"><div id="totalcalls" class="total-calls"></div><td>
    </tr>
  </table>
  <script>
    chart_data = [' . $chart_info  . '];
    make_bar_chart("totalcalls", "Total Calls by Month", chart_data, true, false);
  </script>';
  return $response;
}

function show_account_plan(){
  $cp = new DataManager();
  $cp->dm_load_single(NATURAL_DBNAME.".customer_plan","customer_id='{$_SESSION['selected_customer_id']}'");
  if($cp->affected<1){
    $select_plan = '<div class="dash-table-alert"><a onclick="load_popup(\'plan_sel\', \'list_plans\', \'plan\', \'Selection one Plan\', \'test_button\', true, false, 700, 500, false, false);">Select a plan</a></div>
    <script>
      $( "#plan-container" ).effect(\'pulsate\',null,1000);
    </script>';
    $plan_name        = 'No Plan Selected';
    $plan_description = 'Not Found';
  }else{
    $plan = new DataManager();
    $plan->dm_load_single(NATURAL_DBNAME.".plan","id='{$cp->plan_id}'");
    $plan_name = $plan->name;
    $plan_description = $plan->description;
  }
  $response = '<form name="plan_sel" id="plan_sel">
    <input type="hidden" name="testval" id="testval" value="hello world">
    <table class="dash-table" id="plan-container">
    <tr class="even">
      <td>Plan:</td>
      <td>'.$plan_name.'</td>
    </tr>
    <tr class="odd">
      <td>Description:</td>
      <td>'.$plan_description.'</td>
    </tr>
  </table>'.$select_plan;

  return $response;
}

function show_contact_information(){
  $cp = new DataManager();
  $cp->dm_load_single(NATURAL_DBNAME.".customer","id='{$_SESSION['selected_customer_id']}'");
  $loc = new DataManager();
  $loc->dm_load_single(NATURAL_DBNAME.".location","id='{$cp->location_id}'");
  $response = '<table class="dash-table">
    <tr class="even">
      <td>Name:</td>
      <td>'.$cp->name.'</td>
    </tr>
    <tr class="odd">
      <td>Aniversary Date:</td>
      <td>'.$cp->aniversary_date.'</td>
    </tr>
    <tr class="even">
      <td>Address:</td>
      <td>'.$loc->address.'</td>
    </tr>
    <tr class="odd">
      <td>City:</td>
      <td>'.$loc->city.'</td>
    </tr>
    <tr class="even">
      <td>State:</td>
      <td>'.$loc->state.'</td>
    </tr>
    <tr class="odd">
      <td>Zip:</td>
      <td>'.$loc->zip.'</td>
    </tr>
  </table><div class="extra-function"><a onclick="load_popup(null, \'edit_contact_information\', \'customer\', \'contact_info\', \'test_button\', true, false, 400, 450, false, false);">Edit</a></div>';

  return $response;
}


function show_tickets(){
  
  $info[]     = "['Open','8']";
  $info[]     = "['Closed','2']";
  $info[]     = "['Pending','3']";
  $cinfo      = array_reverse($info);
  $chart_info = implode(",",$cinfo);
  $average    = ceil($average_total/2);
  $response   = '<table class="dash-table">
    <tr class="odd">
      <td colspan="2"><div id="totalcalls" class="total-calls"></div><td>
    </tr>
    <tr class="odd">
      <td colspan="2"><div class="extra-function"><a href="#">Manage Tickets<a></div><td>
    </tr>
  </table>
  <script>
    chart_data = [' . $chart_info . '];
    make_bar_chart("totalcalls", "Total of Tickets by Status", chart_data, true, false);
  </script>';

  return $response;

}
?>
