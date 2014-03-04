// Controller Version 2.0

//Global array containing timers
//Add your timers here if you want process information to handle aut stopping

var timers = new Array();

/**
 * NEW Menu behavior control
 */
$(document).ready(function() {

    // switch the template color
    $('.color-option').click(function() {
        var element_name = this.id;
        $('body').removeClass().addClass(element_name);
        $('#colors').fadeOut('slow').removeClass('opened');
        $('#style-info').html('Style: ' + element_name);
        // Save new preferences on database for the acutal user
        $.ajax({
            url: 'modules/dashboard/index.php?fn=user_change_color&color=' + element_name
        });
    });

    //<div id="show_hide_button"><a class="show_hide_topbar">show/hide</a></div>
    $('#menu-hide-button').click(function() {
        $('#header-wrapper').toggle('blind');
        if ($('#menu-hide-button').is('.up-button')) {
            $('#menu-hide-button').removeClass().addClass('down-button');
            var set_dash = 0;
        } else {
            $('#menu-hide-button').removeClass().addClass('up-button');
            var set_dash = 1;
        }
        proccess_information(null, 'update_user_dash_model', 'user_group', null, 'setdash|' + set_dash, null, 'status-message');
    })
});

//Global var for the history
var counter = 0;
var fromMenu = 0;
var myLocations = new Array();
//$.history._cache = 'cache.html';

//Default location is dashboard
myLocations[0] = 'menu_navigation( \'dashboard_main\',\'dashboard_home\', \'dashboard\', true)';

/*$(document).ready(function() {
 // Set the history cache to be used with back/fwd buttons
 $.history._cache = 'cache.html';
 });*/

//// function to handle the data coming back from the history upon back/fwd hit
//$.history.callback = function(reinstate, cursor) {
//    if (typeof(reinstate) == 'undefined') {
//        counter = 0;
//    } else {
//        counter = parseInt(reinstate.counter) || 0;
//    }
//    console.log('####### From Menu is: ' + fromMenu);
//    if (fromMenu < 1) {
//        return (new Function('return (' + myLocations[counter.valueOf()] + ')')());
//    } else {
//        fromMenu = 0;
//    }
//};

/**
 * NEW Menu class setup and redirection
 */
function menu_navigation(clicked, func, module, isHistory) {
    $('.active').removeClass('active');
   // isHistory = isHistory || false;
    var myLocation = '';
    fromMenu = 1;
    // store the counter inside an object such as {counter:0} along with extra to test speed
    //if (!isHistory) {
    //    counter++;
    //    $.history({'counter': counter});
    //    myLocations[counter] = "menu_navigation( \'" + clicked + "\',\'" + func + "\',\'" + module + "\',true)";
    //}
    $('#' + clicked).addClass('active').parents('li.expanded').addClass('active');
    proccess_information(null, func, module);
}


/**
 * Serialize objects
 */
$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

/**
 * Ajax calls
 */
function proccess_information(formname, func, module, ask_confirm, extra_value, error_el, response_el, response_type, request_type, parent, el, proc_message, timer) {
    var error_el = (error_el == null) ? 'status-message' : error_el;
    var response_el = (response_el == null) ? 'content' : response_el;
    var confirmation = (ask_confirm == null) ? false : ask_confirm;
    var ser = (formname == null) ? false : $('#' + formname).serialize();
    var request_type = (request_type == null) ? 'GET' : request_type;
    var proc_message = (proc_message == null) ? 'Loading, Please wait...' : proc_message;

    if (timer == null) {
        for (var i = 0; i < timers.length; i++)
        {
            clearTimeout(timers[i]);
        }
    }

    //$.growlUI('Hive Smart Dialer', proc_message);
    // if it has a parent
    if (parent) {
        // for response
        var parent_el = '';
        parent_el = $(el).parents('#' + parent);
        if (response_type != 'remove-item' && response_type != 'update_row') {
            response_el = $(parent_el).find('#' + response_el);
            if ($(response_el).length == 0) {
                response_el = 'content';
            }
        }

        // get form id
        if ($('#' + parent).is('form')) {
            ser = $(el).parents('#' + parent).serialize();
        }
        else { // Serialize everysingle form inside the given parent element
            var forms = new Array;
            $('#' + parent + ' form').each(function(i, value) {
                ser = $.toJSON($(this).serializeObject());
                ser = ser.replace(/[[]]/g, '');
                ser = ser.replace(/#/g, '%23');
                forms[i] = 'form[]=' + ser;
            });
            ser = forms.join('&');
        }
        //alert(ser);
        // Putting the error_el under its
        error_el = $(parent_el).find('#' + error_el);

    }

    // Test if response element is an object or just a element id
    if (typeof(response_el) != 'object') {
        response_el = "#" + response_el;
    }
    if (typeof(error_el) != 'object') {
        error_el = "#" + error_el;
    }

    if (extra_value == null) {
        var extra_value = "";
    }
    else {
        if (extra_value.indexOf('&') !== -1) {
            //Extra value has multiple key/values separated by &
            //Let's split it and process one by one
            var extra_values = extra_value.split('&');
            var extra_value = "";
            for (var i = 0, len = extra_values.length; i < len; i++) {
                var val = extra_values[i].split('|');
                extra_value = "&" + val[0] + "=" + val[1] + extra_value;
            }
        } else {
            var val = extra_value.split('|');
            var extra_value = "&" + val[0] + "=" + val[1];
        }
    }
    if (error_el) {
        $(error_el).html('').removeClass('error');
    }

    var do_ajax = true;
    if (confirmation) {
        do_ajax = confirm(ask_confirm);
    }

    if (request_type == "GET") {
        ul = "modules/" + module + "/index.php?fn=" + func + extra_value + "&" + ser;
    } else {
        ul = "modules/" + module + "/index.php";
        var reqdata = "fn=" + func + "&" + extra_value + "&" + ser;
    }
    if (do_ajax) {
        //$.blockUI({
        //    message: proc_message,
        //    centerY: 0,
        //    css: {
        //        top: '90%',
        //        //bottom: '35px',
        //        height: '25px',
        //        border: 'none',
        //        padding: '15px',
        //        font: '14px Trebuchet MS, Arial, Times New Roman',
        //        backgroundColor: '#000',
        //        '-webkit-border-radius': '10px',
        //        '-moz-border-radius': '10px',
        //        opacity: .5,
        //        color: '#fff'
        //    },
        //    overlayCSS: {
        //        border: 'none',
        //        padding: '15px',
        //        backgroundColor: '#000',
        //        '-webkit-border-radius': '10px',
        //        '-moz-border-radius': '10px',
        //        opacity: .0,
        //        backgroundColor: '#00f'
        //    }
        //});

        //setTimeout($.unblockUI, 30000);

        $.ajax({
            type: request_type,
            url: ul,
            data: reqdata,
            success: function(transport) {
                fromMenu = 0;
                var resp = transport.split('|');
                setTimeout($.unblockUI, 50);
                if (transport == 'LOGOUT') {
                    window.location = 'logout.php';
                }
                if (resp[0] == 'ERROR' || resp[0] == 'ALERT') {
                    var msg = resp[0] + ": " + resp[1] + " - " + resp[2];
                    $(error_el).html(msg).addClass('error');
                    return false;
                } else {
                    $(response_el).removeClass('error');
                    switch (response_type) {
                        case 'append':
                            resp = transport.split('||');
                            if (resp[0]) {
                                $(response_el).append(resp[0]);
                                // additional message
                                $(error_el).html(resp[1]);
                            }
                            else {
                                $(response_el).append(transport);
                            }
                            break;
                        case 'prepend':
                            $(response_el).prepend(transport);
                            break;
                        case 'remove-item':
                            if (parent) {
                                $(el).parents('#' + parent).remove();
                            }
                            else {
                                $(el).remove();
                            }
                            $(response_el).html(transport);
                            break;
                        case 'slide':
                            // Clean
                            $('#panel-new').remove();
                            // Calculates the number of columns
                            var row = $(response_el).parent('td').parent('tr');
                            var i = 0;
                            $(row).children().each(function() {
                                i++;
                            });
                            $(row).after('<tr id="panel-new"><td id="panel-response" colspan="' + i + '">' + transport + '</td></tr>');
                            break;
                        case 'popup':
                            response_el = response_el.replace("#", "");
                            $('body').append('<div class="dialog" id="' + response_el + '" title="' + response_el + '">' + transport + '</div>');
                            $('.dialog').dialog({
                                close: function() {
                                    $(this).remove();
                                }
                            });
                            break;
                        case 'popup-modal':
                            response_el = response_el.replace("#", "");
                            // take of # in front the response el
                            $('body').append('<div class="dialog" id="' + response_el + '" title="' + response_el + '">' + transport + '</div>');
                            $('.dialog').dialog({
                                bgiframe: true,
                                modal: true,
                                width: 600,
                                height: 300,
                                close: function() {
                                    $(this).remove();
                                }
                            });
                            break;
                        case 'remove_row':
                            $('#panel-new').remove();
                            var row = $(response_el).parent('td').parent('tr');
                            var i = 0;
                            $(row).children().each(function() {
                                i++;
                            });
                            $(row).after('<tr id="panel-new"><td colspan="' + i + '">' + transport + '</td></tr>');
                            $(row).remove();
                            $('#panel-new').fadeOut(5000, function() {
                                $('#panel-new').remove();
                            });
                            break;
                        case 'remove_row_no_panel':
                            var row = $(response_el).parent('td').parent('tr');
                            var i = 0;
                            $(row).children().each(function() {
                                i++;
                            });
                            $(row).after('<tr id="response-new"><td colspan="' + i + '">' + transport + '</td></tr>');
                            $(row).remove();
                            $('#response-new').fadeOut(5000, function() {
                                $('#response-new').remove();
                            });
                            break;
                        case 'update_row':
                            resp = transport.split('||');
                            $(response_el).html(resp[0]);
                            // Update row
                            $('#panel-new').prev('tr').fadeOut().fadeIn().html(resp[1]);
                            $('#panel-new').fadeOut(8000, function() {
                                $(this).remove();
                            });
                            break;
                        case 'update_field':
                            resp = transport.split('||');
                            if (resp[0] && resp[1]) {
                                $(response_el).fadeOut().fadeIn().val(resp[0]);
                                eval(resp[1]);
                            }
                            else {
                                $(response_el).fadeOut().fadeIn().val(transport);
                            }
                            break;
                        case 'default_callback':
                            resp = transport.split('||');
                            $(response_el).html(resp[0]);
                            eval(resp[1]);
                            break;
                        default:
                            $(response_el).html(transport);
                            if (func == 'dashboard_home' || func == 'dashboard_setup') {
                                // Call the function that makes the dashboard sortable
                                dashboard_action();
                            }
                            break;
                    }
                }
            }
        });
    }
}

function load_popup(formname, func, module, response_el, click_function, modal, frame, width, height, draggable, resizable) {
    var modal = (modal == null) ? 'true' : modal;
    var frame = (frame == null) ? 'true' : frame;
    var width = (width == null) ? 600 : width;
    var height = (height == null) ? 300 : height;
    var ser = (formname == null) ? false : $('#' + formname).serialize();
    var draggable = (draggable == null) ? 'true' : draggable;
    var resizable = (resizable == null) ? 'true' : resizable;
    ul = "modules/" + module + "/index.php?fn=" + func + "&" + ser;
    $.ajax({
        type: "GET",
        url: ul,
        success: function(transport) {
            var resp = transport.split('|');
            if (transport == 'LOGOUT') {
                window.location = 'logout.php';
            }
            $('body').append('<div class="dialog" id="' + response_el + '" title="' + response_el + '">' + transport + '</div>');
            $('.dialog').dialog({
                bgiframe: frame,
                modal: modal,
                width: width,
                height: height,
                draggable: draggable,
                resizable: resizable,
                close: function() {
                    $(this).remove();
                },
                buttons: {
                    Save: function() {
                        process_button_save(click_function, this);
                    },
                    Cancel: function() {
                        $(this).dialog("close");
                    }
                }
            });
        }
    });
}

function process_button_save(fn, dialog) {
    var ser = $('#process_popup').serialize();
    var module = $('#module').val();
    ul = "modules/" + module + "/index.php?" + ser;
    $.ajax({
        type: "GET",
        url: ul,
        success: function(transport) {
            var resp = transport.split('|');
            if (transport == 'LOGOUT') {
                window.location = 'logout.php';
            }
            if (resp[0] == 'ERROR' || resp[0] == 'ALERT') {
                var msg = resp[0] + ": " + resp[1] + " - " + resp[2];
                $('#error-field').html(msg).addClass('container-error');
                return false;
            } else {
                $('#error-field').html(transport).addClass('container-success');
                $(dialog).dialog("close");
            }
        }
    });
}

/**
 * Close the panel opened by the slide option on process_information
 */
$(document).ready(function() {
    $('#panel-close').on('click', function() {
        // This closes all other panel which are opened
        $('#panel-new').remove();
    })
});

/**
 * Fieldset actions
 */
function fieldset_action(fieldset_name) {
    if ($(fieldset_name).parent('fieldset').hasClass('default_open')) {
        $(fieldset_name).parent('fieldset').removeClass('default_open');
        $(fieldset_name).parent('fieldset').addClass('default_closed');
        $(fieldset_name).siblings('div.form-item').fadeOut('slow');
        $(fieldset_name).siblings('table').fadeOut('fast');
    }
    else {
        $(fieldset_name).parent('fieldset').removeClass('default_closed');
        $(fieldset_name).parent('fieldset').addClass('default_open');
        $(fieldset_name).siblings('div.form-item').fadeIn('slow');
        $(fieldset_name).siblings('table').fadeIn('slow');
    }
}

/**
 * Function that deals with Graphael Javascript Library for creating pie graphics
 */
function make_pie(e, pieTitle, pieData, pieLegend, pieColor, pieXpos, pieYpos, pieRadius, titleXpos, titleYpos, legPos, toSort) {
    $('#' + e).children().remove();
    var r = Raphael(e);
    r.g.txtattr.font = "12px 'Trebuchet MS', Arial, sans-serif";
    r.g.text(titleXpos, titleYpos, pieTitle).attr({
        "font-size": 20
    });
    if (legPos == null) {
        legPos = 'west';
    }


    var pie = r.g.piechart(pieXpos, pieYpos, pieRadius, pieData, {
        legend: pieLegend,
        colors: pieColor,
        legendpos: legPos
    }, toSort);
    pie.hover(function() {
        this.sector.stop();
        this.sector.scale(1.1, 1.1, this.cx, this.cy);
        if (this.label) {
            this.label[0].stop();
            this.label[0].scale(1.5);
            this.label[1].attr({
                "font-weight": 800
            });
        }
    }, function() {
        this.sector.animate({
            scale: [1, 1, this.cx, this.cy]
        }, 500, "bounce");
        if (this.label) {
            this.label[0].animate({
                scale: 1
            }, 500, "bounce");
            this.label[1].attr({
                "font-weight": 400
            });
        }
    });
}
;

function checkDupElement(e) {
    var n = $('#' + e).children().length;
    if (n > 1) {
        alert('yes, svg counter is ' + n);
    }
}

function make_line_chart(el, title, cdata, showhighlighter, showcursor, stringFormat) {
    $('#' + el).children().remove();
    if (stringFormat == null) {
        stringFormat = '%b&nbsp;%#d';
    }
//  alert(cdata);
    var plot2 = $.jqplot(el, cdata, {
//  var plot2 = $.jqplot (el, [['15:00',3],['16:00',8],['17:00',0],['18:00',5],['19:00',6],['20:00',12]], {
//  var plot2 = $.jqplot (el, [['2pm',8],['3pm',11],['4pm',15],['5pm',8],['6pm',65],['7pm',69]], {
//  var plot2 = $.jqplot (el, [[14,8],[15,11],[16,13]], {
        // Give the plot a title.
        title: title,
        // You can specify options for all axes on the plot at once with
        // the axesDefaults object.  Here, we're using a canvas renderer
        // to draw the axis label which allows rotated text.
        axesDefaults: {
            labelRenderer: $.jqplot.CanvasAxisLabelRenderer
        },
        highlighter: {
            show: showhighlighter,
            tooltipLocation: 'n',
            sizeAdjust: 12.5
        },
        cursor: {
            show: showcursor,
            tooltipLocation: 'ne'
        }
    });
    /*  if(stringFormat==null){
     stringFormat = '%b&nbsp;%#d';
     }
     $('#'+el).children().remove();
     var plot1 = $.jqplot(el, [cdata], {
     title:title,
     axes:{
     xaxis:{
     renderer:$.jqplot.DateAxisRenderer,
     tickOptions:{
     formatString: stringFormat
     }
     }
     },
     highlighter: {
     show: showhighlighter,
     tooltipLocation: 'n',
     sizeAdjust: 12.5
     },
     cursor: {
     show: showcursor,
     tooltipLocation: 'ne'
     }
     });*/
}

function make_bar_chart(el, title, cdata, showhighlighter, showcursor) {
    //var line1 = [['May', 1577], ['Jun', 3184], ['Jul', 3255], ['Aug', 565], [' Sep', 30656], ['Oct', 14565], ['Nov', 11234]];
    $('#' + el).children().remove();
    var plot1 = $.jqplot(el, [cdata], {
        title: title,
        series: [{renderer: $.jqplot.BarRenderer}],
        axesDefaults: {
            tickRenderer: $.jqplot.CanvasAxisTickRenderer,
            tickOptions: {
                angle: -30,
                fontSize: '8pt'
            }
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer
            }
        },
        seriesDefaults: {
            renderer: $.jqplot.BarRenderer
        },
        /*
         * Enables mouse hover to show the values
         */
        highlighter: {
            show: showhighlighter,
            sizeAdjust: 5,
            tooltipAxes: 'y',
            tooltipLocation: 'n'
        },
        cursor: {
            show: showcursor,
            tooltipLocation: 'ne'
        }
    });
}

function make_bar_chart_stacked(el, title, cdata, line1, line2, showhighlighter, showcursor) {
    $('#' + el).children().remove();
    //var cdata = ['May','Jun','Jul','Aug','Sep','Oct'];
    /*var ticks = cdata;
       var line1 = [14, 32, 41, 44, 40, 37];
       var line2 = [7, 12, 15, 17, 20, 27];*/
    var plot4 = $.jqplot(el, [line1, line2], {
        title: title,
        stackSeries: true,
        axesDefaults: {
            tickRenderer: $.jqplot.CanvasAxisTickRenderer,
            tickOptions: {
                angle: -30,
                fontSize: '8pt'
            }
        },
        seriesDefaults: {
            renderer: $.jqplot.BarRenderer,
            rendererOptions: {barMargin: 20},
            pointLabels: {show: true, stackedValue: true}
        },
        /*
         * Enables mouse hover to show the values
         highlighter: {
         show: showhighlighter,
         sizeAdjust: 5,
         tooltipAxes: 'y',
         tooltipLocation: 'n'
         },*/
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: cdata
            }
        }
    });
}




/**
 * Conference Admin
 */
$(document).ready(function() {
    $('.act img').on('click', function() {
        var element = this;
        var pos_room_act = this.id;
        $.ajax({
            dataType: 'json',
            url: 'modules/conference/index.php?fn=conference_act&pos_room_act=' + pos_room_act,
            success: function(data, textStatus) {
                if (data['success']) {
                    $(element).hide().siblings().show();
                    // Mute or Unmute all
                    if (data['mute_all'] == 1) {
                        $('.mute').hide().siblings().show();
                    }
                    if (data['unmute_all'] == 1) {
                        $('.unmute').hide().siblings().show();
                    }
                    if (data['kick'] == 1) {
                        $(element).parent().parent('td.tools').html('Kicked').parent('tr').css('opacity', '0.3');
                    }
                    if (data['kick_all'] == 1) {
                        $(element).fadeIn();
                        $('.member').css('opacity', '0.3').children('.tools').html('Kicked');
                    }
                    $('#conference_resp').html(data['success']).css('color', 'black');
                }
                else {
                    $('#conference_resp').html(data['error']).css('color', 'red');
                }
            }
        }); // end of ajax function
    });
});


/**
 * Tooltip
 */
$(document).ready(function() {
    $('.tooltip').on('mouseover', function(e) {
        var element = this;
        var text = $(element).next('.tooltip-text').html();
        $('#tooltip-box').css('top', e.pageY - 10).css('left', e.pageX + 20).html(text).fadeIn('normal');
    });
    $('.tooltip').on('mouseout', function() {
        var element = this;
        $('#tooltip-box').fadeOut('normal');
    });
});

/*
 * Function called on the Agent report back button
 */
function agent_report_back() {
    $("#report_response").hide();
    $("#report_menu").slideDown();
}

/**
 * Dashboard Sortable Function
 */
function dashboard_action() {
    $('#sortable1, #sortable2, #sortable3').sortable({
        connectWith: "ul",
        update: function(event, ui) {
            var i = 0;
            var e = '';
            var positions1 = new Array;
            var positions2 = new Array;
            var positions3 = new Array;
            $('#sortable1 li').each(function() {
                e = this.id;
                positions1[i] = e;
                i++;
            });
            var i = 0;
            $('#sortable2 li').each(function() {
                e = this.id;
                positions2[i] = e;
                i++;
            });
            var i = 0;
            $('#sortable3 li').each(function() {
                e = this.id;
                positions3[i] = e;
                i++;
            });
            positions1 = positions1.join(',');
            positions2 = positions2.join(',');
            positions3 = positions3.join(',');
            // Send info to database
            proccess_information('dashboard-form', 'dashboard_update_list', 'dashboard', null, 'positions|' + positions1 + '-' + positions2 + '-' + positions3, null, 'status-message', null);
        }
    });
    $('#sortable1, #sortable2, #sortable3').disableSelection();
}
;

/**
 * Dashboard Setup
 */
function dashboard_setup() {
    proccess_information('dashboard-setup-form', 'dashboard_setup', 'dashboard', null, null, null, 'dashboard-widgets');
}

/**
 * Dashboard Delete Widget
 */
function dashboard_delete_widget(widget) {
    $('#' + widget).fadeIn('fast', function() {
        $(this).remove();
        $('#input_' + widget).attr('checked', false);
        /*var i = 0;
         var e = '';
         var positions = new Array;
         $('#dash-sortable li').each(function() {
         e = this.id;
         positions[i] = e;
         i++;
         });
         positions = positions.join(',');
         // Send info to be stored
         proccess_information('dashboard-form', 'dashboard_update_list', 'dashboard', null, 'positions|'+positions, null, 'status-message', null);*/
        proccess_information('dashboard-setup-form', 'dashboard_setup', 'dashboard', null, null, null, 'dashboard-widgets');
    });
}

/**
 * Dashboard Setup
 */
$(document).ready(function() {
    $('.dashboard-setup-title').on('click', function() {
        if ($(this).hasClass('closed')) {
            $(this).removeClass('closed').addClass('opened');
            $('#dashboard-setup').slideDown('normal');
        }
        else {
            $(this).removeClass('opened').addClass('closed');
            $('#dashboard-setup').slideUp('normal');
        }
    });
});

/**
 * Help Menu
 */
$(document).ready(function() {
    $('.help-block').on('click', function() {
        if ($(this).hasClass('closed')) {
            $(this).removeClass('closed').addClass('opened');
            $('#help-info').slideDown('normal');
        }
        else {
            $(this).removeClass('opened').addClass('closed');
            $('#help-info').slideUp('normal');
        }
    });
});

/**
 * Ajax Uploader
 * Using jquery plugin (http://valums.com/wp-content/uploads/ajax-upload/demo-jquery.htm)
 */
function file_uploader(e, extensions) {
    var button = $('#' + e), interval;
    new AjaxUpload(button, {
        action: 'modules/upload/uploader.php',
        name: 'myfile',
        onSubmit: function(file, ext) {
            // If you want to allow uploading only 1 file at time,
            if (ext && new RegExp('^(' + extensions + ')$').test(ext)) {
                this.disable();
                // Uploding -> Uploading. -> Uploading...
                interval = window.setInterval(function() {
                    var text = button.text();
                    button.text('Uploading');
                }, 2000);
            }
            else {
                $('#file-message').html('Invalid format. The allowed formats are ' + extensions + '.').addClass('error');
                this.enable();
                button.html('<span>Upload</span>');
                return false;
            }
        },
        onComplete: function(file, response) {
            button.html('<span>Upload</span>');

            window.clearInterval(interval);

            // enable upload button
            this.enable();
            switch (response) {
                case 'error1':
                    $('#file-message').html('The file is too big.').addClass('error');
                    break;
                case 'error2':
                    $('#file-message').html('The file was not uploaded.').addClass('error');
                    break;
                case 'success':
                    // add file to the list
                    str = $("textarea").val();
                    if (str.search(file) < 0) {
                        $('<li class="file-item"></li>').appendTo('#uploaded-files').html('<span class="file-name">' + file + '</span> <span class="file-delete" onclick="file_delete(\'' + file + '\', this)">Delete</span>');
                        $('#files').val($("textarea").val() + file + '\n');
                        $('#file-message').html('The file was uploaded successfully.').removeClass('error').css('font-style', 'italic');
                    }
                    else {
                        $('#file-message').html('This file is already uploaded, if you have a new version, please remove it from the list and upload again.').addClass('error');
                    }
                    break;

            }


        }
    });
}

/**
 * Ajax Uploader
 * Deleting Uploaded files
 */
function file_delete(file, e) {
    proccess_information(null, 'file_remove', 'upload', null, 'file|' + file, null, 'file-message');
    $(e).parent().remove();
    var files = '';
    $('#uploaded-files .file-name').each(function() {
        files += $(this).text() + '\n';
    });
    $('#files').val(files);
}

/**
 * Quick Play
 */
function QuickPlay(surl) {
    document.getElementById("playerspan").innerHTML = "<embed src='" + surl + "' hidden=true autostart=true loop=false>";
}

/**
 * Conditional Field Verifier
 */
function conditional_field_controller(parent) {
    $('.conditional-field-controller').each(function() {
        var el = this;
        var el_id = this.id;
        var parent_el = '';
        if (parent) {
            conditional_field(el, el_id, parent);
        }
        else {
            conditional_field(el, el_id);
        }
    })
}

/**
 * Conditional Field
 */
function conditional_field(el, fieldclass, parent) {
    var value = $(el).val();
    if (parent) {
        var parent_el = '';
        parent_el = $(el).parents('#' + parent);
        $(parent_el).find('.' + fieldclass).each(function() {
            if ($(this).hasClass(value)) {
                $(this).parent('div').show();
            }
            else {
                $(this).parent('div').hide();
            }
        })
    }
    else {
        parent_el = $(el).parents('form');
        $(parent_el).find('.' + fieldclass).each(function() {
            if ($(this).hasClass(value)) {
                $(this).parent('div').show();
            }
            else {
                $(this).parent('div').hide();
            }
        })
    }
}

/*
 * Functionality to switch values of a bunch of checkbox
 */
function switch_checkbox_values() {
    $('input[type=checkbox]').each(function() {
        if ($(this).is(':checked')) {
            $(this).attr('checked', false)
        }
        else {
            $(this).attr('checked', true)
        }
    });
}

/*
 *Function to check or uncheck all cheboxes in a form
 * it needs the formname and type as all or none
 */
function toggleChecked(status) {
    $("#report_menu input").each(function() {
        $(this).attr("checked", status);
    })
}

function checkAllPaging(status) {
    $("#paging_manager input").each(function() {
        $(this).attr("checked", status);
    })
}
/**
 * Functionality for multiple-forms with sortable
 */
function multiple_forms_actions() {
    var height = $('#multiple-forms').height();
    if (height < 490) {
        height = '490px';
    }
    $('#multiple-forms-menu').css('height', height);
    // Enable Call Routing Menu to slide following the page scrolling
    $('#multiple-forms-menu ul').stickyfloat({
        duration: 200
    });
    //$('#multiple-forms-sortable').sortable();
    /*  $('#sortable').sortable();
     $('#sortable').sortable();*/
    //$('.single-form h2').disableSelection();
    // Change the number that shows the order of the form
    var i = 0;
    $('.single-form h2 span').each(function() {
        $(this).html(i);
        i++;
    });
    $('#sortable').on('sortupdate', function() {
        var i = 0;
        $('.single-form h2 span').each(function() {
            $(this).html(i);
            i++;
        });
    });
}

/**
 * Multiple Forms minimize/maximize form items
 */
function multiple_forms_max_min(el) {
    if ($(el).hasClass('minimize-icon')) {
        $(el).removeClass('minimize-icon').addClass('maximize-icon').attr('title', 'Maximize').html('Maximize');
        $(el).parents('.single-form').children('form').hide();
        $(el).parents('li').addClass('closed');
    } else {
        $(el).removeClass('maximize-icon').addClass('minimize-icon').attr('title', 'Minimize').html('Minimize');
        $(el).parents('.single-form').children('form').show();
        $(el).parents('li').removeClass('closed');
    }
    multiple_forms_actions();
}

function startProgress() {
    var count = 0;
    $("#progressbar").progressbar({
        value: count
    });
}

function updateProgress(count, msg, hideOnFinish) {
    if (count > 99) {
        count = 100;
    }
    $(".ui-progressbar-value").animate({
        width: count + "%"
    }, 200, 'linear', function() {
        if (msg == null) {
            $("#progress-message").html(count + '% Completed');
        } else {
            $("#progress-message").html(msg);
        }
    });
    if (count > 99 && hideOnFinish) {
        setTimeout("finishProgress()", 3000);
    }
}
function finishProgress() {
    $("#progress-wrapp").fadeOut(1000);
}

function dashboard_auto_refresh() {
    var campaign = $("#campaign_id").val();
    $("body").everyTime(15000, "campaignReloader", function() {
        menu_navigation_fullscreen(campaign);
    }, 0);
}

function menu_navigation_fullscreen(campaign_id, update_menu) {
    var request_update_menu = (update_menu == null) ? false : true;
    if (request_update_menu) {
        $("body").stopTime("campaignReloader");
        //    $("#hive-dashdialer-loading").fadeIn('fast');
        build_fullscreen_menu(campaign_id);
    }
    //  alert("the dash menu is "+$("#show_dash").val() );
    menu_url = '../../modules/dashboard/?fn=show_dashboard_fullscreen_content&campaign_id=' + campaign_id;
    //  $("#hive-dashdialer-content").fadeOut('fast');
    var html = $.ajax({
        url: menu_url,
        success: function(transport) {
            if (transport == "LOGOUT") {
                window.location = 'logout.php';
            } else {
                $("#content-wrapp").html(transport);
                //      $("#hive-dashdialer-loading").fadeOut('fast');

                if (request_update_menu) {
                    $("body").everyTime(15000, "campaignReloader", function() {
                        menu_navigation_fullscreen(campaign_id);
                    }, 0);
                }
            }
        }
    });
}

function build_fullscreen_menu(campaign_id) {
    menu_url = '../../modules/menu_nav/?fn=build_dash_fullscreen_menu&campaign_id=' + campaign_id;
    var html = $.ajax({
        url: menu_url,
        success: function(transport) {
            if (transport == "LOGOUT") {
                window.location = 'logout.php';
            } else {
                $("#hive-dashdialer-menu").html(transport);
            }
        }
    });
}

// Conference Bridge - disable the field depending on selected choice
function conference_bridge_switch(element) {
    var value = $(element).val();
    if (value == 1) {
        $(element).parent().next().hide();
    }
    else {
        $(element).parent().next().show();
    }
}
/*
 function reboot_auto_check(){
 menu_url='modules/dashboard/?fn=check_if_system_has_rebooted';
 $("reboot_checker").everyTime(5000, "rebootChecker", function(){

 }, 0);
 }

 function menu_navigation_fullscreen(campaign_id, update_menu) {
 var request_update_menu= (update_menu == null) ? false : true;
 if(request_update_menu){
 $("body").stopTime("campaignReloader");
 $("#hive-dashdialer-loading").slideDown('fast');
 build_fullscreen_menu(campaign_id);
 }
 //  alert("the dash menu is "+$("#show_dash").val() );
 menu_url='../../modules/dashboard/?fn=show_dashboard_fullscreen_content&campaign_id='+campaign_id;
 //  $("#hive-dashdialer-content").fadeOut('fast');
 var html = $.ajax({
 url: menu_url,
 success: function(transport) {
 if(transport=="LOGOUT")  {
 window.location = 'logout.php';
 }else{
 $("#content-wrapp").html(transport);
 $("#hive-dashdialer-loading").slideUp('fast');

 if(request_update_menu){
 $("body").everyTime(15000, "campaignReloader", function(){
 menu_navigation_fullscreen(campaign_id);
 }, 0);
 }
 }
 }
 });
 }*/

function callmetorec_auto_refresh(mediaID, filename, callback) {
    $('.calltorecord').dialog({
        width: 400,
        autoOpen: false,
        modal: true,
        close: function() {
            $("#ctr_loading").stopTime("ctr_reloader");
            proccess_information(null, 'audio_prompt_list', 'media');
            $(this).remove();
        }
    });
    $('.calltorecord').dialog('open');
    initiate_media_call(mediaID, filename, callback);
    $('#ctr_loading').everyTime(5000, "ctr_reloader", function() {
        check_callmetorecord_progress(mediaID);
    }, 0);
}

function initiate_media_call(mediaID, filename, callback) {
    menu_url = 'modules/media/?fn=initiate_call_to_record&mediaid=' + mediaID + '&filename=' + filename + '&callback=' + callback;
    $.ajax({
        type: 'GET',
        url: menu_url,
        success: function(response) {
        }
    });
}

function check_callmetorecord_progress(mediaID) {
    menu_url = 'modules/media/?fn=check_mediacall_progress&media_id=' + mediaID;

    if (!$('.calltorecord').dialog('isOpen')) {
        $('.calltorecord').dialog('open')
    }
    $.ajax({
        type: 'GET',
        url: menu_url,
        success: function(response) {
            if (response == "LOGOUT") {
                window.location = 'logout.php';
            } else {
                $("#ctr_message").fadeOut();
                $("#ctr_message").html('<h1>' + response + '...</h1>');
                $("#ctr_message").fadeIn();
                if (response == 'Calling' || response == 'Recording') {
                    //keep doing it
                } else {
                    $("#ctr_loading").fadeOut(1000);
                    setTimeout("stopCtrReloader()", 4000);
                }
            }
        }
    });
}

function stopCtrReloader() {
    //To stop auto reloader
    $("#ctr_loading").stopTime("ctr_reloader");
    $(".calltorecord").remove();
    proccess_information(null, 'audio_prompt_list', 'media');
}

function popTagCall() {
    $('.tagcall').dialog({
        width: 800,
        autoOpen: false,
        modal: true,
        close: function() {
            $(this).remove();
        }
    });
    $('.tagcall').dialog('open');
}

/*********************** Order Tracking ***********************/

// This was necessary to put out of ready function because IEca doesn't work with live change event... maybe in the future jquery provide this for us
// Order Tracking
var order_id;
var previous_order_id;
var previous_order_status;

function order_change_status(element) {
    var order_status = $(element).val();
    order_id = element.id.substr(13);
    if ($(element).hasClass('opened')) {
        // This closes all other notes which are opened
        $('tr.order_notes').remove();
        $('.order_status').removeClass('opened');
    }
    else {
        // This closes all other notes which are opened
        $('tr.order_notes').remove();
        $('.order_status').removeClass('opened');
        // This open the notes for this instance
        $(element).addClass('opened');
        //order_notes('list_order_notes', order_id, 'module');
        $.ajax({
            dataType: 'json',
            url: 'modules/order/index.php?fn=list_order_note&order_id=' + order_id,
            success: function(data, textStatus) {
                if (data['success']) {
                    $(element).parent('td').parent('tr').after('<tr class="order_notes"><td colspan="9"><div><label for="past_notes">Past Notes</label><textarea type="text" name="past_notes" cols="45" rows="5" class="past_notes" readonly="readonly">' + data['success'] + '</textarea><label for="new_note">New Notes</label><textarea type="text" name="new_note" cols="45" rows="5" class="new_note"></textarea><input class="add_new_note" id="add_new_note_' + order_id + '" type="button" value="Save"></div><a class="close_order_notes">Close</a></td></tr>');
                }
                else {
                    $(element).parent('td').parent('tr').after('<tr class="order_notes"><td colspan="9">Problems loading the notes for this order.</td></tr>');
                }
            }
        }); // end of ajax function
        // Going back to the previous status of the previous order
        if (previous_order_id != order_id) {
            previous_order_status = $('#order_status_' + previous_order_id).next('.order_hidden_status').text();
            $('#order_status_' + previous_order_id + ' option[value=' + previous_order_status + ']').attr('selected', 'selected');
        }
        previous_order_id = order_id;
    }
}
;

// This was necessary to put out of ready function because IEca doesn't work with live change event... maybe in the future jquery provide this for us
// Order Task
var order_task_id;
var previous_order_task_id;
var previous_order_task_status;

function order_task_change_status(element) {
    var order_task_status = $(element).val();
    order_task_id = element.id.substr(18);
    if ($(element).hasClass('opened')) {
        // This closes all other notes which are opened
        $('tr.order_task_notes').remove();
        $('.order_task_status').removeClass('opened');
    }
    else {
        // This closes all other notes which are opened
        $('tr.order_task_notes').remove();
        $('.order_task_status').removeClass('opened');
        // This open the notes for this instance
        $(element).addClass('opened');
        //order_task_notes('list_order_task_notes', order_task_id, 'module');
        $.ajax({
            dataType: 'json',
            url: 'modules/order/index.php?fn=list_order_task_note&order_task_id=' + order_task_id,
            success: function(data, textStatus) {
                if (data['success']) {
                    $(element).parent('td').parent('tr').after('<tr class="order_task_notes"><td colspan="9"><div><label for="past_notes">Past Notes</label><textarea type="text" name="past_notes" cols="45" rows="5" class="past_notes" readonly="readonly">' + data['success'] + '</textarea><label for="new_note">New Notes</label><textarea type="text" name="new_note" cols="45" rows="5" class="new_note"></textarea><input class="add_new_task_note" id="add_new_task_note_' + order_task_id + '" type="button" value="Save"></div><a class="close_order_task_notes">Close</a></td></tr>');
                }
                else {
                    $(element).parent('td').parent('tr').after('<tr class="order_task_notes"><td colspan="9">Problems loading the notes for this task.</td></tr>');
                }
            }
        }); // end of ajax function
        // Going back to the previous status of the previous order
        if (previous_order_task_id != order_task_id) {
            previous_order_task_status = $('#order_task_status_' + previous_order_task_id).next('.order_task_hidden_status').text();
            $('#order_task_status_' + previous_order_task_id + ' option[value=' + previous_order_task_status + ']').attr('selected', 'selected');
        }
        previous_order_task_id = order_task_id;
    }
}
;

$(document).ready(function() {
    // Close button
    $('.close_order_notes').on('click', function() {
        // This closes all other notes which are opened
        $('tr.order_notes').remove();
        $('.order_status').removeClass('opened');
        $('.order_simple_note').removeClass('opened');
        // Going back to the previous status of the order if the user close the box
        previous_order_status = $('#order_status_' + order_id).next('.order_hidden_status').text();
        $('#order_status_' + order_id + ' option[value=' + previous_order_status + ']').attr('selected', 'selected');
        previous_order_id = '';
    })

    // Open and close row to add a simple note for order tracking
    $('.order_simple_note').on('click', function() {
        var element = this;
        order_id = this.id.substr(18);
        if ($(element).hasClass('opened')) {
            // This closes all other notes which are opened
            $('tr.order_notes').remove();
            $('.order_simple_note').removeClass('opened');
        }
        else {
            // This closes all other notes which are opened
            $('tr.order_notes').remove();
            $('.order_simple_note').removeClass('opened');
            // This open the notes for this instance
            $(element).addClass('opened');
            $.ajax({
                dataType: 'json',
                url: 'modules/order/index.php?fn=list_order_note&order_id=' + order_id,
                success: function(data, textStatus) {
                    if (data['success']) {
                        $(element).parent('td').parent('tr').after('<tr class="order_notes"><td colspan="9"><div><label for="past_notes">Past Notes</label><textarea type="text" name="past_notes" cols="45" rows="5" class="past_notes" readonly="readonly">' + data['success'] + '</textarea><label for="new_note">New Notes</label><textarea type="text" name="new_note" cols="45" rows="5" class="new_note"></textarea><input class="add_new_note" id="add_new_note_' + order_id + '" type="button" value="Save"></div><a class="close_order_notes">Close</a></td></tr>');
                    }
                    else {
                        $(element).parent('td').parent('tr').after('<tr class="order_notes"><td colspan="9">Problems loading the notes for this order.</td></tr>');
                    }
                }
            }); // end of ajax function
        }
    });

    // Add new order note
    $('.add_new_note').on('click', function() {
        var element = this;
        order_id = this.id.substr(13);
        var order_status = $('#order_status_' + order_id).val();
        var new_note = $('.new_note').serialize();
        // if the order is being cancelled, confirm with the user
        var answer = true;
        if (order_status == 2) {
            answer = confirm("The status for this order is Cancelled. Do you want to continue?");
        }
        if (answer) {
            // Necessary to close the order task panel, then when the user opens it again he is going to see all the tasks cancelled automatically
            // This closes all other notes which are opened
            $('tr.order_tasks').remove();
            $('.order_edit').removeClass('opened');
            $.ajax({
                dataType: 'json',
                url: 'modules/order/index.php?fn=add_new_order_note&order_id=' + order_id + '&order_status=' + order_status + '&' + new_note,
                success: function(data, textStatus) {
                    if (data['success']) {
                        $('.order_notes').before('<tr class="order_success_msg"><td colspan="9">' + data['success'] + '</td></tr>');
                        $('.order_notes').fadeOut('normal', function() {
                            $('.order_notes').remove();
                        });
                        $('.order_success_msg').fadeOut(20000, function() {
                            $('.order_success_msg').remove();
                        });
                        // This removes the class opened then the user can select another option for the same select box
                        $('.order_status').removeClass('opened');
                        $('.order_simple_note').removeClass('opened');
                        // This updates the previous hidden status div in order to compare if the status is being changed
                        $('#order_status_' + order_id).next('.order_hidden_status').html(order_status);
                    }
                    else {
                        $('.order_notes').before('<tr class="order_error_msg"><td colspan="9">' + data['error'] + '</td></tr>');
                        $('.order_error_msg').fadeOut(20000, function() {
                            $('.order_error_msg').remove();
                        });
                    }
                }
            }); // end of ajax function
        }
    });

    // Order Task open and close the row to edit the tasks
    $('.order_edit').on('click', function() {
        var element = this;
        order_id = this.id.substr(11);
        if ($(element).hasClass('opened')) {
            // This closes all other notes which are opened
            $('tr.order_tasks').remove();
            $('.order_edit').removeClass('opened');
        }
        else {
            // This closes all other notes which are opened
            $('tr.order_tasks').remove();
            $('.order_edit').removeClass('opened');
            // This open the notes for this instance
            $(element).addClass('opened');
            //order_notes('list_order_notes', order_id, 'module');
            $.ajax({
                dataType: 'json',
                url: 'modules/order/index.php?fn=list_order_task&order_id=' + order_id,
                success: function(data, textStatus) {
                    if (data['success']) {
                        // Test if there is a note panel opened, if yes append this below it
                        if ($(element).parent('td').parent('tr').next('tr').hasClass('order_notes')) {
                            $(element).parent('td').parent('tr').next('tr').after('<tr class="order_tasks"><td colspan="9">' + data['success'] + '<a class="close_order_tasks">Close</a></tr>');
                        }
                        else {
                            $(element).parent('td').parent('tr').after('<tr class="order_tasks"><td colspan="9">' + data['success'] + '<a class="close_order_tasks">Close</a></tr>');
                        }
                    }
                    else {
                        $(element).parent('td').parent('tr').after('<tr class="order_tasks"><td colspan="9">' + data['error'] + '<a class="close_order_tasks">Close</a></td></tr>');
                    }
                }
            }); // end of ajax function
        }
    });

    // Close button for tasks panel
    $('.close_order_tasks').on('click', function() {
        // This closes all other notes which are opened
        $('tr.order_tasks').remove();
        $('.order_edit').removeClass('opened');
    })

    // Close button
    $('.close_order_task_notes').on('click', function() {
        // This closes all other notes which are opened
        $('tr.order_task_notes').remove();
        $('.order_task_status').removeClass('opened');
        $('.order_task_simple_note').removeClass('opened');
        // Going back to the previous status of the order if the user close the box
        previous_order_task_status = $('#order_task_status_' + order_task_id).next('.order_task_hidden_status').text();
        $('#order_task_status_' + order_task_id + ' option[value=' + previous_order_task_status + ']').attr('selected', 'selected');
        previous_order_task_id = '';
    })

    // Add new order note
    $('.add_new_task_note').on('click', function() {
        var element = this;
        order_task_id = this.id.substr(18);
        var order_task_status = $('#order_task_status_' + order_task_id).val();
        var new_note = $('.new_note').serialize();
        $.ajax({
            dataType: 'json',
            url: 'modules/order/index.php?fn=add_new_order_task_note&order_task_id=' + order_task_id + '&order_task_status=' + order_task_status + '&' + new_note,
            success: function(data, textStatus) {
                if (data['success']) {
                    $('.order_task_notes').before('<tr class="order_success_msg"><td colspan="9">' + data['success'] + '</td></tr>');
                    $('.order_task_notes').fadeOut('normal', function() {
                        $('.order_task_notes').remove();

                    });
                    $('.order_success_msg').fadeOut(20000, function() {
                        $('.order_success_msg').remove();
                    });
                    // Verify if the the order is completed and change the status of the order tracking
                    if (data['order_id_completed']) {
                        $('#order_status_' + data['order_id_completed'] + ' option[value=1]').attr('selected', 'selected');
                    }
                    // This removes the class opened then the user can select another option for the same select box
                    $('.order_task_status').removeClass('opened');
                    $('.order_task_simple_note').removeClass('opened');
                    // This updates the previous hidden status div in order to compare if the status is being changed
                    $('#order_task_status_' + order_task_id).next('.order_task_hidden_status').html(order_task_status);
                }
                else {
                    $('.order_task_notes').before('<tr class="order_error_msg"><td colspan="9">' + data['error'] + '</td></tr>');
                    $('.order_error_msg').fadeOut(20000, function() {
                        $('.order_error_msg').remove();
                    });
                }
            }
        }); // end of ajax function
    });

    // Open and close row to add a simple note for order task
    $('.order_task_simple_note').on('click', function() {
        var element = this;
        order_task_id = this.id.substr(23);
        if ($(element).hasClass('opened')) {
            // This closes all other notes which are opened
            $('tr.order_task_notes').remove();
            $('.order_task_simple_note').removeClass('opened');
        }
        else {
            // This closes all other notes which are opened
            $('tr.order_task_notes').remove();
            $('.order_task_simple_note').removeClass('opened');
            // This open the notes for this instance
            $(element).addClass('opened');
            //order_task_notes('list_order_task_notes', order_task_id, 'module');
            $.ajax({
                dataType: 'json',
                url: 'modules/order/index.php?fn=list_order_task_note&order_task_id=' + order_task_id,
                success: function(data, textStatus) {
                    if (data['success']) {
                        $(element).parent('td').parent('tr').after('<tr class="order_task_notes"><td colspan="9"><div><label for="past_notes">Past Notes</label><textarea type="text" name="past_notes" cols="45" rows="5" class="past_notes" readonly="readonly">' + data['success'] + '</textarea><label for="new_note">New Notes</label><textarea type="text" name="new_note" cols="45" rows="5" class="new_note"></textarea><input class="add_new_task_note" id="add_new_task_note_' + order_task_id + '" type="button" value="Save"></div><a class="close_order_task_notes">Close</a></td></tr>');
                    }
                    else {
                        $(element).parent('td').parent('tr').after('<tr class="order_task_notes"><td colspan="9">Problems loading the notes for this task.</td></tr>');
                    }
                }
            }); // end of ajax function
        }
    });
    $('.wowwe_auth').on('click', function() {
        var customer_id = $("#customer_id").val();
        $.ajax({
            url: 'modules/customer/index.php?fn=auth_wowwe_customer&customer_id=' + customer_id,
            success: function(transport) {
                if (transport == "NOK") {
                    alert('Sorry, we could not log you in at this time, please try again! If the problem persists, contact the System Administrator!');
                } else {
                    //window.open(transport,'Simply2.0','toolbar=no,status=0,left=0,top=0,resizable=yes,scrollbars=yes,directories=no,menubar=no,location=no,width=1200,height=700');
                    window.open(transport, 'Simply', 'toolbar=no,status=0,left=0,top=0,resizable=yes,scrollbars=yes,directories=no,menubar=no,location=no,width=1200,height=700');
                }
            }
        });
    });
});

/*********************** Trouble Ticket ***********************/

// This was necessary to put out of ready function because IEca doesn't work with live change event... maybe in the future jquery provide this for us
// Trouble Ticket
var trouble_ticket_id;
var previous_trouble_ticket_id;
var previous_trouble_ticket_status;
var previous_trouble_ticket_priority;

function trouble_ticket_change_status(element) {
    var trouble_ticket_status = $(element).val();
    trouble_ticket_id = element.id.substr(22);
    if ($(element).hasClass('opened')) {
        // This closes all other notes which are opened
        $('tr.trouble_ticket_notes').remove();
        $('.trouble_ticket_status').removeClass('opened');
    }
    else {
        // This closes all other notes which are opened
        $('tr.trouble_ticket_notes').remove();
        $('.trouble_ticket_status').removeClass('opened');
        // This open the notes for this instance
        $(element).addClass('opened');
        $.ajax({
            dataType: 'json',
            url: 'modules/trouble_ticket/index.php?fn=list_trouble_ticket_note&trouble_ticket_id=' + trouble_ticket_id,
            success: function(data, textStatus) {
                if (data['success']) {
                    $(element).parent('td').parent('tr').after('<tr class="trouble_ticket_notes"><td colspan="10"><div><label for="past_notes">Past Notes</label><textarea type="text" name="past_notes" cols="45" rows="5" class="past_notes" readonly="readonly">' + data['success'] + '</textarea><label for="new_note">New Notes</label><textarea type="text" name="new_note" cols="45" rows="5" class="new_note"></textarea><input class="add_new_trouble_ticket_note" id="add_new_note_' + trouble_ticket_id + '" type="button" value="Save"></div><a class="close_trouble_ticket_notes">Close</a></td></tr>');
                }
                else {
                    $(element).parent('td').parent('tr').after('<tr class="trouble_ticket_notes"><td colspan="10">Problems loading the notes for this trouble ticket.</td></tr>');
                }
            }
        }); // end of ajax function
        // Going back to the previous status of the previous trouble ticket
        if (previous_trouble_ticket_id != trouble_ticket_id) {
            previous_trouble_ticket_status = $('#trouble_ticket_status_' + previous_trouble_ticket_id).next('.trouble_ticket_hidden_status').text();
            $('#trouble_ticket_status_' + previous_trouble_ticket_id + ' option[value=' + previous_trouble_ticket_status + ']').attr('selected', 'selected');
        }
        previous_trouble_ticket_id = trouble_ticket_id;
    }
}
;

function trouble_ticket_change_priority(element) {
    var trouble_ticket_status = $(element).val();
    trouble_ticket_id = element.id.substr(24);
    if ($(element).hasClass('opened')) {
        // This closes all other notes which are opened
        $('tr.trouble_ticket_notes').remove();
        $('.trouble_ticket_status').removeClass('opened');
    }
    else {
        // This closes all other notes which are opened
        $('tr.trouble_ticket_notes').remove();
        $('.trouble_ticket_status').removeClass('opened');
        // This open the notes for this instance
        $(element).addClass('opened');
        $.ajax({
            dataType: 'json',
            url: 'modules/trouble_ticket/index.php?fn=list_trouble_ticket_note&trouble_ticket_id=' + trouble_ticket_id,
            success: function(data, textStatus) {
                if (data['success']) {
                    $(element).parent('td').parent('tr').after('<tr class="trouble_ticket_notes"><td colspan="10"><div><label for="past_notes">Past Notes</label><textarea type="text" name="past_notes" cols="45" rows="5" class="past_notes" readonly="readonly">' + data['success'] + '</textarea><label for="new_note">New Notes</label><textarea type="text" name="new_note" cols="45" rows="5" class="new_note"></textarea><input class="add_new_trouble_ticket_note" id="add_new_note_' + trouble_ticket_id + '" type="button" value="Save"></div><a class="close_trouble_ticket_notes">Close</a></td></tr>');
                }
                else {
                    $(element).parent('td').parent('tr').after('<tr class="trouble_ticket_notes"><td colspan="10">Problems loading the notes for this trouble ticket.</td></tr>');
                }
            }
        }); // end of ajax function
        // Going back to the previous status of the previous trouble ticket
        if (previous_trouble_ticket_id != trouble_ticket_id) {
            previous_trouble_ticket_priority = $('#trouble_ticket_status_' + previous_trouble_ticket_id).next('.trouble_ticket_hidden_priority').text();
            $('#trouble_ticket_priority_' + previous_trouble_ticket_id + ' option[value=' + previous_trouble_ticket_priority + ']').attr('selected', 'selected');
        }
        previous_trouble_ticket_id = trouble_ticket_id;
    }
}
;


$(document).ready(function() {
    // Close button
    $('.close_trouble_ticket_notes').on('click', function() {
        // This closes all other notes which are opened
        $('tr.trouble_ticket_notes').remove();
        $('.trouble_ticket_status').removeClass('opened');
        $('.trouble_ticket_priority').removeClass('opened');
        $('.trouble_ticket_simple_note').removeClass('opened');
        // Going back to the previous status of the trouble_ticket if the user close the box
        previous_trouble_ticket_status = $('#trouble_ticket_status_' + trouble_ticket_id).next('.trouble_ticket_hidden_status').text();
        $('#trouble_ticket_status_' + trouble_ticket_id + ' option[value=' + previous_trouble_ticket_status + ']').attr('selected', 'selected');
        // Going back to the previous priority of the trouble_ticket if the user close the box
        previous_trouble_ticket_priority = $('#trouble_ticket_priority_' + trouble_ticket_id).next('.trouble_ticket_hidden_priority').text();
        $('#trouble_ticket_priority_' + trouble_ticket_id + ' option[value=' + previous_trouble_ticket_priority + ']').attr('selected', 'selected');
        previous_trouble_ticket_id = '';
    })

    // Open and close row to add a simple note for trouble_ticket
    $('.trouble_ticket_simple_note').on('click', function() {
        var element = this;
        trouble_ticket_id = this.id.substr(27);
        if ($(element).hasClass('opened')) {
            // This closes all other notes which are opened
            $('tr.trouble_ticket_notes').remove();
            $('.trouble_ticket_simple_note').removeClass('opened');
        }
        else {
            // This closes all other notes which are opened
            $('tr.trouble_ticket_notes').remove();
            $('.trouble_ticket_simple_note').removeClass('opened');
            // This open the notes for this instance
            $(element).addClass('opened');
            $.ajax({
                dataType: 'json',
                url: 'modules/trouble_ticket/index.php?fn=list_trouble_ticket_note&trouble_ticket_id=' + trouble_ticket_id,
                success: function(data, textStatus) {
                    if (data['success']) {
                        $(element).parent('td').parent('tr').after('<tr class="trouble_ticket_notes"><td colspan="10"><div><label for="past_notes">Past Notes</label><textarea type="text" name="past_notes" cols="45" rows="5" class="past_notes" readonly="readonly">' + data['success'] + '</textarea><label for="new_note">New Notes</label><textarea type="text" name="new_note" cols="45" rows="5" class="new_note"></textarea><input class="add_new_trouble_ticket_note" id="add_new_note_' + trouble_ticket_id + '" type="button" value="Save"></div><a class="close_trouble_ticket_notes">Close</a></td></tr>');
                    }
                    else {
                        $(element).parent('td').parent('tr').after('<tr class="trouble_ticket_notes"><td colspan="10">Problems loading the notes for this trouble ticket.</td></tr>');
                    }
                }
            }); // end of ajax function
        }
    });

    // Add new note
    $('.add_new_trouble_ticket_note').on('click', function() {
        var element = this;
        trouble_ticket_id = this.id.substr(13);
        var trouble_ticket_status = $('#trouble_ticket_status_' + trouble_ticket_id).val();
        var trouble_ticket_priority = $('#trouble_ticket_priority_' + trouble_ticket_id).val();
        var new_note = $('.new_note').serialize();
        // if the ticket is being cancelled, confirm with the user
        var answer = true;
        if (trouble_ticket_status == 2) {
            answer = confirm("Are you sure you that the status for this ticket is Cancelled?");
        }
        if (answer) {
            $.ajax({
                dataType: 'json',
                url: 'modules/trouble_ticket/index.php?fn=add_new_trouble_ticket_note&trouble_ticket_id=' + trouble_ticket_id + '&trouble_ticket_status=' + trouble_ticket_status + '&trouble_ticket_priority=' + trouble_ticket_priority + '&' + new_note,
                success: function(data, textStatus) {
                    if (data['success']) {
                        $('.trouble_ticket_notes').before('<tr class="trouble_ticket_success_msg"><td colspan="10">' + data['success'] + '</td></tr>');
                        $('.trouble_ticket_notes').fadeOut('normal', function() {
                            $('.trouble_ticket_notes').remove();
                        });
                        $('.trouble_ticket_success_msg').fadeOut(20000, function() {
                            $('.trouble_ticket_success_msg').remove();
                        });
                        // This removes the class opened then the user can select another option for the same select box
                        $('.trouble_ticket_status').removeClass('opened');
                        $('.trouble_ticket_priority').removeClass('opened');
                        $('.trouble_ticket_simple_note').removeClass('opened');
                        // This updates the previous hidden status div in Trouble Ticket to compare if the status is being changed
                        $('#trouble_ticket_status_' + trouble_ticket_id).next('.trouble_ticket_hidden_status').html(trouble_ticket_status);
                        // This updates the previous hidden status div in Trouble Ticket to compare if the status is being changed
                        $('#trouble_ticket_priority_' + trouble_ticket_id).next('.trouble_ticket_hidden_priority').html(trouble_ticket_priority);
                    }
                    else {
                        $('.trouble_ticket_notes').before('<tr class="trouble_ticket_error_msg"><td colspan="10">' + data['error'] + '</td></tr>');
                        $('.trouble_ticket_error_msg').fadeOut(20000, function() {
                            $('.trouble_ticket_error_msg').remove();
                        });
                    }
                }
            }); // end of ajax function
        }
    });
}); // End document ready function for trouble ticket
/*
 * Javascript for Customer Account
 */
$(document).ready(function() {
    // Open First One
    //$('.customer_account_block:first h3').addClass('opened').next('.info').show();


    // Open Close Info
    $('.customer_account_block h3').on('click', function() {
        if ($(this).hasClass('opened')) {
            $(this).removeClass('opened').next('.info').hide().next('.form').hide();
        }
        else {
            $(this).addClass('opened').next('.info').show();
        }
    });

    // Open Close Form
    $('.customer_account_block .edit').on('click', function() {
        $(this).parent('.info').slideUp('slow', function() {
            $(this).siblings('.form').slideDown('slow');
        });
    });

    // Close Form due the fact that the user cancelled the edit action
    $('.customer_account_form_cancel').on('click', function() {
        $(this).parent('.form').slideUp('slow', function() {
            $(this).siblings('div.info').slideDown();
        });
    });

    $('.customer_account_form_save').on('click', function() {
        var element = this;
        var type = element.id.substr(27);
        var block = $(element).parents('.customer_account_block');
        var form_values = $(element).parent('.form').find('form').serialize();
        // Preparing to send all fields separated by |
        form_values = form_values.split('&').join('|');
        form_values = encodeURI(form_values);
        $.ajax({
            dataType: 'json',
            url: 'modules/customer/index.php?fn=customer_account_form_save&type=' + encodeURI(type.replace(/_/, ' ')) + '&form_values=' + form_values,
            success: function(data, textStatus) {
                if (data['success']) {
                    $('#customer_account_message').remove();
                    $(element).parent('.form').slideUp('slow');
                    // Modify the data and show the info
                    $(block).hide('fast', function() {
                        block.before(data['success']);
                        block.prev('.customer_account_block').children().children('h3').addClass('opened').siblings('div.info').slideDown('slow');
                        block.remove();
                    });
                }
                else {
                    // Display the error
                    $('#customer_account_message').remove();
                    $(element).before('<div id="customer_account_message">' + data['error'] + '</div>');
                    $('#customer_account_message').css('color', 'red');
                }
            }
        }); // end of ajax function
    });

});
