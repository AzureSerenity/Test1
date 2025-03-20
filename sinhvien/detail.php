<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin sinh viên</title>
</head>
<body>
    <?php include __DIR__ . '/../shares/header.php'; ?>

    <?php
        include_once '../database.php';
        $database = new Database();
        $db = $database->dbConnection();

        if (isset($_GET["MaSV"])) {
            $maSV = $_GET["MaSV"];
            $stmt = $db->prepare("SELECT * FROM sinhvien WHERE MaSV = :MaSV");
            $stmt->bindParam(":MaSV", $maSV);
            $stmt->execute();
            $sv = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    ?>

    <h2>Thông tin chi tiết</h2>
    <p>MSSV: <?= $sv["MaSV"] ?></p>
    <p>Họ tên: <?= $sv["HoTen"] ?></p>
    <p>Giới tính: <?= $sv["GioiTinh"] ?></p>
    <p>Ngày sinh: <?= $sv["NgaySinh"] ?></p>
    <p>Hình ảnh:<img src="/opensource/kiemtra/images/<?php echo htmlspecialchars($sv['Hinh']); ?>" width="100"></p>
    <p>Mã ngành: <?= $sv["MaNganh"] ?></p>
    <a href="index.php">Quay lại</a>

</body>
</html>