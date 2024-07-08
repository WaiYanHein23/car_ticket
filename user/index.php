<?php
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
 
 $validata=true;
 $success=false;
 $invalid=false;


?>

<style>
  #first{
          
            background-image: url("../assets/img/avatars/header.jpg");
            background-size:cover;
            background-position: center;
            height:500px;
            width: 1000px;
            background-repeat: no-repeat; 
        }

</style>
  

  <div class="row">
    <div class="col-8 ms-3" id="first">
        <h1 class="text-white text-center mt-3 align-items-center">အဝေးပြေး ကားလက်မှတ်အား မြန်ဆန်လွယ်ကူ ဝယ်ယူပါ။</h1>
        <div class="bg-dark">
    <?php 
      if(isset($_GET['page']) && !empty($_GET['page']))
        include($_GET['page'].'.php');
      ?>
  </div>
    </div>
    <div class="col-4 bg-gray">
   <div class="card p-5 m-3">
      <h1 class="text-center">Search Trip</h1>
	<!-- <form> -->
		<div class="col-md-12">
      <div class="form-group mb-2">
        <input type="hidden" class="form-control" id="id" name="id" value='<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>' required="">
        </select>
      </div>
			<div class="form-group mb-2">
				<label for="from_location" class="control-label">From</label>
				<select  name="from_location" id="from_location" class="form-select" >
					<option value="00">....</option>
          <?php
            $locations=get_all_location($mysqli);
            $i=1;
            while($location=$locations->fetch_assoc()){
              
          ?>
      
						<option  value="<?php echo $location['trip_location_id']  ?>"><?php echo $location['city_name']  ?></option>
           <?php } ?>
				</select>
        
			</div>
			
			<div class="form-group mb-2">
				<label for="to_location" class="control-label">To</label>
				<select name="to_location" id="to_location" class="form-select" >
					<option value="00">....</option>
          <?php
            $locations=get_all_location($mysqli);
            $i=1;
            while($location=$locations->fetch_assoc()){
             
          ?>
						<option value="<?php echo $location['trip_location_id'] ?>" ><?php echo $location['city_name']  ?></option>
            <?php } ?>
				</select>
        
			</div>

			<div class="form-group mb-2">
				<label for="departure_time" class="control-label">Date</label>
				<input type="date" class="datetimepicker form-control" id="departure_time" name="departure_time" value="<?php echo isset($meta['departure_time']) ? date('Y/m/d H:i',strtotime($meta['departure_time'])) : '' ?>" autocomplete="off">
			</div>

      <!-- <div class="form-group mb-2 ms-4">
        <div class="d-flex">

           <button type="button" id="seat-num-dec" class="btn btn-primary" onclick="seatDec()">-</button>
          <div><input id="seat-num" class="form-control" type="text" value="2"></div>
          <button type="button" id="seat-num-inc" class="btn btn-primary" onclick="seatInc()">+</button>
          
        </div>
      </div> -->

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
<div class="row" id="header" >
 
<?php
       $results = get_all_car($mysqli);
       $i = 1;
       while ($car = $results->fetch_assoc()) {
        ?>
        <div class="col-2 m-4">
    <div class="">
           <h4 class="text-center mt-1"><?php echo $car['brand'] ?></h4>
           <div  style="height: 100px;" class="text-center mb-2" >
  <img 
    style='width: 200px; height: 100px;' 
    src='data:image/jpeg;base64,<?php echo $car['image'] ?>'
  />
  </div>
  </div>
</div>
<?php
           $i++;
 } ?>
 
</div>

  <footer class="footer-section bg-dark">        
                
        <div class="row">

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

  <div class="col-4 copyright-area">
<div class="container">
   
        <div class="copyright-text">
            <p style="color: aliceblue;margin: 50px;" >Copyright &copy; 2024, All Right Reserved </p>
        </div>
    </div>
</div>

<div class="col-4 mt-2 footer-menu">
            <ul style="color: aliceblue;" class="m-2">
                <li><a href="#" style="color: white;">Home</a></li>
                <li><a href="#" style="color: white;">Terms</a></li>
                <li><a href="#" style="color: white;">Privacy</a></li>
                <li><a href="#" style="color: white;">Policy</a></li>
                <li><a href="#" style="color: white;">Contact</a></li>
            </ul>
        </div>

        </div>



 <script>

  // let seatNumInput = document.querySelector('#seat-num');

  // function seatInc(){

  //   seatNumInt = parseInt(seatNumInput.value);

  //   if(isNaN(seatNumInt)) {
  //     seatNumInt = 1;
  //   }

  //   seatNumInt++;

  //   seatNumInput.value = seatNumInt

  // }


  // function seatDec(){

  //   seatNumInt = parseInt(seatNumInput.value);

  //   if(isNaN(seatNumInt)) {
  //     seatNumInt = 1;
  //   }

  //   if(seatNumInt > 1) {
  //     seatNumInt--;
  //   }

  //   seatNumInput.value = seatNumInt

  // }

  // $('#search-btn').submit(function(e){
	// 	e.preventDefault()
	// 	var get = '';
	// 	$('input,select').each(function(){
	// 			get += '&'+$(this).attr('name')+'='+$(this).val();
	// 	})
	// 	location.replace("index.php?page=scheduled_list"+get)
		
	// })

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
</footer>
</body>
</html>