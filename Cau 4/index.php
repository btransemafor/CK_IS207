<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách thuê xe</title>
    <script src="https://cdn.cdnhub.io/jquery/3.7.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
</head>

<body>
<style>
        body {
           font-family: "Roboto Mono", monospace; 
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="date"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .Result {
            margin-top: 20px;
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
    </style>
    <form action="">
        Chọn ngày: <input type="date" name="Choose" id="Choose">
    </form>

    <div class="Result"></div>

    <script>
        $(document).ready(function() {
            function LoadRentedCars(date) {
                $.ajax({
                    url: 'LoadRented.php',
                    method: 'GET',
                    data: {
                        date: date
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log("Server response:", data); // Log the response to the console
                        var stt = 1;
                        var text = `
                        <table border="1">
                            <tr>
                                <th>STT</th>
                                <th>Họ tên khách hàng</th>
                                <th>Số xe</th>
                                <th>Tên xe</th>
                            </tr>`;
                        $.each(data, function(i, car) {
                            console.log("Processing car:", car); // Log each car object
                            text += `<tr>
                                <td>` + stt + `</td>
                                <td>` + car.TENKH + `</td>
                                <td>` + car.SOXE + `</td> 
                                <td>` + car.TENXE + `</td>
                            </tr>`;
                            stt += 1;
                        });
                        text += `</table>`;
                        $('.Result').html(text); // Ensure the table is added to the DOM
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Lỗi khi lấy dữ liệu: ' + textStatus, errorThrown);
                    }
                });
            }

            $('#Choose').on('keypress', function(e) {
                if (e.which == 13) {  // Enter key pressed
                    e.preventDefault();  // Prevent form submission
                    var date = $(this).val();
                    LoadRentedCars(date);
                }
            });
        });
    </script>
</body>
</html>
