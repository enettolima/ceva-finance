<?

/**
 * List of customers
 */
function customer_list($row_id = null, $search_query = NULL, $sort = NULL, $pager_current = 1) {
    $title = '<h1>' . translate('List of Customers', $_SESSION['log_preferred_language']) . '</h1>';
    $view = new ListView();

    $status_color = array('bullet_red', 'bullet_green', 'bullet_orange', 'bullet_blue');
    // Select Option for Status
    $customer_status = new SelectOption();
    $customer_status->load_list('ASSOC', 'upstream_name = "customer_status"');
    if ($customer_status->affected) {
        foreach ($customer_status->data as $value) {
            $status[$value['value']] = $value['description'];
        }
    }

    if ($search_query) {
        $search_fields = array('c.id', 'c.name', 'c.status', 'p.name', 'ct.email', 'ct.mobile_phone');
        $exceptions = array('c.status' => $status);
        $search_query = build_search_query($search_query, $search_fields, $exceptions);
    }

    if ($row_id) {
        $clause = 'c.id = ' . $row_id;
    } else {
        $clause = 'c.id <> 0';
    }

    if ($_SESSION['log_access_level'] < 71) {
        $clause .= ' AND c.partner_id = ' . $_SESSION['log_partner_id'];
    }

    // Sort
    if (!$sort) {
        $sort = 'c.id ASC';
    }

    $limit = PAGER_LIMIT;
    $start = ($pager_current * $limit) - $limit;
    // Customer Object
    $customer = new DataManager();
    $customer->dm_load_custom_list("SELECT c.id, c.name AS customer_name, c.status, ct.email, ct.mobile_phone, so.description AS customer_status
    FROM " . NATURAL_DBNAME . ".customer c
    LEFT JOIN " . NATURAL_DBNAME . ".contact ct ON c.contact_id = ct.id
    LEFT JOIN select_option so ON c.status = so.value AND so.upstream_name = 'customer_status'
    WHERE $clause  $search_query
    ORDER BY  $sort
															LIMIT  $start, $limit", 'ASSOC', TRUE);

    if ($customer->affected > 0) {
        // Building the header with sorter
        $fields[] = array('display' => 'Id', 'field' => 'c.id');
        $fields[] = array('display' => 'Name', 'field' => 'customer_name');
        $fields[] = array('display' => 'Contact Email', 'field' => 'ct.email');
        $fields[] = array('display' => 'Phone Number', 'field' => 'ct.mobile_phone');
        $fields[] = array('display' => 'Status', 'field' => 'so.description');
        //$fields[] = array('display' => 'Ticket', 'field' => NULL);
        $fields[] = array('display' => 'Edit', 'field' => NULL);
        $fields[] = array('display' => 'Delete', 'field' => NULL);
        $line[0] = build_sort_header('customer_list', 'customer', $fields, $sort);

        $total = 0;
        for ($i = 0; $i < $customer->affected; $i++) {
            $j = $i + 1;
            $line[$j][0] = $customer->data[$i]['id'];
            $line[$j][1] = $customer->data[$i]['customer_name'];
            $line[$j][2] = $customer->data[$i]['email'];
            $line[$j][3] = $customer->data[$i]['mobile_phone'];
            $line[$j][4] = '<img src="' . TEMPLATE . 'images/' . $status_color[$customer->data[$i]['status']] . '.png"> ' . $customer->data[$i]['customer_status'];
            //$line[$j][6] = '<img title="Add Trouble Ticket" alt="Add Trouble Ticket" class="pointer" src="'.TEMPLATE.'images/note-16x16.png" onclick="proccess_information(null, \'trouble_ticket_customer_add_new_form\', \'trouble_ticket\', \'\', \'customer_id|' . $customer->data[$i]['id'] . '\', \'\', this, \'slide\');">';
            //$line[$j][6] = "<a class=\"trouble-ticket-icon pointer\" onclick=\"proccess_information('listcustomers', 'trouble_ticket_customer_add_new_form', 'trouble_ticket', '', 'customer_id|{$customer->data[$i]['id']}', null, this, 'slide');\"></a>";
            $line[$j][5] = "<a class=\"edit-icon pointer\" onclick=\"parent.location='jump.php?url=customer_dash.php&customer_id={$customer->data[$i]['id']}'\">Edit</a>";
            if ($_SESSION['log_access_level'] == 81) {
                //$line[$j][7] = "<a class=\"delete-icon pointer\" onclick=\"proccess_information('listcustomers', 'delete_customer', 'customer', 'Are you sure you want to remove this Account? WARNING: All data will be erased from the database!', 'customer_id|{$customer->data[$i]['id']}', null, this, 'remove_row');\">Delete</a>";
                $line[$j][6] = "<a class=\"delete-icon disabled-icon\">Delete</a>";
            } else {
                $line[$j][6] = "<a class=\"delete-icon disabled-icon\">Delete</a>";
            }
            $total++;
        }
        if ($row_id) {
            $main_list = "<td>" . $line[1][0] . "</td><td>" . $line[1][1] . "</td><td>" . $line[1][2] . "</td><td>" . $line[1][3] . "</td><td>" . $line[1][4] . "</td><td>" . $line[1][5] . "</td><td>" . $line[1][6] . "</td>";
        } else {
            $main_list = $title . $view->realbuild(NULL, $line, 'customer_list', 'customer', $customer->total_records, $limit, $pager_current, $sort, $search_query);
        }
    } else {
        $main_list = $title . build_search_form('customer_list', 'customer') . 'No Customers to display.';
    }
    return $main_list;
}

function view_customer_info($block = NULL) {
    // Dashboard Configuration according logged user personal preferences
    //$content .= '<span class="dashboard-setup-title closed">Dashboard Setup</span><div id="dashboard-setup">' . dashboard_setup_form($_SESSION['dash_type']) . '</div>';
    // Load the dashboard widgets according pre cofigured by the logged user
    //$content .= '<div id="dashboard-widgets">' . dashboard_widgets($_SESSION['dash_type']) . '</div>';

    $content .= '</div>
  <form id="dashboard-form" name="dashboard-form">
	   Customer Test
    <input type="hidden" name="dashboard_type" id="dashboard_type" value="' . $_SESSION['dash_type'] . '">
  </form>
  <script type="text/javascript">
    $("#account-header").slideDown(800);
  </script>';
    return $content;
}

function edit_contact_information($data) {
    $customer = new Customer();
    $customer->load_single("id='{$_SESSION['selected_customer_id']}'");
    $contact = new Contact();
    $contact->load_single("id='{$customer->contact_id}'");
    $location = new Location();
    $location->load_single("id='{$customer->location_id}'");
    $sel = new SelectOption();
    $sel->load_list("ASSOC", "upstream_name='states' ORDER BY description");
    for ($i = 0; $i < $sel->affected; $i++) {
        $selected = '';
        if ($sel->data[$i]['value'] == 'TX') {
            $selected = 'selected';
        }
        $options .= '<option value="' . $sel->data[$i]['value'] . '" ' . $selected . '>' . $sel->data[$i]['description'] . '</option>';
    }
    $name = $customer->name;
    $email = $contact->email;
    return '
    <div id="dialog-form" title="Create new user">
    <p class="validateTips">All form fields are required.</p>
    <div id="error-field"></div>
    <form name="process_popup" id="process_popup">
      <input type="hidden" name="fn" id="fn" value="update_contact_info">
      <input type="hidden" name="module" id="module" value="customer">
      <fieldset>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" value="' . $name . '"/>
        <label for="address">Address</label>
        <input type="text" name="address" id="address" value="' . $location->address . '" class="text ui-widget-content ui-corner-all" />
        <label for="city">City</label>
        <input type="text" name="city" id="city" value="' . $location->city . '" class="text ui-widget-content ui-corner-all" />
        <label for="state">State</label>
        <select name="state" id="state" class="select ui-widget-content ui-corner-all">
          ' . $options . '
        </select>
        <label for="zip">Zip</label>
        <input type="text" name="zip" id="zip" value="' . $location->zip . '" class="text ui-widget-content ui-corner-all" />
      </fieldset>
    </form>
  </div>';
}

function update_contact_info($data) {
    if ($data['address'] == '' || $data['state'] == '' || $data['city'] == '' || $data['zip'] == '') {
        return 'ERROR||Invalid Address, all fields are required, please try again!';
    }
    $c = new Customer();
    $c->load_single("id='{$_SESSION['selected_customer_id']}'");
    $loc = new Location();
    $loc->load_single("id='{$c->location_id}'");
    $loc->address = $data['address'];
    $loc->city = $data['city'];
    $loc->state = $data['state'];
    $loc->zip = $data['zip'];
    if ($loc->affected > 0) {
        $loc->update("id='{$c->location_id}'");
        $c->name = $data['name'];
        $c->update("id='{$_SESSION['selected_customer_id']}'");
    } else {
        $loc->insert();
        $c->location_id = $loc->id;
        $c->name = $data['name'];
        $c->update("id='{$_SESSION['selected_customer_id']}'");
    }
    return "<script>
    menu_navigation('c_view_myinfo_side','view_customer_info','customer');
    $('#status-message').html('Address saved successfully!').addClass('container-success');
  </script>";
}

?>