
<!DOCTYPE html>
<html>
<head>
    <title>Quản Lý Tài Khoản</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 1032px;
            background-color: #e0d4f7;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .sidebar h2 img {
            margin-right: 10px;
            border-radius: 50%;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            flex-grow: 1;
        }
        .sidebar ul li {
            margin-bottom: 30px;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
        }
        .sidebar ul li a i {
            margin-right: 10px;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ff4d4d;
            padding: 10px 20px;
            color: white;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .header .search-bar {
            display: flex;
            align-items: center;
        }
        .header .search-bar input {
            padding: 5px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
        }
        .header .user-info {
            display: flex;
            align-items: center;
        }
        .header .user-info img {
            border-radius: 50%;
            margin-right: 10px;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .table-container .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            padding:0px;
        }
        .table-container .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .table-container .pagination a.active {
            background-color: #ff4d4d;
            color: white;
        }
        .table-container .pagination a:hover {
            background-color: #ddd;
        }
        .btn {
            padding: 10px 20px;
            margin: 5px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #555;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                height: 70%;
            }
            .main-content {
                padding: 10px;
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            .header h1 {
                font-size: 20px;
            }
            .header .search-bar {
                width: 100%;
                margin-top: 10px;
            }
            .header .search-bar input {
                width: 100%;
            }
            .header .user-info {
                margin-top: 10px;
            }
            table, th, td {
                display: block;
                width: 100%;
            }
            th, td {
                padding: 10px;
                text-align: right;
            }
            th {
                background-color: #f2f2f2;
                text-align: left;
            }
            td {
                border-bottom: none;
                position: relative;
                padding-left: 50%;
            }
            td:before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: calc(50% - 20px);
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
            }
            .table-container .pagination {
                flex-direction: column;
            }
            .table-container .pagination a {
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Quản Lý Tài Khoản</h1>
        <div class="search-bar">
            <input type="text" placeholder="Hinted search text">
            <i class="fas fa-search"></i>
        </div>
       
    </div>
    
    <div class="container">
        <div class="sidebar">
            <div>
                <h2>
                    <img src="https://storage.googleapis.com/a1aa/image/Z1MxpRJLqjraLFTLd7rw6HlOfHzQXdsKye86dZgvnHJxRamTA.jpg" width="40" height="40" alt="User avatar">
                    Chào mừng
                </h2>
                    <ul>
                        <li><a href="#"><i class="fas fa-user"></i>Tài khoản nhân viên</a></li>
                        <li><a href="#"><i class="fas fa-user-plus"></i>Thêm tài khoản khách hàng</a></li>
                        <li><a href="#"><i class="fas fa-user-cog"></i>Thêm tài khoản quản lý</a></li>
                        <li><a href="#"><i class="fas fa-user-check"></i>Kiểm soát</a></li>
                        <li><a href="#"><i class="fas fa-user-shield"></i>Tài khoản còn hoạt động</a></li>
                        <li><a href="#"><i class="fas fa-user-lock"></i>Tài khoản đã khóa</a></li>
                        <li><a href="#"><i class="fas fa-key"></i>Mã khóa tài khoản</a></li>
                    </ul>               
            </div>
        </div>

        <div class="main-content">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Ảnh đại diện</th>
                            <th>Thông tin cá nhân</th>
                            <th>Vai trò</th>
                            <th>Quản lí chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php // ví dụ lấy user từ database ra những user sau 
                        $users = [
                            [
                                'image' => 'images/HoHuuDai.jpg',
                                'name' => 'Hồ Hữu Đại',
                                'id' => 'NV001',
                                'phone' => '0312345597',
                                'email' => 'dai@gmail.com',
                                'roles' => 'Nhân Viên, Quản lí, Admin'
                            ],
                            [
                                'image' => 'images/HoHuuDai.jpg',
                                'name' => 'Nguyễn Xuân Duy',
                                'id' => 'NV002',
                                'phone' => '0312345597',
                                'email' => 'duy@gmail.com',
                                'roles' => 'Nhân Viên'
                            ],
                            [
                                'image' => 'images/HoHuuDai.jpg',
                                'name' => 'Lê Hoàng Huy',
                                'id' => 'KH001',
                                'phone' => '0312345597',
                                'email' => 'huy@gmail.com',
                                'roles' => 'Khách Hàng'
                            ],
                            [
                                'image' => 'images/HoHuuDai.jpg',
                                'name' => 'Huỳnh Tấn Dương',
                                'id' => 'KH002',
                                'phone' => '0312345597',
                                'email' => 'duong@gmail.com',
                                'roles' => 'Khách Hàng'
                            ],
                            [
                                'image' => 'images/HoHuuDai.jpg',
                                'name' => 'Hồ Hữu Đại',
                                'id' => 'NV001',
                                'phone' => '0312345597',
                                'email' => 'dai@gmail.com',
                                'roles' => 'Nhân Viên, Quản lí, Admin'
                            ],
                            [
                                'image' => 'images/HoHuuDai.jpg',
                                'name' => 'Nguyễn Xuân Duy',
                                'id' => 'NV002',
                                'phone' => '0312345597',
                                'email' => 'duy@gmail.com',
                                'roles' => 'Nhân Viên'
                            ],
                            [
                                'image' => 'images/HoHuuDai.jpg',
                                'name' => 'Lê Hoàng Huy',
                                'id' => 'KH001',
                                'phone' => '0312345597',
                                'email' => 'huy@gmail.com',
                                'roles' => 'Khách Hàng'
                            ],
                            [
                                'image' => 'images/HoHuuDai.jpg',
                                'name' => 'Huỳnh Tấn Dương',
                                'id' => 'KH002',
                                'phone' => '0312345597',
                                'email' => 'duong@gmail.com',
                                'roles' => 'Khách Hàng'
                            ],
                            // Add more users here...
                        ];
                        foreach ($users as $user) {
                            echo "<tr>
                                <td data-label='Ảnh đại diện'>
                                    <img src='{{ {$user['image']} }}' width='50' height='50' alt='Avatar of {$user['name']}'>
                                </td>
                                <td data-label='Thông tin cá nhân'>Họ và tên: {$user['name']}<br>ID tài khoản: {$user['id']}<br>Phone: {$user['phone']}<br>Email: {$user['email']}</td>
                                <td data-label='Vai trò'>{$user['roles']}</td>
                                <td data-label='Quản lí chức năng'>
                                    <button class='btn'>Chỉnh sửa thông tin</button><br>
                                    <button class='btn'>Xóa thông tin</button>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
                
                <div class="pagination">
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">5</a>
                    <a href="#">6</a>
                    <a href="#">7</a>
                    <a href="#">8</a>
                    <a href="#">9</a>
                    <a href="#">10</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
