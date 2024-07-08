<?php
require_once("../layouts/header.php");
require_once("../storage/database.php");
require_once("../storage/invoice_db.php");
require_once("../storage/payment_method_db.php");
require_once("../layouts/admin_navar.php");
require_once("../layouts/sidebar.php");
?>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- side var -->
       
        <!-- /side var -->
        <div class="layout-page">
            <!-- Layout Page -->

            <!-- car added -->

            <?php
            $payment_method_id = $user_id = $status = $total_price = '';
            $payment_method_id_err = $user_id_err = $status_err = $total_price_err = '';
            $invalid = "";
            $success = '';

            if (isset($_POST['submit'])) {
                $validate = true;
                $payment_method_id = $_POST['payment_method_id'];
                $user_id = $_POST['user_id'];
                $status = $_POST['status'];
                $total_price = $_POST['total_price'];
                if ($payment_method_id === "00") {
                    $validate = false;
                    $payment_method_id_err = "Payment method Name can't blank";
                }

                if ($user_id === '00') {
                    $validate = false;
                    $user_id_err = "User Name can't blank";
                }

                if ($status === '') {
                    $validate = false;
                    $status_err = "Status can't blank";
                }

                if ($total_price ==='') {
                    $validate = false;
                    $total_price_err = "Total price can't blank";
                }

                if ($validate) {
                    $status = save_invoice($mysqli, $payment_method_id, $user_id, $status, $total_price);
                    if ($status) {
                        $success = "Success";
                        $payment_method_id = $user_id = $status = $total_price = '';

                    } else {
                        $invalid = "Fail";
                    }
                }
            }

            if (isset($_GET["update_id"])) {
                $invoice_id = $_GET["update_id"];
                $invoice = get_invoice_by_id($mysqli, $invoice_id);
                $payment_method_id = $invoice['payment_method_id'];
                $user_id = $invoice['user_id'];
                $status = $invoice['status'];
                $total_price = $invoice['total_price'];
                if (isset($_POST["update"])) {
                    $payment_method_id = $_POST['payment_method_id'];
                    $user_id = $_POST['user_id'];
                    $status = $_POST['status'];
                    $total_price = $_POST['total_price'];
                    if ($payment_method_id === '') $payment_method_id_err = "Payment method ID can not be blank!";
                    if ($payment_method_id_err === '') {
                        $status = update_invoice($mysqli, $invoice_id, $payment_method_id, $user_id, $status, $total_price);
                        if ($status) {
                            $success = "Invoice Updated Success!";
                        } else {
                            $invalid = "Invoice updated Fail!";
                        }
                    }
                }
            }

            ?>
            <?php
            if ($success) { ?>
                <div class="alert alert-success text-center"><?php echo $success ?></div>
            <?php } ?>
            <?php if ($invalid) { ?>
                <div class="alert alert-danger"><?php echo $invalid ?></div>
            <?php } ?>
            <div class="row">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="card ">
                                <div class="ms-md-auto py-2 py-md-0 m-3">
                                    <a href="invoice.php" class="btn btn-primary btn-round me-2">Invoice List</a>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-6 card mt-4">
                                        <div class="card-header">
                                            <?php if (!isset($_GET['id'])) { ?>
                                                <div class="card-title text-center fs-2">Invoice Add</div>
                                            <?php } else { ?>
                                                <div class="card-title text-center fs-2">Invoice Update</div>
                                            <?php } ?>
                                        </div>
                                        <div class="card-body">

                                            <div class="form-floating form-floating-custom mb-3">
                                                
                                                <select class="form-select"  name="payment_method_id">
                                                    <option value="00">Select Payment Method Name</option>
                                                    <?php
                                                    $payments=get_all_payment_method($mysqli);
                                                    $i=1;
                                                    while($payment=$payments->fetch_assoc()){
                                                        $select='';
                                                    if($payment_method_id==$payment['payment_method_id']) $select="selected";
                                                   
                                                    ?>
                                                    <option <?php echo $select ?> value="<?php echo $payment['payment_method_id']  ?>"><?php echo  $payment['payment_method_name'] ?></option>
                                                    <?php  } ?>
                                                </select>
                                                <small class="text-danger"><?php echo $payment_method_id_err ?></small>
                                            </div>

                                            <div class="form-floating form-floating-custom mb-3">
                                                <!-- <input type="text" class="form-control" id="floatingInput" placeholder="User ID" name="user_id" value="" />
                                                <label for="floatingInput">User ID</label> -->
                                                <select class="form-select"  name="user_id" id="">
                                                    <option value="00">Select User Name</option>
                                                    <?php
                                                    $users=get_all_user($mysqli);
                                                    $i=1;
                                                    while($user=$users->fetch_assoc()){
                                                        $select='';
                                                    if($user_id==$user['user_id']) $select="selected";
                                                   
                                                    ?>
                                                    <option <?php echo $select ?> value="<?php echo $user['user_id']  ?>"><?php echo  $user['user_name'] ?></option>
                                                    <?php  } ?>
                                                </select>
                                                <small class="text-danger"><?php echo $user_id_err ?></small>
                                            </div>

                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="Status" name="status" value="<?php echo $status ?>" />
                                                <label for="floatingInput">Status</label>
                                                <small class="text-danger"><?php echo $status_err ?></small>
                                            </div>
                                            
                                            <div class="form-floating form-floating-custom mb-3">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="Total Price" name="total_price" value="<?php echo $total_price ?>" />
                                                <label for="floatingInput">Total Price</label>
                                                <small class="text-danger"><?php echo $total_price_err ?></small>
                                            </div>

                                        </div>
                                        <div class="card-action">
                                            <?php if (isset($_GET['update_id'])) { ?>

                                                <button name="update" class="btn btn-primary my-3">Update</button>
                                            <?php } else { ?>
                                                <button name="submit" class="btn btn-primary my-3">Submit</button>
                                            <?php } ?>
                                            <button class="btn btn-danger">Cancel</button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </form>


            </div>