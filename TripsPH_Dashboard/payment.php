<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="assets/styles.css" />
    <link rel="stylesheet" href="assets/bootstrap.min.css" />
    <style>
        /* Custom CSS styles */
        input[type="number"],
        input[type="email"] {
            width: 500px;
            /* Set the desired width for the input fields */
            max-width: 100%;
            /* Ensure the input fields don't exceed the container width */
        }

        .invalid {
            color: red;
            font-weight: bold;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="form-group">
            <form action="checkout.php" method="post" onsubmit="return validateForm();">
                <h2>Load Your TripsPH Card</h2>

                <!-- Container 1: RFID and Email -->

                <div class="container">
                    <div class="form-group">
                        <label for="rfid">RFID Number<span class="required"></span>:</label>
                        <input type="text" name="rfid" class="form-control" placeholder="rfid" maxlength="16" required />
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required"></span>:</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                    </div>

                    <!-- Container 2: Payment Method -->
                    <div class="container">
                        <div class="form-group">
                            <!-- Add an id to this label so we can select it in JavaScript -->
                            <label id="payment-method-label">Select Payment Method:<span class="required"></span></label>
                            <div class="radio-group">
                                <input type="radio" id="paymethod1" name="paymethod" value="Card Payment" required="required" />
                                <label for="paymethod1">
                                    <img src="assets/img/png-clipart-powerd-by-stripe-payment-methods-credit-cards-tech-companies-payments.png" width="200" alt="Card Payment" />
                                </label>
                                <input type="radio" id="paymethod2" name="paymethod" value="GCash" required="required" />
                                <label for="paymethod2">
                                    <img src="assets/img/gcash.png" width="200" height="40" alt="GCash" />
                                </label>
                                <input type="radio" id="paymethod3" name="paymethod" value="PayMaya" required="required" />
                                <label for="paymethod3">
                                    <img src="assets/img/paymaya.png" width="200" height="40" alt="PayMaya" />
                                </label>
                            </div>
                        </div>
                    </div>


                    <!-- Container 3: Load Amounts and Button -->
                    <div class="container">
                        <div class="form-group">
                            <label for="amount">Load Amount <span class="required"></span>:</label>
                            <div class="radio-group">
                                <div class="denomination-row">
                                    <input type="radio" id="amount-200" name="amount" value="200">
                                    <label for="amount-200">₱200</label>

                                    <input type="radio" id="amount-250" name="amount" value="250">
                                    <label for="amount-250">₱250</label>

                                    <input type="radio" id="amount-500" name="amount" value="500">
                                    <label for="amount-500">₱500</label>
                                </div>
                                <div class="denomination-row">
                                    <input type="radio" id="amount-550" name="amount" value="550">
                                    <label for="amount-550">₱550</label>

                                    <input type="radio" id="amount-600" name="amount" value="600">
                                    <label for="amount-600">₱600</label>

                                    <input type="radio" id="amount-650" name="amount" value="650">
                                    <label for="amount-650">₱650</label>
                                </div>
                                <div class="denomination-row">
                                    <input type="radio" id="amount-1000" name="amount" value="1000">
                                    <label for="amount-1000">₱1000</label>

                                    <input type="radio" id="amount-1500" name="amount" value="1500">
                                    <label for="amount-1500">₱1500</label>

                                    <input type="radio" id="amount-2000" name="amount" value="2000">
                                    <label for="amount-2000">₱2000</label>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <button type="submit" name="payNowBtn" class="btn btn-lg btn-primary btn-block">Pay Now <span class="fa fa-angle-right"></span></button>
                            <a href="index.php" class="btn btn-lg btn-warning btn-block" style="text-decoration: none; color: inherit;">
                                Back <span class="fa fa-angle-left"></span>
                            </a>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            // Clear any previous invalid classes
            var paymentMethodLabel = document.getElementById('payment-method-label');
            paymentMethodLabel.classList.remove('invalid');

            // Check if a payment method is selected
            var paymentMethod = document.querySelector('input[name="paymethod"]:checked');
            if (!paymentMethod) {
                alert("Please select a payment method.");
                paymentMethodLabel.classList.add('invalid');
                return false; // Prevent form submission
            }

            // Check if a load amount is selected
            var loadAmount = document.querySelector('input[name="amount"]:checked');
            if (!loadAmount) {
                alert("Please select a load amount.");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

        // Show an alert for under maintenance payment methods
        document.getElementById("paymethod2").onclick = function() {
            alert("GCash payment method is under maintenance. Please choose another payment method.");
            return false;
        };

        document.getElementById("paymethod3").onclick = function() {
            alert("PayMaya payment method is under maintenance. Please choose another payment method.");
            return false;
        };
    </script>




</body>

</html>