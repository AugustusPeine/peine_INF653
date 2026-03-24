<?php
/**
 * Controller to manage types
 * Handles all logic for the types management page.
 * Processes add/delete operations and prepares data for the view.
 */


require('../model/types_db.php');
require('../helpers.php');

$error = null;
$success = null;

if (isset($_POST['type_name'])) {
    add_type($_POST['type_name']);
    $success = 'Type added successfully!';
}

if (isset($_POST['delete_id'])) {
    if (!delete_type($_POST['delete_id'])) {
        $error = 'Cannot delete this type because vehicles are using it.';
    } else {
        $success = 'Type deleted successfully!';
    }
}

$types = get_types();

include('../view/types_list.php');
?>