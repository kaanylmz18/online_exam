<?php
$connection = new mysqli("localhost", "root", "", "online_exam");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}


?>