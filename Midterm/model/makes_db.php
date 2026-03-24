<?php
/**
 * Makes data access
 */

require_once('database.php');

/**
 * Return all makes ordered by name.
 * @return array
 */
function get_makes()
{
    global $db;
    $query = 'SELECT * FROM makes ORDER BY make_name';
    $statement = $db->prepare($query);
    $statement->execute();
    return $statement->fetchAll();
}


/**
 * Add a new make.
 * @param string $make_name
 * @return void
 */
function add_make($make_name)
{
    global $db;
    $query = 'INSERT INTO makes (make_name) VALUES (:make_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':make_name', $make_name);
    $statement->execute();
}


/**
 * Check if a make has any vehicles.
 * @param int $make_id
 * @return int
 */
function count_vehicles_by_make($make_id)
{
    global $db;
    $query = 'SELECT COUNT(*) as count FROM vehicles WHERE make_id = :make_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':make_id', $make_id);
    $statement->execute();
    $result = $statement->fetch();
    return $result['count'];
}

/**
 * Delete a make by id
 * @param int $make_id
 * @return bool
 */
function delete_make($make_id)
{
    if (count_vehicles_by_make($make_id) > 0) {
        return false;
    }
    
    global $db;
    $query = 'DELETE FROM makes WHERE make_id = :make_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':make_id', $make_id);
    $statement->execute();
    return true;
}

?>