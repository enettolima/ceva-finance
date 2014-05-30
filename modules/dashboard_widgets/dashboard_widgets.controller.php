<?

/**
 * List items
 */
function dashboard_widgets_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
    $view = new ListView();
    // Row Id for update only row
    if (!empty($row_id)) {
      $row_id = 'b.id = ' . $row_id;
    } else {
      $row_id = 'b.id != 0';
    }
    
    // Search
    if (!empty($search)) {
        $search_fields = array('b.id', 'b.title', 'b.description');
        $exceptions = array();
        $search_query = build_search_query($search_query, $search_fields, $exceptions);
    } else {
        $search_query = '';
    }

    // Sort
    if (empty($sort)) {
        $sort = 'b.id ASC';
    }

    $limit = PAGER_LIMIT;
    $start = ($page * $limit) - $limit;
    
    // Dial List Table Object
    $dashboard_widgets = new DataManager();
    $dashboard_widgets->dmLoadCustomList("SELECT b.*
    FROM " . NATURAL_DBNAME . ".dashboard_widgets b
    WHERE $row_id  $search_query
    ORDER BY  $sort 
    LIMIT  $start, $limit", 'ASSOC', TRUE);
    
    if ($dashboard_widgets->affected > 0) {
        // Building the header with sorter
        $headers[] = array('display' => 'Id', 'field' => 'b.id');
        $headers[] = array('display' => 'Title', 'field' => 'b.title');
        $headers[] = array('display' => 'Description', 'field' => 'b.description');
        $headers[] = array('display' => 'Edit', 'field' => NULL);
        $headers[] = array('display' => 'Delete', 'field' => NULL);
        $headers = build_sort_header('dashboard_widgets_list', 'dashboard_widgets', $headers, $sort);

        for ($i = 0; $i < $dashboard_widgets->affected; $i++) {
            $j = $i + 1;
            //This is important for the row update/delete
            $rows[$j]['row_id'] = $dashboard_widgets->data[$i]['id'];
            /////////////////////////////////////////////
            $rows[$j]['id']     = $dashboard_widgets->data[$i]['id'];
            $rows[$j]['title']   = $dashboard_widgets->data[$i]['title'];
            if(strlen($dashboard_widgets->data[$i]['description'])>50){
                $rows[$j]['description'] = substr($dashboard_widgets->data[$i]['description'], 0, 50).'...';    
            }else{
                $rows[$j]['description'] = $dashboard_widgets->data[$i]['description'];    
            }
            $rows[$j]['edit']   = theme_link_process_information('', 'dashboard_widgets_edit_form', 'dashboard_widgets_edit_form', 'dashboard_widgets', array('extra_value' => 'dashboard_widgets_id|' . $dashboard_widgets->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_EDIT_ICON, 'class' => $disabled));
            $rows[$j]['delete'] = theme_link_process_information('', 'dashboard_widgets_delete_form', 'dashboard_widgets_delete_form', 'dashboard_widgets', array('extra_value' => 'dashboard_widgets_id|' . $dashboard_widgets->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON, 'class' => $disabled));
        }
    }
    
    $options = array(
        'show_headers' => TRUE,
        'page_title' => translate('Users List'),
        'page_subtitle' => translate('Manage Dashboard Widgetss'),
        'empty_message' => translate('No dashboard widgets found!'),
        'table_prefix' => theme_link_process_information(translate('Create New Dashboard Widget'), 'dashboard_widgets_create_form', 'dashboard_widgets_create_form', 'dashboard_widgets', array('response_type' => 'modal')),
        'pager_items' => build_pager('dashboard_widgets_list', 'dashboard_widgets', $dashboard_widgets->total_records, $limit, $page),
        'page' => $page,
        'sort' => $sort,
        'search' => $search,
        'show_search' => TRUE,
        'function' => 'dashboard_widgets_list',
        'module' => 'dashboard_widgets',
        'update_row_id' => '',
        'table_form_id' => '',
        'table_form_process' => '',
    );
    $listview = $view->build($rows, $headers, $options);

    return $listview;
}

/*
 * show add form
 */
function dashboard_widgets_create_form() {
    $frm = new DbForm();
    return $frm->build("dashboard_widgets_create_form");
}

/*
 * Insert on table
 */
function dashboard_widgets_create_form_submit($data) {
    $dashboard_widgets_val = new DashboardWidgets();
    $error    = $dashboard_widgets_val->_validate($data, false, false);
    if (!empty($error)) {
      foreach($error as $msg) {
        natural_set_message($msg, 'error');
      }
      return FALSE;
    }
    $dashboard_widgets = new DashboardWidgets();
    foreach ($data as $field => $value) {
        if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
            $dashboard_widgets->$field = $value;
        }
    }
    $dashboard_widgets->insert();
    if ($dashboard_widgets->affected > 0 ) {
        natural_set_message('DashboardWidgets has been created!', 'success');
        return dashboard_widgets_list($dashboard_widgets->id);
    } else {
        natural_set_message('Could not save this DashboardWidgets at this time', 'error');
        return false;
    }
}

/*
 * show edit form
 */
function dashboard_widgets_edit_form($data) {
    $dashboard_widgets = new DashboardWidgets();
    $dashboard_widgets->loadSingle('id='.$data['dashboard_widgets_id']);
    $frm = new DbForm();
    $frm->build('dashboard_widgets_edit_form', $dashboard_widgets, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function dashboard_widgets_edit_form_submit($data) {
    $error = dashboard_widgets_validate($data);
    if (!empty($error)) {
        foreach($error as $msg) {
          natural_set_message($msg, 'error');
        }
        return FALSE;
    } else {
        $dashboard_widgets = new DashboardWidgets();
        $dashboard_widgets->loadSingle("id='" . $data['id'] . "'");
        foreach ($data as $field => $value) {
            if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
                $dashboard_widgets->$field = $value;
            }
        }
        $dashboard_widgets->update("id='" . $data['id'] . "'");
        if ($dashboard_widgets->affected > 0) {
            natural_set_message('DashboardWidgets updated successfully!', 'success');
        }
        return dashboard_widgets_list($data['id']);
    }
}

/*
 * show edit form
 */
function dashboard_widgets_delete_form($data) {
    $dashboard_widgets = new DashboardWidgets();
    $dashboard_widgets->loadSingle('id='.$data['dashboard_widgets_id']);
    if($dashboard_widgets->affected>0){
        $frm = new DbForm();
        $frm->build('dashboard_widgets_delete_form', $dashboard_widgets, $_SESSION['log_access_level']);
    }else{
        natural_set_message('Problems loading dashboard_widgets ' . $user_id, 'error');
        return FALSE;   
    }
}

/*
 * Remove from table
 */
function dashboard_widgets_delete_form_submit($data) {
    $dashboard_widgets = new DashboardWidgets();
    $dashboard_widgets->remove('id=' . $data['id']);
    if ($dashboard_widgets->affected > 0) {
        //return "ERROR||Could not remove!";
        $dashboard_widgets->remove('id=' . $data['id']);
        natural_set_message('DashboardWidgets has been removed successfully!', 'success');
        return $data['id'];
    } else {
        natural_set_message('Problems loading user ' . $user_id, 'error');
        return FALSE;
    }
}

/*
 * Validate data
 */
function dashboard_widgets_validate($data) {
    $dashboard_widgets = new DashboardWidgets();
    $edit = false;
    if (stripos("edit", $words)) {
        $edit = true;
    }
    return $dashboard_widgets->_validate($data, $edit, false);
}

function dashboard_widgets_load_droplets_wrapper(){
    global $twig;
    // Twig Base
    $template = $twig->loadTemplate('content.html');
    $template->display(array(
		// Dashboard - Passing default variables to content.html
		'page_title' => 'Dashboard',
		'page_subtitle' => 'Widgets',
		//'content' => '<div id="myfirstchart"></div>', // TODO: Call function that builds dashboard widgets
		'content' => dashboard_widgets_load_droplets() //Loading dashboard widgets from modules/dashboard_widgets/dashboard_widgets.controller.hp
	));
}

function dashboard_widgets_load_droplets(){
    // Dashboard Configuration according logged user personal preferences
    //$content .= '<span class="dashboard-setup-title closed">Dashboard Setup</span><div id="dashboard-setup">' . dashboard_setup_form() . '</div>';
    // Load the dashboard widgets according pre cofigured by the logged user
    $content .= '<div id="dashboard-widgets">' . dashboard_widgets($_SESSION['dash_type']) . '</div>';
    return $content;
}

function dashboard_widgets($dashboard_type) {
    $user = new User();
    $user->loadSingle('id = ' . $_SESSION['log_id']);
    $arr[0][0] = 1;
    $arr[0][1] = 4;
    $arr[1][0] = 3;
    $arr[2][0] = 2;
    //$user->dashboard_1 = $arr;
    //$user->update('id = ' . $_SESSION['log_id']);
    $dash_type = 'dashboard_' . $dashboard_type;
    $ct = 1;
    if ($user->$dash_type) {
        // Build the dashboard accordingly the dashboard type and if there is something recorded in his desktop
        $user_widgets = $user->$dash_type;
        if ($user_widgets) {
            for ($i = 0; $i < count($user_widgets); $i++) {
                for ($x = 0; $x < count($user_widgets[$i]); $x++) {
                    $widget = new DashboardWidgets();
                    $widget->loadSingle('id = ' . $user_widgets[$i][$x]);
                    
                    if ($widget->enabled) {
                        
                        // Removed from the portlet-content
                        //' . call_user_func($widget->widget_function, $user_widgets[$i][$x]) . '
                        /*$widgets[$i] .= ' <div class="portlet ' . $widget->class . '" id="widget_' . $widget->id .'">
                            <div class="portlet-header">' . $widget->title . '</div>
                            <div class="portlet-content content" id="'.$widget->widget_function.'">
                                <hidden id="function_to_call" name="function_to_call" value="'.$widget->widget_function.'|'.$user_widgets[$i][$x].'">
                            </div>
                        </div>';*/
                        
                        /*
                         <span class="widget-icon">
                                    <i class="glyphicon glyphicon-stats txt-color-darken"></i>
                                </span>
                                <span class="widget-title">' . $widget->title . '</span>
                                <span class="naturalwidget-ctrls" role="menu">
                                    <a class="button-icon" data-placement="bottom" title="" rel="tooltip" href="#" data-original-title="Collapse">
                                        <i class="fa fa-minus "></i>
                                    </a>
                                    <a class="button-icon" data-placement="bottom" title="" rel="tooltip" href="javascript:void(0);" data-original-title="Delete">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </span>
                         */
                        $widgets[$i] .= ' <div class="portlet ui-state-default ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id="widget_' . $widget->id .'">
                            <div class="naturalwidget-header">
                                <i class="fa fa-desktop naturalwidget-icon"></i>
                                <span class="widget-title">' . $widget->title . '</span>
                                <span class="naturalwidget-ctrls" role="menu">
                                    <a class="button-icon button-min" data-placement="bottom" title="" rel="tooltip" href="#" data-original-title="Collapse">
                                        <i class="fa fa-minus "></i>
                                    </a>
                                    <a class="button-icon  button-close" data-placement="bottom" title="" rel="tooltip" href="javascript:void(0);" data-original-title="Delete">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </span>
                            </div>
                            
                            <div class="naturalwidget-content" id="'.$widget->widget_function.'">
                                <hidden id="function_to_call" name="function_to_call" value="'.$widget->widget_function.'|'.$user_widgets[$i][$x].'">
                                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
                            </div>
                        </div>';
                        /*
                        $widgets[$i] .= '<div id="wid-id-0" class="jarviswidget jarviswidget-sortable" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" style="" role="widget">
                        <header role="heading">
                        <span class="widget-icon">
                        <i class="glyphicon glyphicon-stats txt-color-darken"></i>
                        </span>
                        <h2>Live Feeds </h2>
                        <ul id="myTab" class="nav nav-tabs pull-right in">
                        <li class="active">
                        <li>
                        <li>
                        </ul>
                        <span class="jarviswidget-loader">
                        <i class="fa fa-refresh fa-spin"></i>
                        </span>
                        </header>
                        <div class="no-padding" role="content">
                        </div>';*/
                    }
                }
            }
        }
    } else {
        // Return the message to configure his/her dashboard
        //  $content = 'Maybe you are new here, don\'t forget to Setup your Dashboard<br/>Click on the link on the right link "Dashboard Setup" and choose which items you want to see on your dashboard.';
    }

    $content = '<form id="dashboard-form" name="dashboard-form">
       <input type="hidden" name="dashboard_type" value="' . $dashboard_type . '" />
    </form>';
    
    /*
    $( ".dashboard" ).sortable({
        connectWith: ".dashboard",
        handle: ".portlet-header",
        cancel: ".portlet-toggle",
        placeholder: "portlet-placeholder ui-corner-all"
        });*/
    $content .= '
    <div id="dash1" class="dashboard">' . $widgets[0] . '</div>
    <div id="dash2" class="dashboard">' . $widgets[1] . '</div>';
    //<script>dashboard_action();</script>';
    //<div id="dash3" class="dashboard">' . $widgets[2] . '</div>';
    /*
    '<script>
    $(".dashboard").sortable({
        connectWith: ".dashboard",
        handle: ".portlet-header",
        cancel: ".portlet-toggle",
        placeholder: "portlet-placeholder ui-corner-all",
        stop: function(event, ui) {
            var i = 0;
            var e = "";
            var positions = new Array;
            $(".dashboard").each(function() {
                e = $(this).sortable("toArray");
                positions[i] = e;
                i++;
            });

            positions = positions.join("-");
            // Send info to database
            process_information(\'dashboard-form\', \'dashboard_update_list\', \'dashboard_widgets\', null, \'positions|\' + positions, null, \'status-message\', null);
        }
    });
    $(".dashboard").disableSelection();
    $( ".portlet" )
        .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
        .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class=\'ui-icon ui-icon-minusthick portlet-toggle\'></span>");
        $( ".portlet-toggle" ).click(function() {
        var icon = $( this );
        icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
        icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
    });
    </script>';*/
    /*<script>
        
        $(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
            .find( ".portlet-header" )
            .addClass( "ui-corner-all" )
            .prepend( "<span class=\'ui-icon ui-icon-circle-minus\'></span>")
            .prepend( "<span class=\'ui-icon ui-icon-circle-close\'></span>")
            .end()
            .find( ".portlet-content" );
     
        $( ".portlet-header .ui-icon-circle-minus" ).click(function() {
            $( this ).toggleClass( "ui-icon-circle-minus" ).toggleClass( "ui-icon-circle-plus" );
            $( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
        });
     
        $( ".portlet-header .ui-icon-circle-close" ).click(function() {
            dashboard_delete_widget($( this ).parents( ".portlet:first" ).attr("id"));
        });
    </script>';*/
    return $content;
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
	$user->loadSingle('id = ' . $_SESSION['log_id']);
  $dashboard_type = 'dashboard_' . $data['dashboard_type'];
  $user->$dashboard_type = $positions;
  $user->update('id = ' . $_SESSION['log_id']);
  //return '';
}
?>