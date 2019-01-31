var constraints = {
    firstName: /^[A-Za-z][A-Za-z\s]*[A-Za-z]$/, //start and end with a letter; contain letters/spaces in between
    lastName: /^[A-Za-z][A-Za-z\s]*[A-Za-z]$/, 
    // email: /^\w+[\w.-]*\w+@(?=[\w])\w*(\.\w+){0,2}\.\w{2,3}$/,
    email: /^\w+[\w.-]*\w+@(?=[\w])\w*(\.\w+){0,2}$/,
    phoneNo: /^[0-9]{8}$/, //8 digits
    address: /^[A-Za-z0-9][A-Za-z0-9#\s]*$/,
    country: /^[A-Za-z][A-Za-z\s]*[A-Za-z]$/, 
    postalCode: /^[0-9]{6}$/, //6 digits
    ref_no: /^F38EE[0-9]{6}$/
};

function clearErrorMsg() {
    'use strict';
    for (var i = 0; i < arguments.length; i++) {
        if (arguments[i].nextElementSibling != null && arguments[i].nextElementSibling.className == "errorMsg") {
            arguments[i].nextElementSibling.remove();
        }
    }
}

function displayError(input, error) {
    'use strict';
    var errorElement = document.createElement("div");
    errorElement.className="errorMsg";
    errorElement.appendChild(document.createTextNode(error));
    input.parentNode.insertBefore(errorElement, input.nextSibling);
}

function validateCheckout() {
    'use strict';
    var hasError = false;
    // Get references to form elements
    var firstName = document.getElementById("firstName");
    var lastName = document.getElementById("lastName");
    var email = document.getElementById("email");
    var phoneNo = document.getElementById("phoneNo");
    var address = document.getElementById("address");
    var country = document.getElementById("country");
    var postalCode = document.getElementById("postalCode");
    var deliveryDate = document.getElementById("deliveryDate");
    var deliveryTime = document.getElementsByName("deliveryTime");
    var deliveryTimeDiv = document.getElementById("timeDiv");

    clearErrorMsg(firstName, lastName, email, phoneNo, address, country, postalCode, deliveryDate, deliveryTimeDiv);

    // validate first name
    if (firstName.value.trim().length === 0) {
        displayError(firstName,"This field cannot be empty.");
        hasError = true;
    }
    else if (!constraints['firstName'].test(firstName.value)) {
        displayError(firstName,"First Name should contain only alphabet character and/or spaces.");
        hasError = true;
    }

    // validate last name
    if (lastName.value.trim().length === 0) {
        displayError(lastName,"This field cannot be empty.");
        hasError = true;
    }
    else if (!constraints['lastName'].test(lastName.value)) {
        displayError(lastName,"Last Name should contain only alphabet character and/or spaces.");
        hasError = true;
    }

    // validate email
    if (email.value.trim().length === 0) {
        displayError(email,"This field cannot be empty.");
        hasError = true;
    }
    else if (!constraints['email'].test(email.value)) {
        displayError(email,"Email format is incorrect.");
        hasError = true;
    }

    // validate phone number
    if (phoneNo.value.trim().length === 0) {
        displayError(phoneNo,"This field cannot be empty.");
        hasError = true;
    }
    else if (!constraints['phoneNo'].test(phoneNo.value)) {
        displayError(phoneNo,"Please enter a valid 8-digits phone number.");
        hasError = true;
    }

    // validate address
    if (address.value.trim().length === 0) {
        displayError(address,"This field cannot be empty.");
        hasError = true;
    }
    else if (!constraints['address'].test(address.value)) {
        displayError(address,"Please enter a valid address.");
        hasError = true;
    }

    // validate country
    if (country.value.trim().length === 0) {
        displayError(country,"This field cannot be empty.");
        hasError = true;
    }
    else if (!constraints['country'].test(country.value)) {
        displayError(country,"Please enter a valid country.");
        hasError = true;
    }

    // validate postal code
    if (postalCode.value.trim().length === 0) {
        displayError(postalCode,"This field cannot be empty.");
        hasError = true;
    }
    else if (!constraints['postalCode'].test(postalCode.value)) {
        displayError(postalCode,"Please enter a valid 6 digits postal code.");
        hasError = true;
    }

    // validate delivery date
    if (deliveryDate.value.trim().length === 0) {
        displayError(deliveryDate,"Please select a delivery date.");
        hasError = true;
    }

    // validate delivery time
    var timeSelect = false;
    for (var i = 0; i < deliveryTime.length; i++) {
        if (deliveryTime[i].checked) {
            timeSelect = true;
        }
    }
    if (!timeSelect) {
        displayError(deliveryTimeDiv, "Please select a delivery time.");
        hasError = true;
    }

    // return true is no error
    if (hasError) {
        return false;
    }
    else {
        return confirm("Confirm to checkout?");
    }
}

function validateCheckOrder() {
    'use strict';
    var ref_no = document.getElementById("refNo").value.toUpperCase();
    console.log(ref_no);
    if (!constraints['ref_no'].test(ref_no)) {
        alert("Please enter a valid reference number (F38EEXXXXXX).");
        return false;
    }
    else {
        return true;
    }
}

function validateFeedback() {
    'use strict';
    var feedback = document.getElementById("feedback").value;
    if (feedback.trim().length == 0) {
        alert("Feedback field cannot be left blank.");
        return false;
    }
    else {
        return true;
    }
}

function blockdate(dateId) {
    'use strict';

    var today = new Date();
    var yy = today.getFullYear();
    var mm = today.getMonth() + 1;
    var dd = today.getDate() + 1;
    var mindate = [yy, (mm > 9 ? '' : '0') + mm, (dd > 9 ? '' : '0') + dd].join('-');
    document.getElementById(dateId).setAttribute("min", mindate);
}

function init() {
    'use strict';

    // Confirm that document.getElementById() can be used:
    if (document && document.getElementById) {
        var sPath = window.location.pathname;
        var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
        if (sPage == "checkout.php"){
            blockdate("deliveryDate");
            var checkoutForm = document.getElementById('checkoutForm');
            checkoutForm.onsubmit = validateCheckout;
        }
        if (sPage == "checkorder.php"){
            var checkorderForm = document.getElementById("checkorderForm");
            checkorderForm.onsubmit = validateCheckOrder;
        }
        if (sPage == "feedback.php"){
            var feedbackForm = document.getElementById("feedbackForm");
            feedbackForm.onsubmit = validateFeedback;
        }
    }
} // End of init() function.

// Assign an event listener to the window's load event:
window.onload = init;