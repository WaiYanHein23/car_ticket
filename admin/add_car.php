<?php
require_once("../storage/auth_user.php");
require_once("../storage/database.php");
require_once('../storage/car_db.php');


if (!$user) {
    header("Location:../auth/login.php");
  } else {
    if (!$user['is_admin']) {
      header("Location: ../layouts/err.php");
    }
 }

require_once("../layouts/header.php");
require_once("../layouts/sidebar.php");
require_once("../layouts/admin_navar.php");




?>

 <!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
<div class="layout-container">
<div class="layout-page">
<!-- Layout Page -->
 
<!-- car added -->

<?php

$brand=$plate_number=$model = $car_img = $car_img_name ="";
$brand_err=$plate_number_err=$model_err=$car_img_err=$car_img_name_err='';
$validate=true;
$invalid="";
$success='';


if (isset($_POST['submit'])) {
    $brand = $_POST['brand'];
    $plate_number = $_POST['plate_number'];
    $model = $_POST['model'];
    $car_img = $_FILES['car_img']['tmp_name'];
    $car_img_name = $_FILES['car_img']['name'];
    
    if($brand===""){
        $validate=false;
        $brand_err="Brand can't blank";

    }


if($plate_number===''){
    $validate=false;
    $plate_number_err="Plate Number can't be blank";
}

if($model===''){
    $validate=false;
    $model_err="Model can't be blank";
}

if (!str_contains($_FILES['car_img']['type'], 'image/')) {
    $validate=false;
    $car_img_err = "Please upload only image!";
}

if($validate){
    $imgData = file_get_contents($car_img);
    $base64Str = base64_encode($imgData);
    $status=save_car($mysqli,$brand,$plate_number,$model,$base64Str);
    if($status){
$success="Success";
    }else{
        $invalid="Fail";
    }
}


}


if (isset($_GET["update_id"])) {
    $car_id = $_GET["update_id"];
    $car= get_car_by_id($mysqli, $car_id);
    $brand= $car['brand'];
    $plate_number=$car['plate_number'];
    $model=$car['model'];
    $car_img=$car['image'];
    
    if (isset($_POST["update"])) {
        $brand= $_POST['brand'];
        $plate_number=$_POST['plate_number'];
        $model=$_POST['model'];
        $car_img = $_FILES['car_img']['tmp_name'];
        $imgData = file_get_contents($car_img);
        $base64Str = base64_encode($imgData);
        
        if ($brand === '') $brand_err = "Brand can not be blank!";
        if ($brand_err === '' ) {
            $status = update_car($mysqli, $car_id, $brand,$plate_number, $model,$base64Str);
            if ($status) {
                $success = "Car Updated Success!";
            } else {
                $invalid = "Car updated Fail!";
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
        <a href="car.php" class="btn btn-primary btn-round me-2">Car List</a>
    </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-6 card mt-4">
                        <div class="card-header">
                            <?php if (!isset($_GET['update_id'])) { ?>
                                <div class="card-title text-center fs-2">Car Add</div>
                            <?php } else { ?>
                                <div class="card-title text-center fs-2">Car Update</div>
                            <?php } ?>
                        </div>
                        <div class="card-body">
                            <!-- <div class="d-flex justify-content-center">
                                <div class="card justify-content-center" style="width:100px;height:100px;">
                                    <img id="base64Image" style="width:100px;height:100px;" src="<?php echo $full_path_dir; ?>">

                                </div>
                            </div> -->

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder=" Name" name="brand" value="<?php echo $brand ?>" />
                                <label for="floatingInput">Name</label>
                                <small class="text-danger"><?php echo $brand_err ?></small>
                            </div>
                            

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Plate Number" name="plate_number" value="<?php echo $plate_number ?>" />
                                <label for="floatingInput">Plate Number</label>
                                <small class="text-danger"><?php echo $plate_number_err ?></small>
                            </div>


                            <div class="form-floating form-floating-custom mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Model" name="model" value="<?php echo $model ?>" />
                                <label for="floatingInput">Model</label>
                                <small class="text-danger"><?php echo $model_err ?></small>
                            </div>

                            
                            <div class="form-floating form-floating-custom mb-3">
                                <input type="file" class="form-control" id="fileInput" placeholder="Choose image" name="car_img" />
                                <label for="fileInput">Choose Image</label>
                                <small class="text-danger"><?php echo $car_img_err ?></small>
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
