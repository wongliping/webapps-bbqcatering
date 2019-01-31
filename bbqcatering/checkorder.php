<?php 
    include("config/database.php");
    include("function.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barbeque Catering - Check Order</title>
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
            <h2 class="title">Check Order</h2>
            <form id="checkorderForm" method="post">
                <h4 class="headingFormat">Check Order with email or reference number</h4>
                <div>
                    <input type="text" id="refNo" name="refNo" placeholder="Reference No." <?php if (isset($_POST['refNo'])) {echo 'value='.$_POST['refNo']; } ?>>
                    <button class="submitBtn" id="checkOrderBtn" name="checkOrderBtn" type="submit">Search</button>
                </div>
            </form>

            <?php
                // update the order status if delivery date has passed
                updateTransacStatus();

                if (isLoggedin()) {
                    
                    $user_id = $_SESSION['user']['user_id'];

                    if (!isset($_POST['checkOrderBtn'])){

                        // default for logged in user
                        $trans_record = mysqli_query($db, "SELECT * FROM `transactions` WHERE user_id='$user_id'");
                        
                        if (mysqli_num_rows($trans_record) != 0){         
                            displayOrder($trans_record); // display all user's transaction records if exist
                        }                     
                        else { 
                            echo '<div style="text-align: center;"> You have no order records with us yet.</div>'; // if no transaction record found
                        }
                    }
                    else {
                        // if logged-in user search with a reference number
                        $trans_id = decodeRefNo($_POST['refNo']);
                        $trans_record = mysqli_query($db, "SELECT * FROM `transactions` WHERE user_id='$user_id' AND transaction_id='$trans_id'");
                        
                        if (mysqli_num_rows($trans_record) != 0){
                            displayOrder($trans_record); // display transaction information if record exist
                        }
                        else {
                            echo '<div style="text-align: center;"> No record found for Reference No. '.$_POST['refNo'].'.</div>'; // if reference number not found
                        }
                    }
                        
                }             
                elseif (!isLoggedin() && isset($_POST['checkOrderBtn'])) {
                    // if non-logged-in user search with a reference number
                    $trans_id = decodeRefNo($_POST['refNo']);
                    $trans_record = mysqli_query($db, "SELECT * FROM `transactions` WHERE transaction_id='$trans_id'");
                    
                    if (mysqli_num_rows($trans_record) != 0){
                        displayOrder($trans_record); // display transaction information if record exist
                    }
                    else {
                        echo '<div style="text-align: center;"> No record found for Reference No. '.$_POST['refNo'].'.</div>'; // if reference number not found
                    }
                }
            ?>
        </div>
    <footer>
        <small><i>Copyright &copy; 2018 BBQ Catering<br>
        <a href="mailto:bbq@catering.com">bbq@catering.com</a></i></small>
    </footer>
    </div>
</body>
</html>
