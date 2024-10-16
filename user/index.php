<?php
session_start();
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
$user_id = $data['user_id'];


require_once("../layouts/header.php");
require_once("../storage/car_db.php");
require_once("../storage/trip_location_db.php");
require_once("../layouts/user_navar.php");




$name = $qty = $status = '';
$validate = true;
$invalid = $success = false;





// booking form
if (isset($_GET['booking-form'])) {


  if (isset($_GET['id']) && !empty($_GET['id'])) {
    $qry = $mysqli->query("SELECT * FROM scheduled_trips where scheduled_trips_id = " . $_GET['id'])->fetch_array();
    foreach ($qry as $k => $val) {
      $meta[$k] =  $val;
    }



    $car = $mysqli->query("SELECT * FROM car where car_id = " . $meta['car_id'])->fetch_array();
    $from_location = $mysqli->query("SELECT trip_location_id,Concat(city_name) as location FROM trip_location where trip_location_id =" . $meta['from_location'])->fetch_array();
    $to_location = $mysqli->query("SELECT trip_location_id,Concat(city_name) as location FROM trip_location where trip_location_id =" . $meta['to_location'])->fetch_array();
    $departure_time = $mysqli->query("SELECT scheduled_trips_id FROM scheduled_trips where scheduled_trips_id =" . $meta['scheduled_trips_id'])->fetch_array();
    $count = $mysqli->query("SELECT SUM(qty) as sum from ticket_invoice where scheduled_trips_id =" . $meta['scheduled_trips_id'])->fetch_array()['sum'];
    $price = isset($_GET['price']) ? $_GET['price'] : '';
  }


  if (isset($_GET['bid'])) {
    $invoice = $mysqli->query("SELECT * FROM invoice where invoice_id=" . $_GET['bid'])->fetch_array();
    foreach ($invoice as $k => $val) {
      $bmeta[$k] =  $val;
    }
  }
}


$validata = true;
$success = false;
$invalid = false;


?>

<style>
  #first {

    background-image: url("../assets/img/backgrounds/Bus-Electric-City.jpg");
    background-size: cover;
    background-position: center;
    height: 500px;
    width: px;
    background-repeat: no-repeat;
  }


  #one,
  #two,
  #three {

    background-image: url("../assets/img/backgrounds/Bus-Electric-City.jpg");
    background-size: cover;
    background-position: center;
    height: 500px;
    width: px;
    background-repeat: no-repeat;

  }
</style>


<div class="row  bg-gray">
  <div class="col-8 " id="first">
    <h3 class="text-white text-center mt-3 align-items-center">အဝေးပြေး ကားလက်မှတ်အား မြန်ဆန်လွယ်ကူ ဝယ်ယူပါ။</h3>

    <!-- booking_Return   -->
    <div class="row">
      <?php
      if (isset($_GET['booking_return'])) {
        $ref = isset($_GET['ref']) ? $_GET['ref'] : '';
        $total_booked_price = isset($_GET['total_price']) ? $_GET['total_price'] : '';
        $total_qty = isset($_GET['qty']) ? $_GET['qty'] : '';
        $status = $mysqli->query("SELECT * FROM `ticket_invoice` WHERE `paymentRef` = '" . $_GET['ref'] . "'")->fetch_assoc()['status'];

      ?>



        <div class="card w-50 ms-5 mt-5 p-2" style="background-color: rgba(0, 0, 0, 0.6);">
          <div class="card p-0">
            <h3 class="text-center bg-warning">Invoice </h3>
          </div>
          <h5 class="text-primary text-center mt-3">Reference Number: <small class="text-white ms-3"><?php echo $ref ?></small></h5>
          <h5 class="text-primary text-center">Number of Seat :<small class="text-white ms-3"><?php echo $total_qty  ?> seat</small></h5>
          <h5 class="text-primary text-center">Total Price: <small class="text-white ms-3"><?php echo $total_booked_price  ?> ks</small></h5>
          <div class="container mx-5 w-75 ">

            <small class="text-danger rounded ms-4 mt-1 p-2 fs-5" style="background-color:rgb(30, 54, 170);">
              <?= !$status ? 'Please Wait....' : '' ?>
            </small>
            <small class="text-success rounded ms-3 mt-1 p-2 fs-5 w-50 mt-4" style="background-color:rgb(30, 54, 170);">
              <?= $status ? 'Successful' : '' ?>
            </small>

          </div>
          <h4 class="text-danger text-center mt-3">Copy or Capture your Reference number</h4>
        </div>
      <?php } ?>
    </div>
    <!-- /booking_Return -->

    <div class="">

      <?php
      if (!isset($_GET['booking-form'])) {
        if (isset($_GET['page']) && !empty($_GET['page'])) {
          include($_GET['page'] . '.php');
        }
      } else {
      ?>

        <div class="container text-white">
          <form id="manage_book" method="POST">
            <div class="row d-flex w-75 h-25 p-2 mx-auto rounded" style="background-color: rgba(0, 0, 0, 0.4);">
              <div class="col-6">
                <p><b>Bus:</b> <?php echo $car['brand'] . ' | ' . $car['plate_number'] ?></p>
                <p><b>From:</b> <?php echo $from_location['location'] ?></p>
                <p><b>To:</b> <?php echo $to_location['location'] ?></p>
                <p><b>Departure Time</b>: <?php echo date('M d,Y h:i A', strtotime($meta['departure_time'])) ?></p>
                <p><b>Name: <?php echo $user_name  ?></b></p>
                <!-- $count=>invoice_table -->
                <!-- $meta=>scheduled_table -->
                <?php if (($count < $meta['availability'])) : ?>
                  <input type="hidden" class="form-control" id="sid" name="sid" value='<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>' required="">
                  <input type="hidden" class="form-control" id="bid" name="bid" value='<?php echo isset($_GET['bid']) ? $_GET['bid'] : '' ?>' required="">

                  <div class="form-group mb-1 w-50">

                    <input type="hidden" disabled class="form-control p-1" id="name" name="name" value="<?php echo $user_id ?>">
                  </div>

                  <div class="form-group mb-1 w-50">
                    <label for="qty" class="control-label">Quantity</label>
                    <input type="number" maxlength="4" class="form-control p-1 text-right" id="qty" name="qty" value="<?php echo isset($bmeta['qty']) ? $bmeta['qty'] : '' ?>">
                  </div>

                  <!-- payment type -->
                  <!-- <div class="form-group mb-2 w-50">
                    <label for="payment_type" class="control-label">Payment Type</label>
                    <input type="text" class="form-control p-1 text-right" id="payment_type" name="payment_type" value="<?php echo isset($bmeta['payment_type']) ? $bmeta['payment_type'] : '' ?>" placeholder="eg.wave pay(or)kpay">
                  </div> -->

                  <!-- payment type -->
                  <label for="payment_type" class="control-label">Payment Type</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" class="payment_type" name="payment_type" value="KBZ Pay">
                    <label class="form-check-label" for="flexRadioDefault1">
                      KBZ Pay
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" class="payment_type" name="payment_type" value="Wave Pay">
                    <label class="form-check-label" for="flexRadioDefault2">
                     Wave Pay
                    </label>
                  </div>

                  <div class="form-group mb-1 w-50">
                    <label for="transition_no" class="control-label">Transition Number</label>
                    <input type="number" maxlength="4" class="form-control p-1 text-right" id="transition_no" name="transition_no" value="<?php echo isset($bmeta['transition_no']) ? $bmeta['transition_no'] : '' ?>">
                  </div>


                  <div class="d-flex">
                    <div>
                      <button type="submit" id="book_btn" name="submit" class="btn btn-danger me-3">Book</button>
                    </div>
                    <div>
                      <button type="button" id="cancel-booking-form" class="btn btn-primary">Cancel</button>
                    </div>
                  </div>

                <?php else : ?>
                  <h3 class="text-danger">No Available seat</h3>

                <?php endif; ?>
              </div>
              <div class="card col-6 " style="background-color: rgba(0, 0, 0, 0.4);">
                <div class="row d-flex justify-content-between">

                  <div>
                    <p class="text-danger text-center mt-3">You Can Pay Here</p>

                  </div>
                  <!-- modal -->
                  <!-- Button trigger modal -->
                  <div class="row">
                    <!-- kpay button -->
                    <div class="col-6">
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        KBZ PAY
                      </button>
                    </div>
                    <!-- kpay button -->

                    <!-- wave button -->
                    <div class="col-6">
                      <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#waveModal">
                        WAVEPAY
                      </button>
                      <!-- wave button -->


                    </div>
                  </div>

                  <!-- KBZ PAY -->
                  <!-- Modal -->
                  <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog w-25 h-25">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Scan to pay me</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">


                          <div class="card ">
                            <p class="text-primary text-center mt-3">KBZ Pay</p>
                            <img src="../assets/img/backgrounds/kpay.jpg" alt="" srcset="">
                            <p class="mt-2 text-center text-danger">Scan QR Code</p>

                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- modal -->
                  <!-- KBZ  PAY -->


                  <!-- WAVE PAY -->
                  <!-- Modal -->
                  <div class="modal fade" id="waveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog w-25 h-25">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5 " id="exampleModalLabel">Scan to pay me</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">


                          <div class="card" id="wave">
                            <p class="text-primary text-center mt-3">WAVE Pay</p>
                            <img src="../assets/img/backgrounds/kpay.jpg" alt="" srcset="">
                            <p class="mt-2 text-center text-danger">Scan QR Code</p>

                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- modal -->
                  <!-- WAVE  PAY -->


                </div>

              </div>


            </div>
          </form>
        </div>

      <?php } ?>
    </div>
  </div>


  <div id="home" class="col-4  text-white" style="background-color: rgba(125, 149,161, 0.6);">
    <div class="card p-5 m-4" style="background-color: rgba(255,171,0, 0.6);">
      <h1 class="text-center text-primary">Search Trip</h1>
      <!-- <form> -->
      <div class="col-md-12">
        <div class="form-group mb-2">
          <input type="hidden" class="form-control" id="id" name="id" value='<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>' required="">
          </select>
        </div>
        <div class="form-group mb-2">
          <label for="from_location" class="control-label">From </label>
          <select name="from_location" id="from_location" class="form-select">
            <option value="00">🚌 .....</option>
            <?php
            $locations = get_all_location($mysqli);
            $i = 1;
            while ($location = $locations->fetch_assoc()) {

            ?>

              <option value="<?php echo $location['trip_location_id']  ?>"><?php echo $location['city_name']  ?></option>
            <?php } ?>
          </select>

        </div>

        <div class="form-group mb-2">
          <label for="to_location" class="control-label">To</label>
          <select name="to_location" id="to_location" class="form-select">
            <option value="00">📍 .....</option>
            <?php
            $locations = get_all_location($mysqli);
            $i = 1;
            while ($location = $locations->fetch_assoc()) {

            ?>
              <option value="<?php echo $location['trip_location_id'] ?>"><?php echo $location['city_name']  ?></option>
            <?php } ?>
          </select>

        </div>

        <div class="form-group mb-2">
          <label for="departure_time" class="control-label">Date </label>
          <input type="date" class="form-control" id="departure_time" name="departure_time" value="<?php echo isset($meta['departure_time']) ? date('Y-m-d\TH:i', strtotime($meta['departure_time'])) : '' ?>" autocomplete="off">
        </div>

        <div class="card-action d-flex justify-content-center">
          <button id="search-btn" name="submit" class="btn btn-danger text-center my-3">Search Now</button>
        </div>

      </div>
      <!-- </form> -->
    </div>
  </div>
</div>
</div>

<!-- Car List -->
<div class="row" style="background-color: rgb(37, 184,200,0.5)">
  <h3 class="container bg-warning w-25 p-1 rounded-circle text-center text-primary fst-italic mt-4">Operators</h3>
  <div class="row p-5" id="header">
    <?php
    $paga = 0;
    if (isset($_GET['pag'])) {
      $paga = $_GET['pag'];
    }
    $results = get_all_car_start($mysqli, $paga);
    $i = 1;
    while ($car = $results->fetch_assoc()) {
    ?>
      <div class="col-2 my-2">
        <div class="card w-75">
          <h6 class="text-center bg-gray text-white m-0 p-1"><?php echo $car['brand'] ?></h6>

          <a href="">
            <img style='width: 100%; height: 180px;' src='data:image/jpeg;base64,<?php echo $car['image'] ?>' />
          </a>

        </div>
      </div>

    <?php
      $i++;
    } ?>


    <div class="row mt-3">

      <div class="col-10">
        <nav>
          <ul class="pagination mt-3">

            <?php
            $count = get_all_car_pag($mysqli);
            $p = 0;
            for ($i = 1; $i < $count + 1; $i++) {
            ?>

              <li class="page-item"><a class="page-link" href="?pag=<?= $p ?>"><?= $p + 1 ?></a></li>
            <?php
              $p++;
            }
            ?>

          </ul>

        </nav>

      </div>

      <div class="col-1">
        <h3 class="text-danger text-center w-25"><i class="fa-solid fa-bus"></i></h3>
      </div>



    </div>

  </div>


</div>
<!-- Car List -->

<!-- <div class="row d-flex justify-content-around" style="background-color: rgb(37, 184,200,0.5);height:400px;">
<h3 class="text-center text-primary">Popular Routes</h3>
  <div id="one" class="col-4  ms-5" style="width: 300px;height:200px">
<a href="" class="text-center mt-5 p-5"><p style="height:200px;">Yangon to Pyay</p></a>
</div>

  <div id="two" class="col-4  ms-5" style="width: 300px;height:200px" >
        <a href="" class="p-5 mt-5 text-center"><p>Yangon to Mandalay</p></a>
</div>
  <div id="three" class="col-4 ms-5" style="width: 300px;height:200px">

<a href="" class="p-5 text-center"><p>Yangon to Naypyitaw</p></a>
</div>
</div> -->


<div class="row " id="card" style="background-color: rgb(37, 184,200,0.5)">
  <div class="col-sm-4 ">
    <div class="card  w-50 ms-5 my-5  border border-warning" style="background-color:rgb(181, 177, 131)">
      <div class="card-body ">
        <h3 class="text-center text-primary"><i class="fa-solid fa-bus"></i></h3>
        <h5 class="card-title text-primary">
          20+ Bus Operators
        </h5>

        <p class="card-text text-white">Choose from 20+ major bus operators covering 50 destinations.</p>
        <div class="card mx-3">
          <a href="./aboutus.php">
            <p class="text-danger text-center mt-1 mb-2 p-0">Learn More -></p>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card w-50 ms-5 my-5 border border-warning" style="background-color:rgb(181, 177, 131)">
      <div class="card-body">
        <h3 class="text-center text-primary"><i class="fa-solid fa-clock"></i></h3>
        <h5 class="card-title text-primary">
          Instant Booking
        </h5>
        <p class="card-text text-white">Book your trip in less than 5 mins. Instant confirmation after payment.</p>

        <div class="card mx-3">
          <a href="./aboutus.php">
            <p class="text-danger text-center mt-1 mb-2 p-0">Learn More -></p>
          </a>
        </div>

      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card w-50 ms-5 my-5 border border-warning" style="background-color:rgb(181, 177, 131)">
      <div class="card-body">
        <h3 class="text-center text-primary"><i class="fa-solid fa-person-circle-question"></i></h3>
        <h5 class="text-primary text-center card-title">
          Help
        </h5>
        <p class="card-text text-white">Our support center is available for your questions and concerns.</p>

        <div class="card mx-3 p-0">
          <a href="./aboutus.php">
            <p class="text-danger text-center mt-1 mb-2 p-0">Learn More -></p>
          </a>
        </div>


      </div>
    </div>
  </div>

</div>

<div class="row" style="background-color: rgb(37, 184,200,0.5)">
  <h3 class=" card text-center text-primary " style="background-color: rgb(37, 184,200,0.2)">We Accept</h4>
    <div class="row d-flex justify-content-around">
      <div class="  col-3 ms-5 mb-3  " style="width: 130px;">
        <p class="text-center text-danger mt-1">KBZ PAY</p>
        <img class="ms-3 mb-2 ms-0" src="../assets/img/payment/kpay.webp" alt="" srcset="" style="width: 80px; height:100px;">
      </div>

      <div class="col-3 ms-5  mb-3" style="width: 130px;">
        <p class="text-center mt-1 text-danger ">WAVE PAY</p>
        <img class="ms-3 mb-1" src="../assets/img/payment/wave.webp" alt="" srcset="" style="width: 80px; height: 100px;">
      </div>
    </div>
</div>

<footer id="footer" class=" row footer-section bg-dark">

  <div class="row">

    <div class="col-4 mt-2 footer-menu">
      <ul style="color: aliceblue;" class="m-2 ms-5">
        <p class="mb-2 "><a href="#home" class="text-decoration-none" style="color: white;">Home</a></p>
        <p class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Terms</a></p>
        <p class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Privacy</a></p>
        <p class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Policy</a></p>
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

        <div class="text-white mt-3 text-center ">
          <small><i class="fa-solid fa-phone me-2"></i> 09445088092</small>



        </div>

      </div>


    </div>




  </div>



  <script>
    document.getElementById('search-btn').addEventListener('click', function(e) {
      e.preventDefault();
      var get = '';

      var elements = document.querySelectorAll('input, select');
      elements.forEach(function(element) {
        get += '&' + element.name + '=' + encodeURIComponent(element.value);
      });

      location.href = "index.php?page=scheduled_list" + get;
    });
  </script>
  <!-- Core JS
    build:js assets/vendor/js/core.js -->
  <script src="../assets/vendor/js/bootstrap.js"></script>

  <script>
    $(document).on('click', '#cancel-booking-form', function() {
      var id = $(this).data('id');
      window.location.href = 'index.php?page=scheduled_list&id=&from_location=<?= isset($_GET['from_location']) ? $_GET['from_location'] : '' ?>&to_location=<?= isset($_GET['to_location']) ? $_GET['to_location'] : '' ?>&departure_time=&email=';
    });

    document.getElementById('book_btn').addEventListener('click', function(e) {
      e.preventDefault();
      var get = '';
      var name = $('#name').val();
      var qty = $('#qty').val();
      var payment_type = $("input[name='payment_type']:checked").val();
      var transition_no = $('#transition_no').val();
      qty = parseInt(qty, 10);
      var price = <?php echo $price ?>;
      var total_price = qty * price;

      window.location.href = `index.php?page=book_now&sid=<?php echo $_GET['id']; ?>&bid=<?= isset($_GET['bid']) ? $_GET['bid'] : '' ?>&name=${name}&qty=${qty}&payment_type=${payment_type}&transition_no=${transition_no}&total_price=${total_price}`;
    });
  </script>

</footer>
</body>

</html>