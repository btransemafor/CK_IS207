<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trang thuê xe</title>
    <script src="https://cdn.cdnhub.io/jquery/3.7.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        * {
            font-family: "Roboto Mono", monospace;
            background-color: #f4f4f9; 
        }
        input[type="date"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
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
        button {
            border-radius: 10px;
            padding: 10px 20px;
            color:white;
            font-weight: 500;
        }
        .unrent-btn{
            background-color: red;
        }
        .rent-btn{
            background-color: greenyellow;
            color:black
        }
    </style>
</head>
<body>
    <h1>Thuê xe</h1>
    <label for="customer">Họ tên khách hàng:</label>
    <select id="customer"></select>
    <label for="rentalDate">Ngày thuê xe:</label>
    <input type="date" id="rentalDate">
    
    <h2>Danh sách các xe chưa thuê</h2>
    <table id="availableCarsTable">
        <thead>
            <tr>
                <th>Số xe</th>
                <th>Tên xe</th>
                <th>Hãng xe</th>
                <th>Năm sản xuất</th>
                <th>Số chỗ</th>
                <th>Đơn giá thuê</th>
                <th>Chọn thuê</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    
    <h2>Danh sách các xe đang thuê</h2>
    <table id="rentedCarsTable">
        <thead>
            <tr>
                <th>Số xe</th>
                <th>Tên xe</th>
                <th>Hãng xe</th>
                <th>Năm sản xuất</th>
                <th>Số chỗ</th>
                <th>Đơn giá thuê</th>
                <th>Không thuê</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    
    <script>
        $(document).ready(function() {
            // Load danh sách xe chưa thuê
            function loadAvailableCars() {
                $.ajax({
                    url: 'XeChuaThue.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var availableCarsRows = '';
                        $.each(data.availableCars, function(index, car) {
                            availableCarsRows += '<tr>';
                            availableCarsRows += '<td>' + car.SOXE + '</td>';
                            availableCarsRows += '<td>' + car.TENXE + '</td>';
                            availableCarsRows += '<td>' + car.HANGXE + '</td>';
                            availableCarsRows += '<td>' + car.NAMSX + '</td>';
                            availableCarsRows += '<td>' + car.SOCHO + '</td>';
                            availableCarsRows += '<td>' + car.DGTHUE + '</td>';
                            availableCarsRows += '<td><button class="rent-btn" data-id="' + car.SOXE + '">Thuê</button></td>'; // hoc hoi data-id
                            availableCarsRows += '</tr>';
                        });
                        $('#availableCarsTable tbody').html(availableCarsRows);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Lỗi khi lấy dữ liệu: ' + textStatus, errorThrown);
                    }
                });
            }

            // Load danh sách khách hàng
            function loadCustomers() {
                $.ajax({
                    url: 'getData.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var customerOptions = '';
                        $.each(data, function(index, customer) {
                            customerOptions += '<option value="' + customer.makh + '">' + customer.tenkh + '</option>';
                        });
                        $('#customer').html(customerOptions);
                    },
                });
            }

            // Loading danh sách xe đã thuê cho một khách hàng được chọn
            function loadRentedCars(makh) {
                $.ajax({
                    url: 'getRentedCars.php',
                    method: 'GET',
                    dataType: 'json',
                    data: { makh: makh },
                    success: function(data) {
                        var text = '';
                        $.each(data.rentedCars, function(index, car) {
                            text += '<tr><td>' + car.SOXE + '</td>';
                            text += '<td>' + car.TENXE + '</td>';
                            text += '<td>' + car.HANGXE + '</td>';
                            text += '<td>' + car.NAMSX + '</td>';
                            text += '<td>' + car.SOCHO + '</td>';
                            text += '<td>' + car.DGTHUE + '</td>';
                            text += '<td><button class="unrent-btn" data-id="' + car.SOXE + '">Không thuê</button></td></tr>';
                        });
                        $('#rentedCarsTable tbody').html(text);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            // Tải ban đầu
            loadAvailableCars();
            loadCustomers();

            // Tải danh sách xe đã thuê khi thay đổi khách hàng
            $('#customer').change(function() {
                var makh = $(this).val();
                loadRentedCars(makh);
            });

            // Xử lý khi nhấn nút thuê xe
            $(document).on('click', '.rent-btn', function() {
                var MaSoXe = $(this).data('id');
                var makh = $('#customer').val();
                var ngaythue = $('#rentalDate').val();
                $.ajax({
                    url: 'rentCar.php',
                    method: 'POST',
                    data: { makh: makh, soxe: MaSoXe, ngaythue: ngaythue },
                    success: function(data) {
                        alert(data);
                        loadAvailableCars();
                        loadRentedCars(makh);
                    },
                    error: function(error) {
                        alert('Lỗi khi thuê xe');
                    }
                });
            });

            // Xử lý khi nhấn nút không thuê xe
            $(document).on('click', '.unrent-btn', function() {
                var MaSoXe = $(this).data('id');
                var makh = $('#customer').val();
                $.ajax({
                    url: 'unrentCar.php',
                    method: 'POST',
                    data: { makh: makh, soxe: MaSoXe },
                    success: function(data) {
                        alert(data);
                        loadAvailableCars();
                        loadRentedCars(makh);
                    },
                    error: function(error) {
                        alert('Lỗi khi hủy thuê xe');
                    }
                });
            });
        });
    </script>
</body>
</html>
