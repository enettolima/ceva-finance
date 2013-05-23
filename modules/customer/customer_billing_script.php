<?
/** 
* HIVE - Copyleft Open Source Mind, GP 
* Last Modified: Date: 07-18-2009 19:15:01 -0500 (Jul-Sat-2009) $ @ Revision: $Rev: 11 $ 
* @package Hive 
*/
session_start();
require_once('../../bootstrap.php');
require_once(NATURAL_CLASSES_PATH.'datamanager.class.php');
require_once(NATURAL_CLASSES_PATH.'authorizenet.cim.class.php');


/**
 * Stopping script if the session is closed
 */
if(!$_SESSION['logged']) {
  echo "LOGOUT";
	exit;
} 
else {
	$month_year = '112009';
	$month_year_display = '11/2009';
	$table = NATURAL_DBNAME.'.customer_billing';
  print '<h2>Billing Script - Reference '.$month_year_display.'</h2>';	
	print '<p><form id="primary_charges_form" method="post" action="'.$_SERVER['PHP_SELF'].'"><select name="operation"><option value="">Choose one option</option><option value="1">Bill Customers</option><option value="2">Verify Payment Profile</option></select><input type="submit" value="Submit" /></form></p>'; 
	//<option value="3">Populate Payment Profile Table</option>
	$query = 'SELECT COUNT( * ) AS total
            FROM '.$table.' t
            WHERE t.transaction_status = 1';
  $cust_billed = new DataManager;
	$cust_billed->dm_load_custom_list($query , 'ASSOC');
	$query = 'SELECT COUNT( * ) AS total
            FROM '.$table.' t
            WHERE t.transaction_status = 0';
  $cust_not_billed = new DataManager;
	$cust_not_billed->dm_load_custom_list($query , 'ASSOC');
  print '<ul>
					 <li><a href="'.$_SERVER['PHP_SELF'].'">Clean the page and get new statistic</a></li>
	         <li>Successful billed customers: '.$cust_billed->data[0]['total'].'</li>
					 <li>Unsuccessful billed customers: '.$cust_not_billed->data[0]['total'].'</li>
	       </ul>';	
  print '<table>';
	$operation = $_POST['operation'];			 
	if ($operation == 1) {
	  customer_billing_transaction($table, $month_year, $month_year_display);
  }
	elseif ($operation == 2) {
		verify_customer_payment_profile($table);
	}
	elseif ($operation == 3) {
    populate_payment_profile_table();		
	}
	else {
		print '<tr><td>You need to select one option and submit</td></tr>';
	}
	print '</table>';
}

/**
 * Function that make a payment transaction via createCustomerProfileTransactionRequest for first time
 */
function customer_billing_transaction($table, $month_year, $month_year_display) {
  $query = 'SELECT cb.customer_id, cb.customer_name, cb.mrc AS amount, cb.transaction_count, c.id, c.name, c.cim_id, p.id AS package_id, p.name AS package_name, p.mrc_retail AS package_price
				    FROM '.$table.' cb
						LEFT JOIN customer c ON cb.customer_id = c.id
						LEFT JOIN customer_item ci ON cb.customer_id = ci.customer_id
						LEFT JOIN package p ON ci.package_id = p.id
						WHERE cb.transaction_status = 0 
						ORDER BY cb.customer_name';
  $customers = new DataManager;
	$customers->dm_load_custom_list($query , 'ASSOC');
	print '<tr><td><b>Customer ID</b></td><td><b>Customer Display Name</b></td><td><b>Message Response<b></td><td><b>Status<b></td><td><b>Transaction Count<b></td><td><b>Transaction ID<b></td><td><b>Amount</b></td><td><b>Tax</b></td><td><b>Fee</b></td><td><b>Total Amount</b></td></tr>';
	$whole_total_amount = 0;
	$whole_total_fee = 0;
	$whole_total_tax = 0;
	$whole_total = 0;
	if ($customers->affected) {
	  foreach ($customers->data as $customer) {
			// Formatting the amount in a valid format
			$amount = $customer['amount'];
			$whole_total_amount = $whole_total_amount + $amount;
			$fee = 1.40;
			$whole_total_fee = $whole_total_fee + $fee;
	    $tax = round((($amount * 8.25) / 100), 2);
			$whole_total_tax = $whole_total_tax + $tax;
			$total_amount = number_format(($amount + $tax + $fee), 2, '.', '');
			$whole_total = $whole_total + $total_amount;
			// ***************************************************************************************
      // Creating the object >>> FALSE gets REAL action
			$cim = new AuthNetCim(NATURAL_ANET_USERNAME, NATURAL_ANET_PASSWORD, false);
			// ***************************************************************************************
			// Put the variables in the object
			$count = $customer['transaction_count'] + 1;
			$invoice = $customer['customer_id'] . date('Ymd') . $count; 
			$invoice_description = 'Monthly Recurring Charge '.$month_year_display;
			$cim->setParameter('refId', $invoice);
			$cim->setParameter('transactionType', 'profileTransAuthCapture');
			$cim->setParameter('transaction_amount', $total_amount);
			$cim->setParameter('customerProfileId', $customer['cim_id']);
			$cim_payment_id = get_customer_payment_profile_id($customer['cim_id']);  
			$cim->setParameter('customerPaymentProfileId', $cim_payment_id); 
			// Tax
			$cim->SetParameter('tax_amount', $tax);
			$cim->SetParameter('tax_name', 'State Tax');
			$cim->SetParameter('tax_description', '8.25%');
			// LineItems
		  $cim->LineItems = array(array('itemId' => 1, 'name' => 'FUSF', 'description' => 'Government Regulamentary Fee',  'quantity' => 1, 'unitPrice'=> $fee), array('itemId' => $customer['package_id'], 'name' => 'Package', 'description' => $customer['package_name'], 'quantity' => 1, 'unitPrice'=> $amount));
			// Invoice
			$cim->SetParameter('order_invoiceNumber', $invoice);
			$cim->SetParameter('order_description', $invoice_description);		
			// ***************************************************************************************
			$cim->createCustomerProfileTransactionRequest();
			// ***************************************************************************************
			// Getting the transaction id if there is
			$transaction_id = '';
			$xml = explode('|', $cim->response);
			if (is_numeric($xml[6])) {
        $transaction_id = $xml[6];
			}
			// Insert values from customer and response in the database
			$fields = array();
			$fields['customer_id'] = $customer['customer_id'];
			$fields['customer_name'] = $customer['customer_name'];
			$fields['mrc'] = $amount;
			$fields['transaction_count'] = $count;
			// If there is an error the status message will be the error message from authorize.net
	    if ($cim->error_messages) {
				$error_message = '';
				foreach($cim->error_messages as $message) {
					$error_message .= $message . '; ';
			  }
		    $fields['transaction_status_msg'] = $error_message . ' ' . $cim->directResponse; 
			} 
			else {
				$fields['transaction_status_msg'] = $cim->text . ' ' . $cim->directResponse; 
			}
			// Update the the $table with new values from the secondary attempts 
			if ($cim->success == 1) {
			  $fields['transaction_status'] = 1;
 			} 
			if ($cim->error == 1) {
				$fields['transaction_status'] = 0;
			}
 		  $cust = new DataManager();
		  $cust->dm_update($table, 'customer_id = '.$fields['customer_id'], $fields);
			// Report to ben user on the screen
			$transaction_status = ($fields['transaction_status']) ? 'Billed' : 'Not Billed';
			print '<tr><td>'.$customer['customer_id'].'</td><td>'.$customer['customer_name'].'</td><td>'.$fields['transaction_status_msg'].'</td><td>'.$transaction_status.'</td><td>'.$fields['transaction_count'] .'</td><td>'.$transaction_id.'</td><td>'.$amount.'</td><td>'.$tax.'</td><td>'.$fee.'</td><td>'.$total_amount.'</td></tr>';
			// Transaction table insert
			$transaction = new DataManager();
			$transaction_table = NATURAL_DBNAME.'.transaction';
			$transaction_fields = array();
  		$transaction_fields['invoice_number'] = NULL;
			$transaction_fields['customer_id'] = $customer['customer_id'];
			$transaction_fields['reference_type'] = 'PACKAGE';
			$transaction_fields['reference'] = $customer['package_id'];
	    $transaction_fields['payment_type'] = 'CC';
      $transaction_fields['merchant_transaction_id'] = $transaction_id;
      $transaction_fields['merchant_name'] = 'AUTHORIZE';
			if ($count == 1) {
				$transaction_fields['transaction_code'] = 7;
				$transaction_fields['payment_status'] = '';
        $transaction_fields['amount'] = '-'.$total_amount;
				$transaction_fields['description'] = $invoice_description; 
				$transaction->dm_insert($transaction_table, $transaction_fields);
			}
      if ($cim->success == 1) {
				$transaction_fields['transaction_code'] = 8;
				$transaction_fields['payment_status'] = 'APPROVED';
        $transaction_fields['amount'] = $total_amount;
				$transaction_fields['description'] = 'Monthly Recurring Payment'; 
			}
			else {
				$transaction_fields['transaction_code'] = 8;
			  $transaction_fields['amount'] = 0.00;
				$transaction_fields['payment_status'] = 'DECLINED';
				$transaction_fields['description'] = 'Monthly Recurring Payment'; 
			}
			$transaction->dm_insert($transaction_table, $transaction_fields);
		}
	}
	else {
		print '<tr><td>No users to be charged</td></tr>';
	}
	print '<tr><td><b>Totals</b></td><td><b>'.$customers->affected.'</b></td><td>-</td><td>-</td><td>-</td><td>-</td><td><b>'.$whole_total_amount.'</b></td><td><b>'.$whole_total_tax.'</b></td><td><b>'.$whole_total_fee.'</b></td><td><b>'.$whole_total.'</b></td></tr>';
}

/**
 * This function verifies if the customer are registered on Authorize.net correctly
 */
function verify_customer_payment_profile($table) {
  $query = 'SELECT cb.customer_id, cb.customer_name, cb.mrc AS amount, cb.transaction_count, c.id, c.name, c.cim_id, p.id AS package_id, p.name AS package_name, p.mrc_retail AS package_price
				    FROM '.$table.' cb
						LEFT JOIN customer c ON cb.customer_id = c.id
						LEFT JOIN customer_item ci ON cb.customer_id = ci.customer_id
						LEFT JOIN package p ON ci.package_id = p.id
            ORDER BY cb.customer_name';
  $customers = new DataManager;
	$customers->dm_load_custom_list($query , 'ASSOC');
	print '<tr><td><b>Customer ID</b></td><td><b>Customer Display Name</b></td><td><b>CIM ID<b></td><td><b>CIM Payment ID<b></td><td><b>Package ID<b></td><td><b>Package Name</b></td><td><b>Package Price</b></td></tr>';
	if ($customers->affected) {
	  foreach ($customers->data as $customer) {
			// ***************************************************************************************
		  // Creating the object >>> FALSE gets REAL action
			$cim = new AuthNetCim(NATURAL_ANET_USERNAME, NATURAL_ANET_PASSWORD, false);
			// ***************************************************************************************
			$cim_payment_id = get_customer_payment_profile_id($customer['cim_id']);
		  print '<tr><td>'.$customer['customer_id'].'</td><td>'.$customer['customer_name'].'</td><td>'.$customer['cim_id'].'</td><td>'.$cim_payment_id.'</td><td>'.$customer['package_id'] .'</td><td>'.$customer['package_name'].'</td><td>'.$customer['package_price'].'</td></tr>';
		}
	}
	else {
		print '<tr><td>No users to be verified</td></tr>';
	}
}


/**
 * This function is going to populate of the existing customers to the payment_profile table
 */
function populate_payment_profile_table() {
	$query = 'SELECT c.id, c.name, c.cim_id
				    FROM customer c
            ORDER BY c.id';
  $customers = new DataManager();
	$customers->dm_load_custom_list($query , 'ASSOC');
	print '<tr><td><b>Customer ID</b></td><td><b>Customer Name</b></td><td><b>CIM ID<b></td><td><b>CIM Payment ID<b></td><td><b>CC Masked<b></td></tr>';
  if ($customers->affected) {
		foreach ($customers->data as $customer) {
			$fields = array();
			$fields['customer_id'] = $customer['id'];
			$fields['cim_id'] = $customer['cim_id'];
			$fields['cim_payment_id'] = get_customer_payment_profile_id($customer['cim_id']);
			$fields['cc_mask'] = substr(get_customer_payment_profile_info($fields['cim_id'], $fields['cim_payment_id']) , 4);
			$fields['primary_profile'] = 1;
			$payment_profile = new DataManager();
			$payment_profile->dm_insert(NATURAL_DBNAME.'.payment_profile', $fields); 
      print '<tr><td>'.$customer['id'].'</td><td>'.$customer['name'].'</td><td>'.$fields['cim_id'].'</td><td>'.$fields['cim_payment_id'].'</td><td>'.$fields['cc_mask'].'</td></tr>';
		}
	}
	else {
		print '<tr><td>No users to be inserted on payment_profile table</td></tr>';
	}
}

/**
 * This function returns the customerPaymentProfile id from authorize.net
 */
function get_customer_payment_profile_id($cim_id) {
  // Creating the object >>> FALSE gets REAL action
	$cim_payment = new AuthNetCim(NATURAL_ANET_USERNAME, NATURAL_ANET_PASSWORD, false);
	$cim_payment->SetParameter('customerProfileId', $cim_id);
	$cim_payment->getCustomerProfileRequest();
	return $cim_payment->customerPaymentProfileId;
}

/**
 * This function returns items (credit-card in this case) from the Payment Profile from  authorize.net
 */
function get_customer_payment_profile_info($cim_id, $cim_payment_id) {
	// ***************************************************************************************
	// Creating the object >>> FALSE gets REAL action
	$cim_payment_profile = new AuthNetCim(NATURAL_ANET_USERNAME, NATURAL_ANET_PASSWORD, false);
	// ***************************************************************************************
  $cim_payment_profile->SetParameter('customerProfileId', $cim_id);
	$cim_payment_profile->SetParameter('customerPaymentProfileId', $cim_payment_id);
	$cim_payment_profile->getCustomerPaymentProfileRequest();	
	$cc = $cim_payment_profile->substring_between($cim_payment_profile->response,'<cardNumber>','</cardNumber>');
	return $cc;
}

?>

<style>
  h2 {
		color: #666;
	}
	
  table {
		font-family: Arial, Helvetica, sans-serif;
		margin: 25px 0 25px 0;
		width: 100%;
	}
	
  table td {
		border: 1px solid #ccc;
		padding: 4px;
		font-size: 12px;
	}
	
	ul {
		color: #666;
		font-family: Arial, Helvetica, sans-serif;
		font-size: 11px;
		margin: 25px 0 25px;
	}
</style>
