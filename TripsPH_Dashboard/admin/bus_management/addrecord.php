<?php
include "../../admin/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $busno = $_POST["busno"];
    $type = $_POST["type"];
    $purchdate = $_POST["purchdate"];
    $operator = $_POST["operator"];
    $driver = $_POST["driver"];
    $route = $_POST["route"];
    $status = $_POST["status"];

    // Insert data into the database
    $query = "INSERT INTO tbl_bus_management (busno, type, purchdate, operator, driver, route, status) VALUES ('$busno', '$type', '$purchdate', '$operator', '$driver', '$route', '$status')";

    if (mysqli_query($link, $query)) {
        // Data inserted successfully
        header("Location: bus_management.php?msg=New record created successfully");
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
            <h3 class="text-center">Add New Bus</h3>
        </div>
        <div class="card-body">
            <div style="width:600px; margin:0px auto">
                <form class="" action="" method="post">
                    <div class="form-group pt-3">
                        <label for="busno">Bus Number</label>
                        <input type="text" name="busno" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <input type="text" name="type" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="purchdate">Purchase Date</label>
                        <input type="date" name="purchdate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="operator">Operator</label>
                        <input type="text" name="operator" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="driver">Driver</label>
                        <input type="text" name="driver" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="route">Route</label>
                        <input type="text" name="route" class="form-control">
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="in-service">In Service</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="not available">Not Available</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success" name="submit">Save</button>
                        <a href="bus_management.php" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>