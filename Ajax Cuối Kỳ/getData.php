<?php
require_once 'connectDB.php' ; 
// Lấy danh sách khách hàng
$customers = array();
$sql = "SELECT makh, tenkh FROM KHACHHANG";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
//echo json_encode(['customers' => $customers]);
echo json_encode($customers) ; 

// Đóng kết nối
$conn->close();
?>
