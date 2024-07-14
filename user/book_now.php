<?php 
require_once("../storage/db_connect.php");
// extract($_GET);

$sid = isset($_GET['sid']) ? $_GET['sid'] : '';
$bid = isset($_GET['bid']) ? $_GET['bid'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$qty = isset($_GET['qty']) ? $_GET['qty'] : '';
$total_price = isset($_GET['total_price']) ? $_GET['total_price'] : '';
$ref = date('Ymd').mt_rand(1,9999);

// if(empty($bid)){
$insertQuery = $mysqli->query("INSERT INTO ticket_invoice (scheduled_trips_id, username, qty, paymentRef, total_price) VALUES ('$sid', '$name', '$qty', '$ref', '$total_price' )");

if ($insertQuery) {
	$booking_return = true;
    echo '<script>window.location.href = "index.php?status=1&ref=' . urlencode($ref) . '&total_price=' . urlencode($total_price) . '&booking_return=' . urlencode($booking_return) . '";</script>';
}
exit;
// }
// $i = 1;
// $ref = '';
// while($i == 1){
// 	$ref = date('Ymd').mt_rand(1,9999);
// 	$data .= ', payment_method_id = "'.$ref.'" ';
// 	$chk = $mysqli->query("SELECT * FROM invoice where payment_method_id=".$ref)->num_rows;
// 	if($chk <=0)
// 		$i = 0;
// }

// echo "INSERT INTO invoice set ".$data;
// 	$insert = $mysqli->query("INSERT INTO invoice set ".$data);
// 	if($insert){
// 		echo json_encode(array('status'=> 1,'ref'=>$ref));
// 	}
?>