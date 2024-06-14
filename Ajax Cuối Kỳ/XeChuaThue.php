<?php
require_once 'connectDB.php' ; 

// Lấy danh sách xe chưa thuê
$availableCars = array();
$sql = "SELECT XE.SOXE, TENXE, HANGXE, NAMSX, SOCHO, DGTHUE 
        FROM XE 
        LEFT JOIN THUE ON XE.SOXE = THUE.SOXE 
        WHERE THUE.SOXE IS NULL";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $availableCars[] = $row;
        }
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode(['availableCars' => $availableCars]);

// Đóng kết nối
$conn->close();
?>
