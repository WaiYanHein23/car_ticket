<?php
require_once("../storage/auth_user.php");
require_once("../storage/database.php");
require_once('../storage/invoice_db.php');
require_once('../storage/user_db.php');
require_once('../storage/schedule_db.php');


if (!$user) {
    header("Location:../auth/login.php");
  } else {
    if (!$user['is_admin']) {
      header("Location: ../layouts/err.php");
    }
  }

require_once("../layouts/header.php");
require_once("../layouts/admin_navar.php");
require_once("../layouts/sidebar.php");
?>


 <!-- Layout wrapper -->
 <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
<div class="layout-page">
   <!-- Layout Page -->

 

<?php

$validate=true;
$invalid="";
$success='';


$scheduled_trips_id=$user_id=$qty=$status=$refNo=$totalPrice=$transition_no="";

if (isset($_GET["update_id"])) {
    $invoice_id = $_GET["update_id"];
    $invoice= get_invoice_by_id($mysqli,$invoice_id);
    $scheduled_trips_id=$invoice['scheduled_trips_id'];
    $scheldule_trip_sql_result = $mysqli->query("SELECT * FROM `scheduled_trips` WHERE `scheduled_trips_id`=$invoice[scheduled_trips_id]")->fetch_assoc();
    $from_sql_result = $mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$scheldule_trip_sql_result[from_location]")->fetch_assoc();
    $to_sql_result = $mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$scheldule_trip_sql_result[to_location]")->fetch_assoc();
    $user = $mysqli->query("SELECT * FROM `user` WHERE `user_id`=$invoice[user_id]")->fetch_assoc();
    $user_id=$invoice['user_id'];
    $qty=$invoice['qty'];
    $status=$invoice['status'];
    $refNo=$invoice['paymentRef'];
    $total_price=$invoice['total_price'];
    $transition_no=$invoice['transition_no'];
    
    
    if (isset($_POST["update"])) {
        $scheduled_trips_id= $_POST['scheduled_trips_id'];
        $user_id=$_POST['user_id'];
        $qty=$_POST['qty'];
        $status=$_POST['status'];
        $refNo=$_POST['references_no'];
        $total_price=$_POST['total_price'];
        $transition_no=$_POST['transition_no'];
    
            $status = update_invoice($mysqli,$invoice_id,$scheduled_trips_id,$user_id,$qty,$status,$refNo,$total_price,$transition_no);
            if ($status) {
                $success = "Invoice Updated Success!";
            } else {
                $invalid = "Invoice updated Fail!";
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
        <a href="index.php" class="btn btn-primary btn-round me-2">Invoice List</a>
    </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-6 card mt-4 ">
                        <div class="card-header">
                                <div class="card-title text-center fs-2">Invoice Update</div>
                        </div>
                        <div class="card-body ">

                            <div class="form-floating form-floating-custom mb-3">
                                <select class="form-select"  name="scheduled_trips_id">
                                                    <option value="00">Scheduled Trips</option>
                                                    <?php
                                                    $schedules=get_all_schedule($mysqli);
                                                    $i=1;
                                                    while($scheduled=$schedules->fetch_assoc()){                         
                                                        $from_sql_result = $mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$scheduled[from_location]")->fetch_assoc();
                                                         $to_sql_result = $mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$scheduled[to_location]")->fetch_assoc();
                                                        $select='';
                                                    if($scheduled_trips_id==$scheduled['scheduled_trips_id']) $select="selected";
                                                   
                                                    ?>
                                                    <option value="<?php echo $scheduled['scheduled_trips_id']  ?>"><?php echo $from_sql_result['city_name'] .' To '. $to_sql_result['city_name']; ?></option>
                                                    <?php  } ?>
                                </select>


                            </div>
                            

                            <div class="form-floating form-floating-custom mb-3">


                                <select class="form-select"  name="user_id">
                                                    <option value="00">User Name </option>
                                                    <?php
                                                    $users=total_user($mysqli);
                                                    $i=1;
                                                    while($user=$users->fetch_assoc()){
                                                        $select='';
                                                    if($user_id==$car['user_id']) $select="selected";
                                                   
                                                    ?>
                                                    <option <?php echo $select ?> value="<?php echo $user['user_id']  ?>"><?php echo  $user['user_name'] ?></option>
                                                    <?php  } ?>
                             </select>


                            </div>


                            <div class="form-floating form-floating-custom mb-3">
                                <input type="number" class="form-control" id="floatingInput" placeholder="QTY" name="qty" value="<?php echo $qty ?>" />
                                <label for="floatingInput">Quality</label>
                            </div>

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="number" class="form-control" id="floatingInput" placeholder="Status" name="status" value="<?php echo $status ?>" />
                                <label for="floatingInput">Status</label>
                            </div>

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="number" class="form-control" id="floatingInput" placeholder="References Number" name="references_no" value="<?php echo $refNo ?>" />
                                <label for="floatingInput">References Number</label>
                            </div>

                            <div class="form-floating form-floating-custom mb-3">
                                <input type="number" class="form-control" id="floatingInput" placeholder="Total Price" name="total_price" value="<?php echo $total_price ?>" />
                                <label for="floatingInput">Total Price</label>
                            </div>


                            <div class="form-floating form-floating-custom mb-3">
                                <input type="number" class="form-control" id="floatingInput" placeholder="Transition Number" name="transition_no" value="<?php echo $transition_no ?>" />
                                <label for="floatingInput">Transition No</label>
                            </div>

                            
                        </div>

                        <div class="card-action">
                        <?php if (isset($_GET['update_id'])) { ?>

                        <button name="update" class="btn btn-primary my-3">Update</button>
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
