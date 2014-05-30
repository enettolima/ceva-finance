/**
 * Dashboard Sortable Function
 */
function dashboard_action() {
  //alert('Dashboard found');
  $(".dashboard").sortable({
      connectWith: ".dashboard",
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
          process_information('dashboard-form', 'dashboard_update_list', 'dashboard_widgets', null, 'positions|' + positions, null, 'status-message', null);
      }
  });
  $(".dashboard").disableSelection();
  
  $(".button-min").click(function() {
    $( this ).children().toggleClass( "fa-minus fa-plus" );
    $( this ).parents( ".portlet:first" ).find( ".naturalwidget-content" ).toggle();
  });
  
  
  $( ".button-close" ).click(function() {
    //alert('testing click X');
    dashboard_delete_widget($( this ).parents( ".portlet:first" ).attr("id"));
    //$( this ).toggleClass( ".fa-minus" ).toggleClass( ".fa-plus" );
    //$( this ).parents( ".portlet:first" ).find( ".naturalwidget-content" ).toggle();
  });
    /*$( ".portlet-header .ui-icon-circle-minus" ).click(function() {
        $( this ).toggleClass( "ui-icon-circle-minus" ).toggleClass( "ui-icon-circle-plus" );
        $( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
    });*/
    /*$( ".portlet" )
        .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
        .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class=\'ui-icon ui-icon-minusthick portlet-toggle\'></span>");
        $( ".portlet-toggle" ).click(function() {
        var icon = $( this );
        icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
        icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
    });*/
   
    /*$(".dashboard").sortable({
        connectWith: ".dashboard",
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
            process_information('dashboard-form', 'dashboard_update_list', 'dashboard_widgets', null, 'positions|' + positions, null, 'status-message', null);
        }
    });
    $(".dashboard").disableSelection();*/
}

/**
 * Dashboard Setup
 */
function dashboard_setup() {
    proccess_information('dashboard-setup-form', 'dashboard_setup', 'dashboard_widgets', null, null, null, 'dashboard-widgets');
}

/**
 * Dashboard Delete Widget
 */
function dashboard_delete_widget(widget) {
    $('#' + widget).fadeIn('fast', function() {
        $(this).remove();
        $('#input_' + widget).attr('checked', false);
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
        process_information('dashboard-form', 'dashboard_update_list', 'dashboard_widgets', null, 'positions|' + positions, null, 'status-message', null);
    });
}

/**
 * Dashboard Setup
 */
$(document).ready(function() {
    /*$('.dashboard-setup-title').live('click', function() {
        if ($(this).hasClass('closed')) {
            $(this).removeClass('closed').addClass('opened');
            $('#dashboard-setup').slideDown('normal');
        }
        else {
            $(this).removeClass('opened').addClass('closed');
            $('#dashboard-setup').slideUp('normal');
        }
    });*/
});