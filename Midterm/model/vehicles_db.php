<?php
/**
 * Vehicles data access
 * Functions to read and modify vehicles and related joins.
 */

require_once('database.php');

/**
 * Get all vehicles ordered by price or year.
 * @param string $sort 'price' or 'year'
 * @return array
 */
function get_vehicles($sort = 'price')
{
    global $db;

    $order = ($sort == 'year') ? 'year DESC' : 'price DESC';

    $query = "
        SELECT *
        FROM vehicles
        JOIN makes USING(make_id)
        JOIN types USING(type_id)
        JOIN classes USING(class_id)
        ORDER BY $order
        ";

    $statement = $db->prepare($query);
    $statement->execute();
    return $statement->fetchAll();
}


/**
 * Get vehicles filtered by make.
 * @param int $make_id
 * @param string $sort
 * @return array
 */
function filter_make($make_id, $sort = 'price')
{
    global $db;

    $order = ($sort == 'year') ? 'year DESC' : 'price DESC';

    $query = "
        SELECT *
        FROM vehicles
        JOIN makes USING(make_id)
        JOIN types USING(type_id)
        JOIN classes USING(class_id)
        WHERE make_id = :make_id
        ORDER BY $order
        ";

    $statement = $db->prepare($query);
    $statement->bindValue(':make_id', $make_id);
    $statement->execute();

    return $statement->fetchAll();
}


/**
 * Get vehicles filtered by type.
 * @param int $type_id
 * @param string $sort
 * @return array
 */
function filter_type($type_id, $sort = 'price')
{
    global $db;

    $order = ($sort == 'year') ? 'year DESC' : 'price DESC';

    $query = "
        SELECT *
        FROM vehicles
        JOIN makes USING(make_id)
        JOIN types USING(type_id)
        JOIN classes USING(class_id)
        WHERE type_id = :type_id
        ORDER BY $order
        ";

    $statement = $db->prepare($query);
    $statement->bindValue(':type_id', $type_id);
    $statement->execute();

    return $statement->fetchAll();
}


/**
 * Get vehicles filtered by class.
 * @param int $class_id
 * @param string $sort
 * @return array
 */
function filter_class($class_id, $sort = 'price')
{
    global $db;

    $order = ($sort == 'year') ? 'year DESC' : 'price DESC';

    $query = "
        SELECT *
        FROM vehicles
        JOIN makes USING(make_id)
        JOIN types USING(type_id)
        JOIN classes USING(class_id)
        WHERE class_id = :class_id
        ORDER BY $order
        ";

    $statement = $db->prepare($query);
    $statement->bindValue(':class_id', $class_id);
    $statement->execute();

    return $statement->fetchAll();
}


/**
 * Filter vehicles by any combination of make, type, and class.
 * @param int|null $make_id
 * @param int|null $type_id
 * @param int|null $class_id
 * @param string $sort
 * @return array
 */
function filter_vehicles($make_id = null, $type_id = null, $class_id = null, $sort = 'price')
{
    global $db;

    $order = ($sort == 'year') ? 'year DESC' : 'price DESC';

    $query = "
        SELECT *
        FROM vehicles
        JOIN makes USING(make_id)
        JOIN types USING(type_id)
        JOIN classes USING(class_id)
        WHERE 1=1
        ";

    if ($make_id) {
        $query .= " AND make_id = :make_id";
    }
    if ($type_id) {
        $query .= " AND type_id = :type_id";
    }
    if ($class_id) {
        $query .= " AND class_id = :class_id";
    }

    $query .= " ORDER BY $order";

    $statement = $db->prepare($query);

    if ($make_id) {
        $statement->bindValue(':make_id', $make_id);
    }
    if ($type_id) {
        $statement->bindValue(':type_id', $type_id);
    }
    if ($class_id) {
        $statement->bindValue(':class_id', $class_id);
    }

    $statement->execute();
    return $statement->fetchAll();
}


/**
 * Delete a vehicle by id.
 * @param int $vehicle_id
 * @return void
 */
function delete_vehicle($vehicle_id)
{
    global $db;

    $query = 'DELETE FROM vehicles WHERE vehicle_id = :vehicle_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':vehicle_id', $vehicle_id);
    $statement->execute();
}

?>