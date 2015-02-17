<?php

/**
 * List items
 */
function book_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
    $view = new ListView();
    // Row Id for update only row
    if (!empty($row_id)) {
      $row_id = 'id = ' . $row_id;
    } else {
      $row_id = 'id != 0';
    }
    
    // Sort
    if (empty($sort)) {
      $sort = 'id ASC';
    }
    
    $limit = PAGER_LIMIT;
    $offset = ($page * $limit) - $limit;
    $db = DataConnection::readOnly();
    
    // Search
    if (!empty($search)) {
      $search_fields = array('id', 'name', 'author');
      $exceptions = array();
      $search_query = build_search_query($search, $search_fields, $exceptions);
      
      $books = $db->book()
      ->where($row_id)
      ->and($search_query)
      ->order($sort)
      ->limit($limit, $offset);
    } else {
      $books = $db->book()
      ->where($row_id)
      ->order($sort)
      ->limit($limit, $offset);
    }
    
    $i = 0;
    if (count($books)) {
      // Building the header with sorter
      $headers[] = array('display' => 'Id', 'field' => 'id');
      $headers[] = array('display' => 'Name', 'field' => 'name');
      $headers[] = array('display' => 'Author', 'field' => 'author');
      $headers[] = array('display' => 'Edit', 'field' => NULL);
      $headers[] = array('display' => 'Delete', 'field' => NULL);
      $headers = build_sort_header('book_list', 'book', $headers, $sort);

      foreach( $books as $book ){
        $j = $i + 1;
        //This is important for the row update/delete
        $rows[$j]['row_id'] = $book['id'];
        /////////////////////////////////////////////
        $rows[$j]['id']     = $book['id'];
        $rows[$j]['name']   = $book['name'];
        $rows[$j]['author'] = $book['author'];
        $rows[$j]['edit']   = theme_link_process_information('',
            'book_edit_form',
            'book_edit_form',
            'book',
            array('extra_value' => 'id|' . $book['id'],
                'response_type' => 'modal',
                'icon' => NATURAL_EDIT_ICON));
        $rows[$j]['delete'] = theme_link_process_information('',
            'book_delete_form',
            'book_delete_form',
            'book', array('extra_value' => 'id|' . $book['id'],
                'response_type' => 'modal',
                'icon' => NATURAL_REMOVE_ICON));
        $i++;
      }
    }
    
    $options = array(
        'show_headers' => TRUE,
        'page_title' => translate('Users List'),
        'page_subtitle' => translate('Manage Books'),
        'empty_message' => translate('No book found!'),
        'table_prefix' => theme_link_process_information(translate('Create New Book'),
            'book_create_form',
            'book_create_form',
            'book',
                array('response_type' => 'modal')),
        'pager_items' => build_pager('book_list', 'book', count($books), $limit, $page),
        'page' => $page,
        'sort' => $sort,
        'search' => $search,
        'show_search' => TRUE,
        'function' => 'book_list',
        'module' => 'book',
        'update_row_id' => '',
        'table_form_id' => '',
        'table_form_process' => '',
    );
    $listview = $view->build($rows, $headers, $options);

    return $listview;
}

/*
 * show add form
 */
function book_create_form() {
    $frm = new DbForm();
    return $frm->build("book_create_form");
}

/*
 * Insert on table
 */
function book_create_form_submit($data) {
    $error    = book_validate($data);
    if (!empty($error)) {
      foreach($error as $msg) {
        natural_set_message($msg, 'error');
      }
      return FALSE;
    }
    $book = new Book();
    foreach ($data as $field => $value) {
        if ($field != 'fn') {
            $book->$field = $value;
            $submit[$field] = $value;
        }
    }
    //$book->insert();
    $response = $book->create($submit);
    if ( $response['id'] > 0 ) {
        natural_set_message('Book has been created!', 'success');
        return book_list($response['id']);
    } else {
        natural_set_message('Could not save this Book at this time', 'error');
        return false;
    }
}

/*
 * show edit form
 */
function book_edit_form($data) {
    $book = new Book();
    $book->byID($data['id']);
    $frm = new DbForm();
    $frm->build('book_edit_form', $book, $_SESSION['log_access_level']);
}

/*
 * Update table
 */
function book_edit_form_submit($data) {
  $error = book_validate($data);
  if (!empty($error)) {
    foreach($error as $msg) {
      natural_set_message($msg, 'error');
    }
    return FALSE;
  } else {
    $book = new Book();
    $update = $book->update($data);
    if ($update['code']==200) {
      return book_list($data['id']);
    }
  }
}

/*
 * show edit form
 */
function book_delete_form($data) {
    $book = new Book();
    $book->byID($data['id']);
    //$book->loadSingle('id='.$data['book_id']);
    if($book->affected>0){
        $frm = new DbForm();
        $frm->build('book_delete_form', $book, $_SESSION['log_access_level']);
    }else{
        natural_set_message('Problems loading book ' . $data['id'], 'error');
        return FALSE;   
    }
}

/*
 * Remove from table
 */
function book_delete_form_submit($data) {
    $book = new Book();
    $delete = $book->delete($data['id']);
    if ($delete['code']==200) {
        natural_set_message('Book has been removed successfully!', 'success');
        return $data['id'];
    } else {
        natural_set_message('Problems loading book ' . $data['id'], 'error');
        return FALSE;
    }
}

/*
 * Validate data
 */
function book_validate($data) {
    $book = new Book();
    if (strpos($data['fn'], "edit")) {
        $type = "edit";
    }
    if (strpos($data['fn'], "delete")) {
        $type = "delete";
    }
    if (strpos($data['fn'], "create")) {
        $type = "create";
    }
    return $book->_validate($data, $type, false);
}

?>