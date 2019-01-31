<?php 

    // =================== INITIALISATION ========================
    session_start();

    // Global Variables
    $errors =array();

    // create session for cart if not exist
    if (!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }

    // ====================== ACCOUNT MANAGEMENT ======================
    
    if (isset($_POST['registerBtn'])) {
        register();
    }

    if (isset($_POST['loginBtn'])) {
        login();
        if (isLoggedIn()) {
            retrieveUserCart();
        }
    }

    //if logout='1', unset login session variables and redirect to home page
    if (isset($_GET['logout'])) {
        updateUserCart();
        unset($_SESSION['cart']);
        // session_destroy();
        unset($_SESSION['user']);
        header("location: index.php");
    }

    // To update personal particulars when logged in
    if(isset($_POST['updatepersonalBtn'])){
        $current_user_id =$_SESSION['user']['user_id'];
        $firstname   =  escape($_POST['firstname']);
        $lastname    =  escape($_POST['lastname']);
        $email       =  escape($_POST['email']);
        $_SESSION['user']['email'] = escape($_POST['email']);
        $phone       =  escape($_POST['phone']); 
        mysqli_query($db,"UPDATE user SET firstname='$firstname',lastname='$lastname',email='$email',phone='$phone' WHERE user_id='$current_user_id'");
    }

    function register()  {
        global $db, $errors, $email_error, $username_error;

        $username    =  escape($_POST['username']);
        $firstname   =  escape($_POST['firstname']);
        $lastname    =  escape($_POST['lastname']);
        $email       =  escape($_POST['email']);
        $phone       =  escape($_POST['phone']);
        $password_1  =  escape($_POST['password_1']);
        $password_2  =  escape($_POST['password_2']);
        $password    =  md5($password_1);
        $error = 0;


        $result = $db->query("SELECT * FROM user WHERE username = '$username'");
        if($result->num_rows > 0) {
        $username_error = "Username is taken";
        $error++;
        } 

        $result = $db->query("SELECT * FROM user WHERE email = '$email'");
        if($result->num_rows > 0) {
        $email_error = "Email is taken";
        $error++;
        } 

        if ($error == 0){
        $register_query = mysqli_query ($db, "INSERT INTO user (`username`, `user_type`, `password`, `firstname`, `lastname`, `email`, `phone`) VALUES
        ('$username', 'user', '$password', '$firstname', '$lastname', '$email', '$phone')");
        
        // Store variables in SESSION for registration -> logged in state
        $logged_in_user_id = mysqli_insert_id($db);
        $_SESSION['user'] = getUserById($logged_in_user_id);
        $_SESSION['success']  = "You have logged in sucessfully!";

        header('location: index.php'); 
        }
    }
    
    function login() {
        global $db, $username, $errors;
        $username = escape($_POST['username']);
        $password = escape($_POST['password']);

        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }

        $result = $db->query("SELECT * FROM user WHERE username = '$username'");
        if($result->num_rows == 0) {
        array_push($errors, "Username does not exist");
        } 
                //need to prevent sqli injection
            // attempt to login if no errors is found on form
        if (count($errors) == 0) 
        {
            $password = md5($password);

            // $stmtlogin = $db ->prepare("SELECT * FROM user WHERE username= ? AND password= ? LIMIT 1");
            // $stmtlogin->bind_param('ss', $username, $password);
            // $stmtlogin->execute();
            // $results = $stmtlogin->get_result();
			
			$result_user = $db->query("SELECT * FROM user WHERE username ='$username' AND password='$password' LIMIT 1");
        
            if (mysqli_num_rows($result_user) == 1) 
            { // user found
                    // check whether user is admin or user
                $logged_in_user = mysqli_fetch_assoc($result_user);
                if ($logged_in_user['user_type'] == 'admin') 
                    {
                        // store in session array as user
                    $_SESSION['user'] = $logged_in_user;
                    $_SESSION['login_success']  = true;
                        // header('location: index.php');       
                    }
                    else
                    {
                    $_SESSION['user'] = $logged_in_user;
                    $_SESSION['login_success']  = true;
                        // header('location: index.php');
                    }
            }
            else 
            {
            array_push($errors, "Wrong username/password combination");
            }
        }

    }
    
    // return user array from their id
    function getUserById($id){
        global $db;
        $query = "SELECT * FROM user WHERE user_id=" . $id;
        $result = mysqli_query($db, $query);

        $user = mysqli_fetch_assoc($result);
        return $user;
    }

    function isLoggedIn() {
        if (isset($_SESSION['user'])) {
            return true;
        }else{
            return false;
        }
    }

    function isAdmin() {
        if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
            return true;
        }else{
            return false;
        }
    }

    function escape($val){
        global $db;
        return mysqli_real_escape_string($db, trim($val));
    }

    function display_error() {
        global $errors;

        if (count($errors) > 0){
            echo '<div>';
                foreach ($errors as $error){
                    echo $error .'<br>';
                }
            echo '</div>';
        }
    }

    // ==================== MENU PAGE =========================

    // add item to cart from menu page
    if (isset($_POST['addBtn']) && $_POST['qty'] != NULL){
        if (isset($_SESSION['cart'][$_POST['addBtn']])){
            $_SESSION['cart'][$_POST['addBtn']] += $_POST['qty'];
        }
        else {
            $_SESSION['cart'][$_POST['addBtn']] = $_POST['qty'];
        }
    }

    // ===================== CART =============================
    
    // delete item from cart
    if(isset($_POST['dltItem'])){
        $product_id = $_POST['dltItem'];
        unset($_SESSION['cart'][$product_id]);
    }
    
    // update quantity of items on cart 
    if (isset($_POST['updateQtyBtn'])) {
        $_SESSION['cart'] = $_POST['cartQtyUpdate'];
    }

    // empty cart
    if (isset($_POST['emptycartBtn'])) {
        $_SESSION['cart'] = Array();
    }

    // save session cart to user cart in db
    if (isset($_POST['savecartBtn'])) {
        updateUserCart();
    }

    // retrieve user's cart from database and add to $_SESSION['cart']
    function retrieveUserCart() {
        global $db;

        $user_cart = mysqli_query($db, "SELECT * FROM `cart` WHERE user_id = ".$_SESSION['user']['user_id']);
        while ($row = mysqli_fetch_array($user_cart)) {
            if (isset($_SESSION['cart'][$row['product_id']])){
                $_SESSION['cart'][$row['product_id']] += $row['quantity'];
            }
            else {
                $_SESSION['cart'][$row['product_id']] = $row['quantity'];
            }
        }
    }

    // update user's cart in database
    function updateUserCart() {
        global $db;
        $user_id = $_SESSION['user']['user_id'];
        $del_oldCart = mysqli_query($db, "DELETE FROM `cart` WHERE user_id = '$user_id'");
        foreach ($_SESSION['cart'] as $product_id => $qty) {
            $add_to_cart = mysqli_query($db, "INSERT INTO `cart`(`product_id`, `quantity`, `user_id`) VALUES ('$product_id','$qty','$user_id')");
        }
    }

    // ===================== CHECK OUT ========================
    if(isset($_POST['checkoutBtn'])) {
        checkout();
    }

    function checkout() {
        global $db;

        $firstname = $_POST['firstName'];
        $lastname = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phoneNo'];
        $address = $_POST['address'];
        $country = $_POST['country'];
        $pcode = $_POST['postalCode'];
        $deliveryDate = $_POST['deliveryDate'];
        $deliveryTime = $_POST['deliveryTime'];
        $total_cost = $_SESSION['total_cost'];

        if (isset($_POST['specialInstruction'])){
            $sp_instruc = $_POST['specialInstruction'];
        }
        else {
            $sp_instruc = NULL;
        }
        
        if (!isLoggedin()){
            // if user is not logged in, add user to database
            $add_user = mysqli_query($db, "INSERT INTO `user`(`user_type`, `username`, `password`, `firstname`, `lastname`, `email`, `phone`) VALUES ('unreg_user',NULL, NULL, '$firstname','$lastname','$email','$phone')");
            if ($add_user) {
                $user_id = mysqli_fetch_object(mysqli_query($db,"SELECT LAST_INSERT_ID() as user_id"))->user_id;
            }    
        }
        else {
            $user_id = $_SESSION['user']['user_id'];
        }
        
        // add transaction
        $add_trans = mysqli_query($db, "INSERT INTO `transactions`(`user_id`, `total_cost`, `del_address`, `del_country`, `del_pcode`, `del_date`, `del_time`, `sp_instruc`, `status`) VALUES ('$user_id','$total_cost','$address','$country','$pcode','$deliveryDate','$deliveryTime','$sp_instruc','pending delivery')");
        if ($add_trans) {
            $new_trans = mysqli_fetch_object(mysqli_query($db,"SELECT LAST_INSERT_ID() as transaction_id"))->transaction_id;

            foreach ($_SESSION['cart'] as $product_id => $qty) {
                $add_order = mysqli_query($db, "INSERT INTO `orders`(`transaction_id`, `product_id`, `qty`) VALUES ('$new_trans','$product_id','$qty')");
            }
            
            emailConfirmation($email, $new_trans); // send confirmation email after added transaction details to database

            unset($_SESSION['total_cost']);
            $_SESSION['cart'] = Array();
            $_SESSION['last_trans_id'] = $new_trans;
            $_SESSION['email'] = $email;
        }
    }

    function emailConfirmation($email, $trans_id) {
        $ref_no = generateRefNo($trans_id);
        $subject = 'Order Confirmation for Ref No. '.$ref_no.' from BBQ Catering';
        $message = 'Thank you for ordering with us!'."\r\n".' Your reference number is:'.$ref_no."\r\n".'You can check your order with this reference number.';
        $headers = 'From: f38ee@localhost' . "\r\n" .
        'Reply-To: f38ee@localhost' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        mail($email, $subject, $message, $headers,'-ff38ee@localhost');
    }
            
    // ======================= REFERENCE NO. =========================

    // Generate Reference No. from transaction id
    function generateRefNo($trans_id) {
        $ref_no = "F38EE";
        $trans_id_len = strlen((string)$trans_id);
        for ($index = 6; $index > $trans_id_len; $index--){
            $ref_no .= "0";
        }
        $ref_no .= (string)$trans_id;
        return $ref_no;
    }
    
    // Decode Reference No. to give transaction id
    function decodeRefNo($ref_no) {
        $trans_id = (int) substr($ref_no,5);
        return $trans_id;
    }

    // ======================= CHECK ORDER ==========================

    // update the order status if delivery date has passed
    function updateTransacStatus() {
        global $db;
        $update = mysqli_query($db, "UPDATE `transactions`
                                        SET status = 'delivered'
                                        WHERE 
                                        status != 'delivered' AND CURRENT_DATE() > del_date");
    }

    // display order format - heading
    function displayOrderHead() {
        echo '<div id="orderResult">';
        echo '<h4 class="headingFormat">Your Orders</h4>';
        echo '<table>';
            echo '<tr>';
                echo '<th>Reference No.</th>';
                echo '<th>Delivery Address</th>';
                echo '<th>Date of Delivery</th>';
                echo '<th>Date Time</th>';
                echo '<th>Total Price</th>';
                echo '<th>Status</th>';
                echo '<th>Feedback</th>';
            echo '</tr>';
    }

    // display order format - ending
    function displayOrderEnd() {
        echo '</table>';
        echo '</div>';
    }

    // display order
    function displayOrder($trans_record) {

        displayOrderHead();

        while ($trans_row = mysqli_fetch_array($trans_record)) {
            $ref_no = generateRefNo($trans_row['transaction_id']);
            echo '<tr>';
            echo '<td>'.$ref_no.'</td>';
            echo '<td class="caps">'.$trans_row['del_address'].'</td>';
            echo '<td>'.$trans_row['del_date'].'</td>';
            echo '<td>'.$trans_row['del_time'].'</td>';
            echo '<td> $'.$trans_row['total_cost'].'</td>';
            echo '<td class="caps">'.$trans_row['status'].'</td>';
            if ($trans_row['status'] == "delivered") {
                echo '<td><a href="feedback.php?refNo='.$ref_no.'" class="submitBtn" name="feedbackBtn">Leave Feedback</a></td>';
            }
            else { echo '<td></td>';}
            echo '</tr>';                        
        }

        displayOrderEnd();
    }

    // ======================= FEEDBACK =============================

    if (isset($_POST['feedbackBtn'])) {
        feedback();
    }

    function feedback() {
        global $db;
    
        $trans_id = $_POST['transaction_id'];
        $feedback = $_POST['feedback'];

        $add_feedback = mysqli_query($db, "INSERT INTO `feedback` (`transaction_id`, `feedback`) VALUES ('$trans_id', '$feedback')");
    }

    // ======================= ADMIN =============================    
    if(isset($_POST["updatePriceBtn"])){   
        updatepriceAdmin();
    }

    function updatepriceAdmin(){
        global $db; 
        $product_idCount = count($_POST["product_id"]);
        for($i=0; $i<$product_idCount; $i++) {
        mysqli_query($db,"UPDATE product set product_price='" . $_POST["product_price"][$i] . "' WHERE product_id ='" . $_POST["product_id"][$i] . "'");
        }
    }        
?> 