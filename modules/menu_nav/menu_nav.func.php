<?php

/**
 * @file
 * Menu functionalities.
 */

 /**
  * Menu Constructor.
  */
function menu_constructor($level, $dash_show = 0) {
  $main_menu = new DataManager();
  $main_menu->dm_load_list(NATURAL_DBNAME . '.' . MAIN_MENU_TABLE, 'ASSOC', 'status = 1 AND dash_admin="' . $dash_show . '" ORDER BY position');
  $menu = '';
  if ($main_menu->affected) {
    $menu = '<ul class="sidebar-menu">';
    // Main Menu.
    foreach ($main_menu->data as $main_key => $main_item) {
      // Test Permissions.
      if (menu_permission($main_item, $level)) {
        // Sub Menu.
        $menusub = '';
        $treeview = '';
        $treeview_arrow = '';
        $sub_menu = new DataManager();
        $sub_menu->dm_load_list(NATURAL_DBNAME . '.' . SUB_MENU_TABLE, 'ASSOC', 'main_menu_id = ' . $main_item['id'] . ' AND status = 1 ORDER BY position');
        if ($sub_menu->affected) {
          foreach ($sub_menu->data as $sub_item) {
            if (menu_permission($sub_item, $level)) {
              $menuside = '';
              $treeview = '';
              $treeview_arrow = '';
              $side_menu = new DataManager();
              $side_menu->dm_load_list(NATURAL_DBNAME . '.' . SIDE_MENU_TABLE, 'ASSOC', 'sub_menu_id = ' . $sub_item['id'] . ' AND status = 1 ORDER BY position');
              if ($side_menu->affected) {
                // Default href for Natural.
                $href = "javascript:menu_navigation('" . $main_item['element_name'] . "', '" . $main_item['func'] . "', '" . $main_item['module'] . "')";
                foreach ($side_menu->data as $side_item) {
                  if (menu_permission($side_item, $level)) {
                    $menuside .= '<li id="' . $side_item['element_name'] . '"> <a href="' . $href . '" > <i class="fa fa-angle-double-right"></i> ' . translate($side_item['label'], $_SESSION['log_preferred_language']) . '</a> </li>';
                  }
                }
                if ($menuside) {
                  $treeview = 'treeview';
                  $menuside = '<ul class="treeview-menu">' . $menuside . '</ul>';
                  $href = '#';
                }
                else {
                  $href = "javascript:menu_navigation('" . $main_item['element_name'] . "', '" . $main_item['func'] . "', '" . $main_item['module'] . "')";
                }
              }
              $menusub .= '<li class="' . $treeview . '" id="' . $sub_item['element_name'] . '"><a href="' . $href . '" > <i class="fa fa-angle-double-right"></i> ' . translate($sub_item['label'], $_SESSION['log_preferred_language']) . '</a>' . $menuside . '</li>';
            }
          }
          if ($menusub) {
            $treeview = 'treeview';
            $treeview_arrow = '<i class="fa fa-angle-left pull-right"></i>';
            $menusub = '<ul class="treeview-menu">' . $menusub . '</ul>';
            $href = '#';
          }
          else {
            $href = "javascript:menu_navigation('" . $main_item['element_name'] . "', '" . $main_item['func'] . "', '" . $main_item['module'] . "')";
          }
        }
        if ($main_item['initial']) {
          $active = 'active';
        }
        else {
          $active = '';
        }
        // Test if is first and last.
        if ($main_key == 0) {
          $main_item_class = 'first-item';
        }
        elseif ($main_key == ($main_menu->affected - 1)) {
          $main_item_class = 'last-item';
        }
        else {
          $main_item_class = '';
        }
        // Main menu item.
        $menu .= '<li id="' . $main_item['element_name'] . '" class="' . $active . ' ' . $treeview . ' ' . $main_item_class . '"> <a href="' . $href . '" > <i class="fa fa-dashboard"></i> ' . translate($main_item['label'], $_SESSION['log_preferred_language']) . $treeview_arrow . '</a>' . $menusub . '</li>';
      }
    }
    $menu .= '</ul>';
  }
  else {
    $menu = 'Menu is not setup, please contact the administrator.';
  }
  return $menu;
}

/**
 * Menu Permissions function test if the user is able to visualize the menu item.
 */
function menu_permission($menu_item, $level) {
  $build = TRUE;
  switch ($menu_item['allow']) {
    case 'all':
      $class = '';
      $build = TRUE;
      break;

    case 'between':
      $range = explode('and', $menu_item['allow_value']);
      if ($range[0] < $level && $level < $range[1]) {
        $build = TRUE;
      }
      else {
        $build = FALSE;
      }
      break;

    case 'equal':
      if ($menu_item['allow_value'] == $level) {
        $build = TRUE;
      }
      else {
        $build = FALSE;
      }
      break;

    case 'higher':
      if ($menu_item['allow_value'] < $level) {
        $build = TRUE;
      }
      else {
        $build = FALSE;
      }
      break;

    case 'lower':
      if ($menu_item['allow_value'] > $level) {
        $build = TRUE;
      }
      else {
        $build = FALSE;
      }
      break;

  }
  return $build;
}

/**
 * Login main menu.
 */
function build_login_mainmenu($level) {
    $menus = new DataManager();
    $menus->dm_load_list(NATURAL_DBNAME . "." . MAIN_MENU_TABLE, "ASSOC", "id!='' ORDER BY position");

    $menu_options = "";
    if ($menus->affected) {
        $menu = "\t\t\t" . '<ul class="main-menu">' . "\n";
        $menu_options = "";
        for ($i = 0; $i < $menus->affected; $i++) {
            $class = "";
            $menid = "";
            $each = "";
            $build = false;

            $menid = $menus->data[$i]['id'];
            $each = new DataManager();
            $each->dm_load_single(NATURAL_DBNAME . "." . MAIN_MENU_TABLE, "id='{$menid}'");

            switch ($each->allow) {
                case "all":
                    $class = "";
                    $build = true;
                    break;
                case "between":
                    $range = explode("and", $each->allow_value);
                    if ($range[0] < $level && $level < $range[1]) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
                case "equal":
                    if ($each->allow_value == $level) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
                case "higher":
                    if ($each->allow_value < $level) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
                case "lower":
                    if ($each->allow_value > $level) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
            }
            if ($each->initial) {
                $class = "active";
                $build = true;
            }
            if ($build && $each->status == 1) {
                $menu_options .= "<li class='{$class}' name='{$each->element_name}' id='{$each->element_name}'><a HREF=\"javascript:menu_navigation('{$each->element_name}', '1', '{$each->func}', '{$level}', '{$each->module}');\" title=\"{$each->title}\">{$each->label}</a></li>";
            } else {
                $menu_options .= "\n";
            }
        }
    }
    $menu .= "{$menu_options}\t\t\t</ul>\n";
    return $menu;
}

function build_login_submenu($level) {
    $df = new DataManager();
    $df->dm_load_single(NATURAL_DBNAME . "." . MAIN_MENU_TABLE, "initial='1'");

    $menus = new DataManager();
    $menus->dm_load_list(NATURAL_DBNAME . "." . SUB_MENU_TABLE, "ASSOC", "main_menu_id='{$df->id}'");

    $menu_options = "";
    if ($menus->affected) {
        $menu = "\t\t\t" . '<ul class="sub-menu">' . "\n";
        for ($i = 0; $i < $menus->affected; $i++) {
            $class = "";
            $build = false;

            $each = "";
            $each = new DataManager();
            $each->dm_load_single(NATURAL_DBNAME . "." . SUB_MENU_TABLE, "position='{$i}' AND main_menu_id='{$df->id}'");

            switch ($each->allow) {
                case "all":
                    $class = "";
                    $build = true;
                    break;
                case "between":
                    $range = explode("and", $each->allow_value);
                    if ($range[0] < $level && $level < $range[1]) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
                case "equal":
                    if ($each->allow_value == $level) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
                case "higher":
                    if ($each->allow_value < $level) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
                case "lower":
                    if ($each->allow_value > $level) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
            }
            if ($each->initial) {
                $class = "active";
                $build = true;
                $content = execute_initial_function($each->func, $level);
            }

            if ($build && $each->status == 1) {
                $menu_options .= "<li class='{$class}' name='{$each->element_name}' id='{$each->element_name}'>
          <a HREF=\"javascript:menu_navigation('{$each->element_name}', '2', '{$each->func}', '{$level}', '{$each->module}');\" title=\"{$each->title}\" >{$each->label}</a>
          </li>";
            } else {
                $menu_options .= "\n";
            }
        }
    }
    $menu .= "{$menu_options}\t\t\t</ul>\n";
    return $menu;
}

function build_login_sidemenu($level) {
    $df = new DataManager();
    $df->dm_load_single(NATURAL_DBNAME . "." . SUB_MENU_TABLE, "initial='1'");

    $menus = new DataManager();
    $menus->dm_load_list(NATURAL_DBNAME . "." . SIDE_MENU_TABLE, "ASSOC", "sub_menu_id='{$df->id}'");

    $menu_options = "";
    if ($menus->affected) {
        $menu = "\t\t\t" . '<ul class="side-menu">' . "\n";
        for ($i = 0; $i < $menus->affected; $i++) {
            $class = "";
            $build = false;

            $each = "";
            $each = new DataManager();
            $each->dm_load_single(NATURAL_DBNAME . "." . SIDE_MENU_TABLE, "position='{$i}' AND sub_menu_id='{$df->id}'");

            switch ($each->allow) {
                case "all":
                    $class = "";
                    $build = true;
                    break;
                case "between":
                    $range = explode("and", $each->allow_value);
                    if ($range[0] < $level && $level < $range[1]) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
                case "equal":
                    if ($each->allow_value == $level) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
                case "higher":
                    if ($each->allow_value < $level) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
                case "lower":
                    if ($each->allow_value > $level) {
                        $build = true;
                    } else {
                        $build = false;
                    }
                    break;
            }
            if ($each->initial) {
                $class = "active";
                $build = true;
            }

            if ($build && $each->status == 1) {
                $menu_options .= "<li class='{$class}' name='{$each->element_name}' id='{$each->element_name}'><a HREF=\"javascript:menu_navigation('{$each->element_name}', '3', '{$each->func}', '{$level}', '{$each->module}');\" title=\"{$each->title}\">{$each->label}</a></li>";
            } else {
                $menu_options .= "\n";
            }
        }
        $menu .= "{$menu_options}\t\t\t</ul>\n";
    }
    return $menu;
}

function update_menu($data) {
    $level = $_SESSION['log_access_level'];
    switch ($data['button_level']) {
        case 1:
            $df = new DataManager();
            $df->dm_load_single(NATURAL_DBNAME . "." . MAIN_MENU_TABLE, "element_name='{$data['clicked']}'");

            $main = new DataManager();
            $main->dm_load_list(NATURAL_DBNAME . "." . MAIN_MENU_TABLE, "ASSOC", "id!='' ORDER BY position");
            $main_options = "";
            if ($main->affected) {
                $menu = "\t\t\t" . '<ul class="main-menu">' . "\n";
                for ($i = 0; $i < $main->affected; $i++) {
                    $class = "";
                    $menid = "";
                    $each = "";
                    $build = false;

                    $menid = $main->data[$i]['id'];
                    $each = new DataManager();
                    $each->dm_load_single(NATURAL_DBNAME . "." . MAIN_MENU_TABLE, "id='{$menid}'");

                    switch ($each->allow) {
                        case "all":
                            $class = "";
                            $build = true;
                            break;
                        case "between":
                            $range = explode("and", $each->allow_value);
                            if ($range[0] < $level && $level < $range[1]) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "equal":
                            if ($each->allow_value == $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "higher":
                            if ($each->allow_value < $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "lower":
                            if ($each->allow_value > $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                    }
                    if ($each->element_name == $data['clicked']) {
                        $class = "active";
                        $build = true;
                        $main_selected_id = $each->id;
                    }
                    if ($build && $each->status == 1) {
                        $main_options .= "<li class='{$class}' name='{$each->element_name}' id='{$each->element_name}'><a HREF=\"javascript:menu_navigation('{$each->element_name}', '1', '{$each->func}', '{$level}', '{$each->module}');\" title=\"{$each->title}\">{$each->label}</a></li>";
                    } else {
                        $main_options .= "\n";
                    }
                }
            }

            $sub = new DataManager();
            $sub->dm_load_list(NATURAL_DBNAME . "." . SUB_MENU_TABLE, "ASSOC", "main_menu_id='{$main_selected_id}'");

            $sub_options = "";
            if ($sub->affected) {
                $menu = "\t\t\t" . '<ul class="sub-menu">' . "\n";
                for ($i = 0; $i < $sub->affected; $i++) {
                    $class = "";
                    $build = false;

                    $each = "";
                    $each = new DataManager();
                    $each->dm_load_single(NATURAL_DBNAME . "." . SUB_MENU_TABLE, "position='{$i}' AND main_menu_id='{$main_selected_id}'");

                    switch ($each->allow) {
                        case "all":
                            $class = "";
                            $build = true;
                            break;
                        case "between":
                            $range = explode("and", $each->allow_value);
                            if ($range[0] < $level && $level < $range[1]) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "equal":
                            if ($each->allow_value == $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "higher":
                            if ($each->allow_value < $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "lower":
                            if ($each->allow_value > $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                    }
                    if ($each->position == 0) {
                        $class = "active";
                        $build = true;
                        $sub_selected_id = $each->id;
                    }

                    if ($build && $each->status == 1) {
                        $sub_options .= "<li class='{$class}' name='{$each->element_name}' id='{$each->element_name}'><a HREF=\"javascript:menu_navigation('{$each->element_name}', '2', '{$each->func}', '{$level}', '{$each->module}');\" title=\"{$each->title}\">{$each->label}</a></li>";
                    } else {
                        $sub_options .= "\n";
                    }
                }
            }

            $side = new DataManager();
            $side->dm_load_list(NATURAL_DBNAME . "." . SIDE_MENU_TABLE, "ASSOC", "sub_menu_id='{$sub_selected_id}'");

            $side_options = "";
            if ($side->affected) {
                $menu = "\t\t\t" . '<ul class="side-menu">' . "\n";
                for ($i = 0; $i < $side->affected; $i++) {
                    $class = "";
                    $build = false;

                    $each = "";
                    $each = new DataManager();
                    $each->dm_load_single(NATURAL_DBNAME . "." . SIDE_MENU_TABLE, "position='{$i}' AND sub_menu_id='{$sub_selected_id}'");

                    switch ($each->allow) {
                        case "all":
                            $class = "";
                            $build = true;
                            break;
                        case "between":
                            $range = explode("and", $each->allow_value);
                            if ($range[0] < $level && $level < $range[1]) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "equal":
                            if ($each->allow_value == $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "higher":
                            if ($each->allow_value < $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "lower":
                            if ($each->allow_value > $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                    }
                    if ($each->position == 0) {
                        $class = "active";
                        $build = true;
                    }

                    if ($build && $each->status == 1) {
                        $side_options .= "<li class='{$class}' name='{$each->element_name}' id='{$each->element_name}'><a HREF=\"javascript:menu_navigation('{$each->element_name}', '3', '{$each->func}', '{$level}', '{$each->module}');\" title=\"{$each->title}\">{$each->label}</a></li>";
                    } else {
                        $side_options .= "\n";
                    }
                }
            }
            $menu = '<ul class="main-menu">' . $main_options . '</ul>|<ul class="sub-menu">' . $sub_options . '</ul>|<ul class="side-menu">' . $side_options . '</ul>';

            break;
        case 2:

            $df = new DataManager();
            $df->dm_load_single(NATURAL_DBNAME . "." . SUB_MENU_TABLE, "element_name='{$data['clicked']}'");

            $sub = new DataManager();
            $sub->dm_load_list(NATURAL_DBNAME . "." . SUB_MENU_TABLE, "ASSOC", "main_menu_id='{$df->main_menu_id}'");

            $sub_options = "";
            if ($sub->affected) {
                $menu = "\t\t\t" . '<ul class="sub-menu">' . "\n";
                for ($i = 0; $i < $sub->affected; $i++) {
                    $class = "";
                    $build = false;

                    $each = "";
                    $each = new DataManager();
                    $each->dm_load_single(NATURAL_DBNAME . "." . SUB_MENU_TABLE, "position='{$i}' AND main_menu_id='{$df->main_menu_id}'");

                    switch ($each->allow) {
                        case "all":
                            $class = "";
                            $build = true;
                            break;
                        case "between":
                            $range = explode("and", $each->allow_value);
                            if ($range[0] < $level && $level < $range[1]) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "equal":
                            if ($each->allow_value == $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "higher":
                            if ($each->allow_value < $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "lower":
                            if ($each->allow_value > $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                    }
                    if ($each->element_name == $data['clicked']) {
                        $class = "active";
                        $build = true;
                        $sub_selected_id = $each->id;
                    }

                    if ($build && $each->status == 1) {
                        $sub_options .= "<li class='{$class}' name='{$each->element_name}' id='{$each->element_name}'><a HREF=\"javascript:menu_navigation('{$each->element_name}', '2', '{$each->func}', '{$level}', '{$each->module}');\" title=\"{$each->title}\">{$each->label}</a></li>";
                    } else {
                        $sub_options .= "\n";
                    }
                }
            }


            $side = new DataManager();
            $side->dm_load_list(NATURAL_DBNAME . "." . SIDE_MENU_TABLE, "ASSOC", "sub_menu_id='{$sub_selected_id}'");

            $side_options = "";
            if ($side->affected) {
                $menu = "\t\t\t" . '<ul class="side-menu">' . "\n";
                for ($i = 0; $i < $side->affected; $i++) {
                    $class = "";
                    $build = false;

                    $each = "";
                    $each = new DataManager();
                    $each->dm_load_single(NATURAL_DBNAME . "." . SIDE_MENU_TABLE, "position='{$i}' AND sub_menu_id='{$sub_selected_id}'");

                    switch ($each->allow) {
                        case "all":
                            $class = "";
                            $build = true;
                            break;
                        case "between":
                            $range = explode("and", $each->allow_value);
                            if ($range[0] < $level && $level < $range[1]) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "equal":
                            if ($each->allow_value == $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "higher":
                            if ($each->allow_value < $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "lower":
                            if ($each->allow_value > $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                    }
                    if ($each->position == 0) {
                        $class = "active";
                        $build = true;
                    }

                    if ($build && $each->status == 1) {
                        $side_options .= "<li class='{$class}' name='{$each->element_name}' id='{$each->element_name}'><a HREF=\"javascript:menu_navigation('{$each->element_name}', '3', '{$each->func}', '{$level}', '{$each->module}');\" title=\"{$each->title}\">{$each->label}</a></li>";
                    } else {
                        $side_options .= "\n";
                    }
                }
            }
            $menu = '<ul class="sub-menu">' . $sub_options . '</ul>|<ul class="side-menu">' . $side_options . '</ul>';

            break;
        case 3:

            $df = new DataManager();
            $df->dm_load_single(NATURAL_DBNAME . "." . SIDE_MENU_TABLE, "element_name='{$data['clicked']}'");

            $menus = new DataManager();
            $menus->dm_load_list(NATURAL_DBNAME . "." . SIDE_MENU_TABLE, "ASSOC", "sub_menu_id='{$df->sub_menu_id}'");

            $menu_options = "";
            if ($menus->affected) {
                $menu = "\t\t\t" . '<ul class="side-menu">' . "\n";
                for ($i = 0; $i < $menus->affected; $i++) {
                    $class = "";
                    $build = false;

                    $each = "";
                    $each = new DataManager();
                    $each->dm_load_single(NATURAL_DBNAME . "." . SIDE_MENU_TABLE, "position='{$i}' AND sub_menu_id='{$df->sub_menu_id}'");

                    switch ($each->allow) {
                        case "all":
                            $class = "";
                            $build = true;
                            break;
                        case "between":
                            $range = explode("and", $each->allow_value);
                            if ($range[0] < $level && $level < $range[1]) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "equal":
                            if ($each->allow_value == $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "higher":
                            if ($each->allow_value < $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                        case "lower":
                            if ($each->allow_value > $level) {
                                $build = true;
                            } else {
                                $build = false;
                            }
                            break;
                    }
                    if ($each->element_name == $data['clicked']) {
                        $class = "active";
                        $build = true;
                    }

                    if ($build && $each->status == 1) {
                        $menu_options .= "<li class='{$class}' name='{$each->element_name}' id='{$each->element_name}'><a HREF=\"javascript:menu_navigation('{$each->element_name}', '3', '{$each->func}', '{$level}', '{$each->module}');\" title=\"{$each->title}\">{$ft} {$each->label} </font></a></li>";
                    } else {
                        $menu_options .= "\n";
                    }
                }
            }
            $menu .= "{$menu_options}\t\t\t</ul>\n";

            break;
    }
    /* $order  = new OrderTracking();
      $order->load_list("ASSOC","status!='1'");
      $openorders = $order->affected;
      return $menu."<script type='javascript/text'>
      $(\"#order_update\").html('{$openorders}');
      </script>" ; */
    return $menu;
}

/**
 * Main menu list
 */
function list_main_menu() {
    $title = '<h1>List of Main Menu Items</h1>';
    $menu = new MainMenu();
    $menu->load_list("ASSOC", "id!='' ORDER BY position");

    $line[0][0] = "Id";
    $line[0][1] = "Position";
    $line[0][2] = "Name";
    $line[0][3] = "Enabled";
    $line[0][4] = "Access Condition";
    $line[0][5] = "Access Level";
    /* $line[0][6] = "Menu Level"; */
    $line[0][6] = "Edit";
    $line[0][7] = "Delete";

    if ($menu->affected) {
        $total = 0;
        for ($i = 0; $i < $menu->affected; $i++) {
            $status = "";
            if ($menu->data[$i]['status'] == 1) {
                $status = "<input type='checkbox' name='status_{$i}' id='status_{$i}' checked>";
            } else {
                $status = "<input type='checkbox' name='status_{$i}' id='status_{$i}'>";
            }
            if ($menu->data[$i]['id'] == 4) {
                $status = "<input type='checkbox' checked readonly disabled><input type='hidden' name='status_{$i}' id='status_{$i}' value='on'>";
            }
            $j = $i + 1;
            $line[$j][0] = $menu->data[$i]['id'];
            $line[$j][1] = "<input type='text' name='position_{$i}' id='position_{$i}' value='{$menu->data[$i]['position']}' size='3' maxlength='2'>";
            $line[$j][2] = $menu->data[$i]['label'];
            $line[$j][3] = $status;
            $line[$j][4] = $menu->data[$i]['allow'];
            $line[$j][5] = $menu->data[$i]['allow_value'];
            /* $line[$j][6] = $menu->data[$i]['menu_level']; */
            if ($_SESSION['log_access_level'] > 80) {
                $line[$j][6] = '<a title="Edit" class="edit-icon pointer"  onclick="proccess_information(\'listmainmenu\', \'edit_main_menu\', \'menu_nav\', null, \'menuid|' . $menu->data[$i]['id'] . '\');">Edit</a>';
                $line[$j][7] = '<a title="Delete" class="delete-icon pointer" onclick="proccess_information(\'listmainmenu\', \'delete_main_menu\', \'menu_nav\', \'Are you sure you want to delete this menu? By doing this the system will delete its submenus as well!\', \'delete_menu_id|' . $menu->data[$i]['id'] . '\', null, this, \'remove_row\');">Delete</a>
                        <input type="hidden" id="id_' . $i . '" value="' . $menu->data[$i]['id'] . '" name="id_' . $i . '">';
            } else {
                $line[$j][6] = '<a title="Edit (disabled)" class="edit-icon disabled-icon">Edit</a>';
                $line[$j][7] = '<a title="Delete (disabled)" class="delete-icon disabled-icon">Delete</a>';
            }
            $total++;
        }
        $view = new ListView();
        $listview = $view->build(NULL, $line);

        $main_list = $title . '
     <form id="listmainmenu" name="listmainmenu" action="javascript:proccess_information(\'listmainmenu\', \'update_main_menu\', \'menu_nav\', \'Are you sure you want to update the menu?\');">
			' . $listview . '
      <div class="form-item-bottom-table">
        <input type="submit" value="Update" class="button"> <input type="button" value="Add New" class="button" onclick="proccess_information(\'listmainmenu\', \'add_new_mainmenu\', \'menu_nav\', null);"> <input type="hidden" value="' . $total . '" name="total" id="total">
      </div>
     </form>';
    } else {
        $main_list = $title . 'ERROR|' . MAINMENU_NOTFOUND_CODE . '|' . MAINMENU_NOTFOUND_MESG;
    }
    return $main_list;
}

function update_main_menu($data) {
    for ($i = 0; $i < $data['total']; $i++) {
        $id = "";
        $main = "";
        if ($data['position_' . $i] >= $data['total']) {
            return "ERROR|" . HIGHER_MENU_POSITION_CODE . "|" . HIGHER_MENU_POSITION_MESG;
            exit(0);
        }
        $id = $data['id_' . $i];
        $main = new MainMenu();
        $main->load_single("id='{$id}'");
        $main->status = ($data['status_' . $i]) ? 1 : 0;
        $main->position = $data['position_' . $i];
        $main->update("id='{$id}'");
    }
    return "<form action='" . NATURAL_WEB_ROOT . "dashboard.php'>
    " . POSITION_MENU_UPDATED_MESG . " <input type='submit' value='Reload'  class='button'><br>{$save_status}
    </form>
    ";
}

function save_main_menu_config($data) {
    $main = new MainMenu();

    $main->load_single("id='{$data['id']}'");

    $main = new MainMenu();
    $main->position = $data['position'];
    $main->element_name = $data['element_name'];
    $main->label = $data['label'];
    $main->title = $data['title'];
    $main->func = $data['func'];
    $main->module = $data['module'];
    $main->allow = $data['allow'];
    $main->allow_value = $data['allow_value'];
    $main->status = $data['status'];
    $main->initial = $data['initial'];
    /* $main->menu_level   = $data['menu_level']; */

    $main->update("id='{$data['id']}'");

    return "<form action='" . NATURAL_WEB_ROOT . "dashboard.php'>
    " . POSITION_MENU_UPDATED_MESG . " <input type='submit' value='Reload'  class='button'><br>{$save_status}
    </form>" . list_main_menu();
    ;
}

function save_main_menu($data) {
    $main = new MainMenu();

    $main->load_list("ASSOC", "id!='' ORDER BY position DESC LIMIT 1");
    $new_position = $main->data[0]['position'];

    $main = new MainMenu();
    $main->position = $new_position + 1;
    $main->element_name = $data['element_name'];
    $main->label = $data['label'];
    $main->title = $data['title'];
    $main->func = $data['func'];
    $main->module = $data['module'];
    $main->allow = $data['allow'];
    $main->allow_value = $data['allow_value'];
    $main->status = $data['status'];
    $main->initial = $data['initial'];
    /*  $main->menu_level   = $data['menu_level']; */

    $main->insert();

    return "<form action='" . NATURAL_WEB_ROOT . "dashboard.php'>
    " . POSITION_MENU_UPDATED_MESG . " <input type='submit' value='Reload'  class='button'><br>{$save_status}
    </form>" . list_main_menu();
    ;
}

function organize_menu_position($element, $deleted_upstream_id = "") {
    switch ($element) {
        case "main":
            $mn = new MainMenu();
            $mn->load_list("ASSOC", "id!='' ORDER BY position");

            if ($mn->affected) {
                for ($x = 0; $x < $mn->affected; $x++) {
                    $main = "";
                    $result = "";
                    $position = "";
                    $id = "";

                    $id = $mn->data[$x]['id'];
                    $position = $x;

                    //$main     = new MainMenu();
                    //$main->load_single("id='{$id}'");
                    //$main->update("id='{$mn->data[$x]['id']}'");
                    $con = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
                    if (!$con) {
                        die('Could not connect: ' . mysql_error());
                    }
                    mysql_select_db(NATURAL_DBNAME, $con);
                    $result = mysql_query("UPDATE " . NATURAL_DBNAME . "." . MAIN_MENU_TABLE . " SET position='{$position}' WHERE id='{$id}'") or die(mysql_error());
                    mysql_close($con);
                }
            }
            break;
        case "sub":

            $mn = new SubMenu();
            $mn->load_list("ASSOC", "main_menu_id='{$deleted_upstream_id}' ORDER BY position");

            if ($mn->affected) {
                for ($x = 0; $x < $mn->affected; $x++) {
                    $main = "";
                    $result = "";
                    $position = "";
                    $id = "";

                    $id = $mn->data[$x]['id'];
                    $position = $x;

                    //$main     = new MainMenu();
                    //$main->load_single("id='{$id}'");
                    //$main->update("id='{$mn->data[$x]['id']}'");
                    $con = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
                    if (!$con) {
                        die('Could not connect: ' . mysql_error());
                    }
                    mysql_select_db(NATURAL_DBNAME, $con);
                    $result = mysql_query("UPDATE " . NATURAL_DBNAME . "." . SUB_MENU_TABLE . " SET position='{$position}' WHERE id='{$id}'") or die(mysql_error());
                    mysql_close($con);
                }
            }

            break;
        case "side":

            $mn = new SideMenu();
            $mn->load_list("ASSOC", "sub_menu_id='{$deleted_upstream_id}' ORDER BY position");

            if ($mn->affected) {
                for ($x = 0; $x < $mn->affected; $x++) {
                    $main = "";
                    $result = "";
                    $position = "";
                    $id = "";

                    $id = $mn->data[$x]['id'];
                    $position = $x;

                    //$main     = new MainMenu();
                    //$main->load_single("id='{$id}'");
                    //$main->update("id='{$mn->data[$x]['id']}'");
                    $con = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
                    if (!$con) {
                        die('Could not connect: ' . mysql_error());
                    }
                    mysql_select_db(NATURAL_DBNAME, $con);
                    $result = mysql_query("UPDATE " . NATURAL_DBNAME . "." . SIDE_MENU_TABLE . " SET position='{$position}' WHERE id='{$id}'") or die(mysql_error());
                    mysql_close($con);
                }
            }
            break;
    }
}

function delete_main_menu($data) {

    $del = new MainMenu();
    $del->remove("id='{$data['delete_menu_id']}'");

    $sub = new SubMenu();
    $side = new SideMenu();
    $sub->load_list("ASSOC", "main_menu_id='{$data['delete_menu_id']}'");
    if ($sub->affected) {
        for ($i = 0; $i < $sub->affected; $i++) {
            $side->remove("sub_menu_id='{$sub->data[$i]['id']}'");
            $sub->remove("id='{$sub->data[$i]['id']}'");
        }
    }

    organize_menu_position("main");
    return MENU_REMOVED_MESG;
}

/////////////////////////////////////////////////////////////
//SUBMENUS FUNCTIONS
function select_upstream_submenu() {
    $main = new Mainmenu();
    /* $main->load_list("ASSOC", "id <> 0 ORDER BY menu_level"); */
    $main->load_list("ASSOC", "id <> 0");
    if ($main->affected) {
        for ($i = 0; $i < $main->affected; $i++) {
            $list .= '<option value="' . $main->data[$i]['id'] . '">' . $main->data[$i]['label'] . '</option>';
        }
        $resp = "<form id='up_submenu' name='up_submenu' action=\"javascript:proccess_information('up_submenu', 'list_submenus', 'menu_nav', '');\" >Select the Submenu UpStream <select id='main_id' name='main_id'>{$list}</select>
             <input class='button' type='submit' value='Go'  class='button'> </form>";
    } else {
        $resp = 'Main menu not found, please contact you system administrator';
    }
    return $resp;
}

function list_submenus($data) {
    $title = "<h1>List of Sub Menu Items</h1>";
    $main = new MainMenu();
    $main->load_single("id='{$data['main_id']}'");
    $upstream_name = $main->label;

    $line[0][0] = "Id";
    $line[0][1] = "Position";
    $line[0][2] = "Name";
    $line[0][3] = "Enabled";
    $line[0][4] = "Access Condition";
    $line[0][5] = "Access Level";
    $line[0][6] = "Edit";
    $line[0][7] = "Delete";


    $menu = new SubMenu();
    $menu->load_list("ASSOC", "main_menu_id='{$data['main_id']}' ORDER BY position DESC");
    if ($menu->affected) {
        $total = 0;
        for ($i = 0; $i < $menu->affected; $i++) {
            $status = "";
            if ($menu->data[$i]['status'] == 1) {
                $status = "<input type='checkbox' name='status_{$i}' id='status_{$i}' checked>";
            } else {
                $status = "<input type='checkbox' name='status_{$i}' id='status_{$i}'>";
            }
            $j = $i + 1;
            $line[$j][0] = $menu->data[$i]['id'];
            $line[$j][1] = "<input type='text' name='position_{$i}' id='position_{$i}' value='{$menu->data[$i]['position']}' size='3' maxlength='2'>";
            $line[$j][2] = $menu->data[$i]['label'];
            $line[$j][3] = $status;
            $line[$j][4] = $menu->data[$i]['allow'];
            $line[$j][5] = $menu->data[$i]['allow_value'];
            if ($_SESSION['log_access_level'] == 81) {
                $line[$j][6] = '<a title="Edit" class="edit-icon pointer" onclick="proccess_information(\'listsubmenu\', \'edit_sub_menu\', \'menu_nav\', null, \'menuid|' . $menu->data[$i]['id'] . '\');">Edit</a>';
                $line[$j][7] = '<a title="Delete" class="delete-icon pointer" onclick="proccess_information(\'listsubmenu\', \'delete_sub_menu\', \'menu_nav\', \'Are you sure you want to delete this menu? By doing this the system will delete its sidemenus as well!\', \'delete_menu_id|' . $menu->data[$i]['id'] . '\', null, this, \'remove_row\');">Delete</a>
                        <input type="hidden"hidden" id="id_' . $i . '" value="' . $menu->data[$i]['id'] . '" name="id_' . $i . '">';
            } else {
                $line[$j][6] = '<a title="Edit (disabled)" class="edit-icon disabled-icon">Edit</a>';
                $line[$j][7] = '<a title="Delete (disabled)" class="delete-icon disabled-icon">Delete</a>';
            }
            $total++;
        }

        $view = new ListView();
        $listview = $view->build(NULL, $line);

        $main_list = $title . '
      <form id="listsubmenu" name="listsubmenu" action="javascript:proccess_information(\'listsubmenu\', \'update_sub_menu\', \'menu_nav\', \'Are you sure you want to update this menu?\');">
      ' . $listview . '
      <div class="form-item-bottom-table">
        <input type="submit" value="Update" class="button">
        <input type="button" value="Add New" class="button" onclick="proccess_information(\'listsubmenu\', \'add_new_submenu\', \'menu_nav\', null, null);">
        <input type="hidden" value="' . $total . '" name="total" id="total">
        <input type="hidden" id="main_menu_id" name="main_menu_id" value="' . $data['main_id'] . '">
      </div>
      </form>
      <script type="javascript/text">
       $("main-error-msg").update("<h1>' . $upstream_name . '</h1>");
      </script>';
    } else {
        $main_list = $title . SUBMENU_NOTFOUND_MESG . '
      <form name="listsubmenu" id="listsubmenu">
        <input type="button" value="Add New Submenu" class="button" onclick="proccess_information(\'listsubmenu\', \'add_new_submenu\', \'menu_nav\', null, \'main_menu_id|' . $data['main_id'] . '\');">
      </form>
      <script type="javascript/text">
       $("main-error-msg").update("<h1>' . $upstream_name . '</h1>");
      </script>';
    }
    return $main_list;
}

function save_new_submenu($data) {
    $sub = new SubMenu();
    $submenu = new SubMenu();
    $sub->load_list("ASSOC", "main_menu_id='{$data['main_menu_id']}' ORDER BY position DESC LIMIT 1");
    if ($sub->affected) {
        $new_position = $sub->data[0]['position'];
        $submenu->position = $new_position + 1;
    } else {
        $submenu->position = 0;
    }
    $submenu->main_menu_id = $data['main_menu_id'];
    $submenu->element_name = $data['element_name'];
    $submenu->label = $data['label'];
    $submenu->title = $data['title'];
    $submenu->func = $data['func'];
    $submenu->module = $data['module'];
    $submenu->allow = $data['allow'];
    $submenu->allow_value = $data['allow_value'];
    $submenu->status = 1;
    $submenu->initial = 0;
    $submenu->insert();

    $var['main_id'] = $data['main_menu_id'];
    return "<form action='" . NATURAL_WEB_ROOT . "dashboard.php'>
    " . POSITION_MENU_UPDATED_MESG . " <input type='submit' value='Reload'  class='button'><br>{$save_status}
    </form>" . list_submenus($var);
}

function update_sub_menu($data) {
    for ($i = 0; $i < $data['total']; $i++) {
        $status = "";
        $id = "";
        $position = "";
        $main = "";
        if (!is_numeric($data['position_' . $i])) {
            return "ERROR|" . POSITION_NOTNUM_CODE . "|" . POSITION_NOTNUM_MESG;
            exit(0);
        }

        if ($data['position_' . $i] >= $data['total']) {
            return "ERROR|" . HIGHER_MENU_POSITION_CODE . "|" . HIGHER_MENU_POSITION_MESG;
            exit(0);
        }

        $id = $data['id_' . $i];
        $status = ($data['status_' . $i]) ? 1 : 0;
        $position = $data['position_' . $i];

        $con = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }

        mysql_select_db(NATURAL_DBNAME, $con);

        $result = mysql_query("UPDATE " . NATURAL_DBNAME . "." . SUB_MENU_TABLE . " SET status = '{$status}', position='{$position}' WHERE id='{$id}'") or die(mysql_error());

        mysql_close($con);
    }
    return "<form action='" . NATURAL_WEB_ROOT . "dashboard.php'>
    " . POSITION_MENU_UPDATED_MESG . " <input type='submit' value='Reload'  class='button'><br>
    </form>
    ";
}

function save_sub_menu_config($data) {
    /* Array
      (
      [fn] => save_sub_menu_config
      [id] => 7
      [element_name] => vdfghdfg
      [label] => zcxxcvzcxvz
      [title] =>
      [function] =>
      [module] =>
      [allow] => all
      [allow_value] =>
      [submit] => Save
      [main_menu_id] => 1
      [position] => 3
      [status] => 1
      [initial] => 0
      ) */

    $id = $data['id'];
    $element_name = $data['element_name'];
    $label = $data['label'];
    $title = $data['title'];
    $func = $data['func'];
    $module = $data['module'];
    $allow = $data['allow'];
    $allow_value = $data['allow_value'];
    $main_menu_id = $data['main_menu_id'];

    $con = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }

    mysql_select_db(NATURAL_DBNAME, $con);

    $result = mysql_query("UPDATE " . NATURAL_DBNAME . "." . SUB_MENU_TABLE . " SET main_menu_id='{$main_menu_id}', element_name='" . $element_name . "', label='" . $label . "', title='" . $title . "', func='" . $func . "', module='" . $module . "', allow='" . $allow . "', allow_value='" . $allow_value . "' WHERE id='" . $id . "'") or die(mysql_error());

    mysql_close($con);

    $var['main_id'] = $data['main_menu_id'];
    return "<form action='" . NATURAL_WEB_ROOT . "dashboard.php'>
    " . POSITION_MENU_UPDATED_MESG . " <input type='submit' value='Reload'  class='button'><br>{$save_status}
    </form>" . list_submenus($var);
}

function delete_sub_menu($data) {
    $del = new SubMenu();
    $del->load_single("id='{$data['delete_menu_id']}'");
    $main_menu_id = $del->main_menu_id;
    $del->remove("id='{$data['delete_menu_id']}'");

    $side = new SideMenu();
    $side->load_single("sub_menu_id='{$data['delete_menu_id']}'");
    if ($side->affected) {
        $side->remove("sub_menu_id='{$data['delete_menu_id']}'");
    }

    organize_menu_position("sub", $main_menu_id);
    return MENU_REMOVED_MESG;
}

/////////////////////////////////////////////////////////////
//SIDEMENUS FUNCTIONS
function select_upstream_sidemenu() {
    $main = new MainMenu();
    $sub = new SubMenu();
    /* $main->load_list('ASSOC', 'id <> 0 ORDER BY menu_level'); */
    $main->load_list('ASSOC', 'id <> 0');
    if ($main->affected) {
        for ($i = 0; $i < $main->affected; $i++) {
            $sub->load_list("ASSOC", "main_menu_id='{$main->data[$i]['id']}'");
            for ($x = 0; $x < $sub->affected; $x++) {
                $list .= '<option value="' . $sub->data[$x]['id'] . '">' . $main->data[$i]['label'] . ' -> ' . $sub->data[$x]['label'] . '</option>';
            }
        }
        $resp = "<form id='up_sidemenu' name='up_sidemenu' action=\"javascript:proccess_information('up_sidemenu', 'list_sidemenus', 'menu_nav', '');\" >Select the Submenu UpStream <select id='sub_id' name='sub_id'>{$list}</select>
            <input type='submit' value='Go' class='button'> </form>";
    } else {
        $resp = "Main menu not found, please contact you system administrator";
    }
    return $resp;
}

function list_sidemenus($data) {
    $title = '<h1>List of Side Menu Items</h1>';
    $sub = new SubMenu();
    $sub->load_single("id='{$data['sub_id']}'");
    $upstream_name = $sub->label;

    $line[0][0] = "Id";
    $line[0][1] = "Position";
    $line[0][2] = "Name";
    $line[0][3] = "Enabled";
    $line[0][4] = "Access Condition";
    $line[0][5] = "Access Level";
    $line[0][6] = "Edit";
    $line[0][7] = "Delete";

    $side = new SideMenu();
    $side->load_list("ASSOC", "sub_menu_id='{$data['sub_id']}' ORDER BY position");
    if ($side->affected) {
        $total = 0;
        for ($i = 0; $i < $side->affected; $i++) {
            $status = "";
            if ($side->data[$i]['status'] == 1) {
                $status = "<input type='checkbox' name='status_{$i}' id='status_{$i}' checked>";
            } else {
                $status = "<input type='checkbox' name='status_{$i}' id='status_{$i}'>";
            }
            $j = $i + 1;
            $line[$j][0] = $side->data[$i]['id'];
            $line[$j][1] = "<input type='text' name='position_{$i}' id='position_{$i}' value='{$side->data[$i]['position']}' size='3' maxlength='2'>";
            $line[$j][2] = $side->data[$i]['label'];
            $line[$j][3] = $status;
            $line[$j][4] = $side->data[$i]['allow'];
            $line[$j][5] = $side->data[$i]['allow_value'];
            if ($_SESSION['log_access_level'] == 81) {
                $line[$j][6] = '<a title="Edit" class="edit-icon pointer" onclick="proccess_information(\'listsidemenu\', \'edit_side_menu\', \'menu_nav\', null, \'menuid|' . $side->data[$i]['id'] . '\');">Edit</a>';
                $line[$j][7] = '<a title="Delete" class="delete-icon pointer" onclick="proccess_information(\'listsidemenu\', \'delete_side_menu\', \'menu_nav\', \'Are you sure you want to delete this menu?\', \'delete_menu_id|' . $side->data[$i]['id'] . '\', null, this, \'remove_row\');">Delete</a>
                        <input type="hidden" id="id_' . $i . '" value="' . $side->data[$i]['id'] . '" name="id_' . $i . '">';
            } else {
                $line[$j][6] = '<a title="Edit (disabled)" class="edit-icon disabled-icon">Edit</a>';
                $line[$j][7] = '<a title="Delete (disabled)" class="delete-icon disabled-icon">Delete</a>';
            }
            $total++;
        }

        $view = new ListView();
        $listview = $view->build(NULL, $line);

        $main_list = $title .
                '<form id="listsidemenu" name="listsidemenu" action="javascript:proccess_information(\'listsidemenu\', \'update_side_menu\', \'menu_nav\', \'Are you sure you want to update this menu?\');">
      ' . $listview . '
      <div class="form-item-bottom-table">
        <input type="submit" value="Update" class="button">
        <input type="button" value="Add New" class="button" onclick="proccess_information(\'listsidemenu\', \'add_new_sidemenu\', \'menu_nav\', null, \'sub_menu_id|' . $data['sub_id'] . '\');">
        <input type="hidden" value="' . $total . '" name="total" id="total">
        <input type="hidden" id="main_menu_id" name="main_menu_id" value="' . $data['sub_id'] . '">
      </div>
      </form>
      <script type="javascript/text">
        $("main-error-msg").update("<h1>' . $upstream_name . '</h1>");
      </script>';
    } else {
        $main_list = $title . SIDEMENU_NOTFOUND_MESG . '
    <form name="listsidemenu" id="listsidemenu">
      <input type="button" value="Add New" class="button" onclick="proccess_information(\'listsidemenu\', \'add_new_sidemenu\', \'menu_nav\', null, \'sub_menu_id|' . $data['sub_id'] . '\');">
    </form>
      <script type="javascript/text">
        $("main-error-msg").update("<h1>' . $upstream_name . '</h1>");
      </script>';
    }
    return $main_list;
}

function save_new_sidemenu($data) {
    $side = new SideMenu();
    $sidemenu = new SideMenu();
    $side->load_list("ASSOC", "sub_menu_id='{$data['sub_menu_id']}' ORDER BY position DESC LIMIT 1");
    if ($side->affected) {
        $new_position = $side->data[0]['position'];
        $sidemenu->position = $new_position + 1;
    } else {
        $sidemenu->position = 0;
    }
    $sidemenu->sub_menu_id = $data['sub_menu_id'];
    $sidemenu->element_name = $data['element_name'];
    $sidemenu->label = $data['label'];
    $sidemenu->title = $data['title'];
    $sidemenu->func = $data['func'];
    $sidemenu->module = $data['module'];
    $sidemenu->allow = $data['allow'];
    $sidemenu->allow_value = $data['allow_value'];
    $sidemenu->status = 1;
    $sidemenu->initial = 0;
    $sidemenu->insert();
    $var['sub_id'] = $data['sub_menu_id'];
    return "<form action='" . NATURAL_WEB_ROOT . "dashboard.php'>
    " . POSITION_MENU_UPDATED_MESG . " <input type='submit' value='Reload' class='button'>
    </form>" . list_sidemenus($var);
}

function update_side_menu($data) {
    for ($i = 0; $i < $data['total']; $i++) {
        $status = "";
        $id = "";
        $position = "";
        $main = "";
        if (!is_numeric($data['position_' . $i])) {
            return "ERROR|" . POSITION_NOTNUM_CODE . "|" . POSITION_NOTNUM_MESG;
            exit(0);
        }

        if ($data['position_' . $i] >= $data['total']) {
            return "ERROR|" . HIGHER_MENU_POSITION_CODE . "|" . HIGHER_MENU_POSITION_MESG;
            exit(0);
        }

        $id = $data['id_' . $i];
        $status = ($data['status_' . $i]) ? 1 : 0;
        $position = $data['position_' . $i];

        $con = mysql_connect(NATURAL_DBHOST, NATURAL_DBUSER, NATURAL_DBPASS);
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }

        mysql_select_db(NATURAL_DBNAME, $con);

        $result = mysql_query("UPDATE " . NATURAL_DBNAME . "." . SIDE_MENU_TABLE . " SET status = '{$status}', position='{$position}' WHERE id='{$id}'") or die(mysql_error());

        mysql_close($con);
    }
    return "<form action='" . NATURAL_WEB_ROOT . "dashboard.php'>
    " . POSITION_MENU_UPDATED_MESG . " <input type='submit' value='Reload'  class='button'><br>
    </form>
    ";
}

function save_side_menu_config($data) {
    $sidemenu = new SideMenu();
    $sidemenu->load_single("id='{$data['id']}'");
    $sidemenu->sub_menu_id = $data['sub_menu_id'];
    $sidemenu->position = $data['position'];
    $sidemenu->element_name = $data['element_name'];
    $sidemenu->label = $data['label'];
    $sidemenu->title = $data['title'];
    $sidemenu->func = $data['func'];
    $sidemenu->module = $data['module'];
    $sidemenu->allow = $data['allow'];
    $sidemenu->allow_value = $data['allow_value'];
    $sidemenu->status = $data['status'];
    $sidemenu->initial = $data['initial'];
    $sidemenu->update("id='{$data['id']}'");
    $var['sub_id'] = $data['sub_menu_id'];

    return "<form action='" . NATURAL_WEB_ROOT . "dashboard.php'>
    " . POSITION_MENU_UPDATED_MESG . " <input type='submit' value='Reload'  class='button'><br>{$save_status}
    </form>" . list_sidemenus($var);
}

function delete_side_menu($data) {
    $del = new SideMenu();
    $del->load_single("id='{$data['delete_menu_id']}'");
    $sub_menu_id = $del->sub_menu_id;
    $del->remove("id='{$data['delete_menu_id']}'");
    organize_menu_position("side", $sub_menu_id);
    return MENU_REMOVED_MESG;
}

function show_levels() {
    return "To allow this menu between 2 levels, select between and on the next field write 21and41 for example.( <a href=\"javascript:proccess_information('EditMainMenuForm', 'view_levels', 'acl', '', '', '', 'showlevels');\">click here</a> to view levels )<span id='showlevels'></span>";
}

function add_new_mainmenu() {
    $form = new DbForm();
    echo $form->build("new_main_menu");
}

function edit_main_menu($data) {
    $form = new DbForm();
    $menu = new MainMenu();
    $menu->load_single("id='{$data['menuid']}'");
    echo $form->build("edit_main_menu", $menu);
}

function add_new_submenu($data) {
    $main = new MainMenu();
    $main->load_single("id='{$data['main_menu_id']}'");
    $form = new DbForm();
    $subtb->main_menu_id = $data['main_menu_id'];
    $subtb->module = $main->module;
    echo $form->build("new_sub_menu", $subtb);
}

function edit_sub_menu($data) {
    $form = new DbForm();
    $sub = new SubMenu();
    $sub->load_single("id='{$data['menuid']}'");
    $main = new MainMenu();
    $main->load_list("ASSOC", "id!=''");
    if ($main->affected) {
        for ($i = 0; $i < $main->affected; $i++) {
            $list .= "{$main->data[$i]['label']}={$main->data[$i]['id']};";
        }
    } else {
        $list = "Not Found=Not Found;";
    }

    $sub->main_menu_list = substr($list, 0, -1);
    echo $form->build("edit_sub_menu", $sub);
}

function add_new_sidemenu($data) {
    $main = new MainMenu();
    $sub = new SubMenu();
    $main->load_list("ASSOC", "id!=''");
    if ($main->affected) {
        for ($i = 0; $i < $main->affected; $i++) {
            $sub->load_list("ASSOC", "main_menu_id='{$main->data[$i]['id']}'");
            for ($x = 0; $x < $sub->affected; $x++) {
                $list .= "{$main->data[$i]['label']} -> {$sub->data[$x]['label']}={$sub->data[$x]['id']};";
            }
        }
    } else {
        $list = "Not Found=Not Found;";
    }

    $submenu = new SubMenu();
    $submenu->load_single("id='{$data['sub_menu_id']}'");

    $var->sub_menu_list = substr($list, 0, -1);
    $var->sub_menu_id = $data['sub_menu_id'];
    $var->module = $submenu->module;
    $form = new DbForm();
    echo $form->build("new_side_menu", $var);
}

function edit_side_menu($data) {
    $main = new MainMenu();
    $sub = new SubMenu();
    $main->load_list("ASSOC", "id!=''");
    if ($main->affected) {
        for ($i = 0; $i < $main->affected; $i++) {
            $sub->load_list("ASSOC", "main_menu_id='{$main->data[$i]['id']}'");
            for ($x = 0; $x < $sub->affected; $x++) {
                $list .= "{$main->data[$i]['label']} -> {$sub->data[$x]['label']}={$sub->data[$x]['id']};";
            }
        }
    } else {
        $list = "Not Found=Not Found;";
    }

    $side = new SideMenu();
    $side->sub_menu_list = substr($list, 0, -1);
    $side->load_single("id='{$data['menuid']}'");
    $form = new DbForm();
    echo $form->build("edit_side_menu", $side);
    //echo $sidetb->show_edit($side);
}

function build_dash_fullscreen_menu($data) {
    $qc = new Campaigns();
    //$qc->load_list("ASSOC","id!=''");
    $qc->load_list("ASSOC", "id!='' ORDER BY status DESC, id DESC");
//	print_debug($qc);

    if ($qc->affected < 1) {
        $menu = "";
    } else {
        for ($i = 0; $i < $qc->affected; $i++) {
            if ($qc->data[$i]['id'] == $data['campaign_id']) {
                if ($i == 0) {
                    $class = 'active-first';
                } else {
                    $class = 'active';
                }
            } else {
                if ($i == 0) {
                    $class = 'deactive-first';
                } else {
                    $class = '';
                }
            }
            $name = "";
            $len = strlen($qc->data[$i]['name']);
            if (strlen($qc->data[$i]['name']) > 23) {
                $name = substr($qc->data[$i]['name'], 0, 23) . "...";
            } else {
                $name = $qc->data[$i]['name'];
            }
            $menu_list .= "<li class='{$class}' id='{$qc->data[$i]['id']}' name='{$qc->data[$i]['id']}'>
          <a href=\"javascript:menu_navigation_fullscreen('" . $qc->data[$i]['id'] . "',true);\" title='{$qc->data[$i]['name']}'>{$qc->data[$i]['id']} - {$name}</a>
        </li>";
        }
        $menu = "<ul class='hive-dashmenu-list'>
      {$menu_list}
      </ul>";
    }
    return $menu;
}