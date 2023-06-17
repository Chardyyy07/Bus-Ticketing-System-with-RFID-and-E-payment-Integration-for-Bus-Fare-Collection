<?php
include "../../admin/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $full_name = $_POST["full_name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];
    $user_role_id = $_POST["user_role_id"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $query = "INSERT INTO tbl_users (full_name, username, email, mobile, password, user_role_id) VALUES ('$full_name', '$username', '$email', '$mobile', '$hashedPassword', '$user_role_id')";

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
            <h3 class="text-center">Add New User</h3>
        </div>
        <div class="card-body">
            <div style="width:600px; margin:0px auto">
                <form class="" action="" method="post">
                    <div class="form-group pt-3">
                        <label for="full_name">Your name</label>
                        <input type="text" name="full_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="username">Your username</label>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" name="mobile" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="user_role_id">Select user Role</label>
                            <select class="form-control" name="user_role_id" id="user_role_id">
                                <?php
                                $role_query = "SELECT * FROM tbl_user_role";
                                $role_result = mysqli_query($link, $role_query);
                                while ($row = mysqli_fetch_assoc($role_result)) {
                                    $role_id = $row['id'];
                                    $role_name = $row['user_role'];
                                    echo "<option value='$role_id'>$role_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success" name="submit">Save</button>
                        <a href="adminuser.php" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>