<?

function print_debug($val) {
    echo "<pre>";
    if (is_array($val)) {
        print_r($val);
    } else {
        if (is_object($val)) {
            print_r($val);
        } else {
            echo str_replace("\n", "<br>", $val);
        }
    }
    echo "</pre>";
}

function format_us_phone($phone) {
    return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
}

function isValidUsNumber($number) {
    $validation = true;
    if (!is_numeric($number)) {
        $validation = false;
    }
    if (strlen($number) != 10) {
        $validation = false;
    }
    if (substr($number, 0, 1) < 2) {
        $validation = false;
    }
    return $validation;
}

?>
