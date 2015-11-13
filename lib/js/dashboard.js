/**
 * Dashboard Sortable Function
 */
function build_dashboard() {
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
    $( this ).parents( ".grid-stack-item:first" ).find( ".graph" ).toggle();
    $( this ).parents( ".grid-stack-item:first" ).setAttribute("data-gs-height", "1");
  });


  $( ".button-close" ).click(function() {
    dashboard_delete_widget($( this ).parents( ".grid-stack-item:first" ).attr("id"));
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


  $('.grid-stack').on('resizestop', function (event, ui) {
      var grid = this;
      var element = event.target.id;

      var arr = event.target.id.toString().split('__');
      var fn = arr[1];
      var id = arr[2];

      $("#" + fn ).empty();
      $.ajax({
        url: 'modules/dashboard_widgets/index.php?fn='+fn+'&id='+id,
        type: 'GET',
        beforeSend: function() {
          $('#'+fn).html('<div class="naturalwidget-loading"></div>');
        },
        success: function(data) {
          switch (fn) {
            case 'donut_example':
              plot_donut(fn, data);
              break;
            case 'area_graph_example':
              plot_area_graph(fn, data);
              break;
            case 'bar_graph_example':
              plot_graph(fn, data);
              break;
            case 'line_chart_example':
              plot_line_chart(fn, data);
              break;
            case 'period_chart_example':
              plot_period_chart(fn, data);
              break;
            case 'bar_chart_example':
              plot_bar_chart(fn, data);
              break;
          }
        }
      });
  });

  $(function () {
      $('.grid-stack').gridstack({
          width: 12,
          always_show_resize_handle: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
          resizable: {
              handles: 'e, se, s, sw, w'
          }
      });
  });
  $(function () {
      var options = {
          cell_height: 100,
          vertical_margin: 20
      };
      $('.grid-stack').gridstack(options);
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

  $.each(arr, function( key, value ) {
    var sp = value.split('#');
    var fn = sp[0];
    var id = sp[1];
    var graph_id = '#'+fn+'__'+id;
    $.ajax({
      url: 'modules/dashboard_widgets/index.php?fn='+fn+'&id='+id,
      type: 'GET',
      beforeSend: function() {
        $(graph_id).html('<div class="naturalwidget-loading"></div>');
      },
      success: function(data) {
        switch (fn) {
          case 'render_widget_graph':
            render_widget_graph(graph_id, data);
            break;
          case 'donut_example':
            plot_donut(graph_id, data);
            break;
          case 'area_graph_example':
            plot_area_graph(graph_id, data);
            break;
          case 'bar_graph_example':
            plot_graph(graph_id, data);
            break;
          case 'line_chart_example':
            plot_line_chart(graph_id, data);
            break;
          case 'period_chart_example':
            plot_period_chart(graph_id, data);
            break;
          case 'bar_chart_example':
            plot_bar_chart(graph_id, data);
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
function render_widget_graph(graph_id, chart_data){
  // donut
  $(graph_id).html('');
  if ($(graph_id).length && (chart_data["data"] != null)) {
    switch(chart_data["graph_type"]) {
    case 'Line':
        Morris.Line({
          element : graph_id.substring(1),
          data : chart_data["data"],
          xkey : 'period',
          ykeys : ['x', 'y'],
          labels : ['X', 'Y'],
          lineColors: ['rgb(113, 132, 63)', '#E84B4B'],
          xLabelFormat : function (x) {
              vd = new Date(x)
              return vd.getMonth() + '-' + vd.getDate();
            },
          xLabels : 'day'
        });
        break;
    case 'Donut':
        Morris.Donut({
          element : graph_id.substring(1),
          resize : true,
          data : chart_data, //Data received from modules/dashboard_widgets/dashboard_widgets_blocks.php
          formatter : function(x) {
            return x + "%"
          }
        });
        break;
    default:

    }
  }else {
    $(graph_id).html(chart_data["response_nodata"]);
  }

}

/*
 * Functions to plot the charts into the widgets
 */
function plot_donut(graph_id, chart_data){
  // donut
  $(graph_id).html('');
  if ($(graph_id).length) {
    Morris.Donut({
      element : graph_id.substring(1),
      resize : true,
      data : chart_data, //Data received from modules/dashboard_widgets/dashboard_widgets_blocks.php
      formatter : function(x) {
        return x + "%"
      }
    });
  }
}

function plot_area_graph(graph_id, chart_data){
  // area graph
  $(graph_id).html('');
  if ($(graph_id).length) {
    Morris.Area({
      resize : true,
      element : graph_id.substring(1),
      data : chart_data,
      xkey : 'x',
      ykeys : ['y', 'z'],
      labels : ['Y', 'Z']
    });
  }
}

function plot_graph(graph_id, chart_data){
  $(graph_id).html('');
  // bar graph color
  if ($(graph_id).length) {
    Morris.Bar({
      resize : true,
      element : graph_id.substring(1),
      data : chart_data,
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

function plot_line_chart(graph_id, chart_data){
  //negative value
  $(graph_id).html('');
  if ($(graph_id).length) {
    Morris.Line({
      resize : true,
      element : graph_id.substring(1),
      data : chart_data,
      xkey : 'period',
      ykeys : ['a'],
      labels : ['Series A'],
      units : '%'
    });
  }
}

function plot_period_chart(graph_id, chart_data){
  /* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
  $(graph_id).html('');
  if ($(graph_id).length) {
    Morris.Line({
      resize : true,
      element : graph_id.substring(1),
      data : chart_data,
      xkey : 'period',
      ykeys : ['licensed', 'sorned'],
      labels : ['Licensed', 'SORN']
    })
  }
}

function plot_bar_chart(graph_id, chart_data){
  // Use Morris.Bar
  $(graph_id).html('');
  if ($(graph_id).length) {
    Morris.Bar({
      resize : true,
      element : graph_id.substring(1),
      data : chart_data,
      xkey : 'x',
      ykeys : ['y', 'z', 'a'],
      labels : ['Y', 'Z', 'A']
    });
  }
}
// End of plot functions
