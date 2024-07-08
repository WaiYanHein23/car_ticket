<?php
require_once("../layouts/header.php"); 
require_once("../storage/database.php");
require_once("../storage/car_db.php");

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

<div class="ms-md-auto py-2 py-md-0 mt-2">
        <!-- <a href="../#" class="btn btn-label-info btn-round me-2">Manage</a> -->
        <a href="car.php" class="btn btn-primary btn-round me-2">Back</a>
    </div>

    

<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $car_id = $id;
    $car = get_car_by_id($mysqli, $id);
    $brand = $car['brand'];
    $plate_number=$car['plate_number'];
    $model=$car['model'];
//     $car_img = $car['car_img'];
//     $full_path_dir =  "../upload/" . $car_img;
}
?>



<div class="row">
    <div class="col-12">
        <div class="card ">
            <div class="row d-flex justify-content-center">

                <div class="col-6 card mt-4 p-5 " style="width: 40%;">
                    <div class="fs-1">
                        <a href='./car.php?id=$car[car_id]'><i class='icon-arrow-left-circle text-primary'></i></a>
                    </div>
                        <table class="table table-bordered border-primary">
                            <tbody>
                                <tr>
                                    <th class="text-primary">Brand</th>
                                    <th class="text-success"><?php echo $brand ?></th>
                                </tr>
                                <tr>
                                    <th class="text-primary">Plate Number</th>
                                    <th class="text-danger"><?php echo $plate_number ?></th>
                                </tr>
                                <tr>
                                    <th class="text-primary">Model</th>
                                    <th class="text-secondary"><?php echo $model ?></th>
                                </tr>
                               
                            </tbody>

                        </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>



</div>
</div>
 </div>
require_once("../layouts/footer.php");

?>