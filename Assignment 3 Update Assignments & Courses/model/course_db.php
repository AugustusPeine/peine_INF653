<?php
require_once('database.php');

function get_courses()
{
    global $db;
    $query = 'SELECT * FROM courses ORDER BY courseID';
    $statement = $db->prepare($query);
    $statement->execute();
    $courses = $statement->fetchAll();
    $statement->closeCursor();
    return $courses;
}

function get_course_name($course_id)
{
    if (!$course_id) {
        return "All Courses";
    }
    global $db;
    $query = 'SELECT courseName FROM courses WHERE courseID = :course_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id, PDO::PARAM_INT);
    $statement->execute();
    $course = $statement->fetch();
    $statement->closeCursor();

    return $course ? $course['courseName'] : "Unknown Course";
}

function delete_course($course_id)
{
    global $db;
    //Make sure at least one assignment is not associated with the course before deleting
    $query = 'SELECT COUNT(*) AS count FROM assignments WHERE courseID = :course_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id, PDO::PARAM_INT);
    $statement->execute();
    $count = $statement->fetchColumn();
    $statement->closeCursor();

    if ($count > 0) {
        throw new Exception("Cannot delete course with existing assignments.");
    }

    //Delete the course if no assignments are associated with it
    $query = 'DELETE FROM courses WHERE courseID = :course_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}

function add_course($course_name)
{
    global $db;
    $query = 'INSERT INTO courses (courseName) VALUES (:course_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_name', $course_name, PDO::PARAM_STR);
    $statement->execute();
    $statement->closeCursor();
}

//New function to update a course
function update_course($course_id, $course_name) {
    global $db;
    $query = 'UPDATE courses SET courseName = :course_name WHERE courseID = :course_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_name', $course_name, PDO::PARAM_STR);
    $statement->bindValue(':course_id', $course_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}