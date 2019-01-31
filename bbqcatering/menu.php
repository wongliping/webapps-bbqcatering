<?php 
    include("config/database.php");
    include("function.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barbeque Catering - Menu</title>
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

        <div id="content-menu">
             <h2 class="title">Menu</h2>
             <div class="displayflex"> 

                <div class="tab">
                    <?php 
                        // get bestsellers (top 5 by sales quantity)
                        $query_bestseller = "SELECT S1.product_id, S1.sales_qty, S2.product_name, S2.product_mass, S2.product_price, S2.product_image 
                                                FROM (SELECT product_id, SUM(qty) as sales_qty FROM `orders` GROUP BY product_id) AS S1
                                                LEFT OUTER JOIN (SELECT * FROM `product`) AS S2
                                                ON S1.product_id = S2.product_id
                                                ORDER BY sales_qty DESC
                                                LIMIT 5";
                        $result_bestseller =  $db->query($query_bestseller);

                        // display bestseller tab if exist
                        if (mysqli_num_rows($result_bestseller) != 0) {
                            echo '<button class="tablinks" id="tablink_bestseller" onclick="openCategory(event, \'tablink_bestseller\', \'tabcontent_bestseller\')">Best Sellers</button>';
                        }                   
                        
                        // retrieve categories from database and display categories tab 
                        $categories = mysqli_query($db, "SELECT * FROM `category`");
                        while ($cat_row = mysqli_fetch_array($categories)) {
                            $cat_id = $cat_row['category_id'];
                            $tablink_id = "tablink_" . (string)$cat_id;
                            $tabcontent_id = "tabcontent_" . (string)$cat_id;
                            echo '<button class="tablinks" id="'.$tablink_id.'" onclick="openCategory(event, \''.$tablink_id.'\', \''.$tabcontent_id.'\')">'.$cat_row['category_name'].'</button>';
                        }
                    ?>  
                </div>
                
                <!-- Bestsellers -->
                <div id="tabcontent_bestseller" class="tabcontent" style="display:none;">
                    <?php
                        while($row=mysqli_fetch_array($result_bestseller)){
                            echo'<div class="itemwrap">
                                    <p class="foodtitle">' . $row['product_name'] . '<br>(' . $row['product_mass'] . 'g)</p>
                                    <img id="bbqfoodimage" src="data:image/jpeg;base64,' .base64_encode( $row['product_image'] ). '">
                                    <p class="foodprice">$' . $row['product_price'] . '</p>
                                    <form class="menubuttonalign" method="post">
                                        <input placeholder="qty" class="qtyBtn" name="qty" id="qty" value="1" type="number" step="1" min="1">
                                        <button id="addBtn" class="addBtn" name="addBtn" type="submit" value="' . $row['product_id'] . '">Add</button>
                                    </form>
                                </div>';
                        }
                    ?>  
            
                </div>
                
                <!-- Other categories -->
                <?php 
                    $categories = mysqli_query($db, "SELECT * FROM `category`");
                    while ($cat_row = mysqli_fetch_array($categories)) {
                        $cat_id = $cat_row['category_id'];
                        $tabcontent_id = "tabcontent_" . (string)$cat_id;
                        echo '<div id="'.$tabcontent_id.'" class="tabcontent" style="display:none;">';
                        $cat_query = "SELECT * FROM `product` WHERE category_id='$cat_id'";
                        $cat_result = $db->query($cat_query);
                        while($row=mysqli_fetch_array($cat_result)){
                            echo'<div class="itemwrap">
                                    <p class="foodtitle">' . $row['product_name'] . '<br>(' . $row['product_mass'] . 'g)</p>
                                    <img id="bbqfoodimage" src="data:image/jpeg;base64,' .base64_encode( $row['product_image'] ). '">
                                    <p class="foodprice">$' . $row['product_price'] . '</p>
                                    <form class="menubuttonalign" method="post">
                                        <input placeholder="qty" class="qtyBtn" name="qty" id="qty" value="1" type="number" step="1" min="1">
                                        <button id="addBtn" class="addBtn" name="addBtn" type="submit" value="' . $row['product_id'] . '">Add</button>
                                    </form>
                                </div>';
                        }
                        echo '</div>';
                    }
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
        function openCategory(evt, tablink_id, tabcontent_id) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");

            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            
            tablinks = document.getElementsByClassName("tablinks");
            
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            document.getElementById(tabcontent_id).style.display = "block";
            evt.currentTarget.className += " active";

            localStorage.setItem("currentCategory", tablink_id); // save last visited tab to window local storage
        }

        // Toggle tab to last visited tab
        if (localStorage.getItem("currentCategory")) {
            document.getElementById(localStorage.getItem("currentCategory")).click();
        } // If no last visited tab, toggle bestseller tab if exist
        else if (document.getElementById("tablink_bestseller") != null){
            document.getElementById("tablink_bestseller").click();
        } // If no last visited tab and bestseller tab does not exist, toggle first category
        else {
            document.getElementsByClassName("tablinks")[0].click();
        }
        
</script>
