<?php
/**
 * Main Form
 * Main public-facing page for browsing vehicles with sorting and filtering capabilities.
 * This is the primary landing page for customers to view the vehicle inventory.
 */

require('model/vehicles_db.php');
require('model/makes_db.php');
require('model/types_db.php');
require('model/classes_db.php');

$sort = $_GET['sort'] ?? 'price';

$make_id  = $_GET['make_id'] ?? null;
$type_id  = $_GET['type_id'] ?? null;
$class_id = $_GET['class_id'] ?? null;

// Use combined filter function if any filters are active
if ($make_id || $type_id || $class_id) {
	$vehicles = filter_vehicles($make_id, $type_id, $class_id, $sort);
} else {
	$vehicles = get_vehicles($sort);
}

$makes   = get_makes();
$types   = get_types();
$classes = get_classes();

include('view/vehicle_list.php');
?>