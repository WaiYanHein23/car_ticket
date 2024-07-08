<?php
function save_payment_method($mysqli,$payment_method_name){
    $sql="INSERT INTO `payment_method`(`payment_method_name`) VALUES('$payment_method_name')";
if($mysqli->query($sql)){
    return true;
}else{
    return false;
}

}

function get_all_payment_method($mysqli){
    $sql="SELECT * FROM `payment_method`";
    $result=$mysqli->query($sql);
    return $result;
}

function get_payment_method_by_id($mysqli,$id){
    $sql="SELECT * FROM `payment_method` WHERE `payment_method_id`='$id'";
    $result=$mysqli->query($sql);
    return $result->fetch_assoc();
}



function update_payment_method($mysqli,$payment_method_id,$payment_method_name){

    $sql="UPDATE  `payment_method` SET `payment_method_name`='$payment_method_name' WHERE `payment_method_id`=$payment_method_id";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }

}

function delete_payment_method($mysqli,$payment_method_id){
    $sql="DELETE FROM  `payment_method` WHERE `payment_method_id`='$payment_method_id'";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }
}

?>