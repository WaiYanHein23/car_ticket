<?php
// session_start();
require_once("../layouts/header.php");
// require_once("../user/index.php");
require_once("../storage/db_connect.php");
if(isset($_GET['id']) && !empty($_GET['id']) ){
	$qry = $mysqli->query("SELECT * FROM scheduled_trips where scheduled_trips_id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $val){
		$meta[$k] =  $val;
		
	}
	
$car = $mysqli->query("SELECT * FROM car where car_id = ".$meta['car_id'])->fetch_array();
$from_location = $mysqli->query("SELECT trip_location_id,Concat(city_name) as location FROM trip_location where trip_location_id =".$meta['from_location'])->fetch_array();
$to_location = $mysqli->query("SELECT trip_location_id,Concat(city_name) as location FROM trip_location where trip_location_id =".$meta['to_location'])->fetch_array();
$count = $mysqli->query("SELECT SUM(qty) as sum from invoice where scheduled_trips_id =".$meta['scheduled_trips_id'])->fetch_array()['sum'];
 }
 

if(isset($_SESSION['login_id']) && isset($_GET['id'])){
	$invoice = $mysqli->query("SELECT * FROM invoice where invoice_id=".$_GET['id'])->fetch_array();
	foreach($invoice as $k => $val){
		$bmeta[$k] =  $val;
	}
}

?>

<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"> -->
	  <form id="bg-gray manage_book">
		<div class="col-md-12">
			<p><b>Bus:</b> <?php echo $car['brand'] . ' | '.$car['plate_number'] ?></p>
			<p><b>From:</b> <?php echo $from_location['location'] ?></p>
			<p><b>To:</b> <?php echo $to_location['location'] ?></p>
			<p><b>Departure Time</b>: <?php echo date('M d,Y h:i A',strtotime($meta['departure_time'])) ?></p>
			<?php if(($count < $meta['availability']) ): ?>
			<input type="hidden" class="form-control" id="sid" name="sid" value='<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>' required="">
			<input type="hidden" class="form-control" id="sid" name="bid" value='<?php echo isset($_GET['bid']) ? $_GET['bid'] : '' ?>' required="">
			
			<div class="form-group mb-2">
				<label for="name" class="control-label">Name</label>
				<input type="text" class="form-control" id="name" name="name" value="<?php echo isset($bmeta['name']) ? $bmeta['name'] : '' ?>">
			</div>
			<div class="form-group mb-2">
				<label for="qty" class="control-label">Quantity</label>
				<input type="number" maxlength="4" class="form-control text-right" id="qty" name="qty" value="<?php echo isset($bmeta['qty']) ? $bmeta['qty'] : '' ?>">
			</div>
			
			<div class="form-group mb-2">
				<label for="qty" class="control-label">Status</label>
				<select  class="form-control" id="status" name="status" value="<?php echo isset($bmeta['qty']) ? $bmeta['qty'] : '' ?>">
					<option value="1" <?php echo isset($bmeta['status']) && $bmeta['status'] == 1 ? "selected" : '' ?>>Paid</option>
					<option value="0" <?php echo isset($bmeta['status']) && $bmeta['status'] == 0 ? "selected" : '' ?>>Unpaid</option>
				</select>
			</div>

			<div class="d-flex">
			<div>
				<button id="book_btn" class="btn btn-danger me-3">Book</button>
			</div>
			<div>
				<button class="btn btn-primary">Cancel</button>
			</div>
			</div>

			<?php else: ?>
			<h3>No Available seat</h3>
			<!-- <style>
				.uni_modal .modal-footer{
					display: none;
				}
			</style> -->
			<?php endif; ?>
		</div>
	</form>
	  <div>
</div>
      </div>
    </div>
  </div>
</div>

<script>
	$('#book_btn').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'./book_now.php',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
    			end_load()
    			alert_toast('An error occured','danger');
			},
			success:function(resp){
				resp = JSON.parse(resp)
				if(resp.status == 1){
    				end_load()
    				$('.modal').modal('hide')
    				alert_toast('Data successfully saved','success');
    				if('<?php echo !isset($_SESSION['login_id']) ?>' == 1){
    				$('#book_modal .modal-body').html('<div class="text-center"><p><strong><h3>'+resp.ref+'</h3></strong></p><small>Reference Number</small><br/><small>Copy or Capture your Reference number </small></div>')
    				$('#book_modal').modal('show')
    				}else{
    					load_booked();
    				}
				}
			}
		})
	})



// 	document.getElementById('book_btn').addEventListener('click', function(e) {
//       e.preventDefault();
//       var get = '';
      
//       var elements = document.querySelectorAll('input, select');
//       elements.forEach(function(element) {
//           get += '&' + element.name + '=' + encodeURIComponent(element.value);
//       });

//       location.href = "index.php?page=scheduled_list" + get;
//   });


	// $('.datetimepicker').datetimepicker({
	//     format:'Y/m/d H:i',
	//     startDate: '+3d'
	// });
</script>