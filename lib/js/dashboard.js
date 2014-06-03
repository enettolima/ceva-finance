/**
 * Dashboard Sortable Function
 */

  
function dashboard_action() {
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
    dashboard_delete_widget($( this ).parents( ".portlet:first" ).attr("id"));
  });
  
  $('.dashboard-setup-title').click(function() {
    if ($(this).hasClass('closed')) {
      $(this).removeClass('closed').addClass('opened');
      $('#dashboard-setup').slideDown('normal');
    } else {
      $(this).removeClass('opened').addClass('closed');
      $('#dashboard-setup').slideUp('normal');
    }
  });
  
  reload_charts();
  
  
  
  
  
  
  
  
}

/**
 * Dashboard Setup
 */
function dashboard_setup() {
    process_information('dashboard-setup-form', 'dashboard_setup', 'dashboard_widgets', null, null, null, 'dashboard-widgets');
}

/*
 * Get functions to be called and make the call
 */

function reload_charts(){
  var func = $('.functions').map(function(){
    return $(this).val()
  }).get();
  
  var arr = func.toString().split(',');
  
  //var resp = process_information(null, arr[0], 'dashboard_widgets', null, null, null, null, 'return_response');
  
  $.each( arr, function( key, value ) {
    $.ajax({
      url: 'modules/dashboard_widgets/index.php?fn='+value,
      type: 'GET',
      beforeSend: function() {
        $('#'+value).html('<div class="naturalwidget-loading"></div>');
      },
      success: function(data) {
        switch (value) {
          case 'donut_example':
            plot_donut(value, data);
            break;
          case 'area_graph_example':
            plot_area_graph(value, data);
            break;
          case 'bar_graph_example':
            plot_graph(value, data);
            break;
          case 'line_chart_example':
            plot_line_chart(value, data);
            break;
          case 'period_chart_example':
            plot_period_chart(value, data);
            break;
          case 'bar_chart_example':
            plot_bar_chart(value, data);
            break;
        }
      }
    });
  });
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
 * Dashboard Setup Menu
 */
$(document.body).on('click', '#demo-setting', function () {
  $('.demo').toggleClass( "activate" );
});


/*
 * Functions to plot the charts into the widgets
 */
function plot_donut(widget_id, chart_data){
  // donut
  $('#'+widget_id).html('');
  if ($('#'+widget_id).length) {
    Morris.Donut({
      element : widget_id,
      data : chart_data, //Data received from modules/dashboard_widgets/dashboard_widgets_blocks.php
      formatter : function(x) {
        return x + "%"
      }
    });
  }  
}

function plot_area_graph(widget_id, chart_data){
  // area graph
  $('#'+widget_id).html('');
  if ($('#'+widget_id).length) {
    Morris.Area({
      element : widget_id,
      data : chart_data,
      xkey : 'x',
      ykeys : ['y', 'z'],
      labels : ['Y', 'Z']
    });
  }
}

function plot_graph(widget_id, chart_data){
  $('#'+widget_id).html('');
  // bar graph color
  if ($('#'+widget_id).length) {
    Morris.Bar({
      element : widget_id,
      data : [{
        x : '2011 Q1',
        y : 0
      }, {
        x : '2011 Q2',
        y : 1
      }, {
        x : '2011 Q3',
        y : 2
      }, {
        x : '2011 Q4',
        y : 3
      }, {
        x : '2012 Q1',
        y : 4
      }, {
        x : '2012 Q2',
        y : 5
      }, {
        x : '2012 Q3',
        y : 6
      }, {
        x : '2012 Q4',
        y : 7
      }, {
        x : '2013 Q1',
        y : 8
      }],
      xkey : 'x',
      ykeys : ['y'],
      labels : ['Y'],
      barColors : function(row, series, type) {
        if (type === 'bar') {
          var red = Math.ceil(150 * row.y / this.ymax);
          return 'rgb(' + red + ',0,0)';
        } else {
          return '#000';
        }
      }
    });
  }
}

function plot_line_chart(widget_id, chart_data){
  //negative value
  $('#'+widget_id).html('');
  if ($('#'+widget_id).length) {
    var neg_data = [{
      "period" : "2011-08-12",
      "a" : 100
    }, {
      "period" : "2011-03-03",
      "a" : 75
    }, {
      "period" : "2010-08-08",
      "a" : -32
    }, {
      "period" : "2010-05-10",
      "a" : 25
    }, {
      "period" : "2010-03-14",
      "a" : 0
    }, {
      "period" : "2010-01-10",
      "a" : -25
    }, {
      "period" : "2009-12-10",
      "a" : -50
    }, {
      "period" : "2009-10-07",
      "a" : -75
    }, {
      "period" : "2009-09-25",
      "a" : -100
    }];
    Morris.Line({
      element : widget_id,
      data : neg_data,
      xkey : 'period',
      ykeys : ['a'],
      labels : ['Series A'],
      units : '%'
    });
  }
}

function plot_period_chart(widget_id, chart_data){
  /* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
  $('#'+widget_id).html('');
  if ($('#'+widget_id).length) {
    var day_data = [{
      "period" : "2012-10-01",
      "licensed" : 3407,
      "sorned" : 660
    }, {
      "period" : "2012-09-30",
      "licensed" : 3351,
      "sorned" : 629
    }, {
      "period" : "2012-09-29",
      "licensed" : 3269,
      "sorned" : 618
    }, {
      "period" : "2012-09-20",
      "licensed" : 3246,
      "sorned" : 661
    }, {
      "period" : "2012-09-19",
      "licensed" : 3257,
      "sorned" : 667
    }, {
      "period" : "2012-09-18",
      "licensed" : 3248,
      "sorned" : 627
    }, {
      "period" : "2012-09-17",
      "licensed" : 3171,
      "sorned" : 660
    }, {
      "period" : "2012-09-16",
      "licensed" : 3171,
      "sorned" : 676
    }, {
      "period" : "2012-09-15",
      "licensed" : 3201,
      "sorned" : 656
    }, {
      "period" : "2012-09-10",
      "licensed" : 3215,
      "sorned" : 622
    }];
    Morris.Line({
      element : widget_id,
      data : day_data,
      xkey : 'period',
      ykeys : ['licensed', 'sorned'],
      labels : ['Licensed', 'SORN']
    })
  }
}

function plot_bar_chart(widget_id, chart_data){
  // Use Morris.Bar
  $('#'+widget_id).html('');
  if ($('#'+widget_id).length) {
    Morris.Bar({
      element : widget_id,
      data : [{
        x : '2011 Q1',
        y : 3,
        z : 2,
        a : 3
      }, {
        x : '2011 Q2',
        y : 2,
        z : null,
        a : 1
      }, {
        x : '2011 Q3',
        y : 0,
        z : 2,
        a : 4
      }, {
        x : '2011 Q4',
        y : 2,
        z : 4,
        a : 3
      }],
      xkey : 'x',
      ykeys : ['y', 'z', 'a'],
      labels : ['Y', 'Z', 'A']
    });
  }
}