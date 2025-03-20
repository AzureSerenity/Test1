<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: white;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .form-group label {
            width: 100px;
            font-weight: normal;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="file"] {
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 250px;
        }
        .btn-group {
            margin-top: 15px;
            margin-left: 100px;
        }
        .btn {
            padding: 5px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 5px;
        }
        .btn-primary {
            background-color: #28a745;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $maSV = $_POST["MaSV"];
            $hoTen = $_POST["HoTen"];
            $gioiTinh = $_POST["GioiTinh"];
            $ngaySinh = $_POST["NgaySinh"];
            $hinh = $_POST["Hinh"];
            $maNganh = $_POST["MaNganh"];

            $query = "UPDATE sinhvien SET HoTen = :HoTen, GioiTinh = :GioiTinh, NgaySinh = :NgaySinh, 
                    Hinh = :Hinh, MaNganh = :MaNganh WHERE MaSV = :MaSV";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":MaSV", $maSV);
            $stmt->bindParam(":HoTen", $hoTen);
            $stmt->bindParam(":GioiTinh", $gioiTinh);
            $stmt->bindParam(":NgaySinh", $ngaySinh);
            $stmt->bindParam(":Hinh", $hinh);
            $stmt->bindParam(":MaNganh", $maNganh);
            $stmt->execute();
            header("Location: index.php");
        }
    ?>
    
    <h2>Sửa sinh viên</h2>

    <form method="POST">
        <div class="form-group">
            <label for="MaSV">Mã SV:</label>
            <input type="number" id="MaSV" name="MaSV" value="<?= $sv["MaSV"] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="HoTen">Họ Tên:</label>
            <input type="text" id="HoTen" name="HoTen" value="<?= $sv["HoTen"] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="GioiTinh">Giới Tính:</label>
            <input type="text" id="GioiTinh" name="GioiTinh" value="<?= $sv["GioiTinh"] ?>">
        </div>
        
        <div class="form-group">
            <label for="NgaySinh">Ngày Sinh:</label>
            <input type="date" id="NgaySinh" name="NgaySinh" value="<?= $sv["NgaySinh"] ?>">
        </div>
        
        <div class="form-group">
            <label for="Hinh">Hình:</label>
            <input type="file" id="Hinh" name="Hinh" value="<?= $sv["Hinh"] ?>">
        </div>
        
        <div class="form-group">
            <label for="MaNganh">Mã Ngành:</label>
            <input type="text" id="MaNganh" name="MaNganh" value="<?= $sv["MaNganh"] ?>">
        </div>
        
        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Quay Lại</button>
        </div>
    </form>
</body>
</html>