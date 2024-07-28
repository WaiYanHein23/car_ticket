<?php
require_once("../storage/db_connect.php");
require_once("../storage/auth_user.php");

if (!$user) {
  header("Location:../auth/login.php");
} else {
  if ($user['is_admin']) {
    header("Location:../layouts/err.php");
  }
}

$data = json_decode($_COOKIE['user'], true);
$user_name = $data['user_name'];
$user_id=$data['user_id'];

require_once("../layouts/header.php");
require_once("../layouts/user_navar.php");

?>

   <div class="row" style="background-color: rgba(141,214,224, 0.6);min-height: 70vh;">
      <?php
    $invoice_histories=$mysqli->query("SELECT * FROM `ticket_invoice` WHERE `user_id`=$user_id");
    $invoice_histories_count=$mysqli->query("SELECT * FROM `ticket_invoice` WHERE `user_id`=$user_id");
    $count = count($invoice_histories_count->fetch_all());
    if($count==0){
      ?>
      <h1 class="p-5 text-center">No Histroy</h1>
      <?php
    }
    $i = 1;
    while ($invoice_history = $invoice_histories->fetch_assoc()) {
      $scheldule_trip_sql_result = $mysqli->query("SELECT * FROM `scheduled_trips` WHERE `scheduled_trips_id`=$invoice_history[scheduled_trips_id]");
      $scheldule_trip = $scheldule_trip_sql_result->fetch_assoc();
      $from_sql_result = $mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$scheldule_trip[from_location]");
      $to_sql_result = $mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$scheldule_trip[to_location]");
      $from = $from_sql_result->fetch_assoc();
      $to = $to_sql_result->fetch_assoc();
    ?>
      <div class="col-3 m-4 ms-5" >
        <div class="card d-block p-2 " style="background-color: rgb(204, 36, 67,0.8)">
        <h6 class="text-center fs-6"><span class="text-warning me-3">Trips:  </small> <small class="text-white"> <?php echo $from['city_name']  ?> To <?php echo $to['city_name']  ?></small></h5>
        <h5 class="text-center fs-6"><small class="text-warning me-3">References:</small>  <small class="text-white"><?php echo $invoice_history['paymentRef'] ?></small></h5>
        <h5 class="text-center fs-6"><small class="text-warning me-3">Total Seats:</small> <small class="text-white"> <?php echo $invoice_history['qty'] ?>  seats</small> </h5>
        <h5 class="text-center fs-6"><small class="text-warning me-3">Total Prices:</small><small class="text-white"> <?php echo $invoice_history['total_price'] ?> ks</small> </h5>
        <h5 class="text-center fs-6"><small class="text-warning me-3">Paid:</small> <small class="text-white"><?php echo $invoice_history['status'] ?>     (0=fail,1=success)</small></h5>
        <h5 class="text-center fs-6"><small class="text-warning me-3">Transition Number:</small> <small class="text-white"><?php echo $invoice_history['transition_no'] ?></small></h5>
        </div>
      </div>
    <?php
      $i++;
    } ?>
      </div>
    
   


<footer id="footer" class=" row footer-section bg-dark">

  <div class="row">

    <div class="col-4 mt-2 footer-menu">
      <ul style="color: aliceblue;" class="m-2 ms-5">
        <p class="mb-2 "><a href="#home" class="text-decoration-none" style="color: white;">Home</a></p>
        <p class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Terms</a></p>
        <p class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Privacy</a></p>
        <p class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Policy</a></p>
        <p class="mb-2 "><a href="#footer" class="text-decoration-none" style="color: white;">Contact</a></p>
      </ul>
    </div>

    <div class="col-4 copyright-area">
      <div class="container">

        <div class="copyright-text">
          <p style="color: aliceblue;margin: 50px;">Copyright &copy; 2024, All Right Reserved </p>
        </div>
      </div>
    </div>

    <div class="col-4 footer-widget">
      <h3 class="text-center text-white mt-3">Contact Us</h3>
      <div class="footer-social-icon">
        <div class="d-flex justify-content-center">
          <a href="https://www.facebook.com/"><i class="fab fa-facebook-f facebook-bg p-2 me-3"></i></a>
          <a href="https://www.twitter.com/"><i class="fab fa-twitter twitter-bg p-2 me-3"></i></a>
          <a href="https://www.youtube.com/"><i class="fa-brands fa-youtube p-2 me-3"></i></a>
        </div>

        <div class="subscribe-form d-flex justify-content-center me-5">
          <form style="width: 20%; margin: 20px;" action="#">
            <div class="d-flex">
              <!-- <label class="me-2 text-white" for="email">email</label> -->
              <input name="email" type="text" placeholder="email address">
            </div>
          </form>
        </div>

      </div>
    </div>

  </div>

</footer>
</body>

</html>