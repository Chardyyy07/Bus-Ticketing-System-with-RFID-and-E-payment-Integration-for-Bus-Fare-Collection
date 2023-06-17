<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to the login page
if (!isset($_SESSION['id'], $_SESSION['user_role_id'])) {
    header('location:../../admin/login.php?lmsg=true');
    exit;
}

// Include the config file
require_once('../../admin/config.php');

// Check if the ID parameter is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $_GET['id'];

    // Prepare the SQL query to fetch user details
    $sql = "SELECT u.*, r.user_role FROM `tbl_users` u INNER JOIN `tbl_user_role` r ON u.user_role_id = r.id WHERE u.id = ?";

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
            $full_name = $_POST['full_name'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $user_role_id = $_POST['user_role_id'];

            // Prepare the SQL query to update the user record
            $updateSql = "UPDATE `tbl_users` SET `full_name`=?, `username`=?, `email`=?, `mobile`=?, `user_role_id`=? WHERE `id`=?";

            // Prepare and execute the update statement
            $updateStmt = $link->prepare($updateSql);
            $updateStmt->bind_param("ssssii", $full_name, $username, $email, $mobile, $user_role_id, $userId);
            $updateStmt->execute();

            // Redirect to the user list page after successful update
            header('location: adminuser.php');
            exit;
        }
    } else {
        // User not found, redirect to user list
        header('location: ../admin/adminuser.php');
        exit;
    }
} else {
    // ID parameter not provided, redirect to user list
    header('location: ../admin/adminuser.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>View User</title>
    <link rel="stylesheet" href="assets/styles1.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
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
                        <label for="name">Your name</label>
                        <input type="text" name="full_name" class="form-control" value="<?php echo $user['full_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">Your username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" value="<?php echo $user['mobile']; ?>">
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="sel1">Select user Role</label>
                            <select class="form-control" name="user_role_id" id="user_role_id">
                                <option value="1" <?php if ($user['user_role_id'] == 1) echo 'selected'; ?>>Admin</option>
                                <option value="2" <?php if ($user['user_role_id'] == 2) echo 'selected'; ?>>Editor</option>
                                <option value="3" <?php if ($user['user_role_id'] == 3) echo 'selected'; ?>>User only</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success" name="submit">Save</button>
                        <a href="updatepass.php" class="btn btn-info">Update Password</a>
                        <a href="adminuser.php" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>