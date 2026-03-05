<?php
require_once('model/assignment_db.php');
require_once('model/course_db.php');


//Get the assignment ID from the query string
$assignment_id = filter_input(INPUT_GET, 'assignment_id', FILTER_VALIDATE_INT);
$assignment = get_assignments_by_course(null);
$assignment_detail = null;


//Find the assignment details based on the ID
foreach ($assignment as $assign) {
    if ($assign['ID'] == $assignment_id) {
        $assignment_detail = $assign;
        break;
    }
}

$courses = get_courses();

// If the assignment is not found, display an error message
if (!$assignment_detail) {
    die("Assignment not found");
}
?>

<?php include('view/header.php'); ?>



<section>
    <h2>Update Assignment</h2>

    <!-- Form to update an assignment -->
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="update_assignment">
        <input type="hidden" name="assignment_id" value="<?= $assignment_detail['ID'] ?>">

        <label>Description:</label><br>
        <input type="text" name="description" value="<?= htmlspecialchars($assignment_detail['Description']) ?>" required><br><br>

        <label>Course:</label><br>
        <select name="course_id">
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course['courseID'] ?>" 
                    <?= $course['courseID'] == $assignment_detail['courseID'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($course['courseName']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Update Assignment</button>
    </form>
</section>

<?php include('view/footer.php'); ?>