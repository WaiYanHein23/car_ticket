<?php
function save_user($mysqli,$username,$email,$password,$address,$ph_no){
    $sql="INSERT INTO `user`(`user_name`,`email`,`password`,`address`,`ph_no`,`is_admin`) VALUES('$username','$email','$password','$address','$ph_no',false)";
if($mysqli->query($sql)){
    return true;
}else{
    return false;
}

}

function save_admin($mysqli)
{
    $password = password_hash("Admin@1234", PASSWORD_DEFAULT);
    $sql = "INSERT INTO `user`(`user_name`,`email`,`password`,`address`,`ph_no`,`is_admin`) VALUES ('admin','admin@gmail.com','$password','pyay','09445088092',true)";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
 function select_user_by_id($mysqli,$id){
    $sql="select * from user where user_id=$id";
    $user=$mysqli->query($sql);
    if($user){
        return $user->fetch_assoc();
    }
 }

function get_all_user($mysqli){
    $sql="SELECT * FROM `user`";
    $result=$mysqli->query($sql);
    return $result;
}

function get_user_by_id($mysqli,$id){
    $sql="SELECT * FROM `user` WHERE `user_id`='$id'";
    $result=$mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_user_by_email($mysqli,$email){
    $sql="SELECT * FROM `user` WHERE `email`='$email'";
    $result=$mysqli->query($sql);
    return $result->fetch_assoc();
}

function update_user($mysqli,$user_id,$username,$email,$password,$ph_no,$address,$image){

    $sql="UPDATE  `user` SET `user_name`='$username',`email`='$email',`password`='$password',`ph_no`='$ph_no',`address`='$address',`image`='$image' WHERE `user_id`='$user_id'";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }

}


// function getUserName($mysqli) {
//     $sql = "SELECT * FROM `user` WHERE `is_admin` = 0 LIMIT 1";
//     $result = $mysqli->query($sql);

//     if ($result === false) {
//         // Handle query error
//         echo "Error: " . $mysqli->error;
//         return null;
//     }

//     return $result->fetch_assoc();
// }



function get_total_count_user($mysqli){
    $sql = "SELECT COUNT(*) AS `total_count` FROM `user` WHERE `is_admin`=0";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();

}

function total_user($mysqli){
    $sql="SELECT * from `user` where `is_admin`=0";
    $result=$mysqli->query($sql);
    return $result;

}


function get_total_count_admin($mysqli){
    $sql = "SELECT COUNT(*) AS `total_count` FROM `user` WHERE `is_admin`=1";
$result = $mysqli->query($sql);
return $result->fetch_assoc();

}


function update_user_noimage($mysqli,$user_id,$username,$email,$password,$ph_no,$address){

    $sql="UPDATE  `user` SET `user_name`='$username',`email`='$email',`password`='$password',`ph_no`='$ph_no',`address`='$address' WHERE `user_id`='$user_id'";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }

}

function delete_user($mysqli,$user_id){
    $sql="DELETE FROM  `user` WHERE `user_id`='$user_id'";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }
}

?>