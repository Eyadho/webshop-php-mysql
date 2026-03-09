<?php

    $host = 'mysql';
    $port = 3306;
    $username = 'root';
    $password = 'rootpassword';
    $database = 'webbshopDB';

    $conn = new mysqli($host, $username, $password, $database, $port);

    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>