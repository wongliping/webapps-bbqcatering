<?php 
    include("config/database.php");
    include("function.php");

    if (!$_GET['refNo']) {
        header("location: checkorder.php"); // redirect to check order page if no reference number is passed
    }
    else {
        $trans_id = decodeRefNo($_GET['refNo']);
        $trans_record = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `transactions` WHERE transaction_id='$trans_id'"));
        if ($trans_record['status'] != "delivered") {
            header("location: checkorder.php"); // redirect to check order page if status of corresponding transaction is not 'deliered'
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barbeque Catering - Feedback</title>
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
        <h2 class="title">Leave a Feedback</h2>
        <form id="feedbackForm" method="post" action="menu.php">
            <div class="feedbackInfo">
                <h4 class="headingFormat">Order Details</h4>

                <div id="orderDetails">
                    <!-- display order details -->
                    <p><span class="orderLbl">Reference No. </span>: <span class="orderDetail"><?php echo $_GET['refNo'];?></span></p>
                    <p><span class="orderLbl">Delivery Address </span>: <span class="orderDetail caps"><?php echo $trans_record['del_address'];?></span></p>
                    <p><span class="orderLbl">Delivery Date </span>: <span class="orderDetail"><?php echo $trans_record['del_date'];?></span></p>
                    <p><span class="orderLbl">Delivery Time </span>: <span class="orderDetail"><?php echo $trans_record['del_time'];?></span></p>
                    <p><span class="orderLbl">Total Price </span>: <span class="orderDetail">$<?php echo $trans_record['total_cost'];?></span></p>
                </div>

            </div>

            <div class="feedbackInfo">
                <h4 class="headingFormat">Feedback</h4>
                <input type="hidden" name="transaction_id" value="<?php echo $trans_id;?>">
                <textarea type="textarea" id="feedback" name="feedback" rows="5"></textarea>
            </div>
            <a href="checkorder.php">Back</a>
            <button class="submitBtn" name="feedbackBtn" type="submit">Confirm</button>
        </form>
        </div>
    <footer>
        <small><i>Copyright &copy; 2018 BBQ Catering<br>
        <a href="mailto:bbq@catering.com">bbq@catering.com</a></i></small>
    </footer>
    </div>
</body>
</html>