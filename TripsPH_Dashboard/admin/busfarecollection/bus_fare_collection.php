<?php
include "../config.php";
?>

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
    <span class="las la-user-circle" style="color: #899DC1; font-size: 96px;"></span>

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
                    <a href="../user/user_management.php">
                        <span class="las la-user-alt"></span>
                        <small>User Management</small>
                    </a>
                </li>
                    <li>
                       <a href="../cardmanagement/card_management.php">
                            <span class="las la-id-card"></span>
                            <small>Card Management</small>
                        </a>
                    </li>
                    <li>
                       <a href="bus_fare_collection.php" class="active">
                            <span class="las la-bus"></span>
                            <small>Bus Fare Collections</small>
                        </a>
                    </li>
                    <li>
                       <a href="../cardtransactions/card_transactions.php">
                            <span class="las la-credit-card"></span>
                            <small>Card Transactions</small>
                        </a>
                    </li>
                    <li>
                       <a href="../setting/settings.php">
                            <span class="las la-cog"></span>
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
                        <a href="../logout.php">
                        <span>Logout</span></a>
                    </div>
                </div>
            </div>
        </header>
        
<!-- end ng header-->
     
<!-- Start ng main Dashboard Module-->
<main>
<div class="records table-responsive">

<div class="record-header">
    <div class="add">
        <span>Entries</span>
        <select name="" id="">
            <option value="">ID</option>
        </select>
        <a href="add-record.php" class="button">Add Record</a>
    </div>

    <div class="browse">
       <input type="search" placeholder="Search" class="record-search">
    </div>
</div>

<div>

<table width="100%">
  <thead>
    <tr>
      <th>#</th>
      <th><span class="las la-sort"></span> Transaction ID</th>
      <th><span class="las la-sort"></span> RFID Card UID</th>
      <th><span class="las la-sort"></span> Card Holders Name</th>
      <th><span class="las la-sort"></span> Card Balance</th>
      <th><span class="las la-sort"></span> Card Status</th>
      <th><span class="las la-sort"></span> Origin</th>
      <th><span class="las la-sort"></span> Destination</th>
      <th><span class="las la-sort"></span> Total Fare Amount</th>
      <th><span class="las la-sort"></span> Created at</th>
      <th><span class="las la-sort"></span> Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT * FROM `users`";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <tr>
        <td><?php echo $row["id"] ?></td>
        <td><?php echo $row["created_at"] ?></td>
        <td><?php echo $row["username"] ?></td>
        <td><?php echo $row["created_at"] ?></td>
        <td><?php echo $row["created_at"] ?></td>
        <td><?php echo $row["username"] ?></td>
        <td><?php echo $row["username"] ?></td>
        <td><?php echo $row["created_at"] ?></td>
        <td><?php echo $row["created_at"] ?></td>
        <td><?php echo $row["created_at"] ?></td>
        <td class="actions">
        <a href="#" onclick="showData(<?php echo $row["id"] ?>)"><i class="las la-eye"></i></a>
          <a href="edit.php?id=<?php echo $row["id"] ?>"><i class="las la-edit"></i></a>
          <a href="delete.php?id=<?php echo $row["id"] ?>"><i class="las la-trash"></i></a>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>
  </div>          
</main>        
    <!-- end ng main dashboard module-->
    
            <!-- Dialog Box -->
            <div id="dialogBox" class="dialog-box">
            <div class="dialog-content">
                <span class="close">&times;</span>
                <div id="dialogData"></div>
            </div>
        </div>

        <script>
            function showData(id) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dialogData").innerHTML = this.responseText;
                        var dialogBox = document.getElementById("dialogBox");
                        dialogBox.style.display = "block";
                    }
                };
                xhttp.open("GET", "view.php?id=" + id, true);
                xhttp.send();
            }

            var close = document.getElementsByClassName("close")[0];
            close.onclick = function() {
                var dialogBox = document.getElementById("dialogBox");
                dialogBox.style.display = "none";
            }
        </script>
    </div>
</body>
</html>