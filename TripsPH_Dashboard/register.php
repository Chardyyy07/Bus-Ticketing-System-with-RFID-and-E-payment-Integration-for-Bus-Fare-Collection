<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Purchase</title>
    <link rel="stylesheet" href="assets/styles1.css">
    <link rel="stylesheet" href="assets/styles.css" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <style>
        body {
            background-image: none;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">Purchase Card</h3>
        </div>
        <div class="card-body-ight">
            <div style="width: 800px; height: 1000px; margin: 0px auto; display: flex;">
                <div style="width: 50%; padding-right: 20px; padding-top: 60px;">
                    <form class="" action="" method="post">
                        <div class="form-group pt-3">
                            <label for="full_name">First Name</label>
                            <input type="text" name="full_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="username">Middle Name</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Last address</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </form>
                </div>
                <div style="width: 50%; padding-right: 20px; padding-top: 60px;">
                    <form action="process_payment.php" method="POST">
                        <div class="container">
                            <label for="card_number">Enter Card Number:</label>
                            <input type="number" id="card_number" name="card_number" /><br />

                            <label for="amount">Enter Amount or select option from denominations below:</label>
                            <input type="number" id="amount" name="amount" /><br />

                            <div class="denomination-row">
                                <input type="radio" id="10" name="denomination" value="10" onclick="submitForm()" />
                                <label for="10">₱10</label>

                                <input type="radio" id="20" name="denomination" value="20" onclick="submitForm()" />
                                <label for="20">₱20</label>

                                <input type="radio" id="50" name="denomination" value="50" onclick="submitForm()" />
                                <label for="50">₱50</label>
                            </div>

                            <div class="denomination-row">
                                <input type="radio" id="75" name="denomination" value="75" onclick="submitForm()" />
                                <label for="75">₱75</label>

                                <input type="radio" id="100" name="denomination" value="100" onclick="submitForm()" />
                                <label for="100">₱100</label>

                                <input type="radio" id="200" name="denomination" value="200" onclick="submitForm()" />
                                <label for="200">₱200</label>
                            </div>

                            <div class="denomination-row">
                                <input type="radio" id="500" name="denomination" value="500" onclick="submitForm()" />
                                <label for="500">₱500</label>

                                <input type="radio" id="1000" name="denomination" value="1000" onclick="submitForm()" />
                                <label for="1000">₱1000</label>

                                <input type="radio" id="2000" name="denomination" value="2000" onclick="submitForm()" />
                                <label for="2000">₱2000</label>
                            </div>
                        </div>
                        <style>
                            .center-buttons {
                                display: flex;
                                justify-content: center;

                            }
                        </style>
                        <div style="padding-left: 90px">
                            <button type="submit" class="btn btn-success" name="submit">Save</button>
                            <a href="adminuser.php" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>