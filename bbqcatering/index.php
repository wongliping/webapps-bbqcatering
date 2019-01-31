<?php 
    include("config/database.php");
    include("function.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barbeque Catering - Home</title>
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

        <div id="content"><br><br>
            <div class="clearfix">
                <div style="padding-right:10px">
                <img id="bbqmeat" src="bbqmeat.jpg"></div>
                We have been operating since 2010, with <b>10000</b> over customers.<br><br>
                <u>Services provided</u><ul>
                <li>Wide variety of seafood, poultry, satay and even vegetarian choices available for selection, at the lowest possible price</li> 
                <li>Direct delivery to location at extremely low cost with flexible time slots.</li></ul>
            </div>

            <div class="clearfix">
                <img id="bbqstingray" src="bbqstingray.jpg">
                
                <span style="font-size:25px;padding-left:200px"><b>H O T S E L L E R S</b></span>
                <ul style="padding-left:500px">
                <li>Seafood - Sambal Stingray, Tiger Prawns, </li> 
                <li>Poultry - Braised pork with herbs, Sliced Pork, Bacon</li>
                <li>Fish - Salmon, Fishball</li>
                <li>Satay - Chicken, Pork</li></ul>
            </div>
        </div>
    <footer>
        <small><i>Copyright &copy; 2018 BBQ Catering<br>
        <a href="mailto:bbq@catering.com">bbq@catering.com</a></i></small>
    </footer>
    </div>
</body>
</html>