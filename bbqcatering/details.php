<?php 
    include("config/database.php");
    include("function.php");

    if (!isLoggedIn()) {
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('validateupdate.php');?>
    <title>Barbeque Catering - Update Details</title>
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
        	<h2 class="title">Personal Details</h2>
            
             <form id="signupForm" method="post" action="details.php" onsubmit="return validateUpdate()">

            <div class="signupInfo">
                <h4 class="headingFormat">Information</h4>
                <?php 
                 $current_user_id =$_SESSION['user']['user_id'];
                $query ="SELECT firstname, lastname, email, phone FROM user WHERE user_id = $current_user_id";
                $result = $db->query($query);
                while($row=mysqli_fetch_array($result)){
                $firstname=$row['firstname'];
                $lastname=$row['lastname'];
                $email=$row['email'];
                 $phone=$row['phone'];
                }

                ?>
                
                <input type="text" name="firstname" id="firstname" placeholder="First Name" value="<?php echo $firstname; ?>" >
                <input type="text" name="lastname" id="lastname" placeholder="Last Name" value="<?php echo $lastname; ?>">
                <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>">
                <input type="text" name="phone" id="phone" placeholder="Phone" value="<?php echo $phone; ?>">
            <span id="informationerror" style="color:red;font-style:italic"></span>
            </div>

            <button class="submitBtn" name="updatepersonalBtn" type="submit" >Update</button>
            </form>
        </div>
    <footer>
        <small><i>Copyright &copy; 2018 BBQ Catering<br>
        <a href="mailto:bbq@catering.com">bbq@catering.com</a></i></small>
    </footer>
    </div>
</body>
</html>


