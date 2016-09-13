<?php

function logcall($user_id, $customer_id, $template_id, $module, $func, $json_request, $json_response, $pdf, $pdf_size, $error)
{
  //we will add log of the transaction
  $pdo = new PDO(NATURAL_PDO_DSN_READ, NATURAL_PDO_USER_READ, NATURAL_PDO_PASS_READ);
  $sql = 'CALL sp_logcall_add(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
  $stmt = $pdo->prepare($sql);
  $param1 = is_null($customer_id) ? 0 : $customer_id;
  $param2 = is_null($user_id) ? 0 : $user_id;
  $param3 = $template_id;
  $param4 = $module;
  $param5 = $func;
  $param6 = json_encode($json_request, JSON_UNESCAPED_SLASHES);
  $param7 = json_encode($json_response, JSON_UNESCAPED_SLASHES);
  $param8 = $pdf;
  $param9 = $pdf_size;
  $param10 = $error;

  $stmt->bindParam(1, $param1, PDO::PARAM_INT); // customer_id
  $stmt->bindParam(2, $param2, PDO::PARAM_INT); // user_id
  $stmt->bindParam(3, $param3, PDO::PARAM_INT); // template_id
  $stmt->bindParam(4, $param4, PDO::PARAM_STR); // module
  $stmt->bindParam(5, $param5, PDO::PARAM_STR); // function
  $stmt->bindParam(6, $param6, PDO::PARAM_LOB); // json request
  $stmt->bindParam(7, $param7, PDO::PARAM_LOB); // json response
  $stmt->bindParam(8, $param8, PDO::PARAM_STR); // pdf file name
  $stmt->bindParam(9, $param9, PDO::PARAM_INT); // pdf file size
  $stmt->bindParam(10, $param10, PDO::PARAM_INT); // error  1 = true, 0 = false
  $stmt->execute();
  //$errors = $stmt->errorInfo();
  //print_debug($errors);
  //break;
  //finish adding log of the transaction
}


function generate_random_str($length = 32, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
    $chars_length = (strlen($chars) - 1);
    $string = $chars{rand(0, $chars_length)};
    for ($i = 1; $i < $length; $i = strlen($string)) {
        $r = $chars{rand(0, $chars_length)};
        if ($r != $string{$i - 1})
            $string .= $r;
    }
    return $string;
}

function create_guid(){
  $rnd_str = generate_random_str(32,"ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890");
  $guid = substr($rnd_str,  0, 8) . '-' .
          substr($rnd_str,  8, 4) . '-' .
          substr($rnd_str, 12, 4) . '-' .
          substr($rnd_str, 16, 4) . '-' .
          substr($rnd_str, 20, 12);
  return $guid;
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * This separates records by user, group and admin
 */
function set_permission_clause($level = NULL, $user_id = NULL, $table_alias = NULL, $user_table = 0, $public_test = 0) {
    $clause = '';
    if (!$level) {
        $level = $_SESSION['log_access_level'];
    }
    if (!$user_id) {
        $user_id = $_SESSION['log_id'];
    }
    if ($user_table) {
        $clause = $table_alias . 'id = ' . $user_id;
    } else {
        $clause = $table_alias . 'user_id = ' . $user_id;
    }
    return $clause;
}

/**
 * Transform seconds in hms
 */
function sec2hms($sec) {
    // holds formatted string
    $hms = "";
    $hours = intval(intval($sec) / 3600);
    $hms .= $hours . ':';
    $minutes = intval(($sec / 60) % 60);
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT) . ':';
    $seconds = intval($sec % 60);
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return $hms;
}

/**
 * Convert all strings to a different language
 */
function translate($string, $lang = 'en') {

		if($lang == 'en' || $lang == null){
			/**
				* Language is either default or missing so no translation
				* is necessary :D
			 */
			return $string;
		}

	  $db = DataConnection::readOnly();
		$lg = $db->language()
							->where('original', $string)
							->and('lang', $lang)
							->fetch();
    if ($lg) {
        return $lg['translate'];
    } else {
        return $string;
    }
}

/**
 * Set messages to the Session. - Session based
 */
function natural_set_message($msg, $type = 'status') {
  $_SESSION['messages'][] = array('type' => $type, 'msg' => $msg);
  return isset($_SESSION['messages']) ? $_SESSION['messages'] : NULL;
}

/**
 * Builds the process_information link with its parameters
 * process_information(formname, func, module, ask_confirm, extra_value, error_el, response_el, response_type, request_type, parent, el, proc_message, timer)
 */
function theme_link_process_information($text, $formname, $func, $module, $options = array()) {

  // process_information options.
  $process_information_options = array(
    'ask_confirm',
    'extra_value',
    'error_el',
    'response_el',
    'response_type',
    'request_type',
    'parent',
    'el',
    'proc_message',
    'timer',
  );

  $render_options = '';

  // Add an icon.
  /*if (!empty($options['icon'])) {
    $text = '<i class="' . $options['icon'] . '">' . $text . '</i>';
  }*/
	if(isset($options['icon'])){
		$text = '<i class="' . $options['icon'] . '">' . $text . '</i>';
	}

  // Set the javascript properties for the function.
  foreach($process_information_options as $key) {
    if (array_key_exists($key, $options)) {
      if ($options[$key] == 'this') {
        $render_options[] = $options[$key];
      }
      else {
        $render_options[] = "'" . $options[$key] . "'";
      }
    }
    else {
      $render_options[] = 'null';
    }
  }

	if($options['href']!=null){
    $href = $options['href'];
  }else{
    $href = "javascript:process_information('" . $formname . "', '" . $func . "', '" . $module . "', " .  implode(', ', $render_options) . ")";
  }
  //$href = "javascript:process_information('" . $formname . "', '" . $func . "', '" . $module . "', " .  implode(', ', $render_options) . ")";

  if ($options['class'] == 'disabled') {
    $href = '#';
  }

	if($options['target']){
		$target = 'target="'.$options['target'].'"';
	}

  return '<a class="' . $options['class'] . '" href="' . $href . '" '.$target.'>' . $text . '</a>';
}

/**
 * Builds the process_information link with its parameters
 * process_information(formname, func, module, ask_confirm, extra_value, error_el, response_el, response_type, request_type, parent, el, proc_message, timer)
 */
function theme_button_process_information($id, $name, $value, $func, $module, $extra) {

	$js = "javascript:process_information('" . $formname . "', '" . $func . "', '" . $module . "', null, '" .  $extra . "')";

	/*return '<input type="button"
	class="btn btn-primary"
	id="'.$id.'"
	name="'.$name.'"
	onclick="'.$js.'"
	value="'.$value.'"
	data-original-title=""
	title="">';*/

	/*<a type="button"
	 *class="btn btn-primary"
	 *id="buy_did"
	 *name="buy_did"
	 *href="javascript:process_information('', 'buy_phone_number', 'phone_number', '')" value="Buy Now" data-original-title="" title="">Buy Now</a>

	*/
	return '<a type="button"
	class="btn btn-primary"
	id="'.$id.'"
	name="'.$name.'"
	href="'.$js.'"
	value="'.$value.'"
	data-original-title=""
	title="">'.$value.'</a>';
  //return '<a class="' . $options['class'] . '" href="' . $href . '">' . $text . '</a>';
}

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

/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

		//close the zip -- done!
		$zip->close();

		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}

function json_pretty($json, $options = array())
{
    $tokens = preg_split('|([\{\}\]\[,])|', $json, -1, PREG_SPLIT_DELIM_CAPTURE);
    $result = '';
    $indent = 0;
    $format = 'txt';
    //$ind = "\t";
    $ind = "    ";
    if (isset($options['format'])) {
        $format = $options['format'];
    }
    switch ($format) {
        case 'html':
            $lineBreak = '<br />';
            $ind = '&nbsp;&nbsp;&nbsp;&nbsp;';
            break;
        default:
        case 'txt':
            $lineBreak = "\n";
            //$ind = "\t";
            $ind = "    ";
            break;
    }
    // override the defined indent setting with the supplied option
    if (isset($options['indent'])) {
        $ind = $options['indent'];
    }
    $inLiteral = false;
    foreach ($tokens as $token) {
        if ($token == '') {
            continue;
        }
        $prefix = str_repeat($ind, $indent);
        if (!$inLiteral && ($token == '{' || $token == '[')) {
            $indent++;
            if (($result != '') && ($result[(strlen($result) - 1)] == $lineBreak)) {
                $result .= $prefix;
            }
            $result .= $token . $lineBreak;
        } elseif (!$inLiteral && ($token == '}' || $token == ']')) {
            $indent--;
            $prefix = str_repeat($ind, $indent);
            $result .= $lineBreak . $prefix . $token;
        } elseif (!$inLiteral && $token == ',') {
            $result .= $token . $lineBreak;
        } else {
            $result .= ( $inLiteral ? '' : $prefix ) . $token;
            // Count # of unescaped double-quotes in token, subtract # of
            // escaped double-quotes and if the result is odd then we are
            // inside a string literal
            if ((substr_count($token, "\"") - substr_count($token, "\\\"")) % 2 != 0) {
                $inLiteral = !$inLiteral;
            }
        }
    }
    return $result;
}

?>
