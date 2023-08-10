<?php
// Initialize the session
session_start();

// Include the config file
require_once('../admin/config.php');

// Function to filter the data for Excel
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

try {
    // Excel file name for download
    $fileName = "Cards_Registered_" . date('Y-m-d') . ".xls";

    // Fetch records from the database
    $sql = "SELECT r.rfid, r.total_balance, r.valid_until, r.date_created
            FROM `rfid_transaction` r
            INNER JOIN (
                SELECT rfid, MAX(date_created) as max_date_created
                FROM `rfid_transaction`
                GROUP BY rfid
            ) t ON r.rfid = t.rfid AND r.date_created = t.max_date_created";

    $result = mysqli_query($link, $sql);

    // Create an array to store the data rows
    $dataRows = [];

    // Process the fetched data and store it in the $dataRows array
    while ($row = mysqli_fetch_assoc($result)) {
        $rowData = [
            $row["rfid"],
            $row["total_balance"],
            $row["valid_until"],
            $row["date_created"]
        ];
        array_push($dataRows, $rowData);
    }

    // Set the HTTP response headers for download
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Create a file pointer connected to the output stream
    $fp = fopen('php://output', 'w');

    // Write column names to the Excel file
    fputcsv($fp, ['RFID', 'Total Balance', 'Card Expiration', 'Date Created'], "\t");

    // Write the data rows to the Excel file
    foreach ($dataRows as $rowData) {
        array_walk($rowData, 'filterData');
        fputcsv($fp, $rowData, "\t");
    }

    // Close the file pointer
    fclose($fp);

    // Exit the script
    exit;
} catch (Exception $e) {
    // Handle any exceptions or errors that might occur
    echo "Error: " . $e->getMessage();
    exit;
}
