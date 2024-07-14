<?php
require_once("../layouts/header.php");
require_once("../storage/database.php");
require_once("../storage/schedule_db.php");
require_once("../storage/car_db.php");
require_once("../layouts/admin_navar.php");
require_once("../layouts/sidebar.php");
?>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- side var -->
       
        <!-- /side var -->
        <div class="layout-page">
            <!-- Layout Page -->

            <!-- car added -->

            <?php

            $car_id=$from_location=$to_location=$departure_time=$availability=$price="";
            $car_id_err=$from_location_err=$to_location_err=$departure_time_err=$availability_err=$price_err="";
           
            $invalid = "";
            $success = '';
            $validate = true;

            if (isset($_POST['submit'])) {
                $car_id = $_POST['car_id'];
               $from_location=$_POST['from_location'];
               $to_location=$_POST['to_location'];
               $departure_time=$_POST['departure_time'];
                $availability=$_POST['availability'];
                $price = $_POST['price'];
                if ($car_id === "00") {
                    $validate = false;
                    $car_id_err = "Brand can't blank";
                }

                if ($from_location === '') {
                    $validate = false;
                    $from_location_err = "From Location can't blank";
                }

                if ($to_location === '') {
                    $validate = false;
                    $to_location_err = "To Location can't blank";
                }

               

                if ($departure_time === '') {
                    $validate = false;
                    $departure_time_err = "Departure Time can't blank";
                }

               

                if ($availability === '') {
                    $validate = false;
                    $availability_err = "Availabiliry can't blank";
                }


                if ($price ==='') {
                    $validate = false;
                    $price_err = "Price can't blank";
                }

                if ($validate) {
                    $status = save_schedule($mysqli,$car_id,$from_location,$to_location,$departure_time,$availability,$price);
                    if ($status) {
                        $success = "Success";
                      
                    } else {
                        $invalid = "Fail";
                    }
                }
            }

            if (isset($_GET["update_id"])) {
                $schedule_id = $_GET["update_id"];
                $schedule = get_schedule_by_id($mysqli,$schedule_id);
                $car_id = $schedule['car_id'];
                $from_location=$schedule['from_location'];
                $to_location=$schedule['to_location'];
                $departure_time=$schedule['departure_time'];
                $availability=$schedule['availability'];
                $price = $schedule['price'];
                if (isset($_POST["update"])) {
                    $car_id=$_POST['car_id'];
                   $from_location=$_POST['from_location'];
                   $to_location=$_POST['to_location'];
                   $departure_time=$_POST['departure_time'];
                    $availability=$_POST['availability'];
                    $price = $_POST['price'];
                   
                        $status = update_schedule($mysqli,$schedule_id,$car_id,$from_location,$to_location,$departure_time,$availability,$price);
                        if ($status) {
                            $success = "Schedule Updated Success!";
                        } else {
                            $invalid = "Schedule updated Fail!";
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
                                    <a href="schedule.php" class="btn btn-primary btn-round me-2">Schedule List</a>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-6 card mt-4">
                                        <div class="card-header">
                                            <?php if (!isset($_GET['id'])) { ?>
                                                <div class="card-title text-center fs-2">Schedule Add</div>
                                            <?php } else { ?>
                                                <div class="card-title text-center fs-2">Schedule Update</div>
                                            <?php } ?>
                                        </div>
                                        <div class="card-body">

                                            <div class="form-floating form-floating-custom mb-3">
                                                
                                                <select class="form-select"  name="car_id">
                                                    <option value="00">Car ID </option>
                                                    <?php
                                                    $cars=get_all_car($mysqli);
                                                    $i=1;
                                                    while($car=$cars->fetch_assoc()){
                                                        $select='';
                                                    if($car_id==$car['car_id']) $select="selected";
                                                   
                                                    ?>
                                                    <option <?php echo $select ?> value="<?php echo $car['car_id']  ?>"><?php echo  $car['car_id'] ?></option>
                                                    <?php  } ?>
                                                </select>
                                                <small class="text-danger"><?php echo $car_id_err ?></small>
                                            </div>

                                            

                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="number" class="form-control" id="floatingInput" placeholder="From Location" name="from_location" value="<?php echo $from_location ?>" />
                                                <label for="floatingInput">From Location</label>
                                                <small class="text-danger"><?php echo $from_location_err ?></small>
                                            </div>

                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="number" class="form-control" id="floatingInput" placeholder="To Location" name="to_location" value="<?php echo $to_location ?>" />
                                                <label for="floatingInput">To Location</label>
                                                <small class="text-danger"><?php echo $to_location_err ?></small>
                                            </div>

                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="datetime-local" class="form-control" id="floatingInput" placeholder="Departure Time" name="departure_time" value="<?php echo $departure_time ?>" />
                                                <label for="floatingInput">Departure Time</label>
                                                <small class="text-danger"><?php echo $departure_time_err ?></small>
                                            </div>
                                            
                                            
                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="Availability" name="availability" value="<?php echo $availability ?>" />
                                                <label for="floatingInput">Availability</label>
                                                <small class="text-danger"><?php echo $availability_err ?></small>
                                            </div>

                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="Price" name="price" value="<?php echo $price ?>" />
                                                <label for="floatingInput">Price</label>
                                                <small class="text-danger"><?php echo $price_err ?></small>
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