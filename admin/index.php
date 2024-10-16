<?php

require_once("../storage/auth_user.php");
require_once("../storage/invoice_db.php");
require_once("../storage/car_db.php");

require_once("../storage/database.php");



if (!$user) {
  header("Location:../auth/login.php");
} else {
  if (!$user['is_admin']) {
    header("Location: ../layouts/err.php");
  }
}




if(isset($_GET['delete_id'])){
    $invoice_id=$_GET['delete_id'];
    $status=delete_invoice($mysqli,$invoice_id);
    if($status){
        $success="Delete Success";
        header("Location:../admin/index.php?success=$success");
    }else{
        $invalid="Delete Fail";
        header("Location:../admin/index.php?invalid=$invalid");
    }
}

// paid unpaid
if(isset($_POST['unpaid'])){
  $invoice_id = $_POST['invoice_id'];
  $update_invoice_status = update_invoice_status($mysqli,$invoice_id);
  if($update_invoice_status){
    header("Location:../admin/index.php");
  }
}

require_once("../layouts/header.php");
require_once("../layouts/sidebar.php");
require_once("../layouts/admin_navar.php");
?>




<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar mb-3" style="background-color: rgba(141,214,224, 0.6);min-height: 70vh;">
  <div class="layout-container">

    <div class="layout-page">
      <!-- Layout Page -->
      <div class="row " id="card">

      <!-- <div class="col-md-3 ">
          <div class="card w-75 ms-5 my-5 border border-warning">
            <div class="card-body">
              <p class="text-center"><i class="fa-regular fa-user me-2"></i> Admin</p>
             <?php
              $totalAdmin=get_total_count_admin($mysqli);
             ?>
             <p class="card-text text-center">Total :  <?php  echo $totalAdmin['total_count']    ?></p>
            </div>
          </div>
        </div> -->

        <div class="col-md-4 ">
          <div class="card  w-75 ms-5 my-5 border border-warning">
            <div class="card-body">
              <p class="text-center text-primary"><i class="fa-regular fa-user me-2 bg-success p-3 rounded-circle"></i>User</p>
              
             <?php
              $authUser=get_total_count_user($mysqli);
              ?>
              <p class="card-text text-center"><?php echo $authUser['total_count']  ?></p>
              
            </div>
          </div>
        </div>


        <div class="col-md-4">
          <div class="card w-75 ms-5  my-5 border border-warning">
            <div class="card-body">
              <p class="text-center text-primary"><i class="fa-regular fa-user me-2 bg-warning p-3 rounded-circle"></i>Booking User</p>

              <?php

              $total_count = get_total_count_invoice($mysqli);
              ?>
              <p class="card-text text-center">  <?php echo  $total_count['total_count'] ?> </p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card w-75 ms-3 my-5 border border-warning">
            <div class="card-body ">
              <p class="text-center text-primary"><i class="fa-solid fa-bus bg-success p-3 rounded-circle"></i> Car</p>

              <?php

              $total_count = get_total_count_car($mysqli);
              ?>
              <p class="card-text text-center"> <?php echo  $total_count['total_count'] ?> </p>
            </div>
          </div>
        </div>


 <!-- Expense Overview -->
 
 <div class="text-center col-lg-6 order-1  ms-5 bg-danger " >
                  <div class="card h-100">
                    <div class="card-header">
                      <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                          <button
                            type="button"
                            class=" nav-link active  "
                           
                          >
                            Income
                          </button>
                        </li>
                       
                      </ul>
                    </div>
                    <div class="card-body px-0">
                      <div class="tab-content p-0">
                        <div class="row d-flex tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                          <!-- Income Month -->
                          <div class="col-6  p-3  border border-1 border-warning ">
                            <div class="avatar flex-shrink-0 me-3 ">
                              <img src="../assets/img/icons/unicons/wallet.png" alt="User" />
                            </div>
                            <div>
                              <h6 class="d-block bg-warning w-75 p-2">Total Price In Per Month</h6>
                              <div class="d-flex align-items-center">
                              
                                <?php
                                $total_price=get_total_price_invoice($mysqli);

                                ?>
                                <table class="table table-striped ">
                                  <tr>
                                    <th class="text-danger">Month</th>
                                    <th class="text-danger">Total</th>
                                  </tr>
                                  
                                  <?php
                          // Assuming $total_prices is a result set from a database query
                           foreach ( $total_price as $x){ ?>
                              <tr>
                                  <td><?php echo htmlspecialchars($x['created_date']); ?></td>
                                  <td><?php echo htmlspecialchars($x['total_price']); ?> ks</td>
                              </tr>
                              
                          <?php } ?>
                                 

                                </table>
                                
                              </div>
                            </div>
                          </div>
                      <!-- Income Day -->
                          <div class="col-6 p-3  border border-1 border-warning">
                            <div class="avatar flex-shrink-0 me-3 ">
                              <img src="../assets/img/icons/unicons/wallet.png" alt="User" />
                            </div>
                            <div >
                              <h6 class="d-block bg-warning w-75 p-2">Total Price In Per Day</h6>
                              <div class="d-flex align-items-center">
                              
                                <?php
                                $total_price=get_total_price_invoice_per_day($mysqli);

                                ?>
                                <table class="table table-striped ">
                                  <tr>
                                    <th class="text-danger">Day</th>
                                    <th class="text-danger">Total</th>
                                  </tr>
                                  
                                  <?php
                          // Assuming $total_prices is a result set from a database query
                           foreach ( $total_price as $x){ ?>
                              <tr>
                                  <td><?php echo htmlspecialchars($x['created_date']); ?></td>
                                  <td><?php echo htmlspecialchars($x['total_price']); ?> ks</td>
                              </tr>
                              
                          <?php } ?>
                                 

                                </table>
                                
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Expense Overview -->


      </div>

      <!-- / Layout page -->
    </div>


  </div>

  
</div>



<!-- / Layout wrapper -->

<div class="layout-page">
   <!-- Layout Page -->
   <div class="card w-100"  style="background-color: rgb(37, 184,200,.5)">
        <div class="card-header">
            <div class="d-flex align-items-center"  style="background-color: rgb(41,198,41)">
                <h4 class="card-title p-3 text-dark">Booking List</h4>
                <!-- <button class="btn btn-primary btn-round ms-auto">
                    <i class="fa fa-plus"></i>
                    
                </button> -->
            </div>
        </div>
        <div class="card-body" >

            <div class="table-responsive " >
                <table id="add-row" class="display table table-striped table-hover " >
                    <thead class="">
                        <tr class="">
                            <th class="text-danger" style="width: 15%">No</th>
                            <th class="text-danger" style="width: 15%">Trips</th>
                            <th class="text-danger" style="width: 15%">User Name</th>
                            <th class="text-danger" style="width: 15%">Quality</th>
                            <th class="text-danger" style="width: 15%">Payment Type</th>
                            <th class="text-danger" style="width: 10%">Status</th>
                            <th class="text-danger" style="width: 15%">Reference No</th>
                            <th class="text-danger" style="width: 15%">Total Price</th>
                            <th class="text-danger" style="width: 15%">Transition No</th>
                            <th class="text-danger" style="width: 15%">Action</th>
                        </tr>
                    </thead>

                    <tbody class="text-warning">
                      

                        <?php
                         $results = $mysqli->query("SELECT * FROM ticket_invoice");
                        $i = 1;
                        while ($invoice = $results->fetch_assoc()) {
                            $scheldule_trip_sql_result = $mysqli->query("SELECT * FROM `scheduled_trips` WHERE `scheduled_trips_id`=$invoice[scheduled_trips_id]")->fetch_assoc();
                            $from_sql_result = $mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$scheldule_trip_sql_result[from_location]")->fetch_assoc();
                            $to_sql_result = $mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$scheldule_trip_sql_result[to_location]")->fetch_assoc();
                            $user = $mysqli->query("SELECT * FROM `user` WHERE `user_id`=$invoice[user_id]")->fetch_assoc();
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$from_sql_result[city_name] To $to_sql_result[city_name]</td>";
                            echo "<td>$user[user_name]</td>";
                            echo "<td>$invoice[qty]</td>";
                            echo "<td>$invoice[payment_type]</td>";
                            echo "<td>";
                            if ($invoice['status'] == 1) {
                              echo "<a href='#' class='btn btn-primary btn-sm'>Paid</a>";
                          } else {
                              echo "<form method='post'>
                              <input type='hidden' name='invoice_id' value='" . $invoice['invoice_id'] . "'>
                              <button name='unpaid' class=\"btn btn-warning btn-sm\">Unpaid</button>
                                    </form>";
                          }
                          echo "</td>";
                            echo "<td>$invoice[paymentRef]</td>";
                            echo "<td>$invoice[total_price] ks</td>" ;
                            echo "<td>$invoice[transition_no]</td>";
                            echo "<td class='text-center'> <a href='./index.php?delete_id=$invoice[invoice_id]'><i class='text-center fa fa-times text-danger'></i></a></td></a>";
                            echo "</tr>";
                            $i++;
                        }
                        ?>
                        



                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Layout page -->
</div>

<!-- booking user -->



      </div>
    </div>

<?php require_once("../layouts/footer.php")  ?>;