<?php 
    include("config/database.php");
    include("function.php");

    // is not logged in as admin, redirect to home page
    // only admin can access this page
    if (!isLoggedIn() | !isAdmin() ) {
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barbeque Catering - Admin</title>
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
             <h2 class="title">Update Price</h2>
             <form method="post" action="admin.php">
     
                <table id="cart">

                    <tr>
                        <th>Product</th>
                        <th>Mass</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th></th>
                    </tr>

                    <?php 
                        $sales_by_product = "SELECT product.product_id as product_id,product.product_name as product_name, product.product_mass as product_mass, product.product_price as product_price, category.category_name as category_name from product,category WHERE category.category_id = product.category_id";
                
                    $result_category = $db->query($sales_by_product); 
                    $row=mysqli_fetch_array($result_category);
                    
                        while($row =mysqli_fetch_array($result_category)){ 
                            $product_name = ucwords($row['product_name']);
                            $category_name = ucwords($row['category_name']);
                            echo '<tr>'; 
                            echo '<td> ' . $product_name . '</td>';
                            echo '<td> ' . $row['product_mass'] . 'g</td>';
                            echo '<td><input type="hidden" name="product_id[]" value=' . $row['product_id'] . '><input id="menupriceUpdate" name="product_price[]" type="number" step="0.01" min="0.01" value=' . $row['product_price'] . '></td>';
                            echo' <td>' . $category_name . '</td>';
                            echo '</tr>';
                            
                        }
                    ?>
                </table>
       
                <div id="alignpriceUpdateBtn">
                    <button class="cartBtn" name="updatePriceBtn" type="submit">Update</button>
                </div>

            </form>
              
    </div>
       
    <footer>
        <small><i>Copyright &copy; 2018 BBQ Catering<br>
        <a href="mailto:bbq@catering.com">bbq@catering.com</a></i></small>
    </footer>
    </div>
</body>
</html>

