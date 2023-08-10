<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tripsph";
$complete = $umid = $timeentry = $location1 = $timeexit = $location2 = $fare = $current_balance = "";

// Create a connection to the database
$link = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Retrieve the values sent by the ESP8266
$complete = isset($_POST["complete"]) ? test_input($_POST["complete"]) : "";
$umid = isset($_POST["umid"]) ? test_input($_POST["umid"]) : "";
$timeentry = isset($_POST["timeentry"]) ? test_input($_POST["timeentry"]) : "";
$location1 = isset($_POST["location1"]) ? test_input($_POST["location1"]) : "";
$timeexit = isset($_POST["timeexit"]) ? test_input($_POST["timeexit"]) : "";
$location2 = isset($_POST["location2"]) ? test_input($_POST["location2"]) : "";
$fare = isset($_POST["fare"]) ? test_input($_POST["fare"]) : "";
$current_balance = isset($_POST["current_balance"]) ? test_input($_POST["current_balance"]) : "";
$km_travel = isset($_POST["km_travel"]) ? test_input($_POST["km_travel"]) : "";


// Check if the UM_ID already exists in the database
$sql = "SELECT UM_ID, Completed, current_balance FROM passenger WHERE UM_ID = '" . $umid . "'";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $existingCompleted = $row["Completed"];
    $existingBalance = $row["current_balance"];

    if ($existingCompleted === "Completed") {
        // The row has "Completed" value in the Complete column, proceed with insert
        insertData();
    } else {
        // The row does not have "Completed" value in the Complete column, perform an update
        updateData();
    }

    // ???
    //echo "Balance: " . $existingBalance;

} else {
    // UM_ID does not exist, perform an insert
    insertData();
}

// Close the database connection
$link->close();


function insertData()
{

    global $link, $complete, $umid, $timeentry, $location1, $timeexit, $location2, $fare, $current_balance;

    $sql = "INSERT INTO passenger (Completed, UM_ID, Entry_Time, Entry_Location, Exit_Time, Exit_Location, Fare, current_balance)
            VALUES ('" . $complete . "', '" . $umid . "', '" . $timeentry . "', '" . $location1 . "', '" . $timeexit . "', '" . $location2 . "', '" . $fare . "', '" . $current_balance . "')";

    if ($link->query($sql) === TRUE) {
        // ???
        //echo "Data inserted successfully";
    } else {
        // ???
        //echo "Error inserting data: " . $conn->error;
    }
}

function updateData()
{
    global $link, $complete, $umid, $timeentry, $location1, $timeexit, $location2, $fare, $current_balance;

    $sql = "UPDATE passenger SET Completed = '" . $complete . "',   Exit_Time = '" . $timeexit . "', Exit_Location = '" . $location2 . "', Fare = '" . $fare . "', current_balance = '" . $current_balance  . "' WHERE UM_ID = '" . $umid . "'";

    if ($link->query($sql) === TRUE) {
        // ???
        echo "Data updated successfully";
    } else {
        // ???
        echo "Error updating data: " . $link->error;
    }
}


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
