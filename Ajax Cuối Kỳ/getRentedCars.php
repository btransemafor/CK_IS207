<?php
require_once 'connectDB.php' ; 

$makh = $_GET['makh'];

// Lấy danh sách xe đã thuê của khách hàng cụ thể
$rentedCars = array();
$sql = "SELECT XE.SOXE, TENXE, HANGXE, NAMSX, SOCHO, DGTHUE  FROM THUE JOIN XE ON THUE.SOXE = XE.SOXE WHERE MAKH = '$makh'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rentedCars[] = $row;
    }
}

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode(['rentedCars' => $rentedCars]);

$conn->close();
?>
