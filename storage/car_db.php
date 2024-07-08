<?php
function save_car($mysqli, $brand,$plate_number, $model, $car_img)
{
    $sql = "INSERT INTO `car`(`brand`,`plate_number`,`model`,`image`) VALUES('$brand','$plate_number','$model','$car_img')";
    if ($mysqli->query($sql)) {
        return true;
    } else {
        return false;
    }
}

function get_all_car($mysqli)
{
    $sql = "SELECT * FROM `car`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_car_by_id($mysqli, $car_id)
{
    $sql = "SELECT * FROM `car` WHERE `car_id`='$car_id'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}


function update_car($mysqli, $car_id, $brand,$plate_number, $model, $car_img)
{

    $sql = "UPDATE  `car` SET `car_id`=$car_id,`brand`='$brand',`plate_number`='$plate_number',`model`='$model',`image`='$car_img' WHERE `car_id`='$car_id'";
    if ($mysqli->query($sql)) {
        return true;
    } else {
        return false;
    }
}
function delete_car($mysqli, $car_id)
{
    $sql = "DELETE FROM  `car` WHERE `car_id`='$car_id'";
    if ($mysqli->query($sql)) {
        return true;
    } else {
        return false;
    }
}
