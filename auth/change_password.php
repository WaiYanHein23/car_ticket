<?php
require_once("../layouts/header.php");
require_once("../storage/database.php");
require_once("../storage/auth_user.php");
require_once("../storage/user_db.php");
?>


 <!-- Layout wrapper -->
 <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
      <!-- side var -->
      <?php

      require_once("../layouts/sidebar.php");
?>
      <!-- /side var -->
<div class="layout-page">
   <!-- Layout Page -->
<?php require_once("../layouts/user_navar.php")?>

 
<!-- car added -->

<?php

$old_password=$new_password=$confirm_password='';
$old_password_err=$new_password_err=$confirm_password_err='';
$validate=true;
$invalid="";
$success='';


if (isset($_POST['submit'])) {
    $old_password=$_POST['old_password'];
    $new_password=$_POST['new_password'];
    $confirm_password=$_POST['confirm_password'];
    if($old_password===""){
        $validate=false;
        $old_password_err="Old Password can't blank";

    }

    if($new_password===""){
        $validate=false;
        $new_password_err="New Password can't blank";

    }

    if($confirm_password===""){
        $validate=false;
        $confirm_password_err="Confirm Password can't blank";

    }

$data=json_decode($_COOKIE['user'],true);

$user_id = $data['user_id'];
$username = $data['user_name'];
$email = $data['email'];
$password=$data['password'];
$ph_no = $data['ph_no'];
$address = $data['address'];
$image = $data['image'];
$math=password_verify($old_password,$data['password']);
if(!$math){
    $validate = false;
    $old_password_err = "Your old password is incorrect.";
}

if($new_password !== $confirm_password){
    $validate=false;
    $invalid="Password must be same";
}
   

if($validate){
    $password_hash=password_hash($new_password,PASSWORD_DEFAULT);
    $result = update_user($mysqli,$user_id,$username,$email,$password_hash,$ph_no,$address,$image);
    if($result){
        $success="Passwod Change Success";
       }else{
        $invalid="Password Change Fail";
       }

}


}






?>
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
                           
                                <div class="card-title text-center fs-2">Change Password</div>
                            
                        </div>
                        <div class="card-body">

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="password" class="form-control" id="floatingInput" placeholder="Old Password" name="old_password" value="<?php echo $old_password ?>" />
                                <label for="floatingInput">Old Password</label>
                                <small class="text-danger"><?php echo $old_password_err ?></small>
                            </div>

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="password" class="form-control" id="floatingInput" placeholder="New Password" name="new_password" value="<?php echo $new_password ?>" />
                                <label for="floatingInput">New Password</label>
                                <small class="text-danger"><?php echo $new_password_err ?></small>
                            </div>

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="password" class="form-control" id="floatingInput" placeholder="Confirm Password" name="confirm password" value="<?php echo $confirm_password ?>" />
                                <label for="floatingInput">Confirm Password</label>
                                <small class="text-danger"><?php echo $confirm_password_err ?></small>
                            </div>
                            
                        </div>

                        <div class="card-action">
                        <button name="submit" type="submit" class="btn btn-primary my-3">change password</button>
                       
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
