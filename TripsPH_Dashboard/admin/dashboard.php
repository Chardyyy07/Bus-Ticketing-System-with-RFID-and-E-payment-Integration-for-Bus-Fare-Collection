<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['id'], $_SESSION['user_role_id'])) {
    header('location: dashboard.php?lmsg=true');
    exit;
}

// Include the config file
require_once('config.php');
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
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
</head>



<body>
    <!-- Sidebar -->
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <!-- Sidebar Header -->
        <div class="side-header">
            <h3>T<span>ripsPH</span></h3>
        </div>

        <!-- Sidebar Content -->
        <div class="side-content">
            <!-- User Profile -->
            <div class="profile">
                <span class="las la-user-circle" style="color: #899DC1; font-size: 96px;"></span>
                <h4>
                    <!-- Display the username -->
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo $_SESSION['username'];
                    } else {
                        echo 'Default Name';
                    }
                    ?>
                </h4>

                <small>
                    <!-- Display the user role -->
                    <?php
                    if (isset($_SESSION['user_role_id'])) {
                        $role = 'Default Role';
                        if ($_SESSION['user_role_id'] == 1) {
                            $role = 'Admin';
                        } elseif ($_SESSION['user_role_id'] == 2) {
                            $role = 'Editor';
                        } elseif ($_SESSION['user_role_id'] == 3) {
                            $role = 'User Only';
                        }
                        echo $role;
                    } else {
                        echo 'Default Role';
                    }
                    ?>
                </small>
            </div>

            <!-- Side Menu -->
            <div class="side-menu">
                <ul>
                    <li>
                        <a href="../dashboard.php" class="active">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/personnel_management/personnel_management.php">
                            <span class="las la-user-friends"></span>
                            <small>Personnel Management</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/card_transactions/card_transactions.php">
                            <span class="las la-credit-card"></span>
                            <small>Card Transactions</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/bus_management/bus_management.php">
                            <span class="las la-bus-alt"></span>
                            <small>Bus Management</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/bus_destination/bus_destination.php">
                            <span class="las la-bus"></span>
                            <small>Bus Destination Management</small>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="main-content">
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars" style="font-size: 45px; line-height: 45px;"></span>
                </label>

                <div class="header-menu">
                    <!-- User List (visible to admin) -->
                    <?php if (($_SESSION['user_role_id'] == 1) || $_SESSION['user_role_id'] == 2) { ?>
                        <label for="">
                            <span class="las la-users"></span>
                            <a href="adminuser/adminuser.php"><span>User List</span></a>
                        </label>
                    <?php } else { ?>
                        <label for="">
                            <span class="las la-users"></span>
                            <span>User List</span>
                        </label>
                    <?php } ?>
                    <!-- Profile -->
                    <label for=""> <!-- edit profile for who is signed in only -->
                        <span class="las la-user-tie"></span>
                        <a href="edit.php?id=<?php echo $_SESSION['id']; ?>"><span>Profile</span></a>
                    </label>
                    <!-- Logout -->
                    <label for="">
                        <span class="las la-sign-out-alt"></span>
                        <a href="logout.php"><span>Logout</span></a>
                    </label>
                </div>
        </header>


        <!-- Start ng main Dashboard Module-->
        <main>
            <center style="background-color: #333; color: #fff; padding: 10px;">Under Maintenance</center>

</body>

</html>