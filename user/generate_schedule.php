<?php
include '../storage/db_connect.php';
extract($_POST);
$where = '';
if(empty($id)){
	if(!empty($from_location) || !empty($from_location) )
	$where .= " AND (s.from_location = '".$from_location."' AND s.to_location = '".$to_location."') ";

    if(!empty($departure_time)){
		$departure_time = str_replace('/', '-', $departure_time);
			$where .= " and date(s.departure_time) = '".$departure_time."'  ";
		}
}
$qry = $mysqli->query("SELECT s.*, c.brand FROM scheduled_trips s inner join car c on c.car_id = s.car_id where s.status = 1 ".$where." order by date(s.departure_time) asc");
$data = array();
while($row = $qry->fetch_assoc()){
	$from_location = $mysqli->query("SELECT trip_location_id,city_name FROM trip_location where trip_location_id = ".$row['from_location'])->fetch_array()['city_name'];
	$to_location = $mysqli->query("SELECT trip_location_id,city_name FROM trip_location where trip_location_id = ".$row['to_location'])->fetch_array()['city_name'];
	$row['bus'] = $row['brand'];
    $row['from_location'] = $from_location;
	$row['to_location'] = $to_location;
	$row['date'] = date('M d, Y',strtotime($row['departure_time']));
	$row['time'] = date('h:i A',strtotime($row['departure_time']));
	$data[]= $row;
}
echo json_encode($data);