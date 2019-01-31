<?php 
    include("config/database.php");
    include("function.php");

    // if cart is empty, redirect to cart page
    // cannot checkout with nothing on cart
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        header("location: cart.php");
    }

?>    
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barbeque Catering - Check Out</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" media="screen" title="text/css" charset="utf-8">
    <script type="text/javascript" src="validateForm.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
</head>
<body>
    <div id="wrapper">
        <header>
            <img id="bbqlogo" src="logo.png">
        </header>

    <!-- NAV BAR  -->
    <?php include 'nav.php';?>

        <div id="content">
        <h2 class="title">Check Out</h2>
        <form id="checkoutForm" action="thankyou.php" method="post">

            <div class="checkoutInfo">
                <h4 class="headingFormat">Contact Information</h4>
                <!-- this section is auto-filled in user is logged in -->
                <input type="text" id="firstName" name="firstName" placeholder="First Name" <?php if (isLoggedin()) { echo 'value="'.$_SESSION['user']['firstname'].'" readonly';}?>>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name" <?php if (isLoggedin()) { echo 'value="'.$_SESSION['user']['lastname'].'" readonly';}?>>
                <input type="email" id="email" name="email" placeholder="Email" <?php if (isLoggedin()) { echo 'value="'.$_SESSION['user']['email'].'" readonly';}?>>
                <input type="text" id="phoneNo" name="phoneNo" placeholder="Phone" <?php if (isLoggedin()) { echo 'value="'.$_SESSION['user']['phone'].'" readonly';}?>>
            </div>

            <div class="checkoutInfo">
                <h4 class="headingFormat">Delivery Address</h4>
                <input type="text" id="address" name="address" placeholder="Address">
                <input type="text" id="country" name="country" placeholder="Country">
                <input type="text" id="postalCode" name="postalCode" placeholder="Postal Code">
            </div>
        
            <div class="checkoutInfo">
                <h4 class="headingFormat">Delivery Details</h4>
                <input type="date" id="deliveryDate" name="deliveryDate" placeholder="Delivery Date">
                <div id="timeDiv">
                    <?php 
                        // retrieve timeslots from database and display as radio buttons
                        $timeslots = mysqli_query($db, "SELECT timeslot FROM delivery_timeslot");
                        while ($row = mysqli_fetch_array($timeslots)) {
                            $timeslot = date('gA', strtotime($row['timeslot']));
                            echo '<input type="radio" name="deliveryTime" class="radio-time" id="'.$timeslot.'" value="'.$timeslot.'">';
                            echo '<label for="'.$timeslot.'" class="timeLbl"> '.$timeslot.' </label>';
                            }
                        ?>
                </div>
            </div>

            <div class="checkoutInfo">
                <h4 class="headingFormat">Special Instruction</h4>
                <textarea type="textarea" name="specialInstruction" rows="4"></textarea>
            </div>
            <a href="cart.php">Back</a>
            <button class="submitBtn" name="checkoutBtn" type="submit">Confirm</button>
        </form>
        </div>
    <footer>
        <small><i>Copyright &copy; 2018 BBQ Catering<br>
        <a href="mailto:bbq@catering.com">bbq@catering.com</a></i></small>
    </footer>
    </div>
</body>
</html>