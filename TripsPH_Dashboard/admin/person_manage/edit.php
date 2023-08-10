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

// Check if the ID parameter is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $_GET['id'];

    // Prepare the SQL query to fetch user details
    $sql = "SELECT * FROM `tbl_personnel` WHERE `id` = ?";

    // Prepare and execute the statement
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        // Fetch user details
        $user = $result->fetch_assoc();

        // Check if the form is submitted
        if (isset($_POST['submit'])) {
            // Get the updated form values
            $fullname = $_POST["full_name"];
            $position = $_POST["position"];
            $e_mail = $_POST["e_mail"];
            $contact = $_POST["contact"];
            $address = $_POST["address"];

            // Prepare the SQL query to update the user record
            $updateSql = "UPDATE `tbl_personnel` SET `fullname`=?, `position`=?, `e_mail`=?, `contact`=?, `address`=? WHERE `id`=?";

            // Prepare and execute the update statement
            $updateStmt = $link->prepare($updateSql);
            $updateStmt->bind_param("sssssi", $fullname, $position, $e_mail, $contact, $address, $userId);
            $updateStmt->execute();

            // Redirect to the user list page after successful update
            header('location: personnel_management.php');
            exit;
        }
    } else {
        // User not found, redirect to user list
        header('location: ../../admin/personnel_management.php');
        exit;
    }
} else {
    // ID parameter not provided, redirect to user list
    header('location: ../../admin/personnel_management.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="../../assets/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/styles1.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">Edit User</h3>
        </div>
        <div class="card-body">
            <div style="width:600px; margin:0px auto">
                <form class="" action="" method="post">

                    <div class="form-group pt-3">
                        <label for="fullname">Your name</label>
                        <input type="text" name="full_name" class="form-control" value="<?php echo $user['fullname']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="position">Your position</label>
                        <input type="text" name="position" class="form-control" value="<?php echo $user['position']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="e_mail">Email address</label>
                        <input type="email" name="e_mail" class="form-control" value="<?php echo $user['e_mail']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="text" name="contact" class="form-control" value="<?php echo $user['contact']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" value="<?php echo $user['address']; ?>">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success" name="submit">Save</button>
                        <a href="personnel_management.php" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>