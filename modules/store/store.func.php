<?php

function load_store_menu() {
    return load_store();
}

function load_store() {
    //Add this after the first tr on the table
    //<td rowspan="3"><img src="'.TEMPLATE.'images/'.$pp->data[$i]['image'].'" /></td>
    $product_list .= '
      <div class="scProductListItem"> 
        <table border="0" cellpadding="2" cellspacing="2" class="scProduct">
        <tr>
        <td><span class="productTitle" id="prod_name' . $pp->data[$i]['id'] . '">' . $pp->data[$i]['name'] . '</span></td>
        </tr>
        <tr>
        <td><label>Price:</label> $<span id="prod_price' . $pp->data[$i]['id'] . '">' . $pp->data[$i]['nrc_retail'] . '</span></td>
        </tr>               
        <tr>
        <td><label>Quantity:</label>
        <input name="prod_qty" class="scText" id="prod_qty' . $pp->data[$i]['id'] . '" value="1" size="3" type="text">
        <input type="button" rel="' . $pp->data[$i]['id'] . '" class="scItemButton scBtn" value="Add Product"></td>
        </tr>              
        </table>
      </div>';
    //$content .= '<span class="store-setup-title closed">0 Items in your Cart</span><div id="dashboard-setup"></div>';

    $content = '<form id="shopping_cart" name="shopping_cart" action="javascript:proccess_information(\'shopping_cart\',\'confirm_order\',\'store\', null, null, null, \'confirm_order\');">
        <!-- Product list HTML -->
  <div id="smartcart" class="scContainer">         		
    <div id="sc_productlist" class="scProductList">
      ' . $product_list . ' 
    </div>
      <div id="sc_cart" class="scCart">
        <!-- Selected Product ID/Quantity are stored on the <select> element below -->
        <select id="product_list" name="product_list[]" style="display:none;" multiple="multiple">
        </select>               
         <div class="scCartListHead">
             <table class="scCartTableHead"><tr>
               <td>&nbsp;&nbsp;Product</td>
               <td width="80px">Quantity</td>
               <td width="130px">Amount ($)</td>
             </tr></table>
         </div>
         <!-- Cart List: Selected Products are listed inside div below -->
         <div id="sc_cartlist" class="scCartList"></div>
         
         <div class="scCartListHead">
             <table class="scCartTableHead"><tr>
               <td>
                  <!-- Message Label -->
                  <span id="sc_message"></span></td>
               <td width="100px">Subtotal ($):</td>
               <td width="120px"> 
                  <!-- Sub Total Label -->
                  <span id="sc_subtotal"></span>
               </td>
             </tr></table>
         </div>
         <br>
         <input style="width:200px;height:35px;float:right;" type="submit" class="scBtn" value="Checkout >>">
      </div>
      <!-- End Cart HTML -->
     </div>
     <div id="confirm_order" name="confirm_order"></div>
	</form>
  <script type="text/javascript">
		$(document).ready(function() {
		  // call the cart function
			$("#sc_cart").smartCart();
		}); 
	</script>';
    return $content;
}

function confirm_order($data) {
    if (count($data['product_list']) < 1) {
        return 'ERROR||You have to select at least one product, please try again!';
        exit(0);
    }
    for ($i = 0; $i < count($data['product_list']); $i++) {
        $product = '';
        $price = '';
        $product = explode("|", $data['product_list'][$i]);
        $pp = new PlanProduct();
        $pp->load_single("product_id='{$product[0]}'");
        if ($i % 2) {
            $class = 'odd';
        } else {
            $class = 'even';
        }
        $product_price = $pp->nrc_retail;
        $price = $product_price * $product[1];
        if ($pp->shipping_charge > 0) {
            $ship = $ship + ($product[1] * $pp->shipping_charge);
        }
        $product_list .= '<tr class="' . $class . '">
      <td>' . $pp->name . '</td>
      <td>' . $product[1] . '</td>
      <td>' . $product_price . '</td>
      <td>' . number_format($price, 2, '.', '') . '</td>
    </tr>';

        $sub_total = $sub_total + ($ship + $price);
    }
    //Function getCustomerPlanID is on lib/util.php
    $plan_id = getCustomerPlanID();
    $plan = new Plan();
    $plan->load_single("id='{$plan_id}'");
    $sales_tax = $sub_total * ($plan->sales_tax / 100);
    $total = $sub_total + $sales_tax;
    return '
    <div id="smartcart" class="scContainer">         		
      <h1>Please confirm your order!</h1>
      <table class="scCartConfirm">
        <tr>
          <th>Product</th>
          <th>Quantity</th>
          <th>Unit Price</th>
          <th>Amound ($)</th>
        </tr>
          ' . $product_list . '
        <tr>
          <td colspan="4"><hr></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td>Shipping Charges ($)</td>
          <td>' . number_format($ship, 2, '.', '') . '</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td>Sales Tax ($)</td>
          <td>' . number_format($sales_tax, 2, '.', '') . '</td>
        </tr>
        <tr class="even priceTotal">
          <td></td>
          <td></td>
          <td>Total ($)</td>
          <td>' . number_format($total, 2, '.', '') . '</td>
        </tr>
      </table>
      <input style="width:200px;height:35px;float:left;" type="button" class="scBtn" value="<< Back" onclick="javascript:proccess_information(\'shopping_cart\',\'back_to_cart\',\'store\', null, null, null, \'confirm_order\');">
      <input style="width:200px;height:35px;float:right;" type="button" class="scBtn" value="Complete Purchase >>" onclick="javascript:proccess_information(\'shopping_cart\',\'process_order\',\'store\', null, null, null, \'confirm_order\');">
    </div>

    <script type="text/javascript">
      $("#confirm_order").show();
      $("#smartcart").slideUp();
	  </script>';
}

function back_to_cart($data) {
    return '<script type="text/javascript">
      $("#smartcart").slideDown();
      $("#confirm_order").hide();
	  </script>';
}

function process_order($data) {
    print_debug($data);
}

?>
