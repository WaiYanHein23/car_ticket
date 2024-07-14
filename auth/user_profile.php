<?php

require_once("../storage/database.php");
require_once("../storage/auth_user.php");
require_once("../storage/user_db.php");
require_once("../layouts/user_navar.php");

$username=$email=$ph_no=$address=$image="";
$username_err=$email_err=$ph_no_err=$address_err=$image_err="";
$validate=true;
$invalid="";
$success='';
$data=json_decode($_COOKIE['user'],true);
$user_id=$data['user_id'];
$username = $data['user_name'];
$email = $data['email'];
$password=$data['password'];
$ph_no = $data['ph_no'];
$address = $data['address'];
// $image = $data['image'];

if (isset($_POST['submit'])) {
    $username=$_POST['user_name'];
    $email=$_POST['email'];
    $ph_no=$_POST['ph_no'];
    $address=$_POST['address'];
    $image = $_FILES['img']['tmp_name'];
    $img_name = $_FILES['img']['name'];
    var_dump($img_name);    
    if($username===""){
        $validate=false;
        $name_err="Name can't blank";

    }

    if($email===""){
        $validate=false;
        $email_err="Email can't blank";

    }

    if($ph_no===""){
        $validate=false;
        $ph_no_err="Phone Number can't blank";

    }

    if($address===""){
        $validate=false;
        $address_err="Address can't blank";

    }

    if(!empty($img_name)){
    if (!str_contains($_FILES['img']['type'], 'image/')) {
        echo "hello";
        $validate=false;
        $img_err = "Please upload only image!";
    }
}



if($validate){
    if(!empty($img_name)) {
        $user_image=file_get_contents($image);
    $base64=base64_encode($user_image);
    $result = update_user($mysqli,$user_id,$username,$email,$password,$ph_no,$address,$base64);
    if($result){
        $success="Profile Update Success";
       // $data = get_user_by_id($mysqli,$user['user_id']);
        $users = ["user_id"=>$user['user_id'], "user_name"=>$user['user_name'], "email"=>$user['email'],"password"=> $user['password'],"ph_no"=>$user['ph_no'],"address"=>$user['address'],"is_admin"=>$user['is_admin']];
        setcookie('user', json_encode($users), time()+3600*24*7,'/');
       }else{
        $invalid="Profile Update Fail";
       }
    } else {
        $result = update_user_noimage($mysqli,$user_id,$username,$email,$password,$ph_no,$address);
        if($result){
            $success="Profile Update Success";
            $data = get_user_by_id($mysqli,$user['user_id']);
            setcookie('user', json_encode($data), time()+3600*24*7,'/');
           }else{
            $invalid="Profile Update Fail";
           }
    }
    
    

}


}
?>

<?php require_once("../layouts/header.php");?>
 <!-- Layout wrapper -->
 <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
<div class="layout-page">

 
<!-- car added -->


<?php
if ($success) { ?>
    <div class="alert alert-success text-center"><?php echo $success ?></div>
<?php } ?>
<?php if ($invalid) { ?>
    <div class="alert alert-danger"><?php echo $invalid ?></div>
<?php } ?>
<div class="row">
    <form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="row d-flex justify-content-center">
                    <div class="col-6 card mt-4">
                        <div class="card-header">
                           
                                <div class="card-title text-center fs-2">Profile</div>
                            
                        </div>
                        <div class="card-body">

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="UserName" name="user_name" value="<?php echo $username ?>" />
                                <label for="floatingInput">Name</label>
                                <small class="text-danger"><?php echo $username_err ?></small>
                            </div>
                            
                            <div class="form-floating form-floating-custom mb-3">
                                <input type="email" class="form-control" id="floatingInput" placeholder="Email" name="email" value="<?php echo $email ?>" />
                                <label for="floatingInput">Email</label>
                                <small class="text-danger"><?php echo $email_err ?></small>
                            </div>

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Address" name="address" value="<?php echo $address ?>" />
                                <label for="floatingInput">Address</label>
                                <small class="text-danger"><?php echo $address_err ?></small>
                            </div>


                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Phone Number" name="ph_no" value="<?php echo $ph_no ?>" />
                                <label for="floatingInput">Phone Number</label>
                                <small class="text-danger"><?php echo $ph_no_err ?></small>
                            </div>

                            
                            <div class="form-floating form-floating-custom mb-3">
                                <input type="file" class="form-control" id="fileInput" placeholder="Choose image" name="img" />
                                <label for="fileInput">Choose Image</label>
                                <small class="text-danger"><?php echo $image_err ?></small>
                            </div>
                        </div>

                        <div class="card-action">
                        <button name="submit" type="submit" class="btn btn-primary my-3">Update Profile</button>
                       
                            <button class="btn btn-danger">Cancel</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
   


</div>

<!-- /car added -->



        </div>
    </div>
    <!-- / Layout page -->
</div>
      </div>
    </div>
    <!-- / Layout wrapper -->


    <?php

    require_once("../layouts/footer.php");
    ?>
