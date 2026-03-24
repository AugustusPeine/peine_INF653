<!DOCTYPE html>
<html>
<head>
    <title>Manage Makes - Zippy Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

<h1>Manage Makes</h1>

<!-- Error message if deletion fails -->
<?php if ($error): ?>
    <div style="background-color: #ffcccc; color: #cc0000; padding: 12px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #cc0000;">
        <?= $error ?>
    </div>
<?php endif; ?>

<!-- Successful add or delete -->
<?php if ($success): ?>
    <div style="background-color: #ccffcc; color: #009900; padding: 12px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #009900;">
        ✓ <?= $success ?>
    </div>
<?php endif; ?>

<!-- Input field and button to add new vehicle make -->
<form method="post">
	<input type="text" name="make_name" placeholder="Enter new make name" required>
	<button type="submit">Add Make</button>
</form>

<!--Table of all makes -->
<div class="table-wrapper">
	<table>
		<thead>
			<tr>
				<th>Make Name</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($makes as $make): ?>
				<tr>
					<td><?= $make['make_name'] ?></td>
					<td>
						<form method="post" style="margin: 0;">
							<input type="hidden" name="delete_id" value="<?= $make['make_id'] ?>">
							<button type="submit">Delete</button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<!-- Footer that links to other admin pages -->
<?php render_admin_footer('makes'); ?>

</body>
</html>