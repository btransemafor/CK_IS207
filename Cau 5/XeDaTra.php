<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin những xe đã trả</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
   <style>
     table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
   </style> 
    <form action="">
        Từ ngày <input type="date" name="NgayBatDau" id="NgayBatDau">
        Đến ngày <input type="date" name="NgayKetThuc" id="NgayKetThuc">
        <br>
        Họ tên khách hàng: 

        <?php 
            require_once 'connectDB.php'; 
            $sql = "SELECT MAKH, TENKH FROM KHACHHANG"; 
            $result = $conn->query($sql); 
            echo '<select id="List_KH">';
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['MAKH']."'>".$row['TENKH']."</option>"; 
                }
            }
            echo '</select>';
            $conn->close(); // Close the connection after use
        ?>
    </form>

    <div class="result"></div>

    <script>
        $(document).ready(function() {
            function LoadCar() {
                var ngayBD = $('#NgayBatDau').val();
                var ngayKT = $('#NgayKetThuc').val();
                var maKH = $('#List_KH').val();

                if (ngayBD && ngayKT && maKH) {
                    console.log(ngayBD);
                    console.log(ngayKT);
                    console.log(maKH);
                    $.ajax({
                        url: 'Xuly.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            'ngayBD': ngayBD, 
                            'ngayKT': ngayKT, 
                            'maKH': maKH 
                        }, 
                        success: function(data) {
                            var stt = 1; 
                            var text = '<table><tr><th>STT</th><th>Số xe</th><th>Tên xe</th><th>Giá Thuê</th></tr>';
                            // Duyệt qua các object in json 
                            $.each(data, function(index, car) {
                                text += "<tr><td>" + stt + "</td>";
                                text += "<td>" + car.SOXE + "</td>";
                                text += "<td>" + car.TENXE + "</td>";
                                text += "<td>" + car.GIATHUE + "</td></tr>";
                                stt += 1; 
                            });  
                            text += '</table>';
                            $('.result').html(text);
                        }, 
                        error: function(xhr, status, error) {
                            console.error("Status: " + status + ", Error: " + error);
                            alert("Có lỗi xảy ra khi tải dữ liệu.");
                        }
                    });
                } else {
                    console.log("Vui lòng chọn đầy đủ thông tin trước khi thực hiện.");
                }
            }

            $('#List_KH').change(LoadCar); 
            $('#NgayBatDau').change(LoadCar); 
            $('#NgayKetThuc').change(LoadCar); 
        });
    </script>
</body>
</html>
