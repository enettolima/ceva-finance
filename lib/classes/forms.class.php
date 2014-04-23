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

  function _get_field_options($field) {
    $options = array();
    if ($field['data_table'] != '') {
      $query_field_name = '';
      while (strpos($field['data_query'], "s{") > 0) {
        $query_field_name = $this->_get_session_var($field['data_query']);
        $field['data_query'] = str_replace("s{{$query_field_name}}", "{$_SESSION[$query_field_name]}", $field['data_query']);
      }
      $dm = new DataManager;
      $query_select = ($field['data_value'] == $field['data_label']) ? $field['data_value'] : "{$field['data_value']},{$field['data_label']}";
      $query = "SELECT {$query_select} FROM {$field['data_table']} WHERE {$field['data_query']} ORDER BY {$field['data_sort']}";
      $dm->dm_load_custom_list($query, 'ASSOC');

      $data_value = explode(',', $field['data_value']);
      $data_label = explode(',', $field['data_label']);
      for ($dvf = 0; $dvf < count($data_value); $dvf++) {
        $value = $data_value[$dvf];
        $label = $data_label[$dvf];

        for ($y = 0; $y < $dm->affected; $y++) {
          if ($dm->data[$y][$value] == $prev_value && $dm->data[$y][$label] == $prev_label)
            continue;

          switch($field['html_type']) {
            case 'list':
              $status = ($dm->data[$y][$data_value[$dvf]] == $field['def_val'] ? 'selected' : '');
              break;
            case 'checkbox':
            case 'radio':
              // For Multiple Checkbox Values
              if (is_array($field['def_val'])) {
                $status = (in_array($dm->data[$y][$data_value[$dvf]], $field['def_val']) ? 'checked' : '');
              }
              else {
                $status = ($dm->data[$y][$data_value[$dvf]] == $field['def_val'] ? 'checked' : '');
              }
              break;
          }

          $options[] = array('value' => $dm->data[$y][$value], 'label' => $dm->data[$y][$label], 'status' => $status);
          $prev_value = $dm->data[$y][$value];
          $prev_label = $dm->data[$y][$label];
        }
      }

      if ($field['field_values']) {
        $opt = explode(';', $field['field_values']);
        for ($i = 0; $i < count($opt); $i++) {
          if ($opt[$i]) {
            $values_pair = explode('=', $opt[$i]);
            switch($field['html_type']) {
              case 'list':
                $status = ($values_pair[1] == $field['def_val'] ? 'selected' : '');
                break;
              case 'checkbox':
              case 'radio':
                if (is_array($field['def_val'])) {
                  $status = (in_array($values_pair[1], $field['def_val']) ? 'checked' : '');
                }
                else {
                  $status = ($values_pair[1] == $field['def_val'] ? 'checked' : '');
                }
                break;
            }
            $options[] = array('value' => $values_pair[1], 'label' => $values_pair[0], 'status' => $status);
          }
        }
      }
    }
    else {
      $opt = explode(';', $field['field_values']);
      for ($i = 0; $i < count($opt); $i++) {
        $values_pair = explode("=", $opt[$i]);
        switch($field['html_type']) {
          case 'list':
            $status = ($values_pair[1] == $field['def_val'] ? 'selected' : '');
            break;
          case 'checkbox':
          case 'radio':
            if (is_array($field['def_val'])) {
              $status = (in_array($values_pair[1], $field['def_val']) ? 'checked' : '');
            }
            else {
              $status = ($values_pair[1] == $field['def_val'] ? 'checked' : '');
            }
            break;
        }
        $options[] = array('value' => $values_pair[1], 'label' => $values_pair[0], 'status' => $status);
      }
    }
    return $options;
  }

  /**
   * Form builder
   */
  function build($form_name, $val = NULL, $level = NULL, $modal = TRUE) {

    global $twig;

    $form_fields = new DataManager();
    $form_param = new DataManager();
    $check_dup = new DataManager();
    $fields = array();
    $hidden_fields = array();

    $level = ($level == NULL && isset($_SESSION['log_access_level'])) ? $_SESSION['log_access_level'] : $level;

    $form_fields->dm_load_list(NATURAL_DBNAME . "." . FIELD_TABLE, "ASSOC", "form_reference='" . $form_name . "' ORDER BY form_field_order ASC");
    if (!$form_fields->affected) {
      $error_message = 'Form ' . $form_name . ' not found!';
    }

    $form_param->dm_load_single(NATURAL_DBNAME . "." . FORM_TABLE, "form_id='" . $form_name . "' LIMIT 1");
    if (!$form_param->affected) {
      $error_message = 'Parameters for the form ' . $form_name . ' not found!';
    }

    // Overriding values from action
    if ($val->action) {
      $form_action = $val->action;
    }
    else {
      $form_action = str_replace("\'", "'", $form_param->form_action);
    }

    // Start looping through fields.
    for ($f = 0; $f < $form_fields->affected; $f++) {
      if ($form_fields->data[$f]['level'] != $level && $form_fields->data[$f]['field_name'] == $form_fields->data[$f - 1]['field_name']) {
        continue;
      }

      // Field ID
      $form_fields->data[$f]['field_id'] = trim($form_fields->data[$f]['field_id']);

      if (is_object($val)) {
        $fdef_val       = trim($form_fields->data[$f]['def_val']);
        $f_values       = trim($form_fields->data[$f]['field_values']);
        $prefix_values  = trim($form_fields->data[$f]['prefix']);
        $suffix_values  = trim($form_fields->data[$f]['suffix']);
        $html_options   = trim($form_fields->data[$f]['html_options']);

        if (property_exists($val, $fdef_val)) {
          $form_fields->data[$f]['def_val'] = $val->$fdef_val;
        }
        if (isset($val->$f_values)) {
          $form_fields->data[$f]['field_values'] = $val->$f_values;
        }
        if (isset($val->{$prefix_values})) {
          $form_fields->data[$f]['prefix'] = $val->$prefix_values;
        }
        if (isset($val->{$suffix_values})) {
          $form_fields->data[$f]['suffix'] = $val->$suffix_values;
        }
        if (property_exists($val, $html_options)) {
          $form_fields->data[$f]['html_options'] = $val->$html_options;
        }
      }

      // Verifies the form field Level and applies the ACL if needed to make this work you must set the level field in the field_template
      // to the minimum level that has access to the raw field withou the ACL being applied. for example if you set the Level to 41 and ACL to readonly
      // anyone with level 41 and below will not be able to edit the field only people with level 42 and above.
      if ($form_fields->data[$f]['level'] >= $level) {
        if ($form_fields->data[$f]['acl'] != "" && $form_fields->data[$f]['html_type'] != 'list') {
          $form_fields->data[$f]['html_type'] = $form_fields->data[$f]['acl'];
        }
        // If you insert something in the level and don't specify anything on acl then acl will be hidden by default...
        else {
          if ($form_fields->data[$f]['html_type'] != 'list') {
            $form_fields->data[$f]['html_type'] = 'hidden';
          }
        }
      }

      // Preprocess some fields before sendint to the template engine.
      switch ($form_fields->data[$f]['html_type']) {
        case 'hidden':
          // We need to put the hidden fields after all other fields.
          $hidden_fields[$form_fields->data[$f]['id']] = $form_fields->data[$f];
          unset($form_fields->data[$f]);
          // Get out of the loop
          continue;
        case 'list':
          $options = $this->_get_field_options($form_fields->data[$f]);
          // Prepare select list options
          if ($form_fields->data[$f]['acl'] == 'readonly' && $form_fields->data[$f]['level'] >= $level) {
            // TODO Readonly - get the selected data based on options array and display
            $hidden_fields[] = $form_fields->data[$f];
            unset($form_fields->data[$f]);
          }
          else {
            $form_fields->data[$f]['options'] = $options;
          }
          break;
        case 'checkbox':
          $options = $this->_get_field_options($form_fields->data[$f]);
          // Prepare Checkbox options
          if ($form_fields->data[$f]['acl'] == 'readonly' && $form_fields->data[$f]['level'] >= $level) {
            // TODO Readonly - get the selected data based on options array and display
            $hidden_fields[] = $form_fields->data[$f];
            unset($form_fields->data[$f]);
          }
          else {
            $form_fields->data[$f]['options'] = $options;
          }
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
            $form_fields->data[$f]['def_val'] = $dm->$data_label;
          }
          break;
        case 'submit':
          $submit_text = $form_fields->data[$f]['def_val'];
          break;



        // TODO: Review bellow items
        case 'fileuploader':
          $form_element = '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-file"><label for="' . $form_fields->data[$f]['field_id'] . '">' . $form_fields->data[$f]['def_label'] . '</label>';
          $form_element .= $form_fields->data[$f]['prefix'] . '<span id="' . $form_fields->data[$f]['field_id'] . '" class="upload-button ' . $form_fields->data[$f]['css_class'] . '"> <span>' . $form_fields->data[$f]['field_name'] . '</span> </span>' . $form_fields->data[$f]['suffix'] . '</div>';
          $script = '<script  type="text/javascript">file_uploader(\'' . $form_fields->data[$f]['field_id'] . '\', \'' . $form_fields->data[$f]['field_values'] . '\');</script>';
          $form_element .= '<div class="form-item '. $form_fields->data[$f]['vertical'].'"><span id="file-message"></span><ol id="uploaded-files"></ol> <textarea id="files" name="files"></textarea>' . $script . '</div>';
          break;
        case 'reset':
          $form_element .= '<div id="form-item-' . $form_fields->data[$f]['field_id'] . '" class="form-item '. $form_fields->data[$f]['vertical'].' form-reset"> <input type="' . $form_fields->data[$f]['html_type'] . '" id="' . $form_fields->data[$f]['field_id'] . '" name="' . $form_fields->data[$f]['field_name'] . '" class="' . $form_fields->data[$f]['css_class'] . '" value="' . $form_fields->data[$f]['def_val'] . '" ' . $form_fields->data[$f]['html_options'] . ' onClick="' . $form_fields->data[$f]['click'] . '" onFocus="' . $form_fields->data[$f]['focus'] . '" onBlur="' . $form_fields->data[$f]['blur'] . '" />' . $form_fields->data[$f]['suffix'] . '</div>';
          break;
      }

      // Fieldset
      if (!empty($form_fields->data[$f]['fieldset_name'])) {
        $fieldsets[$form_fields->data[$f]['fieldset_name']]['fields'][] = $form_fields->data[$f];
      }

    }

    // Get Fieldset information
    $fieldset_clause = array();
    if (!empty($fieldsets)) {
      foreach ($fieldsets as $key => $fieldset) {
        $fieldset_clause[] = "'" . $key . "'";
      }
    }

    $fs = new DataManager();
    $fs->dm_load_list("" . NATURAL_DBNAME . "." . FIELDSET_TABLE . "", "ASSOC", "name IN (" . implode(', ', $fieldset_clause) .  ") ORDER BY position");
    for ($z = 0; $z < $fs->affected; $z++) {
      $fieldsets[$fs->data[$z]['name']]['id'] = $fs->data[$z]['id'];
      $fieldsets[$fs->data[$z]['name']]['name'] = $fs->data[$z]['name'];
      $fieldsets[$fs->data[$z]['name']]['label'] = $fs->data[$z]['label'];
      $fieldsets[$fs->data[$z]['name']]['css_class'] = $fs->data[$z]['css_class'];
    }

    // Adding the hidden fields
    if (!empty($form_fields->data)) {
      $fieldsets['blank']['fields'] = $form_fields->data + $hidden_fields;
    }

    // Render Array
    $render = array(
      'page_title' => !empty($form_param->form_title) ? $form_param->form_title : '',
      'form' => $form_param,
      'fieldsets' => $fieldsets, // This includes non fieldsets fields into the blank array
      'submit_text' => !empty($submit_text) ? $submit_text : 'Save',
      'modal' => $modal,
    );
//die(print_r($render));
    $template = $twig->loadTemplate('form.html');
    $template->display($render);
  }

}

?>