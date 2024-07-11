<?php 
require_once("../storage/db_connect.php");
extract($_POST);

// $data = ' scheduled_trips_id = '.$sid.' ';
// $data .= ', name = "'.$name.'" ';
// $data .= ', qty ="'.$qty.'" ';
if(!empty($bid)){
	$data .= ', status ="'.$status.'" ';
	$update = $mysqli->query("UPDATE invoice set ".$data." where invoice_id =".$bid);
	if($update){
		echo json_encode(array('status'=> 1));
	}
	exit;
}
// $i = 1;
// $ref = '';
// while($i == 1){
// 	$ref = date('Ymd').mt_rand(1,9999);
// 	$data .= ', ref_no = "'.$ref.'" ';
// 	$chk = $mysqli->query("SELECT * FROM invoice where payment_method_id=".$ref)->num_rows;
// 	if($chk <=0)
// 		$i = 0;
// }

// echo "INSERT INTO booked set ".$data;
	// $insert = $mysqli->query("INSERT INTO invoice set ".$data);
	// if($insert){
	// 	echo json_encode(array('status'=> 1,'ref'=>$ref));
	// }
