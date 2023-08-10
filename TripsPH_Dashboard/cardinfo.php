<?php
// Include the config file
require_once('admin/config.php');

$latestTotalBalance = null;
$passengerResult = null;
$reloadResult = null;
$passengerMessage = null;
$reloadMessage = null;
$latestTotalBalance = 0;
$reloadMessage = null;  //

if (isset($_POST['submit'])) {
    $rfid = $_POST['rfid'];

    // Passenger Transaction History
    $passengerSql = "SELECT r.*, p.`No.`, p.Entry_Time, p.Entry_Location, p.Exit_Time, p.Exit_Location
                    FROM `rfid_transaction` r
                    LEFT JOIN `passenger` p ON r.rfid = p.UM_ID AND r.date_created = p.date_created
                    WHERE r.rfid = ?";
    $passengerStmt = mysqli_prepare($link, $passengerSql);
    mysqli_stmt_bind_param($passengerStmt, "s", $rfid);
    mysqli_stmt_execute($passengerStmt);
    $passengerResult = mysqli_stmt_get_result($passengerStmt);

    // User reload Transaction History
    $reloadSql = "SELECT r.*, h.id, h.email, h.paymethod, h.payment_status, h.payment_intent
                  FROM `rfid_transaction` r
                  LEFT JOIN `tbl_reload_history` h ON r.rfid = h.rfid AND DATE(r.date_created) = DATE(h.created_at)
                  WHERE r.rfid = ?
                  AND NOT ((r.type = 'failed' AND h.payment_status = 'completed') OR (r.type = 'loading' AND h.payment_status = 'failed') OR r.type IN ('Insufficient Balance', 'Departed', 'Arrived'))";
    $reloadStmt = mysqli_prepare($link, $reloadSql);
    mysqli_stmt_bind_param($reloadStmt, "s", $rfid);
    mysqli_stmt_execute($reloadStmt);
    $reloadResult = mysqli_stmt_get_result($reloadStmt);

    // Latest Total Balance
    $latestBalanceSql = "SELECT total_balance
                        FROM `rfid_transaction`
                        WHERE rfid = ?
                        ORDER BY date_created DESC
                        LIMIT 1";
    $latestBalanceStmt = mysqli_prepare($link, $latestBalanceSql);
    mysqli_stmt_bind_param($latestBalanceStmt, "s", $rfid);
    mysqli_stmt_execute($latestBalanceStmt);
    $latestBalanceResult = mysqli_stmt_get_result($latestBalanceStmt);
    $latestBalanceRow = mysqli_fetch_assoc($latestBalanceResult);

    if ($latestBalanceRow !== null) {
        $latestTotalBalance = $latestBalanceRow["total_balance"];
    }

    if (mysqli_num_rows($reloadResult) === 0) {
        $reloadMessage = "No user reload transaction records found for the RFID card.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>TripsPH User Transactions</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/styles1.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<style>
    td.center {
        text-align: center;
    }
</style>

<body>
    <div class="main-content">
        <div class="container">
            <main>
                <div class="page-content">
                    <div class="transaction-history">
                        <h2 class="text-center">View Past Transaction</h2>
                        <div class="text-center mb-4">
                            <?php if (isset($latestTotalBalance)) : ?>
                                <h3 class="badge badge-lg badge-success text-white" style="font-size: 24px;">Available Balance: ₱<?php echo $latestTotalBalance; ?></h3>
                            <?php endif; ?>
                        </div>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="rfid">Enter RFID Card Number:</label>
                                <br>
                                <input type="text" id="rfid" name="rfid" class="form-control" value="<?php echo isset($rfid) ? htmlspecialchars($rfid) : ''; ?>" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-primary">View Transactions</button>
                                <a href="index.php" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>

                    <?php if (!empty($passengerResult)) : ?>
                        <div class="container">
                            <main>
                                <div class="page-content">
                                    <div class="transaction-history">
                                        <!-- Passenger Transaction History -->
                                        <h2 class="text-center">Travel History</h2>
                                        <?php if (isset($passengerMessage)) : ?>
                                            <p class="text-center"><?php echo $passengerMessage; ?></p>
                                        <?php else : ?>
                                            <?php if (mysqli_num_rows($passengerResult) === 0) : ?>
                                                <p class="text-center">No user travel history records found for the RFID card.</p>
                                            <?php else : ?>
                                                <div class="record-header">
                                                    <div class="records table-responsive">
                                                        <table id="passenger-table" class="table table-striped" style="width: 100%; text-align: center; vertical-align: middle;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align: center; vertical-align: middle;">Ticket No.</th>
                                                                    <th style="text-align: center; vertical-align: middle;">RFID</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Type</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Entry Time</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Entry Location</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Exit Time</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Exit Location</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Fare</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Km. Travelled</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Current Balance</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Total Balance</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Valid Until</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Date Created</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php while ($row = mysqli_fetch_assoc($passengerResult)) : ?>
                                                                    <?php
                                                                    // Display passenger transaction records
                                                                    // Exclude rows with "loading" and "failed" types
                                                                    $type = $row["type"];
                                                                    if ($type === "loading" || $type === "failed") {
                                                                        continue;
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["ticket_no."] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["rfid"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                            <?php
                                                                            if ($type == "Insufficient Balance") {
                                                                                echo "<span class='badge badge-lg badge-danger text-white'>Insufficient Balance</span>";
                                                                            } elseif ($type == "Arrived") {
                                                                                echo "<span class='badge badge-lg badge-info text-white'>Arrived</span>";
                                                                            } elseif ($type == "Departed") {
                                                                                echo "<span class='badge badge-lg badge-success text-white'>Departed</span>";
                                                                            } else {
                                                                                echo $type;
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["Entry_Time"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["Entry_Location"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["Exit_Time"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["Exit_Location"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;">₱<?php echo $row["Fare"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["km_travel"] ?> km</td>
                                                                        <td style="text-align: center; vertical-align: middle;">₱<?php echo $row["current_balance"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;">₱<?php echo $row["total_balance"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["valid_until"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["date_created"] ?></td>
                                                                    </tr>
                                                                <?php endwhile; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </main>
                        </div>
                    <?php endif; ?>


                    <?php if (!empty($reloadResult)) : ?>
                        <div class="container">
                            <main>
                                <div class="page-content">
                                    <div class="transaction-history">
                                        <!-- User reload Transaction History -->
                                        <h2 class="text-center">TripsPH Card Reloading History</h2>
                                        <?php if (isset($reloadMessage)) : ?>
                                            <p class="text-center"><?php echo $reloadMessage; ?></p>
                                        <?php else : ?>
                                            <?php if (mysqli_num_rows($reloadResult) === 0) : ?>
                                                <p class="text-center">No user reload transaction records found for the RFID card.</p>
                                            <?php else : ?>
                                                <div class="record-header">
                                                    <div class="records table-responsive">
                                                        <table id="reload-table" class="table table-striped" style="width: 100%; text-align: center; vertical-align: middle;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align: center; vertical-align: middle;">Ticket No.</th>
                                                                    <th style="text-align: center; vertical-align: middle;">RFID</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Type</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Email</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Payment Method</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Payment Status</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Payment Intent</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Amount</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Current Balance</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Total Balance</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Card Expiration</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Date Created</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php while ($row = mysqli_fetch_assoc($reloadResult)) : ?>
                                                                    <!-- Display user reload transaction records here -->
                                                                    <tr>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["ticket_no."] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["rfid"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                            <?php
                                                                            $type = $row["type"];
                                                                            if ($type == "loading") {
                                                                                echo "<span class='badge badge-lg badge-warning text-white'>Loading</span>";
                                                                            } elseif ($type == "failed") {
                                                                                echo "<span class='badge badge-lg badge-danger text-white'>Failed</span>";
                                                                            } elseif ($type == "Expired") {
                                                                                echo "<span class='badge badge-lg badge-dark text-white'>Expired</span>";
                                                                            } else {
                                                                                echo $type;
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["email"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["paymethod"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                            <?php
                                                                            $status = $row["payment_status"];
                                                                            if ($status == "Completed") {
                                                                                echo "<span class='badge badge-success'>Completed</span>";
                                                                            } elseif ($status == "Failed") {
                                                                                echo "<span class='badge badge-danger'>Failed</span>";
                                                                            } elseif ($status == "Pending") {
                                                                                echo "<span class='badge badge-primary'>Pending</span>";
                                                                            } else {
                                                                                echo $status;
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["payment_intent"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;">₱<?php echo $row["amount"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;">₱<?php echo $row["current_balance"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;">₱<?php echo $row["total_balance"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["valid_until"] ?></td>
                                                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["date_created"] ?></td>
                                                                    </tr>
                                                                <?php endwhile; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </main>
                        </div>
                    <?php endif; ?>

                </div>
            </main>
        </div>
    </div>

    <!-- Add DataTables JS library and initialization -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#passenger-table').DataTable();
            $('#reload-table').DataTable();
        });
    </script>
</body>

</html>