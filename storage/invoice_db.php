<?php
function save_invoice($mysqli, $scheduled_trips_id, $username, $qty, $status, $paymentRef, $total_price,$transition_no)
{
    $sql = "INSERT INTO `ticket_invoice`(`scheduled_trips_id`,`username`,`qty`,`status`,`paymentRef`,`total_price`,`transition_no`) VALUES('$scheduled_trips_id','$username','$qty','$status','$paymentRef','$total_price','$transition_no')";
    echo $sql;
    if ($mysqli->query($sql)) {
        return true;
    } else {
        return false;
    }
}

function get_all_invoice($mysqli)
{
    $sql = "SELECT * FROM `ticket_invoice`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_total_count_invoice($mysqli)
{
    $sql = "SELECT COUNT(*) AS `total_count` FROM `ticket_invoice`";

    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_invoice_by_id($mysqli, $id)
{
    $sql = "SELECT * FROM `ticket_invoice` WHERE `invoice_id`='$id'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}


function update_invoice($mysqli, $invoice_id, $scheduled_trips_id, $username, $qty, $status, $paymentRef, $total_price,$transition_no)
{

    $sql = "UPDATE  `ticket_invoice` SET `scheduled_trips_id`='$scheduled_trips_id',`username`='$username',`qty`='$qty',`status`='$status',`paymentRef`='$paymentRef',`total_price`='$total_price',`transition_no`=$transition_no WHERE `invoice_id`=$invoice_id";
    if ($mysqli->query($sql)) {
        return true;
    } else {
        return false;
    }

}


function delete_invoice($mysqli, $invoice_id)
{
    $sql = "DELETE FROM  `invoice` WHERE `invoice_id`='$invoice_id'";
    if ($mysqli->query($sql)) {
        return true;
    } else {
        return false;
    }
}

function get_invoice_using_ref($mysqli, $ref)
{
    $sql = "SELECT * FROM `ticket_invoice` WHERE `paymentRef`";
} 
