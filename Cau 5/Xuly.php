<?php
require_once 'connectDB.php';


$ngayBD = $_POST['ngayBD'];
$ngayKT = $_POST['ngayKT'];
$maKH = $_POST['maKH'];

// SQL query
$sql = "SELECT THUE.SOXE, TENXE, GIATHUE FROM THUE JOIN XE ON THUE.SOXE = XE.SOXE WHERE NGAYTRA IS NOT NULL AND MAKH = '$maKH'";

$result = $conn->query($sql);

$XeDaTra = array();
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $XeDaTra[] = $row;
        }
    }
} 
$conn->close();

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($XeDaTra);
?>
