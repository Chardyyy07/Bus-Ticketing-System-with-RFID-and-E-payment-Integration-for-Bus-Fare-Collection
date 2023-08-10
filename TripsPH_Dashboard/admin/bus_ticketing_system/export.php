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
$fileName = "Passenger_Transactions_" . date('Y-m-d') . ".xls";

// Fetch records from database
$sql = "SELECT r.*, p.`No.`, p.Entry_Time, p.Entry_Location, p.Exit_Time, p.Exit_Location
        FROM `rfid_transaction` r
        LEFT JOIN `passenger` p ON r.rfid = p.UM_ID AND r.date_created = p.date_created";
$result = mysqli_query($link, $sql);

// Create an array to store the data rows
$dataRows = [];

// Process the data rows
while ($row = mysqli_fetch_assoc($result)) {
    $type = $row["type"];
    if ($type == "loading" || $type == "failed") {
        continue;
    }
    $rowData = [
        $row['No.'],
        $row['ticket_no.'],
        $row['rfid'],
        $row['type'],
        $row['Entry_Time'],
        $row['Entry_Location'],
        $row['Exit_Time'],
        $row['Exit_Location'],
        $row['km_travel'],
        $row['Fare'],
        $row['current_balance'],
        $row['total_balance'],
        $row['valid_until'],
        $row['date_created'],
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
fputcsv($fp, ['ID', 'Ticket No.', 'RFID', 'Type', 'Entry Time', 'Entry Location', 'Exit Time', 'Exit Location',  'Km Travelled', 'Fare', 'Current Balance', 'Total Balance', 'Card Expiration', 'Date Created'], "\t");

// Write the data rows to the Excel file
foreach ($dataRows as $rowData) {
    fputcsv($fp, $rowData, "\t");
}

// Close the file pointer
fclose($fp);

// Exit the script
exit;
