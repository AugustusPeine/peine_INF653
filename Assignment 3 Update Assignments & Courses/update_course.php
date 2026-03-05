<?php
require_once('model/course_db.php');

//Get the course ID from the query string
$course_id = filter_input(INPUT_GET, 'course_id', FILTER_VALIDATE_INT);
$courses = get_courses();
$course_detail = null;


//Find the course details based on the ID
foreach ($courses as $c) {
    if ($c['courseID'] == $course_id) {
        $course_detail = $c;
        break;
    }
}


//If the course is not found display error 
if (!$course_detail) {
    die("Course not found");
}
?>

<?php include('view/header.php'); ?>

<section>
    <h2>Update Course</h2>

    <!-- Form to update a course -->
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="update_course">
        <input type="hidden" name="course_id" value="<?= $course_detail['courseID'] ?>">

        <label>Course Name:</label><br>
        <input type="text" name="course_name" value="<?= htmlspecialchars($course_detail['courseName']) ?>" required><br><br>

        <button type="submit">Update Course</button>
    </form>
</section>

<?php include('view/footer.php'); ?>