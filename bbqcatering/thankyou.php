<?php 
    include("config/database.php");
    include("function.php");

    if(!$_SESSION['last_trans_id']) {
        header("location: checkout.php");
    }
    else {
        $ref_no = generateRefNo($_SESSION['last_trans_id']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barbeque Catering - Thank you for ordering</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" media="screen" title="text/css" charset="utf-8">
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
            <h2 class="title">Thank You</h2>
            <div id="thankyoudiv">
                <h3>Thank you for ordering with us!</h3>
                <p>Your reference number is: <span style="font-weight:bold;"><?php echo $ref_no; ?> </span><br>
                   You can check your order <a href="checkorder.php">here</a> with this reference number. <br><br>
				   A confirmation mail has been sent to: <?php echo $_SESSION['email']; ?><br><br>
                   Redirecting in ... <span id="timerspan"></span></p>
				  
                <?php 
                    unset($_SESSION['last_trans_id']);
                    unset($_SESSION['email']);
                ?>
				
            </div>            
        </div>
    <footer>
        <small><i>Copyright &copy; 2018 BBQ Catering<br>
        <a href="mailto:bbq@catering.com">bbq@catering.com</a></i></small>
    </footer>
    </div>
</body>
</html>

<script>
    // document.getElementById("timerspan");
    var countdown = 30; //seconds
    document.getElementById("timerspan").innerHTML = countdown;
    setInterval("CountdownTimer()",1000); // 1000 miliseconds

    function CountdownTimer() {
        if (countdown > 1) {
            countdown--;
            document.getElementById("timerspan").innerHTML = countdown;
        }
        else {
            window.location = "menu.php"; // redirect to menu page after countdown timer is up
        }
    }
</script>