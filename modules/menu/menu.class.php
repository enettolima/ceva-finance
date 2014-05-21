<?php

/**
 * @file
 * Menu functionalities.
 */

class Menu Extends DataManager{
  
  /**
	 * Method to fecth Menu list by level
	 *
	 * Fech a list of menus 
	 * by level
	 *
	 * @url GET byLevel/{level}
	 * @url POST byLevel
	 * @smart-auto-routing false
	 * 
	 * @access public
	 * @throws 404 Menu not found for requested level
	 * @param string $level Menu to be fetched
	 * @return mixed 
	 */
  
  public function byLevel($menu_name = 'main', $level) {
    parent::dmLoadList(NATURAL_DBNAME . '.menu'  , 'ASSOC', 'status = 1 AND menu_name LIKE "'.$menu_name.'" ORDER BY position');
    if ($this->affected) {
      $links = array();
      foreach ($this->data as $key => $item) {
        // Test permission.
        if ($this->menuPermission($item, $level)) {
          $links[$item['id']] = $item;
        }
      }
      $tree = $this->menuBuildTree($links);
      return $tree;
    }
  }
  
  /**
	* @smart-auto-routing false
	* @access private
	*/
  public function loadList($level){
    $menu = new DataManager();
    $menu->dmLoadList(NATURAL_DBNAME . '.menu'  , 'ASSOC', 'status = 1 AND menu_name LIKE "main" ORDER BY position');
    return $menu;
  }
  
  /**
	* @smart-auto-routing false
	* @access private
	* Builds a multi dimensional array based on the menu items.
  *
  * @param $links
  *   The links of the menu
  * @param $parent_id
  *   The parent_id (pid) of the menu item
  */
  public function menuBuildTree(array &$links, $parent_id = 0) {
    $branch = array();
    foreach ($links as $link) {
      if ($link['pid'] == $parent_id) {
        $children = $this->menuBuildTree($links, $link['id']);
        if ($children) {
          $link['children'] = $children;
        }
        $branch[$link['id']] = $link;
        unset($links[$link['id']]);
      }
    }
  
    return $branch;
  }
  
  /**
	* @smart-auto-routing false
	* @access private
	*/
  public function menuPermission($menu_item, $level) {
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
}