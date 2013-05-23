<?php
  require_once('index.php');
  require_once('customer.func.php');
	$ct = new Customer();
	$ct->load_list('ASSOC',"status='3'");
	echo $ct->affected.' customers found with House status<br>';
	for($i=0; $i<$ct->affected; $i++){
		$data['customer_id'] 		= $ct->data[$i]['id'];
		$data['account_status'] = 0;
		//$update = update_customer_status($data);
		echo 'Customer ID: '.$ct->data[$i]['id'].' - Customer Name: '.$ct->data[$i]['name'].'<br>';
	}
?>
