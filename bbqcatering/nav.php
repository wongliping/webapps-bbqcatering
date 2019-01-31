<div id="navbar">
    <nav role="navigation">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="checkorder.php">Check Order</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="cart.php"><img id="cartlogo" src="shopping-cart-white.png">Cart</a></li>

            <?php 
                if (isLoggedin()){ 
                    echo '<li><a href="#">Account</a>
                                <ul class="dropdown">';

                            if(isAdmin()){
                                echo '<li><a href="admin.php">Admin</a></li>';
                            }
                                    echo'<li><a href="details.php">Details</a></li>
                                    <li><a href="index.php?logout=1">Logout</a></li>
                                </ul>
                        </li>';}
                else{
                    echo'<li><a href="login.php">Login</a></li>';
                }
            ?>
        </ul>
    </nav>
</div>