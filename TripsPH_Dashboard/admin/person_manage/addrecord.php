<?php
include "../../admin/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $fullname = $_POST["fullname"];
    $position = $_POST["position"];
    $e_mail = $_POST["e_mail"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];

    // Insert data into the database
    $query = "INSERT INTO tbl_personnel (fullname, position, e_mail, contact, address) VALUES ('$fullname', '$position', '$e_mail', '$contact', '$address')";


    if (mysqli_query($link, $query)) {
        // Data inserted successfully
        header("Location: personnel_management.php?msg=New record created successfully");
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="../../assets/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/styles1.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">Add New Personnel</h3>
        </div>
        <div class="card-body">
            <div style="width:600px; margin:0px auto">
                <form class="" action="" method="post">
                    <div class="form-group pt-3">
                        <label for="fullname">Name</label>
                        <input type="text" name="fullname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" name="position" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="e_mail">Email address</label>
                        <input type="email" name="e_mail" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact Number</label>
                        <input type="number" name="contact" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="address" name="address" class="form-control">
                    </div>
                    <div class="text-left">
                        <button type="submit" class="btn btn-success" name="submit">Save</button>
                        <a href="personnel_management.php" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>