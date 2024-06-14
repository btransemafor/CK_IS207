<?php 
// Ket nối Database 
require_once 'connectDB.php' ;

$date = $_GET['date'] ; 

// ngaythue & (ngaytra là null) 

$sql = "SELECT TENKH , XE.SOXE, TENXE FROM THUE JOIN XE ON XE.SOXE = THUE.SOXE JOIN KHACHHANG KH ON KH.MAKH = THUE.MAKH
WHERE NGAYTHUE = '$date' AND NGAYTRA IS NULL" ; 

$result = $conn->query($sql) ; 

$rent = array() ; 

if ($result->num_rows > 0 ) {
    while($row = $result->fetch_assoc()) {
        $rent[] = $row ; 
    }
}

header('Content-Type: application/json') ;
echo json_encode($rent);

$conn->close();
?>