<?php

require_once("../storage/auth_user.php");
require_once("../storage/invoice_db.php");

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

        <div class="col-sm-4 ">
          <div class="card w-50 ms-5 my-5 border border-warning">
            <div class="card-body ">
              <p class="text-center text-primary"><i class="fa-regular fa-user me-2"></i>Booking User</p>

              <?php

              $total_count = get_total_count_invoice($mysqli);
              ?>
              <p class="card-text text-center"> <?php echo  $total_count['total_count'] ?> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="card w-50 ms-5 my-5 border border-warning">
            <div class="card-body">
              <h3 class="text-center text-primary"><i class="fa-solid fa-clock"></i></h3>
              <h5 class="card-title text-primary">
                Instant Booking
              </h5>
              <p class="card-text">Book your trip in less than 5 min. Instant confirmation after payment.</p>

            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="card w-50 ms-5 my-5 border border-warning">
            <div class="card-body">
              <h3 class="text-center text-primary"><i class="fa-solid fa-person-circle-question"></i></h3>
              <h5 class="text-primary text-center card-title">
                Help 24/7
              </h5>
              <p class="card-text">Our support center is available 24/7 for your questions and concerns.</p>

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