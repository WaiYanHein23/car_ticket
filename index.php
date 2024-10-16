<?php
require_once("./storage/database.php");
require_once("./storage/car_db.php");
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
    <div class="row d-flex justify-content-between" id="bg">
       <div class="col-9">
        <!-- <h4 class="text-white m-5">Book Online Bus Ticket Around Myanmar</h4> -->
        <h5 class="text-white m-5">မြန်မာနိုင်ငံအဝှမ်း ကားလိုင်း နှစ်ဆယ်ကျော်မှ အသက်သာ အဆင်ပြေဆုံး ခရီးစဉ်ကို ရှာဖွေလိုက်ပါ။</p>

    </div>
       <div class="col-3 d-flex justify-content-center"> 
        <div class="m-5  fs-5"><a class="text-decoration-none" href="./auth/login.php">Login</a></div>
        <div class="m-5  fs-5"><a class="text-decoration-none" href="./auth/register.php">Register</a></div>
        </div>

<!-- Car List -->
<div class="row  mt-5" >
  
  <div class="row  justify-content-center mt-5 " id="header">
  <div class="container  text-white mt-5 w-75 ms-2"  >
  <a href=""><h3 class="mt-5 link-underline  text-center text-danger fst-italic" >Operators</h3></a>
  </div>
    <?php
    $paga = 0;
    if (isset($_GET['pag'])) {
      $paga = $_GET['pag'];
       
    }
    $results = get_all_car_pagination($mysqli, $paga);
    $i = 1;
    while ($car = $results->fetch_assoc()) {
    ?>

      <div class="col-3 mt-5">
        <div class="card text-white mt-3 h-50 w-50 ms-2" style="background-color: rgb(255,193,7,0.4)">
          <a class="text-center mt-1 btn btn-outline-info" href=""><?php echo $car['brand'] ?></a>
        </div>
      </div>

    <?php
      $i++;
    } ?>


    <div class="row ">
      
      <div class="col-6 ">
      <nav>
      <ul class="pagination ">
            
        <?php
        $count = get_all_car_pag($mysqli);
        $p = 0;
        for ($i = 1; $i < $count + 1; $i ++) {
        ?>  
          <li class="page-item ms-5 "><a class="page-link" href="?pag=<?= $p ?>"><?= $p + 1 ?></a></li>
          
        <?php
          $p++;
        }
        ?>
               
        </ul>

      
      
    </nav>

      </div>
     
      
    </div>

  </div>


</div>
 <!-- Car List -->
    </div>

    
</body>
</html>