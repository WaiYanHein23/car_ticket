<?php
require_once("../storage/database.php");
require_once("../storage/trip_location_db.php");

if (!$user) {
    header("Location:../auth/login.php");
  } else {
     if (!$user['is_admin']) {
         header("Location:../layouts/err.php");
     }
  }

require_once("../layouts/header.php"); 
require_once("../layouts/sidebar.php");
require_once("../layouts/admin_navar.php")
?>
<!-- Layout wrapper -->
 <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
<div class="layout-page">
   <!-- Layout Page -->
<?php ?>

<div class="ms-md-auto py-2 py-md-0 mt-2">
        <!-- <a href="../#" class="btn btn-label-info btn-round me-2">Manage</a> -->
        <a href="location.php" class="btn btn-primary btn-round me-2">Back</a>
    </div>

    

<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $location_id = $id;
    $location = get_location_by_id($mysqli, $id);
    $departure_location = $location['departure_location'];
    $destination=$location['destination'];
   $price=$location['price'];
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
                                    <th class="text-primary">Departure Location</th>
                                    <th class="text-success"><?php echo $departure_location ?></th>
                                </tr>
                                <tr>
                                    <th class="text-primary">Destination</th>
                                    <th class="text-warning"><?php echo $destination ?></th>
                                </tr>
                                <tr>
                                    <th class="text-primary">Price</th>
                                    <th class="text-danger"><?php echo $price ?></th>
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