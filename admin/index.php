<?php 

require_once("../layouts/header.php");  
require_once("../storage/auth_user.php");

if (!$user) {
  header("Location:../auth/login.php");
} else {
   if (!$user['is_admin']) {
       header("Location:../layouts/err.php");
   }
}


?>

<?php   
    require_once("../layouts/admin_navar.php");
    require_once("../layouts/sidebar.php");
    ?>
    
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

      

<div class="layout-page">
   <!-- Layout Page -->
<h1 class="text-center mt-2">Welcome From Admin Page</h1>
    <!-- / Layout page -->
</div>

      </div>
    </div>
    <!-- / Layout wrapper -->

    

<?php require_once("../layouts/footer.php")  ?>;

   