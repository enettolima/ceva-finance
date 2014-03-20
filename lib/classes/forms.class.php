<?php

class DbForm {

  function _get_session_var($data) {
    $data = " " . $data;
    $ini = strpos($data, "s{");
    if ($ini == 0)
      return "";
    $ini += strlen("s{");
    $len = strpos($data, "}", $ini) - $ini;
    return substr($data, $ini, $len);
  }

  function _get_var($data) {
    $data = " " . $data;
    $ini = strpos($data, "v{");
    if ($ini == 0)
      return "";
    $ini += strlen("v{");
    $len = strpos($data, "}", $ini) - $ini;
    return substr($data, $ini, $len);
  }

  function build($form_name, $val = NULL, $level = NULL) {

    global $twig;

    $form_fields = new DataManager();
    $form_param = new DataManager();
    $check_dup = new DataManager();
    $formres = "";

    $level = ($level == NULL && isset($_SESSION['log_access_level'])) ? $_SESSION['log_access_level'] : $level;

    $form_fields->dm_load_list(NATURAL_DBNAME . "." . FIELD_TABLE, "ASSOC", "form_reference='" . $form_name . "' ORDER BY level, field_name DESC");
    if (!$form_fields->affected) {
      echo 'Form ' . $form_name . ' not found!';
      exit(0);
    }

    $form_param->dm_load_single(NATURAL_DBNAME . "." . FORM_TABLE, "form_id='" . $form_name . "' LIMIT 1");
    if (!$form_param->affected) {
      echo 'Parameters for the form ' . $form_name . ' not found!';
      exit(0);
    }
    if ($form_param->form_tips) {
      $tips = "<h3 class='form_tips'>{$form_param->form_tips}</h3>";
    }
    if ($form_param->form_legend) {
      $formres = $form_param->form_legend . "\n";
    }

    // Overriding values from action
    if ($val->action) {
      $action = $val->action;
    } else {
      $action = str_replace("\'", "'", $form_param->form_action);
    }
    $formres = "{$parag}{$tips}
      <form id=\"{$form_param->form_id}\" name=\"{$form_param->form_name}\" class=\"{$form_param->form_class}\" action=\"" . $action . "\" method=\"{$form_param->form_method}\" onsubmit=\"$form_param->form_onsubmit\">\n" . $formres;
    $ct = 0;

    /* start looping through fieldsets */
    for ($f = 0; $f < $form_fields->affected; $f++) {
      if ($form_fields->data[$f]['level'] != $level && $form_fields->data[$f]['field_name'] == $form_fields->data[$f - 1]['field_name']) {
        continue;
      }

      $form_element = "";
      $radio_element = "";

      if (is_object($val)) {
        /*
         * nice, we have an object available here
         * let's get the vaules and whatnot from here.
         */


        $fdef_val       = trim($form_fields->data[$f]['def_val']);
        $f_values       = trim($form_fields->data[$f]['field_values']);
        $prefix_values  = trim($form_fields->data[$f]['prefix']);
        $suffix_values  = trim($form_fields->data[$f]['suffix']);
        $html_options   = trim($form_fields->data[$f]['html_options']);

        if (property_exists($val, $fdef_val)) {
          $form_fields->data[$f]['def_val'] = $val->{$fdef_val};
        }
        if (isset($val->$f_values)) {
          $form_fields->data[$f]['field_values'] = $val->{$f_values};
        }
        if (isset($val->{$prefix_values})) {
          $form_fields->data[$f]['prefix'] = $val->{$prefix_values};
        }
        if (isset($val->{$suffix_values})) {
          $form_fields->data[$f]['suffix'] = $val->{$suffix_values};
        }
        if (property_exists($val, $html_options)) {
          $form_fields->data[$f]['html_options'] = $val->{$html_options};
        }
        /*if(!$form_fields->data[$f]['vertical']){
          $form_fields->data[$f]['vertical'] = '_auto';
        }*/
      }

      $fname = trim($form_fields->data[$f]['field_id']);
      $field_id = trim($form_fields->data[$f]['field_id']);

      /**
       * Required Field
       */
      if ($form_fields->data[$f]['required']) {
        $form_fields->data[$f]['def_label'] .= ' <span class="field-required">*</span>';
      }

      /**
       * Tooltip
       */
      if ($form_fields->data[$f]['tooltip']) {
        $form_fields->data[$f]['def_label'] .= ' <a class="tooltip">Tooltip</a><span class="tooltip-text">' . $form_fields->data[$f]['tooltip'] . '</span>';
      }

      /*
       * Verifies the form field Level and applies the ACL if needed
       * to make this work you must set the level field in the field_template
       * to the minimum level that has access to the raw field withou the ACL
       * being applied. for example if you set the Level to 41 and ACL to readonly
       * anyone with level 41 and below will not be able to edit the field
       * only people with level 42 and above.
       */

      if ($form_fields->data[$f]['level'] >= $level) {
        if ($form_fields->data[$f]['acl'] != "" && $form_fields->data[$f]['html_type'] != "list") {
          $form_fields->data[$f]['html_type'] = $form_fields->data[$f]['acl'];
        }
        // If you insert something in the level and don't specifye anything on acl then acl will be hidden by default...
        else {
          if ($form_fields->data[$f]['html_type'] != "list")
            $form_fields->data[$f]['html_type'] = 'hidden';
        }
      }

      switch ($form_fields->data[$f]['html_type']) {
        case 'fileuploader':
          $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-file"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
          $form_element .= $form_fields->data[$f]['prefix'] . '<span id="' . $form_fields->data[$f]['field_id'] . '" class="upload-button ' . $form_fields->data[$f]['css_class'] . '"> <span>' . $form_fields->data[$f]['field_name'] . '</span> </span>' . $form_fields->data[$f]['suffix'] . '</div>';
          $script = '<script  type="text/javascript">file_uploader(\'' . $form_fields->data[$f]['field_id'] . '\', \'' . $form_fields->data[$f]['field_values'] . '\');</script>';
          $form_element .= '<div class="form-item '. $form_fields->data[$f]['vertical'].'"><span id="file-message"></span><ol id="uploaded-files"></ol> <textarea id="files" name="files"></textarea>' . $script . '</div>';
          break;
        case 'submit':
          $form_element .= '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-submit"> <input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_label'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" />' . $form_fields->data[$f]['suffix'] . '</div>';
          break;
        case 'reset':
          $form_element .= '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-reset"> <input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" />' . $form_fields->data[$f]['suffix'] . '</div>';
          break;
        case 'button':
          $form_element .= '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-button"> <input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" />' . $form_fields->data[$f]['suffix'] . '</div>';
          break;
        case 'text':
          $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-text"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
          $form_element .= $form_fields->data[$f]['prefix'] . '<input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" onChange="' . $form_fields->data[$f]['onchange'] . '" onChange="' . $form_fields->data[$f]['onchange'] . '" />' . $form_fields->data[$f]['suffix'] . '</div>';
          break;
        case 'hidden':
          $hidden_element .= '<input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '">';
          break;
        case 'readonly':
          if ($form_fields->data[$f]['data_table'] != '') {
            $dm = new DataManager;
            $query = "SELECT {$form_fields->data[$f]['data_label']} FROM {$form_fields->data[$f]['data_table']} WHERE {$form_fields->data[$f]['data_value']} = '{$form_fields->data[$f]['def_val']}' AND {$form_fields->data[$f]['data_query']}  ORDER BY {$form_fields->data[$f]['data_sort']} LIMIT 1";
            $dm->dm_custom_query($query, true);
            $data_label = $form_fields->data[$f]['data_label'];
            if (!$dm->$data_label) {
              $dm->$data_label = '-';
            }
            $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-readonly"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
            $form_element .= $form_fields->data[$f]['prefix'] . $dm->$data_label . '<input type="hidden" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '"' . $form_fields->data[$f]['html_options'] . '/>' . $form_fields->data[$f]['suffix'] . '</div>';
          } else {
            $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-readonly"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
            $form_element .= $form_fields->data[$f]['prefix'] . $form_fields->data[$f]['def_val'] . '<input type="hidden" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '"' . $form_fields->data[$f]['html_options'] . '/>' . $form_fields->data[$f]['suffix'] . '</div>';
          }
          break;
        case 'password':
          $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-password"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
          $form_element .= $form_fields->data[$f]['prefix'] . '<input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '"' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" >' . $form_fields->data[$f]['suffix'] . '</div>';
          break;
        case 'checkbox': //Buggy
          $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-password"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
          $form_element .= $form_fields->data[$f]['prefix'] . '<input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '"' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" >' . $form_fields->data[$f]['suffix'] . '</div>';
          break;
        case 'list':
          if ($form_fields->data[$f]['data_table'] != "") {
            $select_options = '';
            $query_field_name = '';
            while (strpos($form_fields->data[$f]['data_query'], "s{") > 0) {
              $query_field_name = $this->_get_session_var($form_fields->data[$f]['data_query']);
              $form_fields->data[$f]['data_query'] = str_replace("s{{$query_field_name}}", "{$_SESSION[$query_field_name]}", $form_fields->data[$f]['data_query']);
            }
            $dm = new DataManager;
            $query_select = ($form_fields->data[$f]['data_value'] == $form_fields->data[$f]['data_label']) ? $form_fields->data[$f]['data_value'] : "{$form_fields->data[$f]['data_value']},{$form_fields->data[$f]['data_label']}";
            $query = "SELECT {$query_select} FROM {$form_fields->data[$f]['data_table']} WHERE {$form_fields->data[$f]['data_query']} ORDER BY {$form_fields->data[$f]['data_sort']}";
            $dm->dm_load_custom_list($query, "ASSOC");

            $data_value = explode(',', $form_fields->data[$f]['data_value']);
            $data_label = explode(',', $form_fields->data[$f]['data_label']);
            for ($dvf = 0; $dvf < count($data_value); $dvf++) {
              $value = $data_value[$dvf];
              $label = $data_label[$dvf];

              for ($y = 0; $y < $dm->affected; $y++) {
                if ($dm->data[$y][$value] == $prev_value && $dm->data[$y][$label] == $prev_label)
                  continue;

                if ($dm->data[$y][$data_value[$dvf]] == $form_fields->data[$f]['def_val']) {
                  $status = 'selected';
                  $readonly_data['label'] = $dm->data[$y][$label];
                  $readonly_data['value'] = $dm->data[$y][$value];
                } else {
                  $status = '';
                }

                $select_options .= '<option value="' . $dm->data[$y][$value] . '" ' . $status . '>' . $dm->data[$y][$label] . '</option>';
                $prev_value = $dm->data[$y][$value];
                $prev_label = $dm->data[$y][$label];
              }
            }

            if ($form_fields->data[$f]['field_values']) {
              $opt = explode(';', $form_fields->data[$f]['field_values']);
              for ($i = 0; $i < count($opt); $i++) {
                if ($opt[$i]) {
                  $values_pair = explode('=', $opt[$i]);
                  if ($values_pair[1] == $form_fields->data[$f]['def_val']) {
                    $status = 'selected';
                    $readonly_data['label'] = $values_pair[0];
                    $readonly_data['value'] = $values_pair[1];
                  } else {
                    $status = "";
                  }
                  $select_options .= "\n\t\t\t\t<option value=" . $values_pair[1] . ' ' . $status . '>' . $values_pair[0] . '</option>';
                }
              }
            }
          } else {
            $opt = explode(';', $form_fields->data[$f]['field_values']);
            $select_options = '';

            for ($i = 0; $i < count($opt); $i++) {
              $values_pair = explode("=", $opt[$i]);
              if ($values_pair[1] == $form_fields->data[$f]['def_val']) {
                $status = 'selected';
                $readonly_data['label'] = $values_pair[0];
                $readonly_data['value'] = $values_pair[1];
              } else {
                $status = '';
              }
              $select_options .= '<option value="' . $values_pair[1] . '" ' . $status . '>' . $values_pair[0] . '</option>';
            }
          }
          if ($form_fields->data[$f]['acl'] == 'readonly' && $form_fields->data[$f]['level'] >= $level) {
            $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-select"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
            $form_element .= $form_fields->data[$f]['prefix'] . $readonly_data['label'] . '<input type="hidden" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $readonly_data['value'] . '"' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" >' . $form_fields->data[$f]['suffix'] . '</div>';
          } else {
            $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-select"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
            $form_element .= $form_fields->data[$f]['prefix'] . '<select id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" onChange="' . $form_fields->data[$f]['onchange'] . '">' . $select_options . '</select >' . $form_fields->data[$f]['suffix'] . '</div>';
          }
          break;
        case 'textarea':
          $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-textarea"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
          $form_element .= $form_fields->data[$f]['prefix'] . '<textarea id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" >' . $form_fields->data[$f]['def_val'] . '</textarea >' . $form_fields->data[$f]['suffix'] . '</div>';
          break;
        case 'radio': //Buggy
          if ($form_fields->data[$f]['data_table'] != "") {
            $select_options = "";
            $dm = new DataManager;
            $dm->dm_load_list(NATURAL_DBNAME . ".{$form_fields->data[$f]['data_table']}", "ASSOC", "{$form_fields->data[$f]['data_query']} ORDER BY {$form_fields->data[$f]['data_sort']}");
            $data_value = $form_fields->data[$f]['data_value'];
            $def_label = $form_fields->data[$f]['def_label'];
            for ($y = 0; $y < count($dm->data); $y++) {
              if ($dm->data[$y][$data_value] == $form_fields->data[$f]['def_val']) {
                $status = 'checked';
              } else {
                $status = '';
              }
              $radio_element .= '<input type="radio" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" value="' . $dm->data[$y][$data_value] . '" ' . $status . '>' . $dm->data[$y][$def_label];
            }
            if ($form_fields->data[$f]['values']) {
              $opt = explode(';', $form_fields->data[$f]['values']);
              for ($i = 0; $i < count($opt); $i++) {
                if ($opt[$i]) {
                  $values_pair = explode('=', $opt[$i]);
                  if ($values_pair[1] == $form_fields->data[$f]['def_val']) {
                    $status = 'checked';
                  } else {
                    $status = '';
                  }
                  $radio_element .= '<input type="radio" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" ' . $form_fields->data[$f]['html_options'] . '  onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" value="' . $dm->data[$i]['values'] . '" ' . $status . ' >' . $values_pair[0];
                }
              }
            }
          } else {
            $values = explode(';', $form_fields->data[$f]['values']);
            foreach ($values as $key => $value) {
              $values_pair = split('=', $value);
              if ($values_pair[1] == $form_fields->data[$f]['def_val']) {
                $status = 'checked';
              } else {
                $status = '';
              }

              $radio_element .= '<input type="radio" id="' . $form_fields->data[$f]['form_id'] . '" name="' . $form_fields->data[$f]['form_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" ' . $form_fields->data[$f]['html_options'] . '  onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" value="' . $values_pair[1] . '" ' . $status . ' > ' . $values_pair[0];
            }
          }
          $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-radio"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
          $form_element .= $form_fields->data[$f]['prefix'] . $radio_element . $form_fields->data[$f]['suffix'] . '</div>';
          break;
        case 'message':
          $form_element = '<div name="' . $form_fields->data[$f]['form_name'] . '" id="' . $form_fields->data[$f]['form_id'] . '" class="' . $form_fields->data[$f]['style'] . '"><p>' . $form_fields->data[$f]['message'] . '</p></div>';
          break;
      }
      if ($form_fields->data[$f]['html_type'] != 'hidden') {
        $fieldset[$form_fields->data[$f]['form_field_order']] = $form_element;
        $ct++;
      }
    }
    ksort($fieldset);
    foreach ($fieldset as $key => $value) {
      $fields .= $value;
    }
    $formres .= $fields;
    $formres .= $hidden_element . '</form>';

    // Render Array
    $render = array(
      'page_title' => !empty($form_param->form_title) ? $form_param->form_title : '',
      'content'=> $formres, // TEMPORARY
    );

    $template = $twig->loadTemplate('form.html');
    $template->display($render);
    //return $formres;
  }

}

class DbFieldset {

  function _get_session_var($data) {
    $data = " " . $data;
    $ini = strpos($data, "s{");
    if ($ini == 0)
      return "";
    $ini += strlen("s{");
    $len = strpos($data, "}", $ini) - $ini;
    return substr($data, $ini, $len);
  }

  function _get_var($data) {
    $data = " " . $data;
    $ini = strpos($data, "v{");
    if ($ini == 0)
      return "";
    $ini += strlen("v{");
    $len = strpos($data, "}", $ini) - $ini;
    return substr($data, $ini, $len);
  }

  function build($form_name, $val=NULL, $level=NULL, $disable=NULL) {
    $form_fields = new DataManager();
    $form_param = new DataManager();
    $check_dup = new DataManager();
    $formres = "";

    $level = ($level == NULL && isset($_SESSION['log_access_level'])) ? $_SESSION['log_access_level'] : $level;

    $form_fields->dm_load_list(NATURAL_DBNAME . "." . FIELD_TABLE, "ASSOC", "form_reference='{$form_name}' ORDER BY level,field_name DESC");
    if (!$form_fields->affected) {
      echo "Form {$form_name} not found!";
      exit(0);
    }

    $form_param->dm_load_single(NATURAL_DBNAME . "." . FORM_TABLE, "form_id='{$form_name}' LIMIT 1");
    if (!$form_param->affected) {
      echo "Parameters for the form {$form_name} not found!";
      exit(0);
    }
    if ($form_param->form_title) {
      $parag = "<h1>{$form_param->form_title}</h1>";
    }
    if ($form_param->form_tips) {
      $tips = "<h3 class='form_tips'>{$form_param->form_tips}</h3>";
    }

    // Overriding values from action
    if ($val->action) {
      $action = $val->action;
    } else {
      $action = str_replace("\'", "'", $form_param->form_action);
    }
    $formheader = "{$parag}{$tips}
			<form id=\"{$form_param->form_id}\" name=\"{$form_param->form_name}\" class=\"{$form_param->form_class}\" action=\"" . $action . "\" method=\"{$form_param->form_method}\" onsubmit=\"$form_param->form_onsubmit\">\n";

    if ($disable) {
      foreach ($disable as $key => $value) {
        $skip_fieldset .= "AND name!='{$value}' ";
      }
    }
    $fs = new DataManager();
    $fs->dm_load_list("" . NATURAL_DBNAME . "." . FIELDSET_TABLE . "", "ASSOC", "id!='' {$skip_fieldset} ORDER BY position");
    for ($z = 0; $z < $fs->affected; $z++) {

      $fieldset = array();
      $tablerows = "";
      $form_fields = new DataManager();
      $form_fields->dm_load_list(NATURAL_DBNAME . "." . FIELD_TABLE, "ASSOC", "form_reference='{$form_name}' AND fieldset_name='{$fs->data[$z]['name']}' ORDER BY form_field_order, level,field_name DESC");
      if ($form_fields->affected) {
        if ($fs->data[$z]['label']) {
          $legend = $fs->data[$z]['label'];
        } else {
          $legend = $form_param->form_legend;
        }
        $mount_name = $fs->data[$z]['name'] . "_table";
        $formres .= "<fieldset class='{$fs->data[$z]['css_class']}' name='{$fs->data[$z]['name']}' id='{$fs->data[$z]['name']}'>
					<legend onclick=\"fieldset_action(this);\">{$legend}</legend>";
        $ct = 0;

        /* start looping through fieldsets */
        for ($f = 0; $f < $form_fields->affected; $f++) {
          if ($form_fields->data[$f]['level'] != $level && $form_fields->data[$f]['field_name'] == $form_fields->data[$f - 1]['field_name']) {
            continue;
          }

          $form_element = "";
          $radio_element = "";

          if (is_object($val)) {
            /*
             * nice, we have and object available here
             * let's get the vaules and whatnot from here.
             */


            $fdef_val = trim($form_fields->data[$f]['def_val']);
            $f_values = trim($form_fields->data[$f]['field_values']);
            $prefix_values = trim($form_fields->data[$f]['prefix']);
            $suffix_values = trim($form_fields->data[$f]['suffix']);
            $html_options = trim($form_fields->data[$f]['html_options']);

            if (property_exists($val, $fdef_val)) {
              $form_fields->data[$f]['def_val'] = $val->{$fdef_val};
            }
            if (isset($val->$f_values)) {
              $form_fields->data[$f]['field_values'] = $val->{$f_values};
            }
            if (isset($val->{$prefix_values})) {
              $form_fields->data[$f]['prefix'] = $val->{$prefix_values};
            }
            if (isset($val->{$suffix_values})) {
              $form_fields->data[$f]['suffix'] = $val->{$suffix_values};
            }
            if (property_exists($val, $html_options)) {
              $form_fields->data[$f]['html_options'] = $val->{$html_options};
            }
            /*if(!$form_fields->data[$f]['vertical']){
              $form_fields->data[$f]['vertical'] = '_auto';
            }*/
          }

          $fname = trim($form_fields->data[$f]['field_id']);
          $field_id = trim($form_fields->data[$f]['field_id']);

          /**
           * Required Field
           */
          if ($form_fields->data[$f]['required']) {
            $form_fields->data[$f]['def_label'] .= ' <span class="field-required">*</span>';
          }


          /**
           * Tooltip
           */
          if ($form_fields->data[$f]['tooltip']) {
            $form_fields->data[$f]['def_label'] .= ' <a class="tooltip">Tooltip</a><span class="tooltip-text">' . $form_fields->data[$f]['tooltip'] . '</span>';
          }

          /*
           * Verifies the form field Level and applies the ACL if needed
           * to make this work you must set the level field in the field_template
           * to the minimum level that has access to the raw field withou the ACL
           * being applied. for example if you set the Level to 41 and ACL to readonly
           * anyone with level 41 and below will not be able to edit the field
           * only people with level 42 and above.
           */

          if ($form_fields->data[$f]['level'] >= $level) {
            if ($form_fields->data[$f]['acl'] != '' && $form_fields->data[$f]['html_type'] != 'list') {
              $form_fields->data[$f]['html_type'] = $form_fields->data[$f]['acl'];
            }
            // If you insert something in the level and don't specifye anything on acl then acl will hidden by default...
            else {
              if ($form_fields->data[$f]['html_type'] != 'list')
                $form_fields->data[$f]['html_type'] = 'hidden';
            }
          }

          switch ($form_fields->data[$f]['html_type']) {
            case 'fileuploader':
              $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-file"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
              $form_element .= $form_fields->data[$f]['prefix'] . '<span id="' . $form_fields->data[$f]['field_id'] . '" class="upload-button ' . $form_fields->data[$f]['css_class'] . '"> <span>' . $form_fields->data[$f]['field_name'] . '</span> </span>' . $form_fields->data[$f]['suffix'] . '</div>';
              $script = '<script  type="text/javascript">file_uploader(\'' . $form_fields->data[$f]['field_id'] . '\', \'' . $form_fields->data[$f]['field_values'] . '\');</script>';
              $form_element .= '<div class="form-item '. $form_fields->data[$f]['vertical'].'"><span id="file-message"></span><ol id="uploaded-files"></ol> <textarea id="files" name="files"></textarea>' . $script . '</div>';
              break;
            case 'submit':
              $buttons .= $form_fields->data[$f]['prefix'] . '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-submit"> <input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_label'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" />' . $form_fields->data[$f]['suffix'] . '</div>';
              break;
            case 'reset':
              $buttons .= '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-reset"> <input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" />' . $form_fields->data[$f]['suffix'] . '</div>';
              break;
            case 'button':
              $form_element .= '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-button"> <input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" />' . $form_fields->data[$f]['suffix'] . '</div>';
              break;
            case 'text':
              $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-text"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
              $form_element .= $form_fields->data[$f]['prefix'] . '<input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" onChange="' . $form_fields->data[$f]['onchange'] . '" onChange="' . $form_fields->data[$f]['onchange'] . '" />' . $form_fields->data[$f]['suffix'] . '</div>';
              break;
            case 'hidden':
              $hidden_element .= '<input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '">';
              break;
            case 'readonly':
              if ($form_fields->data[$f]['data_table'] != '') {
                $dm = new DataManager;
                $query = "SELECT {$form_fields->data[$f]['data_label']} FROM {$form_fields->data[$f]['data_table']} WHERE {$form_fields->data[$f]['data_value']} = '{$form_fields->data[$f]['def_val']}' AND {$form_fields->data[$f]['data_query']}  ORDER BY {$form_fields->data[$f]['data_sort']} LIMIT 1";
                $dm->dm_custom_query($query, true);
                $data_label = $form_fields->data[$f]['data_label'];
                if (!$dm->$data_label) {
                  $dm->$data_label = '-';
                }
                $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-readonly"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
                $form_element .= $form_fields->data[$f]['prefix'] . $dm->$data_label . '<input type="hidden" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '"' . $form_fields->data[$f]['html_options'] . '/>' . $form_fields->data[$f]['suffix'] . '</div>';
              } else {
                $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-readonly"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
                $form_element .= $form_fields->data[$f]['prefix'] . $form_fields->data[$f]['def_val'] . '<input type="hidden" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '"' . $form_fields->data[$f]['html_options'] . '/>' . $form_fields->data[$f]['suffix'] . '</div>';
              }
              break;
            case 'password':
              $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-password"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
              $form_element .= $form_fields->data[$f]['prefix'] . '<input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '"' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" >' . $form_fields->data[$f]['suffix'] . '</div>';
              break;
            case 'checkbox': //Buggy
              $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-password"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
              $form_element .= $form_fields->data[$f]['prefix'] . '<input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '"' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" >' . $form_fields->data[$f]['suffix'] . '</div>';
              break;
            case 'list':
              if ($form_fields->data[$f]['data_table'] != "") {
                $select_options = '';
                $query_field_name = '';
                while (strpos($form_fields->data[$f]['data_query'], "s{") > 0) {
                  $query_field_name = $this->_get_session_var($form_fields->data[$f]['data_query']);
                  $form_fields->data[$f]['data_query'] = str_replace("s{{$query_field_name}}", "{$_SESSION[$query_field_name]}", $form_fields->data[$f]['data_query']);
                }
                $dm = new DataManager;
                $query_select = ($form_fields->data[$f]['data_value'] == $form_fields->data[$f]['data_label']) ? $form_fields->data[$f]['data_value'] : "{$form_fields->data[$f]['data_value']},{$form_fields->data[$f]['data_label']}";
                $query = "SELECT {$query_select} FROM {$form_fields->data[$f]['data_table']} WHERE {$form_fields->data[$f]['data_query']} ORDER BY {$form_fields->data[$f]['data_sort']}";
                $dm->dm_load_custom_list($query, "ASSOC");

                $data_value = explode(',', $form_fields->data[$f]['data_value']);
                $data_label = explode(',', $form_fields->data[$f]['data_label']);
                for ($dvf = 0; $dvf < count($data_value); $dvf++) {
                  $value = $data_value[$dvf];
                  $label = $data_label[$dvf];

                  for ($y = 0; $y < $dm->affected; $y++) {
                    if ($dm->data[$y][$value] == $prev_value && $dm->data[$y][$label] == $prev_label)
                      continue;

                    if ($dm->data[$y][$data_value[$dvf]] == $form_fields->data[$f]['def_val']) {
                      $status = 'selected';
                      $readonly_data['label'] = $dm->data[$y][$label];
                      $readonly_data['value'] = $dm->data[$y][$value];
                    } else {
                      $status = '';
                    }

                    $select_options .= '<option value="' . $dm->data[$y][$value] . '" ' . $status . '>' . $dm->data[$y][$label] . '</option>';
                    $prev_value = $dm->data[$y][$value];
                    $prev_label = $dm->data[$y][$label];
                  }
                }

                if ($form_fields->data[$f]['field_values']) {
                  $opt = explode(';', $form_fields->data[$f]['field_values']);
                  for ($i = 0; $i < count($opt); $i++) {
                    if ($opt[$i]) {
                      $values_pair = explode('=', $opt[$i]);
                      if ($values_pair[1] == $form_fields->data[$f]['def_val']) {
                        $status = 'selected';
                        $readonly_data['label'] = $values_pair[0];
                        $readonly_data['value'] = $values_pair[1];
                      } else {
                        $status = "";
                      }
                      $select_options .= "\n\t\t\t\t<option value=" . $values_pair[1] . ' ' . $status . '>' . $values_pair[0] . '</option>';
                    }
                  }
                }
              } else {
                $opt = explode(';', $form_fields->data[$f]['field_values']);
                $select_options = '';

                for ($i = 0; $i < count($opt); $i++) {
                  $values_pair = explode("=", $opt[$i]);
                  if ($values_pair[1] == $form_fields->data[$f]['def_val']) {
                    $status = 'selected';
                    $readonly_data['label'] = $values_pair[0];
                    $readonly_data['value'] = $values_pair[1];
                  } else {
                    $status = '';
                  }
                  $select_options .= '<option value="' . $values_pair[1] . '" ' . $status . '>' . $values_pair[0] . '</option>';
                }
              }
              if ($form_fields->data[$f]['acl'] == 'readonly' && $form_fields->data[$f]['level'] >= $level) {
                $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-select"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
                $form_element .= $form_fields->data[$f]['prefix'] . $readonly_data['label'] . '<input type="hidden" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $readonly_data['value'] . '"' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" >' . $form_fields->data[$f]['suffix'] . '</div>';
              } else {
                $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-select"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
                $form_element .= $form_fields->data[$f]['prefix'] . '<select id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" onChange="' . $form_fields->data[$f]['onchange'] . '">' . $select_options . '</select >' . $form_fields->data[$f]['suffix'] . '</div>';
              }
              break;
            case 'textarea':
              $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-textarea"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
              $form_element .= $form_fields->data[$f]['prefix'] . '<textarea id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" >' . $form_fields->data[$f]['def_val'] . '</textarea >' . $form_fields->data[$f]['suffix'] . '</div>';
              break;
            case 'radio': //Buggy
              if ($form_fields->data[$f]['data_table'] != "") {
                $select_options = "";
                $dm = new DataManager;
                $dm->dm_load_list(NATURAL_DBNAME . ".{$form_fields->data[$f]['data_table']}", "ASSOC", "{$form_fields->data[$f]['data_query']} ORDER BY {$form_fields->data[$f]['data_sort']}");
                $data_value = $form_fields->data[$f]['data_value'];
                $def_label = $form_fields->data[$f]['def_label'];
                for ($y = 0; $y < count($dm->data); $y++) {
                  if ($dm->data[$y][$data_value] == $form_fields->data[$f]['def_val']) {
                    $status = 'checked';
                  } else {
                    $status = '';
                  }
                  $radio_element .= '<input type="radio" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" value="' . $dm->data[$y][$data_value] . '" ' . $status . '>' . $dm->data[$y][$def_label];
                }
                if ($form_fields->data[$f]['values']) {
                  $opt = explode(';', $form_fields->data[$f]['values']);
                  for ($i = 0; $i < count($opt); $i++) {
                    if ($opt[$i]) {
                      $values_pair = explode('=', $opt[$i]);
                      if ($values_pair[1] == $form_fields->data[$f]['def_val']) {
                        $status = 'checked';
                      } else {
                        $status = '';
                      }
                      $radio_element .= '<input type="radio" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" ' . $form_fields->data[$f]['html_options'] . '  onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" value="' . $dm->data[$i]['values'] . '" ' . $status . ' >' . $values_pair[0];
                    }
                  }
                }
              } else {
                $values = explode(';', $form_fields->data[$f]['values']);
                foreach ($values as $key => $value) {
                  $values_pair = split('=', $value);
                  if ($values_pair[1] == $form_fields->data[$f]['def_val']) {
                    $status = 'checked';
                  } else {
                    $status = '';
                  }

                  $radio_element .= '<input type="radio" id="' . $form_fields->data[$f]['form_id'] . '" name="' . $form_fields->data[$f]['form_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" ' . $form_fields->data[$f]['html_options'] . '  onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" value="' . $values_pair[1] . '" ' . $status . ' > ' . $values_pair[0];
                }
              }
              $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-radio"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
              $form_element .= $form_fields->data[$f]['prefix'] . $radio_element . $form_fields->data[$f]['suffix'] . '</div>';
              break;
            case 'message':
              $form_element = '<div name="' . $form_fields->data[$f]['form_name'] . '" id="' . $form_fields->data[$f]['form_id'] . '" class="' . $form_fields->data[$f]['style'] . '"><p>' . $form_fields->data[$f]['message'] . '</p></div>';
              break;
          }
          if ($form_fields->data[$f]['html_type'] != 'hidden') {
            $fieldset[$form_fields->data[$f]['form_field_order']] = $form_element;
            $ct++;
          }
        }
        ksort($fieldset);
        //die(print_r($fieldset));
        $fields = '';
        foreach ($fieldset as $key => $value) {
          $fields .= $value;
        }
        $formres .= $fields;
        $formres .= $hidden_element . '</fieldset>';
      }
      //FINISH LOOP TO THE FIELDSET HERE
    }

    $formfoot = $buttons . '</form>';

//Adding auto width on form labels:
    /*        $formres .= '<script type="text/javascript">
                $().ready(function() {
        var max = 0;
        $("label").each(function(){
            if ($(this).width() > max)
                max = $(this).width();
        });
        $("label").width(max);
        $(".multiple-select-container").css("margin-left",max+15+"px");
    });
    </script>';        */

    return $formheader . $formres . $formfoot;
  }

}

?>