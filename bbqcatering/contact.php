<?php 
    include("config/database.php");
    include("function.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barbeque Catering - Contact</title>
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
            <h2 class="title">Contact Us</h2>
            <div id="contact">
                <div id="contact-left">
                    <img src="map.JPG">
                </div>
                <div id="contact-right">
                    <div>
                        <img src="call.jpg">
                        <span>(+65) 6760 1234 <br> </span>
                    </div>
                    <div>
                        <img src="mail.png">
                        <span>sales@bbqcatering.com <br> </span>
                    </div>
                    <div>
                        <img src="location.jpg">
                        <span>35 Barbeque Avenue <br>
                            Singapore 612345 <br> </span>
                    </div>
                    <div>
                        <img src="opening.jpg">
                        <span>Mon – Fri &emsp; &emsp; 8.00am – 5.30pm <br>
                        Sat – Sun &emsp; &emsp; 8.00am – 3.30pm</span>
                    </div>


                </div>
            </div>
            
        </div>
    <footer>
        <small><i>Copyright &copy; 2018 BBQ Catering<br>
        <a href="mailto:bbq@catering.com">bbq@catering.com</a></i></small>
    </footer>
    </div>
</body>
</html>