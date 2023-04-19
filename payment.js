// Set the enter amount field value to the selected denomination value
function submitForm() {
    // Get the selected denomination value
    const denominationValue = document.querySelector('input[name="denomination"]:checked').value;

    // Set the enter amount field value to the selected denomination value
    document.getElementById("amount").value = denominationValue;
}

function generateReceipt() {
    // Get the selected denomination value
    let denomination = document.querySelector('input[name="denomination"]:checked').value;

    // Get the selected payment method
    let paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

    // Get the email address entered by the user
    let email = document.getElementById('email').value;

    // Create a receipt string with the selected denomination, payment method, and email address
    let receipt = `Denomination: ₱${denomination}\nPayment Method: ${paymentMethod}\nEmail: ${email}`;

    // Open a new window with a receipt.html file
    let receiptWindow = window.open('receipt.html', '_blank');

    // Write the receipt string to the new window
    receiptWindow.document.write(`<pre>${receipt}</pre>`);
}