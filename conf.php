<?
  require_once('bootstrap.php');

  $customer = new Customer();
  $dm       = new DataManager();
  $customer->load_list("ASSOC","type='C'");
  if($customer->affected){
    for($i=0; $i<$customer->affected; $i++){
      $ci = new CustomerItem();
      $ci->load_single("customer_id='{$customer->data[$i]['id']}'"); 
      if($ci->package_id>2){
        $user = new User();
        $user->load_single("customer_id='{$customer->data[$i]['id']}' LIMIT 1");

        $tool = new Tool();
        $conf = new Conference();
        $conf->customer_id  = $customer->data[$i]['id'];
        $conf->user_id      = $user->id;
        $conf->room         = $tool->generate_random_room();
        $conf->pin          = $dm->dm_random(false,4);
        $conf->admin_pin    = $dm->dm_random(false,4);
        $conf->status       = 1;
        $conf->insert();

        echo "Conference Number {$conf->room}<br>";
      }
    } 
  }else{
    echo "Customer Not Found";
  }

?>
