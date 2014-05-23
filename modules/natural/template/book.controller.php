<?

/*
 * Get list from the model
 */

function getList($clause, $search_query, $sort, $start, $limit) {
    $book = new Book();
    $book->load_custom_list("SELECT b.*
    FROM " . NATURAL_DBNAME . ".book b
    WHERE $clause  $search_query
    ORDER BY  $sort 
    LIMIT  $start, $limit", 'ASSOC', TRUE);

    return $book;
}

/*
 * Get single item from database
 */

function getSingle($id) {
    $book = new Book();
    $book->load_single("id='" . $id . "'");
    return $book;
}

/*
 * Update table
 */

function book_edit($data) {
    $val = validate($data);
    if ($val) {
        return 'ERROR||' . $val;
        exit(0);
    }
    $book = new Book();
    $book->load_single("id='" . $data['id'] . "'");
    foreach ($data as $field => $value) {
        if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
            $book->$field = $value;
        }
    }
    $book->update("id='" . $data['id'] . "'");
    if ($book->affected < 1)
        return "ERROR||Could not update thie record!";

    return "Book saved!||" . book_list($data['id']);
}

/*
 * Insert on table
 */

function book_add($data) {
    $val = validate($data);
    if ($val) {
        return 'ERROR||' . $val;
        exit(0);
    }
    $book = new Book();
    foreach ($data as $field => $value) {
        if ($field != 'affected' && $field != 'errorcode' && $field != 'data' && $field != 'dbid' && $field != 'id' && $field != 'fn') {
            $book->$field = $value;
        }
    }
    $book->insert();
    if ($book->affected < 1)
        return "ERROR||Could not update this record!";

    return "Book saved!" . book_list();
}

/*
 * Remove from table
 */

function book_delete($data) {
    $book = new Book();
    $book->remove("id='" . $data['id'] . "'");
    //print_debug($book);
    if ($book->affected < 1)
        return "ERROR||Could not remove!";

    $panel = new Panel();
    return $panel->build_panel('', "Book removed!");
}

/*
 * Validate data
 */

function validate($data) {
    $book = new Book();
    $edit = false;
    if (stripos("edit", $words)) {
        $edit = true;
    }
    return $book->_validate($data, $edit, false);
}

?>