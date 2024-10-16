<?php
require_once("../storage/auth_user.php");
require_once("../storage/database.php");
require_once("../storage/invoice_db.php");


if (!$user) {
    header("Location:../auth/login.php");
  } else {
     if (!$user['is_admin']) {
         header("Location:../layouts/err.php");
     }
  }


if(isset($_GET['delete_id'])){
    $invoice_id=$_GET['delete_id'];
    $status=delete_invoice($mysqli,$invoice_id);
    if($status){
        $success="Delete Success";
        header("Location:../admin/invoice.php?success=$success");
    }else{
        $invalid="Delete Fail";
        header("Location:../admin/invoice.php?invalid=$invalid");
    }
}

require_once("../layouts/header.php");
require_once("../layouts/admin_navar.php");
require_once("../layouts/sidebar.php");


?>

<div class="layout-wrapper layout-content-navbar ">
      <div class="layout-container">

      

<div class="layout-page">
   <!-- Layout Page -->
   <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Booking List</h4>
            </div>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table id="add-row" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 15%">No</th>
                            <th style="width: 15%">Trips</th>
                            <th style="width: 15%">User Name</th>
                            <th style="width: 15%">Quality</th>
                            <th style="width: 10%">Status(paid=1,unpaid=0)</th>
                            <th style="width: 15%">Reference No</th>
                            <th style="width: 15%">Total Price</th>
                            <th style="width: 15%">Transition No</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                         $results = $mysqli->query("SELECT * FROM ticket_invoice");
                        $i = 1;
                        while ($invoice = $results->fetch_assoc()) {
                            $scheldule_trip_sql_result = $mysqli->query("SELECT * FROM `scheduled_trips` WHERE `scheduled_trips_id`=$invoice[scheduled_trips_id]")->fetch_assoc();
                            $from_sql_result = $mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$scheldule_trip_sql_result[from_location]")->fetch_assoc();
                            $to_sql_result = $mysqli->query("SELECT * FROM `trip_location` WHERE `trip_location_id`=$scheldule_trip_sql_result[to_location]")->fetch_assoc();
                            $user = $mysqli->query("SELECT * FROM `user` WHERE `user_id`=$invoice[user_id]")->fetch_assoc();
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$from_sql_result[city_name] To $to_sql_result[city_name]</td>";
                            echo "<td>$user[user_name]</td>";
                            echo "<td>$invoice[qty]</td>";
                            echo "<td>$invoice[status]</td>";
                            echo "<td>$invoice[paymentRef]</td>";
                            echo "<td>$invoice[total_price] </td>";
                            echo "<td>$invoice[transition_no]</td>";
                            echo "<td><a href='./update_invoice.php?update_id=$invoice[invoice_id]'><i class='fa fa-edit me-4'></i></a>";
                            echo "<a href='?delete_id=$invoice[invoice_id]'><i class='fa fa-times text-danger'></i></a></td></a>";
                            echo "</tr>";
                            $i++;
                        }
                        ?>



                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Layout page -->
</div>

      </div>
    </div>
<?php require_once("../layouts/footer.php");