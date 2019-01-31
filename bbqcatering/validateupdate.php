<script>
    function validateUpdate() 
    {
    'use strict';

    
    // ======================= Obtain form values ====================================
    var firstname = document.getElementById('firstname');
    var lastname = document.getElementById('lastname');
    var email = document.getElementById('email');
    var phone = document.getElementById('phone');
    var informationerror = [];
    var credentialerror = [];
    var username_check = [];
    var email_check = [];

    <?php 
        // email must be unique
        $email_query = "SELECT email from user WHERE user_type ='user' OR user_type='admin'";
        $resultemail = $db->query($email_query); 
        $email_array = array();
        
        while($row = mysqli_fetch_array($resultemail))
        {
        // add each row returned into an array
        $email_array[] = $row;
        }
        $user_email = $_SESSION['user']['email'];


    ?> 
    email_check =<?php echo json_encode($email_array) ?>;  
    // check if email is unchanged
    var user_email = <?php echo json_encode($user_email) ?>;  

    // ======================= Regexp values====================================
    var namecheck = /^[A-Za-z\s]+$/;
    var emailcheck = /^\w+([\.-]?\w+)*@\w+((\.\w+){0,2})((\.\w{2,3}){1})$/i;
    var phonecheck = /^\d{8}$/;

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
        if ( user_email.toLowerCase() != email.value.trim().toLowerCase())
        {
        for(var i=0; i<email_check.length; i++)
        {   
            if(email_check[i].email.toLowerCase() === email.value.trim().toLowerCase())
            {
            informationerror.push('Email is taken');
            }
        }
        }
    }
    else{
        informationerror.push('Email is empty');
    }

    // ======================= Display error ====================================
    if (informationerror.length != 0 ) {
        document.getElementById("informationerror").innerHTML = informationerror.join("<br>");
        return false;
    }
    else {
        alert("Update is successful!");
        return true;
    }
}
</script>