<?php
/**
 * Helper functions for admin area
 */

/**
 * Render admin footer with dynamic navigation
 * Excludes the current page from being linked
 * @param string $current_page 'index', 'add_vehicle', 'makes', 'types', or 'classes'
 * @return void
 */
function render_admin_footer($current_page) {
    $nav_items = array(
        'index' => array('url' => 'index.php', 'label' => 'Vehicle List'),
        'add_vehicle' => array('url' => 'add_vehicle.php', 'label' => 'Add Vehicle'),
        'makes' => array('url' => 'makes.php', 'label' => 'Manage Makes'),
        'types' => array('url' => 'types.php', 'label' => 'Manage Types'),
        'classes' => array('url' => 'classes.php', 'label' => 'Manage Classes'),
    );

    echo '<footer class="admin-footer">';
    foreach ($nav_items as $key => $item) {
        if ($key !== $current_page) {
            echo '<a href="' . $item['url'] . '">' . $item['label'] . '</a>';
        }
    }
    echo '</footer>';
}
?>
