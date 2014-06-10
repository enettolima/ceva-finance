<?php

/**
 * This file is used to organize and display the dashboard widgets
 * Dashboard Widget - Server Properties
 */
function donut_example() {
    $resp_data[0]['value'] = 60;
    $resp_data[0]['label'] = 'foo';
    
    $resp_data[1]['value'] = 15;
    $resp_data[1]['label'] = 'bar';
    
    $resp_data[2]['value'] = 10;
    $resp_data[2]['label'] = 'baz';
    
    $resp_data[3]['value'] = 5;
    $resp_data[3]['label'] = 'A really really long label';
    
    $resp_data[4]['value'] = 10;
    $resp_data[4]['label'] = 'Another Label';
    
    sleep(2);
    header('Content-Type: application/json');
    echo json_encode($resp_data);
}

function area_graph_example() {
    $resp_data[0]['x'] = '2011 Q1';
    $resp_data[0]['y'] = 3;
    $resp_data[0]['z'] = 3;
    
    $resp_data[1]['x'] = '2011 Q2';
    $resp_data[1]['y'] = 2;
    $resp_data[1]['z'] = 0;
    
    $resp_data[2]['x'] = '2011 Q3';
    $resp_data[2]['y'] = 0;
    $resp_data[2]['z'] = 2;
    
    $resp_data[3]['x'] = '2011 Q4';
    $resp_data[3]['y'] = 4;
    $resp_data[3]['z'] = 4;
    
    $resp_data[4]['x'] = '2012 Q1';
    $resp_data[4]['y'] = 2;
    $resp_data[4]['z'] = 9;
    
    sleep(1);
    header('Content-Type: application/json');
    echo json_encode($resp_data);
}

function bar_chart_example() {
    $resp_data[0]['x'] = '2011 Q1';
    $resp_data[0]['y'] = 3;
    $resp_data[0]['z'] = 2;
    $resp_data[0]['a'] = 3;
    
    $resp_data[1]['x'] = '2011 Q2';
    $resp_data[1]['y'] = 2;
    $resp_data[1]['z'] = null;
    $resp_data[1]['a'] = 1;
    
    $resp_data[2]['x'] = '2011 Q3';
    $resp_data[2]['y'] = 0;
    $resp_data[2]['z'] = 2;
    $resp_data[2]['a'] = 4;
    
    $resp_data[3]['x'] = '2011 Q4';
    $resp_data[3]['y'] = 2;
    $resp_data[3]['z'] = 4;
    $resp_data[3]['a'] = 3;
    
    sleep(1);
    header('Content-Type: application/json');
    echo json_encode($resp_data);
}

function period_chart_example() {
    $resp_data[0]['period']     = '2012-10-01';
    $resp_data[0]['licensed']   = 3407;
    $resp_data[0]['sorned']     = 660;
    
    $resp_data[1]['period']     = '2012-09-30';
    $resp_data[1]['licensed']   = 3351;
    $resp_data[1]['sorned']     = 629;
    
    $resp_data[2]['period']     = '2012-09-29';
    $resp_data[2]['licensed']   = 3269;
    $resp_data[2]['sorned']     = 618;
    
    $resp_data[3]['period']     = '2012-09-20';
    $resp_data[3]['licensed']   = 3246;
    $resp_data[3]['sorned']     = 661;
    
    $resp_data[4]['period']     = '2012-09-19';
    $resp_data[4]['licensed']   = 3257;
    $resp_data[4]['sorned']     = 667;
    
    $resp_data[5]['period']     = '2012-09-18';
    $resp_data[5]['licensed']   = 2245;
    $resp_data[5]['sorned']     = 934;
    
    $resp_data[6]['period']     = '2012-09-17';
    $resp_data[6]['licensed']   = 2875;
    $resp_data[6]['sorned']     = 789;
    
    $resp_data[7]['period']     = '2012-09-16';
    $resp_data[7]['licensed']   = 3171;
    $resp_data[7]['sorned']     = 676;
    
    $resp_data[8]['period']     = '2012-09-15';
    $resp_data[8]['licensed']   = 2456;
    $resp_data[8]['sorned']     = 534;
    
    $resp_data[9]['period']     = '2012-09-10';
    $resp_data[9]['licensed']   = 3215;
    $resp_data[9]['sorned']     = 622;
    
    sleep(2);
    header('Content-Type: application/json');
    echo json_encode($resp_data);
}

function bar_graph_example() {
    $resp_data[0]['x']  = '2011 Q1';
    $resp_data[0]['y']  = 0;
    
    $resp_data[1]['x']  = '2011 Q2';
    $resp_data[1]['y']  = 1;
    
    $resp_data[2]['x']  = '2011 Q3';
    $resp_data[2]['y']  = 3;
    
    $resp_data[3]['x']  = '2011 Q4';
    $resp_data[3]['y']  = 4;
    
    $resp_data[4]['x']  = '2012 Q1';
    $resp_data[4]['y']  = 2;
    
    $resp_data[5]['x']  = '2012 Q2';
    $resp_data[5]['y']  = 5;
    
    $resp_data[6]['x']  = '2012 Q3';
    $resp_data[6]['y']  = 9;
    
    $resp_data[7]['x']  = '2012 Q4';
    $resp_data[7]['y']  = 7;
    
    $resp_data[8]['x']  = '2013 Q1';
    $resp_data[8]['y']  = 13;
    
    sleep(2);
    header('Content-Type: application/json');
    echo json_encode($resp_data);
}

function line_chart_example() {
    $resp_data[0]['period'] = '2011-08-12';
    $resp_data[0]['a']      = 100;
    
    $resp_data[1]['period'] = '2011-03-03';
    $resp_data[1]['a']      = 75;
    
    $resp_data[2]['period'] = '2010-08-08';
    $resp_data[2]['a']      = -32;

    $resp_data[3]['period'] = '2010-05-10';
    $resp_data[3]['a']      = 25;
    
    $resp_data[4]['period'] = '2010-03-14';
    $resp_data[4]['a']      = 0;
    
    $resp_data[5]['period'] = '2010-01-10';
    $resp_data[5]['a']      = -25;
    
    $resp_data[6]['period'] = '2009-12-10';
    $resp_data[6]['a']      = -50;
    
    $resp_data[7]['period'] = '2009-10-07';
    $resp_data[7]['a']      = -75;
    
    $resp_data[8]['period'] = '2009-09-25';
    $resp_data[8]['a']      = -100;
    
    sleep(1);
    header('Content-Type: application/json');
    echo json_encode($resp_data);
}

?>