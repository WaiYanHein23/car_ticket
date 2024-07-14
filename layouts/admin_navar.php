
<?php
require_once("../storage/database.php");
require_once("../storage/user_db.php");

if(isset($_POST['logout'])){
  setcookie("user","",-1,"/");
  header("Location:../auth/login.php");


}

$data = json_decode($_COOKIE['user'], true);
$user_name = $data['user_name'];
$user = get_user_by_id($mysqli, $data['user_id']);
$user_image=$user['image'];

?> 
      
     <!-- Navbar -->
          <nav
            class=" align-items-center bg-dark"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

              <!-- Search -->
              <!-- <div class="navbar-nav align-items-center ms-5">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div> -->
              <!-- /Search -->

              
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3 text-white">
                  
                    <?php echo $user_name;?>
                   
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online me-4 mb-2">
                    <img style="width: 50px;height: 50px;" class="rounded" src="data:image/png/jpg;base64,<?php echo $user_image ?>" alt="">
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                            <img style="width: 50px;height: 50px;" class="rounded" src="data:image/png/jpg;base64,<?php echo $user_image ?>" alt="">
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?php echo $user_name  ?></span>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../auth/admin_change_password.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    
                    <li>
                      <a class="dropdown-item" href="../auth/admin_change_password.php">
                      <i class="fa-solid fa-key me-2"></i>
                        <span class="align-middle">Change Password</span>
                      </a>
                    </li>
                    
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                     <form action="" method="post">
                        
                        <button type="submit" name="logout" class="p-2 ms-5 btn btn-danger">Log Out</button>
                
                     </form>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>
         
     <!-- / Navbar -->