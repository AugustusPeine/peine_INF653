<?php
/**
 * Database connection
 */

$dsn = 'mysql:host=localhost;dbname=zippyusedautos';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    //Log errors instead of echo
    echo $e->getMessage();
}

?>