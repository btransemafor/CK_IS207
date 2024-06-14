<?php
require_once 'connect.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST' && isset($_POST['action']) && $_POST['action'] == 'getInfo') {
    $makh = $_POST['makh'];
    $ngaythue = $_POST['ngaythue'];

    // Lay danh sach xe da thue
    $sql_dathue = "SELECT T.SOXE, TENXE, HANGXE, NAMSX, SOCHO, DGTHUE 
                   FROM THUE T JOIN XE X ON T.SOXE = X.SOXE 
                   WHERE T.MAKH = '$makh'";

    $result_dathue = $conn->query($sql_dathue);

    echo '<table border="1">';
    echo "<tr>
    <td colspan='7'>Danh sách các xe đã thuê</td>
  </tr>
  <tr>
    <th>Số xe</th> 
    <th>Tên xe</th> 
    <th>Hãng xe</th> 
    <th>Năm sản xuất</th> 
    <th>Số chỗ</th> 
    <th>Đơn giá thuê</th> 
    <th>Chọn thuê</th> 
  </tr>";
    if ($result_dathue && $result_dathue->num_rows > 0) {
        while ($row = $result_dathue->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['SOXE'] . "</td>
                    <td>" . $row['TENXE'] . "</td>
                    <td>" . $row['HANGXE'] . "</td>
                    <td>" . $row['NAMSX'] . "</td>
                    <td>" . $row['SOCHO'] . "</td>
                    <td>" . $row['DGTHUE'] . "</td>
                    <td><button name='khongthue' class='btn-khongthue'>Không Thuê</button></td> 
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Khách hàng chưa thuê xe nào hết!</td></tr>";
    }
    echo '</table>';

    exit();
}
