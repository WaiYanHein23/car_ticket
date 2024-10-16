<?php

$mysqli = new mysqli("localhost", "root", "");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function create_db($mysqli) {
    $sql = "CREATE DATABASE IF NOT EXISTS car_ticket_system";
    if ($mysqli->query($sql)) {
        return true;
    } else {
        echo "Error creating database: " . $mysqli->error;
        return false;
    }
}

function select_db($mysqli) {
    if ($mysqli->select_db("car_ticket_system")) {
        return true;
    } else {
        echo "Error selecting database: " . $mysqli->error;
        return false;
    }
}

function create_tables($mysqli) {
    $sql = "CREATE TABLE IF NOT EXISTS `user`(
        `user_id` INT AUTO_INCREMENT,
        `user_name` VARCHAR(20) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `ph_no` VARCHAR(20) NOT NULL,
        `address` VARCHAR(30) NOT NULL,
        `image`  TEXT,
        `is_admin` BOOLEAN DEFAULT false,
        PRIMARY KEY(`user_id`),
        UNIQUE(`email`)
    )";
    if ($mysqli->query($sql) === false) {
        echo "Error creating `user` table: " . $mysqli->error;
        return false;
    }

   

    $sql = "CREATE TABLE IF NOT EXISTS `car`(
        `car_id` INT AUTO_INCREMENT,
        `brand` VARCHAR(100) NOT NULL,
        `plate_number` VARCHAR(20),
        `model` VARCHAR(50),
        `image` TEXT,
        PRIMARY KEY(`car_id`)
    )";
    if ($mysqli->query($sql) === false) {
        echo "Error creating `car` table: " . $mysqli->error;
        return false;
    }

  

    $sql = "CREATE TABLE IF NOT EXISTS `trip_location`(
        `trip_location_id` INT AUTO_INCREMENT,
        `city_name` varchar(250) NOT NULL,
        `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0= inactive , 1= active',
        PRIMARY KEY (`trip_location_id`)
    )";
    if ($mysqli->query($sql) === false) {
        echo "Error creating `schedule` table: " . $mysqli->error;
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `scheduled_trips`(
        `scheduled_trips_id` INT AUTO_INCREMENT,
        `car_id` int(30) NOT NULL,
        `from_location` int(30) NOT NULL,
        `to_location` int(30) NOT NULL,
        `departure_time` datetime NOT NULL,
        `status` tinyint(4) NOT NULL DEFAULT 1,
        `availability` int(11) NOT NULL,
        `price` text NOT NULL,
        PRIMARY KEY (`scheduled_trips_id`),
        FOREIGN KEY (`car_id`) REFERENCES `car`(`car_id`)ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (`from_location`) REFERENCES `trip_location`(`trip_location_id`)ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (`to_location`) REFERENCES `trip_location`(`trip_location_id`)ON DELETE CASCADE ON UPDATE CASCADE
    )";

    if ($mysqli->query($sql) === false) {
        echo "Error creating `schedule` table: " . $mysqli->error;
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `ticket_invoice`(
        `invoice_id` INT AUTO_INCREMENT,
        `scheduled_trips_id` INT NOT NULL,
        `user_id` INT NOT NULL,
        `qty` INT NOT NULL,
        `payment_type` TEXT NOT NULL,
        `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0= unpaid , 1= paid',
        `paymentRef` TEXT NOT NULL,
        `total_price` TEXT NOT NULL,
        `transition_no` TEXT NOT NULL,
        `created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(`invoice_id`),
        FOREIGN KEY (`scheduled_trips_id`) REFERENCES `scheduled_trips`(`scheduled_trips_id`) ,
        FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`)

    )";
    if ($mysqli->query($sql) === false) {
        echo "Error creating `ticket_invoice` table: " . $mysqli->error;
        return false;
    }

}

create_db($mysqli);
select_db($mysqli);
create_tables($mysqli);


?>