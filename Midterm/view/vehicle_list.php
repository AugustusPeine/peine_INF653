<!DOCTYPE html>
<html>
<head>
    <title>Zippy Used Autos</title>
    <link rel="stylesheet" href="css/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>

<body>
    <h1>Zippy Used Autos</h1>

    <!-- Sort form-->
    <form method="get">
        <label>Sort By</label>
        <select name="sort">
            <option value="price" <?= ($sort == 'price') ? 'selected' : '' ?>>Price (High to Low)</option>
            <option value="year" <?= ($sort == 'year') ? 'selected' : '' ?>>Year (Newest)</option>
        </select>

        <!-- Hidden fields preserve ALL active filters through sorting -->
        <?php if (!empty($make_id)): ?>
            <input type="hidden" name="make_id" value="<?= $make_id ?>">
        <?php endif; ?>
        <?php if (!empty($type_id)): ?>
            <input type="hidden" name="type_id" value="<?= $type_id ?>">
        <?php endif; ?>
        <?php if (!empty($class_id)): ?>
            <input type="hidden" name="class_id" value="<?= $class_id ?>">
        <?php endif; ?>

        <button>Sort</button>
    </form>

    <!-- Container that holds filter sidebar and vehicle table -->
    <div class="content-wrapper">
        <!-- Left panel with dropdowns for make, type, and class filtering -->
        <div class="filters-sidebar">
            <h3>Filter Vehicles</h3>
            <form method="get">
                <!-- Make Filter Dropdown -->
                <label for="make_select">Make</label>
                <select id="make_select" name="make_id">
                    <option value="">-- All Makes --</option>
                    <?php foreach ($makes as $make): ?>
                        <option value="<?= $make['make_id'] ?>" <?= (isset($make_id) && $make_id == $make['make_id']) ? 'selected' : '' ?>>
                            <?= $make['make_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Type Filter Dropdown -->
                <label for="type_select">Type</label>
                <select id="type_select" name="type_id">
                    <option value="">-- All Types --</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?= $type['type_id'] ?>" <?= (isset($type_id) && $type_id == $type['type_id']) ? 'selected' : '' ?>>
                            <?= $type['type_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Class Filter Dropdown -->
                <label for="class_select">Class</label>
                <select id="class_select" name="class_id">
                    <option value="">-- All Classes --</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['class_id'] ?>" <?= (isset($class_id) && $class_id == $class['class_id']) ? 'selected' : '' ?>>
                            <?= $class['class_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Hidden input carries current sort through filter submission -->
                <input type="hidden" name="sort" value="<?= $sort ?>">
                <button type="submit">Apply Filters</button>
            </form>

            <!-- Shown only when filters are active -->
            <?php if (!empty($make_id) || !empty($type_id) || !empty($class_id)): ?>
                <div style="text-align: center; margin-top: 12px;">
                    <a href="index.php" class="clear-filters">Clear All Filters</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Vehicle Table -->
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
                            <td><strong>$<?= number_format($vehicle['price'], 2) ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>