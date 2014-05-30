<?php

/**
 * This file is used to organize and display the dashboard widgets
 * Dashboard Widget - Server Properties
 */
function performance_trends() {
    $total = 0;
    $counter = 0;
    $monthlabel = date("m/d/y", strtotime("-" . $i . " day"));
    $now = date("Y-m-d");
    $last = date("Y-m-d", strtotime("-7 Days"));
    $dm = new DataManager();
    $dm->dmLoadCustomList("SELECT DATE(i.closed_stamp) as stamp, AVG(i.tech_rating) as tech_rating,AVG(i.architel_rating) as architel_rating, COUNT(*) as tickets FROM incidents i 
    WHERE closed_stamp BETWEEN '{$last}' AND '{$now}' and survey_status='1' 
    GROUP BY DATE(closed_stamp) ORDER BY closed_stamp ASC", "ASSOC");

    for ($i = 1; $i < 8; $i++) {
        $monthlabel = date("m/d/y", strtotime("-" . $i . " day"));
        $daycheck = date("Y-m-d", strtotime("-" . $i . " Days"));
        $found = false;
        $info[] = "'" . $monthlabel . "'";
        for ($x = 0; $x < $dm->affected; $x++) {
            if ($dm->data[$x]['stamp'] == $daycheck) {
                $tech[] = round($dm->data[$x]['tech_rating'], 1);
                $comp[] = round($dm->data[$x]['architel_rating'], 1);
                $tick[] = round($dm->data[$x]['tickets'], 1);
                $found = true;
                $counter++;
            }
        }
        if (!$found) {
            $tech[] = 0;
            $comp[] = 0;
            $tick[] = 0;
        }
    }

    $cinfo = array_reverse($info);
    $tinfo = array_reverse($tech);
    $tkinfo = array_reverse($tick);
    $ainfo = array_reverse($comp);

    $ct_info = implode(",", $cinfo);
    $chart_info = "{$ct_info}";
    $tech_info = implode(",", $tinfo);
    $arch_info = implode(",", $ainfo);
    $tick_info = implode(",", $tkinfo);
    $response = '<div id="performanceAll" class="max-trunks"></div>
  <script>
    chart_data = [' . $chart_info . '];
    lines = [[' . $tech_info . '],[' . $arch_info . '],[' . $tick_info . ']];
    labels = ["Tech AVG","Architel AVG","Scored Tickets"];
    make_line_chart("performanceAll", null, chart_data, lines, labels, true, true, false, "%#H:%S");
  </script>';
    return $response;
}

function stale_ticket_report() {
    $dm = new DataManager();
    $dm->dmLoadCustomList("SELECT COUNT(ref) as counter FROM open_incidents WHERE TIMESTAMPDIFF(HOUR, `last_update`, NOW()) > 24", "ASSOC");
    $higher24 = $dm->data[0]['counter'];
    $dm = new DataManager();
    $dm->dmLoadCustomList("SELECT COUNT(ref) as counter FROM open_incidents WHERE TIMESTAMPDIFF(HOUR, `last_update`, NOW()) > 48", "ASSOC");
    $higher48 = $dm->data[0]['counter'];
    $dm = new DataManager();
    $dm->dmLoadCustomList("SELECT COUNT(ref) as counter FROM open_incidents WHERE TIMESTAMPDIFF(HOUR, `last_update`, NOW()) > 72", "ASSOC");
    $higher72 = $dm->data[0]['counter'];

    $info[] = "['Higher then 24 hrs',{$higher24}]";
    $info[] = "['Higher then 48 hrs',{$higher48}]";
    $info[] = "['Higher then 72 hrs',{$higher72}]";
    $cinfo = array_reverse($info);
    $ct_info = implode(",", $cinfo);
    $chart_info = "{$ct_info}";
    $response = '<div id="ticketReport" class="max-trunks"></div>
  <script>
    chart_data = [' . $chart_info . '];
    make_bar_chart("ticketReport", null, chart_data, true, false, "");
  </script>';
    return $response;
}

function tech_score_average() {
    $total = 0;
    $monthlabel = date("m/d/y", strtotime("-" . $i . " day"));
    $now = date("Y-m-d");
    $last = date("Y-m-d", strtotime("-7 Days"));
    $dm = new DataManager();
    $dm->dmLoadCustomList("SELECT DATE(i.closed_stamp) as stamp, AVG(i.tech_rating) as tech_rating,AVG(i.architel_rating) as architel_rating, COUNT(*) as tickets FROM incidents i 
    WHERE closed_stamp BETWEEN '{$last}' AND '{$now}' and survey_status='1' 
    GROUP BY DATE(closed_stamp) ORDER BY closed_stamp ASC", "ASSOC");

    $total = 0;
    $counter = 0;
    for ($i = 1; $i < 8; $i++) {
        $monthlabel = date("m/d/y", strtotime("-" . $i . " day"));
        $daycheck = date("Y-m-d", strtotime("-" . $i . " Days"));
        $found = false;
        for ($x = 0; $x < $dm->affected; $x++) {
            if ($dm->data[$x]['stamp'] == $daycheck) {
                $info[] = "['{$monthlabel}'," . round($dm->data[$x]['tech_rating'], 1) . "]";
                $found = true;
                $counter++;
                $total = $total + round($dm->data[$x]['tech_rating'], 1);
            }
        }
        if (!$found) {
            $info[] = "['{$monthlabel}',0]";
        }
    }

    $cinfo = array_reverse($info);
    $chart_info = implode(",", $cinfo);
    $average = round($total / $counter, 1);
    $response = '<div id="techScore" class="total-calls"></div>
  <script>
    chart_data = [' . $chart_info . '];
    make_bar_chart("techScore", null, chart_data, true, false);
  </script>';

    return $response;
}

function company_score_average() {
    $total = 0;
    $monthlabel = date("m/d/y", strtotime("-" . $i . " day"));
    $now = date("Y-m-d");
    $last = date("Y-m-d", strtotime("-7 Days"));
    $dm = new DataManager();
    $dm->dmLoadCustomList("SELECT DATE(i.closed_stamp) as stamp, AVG(i.tech_rating) as tech_rating,AVG(i.architel_rating) as architel_rating, COUNT(*) as tickets FROM incidents i 
    WHERE closed_stamp BETWEEN '{$last}' AND '{$now}' and survey_status='1' 
    GROUP BY DATE(closed_stamp) ORDER BY closed_stamp ASC", "ASSOC");

    $total = 0;
    $counter = 0;
    for ($i = 1; $i < 8; $i++) {
        $monthlabel = date("m/d/y", strtotime("-" . $i . " day"));
        $daycheck = date("Y-m-d", strtotime("-" . $i . " Days"));
        $found = false;
        for ($x = 0; $x < $dm->affected; $x++) {
            if ($dm->data[$x]['stamp'] == $daycheck) {
                $info[] = "['{$monthlabel}'," . round($dm->data[$x]['architel_rating'], 1) . "]";
                $found = true;
                $counter++;
                $total = $total + round($dm->data[$x]['architel_rating'], 1);
            }
        }
        if (!$found) {
            $info[] = "['{$monthlabel}',0]";
        }
    }

    $cinfo = array_reverse($info);
    $chart_info = implode(",", $cinfo);
    $average = round($total / $counter, 1);
    $response = '<div id="archScore" class="total-calls"></div>
  <script>
    chart_data = [' . $chart_info . '];
    make_bar_chart("archScore", null, chart_data, true, false);
  </script>';

    return $response;
}

function company_survey() {
    for ($i = 1; $i < 8; $i++) {
        $total = 0;
        $monthlabel = date("m/d/y", strtotime("-" . $i . " day"));
        $monthyear = date("Y-m-d", strtotime("-" . $i . " Days"));
        //Getting Red rating
        $r = new DataManager();
        $r->dmLoadCustomList("SELECT count(id) AS red FROM " . NATURAL_DBNAME . ".incidents WHERE closed_stamp LIKE '%" . $monthyear . "%' AND survey_status='1' AND architel_rating" . LOW_RANGE, "ASSOC");
        $red[] = $r->data[0]['red'];
        //Getting yellow rating
        $y = new DataManager();
        $y->dmLoadCustomList("SELECT count(id) AS yellow FROM " . NATURAL_DBNAME . ".incidents WHERE closed_stamp LIKE '%" . $monthyear . "%' AND survey_status='1' AND architel_rating BETWEEN " . MID_RANGE, "ASSOC");
        $yellow[] = $y->data[0]['yellow'];
        //Getting green rating
        $g = new DataManager();
        $g->dmLoadCustomList("SELECT count(id) AS green FROM " . NATURAL_DBNAME . ".incidents WHERE closed_stamp LIKE '%" . $monthyear . "%' AND survey_status='1' AND architel_rating" . HIG_RANGE, "ASSOC");
        $green[] = $g->data[0]['green'];

        //$info[]     = "['{$monthlabel}',{$total}]";
        $info[] = "'{$monthlabel}'";
    }
    $cinfo = array_reverse($info);
    $redinfo = array_reverse($red);
    $yellowinfo = array_reverse($yellow);
    $greeninfo = array_reverse($green);

    $chart_info = implode(",", $cinfo);
    $red_info = implode(",", $redinfo);
    $yellow_info = implode(",", $yellowinfo);
    $green_info = implode(",", $greeninfo);
    $response = '<div id="companySurvey" class="total-calls"></div>
    <script>
    chart_data  = [' . $chart_info . '];
    line1  = [' . $red_info . '];
    line2  = [' . $yellow_info . '];
    line3  = [' . $green_info . '];
    make_bar_chart_stacked_3lines("companySurvey", null, chart_data, line1, line2, line3, true, false);
  </script>';
    return $response;
}

function tech_survey() {
    for ($i = 1; $i < 8; $i++) {
        $total = 0;
        $monthlabel = date("m/d/y", strtotime("-" . $i . " day"));
        $monthyear = date("Y-m-d", strtotime("-" . $i . " Days"));
        //Getting Red rating
        $r = new DataManager();
        $r->dmLoadCustomList("SELECT count(id) AS red FROM " . NATURAL_DBNAME . ".incidents WHERE closed_stamp LIKE '%" . $monthyear . "%' AND survey_status='1' AND tech_rating" . LOW_RANGE, "ASSOC");
        $red[] = $r->data[0]['red'];
        //Getting yellow rating
        $y = new DataManager();
        $y->dmLoadCustomList("SELECT count(id) AS yellow FROM " . NATURAL_DBNAME . ".incidents WHERE closed_stamp LIKE '%" . $monthyear . "%' AND survey_status='1' AND tech_rating BETWEEN " . MID_RANGE, "ASSOC");
        $yellow[] = $y->data[0]['yellow'];
        //Getting green rating
        $g = new DataManager();
        $g->dmLoadCustomList("SELECT count(id) AS green FROM " . NATURAL_DBNAME . ".incidents WHERE closed_stamp LIKE '%" . $monthyear . "%' AND survey_status='1' AND tech_rating " . HIG_RANGE, "ASSOC");
        $green[] = $g->data[0]['green'];

        //$info[]     = "['{$monthlabel}',{$total}]";
        $info[] = "'{$monthlabel}'";
    }
    $cinfo = array_reverse($info);
    $redinfo = array_reverse($red);
    $yellowinfo = array_reverse($yellow);
    $greeninfo = array_reverse($green);

    $chart_info = implode(",", $cinfo);
    $red_info = implode(",", $redinfo);
    $yellow_info = implode(",", $yellowinfo);
    $green_info = implode(",", $greeninfo);
    $response = '<div id="techSurvey" class="total-calls"></div>
    <script>
    chart_data  = [' . $chart_info . '];
    line1  = [' . $red_info . '];
    line2  = [' . $yellow_info . '];
    line3  = [' . $green_info . '];
    make_bar_chart_stacked_3lines("techSurvey", null, chart_data, line1, line2, line3, true, false);
  </script>';
    return $response;
}

function load_highest_scores() {
    $today = date("Y-m-d");
    $last_week = $start_date = date("Y-m-d", strtotime('-10 days'));
    $r = new DataManager();
    $r->dmLoadCustomList("SELECT `org_name`, AVG(architel_rating) as rate FROM `incidents` WHERE 
`survey_status` = '1' AND `closed_stamp` BETWEEN '" . $last_week . "' AND '" . $today . "'
GROUP BY `org_name`
ORDER BY rate DESC LIMIT 10", "ASSOC");
    //print_debug($r);
    if ($r->affected > 0) {
        for ($i = 0; $i < $r->affected; $i++) {
            if ($i % 2) {
                $class = 'even';
            } else {
                $class = 'odd';
            }
            $row .= '<tr class="' . $class . '">
            <td>' . $r->data[$i]['org_name'] . '</td>
            <td>' . number_format($r->data[$i]['rate'], 1) . '</td>
          </tr>';
        }
    }

    $response = '<table>
            <tr>
            <td><b>Company Name:</b></td>
            <td><b>Average Score:</b></td>
            </tr>
            ' . $row . '
            </table>';
    return $response;
}

function load_lowest_scores() {
    $today = date("Y-m-d");
    $last_week = $start_date = date("Y-m-d", strtotime('-10 days'));
    $r = new DataManager();
    $r->dmLoadCustomList("SELECT `org_name`, AVG(architel_rating) as rate FROM `incidents` WHERE 
`survey_status` = '1' AND `closed_stamp` BETWEEN '" . $last_week . "' AND '" . $today . "'
GROUP BY `org_name`
ORDER BY rate LIMIT 10", "ASSOC");
    //print_debug($r);
    if ($r->affected > 0) {
        for ($i = 0; $i < $r->affected; $i++) {
            if ($i % 2) {
                $class = 'even';
            } else {
                $class = 'odd';
            }
            $row .= '<tr class="' . $class . '">
            <td>' . $r->data[$i]['org_name'] . '</td>
            <td>' . number_format($r->data[$i]['rate'], 1) . '</td>
          </tr>';
        }
    }

    $response = '<table>
            <tr>
            <td><b>Company Name:</b></td>
            <td><b>Average Score:</b></td>
            </tr>
            ' . $row . '
            </table>';
    return $response;
}

?>