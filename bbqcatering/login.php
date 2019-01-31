<?php 
    include("config/database.php");
    include("function.php");

    if (isLoggedIn() && $_SESSION['login_success'] == false) {
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barbeque Catering - Login</title>
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
        	<h2 class="title">Login</h2>
        	<form id="loginform" method="post" action="login.php">
        		<label>Username:</label>
        		<input id="username" type="text" name="username" placeholder="username" value="<?php 

                if (isset($_POST['username'])){
                echo $_POST['username'];}?>" required><br>
        		<label>Password:</label>
        		<input type="password" name="password" placeholder="password" required><br>
                <div style="padding-left:30px">
                <span style="color:red;font-size:15px"><?php echo display_error(); ?> </span> </div>
        		<span id="signuplink">Not a member yet? Register <a href="register.php">here</a></span>
        		<button id="loginBtn" type="submit" name="loginBtn">Login</button>
        		
        	</form>      
        </div>
    <footer>
        <small><i>Copyright &copy; 2018 BBQ Catering<br>
        <a href="mailto:bbq@catering.com">bbq@catering.com</a></i></small>
    </footer>
    </div>
</body>
</html>

<script>
    function isloginAlert() {
        if (<?php if(isLoggedIn()) {echo $_SESSION['login_success'];} ?>) {
            <?php $_SESSION['login_success'] = false;
            ?> 
            if (!alert("You have logged in successfully!")) {
                window.location.href = "index.php";
                }
            }
    }
    window.onload = isloginAlert;
</script>
