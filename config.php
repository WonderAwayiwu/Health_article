<?php 

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'health_app');

    $sql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($sql->connect_error) {
        die("Connection failed: " . $sql->connect_error);
    }  

?>                      