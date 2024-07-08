<?php
require_once("../layouts/header.php");
require_once("../storage/database.php");
require_once("../storage/payment_method_db.php");
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
<?php require_once("../layouts/admin_navar.php")?>

 
<!-- car added -->

<?php

$payment_method_name='';
$payment_method_name_err='';
$validate=true;
$invalid="";
$success='';


if (isset($_POST['submit'])) {
    $payment_method_name= $_POST['payment_method_name'];
    if($payment_method_name===""){
        $validate=false;
        $payment_method_name_err="Payment Method can't blank";

    }


if($validate){
    $status=save_payment_method($mysqli,$payment_method_name);
    if($status){
$success="Success";
    }else{
        $invalid="Fail";
    }
}


}


if (isset($_GET["update_id"])) {
    $payment_method_id = $_GET["update_id"];
    $payment_method= get_payment_method_by_id($mysqli, $payment_method_id);
    $payment_method_name= $payment_method['payment_method_name'];
    if (isset($_POST["update"])) {
        $payment_method_name=$_POST['payment_method_name'];
         if ($payment_method_name === '') $payment_method_name_err = "Payment Method can not be blank!";
        if ($payment_method_name_err=== '' ) {
           $status =update_payment_method($mysqli,$payment_method_id,$payment_method_name);
            if ($status) {
                $success = "Payment Updated Success!";
            } else {
                $invalid = "Payment updated Fail!";
            }
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
            <div class="ms-md-auto py-2 py-md-0 m-3">
        <a href="payment.php" class="btn btn-primary btn-round me-2">Payment List</a>
    </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-6 card mt-4">
                        <div class="card-header">
                            <?php if (!isset($_GET['id'])) { ?>
                                <div class="card-title text-center fs-2">Payment Add</div>
                            <?php } else { ?>
                                <div class="card-title text-center fs-2">Payment Update</div>
                            <?php } ?>
                        </div>
                        <div class="card-body">

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Payment Method Name" name="payment_method_name" value="<?php echo $payment_method_name ?>" />
                                <label for="floatingInput">Payment Method</label>
                                <small class="text-danger"><?php echo $payment_method_name_err ?></small>
                            </div>
                            
                        </div>

                        <div class="card-action">
                        <?php if (isset($_GET['update_id'])) { ?>

                        <button name="update" class="btn btn-primary my-3">Update</button>
                        <?php } else { ?>
                        <button name="submit" class="btn btn-primary my-3">Submit</button>
                        <?php } ?>
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
