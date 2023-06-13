<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['id'], $_SESSION['user_role_id'])) {
    header('location: dashboard.php?lmsg=true');
    exit;
}

// Include the config file
require_once('../../admin/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>TripsPH Admin Dashboard</title>

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
                        <a href="user_management.php">
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
    </div>

    <!-- Start ng header-->
    <div class="main-content">

        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars" style="font-size: 45px; line-height: 45px;"></span>
                </label>

                <div class="header-menu">
                    <!--only visible to admin-->
                    <?php if ($_SESSION['user_role_id'] == 1) { ?>
                        <label for="">
                            <span class="las la-users"></span>
                            <a href="/adminuser.php"><span>User List</span></a>
                        </label>
                    <?php } ?>



                    <label for="">
                        <span class="las la-user-tie"></span>
                        <a href="../adminuser/adminuser.php"><span>Profile</span></a>
                    </label>

                    <label for="">
                        <span class="las la-sign-out-alt"></span>
                        <a href="../logout.php"><span>Logout</span></a>
                    </label>
                </div>
        </header>
        <!-- Start ng main Dashboard Module-->
        <main>

            <div class="page-content">

                <div class="records table-responsive">

                    <div class="record-header">
                        <div class="add">
                            </select>
                            <a href="add-record.php" class="button">Add Record</a>
                        </div>

                    </div>
                    <div>
                        <div class="record-header">
                            <div class="records table-responsive">
                                <table id="example" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="vertical-align: middle;">id</th>
                                            <th style="vertical-align: middle;">role id</th>
                                            <th style="vertical-align: middle;">Fullname</th>
                                            <th style="vertical-align: middle;">Username</th>
                                            <th style="vertical-align: middle;">Email</th>
                                            <th style="vertical-align: middle;">Mobile</th>
                                            <th style="vertical-align: middle;">created at</th>
                                            <th style="vertical-align: middle;">updated_at</th>
                                            <th style="vertical-align: middle;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `tbl_users`";
                                        $result = mysqli_query($link, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <tr>
                                                <td style="vertical-align: middle;"><?php echo $row["id"] ?></td>
                                                <td style="vertical-align: middle;"><?php echo $row["user_role_id"] ?></td>
                                                <td style="vertical-align: middle;"><?php echo $row["full_name"] ?></td>
                                                <td style="vertical-align: middle;"><?php echo $row["username"] ?></td>
                                                <td style="vertical-align: middle;"><?php echo $row["email"] ?></td>
                                                <td style="vertical-align: middle;"><?php echo $row["mobile"] ?></td>
                                                <td style="vertical-align: middle;"><?php echo $row["created_at"] ?></td>
                                                <td style="vertical-align: middle;"><?php echo $row["updated_at"] ?></td>
                                                <td class="actions" style="vertical-align: middle;">
                                                    <a href="#" onclick="showData(<?php echo htmlspecialchars($row['id']); ?>)"><i class="las la-eye"></i></a>
                                                    <a href="edit.php?id=<?php echo $row["id"] ?>"><i class="las la-edit"></i></a>
                                                    <a href="delete.php?id=<?php echo $row["id"] ?>"><i class="las la-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                    <tfoot>
                                </table>
                                <!-- script for the table pagination,search, filter and show-->
                                <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                                <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
                                <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
                                <script>
                                    $(document).ready(function() {
                                        $("#example").DataTable();
                                    });
                                </script>
</body>

</html>