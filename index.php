<?php

require_once("./layouts/header.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
</bootstrap -->
    
</head>
<style>
       #bg{
        background-image: url("./assets/img/backgrounds/2.jpg");
        background-size: cover;
        background-position: center;
        height: 100vh;
       }
    </style>
<body>
    <div class="d-flex justify-content-between" id="bg">
       <div>
        <h3 class="text-white m-5">မြန်မာနိုင်ငံအဝှမ်း ကားလိုင်း များမှ အသက်သာ အဆင်ပြေဆုံး ခရီးစဉ်ကို ရှာဖွေလိုက်ပါ။</h3>
    </div>
       <div class="d-flex"> 
        <div class="m-5  fs-5"><a class="text-decoration-none" href="./auth/login.php">Login</a></div>
        <div class="m-5 fs-5"><a class="text-decoration-none" href="./auth/register.php">Register</a></div>
        </div>
    </div>
</body>
</html>