<?php 
    include("config/database.php");
    include("function.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barbeque Catering - Cart</title>
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
            <h2 class="title">Cart</h2>
        <?php 
            // if cart is empty
            if (empty($_SESSION['cart'])){
                echo '<h3 style="text-align: center">Your cart is empty.</h3>';
            }
            // if cart is not empty, display items in table format
            else {
        ?>  
            <form method="post" id="cartForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" onkeypress="return event.keyCode != 13;">
           
            <table id="cart">
                <tr>
                    <th>Item</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th></th>
                </tr>

        <?php
                $total_cost = 0;
                foreach ($_SESSION['cart'] as $product_id => $quantity){
                    $query = mysqli_fetch_object(mysqli_query($db, "SELECT product_name, product_price FROM product WHERE product_id = '$product_id'"));
                    $product_name = $query->product_name;
                    $product_price = $query->product_price;
                    $product_subtotal = number_format($product_price * $quantity, 2);
                    $total_cost += $product_subtotal; // add the subtotal of each product to the grand total
                    // display the information of each item in cart
                    echo '<tr>';
                    echo '<td class="caps">'.$product_name.' </td>';
                    echo '<td id="cost">$' . $product_price . '</td>';
                    echo '<td><input class="cartQtyUpdate" id="cartQtyUpdate" name="cartQtyUpdate['.$product_id.']" type="number" step="1" min="1" value=' . $quantity . ' ></td>';
                    echo '<td id="subtotalcost">$'.$product_subtotal.'</td>';
                    echo '<td><button formaction="cart.php" name="dltItem" type="submit" class="dltItemBtn" id="dltItemBtn" value="' . $product_id . '">&#10006;</button></td>';
                    echo '</tr>';
                }
                $total_cost = number_format($total_cost,2);
                $_SESSION['total_cost'] = $total_cost;
          ?>

            </table>

            <div id="grandtotalalign">Grand Total: $<?php echo $total_cost; ?></div>
       
            <div id="alignbuttons">
            <input formaction="cart.php" name="updateQtyBtn" id="updateQtyBtn" type="submit">
            <button id="emptycartBtn" class="cartBtn" name="emptycartBtn" type="submit" formaction="cart.php" onclick="return confirm('Are you sure you want to remove everything from cart?');">Empty Cart</button>
            <?php
                // 'save cart' button will only be displayed if user is logged in
                if (isLoggedin()) {
                    echo '<button id="savecartBtn" class="cartBtn" name="savecartBtn" type="submit" formaction="cart.php" >Save Cart</button>';
                } 
            ?>
            <button id="cartBtn" class="cartBtn" name="submitcartBtn" type="submit" formaction="checkout.php" onclick="return confirm('Confirm to proceed to checkout?');">Confirm</button>
            </div>

        </form>
        <?php } ?>
        </div>
    <footer>
        <small><i>Copyright &copy; 2018 BBQ Catering<br>
        <a href="mailto:bbq@catering.com">bbq@catering.com</a></i></small>
    </footer>
    </div>
</body>
</html>

<script>

    // set up event listener
    var cartUpdateClass = document.getElementsByClassName("cartQtyUpdate");

    for (var i = 0; i < cartUpdateClass.length; i++) {
        cartUpdateClass[i].addEventListener("change",updateCart,false);
    }

    // update cart function
    function updateCart() {
        document.getElementById("updateQtyBtn").click();
        
    }

</script>