<?

/**
 * List items
 */
function book_list($row_id = null, $search_query = NULL, $sort = NULL, $pager_current = 1) {
    $title = '<h1>' . translate('List of books', $_SESSION['log_preferred_language']) . '</h1>';
    $view = new ListView();

    if ($search_query) {
        $search_fields = array('b.id', 'b.name', 'b.author');
        $exceptions = array();
        $search_query = build_search_query($search_query, $search_fields, $exceptions);
    }

    if ($row_id) {
        $clause = 'b.id = ' . $row_id;
    } else {
        $clause = 'b.id <> 0';
    }

    // Sort
    if (!$sort) {
        $sort = 'b.id ASC';
    }

    $limit = PAGER_LIMIT;
    $start = ($pager_current * $limit) - $limit;
    // book Object
    $book = getList($clause, $search_query, $sort, $start, $limit);

    if ($book->affected > 0) {
        // Building the header with sorter
        $fields[] = array('display' => 'Id', 'field' => 'b.id');
        $fields[] = array('display' => 'Name', 'field' => 'b.name');
        $fields[] = array('display' => 'Author', 'field' => 'b.author');
        $fields[] = array('display' => 'Edit', 'field' => NULL);
        $fields[] = array('display' => 'Delete', 'field' => NULL);
        $line[0] = build_sort_header('book_list', 'book', $fields, $sort);

        $total = 0;
        for ($i = 0; $i < $book->affected; $i++) {
            $j = $i + 1;
            $line[$j][0] = $book->data[$i]['id'];
            $line[$j][1] = $book->data[$i]['name'];
            $line[$j][2] = $book->data[$i]['author'];
            $line[$j][3] = "<a class=\"edit-icon pointer\" onclick=\"proccess_information(null, 'book_edit_form', 'book', null, 'id|{$book->data[$i]['id']}', null, this, 'slide');\">Edit</a>";
            $line[$j][4] = "<a class=\"delete-icon pointer\" onclick=\"proccess_information(null, 'book_delete', 'book', 'Are you sure you want to remove this Book?', 'id|{$book->data[$i]['id']}', null, this, 'remove_row');\">Delete</a>";
            $total++;
        }
        if ($row_id) {
            $main_list = "<td>" . $line[1][0] . "</td><td>" . $line[1][1] . "</td><td>" . $line[1][2] . "</td><td>" . $line[1][3] . "</td><td>" . $line[1][4] . "</td>";
        } else {
            $main_list = $title . $view->realbuild(NULL, $line, 'book_list', 'book', $book->total_records, $limit, $pager_current, $sort, $search_query);
        }
    } else {
        $main_list = $title . build_search_form('book_list', 'book') . 'No books to display.';
    }
    return $main_list;
}

/*
 * show edit form
 */

function book_edit_form($data) {
    $panel = new Panel();
    $book = getSingle($data['id']);
    $frm = new DbForm();
    $resp = $frm->build('book_edit', $book);
    return $panel->build_panel('', $resp);
}

/*
 * show add form
 */

function book_add_form($data) {
    $frm = new DbForm();
    echo $frm->build("book_new");
}

?>