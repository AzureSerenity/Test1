<?php
    include_once '../database.php';

    $registeredCount = 0;
    if (isset($_SESSION['MaSV'])) {
        $database = new Database();
        $db = $database->dbConnection();
        $mssv = $_SESSION['MaSV'];

        $query = "SELECT COUNT(*) AS total FROM ChiTietDangKy 
                JOIN DangKy ON ChiTietDangKy.MaDK = DangKy.MaDK 
                WHERE DangKy.MaSV = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$mssv]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $registeredCount = $result['total'] ?? 0;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sinh viên</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Test 1</a>
        <button class="navbar-toggler" type="button" data-logger="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="../sinhvien/index.php" class="nav-link">Sinh Viên</a>
                </li>
                <li class="nav-item">
                    <a href="../hocphan/hocphan.php" class="nav-link">Học Phần</a>
                </li>
                <li class="nav-item">
                    <a href="../authorize/dangky.php" class="nav-link">
                        Đăng Ký (<?php echo $registeredCount; ?>)
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../authorize/dangnhap.php" class="nav-link">Đăng Nhập</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
