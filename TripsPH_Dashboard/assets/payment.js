// Set the enter amount field value to the selected denomination value
function submitForm() {
    // Get the selected denomination value
    const denominationValue = document.querySelector('input[name="denomination"]:checked').value;

    // Set the enter amount field value to the selected denomination value
    document.getElementById("amount").value = denominationValue;
}

// Set the pop up window appear if the submit button is clicked
function generateReceipt() {
    // Retrieve values from form inputs
    var denomination = document.querySelector('input[name="denomination"]:checked').value;
    var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    var cardNumber = document.getElementById('card_number').value;
    var email = document.getElementById('email').value;

    // Populate the elements in the floating pop-up window
    document.getElementById('denominationSummary').innerHTML = 'Price: ₱' + denomination;
    document.getElementById('paymentMethodSummary').innerHTML = 'Payment Method: ' + paymentMethod;
    document.getElementById('cardNumberSummary').innerHTML = 'Card Number: ' + cardNumber;
    document.getElementById('emailSummary').innerHTML = 'Email: ' + email;

    // Show the floating pop-up window
    document.getElementById('orderSummary').style.display = 'block';
}

function cancelOrder() {
    // Cancel order logic here
    closePopup();
}

function confirmOrder() {
    // Confirm order logic here
    closePopup();
}

function closePopup() {
    // Hide the floating pop-up window
    document.getElementById('orderSummary').style.display = 'none';
}

document.getElementById('paymentForm').addEventListener('submit', function(event) {
    // Prevent form submission
    event.preventDefault();

    // Call generateReceipt function to display the floating pop-up window
    generateReceipt();
});