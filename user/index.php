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
    width:px;
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
  $total_qty=isset($_GET['qty'])?$_GET['qty']:'';?>
 <div class="card w-50 ms-5 mt-5 p-2" style="background-color: rgb(71, 170, 44,0.5)" >
 <div class="card p-0">
 <h3 class="text-center bg-warning">Invoice </h3>
 </div>
 <h5 class="text-primary text-center mt-3">Reference Number:  <small class="text-white ms-3"><?php echo $ref ?></small></h5>
 <h5 class="text-primary text-center">Number of Seat :<small class="text-white ms-3"><?php echo $total_qty  ?> seat</small></h5>
  <h5 class="text-primary text-center">Total Price: <small class="text-white ms-3"><?php echo $total_booked_price  ?> ks</small></h5>
  <h4 class="text-danger text-center">Copy or Capture your Reference number</h4>
</div>
<?php } ?>
   </div>
<!-- /booking_Return -->

    <div class="" >

      <?php
      if (!isset($_GET['booking-form'])) {
        if (isset($_GET['page']) && !empty($_GET['page'])) {
          include($_GET['page'] . '.php');
        }
      } else {
      ?>

        <div class="container text-white">
          <form id="manage_book"  method="POST">
            <div class="row d-flex w-75 p-4 mx-auto rounded" style="background-color: rgba(0, 0, 0, 0.4);">
             <div class="col-6"> 
              <p><b>Bus:</b> <?php echo $car['brand'] . ' | ' . $car['plate_number'] ?></p>
              <p><b>From:</b> <?php echo $from_location['location'] ?></p>
              <p><b>To:</b> <?php echo $to_location['location'] ?></p>
              <p><b>Departure Time</b>: <?php echo date('M d,Y h:i A', strtotime($meta['departure_time'])) ?></p>
             <!-- $count=>invoice_table -->
             <!-- $meta=>scheduled_table -->
              <?php if (($count < $meta['availability'])) : ?>
                <input type="hidden" class="form-control" id="sid" name="sid" value='<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>' required="">
                <input type="hidden" class="form-control" id="bid" name="bid" value='<?php echo isset($_GET['bid']) ? $_GET['bid'] : '' ?>' required="">

                <div class="form-group mb-2 w-50">
                  <label for="name" class="control-label">Name</label>
                  <input type="text" class="form-control p-1" id="name" name="name" value="<?php echo isset($bmeta['name']) ? $bmeta['name'] : '' ?>">
                </div>

                <div class="form-group mb-2 w-50">
                  <label for="qty" class="control-label">Quantity</label>
                  <input type="number" maxlength="4" class="form-control p-1 text-right" id="qty" name="qty" value="<?php echo isset($bmeta['qty']) ? $bmeta['qty'] : '' ?>">
                </div>

                <div class="form-group mb-2 w-50">
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
             <div class="card col-6 ms-5  w-25 h-25 mt-5  " style="background-color: rgba(0, 0, 0, 0.2);">
              <p class="text-primary text-center mt-3">KBZPay</p>
                <img src="../assets/img/backgrounds/payment_no.jpg" alt="" srcset="">
                <p class="mt-2 text-center">Scan QR Code</p>
             </div>
            </div>
          </form>
        </div>

      <?php } ?>
    </div>
  </div>


  <div id="home" class="col-4  text-white" style="background-color: rgba(125, 149,161, 0.6);">
    <div class="card p-5 m-4" style="background-color: rgba(125, 149,161, 0.7);">
      <h1 class="text-center text-white">Search Trip</h1>
      <!-- <form> -->
      <div class="col-md-12">
        <div class="form-group mb-2">
          <input type="hidden" class="form-control" id="id" name="id" value='<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>' required="">
          </select>
        </div>
        <div class="form-group mb-2">
          <label for="from_location" class="control-label">From</label>
          <select name="from_location" id="from_location" class="form-select">
            <option value="00">....</option>
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
            <option value="00">....</option>
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
          <label for="departure_time" class="control-label">Date</label>
          <input type="date" class="datetimepicker form-control" id="departure_time" name="departure_time" value="<?php echo isset($meta['departure_time']) ? date('Y/m/d H:i', strtotime($meta['departure_time'])) : '' ?>" autocomplete="off">
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

<div class="row" style="background-color: rgb(142, 155, 170)">
  <h1 class="text-center text-white fst-italic mt-4">Operators</h1>
  <div class="row" id="header">
    <?php
    $results = get_all_car($mysqli);
    $i = 1;
    while ($car = $results->fetch_assoc()) {
    ?>
      <div class="col-2 m-4">
        <div class="">
          <h4 class="text-center text-white mt-1"><?php echo $car['brand'] ?></h4>
          <div style="height: 100px;" class="text-center mb-5">
            <div class="card">
            <img style='width: 230px; height: 150px;' src='data:image/jpeg;base64,<?php echo $car['image'] ?>' />
            </div>
          </div>
        </div>
      </div>
    <?php
      $i++;
    } ?>

  </div>

</div>


  <div class="row " id="card" style="background-color: rgb(142, 155, 170)">
    <div class="col-sm-4 ">
      <div class="card w-50 ms-5 my-5 border border-warning">
        <div class="card-body ">
          <h3 class="text-center text-primary"><i class="fa-solid fa-bus"></i></h3>
          <h5 class="card-title text-primary">
          20+ Bus Operators
         </h5>
         <p class="card-text">Choose from 20+ major bus operators covering 100 destinations.</p>
        
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


<footer  id="footer" class=" row footer-section bg-dark">

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
      var transition_no= $('#transition_no').val();
      qty = parseInt(qty, 10);
      var price = <?php echo $price ?>;
      var total_price = qty * price;

      window.location.href = `index.php?page=book_now&sid=<?php echo $_GET['id']; ?>&bid=<?= isset($_GET['bid']) ? $_GET['bid'] : '' ?>&name=${name}&qty=${qty}&transition_no=${transition_no}&total_price=${total_price}`;
    });

  </script>

</footer>
</body>

</html>