<?php
require_once("../layouts/header.php");
require_once("../storage/database.php");
require_once("../storage/seat_db.php");
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

$seat_name='';
$seat_name_err="";
$validate=true;
$invalid="";
$success='';


if (isset($_POST['submit'])) {
    $seat_name = $_POST['seat_name'];
    if($seat_name===""){
        $validate=false;
        $seat_name_err="Seat Name can't blank";

    }


if($validate){
    $status=save_seat($mysqli,$seat_name);
    if($status){
$success="Success";
    }else{
        $invalid="Fail";
    }
}


}


if (isset($_GET["update_id"])) {
    $seat_id = $_GET["update_id"];
    $seat= get_seat_by_id($mysqli, $seat_id);
    $seat_name= $seat['seat_name'];
    if (isset($_POST["update"])) {
        $seat_name=$_POST['seat_name'];
         if ($seat_name === '') $seat_name_err = "Seat Name can not be blank!";
        if ($seat_name_err === '' ) {
           $status =update_seat($mysqli,$seat_id,$seat_name);
           
            if ($status) {
                $success = "Seat Updated Success!";
            } else {
                $invalid = "Seat updated Fail!";
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
        <a href="seat.php" class="btn btn-primary btn-round me-2">Seat List</a>
    </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-6 card mt-4">
                        <div class="card-header">
                            <?php if (!isset($_GET['id'])) { ?>
                                <div class="card-title text-center fs-2">Seat Add</div>
                            <?php } else { ?>
                                <div class="card-title text-center fs-2">Seat Update</div>
                            <?php } ?>
                        </div>
                        <div class="card-body">

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Seat Name" name="seat_name" value="<?php echo $seat_name ?>" />
                                <label for="floatingInput">Seat Name</label>
                                <small class="text-danger"><?php echo $seat_name_err ?></small>
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
