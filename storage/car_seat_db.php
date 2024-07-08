<?php
function save_car_seat($mysqli,$car_schedule_id,$seat_id,$invoice_id,$booking_date){
    $sql="INSERT INTO `car_seat`(`car_schedule_id`,`seat_id`,`invoice_id`,`booking_date`) VALUES('$car_schedule_id','$seat_id','$invoice_id','$booking_date')";
if($mysqli->query($sql)){
    return true;
}else{
    return false;
}

}

function get_all_car_seat($mysqli){
    $sql="SELECT * FROM `car_seat`";
    $result=$mysqli->query($sql);
    return $result;
}

function get_car_seat_by_id($mysqli,$id){
    $sql="SELECT * FROM `car_seat` WHERE `car_seat_id`='$id'";
    $result=$mysqli->query($sql);
    return $result->fetch_assoc();
}


function update_car_seat($mysqli,$car_seat_id,$car_schedule_id,$seat_id,$invoice_id,$booking_date){

    $sql="UPDATE  `car_seat` SET `car_schedule_id`=$car_schedule_id,`seat_id`='$seat_id',`invoice`='$invoice_id',`booking_date`='$booking_date' WHERE `car_seat_id`=$car_seat_id";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }

    function delete_car_seat($mysqli,$car_seat_id){
        $sql="DELETE FROM  `car_seat` WHERE `car_seat_id`='$car_seat_id'";
        if($mysqli->query($sql)){
            return true;
        }else{
            return false;
        }
    }
}

?>