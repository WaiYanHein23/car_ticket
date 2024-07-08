<?php
function save_seat($mysqli,$seatname){
    $sql="INSERT INTO `seat`(`seat_name`) VALUES('$seatname')";
if($mysqli->query($sql)){
    return true;
}else{
    return false;
}

}

function get_all_seat($mysqli){
    $sql="SELECT * FROM `seat`";
    $result=$mysqli->query($sql);
    return $result;
}

function get_seat_by_id($mysqli,$id){
    $sql="SELECT * FROM `seat` WHERE `seat_id`='$id'";
    $result=$mysqli->query($sql);
    return $result->fetch_assoc();
}


function update_seat($mysqli,$seat_id,$seat_name){

    $sql="UPDATE  `seat` SET `seat_name`='$seat_name' WHERE `seat_id`=$seat_id";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }

}

function delete_seat($mysqli,$seat_id){
    $sql="DELETE FROM  `seat` WHERE `seat_id`='$seat_id'";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }
}

?>