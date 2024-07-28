<?php
require_once("../storage/auth_user.php");
require_once("../storage/database.php");
require_once("../storage/schedule_db.php");
require_once("../storage/invoice_db.php");


if (!$user) {
    header("Location:../auth/login.php");
  } else {
    if (!$user['is_admin']) {
      header("Location: ../layouts/err.php");
    }
  }


$success='';
$invalid='';


if (isset($_GET["success"])) $success = $_GET["success"];
if (isset($_GET["invalid"])) $invalid = $_GET["invalid"];



if(isset($_GET['delete_id'])){
    $schedule_id=$_GET['delete_id'];
    $status=delete_invoice_by_scheduled_trips_id($mysqli,$schedule_id);
    if($status){
        $status_scheduled=delete_schedule($mysqli,$schedule_id);
        if($status_scheduled){
            $success="Delete Success";
            header("Location:../admin/schedule.php?success=$success");
        }
        
    }else{
        $invalid="Delete Fail";
        header("Location:../admin/schedule.php?invalid=$invalid");
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

 
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h6 class="op-7 mb-2 ms-2">Manage Schedule </h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <!-- <a href="../#" class="btn btn-label-info btn-round me-2">Manage</a> -->
        <a href="add_schedule.php" class="btn btn-primary btn-round me-2">Add Schedule</a>
    </div>
</div>
<div class="col-md-12">

<?php
if ($success) { ?>
    <div class="alert alert-success text-center"><?php echo $success ?></div>
<?php } ?>
<?php if ($invalid) { ?>
    <div class="alert alert-danger"><?php echo $invalid ?></div>
<?php } ?>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Schedule List</h4>
                <!-- <button class="btn btn-primary btn-round ms-auto">
                    <i class="fa fa-plus"></i>
                    
                </button> -->
            </div>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table id="add-row" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 15%">No</th>
                            <th style="width: 15%">Brand Name</th>
                            <th style="width: 15%">From Location</th>
                            <th style="width: 15%">To Location</th>
                            <th style="width: 15%">Departure Time</th>
                            <th style="width: 15%">Availability</th>
                            <th style="width: 15%">Price</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $results = get_all_schedule($mysqli);
                        $i = 1;
                        while ($schedule = $results->fetch_assoc()) {
                            $car_result=$mysqli->query("SELECT * FROM `car` WHERE `car_id`=$schedule[car_id]")->fetch_assoc();
                            $from_location=$mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$schedule[from_location]")->fetch_assoc();
                            $to_location=$mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$schedule[to_location]")->fetch_assoc();
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$car_result[brand]</td>";
                            echo "<td>$from_location[city_name]</td>"; 
                            echo "<td>$to_location[city_name]</td>"; 
                            echo "<td>$schedule[departure_time]</td>";
                            echo "<td>$schedule[availability]</td>"; 
                            echo "<td>$schedule[price]</td>";                           
                            echo "<td><a href='./add_schedule.php?update_id=$schedule[scheduled_trips_id]'><i class='fa fa-edit me-4'></i></a>";
                            echo "<a href='?delete_id=$schedule[scheduled_trips_id]'><i class='fa fa-times text-danger'></i></a></td></a>";
                            echo "</tr>";
                            $i++;
                        }
                        ?>



                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    
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