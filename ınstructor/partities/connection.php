<?php
$connection = new mysqli("localhost", "kaan", "C6DVPSp.[MQAzpsn", "online_exam");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}


?>