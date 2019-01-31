<?php 
    include("config/database.php");
    include("function.php");

    if (isLoggedIn()) {
        header('location: index.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barbeque Catering - Register</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" media="screen" title="text/css" charset="utf-8">
    <link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="validateRegistration.js"></script>
</head>
<body>
    <div id="wrapper">
        <header>
            <img id="bbqlogo" src="logo.png">
        </header>
    <?php include("nav.php"); ?>
        <div id="content">
        	<h2 class="title">Register</h2>
            
             <form id="signupForm" method="post" action="register.php">

            <div class="signupInfo">
                <h4 class="headingFormat">Information</h4>
                
                <input type="text" name="firstname" id="firstname" placeholder="First Name" value="<?php 

                if (isset($_POST['firstname'])){
                echo $_POST['firstname'];}?>">
                <input type="text" name="lastname" id="lastname" placeholder="Last Name" value="<?php 

                if (isset($_POST['lastname'])){
                echo $_POST['lastname'];}?>" >
                <input type="email" name="email" id="email" placeholder="Email" value="<?php 

                if (isset($_POST['email'])){
                echo $_POST['email'];}?>" >
                <input type="text" name="phone" id="phone" placeholder="Phone" value="<?php 

                if (isset($_POST['phone'])){
                echo $_POST['phone'];}?>" >
            <span id="informationerror" style="color:red;font-style:italic"></span>
            <span style="color:red;font-size:15px"><?php if(isset($email_error)) {echo $email_error;} ?> </span>
            </div>

            <div class="credentialsInfo">
                <h4 class="headingFormat">credentials</h4>
                <input type="text" name="username" id="username" placeholder="username" value="<?php 

                if (isset($_POST['username'])){
                echo $_POST['username'];}?>" >
                <input type="password" name="password_1" id="password_1" placeholder="password">
                <input type="password" name="password_2" id="password_2" placeholder="confirm password">
            <span id="credentialerror" style="color:red;font-style:italic"></span>
            <span style="color:red;font-size:15px"><?php echo display_error(); ?> </span>
            <span style="color:red;font-size:15px"><?php if(isset($username_error)) {echo $username_error;} ?> </span>
            </div>
            Already a member? Login <a href="login.php">here</a>
            <button class="submitBtn" name="registerBtn" type="submit">Register</button>
            </form>
        </div>
    <footer>
        <small><i>Copyright &copy; 2018 BBQ Catering<br>
        <a href="mailto:bbq@catering.com">bbq@catering.com</a></i></small>
    </footer>
    </div>
</body>
</html>


