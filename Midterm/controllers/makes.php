<?php
/**
 * Controller to manage makes
 * Handles all logic for the makes management page.
 * Processes add/delete operations and prepares data for the view.
 */


require('../model/makes_db.php');
require('../helpers.php');

$error = null;
$success = null;

// Add a new make when posted
if (isset($_POST['make_name'])) {
    add_make($_POST['make_name']);
    $success = 'Make added successfully!';
}

// Delete an existing make when requested
if (isset($_POST['delete_id'])) {
    if (!delete_make($_POST['delete_id'])) {
        $error = 'Cannot delete this make because vehicles are using it.';
    } else {
        $success = 'Make deleted successfully!';
    }
}

$makes = get_makes();

include('../view/makes_list.php');
?>