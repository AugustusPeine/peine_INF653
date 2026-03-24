<?php
/**
 * Controller to manage classes
 * Handles all logic for the classes management page.
 * Processes add/delete operations and prepares data for the view.
 */


require('../model/classes_db.php');
require('../helpers.php');

$error = null;
$success = null;

if (isset($_POST['class_name'])) {
    add_class($_POST['class_name']);
    $success = 'Class added successfully!';
}

if (isset($_POST['delete_id'])) {
    if (!delete_class($_POST['delete_id'])) {
        $error = 'Cannot delete this class because vehicles are using it.';
    } else {
        $success = 'Class deleted successfully!';
    }
}

$classes = get_classes();

include('../view/classes_list.php');
?>