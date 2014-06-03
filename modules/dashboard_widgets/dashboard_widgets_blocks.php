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
    $response = '<div id="archScore" class="total-calls"></div>
  <script>
    chart_data = [' . $chart_info . '];
    make_bar_chart("archScore", null, chart_data, true, false);
  </script>';
    sleep(1);
    return $response;
}

function period_chart_example() {
    $response = '<div id="companySurvey" class="total-calls"></div>
    <script>
    chart_data  = [' . $chart_info . '];
    line1  = [' . $red_info . '];
    line2  = [' . $yellow_info . '];
    line3  = [' . $green_info . '];
    make_bar_chart_stacked_3lines("companySurvey", null, chart_data, line1, line2, line3, true, false);
  </script>';
    sleep(2);
    return $response;
}

function bar_graph_example() {
    
    $response = '<div id="techSurvey" class="total-calls"></div>
    <script>
    chart_data  = [' . $chart_info . '];
    line1  = [' . $red_info . '];
    line2  = [' . $yellow_info . '];
    line3  = [' . $green_info . '];
    make_bar_chart_stacked_3lines("techSurvey", null, chart_data, line1, line2, line3, true, false);
  </script>';
  
    sleep(2);
    return $response;
}

function line_chart_example() {
    $response = '<table>
            <tr>
            <td><b>Company Name:</b></td>
            <td><b>Average Score:</b></td>
            </tr>
            ' . $row . '
            </table>';
    sleep(1);
    return $response;
}

?>