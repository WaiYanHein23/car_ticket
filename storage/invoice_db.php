<?php
function save_invoice($mysqli, $scheduled_trips_id, $user_id, $qty,$payment_type, $status, $paymentRef, $total_price,$transition_no)
{
    $sql = "INSERT INTO `ticket_invoice`(`scheduled_trips_id`,`user_id`,`qty`,`payment_type`,`status`,`paymentRef`,`total_price`,`transition_no`) VALUES('$scheduled_trips_id','$user_id','$qty','$payment_type','$status','$paymentRef','$total_price','$transition_no')";
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

function get_total_price_invoice($mysqli)
{
    $sql = "SELECT MONTHNAME(created_date) as created_date, SUM(total_price) as total_price from ticket_invoice  GROUP BY MONTH (created_date)";

    $result = $mysqli->query($sql);
    return $result;
}

function get_total_price_invoice_per_day($mysqli)
{
    $sql = "SELECT DAYNAME(created_date) as created_date, SUM(total_price) as total_price from ticket_invoice  GROUP BY DAY (created_date)";

    $result = $mysqli->query($sql);
    return $result;
}

function update_invoice_status($mysqli,$invoice_id)
{
    $sql = "Update `ticket_invoice` set `status` = true where`invoice_id` = $invoice_id";
    $result = $mysqli->query($sql);
    return $result;
}
function get_invoice_by_id($mysqli, $id)
{
    $sql = "SELECT * FROM `ticket_invoice` WHERE `invoice_id`='$id'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}


function update_invoice($mysqli, $invoice_id, $scheduled_trips_id, $user_id, $qty, $payment_type , $status, $paymentRef, $total_price,$transition_no)
{

    $sql = "UPDATE  `ticket_invoice` SET `scheduled_trips_id`='$scheduled_trips_id',`user_id`='$user_id',`qty`='$qty',`payment_type`='$payment_type',`status`='$status',`paymentRef`='$paymentRef',`total_price`='$total_price',`transition_no`='$transition_no' WHERE `invoice_id`=$invoice_id";
    if ($mysqli->query($sql)) {
        return true;
    } else {
        return false;
    }

}

function delete_invoice_by_scheduled_trips_id($mysqli, $id)
{
    $sql = "DELETE  FROM `ticket_invoice` WHERE `scheduled_trips_id`='$id'";
    if ($mysqli->query($sql)) {
        return true;
    } else {
        return false;
    }
}



function delete_invoice($mysqli, $invoice_id)
{
    $sql = "DELETE FROM  `ticket_invoice` WHERE `invoice_id`='$invoice_id'";
    if ($mysqli->query($sql)) {
        return true;
    } else {
        return false;
    }
}

