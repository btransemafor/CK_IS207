<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang tra xe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Thông tin trả xe</h2>
    <form action="" method="post" class="form-traxe">
        <table>
            <tr>
                <td>Họ tên khách hàng</td>
                <td>
                    <?php
                    require_once 'connect.php';
                    echo '<select id="tenKH" name="tenKH">';
                    $sql_name = "SELECT MAKH, TENKH FROM KHACHHANG";
                    $result_name = $conn->query($sql_name);

                    if ($result_name) {
                        $count = $result_name->num_rows;
                        if ($count > 0) {
                            while ($row = $result_name->fetch_assoc()) {
                                echo "<option value='" . $row['MAKH'] . "'>" . $row['TENKH'] . "</option>";
                            }
                        }
                    }
                    echo '</select>';
                    ?>
                </td>
            </tr>
            <tr>
                <td>Số xe</td>
                <td><input type="text" name="masoxe" id="masoxe" placeholder="51H-xxx-xx"></td>
            </tr>
            <tr>
                <td>Ngày thuê</td>
                <td><input type="date" name="ngaythue" id="ngaythue"></td>
            </tr>
            <tr>
                <td>Ngày trả</td>
                <td><input type="date" name="ngaytra" id="ngaytra"></td>
            </tr>
            <tr>
                <td><input type="submit" value="Trả xe" name="btn-traxe"></td>
                <td></td>
            </tr>
        </table>
    </form>

    <?php
    function TinhSoNgay($startDate, $finishDate) {
        $startDate = new DateTime($startDate);
        $finishDate = new DateTime($finishDate);
        $SoNgay = $startDate->diff($finishDate);
        return $SoNgay->days + 1;
    }

    if (isset($_POST['btn-traxe']) && $_POST['btn-traxe'] == 'Trả xe') {
        // Lay thong tin tu form
        $maKH = $_POST['tenKH'];
        $ngaythue = $_POST['ngaythue'];
        $ngaytra = $_POST['ngaytra'];
        $masoxe = $_POST['masoxe'];

        // Lay don gia thue xe
        $sql_dgthue = "SELECT DGTHUE FROM XE WHERE SOXE = '$masoxe'";
        $result = $conn->query($sql_dgthue);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $dgthue = (float)$row['DGTHUE'];
        } else {
            die('Không tìm thấy xe với số xe: ' . $masoxe);
        }

        // Kiểm tra xem khách hàng có thuê xe đó không
        $sql_check = "SELECT * FROM THUE WHERE MAKH ='$maKH' AND SOXE = '$masoxe'";
        $res_check = $conn->query($sql_check);

        if ($res_check->num_rows <= 0) {
            die("Khách hàng chưa thuê xe trên. Vui lòng kiểm tra lại.");
        }

        // Tinh so ngay thue
        $songaythue = TinhSoNgay($ngaythue, $ngaytra);
        $giathue = $songaythue * $dgthue;

        // Cập nhật thông tin ngày trả và giá thuê vào bảng THUE
        $sql_update = "UPDATE THUE 
                        SET NGAYTRA = '$ngaytra', 
                        GIATHUE = '$giathue' 
                        WHERE MAKH = '$maKH' 
                        AND SOXE = '$masoxe'";

        if ($conn->query($sql_update) === TRUE) {
            echo "Trả xe thành công! Số ngày thuê là $songaythue, Giá thuê: $giathue";
        } else {
            echo 'Lỗi: ' . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>
