<?

/**
 * List items
 */
function book_list($row_id = NULL, $search = NULL, $sort = NULL, $page = 1) {
    $view = new ListView();
    // Row Id for update only row
    if (!empty($row_id)) {
      $row_id = 'b.id = ' . $row_id;
    } else {
      $row_id = 'b.id != 0';
    }
    
    // Search
    if (!empty($search)) {
        $search_fields = array('b.id', 'b.name', 'b.author');
        $exceptions = array();
        $search_query = build_search_query($search, $search_fields, $exceptions);
    } else {
        $search_query = '';
    }

    // Sort
    if (empty($sort)) {
        $sort = 'b.id ASC';
    }

    $limit = PAGER_LIMIT;
    $start = ($page * $limit) - $limit;
    
    // Dial List Table Object
    $book = new DataManager();
    $book->dmLoadCustomList("SELECT b.*
    FROM " . NATURAL_DBNAME . ".book b
    WHERE $row_id  $search_query
    ORDER BY  $sort 
    LIMIT  $start, $limit", 'ASSOC', TRUE);
    
    if ($book->affected > 0) {
        // Building the header with sorter
        $headers[] = array('display' => 'Id', 'field' => 'b.id');
        $headers[] = array('display' => 'Name', 'field' => 'b.name');
        $headers[] = array('display' => 'Author', 'field' => 'b.author');
        $headers[] = array('display' => 'Edit', 'field' => NULL);
        $headers[] = array('display' => 'Delete', 'field' => NULL);
        $headers = build_sort_header('book_list', 'book', $headers, $sort);

        for ($i = 0; $i < $book->affected; $i++) {
            $j = $i + 1;
            //This is important for the row update/delete
            $rows[$j]['row_id'] = $book->data[$i]['id'];
            /////////////////////////////////////////////
            $rows[$j]['id']     = $book->data[$i]['id'];
            $rows[$j]['name']   = $book->data[$i]['name'];
            $rows[$j]['author'] = $book->data[$i]['author'];
            $rows[$j]['edit']   = theme_link_process_information('', 'book_edit_form', 'book_edit_form', 'book', array('extra_value' => 'book_id|' . $book->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_EDIT_ICON));
            $rows[$j]['delete'] = theme_link_process_information('', 'book_delete_form', 'book_delete_form', 'book', array('extra_value' => 'book_id|' . $book->data[$i]['id'], 'response_type' => 'modal', 'icon' => NATURAL_REMOVE_ICON));
        }
    }
    
    $options = array(
        'show_headers' => TRUE,
        'page_title' => translate('Users List'),
        'page_subtitle' => translate('Manage Books'),
        'empty_message' => translate('No book found!'),
        'table_prefix' => theme_link_process_information(translate('Create New Book'), 'book_create_form', 'book_create_form', 'book', array('response_type' => 'modal')),
        'pager_items' => build_pager('book_list', 'book', $book->total_records, $limit, $page),
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
    //print $form;
}

/*
 * Insert on table
 */
function book_create_form_submit($data) {
    $book_val = new Book();
    $error    = $book_val->_validate($data, false, false);
    if (!empty($error)) {
      foreach($error as $msg) {
        natural_set_message($msg, 'error');
      }
      return FALSE;
    }
    $book = new Book();
    foreach ($data as $field => $value) {
        if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
            $book->$field = $value;
        }
    }
    $book->insert();
    if ($book->affected > 0 ) {
        natural_set_message('Book has been created!', 'success');
        return book_list($book->id);
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
    $book->loadSingle('id='.$data['book_id']);
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
        $book->loadSingle("id='" . $data['id'] . "'");
        foreach ($data as $field => $value) {
            if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
                $book->$field = $value;
            }
        }
        $book->update("id='" . $data['id'] . "'");
        if ($book->affected > 0) {
            natural_set_message('Book updated successfully!', 'success');
        }
        return book_list($data['id']);
    }
}

/*
 * show edit form
 */
function book_delete_form($data) {
    $book = new Book();
    $book->loadSingle('id='.$data['book_id']);
    if($book->affected>0){
        $frm = new DbForm();
        $frm->build('book_delete_form', $book, $_SESSION['log_access_level']);
    }else{
        natural_set_message('Problems loading book ' . $user_id, 'error');
        return FALSE;   
    }
}

/*
 * Remove from table
 */
function book_delete_form_submit($data) {
    $book = new Book();
    $book->remove('id=' . $data['id']);
    if ($book->affected > 0) {
        //return "ERROR||Could not remove!";
        $book->remove('id=' . $data['id']);
        natural_set_message('Book has been removed successfully!', 'success');
        return $data['id'];
    } else {
        natural_set_message('Problems loading user ' . $user_id, 'error');
        return FALSE;
    }
}

/*
 * Validate data
 */
function book_validate($data) {
    $book = new Book();
    $edit = false;
    if (stripos("edit", $words)) {
        $edit = true;
    }
    return $book->_validate($data, $edit, false);
}

?>