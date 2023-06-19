<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to the login page
if (!isset($_SESSION['id'], $_SESSION['user_role_id'])) {
    header('location: ../../admin/login.php?lmsg=true');
    exit;
}

// Include the config file
require_once('../../admin/config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $from = $_POST['from'];
    $to = $_POST['to'];
    $fare = $_POST['fare'];

    // Validate the form data (add your validation rules here)

    // Insert the data into the tbl_fare_matrix table
    $query  = "INSERT INTO tbl_fare_matrix (from, to, fare) VALUES ('$from', '$to', '$fare')";

    if (mysqli_query($link, $query)) {
        // Data inserted successfully
        header("Location: adminuser.php?msg=New record created successfully");
        exit(); // Add exit() after header() to prevent further execution
    } else {
        // Error occurred while inserting data
        echo "Error: " . mysqli_error($link);
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>TripsPH Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="../../assets/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/styles1.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
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
                        <a href="../dashboard.php">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                        <a href="../personnel_management/personnel_management.php">
                            <span class="las la-user-friends"></span>
                            <small>Personnel Management</small>
                        </a>
                    </li>
                    <li>
                        <a href="../card_transactions/card_transactions.php">
                            <span class="las la-credit-card"></span>
                            <small>Card Transactions</small>
                        </a>
                    </li>
                    <li>
                        <a href="../bus_management/bus_management.php">
                            <span class="las la-bus-alt"></span>
                            <small>Bus Management</small>
                        </a>
                    </li>
                    <li>
                        <a href="../bus_destination/bus_destination.php" class="active">
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
                            <a href="../adminuser/adminuser.php"><span>User List</span></a>
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
                        <a href="../logout.php"><span>Logout</span></a>
                    </label>
                </div>
        </header>

        <!-- Main Dashboard Module -->
        <main>
            <!-- User List -->
            <div class="page-content">
                <div class="records table-responsive">
                    <!-- Add Landmark Form -->
                    <div class="record-header">
                        <div class="records table-responsive">
                            <div class="">
                                <form action="" method="POST">
                                    <label for="from">From:</label>
                                    <input type="text" id="from" name="from" placeholder="Enter from location">

                                    <label for="to">To:</label>
                                    <input type="text" id="to" name="to" placeholder="Enter to location">

                                    <label for="fare">Fare:</label>
                                    <input type="text" id="fare" name="fare" placeholder="Enter fare amount">

                                    <button class="btn btn-success btn-sm" style="color: white;" name="submit">Save</button>
                                </form>
                                <div class="record-header">
                                    <div class="records table-responsive">
                                        <table id="example" class="table table-striped" style="width: 100%; text-align: center; vertical-align: middle;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">ID</th>
                                                    <th style="text-align: center; vertical-align: middle;">From:</th>
                                                    <th style="text-align: center; vertical-align: middle;">To:</th>
                                                    <th style="text-align: center; vertical-align: middle;">Total Fare:</th>
                                                    <th style="text-align: center; vertical-align: middle;">Created At</th>
                                                    <th style="text-align: center; vertical-align: middle;">Updated At</th>
                                                    <th style="text-align: center; vertical-align: middle;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody> <!-- status code -->
                                                <?php
                                                $sql = "SELECT * FROM `tbl_fare_matrix`";
                                                $result = mysqli_query($link, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $userId = $row["id"];
                                                    $status = $row["status"];
                                                    $statusBadge = $status == "1" ? "Active" : "Inactive";
                                                    $statusClass = $status == "1" ? "badge-success" : "badge-danger";
                                                ?>
                                                    <tr> <!-- user role code -->
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["id"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["from"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["to"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["fare"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["created_at"] ?></td>
                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["updated_at"] ?></td>
                                                        <td class="actions" style="text-align: center; vertical-align: middle;">
                                                            <a class="btn btn-success btn-sm" href="view.php?id=<?php echo $row["id"] ?>">View</a>
                                                            <?php if (($_SESSION['user_role_id'] == 1) || $_SESSION['user_role_id'] == 2) { ?>
                                                                <a class="btn btn-info btn-sm" href="edit.php?id=<?php echo $row["id"] ?>">Edit</a>
                                                                <?php if ($_SESSION['user_role_id'] <= 1) { ?>
                                                                    <a class="btn btn-danger btn-sm" href="delete.php?id=<?php echo $row["id"] ?>">Delete</a>
                                                                <?php } ?>

                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- 2nd Table -->
                            <div class="records table-responsive">
                                <div class="record-header">
                                    <div class="add">
                                        <!-- Add Record (visible to admin and editor) -->
                                        <?php if (($_SESSION['user_role_id'] == 1) || $_SESSION['user_role_id'] == 2) { ?>
                                            <a href="addrecord.php" class="btn btn-info btn-sm d-flex align-items-center">
                                                <span class="las la-plus-circle" style="font-size: 32px; color: white;"></span>
                                                <span class="ms-2" style="color: white;">Add Landmark</span>
                                            </a>
                                        <?php } else { ?>
                                            <a class="btn btn-info btn-sm disabled">Add Record</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <table id="example" class="table table-striped" style="width: 100%; text-align: center; vertical-align: middle;">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;">ID</th>
                                            <th style="text-align: center; vertical-align: middle;">Landmark</th>
                                            <th style="text-align: center; vertical-align: middle;">Created At</th>
                                            <th style="text-align: center; vertical-align: middle;">Updated At</th>
                                            <th style="text-align: center; vertical-align: middle;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody> <!-- status code -->
                                        <?php
                                        $sql = "SELECT * FROM `tbl_landmark`";
                                        $result = mysqli_query($link, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $userId = $row["id"];
                                            $status = $row["status"];
                                            $statusBadge = $status == "1" ? "Active" : "Inactive";
                                            $statusClass = $status == "1" ? "badge-success" : "badge-danger";
                                        ?>
                                            <tr> <!-- user role code -->
                                                <td style="text-align: center; vertical-align: middle;"><?php echo $row["id"] ?></td>
                                                <td style="text-align: center; vertical-align: middle;"><?php echo $row["full_name"] ?></td>
                                                <td style="text-align: center; vertical-align: middle;"><?php echo $row["created_at"] ?></td>
                                                <td style="text-align: center; vertical-align: middle;"><?php echo $row["updated_at"] ?></td>
                                                <td class="actions" style="text-align: center; vertical-align: middle;">
                                                    <a class="btn btn-success btn-sm" href="view.php?id=<?php echo $row["id"] ?>">View</a>
                                                    <?php if (($_SESSION['user_role_id'] == 1) || $_SESSION['user_role_id'] == 2) { ?>
                                                        <a class="btn btn-info btn-sm" href="edit.php?id=<?php echo $row["id"] ?>">Edit</a>
                                                        <?php if ($_SESSION['user_role_id'] <= 1) { ?>
                                                            <a class="btn btn-danger btn-sm" href="delete.php?id=<?php echo $row["id"] ?>">Delete</a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                            </div>
                        </div>
        </main>

        <!-- Script for the table -->
        <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
            });
        </script>
</body>

</html>