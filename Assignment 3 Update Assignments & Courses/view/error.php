<?php
include('header.php');
?>

<section>
    <h2>Error</h2>
    <p style="color:red; font-weight: bold;">
        <?= isset($error) ? htmlspecialchars($error) : "An unknown error occurred." ?>
    </p>
    <p><a href=".?action=list_courses">Back to Courses</a></p>
    <p><a href=".?action=list_assignments">Back to Assignments</a></p>
</section>

<?php
include('footer.php');
?>