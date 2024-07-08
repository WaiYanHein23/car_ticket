<?php

function save_location($mysqli,$city_name){
    $sql="INSERT INTO `trip_location`(`city_name`,`status`) VALUES('$city_name',true)";
if($mysqli->query($sql)){
    return true;
}else{
    return false;
}

}

function get_all_location($mysqli){
    $sql="SELECT * FROM `trip_location`";
    $result=$mysqli->query($sql);
    return $result;
}

function update_location($mysqli,$trip_location_id,$city_name){

    $sql="UPDATE `trip_location` SET `trip_location_id`='$trip_location_id', `city_name`='$city_name' WHERE `trip_location_id`=$trip_location_id";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }

}




function delete_location($mysqli,$trip_location_id){
    $sql="DELETE FROM  `trip_location` WHERE `trip_location_id`='$trip_location_id'";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }
}

?>