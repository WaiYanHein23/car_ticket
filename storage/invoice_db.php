<?php
function save_invoice($mysqli,$payment_method_id,$scheduled_trips_id,$user_id,$qty,$status,$total_price){
    $sql="INSERT INTO `invoice`(`payment_method_id`,`scheduled_trips_id`,`user_id`,`qty`,`status`,`total_price`) VALUES('$payment_method_id','$scheduled_trips_id','$user_id','$qty','$status','$total_price')";
    echo $sql;
if($mysqli->query($sql)){
    return true;
}else{
    return false;
}

}

function get_all_invoice($mysqli){
    $sql="SELECT * FROM `invoice`";
    $result=$mysqli->query($sql);
    return $result;
}

function get_invoice_by_id($mysqli,$id){
    $sql="SELECT * FROM `invoice` WHERE `invoice_id`='$id'";
    $result=$mysqli->query($sql);
    return $result->fetch_assoc();
}


function update_invoice($mysqli,$invoice_id,$payment_method_id,$user_id,$status,$total_price){

    $sql="UPDATE  `invoice` SET `payment_method_id`=$payment_method_id,`user_id`='$user_id',`status`='$status',`total_price`='$total_price' WHERE `invoice_id`=$invoice_id";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }

    function delete_invoice($mysqli,$invoice_id){
        $sql="DELETE FROM  `invoice` WHERE `invoice_id`='$invoice_id'";
        if($mysqli->query($sql)){
            return true;
        }else{
            return false;
        }
    }
}

?>