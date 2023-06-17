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

// Check if the form is submitted to update user status
if (isset($_GET['id']) && isset($_GET['action'])) {
    // Store the user ID and action from the URL parameters
    $user_id = $_GET['id'];
    $action = $_GET['action'];

    // Validate and prepare the SQL query to update the user status based on the action
    if ($action === 'deactivate') {
        $status = 0; // Inactive status
    } elseif ($action === 'activate') {
        $status = 1; // Active status
    } else {
        // Invalid action, redirect back to the user list
        header('location: adminuser.php');
        exit;
    }

    // Update the user status in the database
    $sql = "UPDATE `tbl_users` SET `status` = $status WHERE `id` = $user_id";
    mysqli_query($link, $sql);
}

?>

<!-- Rest of the code -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>TripsPH Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/styles1.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
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
                        <a href="../dashboard.php">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/user_management.php">
                            <span class="las la-user-alt"></span>
                            <small>User Admin Management</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/cardmanagement/card_management.php">
                            <span class="las la-id-card"></span>
                            <small>Card Management</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/busfarecollection/bus_fare_collection.php">
                            <span class="las la-bus"></span>
                            <small>Bus Fare Collections</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/cardtransactions/card_transactions.php">
                            <span class="las la-credit-card"></span>
                            <small>Card Transactions</small>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/setting/settings.php">
                            <span class="las la-cog"></span>
                            <small>Settings</small>
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
                    <?php if ($_SESSION['user_role_id'] <= 1) { ?>
                        <label for="">
                            <span class="las la-users"></span>
                            <a href="/adminuser.php"><span>User List</span></a>
                        </label>
                    <?php } else { ?>
                        <label for="">
                            <span class="las la-users"></span>
                            <span>User List</span>
                        </label>
                    <?php } ?>

                    <!-- Profile -->
                    <label for="">
                        <span class="las la-user-tie"></span>
                        <a href="../adminuser/adminuser.php"><span>Profile</span></a>
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
                    <div class="record-header">
                        <div class="add">
                            <!-- Add Record (visible to admin and editor) -->
                            <?php if (($_SESSION['user_role_id'] == 1) || $_SESSION['user_role_id'] == 2) { ?>
                                <a href="addrecord.php" class="btn btn-info btn-sm">Add Record</a>
                            <?php } else { ?>
                                <a class="btn btn-info btn-sm disabled">Add Record</a>
                            <?php } ?>
                        </div>
                    </div>

                    <div>
                        <div class="record-header">
                            <div class="records table-responsive">
                                <table id="example" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="vertical-align: middle;">ID</th>
                                            <th style="vertical-align: middle;">Role</th>
                                            <th style="vertical-align: middle;">Fullname</th>
                                            <th style="vertical-align: middle;">Username</th>
                                            <th style="vertical-align: middle;">Email</th>
                                            <th style="vertical-align: middle;">Mobile</th>
                                            <th style="vertical-align: middle;">Status</th>
                                            <th style="vertical-align: middle;">Created At</th>
                                            <th style="vertical-align: middle;">Updated At</th>
                                            <th style="vertical-align: middle;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT u.*, r.user_role FROM `tbl_users` u INNER JOIN `tbl_user_role` r ON u.user_role_id = r.id";
                                        $result = mysqli_query($link, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $userId = $row["id"];
                                            $status = $row["status"];
                                            $statusBadge = $status == "1" ? "Active" : "Inactive";
                                            $statusClass = $status == "1" ? "badge-success" : "badge-danger";
                                        ?>
                                            <tr>
                                                <td style="vertical-align: middle;"><?php echo $row["id"] ?></td>
                                                <td style="vertical-align: middle;">
                                                    <?php
                                                    $userRole = $row["user_role"];
                                                    if ($userRole == "Admin") {
                                                        echo "<span class='badge badge-lg badge-success text-white'>Admin</span>";
                                                    } elseif ($userRole == "Editor") {
                                                        echo "<span class='badge badge-lg badge-info text-white'>Editor</span>";
                                                    } elseif ($userRole == "User Only") {
                                                        echo "<span class='badge badge-lg badge-dark text-white'>User Only</span>";
                                                    } else {
                                                        echo $userRole;
                                                    }
                                                    ?>
                                                </td>
                                                <td style="vertical-align: middle;"><?php echo $row["full_name"] ?></td>
                                                <td style="vertical-align: middle;"><?php echo $row["username"] ?></td>
                                                <td style="vertical-align: middle;"><?php echo $row["email"] ?></td>
                                                <td style="vertical-align: middle;"><?php echo $row["mobile"] ?></td>
                                                <td style="vertical-align: middle;">
                                                    <span class="badge badge-lg <?php echo $statusClass ?> text-white"><?php echo $statusBadge ?></span>
                                                </td>
                                                <td style="vertical-align: middle;"><?php echo $row["created_at"] ?></td>
                                                <td style="vertical-align: middle;"><?php echo $row["updated_at"] ?></td>
                                                <td class="actions" style="vertical-align: middle;">
                                                    <a class="btn btn-success btn-sm" href="view.php?id=<?php echo $row["id"] ?>">View</a>
                                                    <?php if (($_SESSION['user_role_id'] == 1) || $_SESSION['user_role_id'] == 2) { ?>
                                                        <a class="btn btn-info btn-sm" href="edit.php?id=<?php echo $row["id"] ?>">Edit</a>
                                                        <?php if ($_SESSION['user_role_id'] <= 1) { ?>
                                                            <a class="btn btn-danger btn-sm" href="delete.php?id=<?php echo $row["id"] ?>">Delete</a>
                                                        <?php } ?>
                                                        <a class="btn btn-warning btn-sm" href="status.php?id=<?php echo $row["id"] ?>&action=<?php echo $status == "1" ? "deactivate" : "activate" ?>"><?php echo $status == "1" ? "Deactivate" : "Activate" ?></a>
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
                </div>
            </div>
        </main>
    </div>

    <!-- Script -->
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