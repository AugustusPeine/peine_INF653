<?php
/**
 * Classes data access
 */
require_once('database.php');

/**
 * Return all classes ordered by name.
 * @return array
 */
function get_classes()
{
    global $db;
    $query = 'SELECT * FROM classes ORDER BY class_name';
    $statement = $db->prepare($query);
    $statement->execute();
    return $statement->fetchAll();
}


/**
 * Add a new class.
 * @param string $class_name
 * @return void
 */
function add_class($class_name)
{
    global $db;
    $query = 'INSERT INTO classes (class_name) VALUES (:class_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':class_name', $class_name);
    $statement->execute();
}


/**
 * Check if a class has any vehicles.
 * @param int $class_id
 * @return int
 */
function count_vehicles_by_class($class_id)
{
    global $db;
    $query = 'SELECT COUNT(*) as count FROM vehicles WHERE class_id = :class_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':class_id', $class_id);
    $statement->execute();
    $result = $statement->fetch();
    return $result['count'];
}

/**
 * Delete a class by id
 * @param int $class_id
 * @return bool
 */
function delete_class($class_id)
{
    if (count_vehicles_by_class($class_id) > 0) {
        return false;
    }
    
    global $db;
    $query = 'DELETE FROM classes WHERE class_id = :class_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':class_id', $class_id);
    $statement->execute();
    return true;
}

?>