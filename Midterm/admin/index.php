<?php
/**
 * Admin Page to manage vehicles
 * Main admin dashboard that displays all vehicles with delete functionality.
 * Allows administrators to remove vehicles from inventory.
*/

require('../model/vehicles_db.php');
require('../helpers.php');

//Handle vehicle deletion when delete form is posted
if (isset($_POST['vehicle_id'])) {
	delete_vehicle($_POST['vehicle_id']);
}

//Get fresh list of all vehicles
$vehicles = get_vehicles();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Zippy Used Autos - Admin</title>
	<link rel="stylesheet" href="../css/styles.css">
	<meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

<h1>Admin Vehicle Management</h1>

<!-- Lists all vehicles -->
<div class="table-wrapper">
	<table>
		<thead>
			<tr>
				<th>Year</th>
				<th>Make</th>
				<th>Model</th>
				<th>Type</th>
				<th>Class</th>
				<th>Price</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($vehicles as $vehicle): ?>
				<tr>
					<td><?= $vehicle['year'] ?></td>
					<td><?= $vehicle['make_name'] ?></td>
					<td><?= $vehicle['model'] ?></td>
					<td><?= $vehicle['type_name'] ?></td>
					<td><?= $vehicle['class_name'] ?></td>
					<td>$<?= number_format($vehicle['price'], 2) ?></td>

				<!-- Delete form -->
				<td>
					<form method="post" style="margin: 0;">
						<input type="hidden" name="vehicle_id" value="<?= $vehicle['vehicle_id'] ?>">
						<button>Delete</button>
					</form>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<!-- Footer that links to other admin pages -->
<?php render_admin_footer('index'); ?>

</body>
</html>