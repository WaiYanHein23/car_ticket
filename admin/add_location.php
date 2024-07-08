<?php
require_once("../layouts/header.php");
require_once("../storage/database.php");
require_once("../storage/trip_location_db.php");
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

$city_name='';
$city_name_err='';
$validate=true;
$invalid="";
$success='';


if (isset($_POST['submit'])) {
    $city_name = $_POST['city_name'];
    if($city_name===""){
        $validate=false;
        $city_name_err="City can't blank";

    }


if($validate){
    $status=save_location($mysqli,$city_name);
    if($status){
$success="Success";
    }else{
        $invalid="Fail";
    }
}


}


if (isset($_GET["update_id"])) {
    $location_id = $_GET["update_id"];
    $location= get_location_by_id($mysqli, $location_id);
    $departure_location= $location['departure_location'];
    $destination=$location['destination'];
    $price=$location['price'];
    if (isset($_POST["update"])) {
        $departure_location=$_POST['departure_location'];
       $destination=$_POST['destination'];
        $price=$_POST['price'];
         if ($departure_location === '') $departure_location_err = "Departure Location can not be blank!";
        if ($departure_location_err === '' ) {
           $status =update_location($mysqli,$location_id,$departure_location,$destination,$price);
            if ($status) {
                $success = "Location Updated Success!";
            } else {
                $invalid = "Location updated Fail!";
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
        <a href="location.php" class="btn btn-primary btn-round me-2">Location List</a>
    </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-6 card mt-4">
                        <div class="card-header">
                            <?php if (!isset($_GET['id'])) { ?>
                                <div class="card-title text-center fs-2">Location Add</div>
                            <?php } else { ?>
                                <div class="card-title text-center fs-2">Location Update</div>
                            <?php } ?>
                        </div>
                        <div class="card-body">

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="City Name" name="city_name" value="<?php $city_name ?>" />
                                <label for="floatingInput">City</label>
                                <small class="text-danger"><?php $city_name_err  ?></small>
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
