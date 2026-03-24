<!DOCTYPE html>
<html>
<head>
    <title>Manage Types - Zippy Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

<h1>Manage Types</h1>

<!-- Delete fails -->
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

<!-- Input field and button to add new vehicle type -->
<form method="post">
	<input type="text" name="type_name" placeholder="Enter new type name" required>
	<button type="submit">Add Type</button>
</form>

<!-- Table of all types -->
<div class="table-wrapper">
	<table>
		<thead>
			<tr>
				<th>Type Name</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($types as $type): ?>
				<tr>
					<td><?= $type['type_name'] ?></td>
					<td>
						<form method="post" style="margin: 0;">
							<input type="hidden" name="delete_id" value="<?= $type['type_id'] ?>">
							<button type="submit">Delete</button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<!-- Footer that links to other admin pages -->
<?php render_admin_footer('types'); ?>

</body>
</html>