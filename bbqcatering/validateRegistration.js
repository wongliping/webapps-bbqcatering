    function validateRegistration() 
    {
    'use strict';

    
    // ======================= Obtain form values ====================================
    var firstname = document.getElementById('firstname');
    var lastname = document.getElementById('lastname');
    var email = document.getElementById('email');
    var phone = document.getElementById('phone');
    var username = document.getElementById('username');
    var password_1 = document.getElementById('password_1');
    var password_2 = document.getElementById('password_2');
    var informationerror = [];
    var credentialerror = [];
    var username_check = [];
    var email_check = []; 

    // ======================= Regexp values====================================
    var namecheck = /^[A-Za-z\s]+$/;
    var usercheck = /^[a-z\d]+$/i;
    var emailcheck = /^\w+([\.-]?\w+)*@\w+((\.\w+){0,2})((\.\w{2,3}){1})$/i;
    var phonecheck = /^\d{8}$/;
    var passwordcheck = /^[a-zA-Z0-9!@#$&()\\-`.+,/\"]{8,20}$/;

    // ======================= Information ====================================
    if (firstname.value.trim().length > 0)
    {
        if (namecheck.test(firstname.value) != true ) {
         informationerror.push('First name should only contain alphabetetic characters');
        }
    }
    else
    {
        informationerror.push('First name is empty');
    }

    if (lastname.value.trim().length > 0)
    {
        if (namecheck.test(lastname.value) != true ) {
         informationerror.push('Last name should only contain alphabetetic characters');
        }
    }
    else
    {
        informationerror.push('Last name is empty');
    }


    if (phone.value.trim().length > 0)
    {
        if (phonecheck.test(phone.value) != true ) {
         informationerror.push('Please key in a valid Singapore number without spaces');
        }
    }
    else
    {
        informationerror.push('Phone number is empty');
    }

    if (email.value.trim().length > 0)
    {
        if ( emailcheck.test(email.value) != true){
        informationerror.push('Please key the correct email format');
        }
    }
    else{
        informationerror.push('Email is empty');
    }

    // ======================= Credentials ====================================
    if (password_1.value.trim().length > 0 && password_2.value.trim().length >0){
        if (password_1.value != password_2.value){
        credentialerror.push('Passwords do not match');
        }
        if (passwordcheck.test(password_1.value) !=true | passwordcheck.test(password_2.value) !=true ){
        credentialerror.push('Password should be at least 8 characters long, alphanumeric characters, no spaces and special characters')
    }
    }
    else{
        credentialerror.push('Either one or both of the password fields are empty');
    }


    if (username.value.trim().length > 0)
    {
        if (usercheck.test(username.value) != true ) {
         credentialerror.push('Please key only alphabetic characters without spaces');
        }
    }
    else
    {
        credentialerror.push('username is empty');
    }

    // ======================= Display error ====================================
    if (credentialerror.length > 0 | informationerror.length > 0)
    {
    if (informationerror.length != 0 )
    {
    document.getElementById("informationerror").innerHTML = informationerror.join("<br>");
    }
    else
    {
    document.getElementById("informationerror").innerHTML = ''; 
    }

    if (credentialerror.length !=0 )
    {
    document.getElementById("credentialerror").innerHTML = credentialerror.join("<br>");
    }
    else
    {
    document.getElementById("credentialerror").innerHTML = ''; 
    }
    return false;
    }
    else
    {   
    return true;
    }
}

function init(){
    var signupForm = document.getElementById("signupForm");
    signupForm.onsubmit = validateRegistration;
}

window.onload = init;