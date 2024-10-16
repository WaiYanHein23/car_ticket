<?php 
require_once("../storage/db_connect.php");

$sid = isset($_GET['sid']) ? $_GET['sid'] : '';
$bid = isset($_GET['bid']) ? $_GET['bid'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$qty = isset($_GET['qty']) ? $_GET['qty'] : '';
$payment_type = isset($_GET['payment_type']) ? $_GET['payment_type'] : '';
$transition_no=isset($_GET['transition_no']) ? $_GET['transition_no']:'';
$total_price = isset($_GET['total_price']) ? $_GET['total_price'] : '';
$ref = date('Ymd').str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

?>



<?php

 $insertQuery = $mysqli->query("INSERT INTO ticket_invoice (scheduled_trips_id, user_id, qty,	payment_type, paymentRef, total_price,transition_no) VALUES ('$sid', '$name', '$qty','$payment_type', '$ref', '$total_price','$transition_no' )");

 if ($insertQuery) {
 	$booking_return = true;
     echo '<script>window.location.href = "index.php?status=1&ref=' . urlencode($ref) .'&qty='. urldecode($qty) . '&payment_type=' . urlencode($payment_type) . '&transition_no='.urldecode($transition_no).'&total_price=' . urlencode($total_price) . '&booking_return=' . urlencode($booking_return) . '";</script>';
 }
 exit; 

 ?> 

