<?php
/**
* NATURAL - Copyright Open Source Mind, LLC
* Last Modified: Date: 05-06-2014 17:23:02 -0500  $ @ Revision: $Rev: 11 $
* @package Natural Framework
*/

/**
* Database form management
*/

class DbForm {

  function _getSessionVar($data) {
    $data = " " . $data;
    $ini = strpos($data, "s{");
    if ($ini == 0)
      return "";
    $ini += strlen("s{");
    $len = strpos($data, "}", $ini) - $ini;
    return substr($data, $ini, $len);
  }

  function _getVar($data) {
    $data = " " . $data;
    $ini = strpos($data, "v{");
    if ($ini == 0)
      return "";
    $ini += strlen("v{");
    $len = strpos($data, "}", $ini) - $ini;
    return substr($data, $ini, $len);
  }

  function _getFieldOptions($field) {
    $options = array();
    if ($field['data_table'] != '') {
      $query_field_name = '';
      while (strpos($field['data_query'], "s{") > 0) {
        $query_field_name = $this->_getSessionVar($field['data_query']);
        $field['data_query'] = str_replace("s{{$query_field_name}}", "{$_SESSION[$query_field_name]}", $field['data_query']);
      }
      $dm = new DataManager;
      $query_select = ($field['data_value'] == $field['data_label']) ? $field['data_value'] : "{$field['data_value']},{$field['data_label']}";
      $query = "SELECT {$query_select} FROM {$field['data_table']} WHERE {$field['data_query']} ORDER BY {$field['data_sort']}";
      $dm->dmLoadCustomList($query, 'ASSOC');

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

    $form_param->dmLoadSingle(NATURAL_DBNAME . "." . FORM_TABLE, "form_id='" . $form_name . "' LIMIT 1");
    if (!$form_param->affected) {
      $error_message = 'Parameters for the form ' . $form_name . ' not found!';
    }

    $form_fields->dmLoadList(NATURAL_DBNAME . "." . FIELD_TABLE, "ASSOC", "form_template_id='" . $form_param->id . "' ORDER BY form_field_order ASC");
    if (!$form_fields->affected) {
      $error_message = 'Form ' . $form_name . ' not found!';
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
        if ($form_fields->data[$f]['acl'] == 'readonly') {
          $form_fields->data[$f]['css_class'] .= 'form-readonly';
        }
        else {
          $form_fields->data[$f]['html_type'] = 'hidden';
          $form_fields->data[$f]['def_val'] = is_array($form_fields->data[$f]['def_val']) ? implode(', ', $form_fields->data[$f]['def_val']) : $form_fields->data[$f]['def_val'];
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
        case 'checkbox':
        case 'radio':
        case 'list':
          $options = $this->_getFieldOptions($form_fields->data[$f]);
          $form_fields->data[$f]['options'] = $options;
          break;
        case 'readonly':
          if ($form_fields->data[$f]['data_table'] != '') {
            $dm = new DataManager;
            $query = "SELECT {$form_fields->data[$f]['data_label']} FROM {$form_fields->data[$f]['data_table']} WHERE {$form_fields->data[$f]['data_value']} = '{$form_fields->data[$f]['def_val']}' AND {$form_fields->data[$f]['data_query']}  ORDER BY {$form_fields->data[$f]['data_sort']} LIMIT 1";
            $dm->dmCustomQuery($query, true);
            $data_label = $form_fields->data[$f]['data_label'];
            if (!$dm->$data_label) {
              $dm->$data_label = '-';
            }
            $form_fields->data[$f]['def_val'] = $dm->$data_label;
          }
          break;
        case 'uploader':
          $form_fields->data[$f]['file_items'] = '';
          if (!empty($form_fields->data[$f]['def_val']) && is_array($form_fields->data[$f]['def_val'])) {
            $files = new DataManager;
            $files->dmLoadCustomList('SELECT * FROM files WHERE id IN (' . implode(',', $form_fields->data[$f]['def_val']) . ') ORDER BY id', 'ASSOC');
            if ($files->affected > 0) {
              foreach ($files->data as $file) {
                $render = array(
                  'filename'=> $file['filename'],
                  'preview' => (strpos($form_fields->data[$f]['field_values'], 'preview=true') !== false) ? TRUE : FALSE,
                  'preview_uri' => $file['uri'],
                  'id' => $file['id'],
                  'field_id' => $form_fields->data[$f]['id'],
                  'field_name'=> $form_fields->data[$f]['field_name'],
                );
                // File item
                $form_fields->data[$f]['file_items'] .= $twig->render('uploader-file-item.html', $render);
              }
              // Field  attributes
              $field_limit = 0;
              if (!empty($form_fields->data[$f]['field_values'])) {
                $field_values = explode('|', $form_fields->data[$f]['field_values']);
                foreach ($field_values as $value) {
                  $option = explode('=', $value);
                  switch ($option[0]) {
                    case 'limit':
                      $field_limit = $option[1];
                      break;
                  }
                }
              }
              if ($field_limit >= $files->affected) {
                $form_fields->data[$f]['css_class'] .= 'hide';
              }
            }
          }
          break;
        case 'submit':
          $submit_text = $form_fields->data[$f]['def_val'];
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
    $fs->dmLoadList("" . NATURAL_DBNAME . "." . FIELDSET_TABLE . "", "ASSOC", "name IN (" . implode(', ', $fieldset_clause) .  ") ORDER BY position");
    for ($z = 0; $z < $fs->affected; $z++) {
      $fieldsets[$fs->data[$z]['name']]['id'] = $fs->data[$z]['id'];
      $fieldsets[$fs->data[$z]['name']]['name'] = $fs->data[$z]['name'];
      $fieldsets[$fs->data[$z]['name']]['label'] = $fs->data[$z]['label'];
      $fieldsets[$fs->data[$z]['name']]['css_class'] = $fs->data[$z]['css_class'];
    }

    // Adding the hidden fields
    /*if (!empty($form_fields->data)) {
      $fieldsets['blank']['fields'] = $form_fields->data + $hidden_fields;
    }*/

    if ($fs->affected>0) {
      $fieldsets['blank']['fields'] = $hidden_fields;
    }else{
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

    $template = $twig->loadTemplate('form.html');
    $template->display($render);
  }
}

?>