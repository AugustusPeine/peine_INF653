<?php
/**
 * Admin Page to add vehicle
 * Provides a form interface for admin users to add new vehicles to the inventory.
 * Displays form with year, model, price, and category dropdowns.
 */



require('../model/database.php');
require('../model/makes_db.php');
require('../model/types_db.php');
require('../model/classes_db.php');
require('../helpers.php');

$makes   = get_makes();
$types   = get_types();
$classes = get_classes();

if (isset($_POST['model'])) {
	$query = "
        INSERT INTO vehicles
        (year, model, price, type_id, class_id, make_id)
        VALUES
        (:year, :model, :price, :type_id, :class_id, :make_id)
        ";

	$statement = $db->prepare($query);

	$statement->bindValue(':year', $_POST['year']);
	$statement->bindValue(':model', $_POST['model']);
	$statement->bindValue(':price', $_POST['price']);
	$statement->bindValue(':type_id', $_POST['type_id']);
	$statement->bindValue(':class_id', $_POST['class_id']);
	$statement->bindValue(':make_id', $_POST['make_id']);

	$statement->execute();

	echo "<p>Vehicle added successfully!</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Vehicle - Zippy Admin</title>
	<link rel="stylesheet" href="../css/styles.css">
	<meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

<h1>Add Vehicle</h1>

<form method="post">
	<label for="year">Year</label>
	<input id="year" type="number" name="year" min="1900" max="2099" required>

	<label for="model">Model</label>
	<input id="model" type="text" name="model" required>

	<label for="price">Price</label>
	<input id="price" type="number" name="price" step="0.01" min="0" required>

	<label for="make_id">Make</label>
	<select id="make_id" name="make_id" required>
		<option value="">-- Select Make --</option>
		<?php foreach ($makes as $make): ?>
			<option value="<?= $make['make_id'] ?>"><?= $make['make_name'] ?></option>
		<?php endforeach; ?>
	</select>

	<label for="type_id">Type</label>
	<select id="type_id" name="type_id" required>
		<option value="">-- Select Type --</option>
		<?php foreach ($types as $type): ?>
			<option value="<?= $type['type_id'] ?>"><?= $type['type_name'] ?></option>
		<?php endforeach; ?>
	</select>

	<label for="class_id">Class</label>
	<select id="class_id" name="class_id" required>
		<option value="">-- Select Class --</option>
		<?php foreach ($classes as $class): ?>
			<option value="<?= $class['class_id'] ?>"><?= $class['class_name'] ?></option>
		<?php endforeach; ?>
	</select>

	<button type="submit">Add Vehicle</button>
</form>


<?php render_admin_footer('add_vehicle'); ?>

</body>
</html>