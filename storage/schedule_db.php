<?php
function save_schedule($mysqli,$car_id,$from_location,$to_location,$departure_time,$status,$availability,$price){
    $sql="INSERT INTO `scheduled_trips`(`car_id`,`from_location`,`to_location`,`departure_time`,`status`,`availability`,`price`) VALUES('$car_id','$from_location','$to_location','$departure_time','$status','$availability','$price')";
if($mysqli->query($sql)){
    return true;
}else{
    return false;
}

}

function get_all_schedule($mysqli){
    $sql="SELECT * FROM `scheduled_trips`";
    $result=$mysqli->query($sql);
    return $result;
}

function get_schedule_by_id($mysqli,$id){
    $sql="SELECT * FROM `scheduled_trips` WHERE `scheduled_trips_id`='$id'";
    $result=$mysqli->query($sql);
    return $result->fetch_assoc();
}



function update_schedule($mysqli,$schedule_id,$car_id,$from_location,$to_location,$departure_time,$status,$availability,$price){

    $sql="UPDATE  `scheduled_trips` SET `car_id`=$car_id,`from_location`='$from_location',`to_location`='$to_location',`departure_time`='$departure_time',`status`='$status',`availability`='$availability',`price`='$price' WHERE `scheduled_trips_id`=$schedule_id";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }
}

function delete_schedule_by_location_id($mysqli,$id){
    $sql="DELETE  FROM `scheduled_trips` WHERE `from_location` or `to_location`='$id'";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }
}


function delete_schedule($mysqli,$schedule_id){
    $sql="DELETE FROM  `scheduled_trips` WHERE `scheduled_trips_id`='$schedule_id'";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }
}
?>