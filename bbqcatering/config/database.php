<?php 
     $db = mysqli_connect('localhost', '', '', '');
    if(mysqli_connect_error()) {
     echo "failed to connect to mysql:" .mysqli_connection_error();
     }
?>
