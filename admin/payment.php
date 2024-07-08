<?php
require_once("../layouts/header.php");
require_once("../storage/database.php");
require_once("../storage/payment_method_db.php");

$success='';
$invalid='';


if (isset($_GET["success"])) $success = $_GET["success"];
if (isset($_GET["invalid"])) $invalid = $_GET["invalid"];



if(isset($_GET['delete_id'])){
   $payment_method_id=$_GET['delete_id'];
    $status=delete_payment_method($mysqli,$payment_method_id);
    if($status){
        $success="Delete Success";
        header("Location:../admin/payment.php?success=$success");
    }else{
        $invalid="Delete Fail";
        header("Location:../admin/payment.php?invalid=$invalid");
    }
}



?>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
      <!-- side var -->
      <?php

      require_once("../layouts/sidebar.php");
?>
      <!-- /side var -->
<div class="layout-page">
   <!-- Layout Page -->
<?php require_once("../layouts/admin_navar.php")?>

 



<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h6 class="op-7 mb-2 ms-2">Manage Payment </h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <!-- <a href="../#" class="btn btn-label-info btn-round me-2">Manage</a> -->
        <a href="add_payment.php" class="btn btn-primary btn-round me-2">Add Payment</a>
    </div>
</div>
<div class="col-md-12">

<?php
if ($success) { ?>
    <div class="alert alert-success text-center"><?php echo $success ?></div>
<?php } ?>
<?php if ($invalid) { ?>
    <div class="alert alert-danger"><?php echo $invalid ?></div>
<?php } ?>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Payment List</h4>
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
                            <th style="width: 15%">Payment Method</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $results = get_all_payment_method($mysqli);
                        $i = 1;
                        while ($payment_method = $results->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$payment_method[payment_method_name]</td>";
                            echo "<td><a href='./add_payment.php?update_id=$payment_method[payment_method_id]'><i class='fa fa-edit me-4'></i></a>";
                            echo "<a href='?delete_id=$payment_method[payment_method_id]'><i class='fa fa-times text-danger'></i></a></td></a>";
                            echo "</tr>";
                            $i++;
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    
</div>
    </div>
    <!-- / Layout page -->
</div>
      </div>
    </div>
    <!-- / Layout wrapper -->


 <?php

    require_once("../layouts/footer.php");
?>