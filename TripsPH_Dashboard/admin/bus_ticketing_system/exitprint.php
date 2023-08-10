<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tripsph";

// Create a new mysqli connection
$link = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// SQL query
$sql = "SELECT `Exit_Time`, `Exit_Location`, `Fare`, `km_travel`
        FROM `passenger`
        WHERE `Completed` = 'Completed'
        ORDER BY `No.` DESC
        LIMIT 1";

// Execute the query
$result = $link->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch the row as an associative array
    $row = $result->fetch_assoc();

    // Echo the retrieved data
   echo "Exit Status: Completed" . "\n";
    echo "Date and Time: " . $row['Exit_Time'] . "\n";
    echo "Exit Location: " . $row['Exit_Location'] . "\n";
    echo "Fare Deducted: " . $row['Fare'] . "\n";
    echo "KM Traveled: " . $row['km_travel'] . "\n" . "\n";

    echo "All Rights Reserved" . "\n";
   
} else {
   // echo "No data found.";
}

// Close the database connection
$link->close();
?>