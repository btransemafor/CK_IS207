
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.cdnhub.io/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Thuê xe</h2> 
    <form action="#" method="get" class="thuexe-form">
        <div class="text-name">Họ tên khách hàng</div> 
        <?php 

            require_once 'connect.php' ; 
            $sql_namekh = "SELECT MAKH, TENKH FROM KHACHHANG";
            $result = $conn->query($sql_namekh);

            echo '<select id="nameKH" class="nameKH">';
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<option value="'.$row['MAKH'].'">'.$row['TENKH'].'</option>';
                }
            }
            echo '</select>';
        ?>
        Ngày thuê xe <input type="date" name="ngaythue" id="ngaythue" placeholder="15/12/2023">
        <button type="button" id="submitForm">Submit</button>
    </form>

    <div class="list-chuathue">
        <?php 
            echo "<table border='1'>";
            $sql_chuathue = "SELECT XE.SOXE, TENXE, HANGXE, NAMSX, SOCHO, DGTHUE 
                             FROM XE LEFT JOIN THUE ON XE.SOXE = THUE.SOXE 
                             WHERE THUE.SOXE IS NULL";

            $result = $conn->query($sql_chuathue);
            echo "<tr>
                    <td colspan='7'>Danh sách các xe chưa thuê</td>
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
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row['SOXE']."</td>
                            <td>".$row['TENXE']."</td>
                            <td>".$row['HANGXE']."</td>
                            <td>".$row['NAMSX']."</td>
                            <td>".$row['SOCHO']."</td>
                            <td>".$row['DGTHUE']."</td>
                            <td><button name='thue' class='btn-thue'>Thuê</button></td> 
                          </tr>";
                }
            }
            echo '</table>';
        ?>
    </div>

    <div class="list-dathue" id="list-dathue"></div>

    <script>
        $(document).ready(function() {
            function ajax() {
                var makh = $('#nameKH').val();
                var ngaythue = $('#ngaythue').val();

                $.ajax({
                    url: 'xuly.php',
                    method: 'POST',
                    data: {
                        'makh': makh,
                        'ngaythue': ngaythue,
                        'action': 'getInfo'
                    },
                    success: function(response) {
                        console.log(response);
                        $('#list-dathue').html(response);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }

            $('#nameKH').change(ajax);
        

            // Xu ly khi nhan nut thue 

            // Lay thong tin khach hang 
            // Lấy masoxe đó 

            function Ajax_Thue_Xe() {
                var $makh = $('#nameKH').val() ; 
                
            }


           // Using event delegation to handle dynamic elements
           $(document).on('click', '.btn-thue', function() {
                var SoXeDuocThue = $(this).closest('tr').find('td:first').text();
                var makh = $("#nameKH").val();
                var NgayThue = $('#ngaythue').val();
                console.log(SoXeDuocThue) ; 
                $.ajax({
                    url: 'xulythuexe.php',
                    method: 'POST',
                    data: {
                        'makh': makh,
                        'NgayThue': NgayThue,
                        'SoXeDuocThue': SoXeDuocThue,
                        'action': 'ThueXe'
                    },
                    success: function(response) {
                        // Cap nhat lai 
                        console.log('Da cap nhat');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

        });
    </script>
</body>
</html>