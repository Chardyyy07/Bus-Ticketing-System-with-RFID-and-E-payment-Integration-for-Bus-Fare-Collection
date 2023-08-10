<?php
// Initialize the session
session_start();

// Include the config file
require_once('../../admin/config.php');

// Filter the excel data
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download
$fileName = "TripsPH All Transactions " . date('Y-m-d') . ".xls";

// Fetch records from database
$sql = "SELECT r.*, p.Entry_Time, p.Entry_Location, p.Exit_Time, p.Exit_Location
FROM `rfid_transaction` r
LEFT JOIN `passenger` p ON r.rfid = p.UM_ID AND r.date_created = p.date_created
ORDER BY r.id ASC"; // Changed 'rh.id' to 'r.id'

$result = mysqli_query($link, $sql);

// Create an array to store the data rows
$dataRows = [];

// Process the data rows
while ($row = mysqli_fetch_assoc($result)) {
    $rowData = [
        $row['id'],
        $row['ticket_no.'],
        $row['rfid'],
        $row['type'],
        $row['amount'],
        $row['Entry_Time'],
        $row['Entry_Location'],
        $row['Exit_Time'],
        $row["Exit_Location"],
        $row["Fare"],
        $row["km_travel"],
        $row["current_balance"],
        $row["total_balance"],
        $row["valid_until"],
        $row["date_created"],
    ];

    // Filter the data to handle special characters
    array_walk($rowData, 'filterData');

    // Add the filtered data to the array
    $dataRows[] = $rowData;
}

// Headers for download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");
header("Pragma: no-cache");
header("Expires: 0");

// Create a file pointer connected to the output stream
$fp = fopen('php://output', 'w');

// Write column names to the Excel file
fputcsv($fp, ['ID', 'Ticket No.', 'RFID', 'Type', 'Amount', 'Entry Time', 'Entry Location', 'Exit Time', 'Exit Location', 'Fare', 'Km Travelled', 'Current Balance', 'Total Balance', 'Card Expiration', 'Date Created'], "\t");

// Write the data rows to the Excel file
foreach ($dataRows as $rowData) {
    fputcsv($fp, $rowData, "\t");
}

// Close the file pointer
fclose($fp);

// Exit the script
exit;
