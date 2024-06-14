<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Them Xe Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Thêm xe</h2>
    <form action="#" method="post" class="themxe">
        Mã xe <input type="text" name="maxe" id="maxe" placeholder="51E-xxx.xx"> <br>
        Tên xe <input type="text" name="tenxe" id="tenxe" placeholder="Forester"> <br>
        Hãng xe <input type="text" name="hangxe" id="hangxe" placeholder="Subaru"> <br>
        Số chổ <input type="number" name="socho" id="socho" placeholder="5"> <br>
        Năm sản xuất <input type="text" name="namsx" id="namsx" placeholder="2022"> <br>
        Đơn giá thuê <input type="text" name="DGThue" id="DGThue" placeholder="1000000"> <br>

        <div class="btn-submit"><input type="submit" value="Thêm" name ='them'></div>
    </form>
</body>
</html>


<?php 
    if (isset($_POST['them']) && $_POST['them'] == 'Thêm') {
        // lấy dữ liệu từ control
        $masoxe = $_POST['maxe'] ; 
        $tenxe = $_POST['tenxe'] ; 
        $hangxe = $_POST['hangxe'] ; 
        $socho = $_POST['socho'] ; 
        $namsx = $_POST['namsx'] ; 
        $dgthue = $_POST['DGThue'] ; 

        // connect Database 
        require_once 'connect.php' ; 

        $insert_xe = "INSERT INTO XE(SOXE,TENXE, HANGXE, SOCHO, NAMSX, DGTHUE, TINHTRANG) VALUES 
            ('$masoxe' , '$tenxe' , '$hangxe', '$socho' , '$namsx', '$dgthue', '0')" ; 

        // execute 

        $r = $conn->query($insert_xe) ; 

        if ($r) {
            echo 'THEM THANH CONG <br>' ; 
        }
        else 'LOI'; 
    }

?>