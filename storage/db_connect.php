<?php 
    $mysqli = new mysqli("localhost", "root", "", "car_ticket_system");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
?>