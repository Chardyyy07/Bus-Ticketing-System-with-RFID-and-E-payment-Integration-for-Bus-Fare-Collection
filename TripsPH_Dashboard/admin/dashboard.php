<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['id'], $_SESSION['user_role_id'])) {
    header('location: dashboard.php?lmsg=true');
    exit;
}

// Include the config file
require_once('../admin/config.php');
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
                        <a href="../admin/dashboard.php" class="active">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/rfid_transac/rfid_transac.php">
                            <span class="las la-credit-card"></span>
                            <small>TRIPS PH Card Transactions</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/card_transactions/card_transactions.php">
                            <span class="lab la-cc-mastercard"></span>
                            <small>Reloading Transactions</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/bus_ticketing_system/bus_ticket.php">
                            <span class="las la-bus"></span>
                            <small>Bus Ticketing System</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/person_manage/personnel_management.php">
                            <span class="las la-user-friends"></span>
                            <small>Personnel Management</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/bus_management/bus_management.php">
                            <span class="las la-bus-alt"></span>
                            <small>Bus Management</small>
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
                        <a href="adminuser/edit.php?id=<?php echo $_SESSION['id']; ?>"><span>Profile</span></a>
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

            <div class="page-header">
                <h1>TripsPH Dashboard</h1>
                <small>Home / Dashboard</small>
            </div>

            <div class="page-content">

                <div class="analytics">

                    <div class="card">
                        <div class="card-head">
                            <?php
                            // Count the total number of rows in the "rfid_transaction" table
                            $sql = "SELECT COUNT(*) FROM rfid_transaction";
                            $result = mysqli_query($link, $sql);
                            $row = mysqli_fetch_row($result);
                            $count = $row[0];
                            ?>
                            <h2><?php echo $count; ?></h2>
                            <span class="las la-user-friends"></span>
                        </div>
                        <div class="card-progress">
                            <small>Overall Transaction</small>
                            <div class="card-indicator">
                                <div class="indicator one"></div>
                            </div>
                        </div>
                        <a href="../admin/rfid_transac/rfid_transac.php">View Details</a>
                    </div>


                    <div class="card">
                        <div class="card-head">
                            <?php
                            // Count the total number of rows in the "tbl_reload_history" table
                            $sql = "SELECT COUNT(*) FROM tbl_reload_history";
                            $result = mysqli_query($link, $sql);
                            $row = mysqli_fetch_row($result);
                            $count = $row[0];
                            ?>
                            <h2><?php echo $count; ?></h2>
                            <span class="las la-shopping-cart"></span>
                        </div>
                        <div class="card-progress">
                            <small>Reloading Transactions</small>
                            <div class="card-indicator">
                                <div class="indicator two"></div>
                            </div>
                        </div>
                        <a href="../admin/card_transactions/card_transactions.php">View Details</a>
                    </div>


                    <div class="card">
                        <div class="card-head">
                            <?php
                            // Count the total number of unique RFID cards in the 'rfid' column of the 'rfid_transaction' table
                            $sql = "SELECT COUNT(DISTINCT rfid) FROM rfid_transaction";
                            $result = mysqli_query($link, $sql);
                            $row = mysqli_fetch_row($result);
                            $count = $row[0];
                            ?>
                            <h2><?php echo $count; ?></h2>

                            <span class="las la-credit-card"></span>
                        </div>
                        <div class="card-progress">
                            <small>Total Registered Cards</small>
                            <div class="card-indicator">
                                <div class="indicator three"></div>
                            </div>
                        </div>
                        <a href="../admin/cardregistered.php">View Details</a>
                    </div>



                    <div class="card">
                        <div class="card-head">
                            <?php
                            // Count the total number of rows in the "passenger" table
                            $sql = "SELECT COUNT(*) FROM passenger";
                            $result = mysqli_query($link, $sql);
                            $row = mysqli_fetch_row($result);
                            $count = $row[0];
                            ?>
                            <h2><?php echo $count; ?></h2>
                            <span class="las la-bus-alt"></span>
                        </div>
                        <div class="card-progress">
                            <small>Passengers Transactions</small>
                            <div class="card-indicator">
                                <div class="indicator four"></div>
                            </div>
                        </div>
                        <a href="../admin/bus_ticketing_system/bus_ticket.php">View Details</a>
                    </div>
                </div>

                <!-- Main Dashboard Module -->
                <main>
                    <!-- User List -->
                    <div class="page-content">
                        <div class="records table-responsive">
                            <div class="record-header">
                                <div class="add">
                                    <?php ?>
                                </div>
                            </div>

                            <div>
                                <div class="record-header">
                                    <div class="records table-responsive">
                                        <table id="example" class="table table-striped" style="width: 100%; text-align: center; vertical-align: middle;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">Id</th>
                                                    <th style="text-align: center; vertical-align: middle;">Ticket No.</th>
                                                    <th style="text-align: center; vertical-align: middle;">RFID</th>
                                                    <th style="text-align: center; vertical-align: middle;">Type</th>
                                                    <th style="text-align: center; vertical-align: middle;">Amount</th>
                                                    <th style="text-align: center; vertical-align: middle;">Entry Time</th>
                                                    <th style="text-align: center; vertical-align: middle;">Entry Location</th>
                                                    <th style="text-align: center; vertical-align: middle;">Exit Time</th>
                                                    <th style="text-align: center; vertical-align: middle;">Exit Location</th>
                                                    <th style="text-align: center; vertical-align: middle;">Fare</th>
                                                    <th style="text-align: center; vertical-align: middle;">Km. Travelled</th>
                                                    <th style="text-align: center; vertical-align: middle;">Current Balance</th>
                                                    <th style="text-align: center; vertical-align: middle;">Total Balance</th>
                                                    <th style="text-align: center; vertical-align: middle;">Valid Until</th>
                                                    <th style="text-align: center; vertical-align: middle;">Date Created</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT r.*, p.Entry_Time, p.Entry_Location, p.Exit_Time, p.Exit_Location
                            FROM `rfid_transaction` r
                            LEFT JOIN `passenger` p ON r.rfid = p.UM_ID AND r.date_created = p.date_created";
                                                $result = mysqli_query($link, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                    <tr>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["id"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["ticket_no."] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["rfid"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <?php
                                                            $type = $row["type"];
                                                            if ($type == "loading") {
                                                                echo "<span class='badge badge-lg badge-warning text-white'>Loading</span>";
                                                            } elseif ($type == "failed") {
                                                                echo "<span class='badge badge-lg badge-danger text-white'>Failed</span>";
                                                            } elseif ($type == "Insufficient Balance") {
                                                                echo "<span class='badge badge-lg badge-danger text-white'>Insufficient Balance</span>";
                                                            } elseif ($type == "Arrived") { // Handling new "Arrived" type
                                                                echo "<span class='badge badge-lg badge-info text-white'>Arrived</span>";
                                                            } elseif ($type == "Departed") { // Handling new "Departed" type
                                                                echo "<span class='badge badge-lg badge-success text-white'>Departed</span>";
                                                            } elseif ($type == "Expired") { // Handling new "Departed" type
                                                                echo "<span class='badge badge-lg badge-dark text-white'>Expired</span>";
                                                            } else {
                                                                echo $type;
                                                            }

                                                            ?>
                                                        </td>
                                                        <td style="text-align: center; vertical-align: middle;">₱<?php echo $row["amount"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["Entry_Time"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["Entry_Location"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["Exit_Time"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["Exit_Location"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;">₱<?php echo $row["Fare"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["km_travel"] ?> km</td>
                                                        <td style="text-align: center; vertical-align: middle;">₱<?php echo $row["current_balance"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;">₱<?php echo $row["total_balance"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["valid_until"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["date_created"] ?></td>

                                                    </tr>
                                                <?php } ?>
                                                </td>
                                                </tr>
                                                <?php

                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

            </td>
            </tr>
            </tbody>
            </table>
    </div>
    </div>
    </div>
    </div>
    </div>
    </main>
    </div>


    <!-- Script for the table -->
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>