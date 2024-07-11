<?php
session_start();
require_once("../storage/db_connect.php");
require_once("../layouts/header.php");
require_once("../storage/auth_user.php");
require_once("../storage/car_db.php");
require_once("../storage/trip_location_db.php");
require_once("../layouts/user_navar.php");

if (!$user) {
  header("Location:../auth/login.php");
} else {
  if ($user['is_admin']) {
    header("Location:../layouts/err.php");
  }
}

$name=$qty=$status='';
$validate=true;
$invalid=$success=false;



if(isset($_POST['submit'])){
  $name=$_POST['name'];
  $qty=$_POST['qty'];
  $status=$_POST['status'];

 

}

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
    $count = $mysqli->query("SELECT SUM(qty) as sum from invoice where scheduled_trips_id =" . $meta['scheduled_trips_id'])->fetch_array()['sum'];
  }


  if (isset($_SESSION['login_id']) && isset($_GET['id'])) {
    $invoice = $mysqli->query("SELECT * FROM invoice where invoice_id=" . $_GET['id'])->fetch_array();
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

    background-image: url("../assets/img/avatars/Bus-Electric-City.jpg");
    background-size: cover;
    background-position: center;
    height: 500px;
    width: 1000px;
    background-repeat: no-repeat;
  }
</style>


<div class="row">
  <div class="col-8 ms-3" id="first">
    <h3 class="text-white text-center mt-3 align-items-center">အဝေးပြေး ကားလက်မှတ်အား မြန်ဆန်လွယ်ကူ ဝယ်ယူပါ။</h3>
    <div class="">
      <?php
      if (!isset($_GET['booking-form'])) {
        if (isset($_GET['page']) && !empty($_GET['page'])) {
          include($_GET['page'] . '.php');
        }
      } else {
      ?>

       <div class="container text-white">
       <form method="POST">
          <div class="w-75 p-3 mx-auto rounded" style="background-color: rgba(0, 0, 0, 0.4);">
            <p><b>Bus:</b> <?php echo $car['brand'] . ' | ' . $car['plate_number'] ?></p>
            <p><b>From:</b> <?php echo $from_location['location'] ?></p>
            <p><b>To:</b> <?php echo $to_location['location'] ?></p>
            <p><b>Departure Time</b>: <?php echo date('M d,Y h:i A', strtotime($meta['departure_time'])) ?></p>
            <?php if (($count < $meta['availability'])) : ?>
              <input type="hidden" class="form-control" id="sid" name="sid" value='<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>' required="">
              <input type="hidden" class="form-control" id="sid" name="bid" value='<?php echo isset($_GET['bid']) ? $_GET['bid'] : '' ?>' required="">

              <div class="form-group mb-2 w-50">
                <label for="name" class="control-label">Name</label>
                <input type="text" class="form-control p-1" id="name" name="name" value="<?php echo isset($bmeta['name']) ? $bmeta['name'] : '' ?>">
              </div>
              <div class="form-group mb-2 w-50">
                <label for="qty" class="control-label">Quantity</label>
                <input type="number" maxlength="4" class="form-control p-1 text-right" id="qty" name="qty" value="<?php echo isset($bmeta['qty']) ? $bmeta['qty'] : '' ?>">
              </div>

              <div class="form-group mb-2 w-50">
                <label for="qty" class="control-label">Status</label>
                <select class="form-control p-1" id="status" name="status" value="<?php echo isset($bmeta['qty']) ? $bmeta['qty'] : '' ?>">
                  <option value="1" <?php echo isset($bmeta['status']) && $bmeta['status'] == 1 ? "selected" : '' ?>>Paid</option>
                  <option value="0" <?php echo isset($bmeta['status']) && $bmeta['status'] == 0 ? "selected" : '' ?>>Unpaid</option>
                </select>
              </div>

              <div class="d-flex">
                <div>
                  <button type="submit" name="submit" class="btn btn-danger me-3">Book</button>
                </div>
                <div>
                  <button type="button" id="cancel-booking-form" class="btn btn-primary">Cancel</button>
                </div>
              </div>

            <?php else : ?>
              <h3>No Available seat</h3>
           
            <?php endif; ?>
          </div>
        </form>
       </div>

      <?php } ?>
    </div>
  </div>

  
  <div class="col-4 text-white" style="background-color: rgba(125, 149,161, 0.7);">
    <div class="card p-5 m-3" style="background-color: rgba(125, 149,161, 0.7);">
      <h1 class="text-center text-white" >Search Trip</h1>
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
<h1 class="text-center">Operators</h1>
<div class="row" id="header">

  <?php
  $results = get_all_car($mysqli);
  $i = 1;
  while ($car = $results->fetch_assoc()) {
  ?>
    <div class="col-2 m-4">
      <div class="">
        <h4 class="text-center mt-1"><?php echo $car['brand'] ?></h4>
        <div style="height: 100px;" class="text-center mb-2">
          <img style='width: 200px; height: 100px;' src='data:image/jpeg;base64,<?php echo $car['image'] ?>' />
        </div>
      </div>
    </div>
  <?php
    $i++;
  } ?>

</div>

<footer class="footer-section bg-dark">

  <div class="row">

    <div class="col-4 mt-2 footer-menu">
      <ul style="color: aliceblue;" class="m-2">
        <li class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Home</a></li>
        <li class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Terms</a></li>
        <li class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Privacy</a></li>
        <li class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Policy</a></li>
        <li class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Contact</a></li>
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
      // window.location.href ='customer_book.php?id=' + id;
      window.location.href = 'index.php?page=scheduled_list&id=&from_location=1&to_location=2&departure_time=&email=';
    });


  //   	document.getElementById('book_btn').addEventListener('click', function(e) {
  //     e.preventDefault();
  //     var get = '';
      
  //     var elements = document.querySelectorAll('input, select');
  //     elements.forEach(function(element) {
  //         get += '&' + element.name + '=' + encodeURIComponent(element.value);
  //     });

  //     location.href = "index.php?page=book_now" + get;
  //  });


	//  $('.datetimepicker').datetimepicker({
	//     format:'Y/m/d H:i',
	//     startDate: '+3d'
	// });

  

  // $('#manage_book').submit(function(e){
	// 	e.preventDefault()
	// 	start_load()
	// 	$.ajax({
	// 		url:'./book_now.php',
	// 		method:'POST',
	// 		data:$(this).serialize(),
	// 		error:err=>{
	// 			console.log(err)
  //   			end_load()
  //   			alert_toast('An error occured','danger');
	// 		},
	// 		success:function(resp){
	// 			resp = JSON.parse(resp)
	// 			if(resp.status == 1){
  //   				end_load()
  //   				$('.modal').modal('hide')
  //   				alert_toast('Data successfully saved','success');
  //   				if('<?php echo !isset($_SESSION['login_id']) ?>' == 1){
  //   				$('#book_modal .modal-body').html('<div class="text-center"><p><strong><h3>'+resp.ref+'</h3></strong></p><small>Reference Number</small><br/><small>Copy or Capture your Reference number </small></div>')
  //   				$('#book_modal').modal('show')
  //   				}else{
  //   					load_booked();
  //   				}
	// 			}
	// 		}
	// 	})
	// })

  </script>
  
</footer>
</body>

</html>