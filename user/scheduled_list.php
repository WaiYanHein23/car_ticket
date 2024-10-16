<section id="bg-bus" class="d-flex align-items-center">
<main id="main">
	<div class="container-fluid">
		<div class="col-lg-12">
			<div class="row">
				&nbsp;
			</div>
			<div class="row">
				<div class="card col-md-12"  style="background-color: rgba(47,184,204,0.5);" >
					
					<div class="card-body mx-auto rounded ">
						<table class="table table-striped table-bordered " id="schedule-field">
							<colgroup>
								<col width="5%">
								<col width="10%">
								<col width="15%">
								<col width="20%">
								<col width="10%">
								<col width="10%">
								<col width="10%">
							</colgroup>
							<thead>
								<tr>
									<th class="text-center text-danger">#</th>
									<th class="text-center text-danger">Date</th>
									<th class="text-center text-danger">Bus</th>
									<th class="text-center text-danger">Location</th>
									<th class="text-center text-danger">Departure</th>
									<th class="text-center text-danger">Availability</th>
									<th class="text-center text-danger">Price</th>
                                    <th class="text-center text-danger">Action</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</main>
</section>

<script>
    var scheduled_trips = [];
    $(document).ready(function() {
        function loadSchedule() {
            // Destroy existing DataTables instance if it exists
            if ($.fn.DataTable.isDataTable('#schedule-field')) {
                $('#schedule-field').DataTable().destroy();
            }

            $('#schedule-field tbody').html('<tr><td colspan="7" class="text-center">Please wait...</td></tr>');

            $.ajax({
                url: 'generate_schedule.php',
                method: 'POST',
                data: {
                    id: '<?php echo $_GET['id'] ?>',
                    from_location: '<?php echo $_GET['from_location'] ?>',
                    to_location: '<?php echo $_GET['to_location'] ?>',
                    departure_time: '<?php echo $_GET['departure_time'] ?>'
                },
                dataType: 'json', // Specify JSON dataType if response is JSON
                error: function(err) {
                    console.log(err);
                    // alert_toast('An error occurred.', 'danger');
                },
                success: function(resp) {
                    if (resp && typeof resp !== 'undefined') {
                        console.log(resp);
                        scheduled_trips = resp;
                        if (Object.keys(resp).length > 0) {
                            $('#schedule-field tbody').html('');
                            var i = 1;
                            Object.keys(resp).forEach(function(k) {
                                var tr = $('<tr></tr>');
                                tr.append('<td class="text-center">' + (i++) + '</td>');
                                tr.append('<td class="">' + resp[k].date + '</td>');
                                tr.append('<td class="">' + resp[k].bus + '</td>');
                                tr.append('<td class="">' + resp[k].from_location + ' - ' + resp[k].to_location + '</td>');
                                tr.append('<td>' + resp[k].time + '</td>');
                                tr.append('<td>' + resp[k].availability + '</td>');
                                tr.append('<td>' + resp[k].price + '</td>');
                                tr.append('<td><center><button class="btn btn-sm btn-danger mr-2 text-white"  id="book_now" data-id="' + resp[k].scheduled_trips_id + '"><strong>Book Now</strong></button></center></td>');
                                $('#schedule-field tbody').append(tr);
                            });
                        } else {
                            $('#schedule-field tbody').html('<tr><td colspan="7" class="text-center">No data.</td></tr>');
                        }
                    }
                },
                complete: function() {
                    $('#schedule-field').DataTable({
                        // DataTables configuration options
                    });

                    $(document).on('click', '#book_now', function() {
                        var id = $(this).data('id');
                        const sid = parseInt(id, 10);

                        //Generate the scheduled trip price
                        var selected_trip = scheduled_trips.find(trip => trip['scheduled_trips_id']);
                        const ticket_price = selected_trip['price'];
                        // window.location.href ='customer_book.php?id=' + id;
                        window.location.href =`index.php?page=scheduled_list&id=&price=${ticket_price}&from_location=<?= isset($_GET['from_location']) ? $_GET['from_location'] : '' ?>&to_location=<?= isset($_GET['to_location']) ? $_GET['to_location'] : '' ?>&departure_time=&email=&booking-form=true&id=` + id;
                    });
                }   
            });
        }

        // Initialize on document ready
        loadSchedule();

        
    });
</script>
