<?php
function pdo_connect_mysql() {
    $host = 'localhost';
    $db   = 'fixer_upper_shop';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';
    

  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        //commented out the next line for production
        //echo "Connected successfully!";
        return $pdo;
    } catch (\PDOException $e) {
        exit('Failed to connect to database!');
    }
}
?>  