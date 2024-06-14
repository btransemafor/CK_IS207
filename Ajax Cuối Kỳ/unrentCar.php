<?php 

require_once 'connectDB.php' ;
// makh: makh, soxe: MaSoXe 

$makh = $_POST['makh'] ; 
$masoxe = $_POST['soxe'] ; 

// Xoa thue trong THUE Table 

// DELETE FROM table_name WHERE condition;
$sql ="DELETE FROM THUE WHERE SOXE = '$masoxe'" ; 

if ($conn->query($sql) == true) {
    echo 'Hủy thuê xe thành công' ; 
}

?>