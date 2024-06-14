<?php 
require_once 'connectDB.php' ; 
//makh: makh, soxe: MaSoXe, ngaythue: ngaythue
// Ngay thue 
// MaKH 
// MaSoXe 

$maKH = $_POST['makh'] ; 
$SoXe = $_POST['soxe'] ; 
$NgayThue = $_POST['ngaythue'] ; 

// Khi thuê thì thêm vào bảng thuê 
// Câu truy vấn để thêm là gì ? 
$sql = "INSERT INTO THUE(makh, soxe, ngaythue) VALUES ('$maKH','$SoXe','$NgayThue')" ;
// Execute
$result = $conn->query($sql) ; 

if ($result) {
    echo 'Khách Hàng '.$maKH.' Đã Thuê Xe '. $SoXe.' Thành Công !' ;  
}

?>