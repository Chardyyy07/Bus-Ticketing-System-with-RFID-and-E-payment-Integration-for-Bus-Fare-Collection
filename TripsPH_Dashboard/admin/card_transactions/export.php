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
$fileName = "Reloading_Transactions_" . date('Y-m-d') . ".xls";

// Fetch records from database
$sql = "SELECT r.*, h.id, h.email, h.paymethod, h.payment_status, h.payment_intent
        FROM `rfid_transaction` r
        LEFT JOIN `tbl_reload_history` h ON r.rfid = h.rfid AND DATE(r.date_created) = DATE(h.created_at)
        WHERE NOT ((r.type = 'failed' AND h.payment_status = 'completed') OR (r.type = 'loading' AND h.payment_status = 'failed') OR r.type IN ('Insufficient Balance', 'Departed', 'Arrived'))";

$result = mysqli_query($link, $sql);

// Create an array to store the data rows
$dataRows = [];

// Process the data rows
while ($row = mysqli_fetch_assoc($result)) {
    $rowData = [
        $row['id'],
        $row['ticket_no.'],
        $row['rfid'],
        $row['email'],
        $row['type'],
        $row['amount'],
        $row['paymethod'],
        $row['payment_status'],
        $row['payment_intent'],
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
fputcsv($fp, ['ID', 'Ticket No.', 'RFID', 'Email', 'Type', 'Amount', 'Payment Method', 'Payment Status', 'Payment Intent', 'Current Balance', 'Total Balance', 'Card Expiration', 'Date Created'], "\t");

// Write the data rows to the Excel file
foreach ($dataRows as $rowData) {
    fputcsv($fp, $rowData, "\t");
}

// Close the file pointer
fclose($fp);

// Exit the script
exit;
