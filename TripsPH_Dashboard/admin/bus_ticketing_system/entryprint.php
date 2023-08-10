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
$sql = "SELECT `No.`, Completed, UM_ID, Entry_Time, Entry_Location
        FROM passenger
        WHERE Completed = 'Not Yet'
        ORDER BY `No.` DESC
        LIMIT 1";

// Execute the query
$result = $link->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch the row as an associative array
    $row = $result->fetch_assoc();

    // Echo the retrieved data with newline characters
    
    echo "" . "\n" ;

    echo "Entry Status: Success" . "\n";
    echo "Ticket/Control No: " . $row['No.'] . "\n";
    echo "Card UID: " . $row['UM_ID'] . "\n";  
    echo "Date and Time: " . $row['Entry_Time'] . "\n";
    echo "Departure Location: " . $row['Entry_Location'] . "\n" . "\n" ;

    echo "EARIST, Main Campus" . "\n";
    echo "TRIPS PH TEAM" . "\n";
    echo "Have a Safe Journey!" . "\n" ;
    //echo "Status:" . $row['Completed'] . "\n";
} else {
    echo "No data found.";
}

// Close the database connection
$link->close();
?>
