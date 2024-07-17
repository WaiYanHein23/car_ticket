<?php
require_once("../storage/auth_user.php");
require_once("../storage/database.php");

if (!$user) {
    header("Location:../auth/login.php");
  } else {
     if (!$user['is_admin']) {
         header("Location:../layouts/err.php");
     }
  }
require_once("../layouts/header.php");
require_once("../layouts/admin_navar.php");
require_once("../layouts/sidebar.php");

?>

<div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

      

<div class="layout-page">
   <!-- Layout Page -->
   <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Booking List</h4>
                <!-- <button class="btn btn-primary btn-round ms-auto">
                    <i class="fa fa-plus"></i>
                    
                </button> -->
            </div>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table id="add-row" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 15%">No</th>
                            <th style="width: 15%">Scheduled ID</th>
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
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$invoice[scheduled_trips_id]</td>";
                            echo "<td>$invoice[username]</td>";
                            echo "<td>$invoice[qty]</td>";
                            echo "<td>$invoice[status]</td>";
                            echo "<td>$invoice[paymentRef]</td>";
                            echo "<td>$invoice[total_price]</td>";
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