<?php
require_once("../storage/db_connect.php");
require_once("../storage/auth_user.php");

if (!$user) {
  header("Location:../auth/login.php");
} else {
  if ($user['is_admin']) {
    header("Location:../layouts/err.php");
  }
}

require_once("../layouts/header.php");
require_once("../layouts/user_navar.php");

?>

<div class="row" style="background-color: rgb(37, 184,200,0.5)">
<div class="row ms-4 mt-3" style="height: 500px;" >
    <h3>About Ticket</h3>
    <p class="my-3">Car Ticketing is partnered with more than 20 major Bus operators in Myanmar, and it mainly offers online ticketing to more than a hundred destinations for bus travelers mainly in Myanmar.</h2>
  <h3 class="my-3">Instant Confirmation</h3>
  <p class="ms-2">Car Ticketing is the only e-commerce website in Myanmar to offer instant confirmation for your ticket purchase with the major bus operators</p>
 <h3 class="my-3">Payment Options</h3>
 <p class="ms-2">Car Ticketing accepts several payment methods. You can pay with KPAY and WaveMoney.</p>
</div>
</div>

<footer id="footer" class=" row footer-section bg-dark">

  <div class="row">

    <div class="col-4 footer-menu">
      <ul style="color: aliceblue;" class="m-2 ms-5">
        <p class="mb-2 "><a href="#home" class="text-decoration-none" style="color: white;">Home</a></p>
        <p class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Terms</a></p>
        <p class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Privacy</a></p>
        <p class="mb-2 "><a href="#" class="text-decoration-none" style="color: white;">Policy</a></p>
      </ul>
    </div>

    <div class="col-4 copyright-area">
      <div class="container">

        <div class="copyright-text">
          <p style="color: aliceblue;margin: 50px;">Copyright &copy; 2024, All Right Reserved </p>
        </div>
      </div>
    </div>

    <div class="col-4 footer-widget">
      <h3 class="text-center text-white mt-3">Contact Us</h3>
      <div class="footer-social-icon">
        <div class="d-flex justify-content-center">
          <a href="https://www.facebook.com/"><i class="fab fa-facebook-f facebook-bg p-2 me-3"></i></a>
          <a href="https://www.twitter.com/"><i class="fab fa-twitter twitter-bg p-2 me-3"></i></a>
          <a href="https://www.youtube.com/"><i class="fa-brands fa-youtube p-2 me-3"></i></a>
        
        </div>

        <div class="text-white mt-3 text-center ">
          <small><i class="fa-solid fa-phone me-2"></i> 09445088092</small>
          
        </div>
       
      </div>

      
    </div>


  </div>


  <!-- Core JS
    build:js assets/vendor/js/core.js -->
  <script src="../assets/vendor/js/bootstrap.js"></script>


</footer>
