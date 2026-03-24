<?php
/**
 * Types data access
 */

require_once('database.php');

/**
 * Return all types ordered by name.
 * @return array
 */
function get_types()
{
    global $db;
    $query = 'SELECT * FROM types ORDER BY type_name';
    $statement = $db->prepare($query);
    $statement->execute();
    return $statement->fetchAll();
}


/**
 * Add a new type.
 * @param string $type_name
 * @return void
 */
function add_type($type_name)
{
    global $db;
    $query = 'INSERT INTO types (type_name) VALUES (:type_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':type_name', $type_name);
    $statement->execute();
}


/**
 * Check if a type has any vehicles.
 * @param int $type_id
 * @return int
 */
function count_vehicles_by_type($type_id)
{
    global $db;
    $query = 'SELECT COUNT(*) as count FROM vehicles WHERE type_id = :type_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':type_id', $type_id);
    $statement->execute();
    $result = $statement->fetch();
    return $result['count'];
}

/**
 * Delete a type by id.
 * @param int $type_id
 * @return bool
 */
function delete_type($type_id)
{
    if (count_vehicles_by_type($type_id) > 0) {
        return false;
    }
    
    global $db;
    $query = 'DELETE FROM types WHERE type_id = :type_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':type_id', $type_id);
    $statement->execute();
    return true;
}

?>