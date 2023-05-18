
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>TripsPH Admin Dashboard</title>

    <link rel="stylesheet" href="../assets/styles1.css">
  <!-- Copied from https://icons8.com/line-awesome/howto then copy the CDN for icons  -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>


<body>
    <!-- Start ng sidebar -->
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>T<span>ripsPH</span></h3>
        </div>

        <div class="side-content">
    <div class="profile">
        <div class="profile-img bg-img" style="background-image: url(img/3.jpeg)"></div>
        <h4>
            <?php
            if (isset($_SESSION['username'])) {
                echo $_SESSION['username'];
            } else {
                echo 'Default Name'; // Change this to the default name if no user is logged in
            }
            ?>
        </h4>
        <small>Admin</small>
    </div>
            <div class="side-menu">
                <ul>
                    <li>
                       <a href="../dashboard.php">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                 <li>
                    <a href="user_management.php" class="active">
                        <span class="las la-user-alt"></span>
                        <small>User Management</small>
                    </a>
                </li>
                    <li>
                       <a href="../cardmanagement/card_management.php">
                            <span class="las la-envelope"></span>
                            <small>Card Management</small>
                        </a>
                    </li>
                    <li>
                       <a href="../busfarecollection/bus_fare_collection.php">
                            <span class="las la-clipboard-list"></span>
                            <small>Bus Fare Collections</small>
                        </a>
                    </li>
                    <li>
                       <a href="../cardtransactions/card_transactions.php">
                            <span class="las la-shopping-cart"></span>
                            <small>Card Transactions</small>
                        </a>
                    </li>
                    <li>
                       <a href="../setting/settings.php">
                            <span class="las la-tasks"></span>
                            <small>Settings</small>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
  <!-- Start ng header-->
  <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
                    <label for="">
                        <span class="las la-search"></span>
                    </label>
                    
                    <div class="notify-icon">
                        <span class="las la-envelope"></span>
                        <span class="notify">4</span>
                    </div>
                    
                    <div class="notify-icon">
                        <span class="las la-bell"></span>
                        <span class="notify">3</span>
                    </div>
                    
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>

                        <span class="las la-power-off"></span>
                        <a href="logout.php">
                        <span>Logout</span>
                    </div>
                </div>
            </div>
        </header>
        
<!-- end ng header-->
     
<!-- Start ng main Dashboard Module-->
<main>
          
    <!-- end ng main dashboard module-->
</body>
</html>


 


