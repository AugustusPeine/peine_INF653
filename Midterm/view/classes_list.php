<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes - Zippy Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

<h1>Manage Classes</h1>

<!-- Deletion fails -->
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

<!-- Input field and button to add new vehicle class -->
<form method="post">
	<input type="text" name="class_name" placeholder="Enter new class name" required>
	<button type="submit">Add Class</button>
</form>

<!-- Table of all classes -->
<div class="table-wrapper">
	<table>
		<thead>
			<tr>
				<th>Class Name</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($classes as $class): ?>
				<tr>
					<td><?= $class['class_name'] ?></td>
					<td>
						<form method="post" style="margin: 0;">
							<input type="hidden" name="delete_id" value="<?= $class['class_id'] ?>">
							<button type="submit">Delete</button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<!-- Footer that links to other admin pages -->
<?php render_admin_footer('classes'); ?>

</body>
</html>