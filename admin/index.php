<?php

require_once("../storage/auth_user.php");
require_once("../storage/invoice_db.php");
require_once("../storage/car_db.php");

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
      <div class="row " id="card">

      <div class="col-sm-3">
          <div class="card w-50 ms-5 my-5 border border-warning">
            <div class="card-body">
              <p class="text-center text-primary"><i class="fa-regular fa-user me-2"></i> Admin</p>
             <?php
              $totalAdmin=get_total_count_admin($mysqli);
             ?>
             <p class="text-center">Total Admin:  <?php  echo $totalAdmin['total_count']    ?></p>
            </div>
          </div>
        </div>

        <div class="col-sm-3">
          <div class="card w-50 ms-5 my-5 border border-warning">
            <div class="card-body">
              <p class="text-center text-primary"><i class="fa-regular fa-user me-2"></i>User</p>
              
             <?php
              $authUser=get_total_count_user($mysqli);
              ?>
              <p class="tet-center">Total User:   <?php echo $authUser['total_count']  ?></p>
              
            </div>
          </div>
        </div>


        <div class="col-sm-3">
          <div class="card w-50 ms-5 my-5 border border-warning">
            <div class="card-body ">
              <p class="text-center text-primary"><i class="fa-regular fa-user me-2"></i>Booking User</p>

              <?php

              $total_count = get_total_count_invoice($mysqli);
              ?>
              <p class="card-text text-center">Total User:  <?php echo  $total_count['total_count'] ?> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-3">
          <div class="card w-50 ms-5 my-5 border border-warning">
            <div class="card-body ">
              <p class="text-center text-primary"><i class="fa-solid fa-bus"></i> Car</p>

              <?php

              $total_count = get_total_count_car($mysqli);
              ?>
              <p class="card-text text-center">Total Car:  <?php echo  $total_count['total_count'] ?> </p>
            </div>
          </div>
        </div>

        


      </div>

      <!-- / Layout page -->
    </div>

  </div>
</div>
<!-- / Layout wrapper -->

<?php require_once("../layouts/footer.php")  ?>;