<?php
    session_start();
    include_once '../database.php';

    $database = new Database();
    $db = $database->dbConnection();
    $error = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $maSV = $_POST["MaSV"];

        $stmt = $db->prepare("SELECT * FROM sinhvien WHERE MaSV = :MaSV");
        $stmt->bindParam(":MaSV", $maSV);
        $stmt->execute();
        $sv = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($sv) {
            $_SESSION["MaSV"] = $sv["MaSV"];
            $_SESSION["HoTen"] = $sv["HoTen"];
            header("Location: ../hocphan/hocphan.php");
            exit();
        } else {
            $error = "MSSV không tồn tại!";
        }
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 400px;">
        <h2 class="text-center mb-4">Đăng Nhập</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Mã SV</label>
                <input type="text" name="MaSV" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
        </form>
    </div>
</body>
</html>
