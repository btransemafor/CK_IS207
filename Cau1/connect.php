<?php 
    $servername = 'localhost' ; 
    $username = 'root' ; 
    $password = '' ; 
    $dbName = 'ThueXeDB' ; 

    $conn = new mysqli($servername, $username, $password , $dbName) ; 

    if (!$conn) {
        die('Error'. $conn->connect_error) ;
    }
    echo 'Ket noi thanh cong<br>' ; 



?>