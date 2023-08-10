<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tripsph";

// Create a new mysqli connection
$link = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Query to select the latest row for the total_balance column
$sql = "SELECT total_balance FROM rfid_transaction ORDER BY id DESC LIMIT 1";
$result = $link->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch the row as an associative array
    $row = $result->fetch_assoc();
    
    // Check if there is a result
    if ($row) {
        // Get the total_balance value from the row
        $total_balance = $row['total_balance'];
        
        // Output the result
        echo "Exit Money: " . $total_balance;
        echo "" . "\n" ;
    } else {
        echo "No records found.";
    }
} else {
    echo "Error: " . $link->error;
}

// Close the connection when done
$link->close();
?>
