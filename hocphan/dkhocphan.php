<?php
session_start();
if (!isset($_SESSION['MaSV'])) {
    header("Location: ../authorize/dangnhap.php");
    exit();
}

include_once '../database.php';
$database = new Database();
$db = $database->dbConnection();
$mssv = $_SESSION['MaSV'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['MaHP'])) {
        $maHP = $_POST['MaHP'];

        $checkQuery = "SELECT * FROM ChiTietDangKy 
                    JOIN DangKy ON ChiTietDangKy.MaDK = DangKy.MaDK
                    WHERE DangKy.MaSV = ? AND ChiTietDangKy.MaHP = ?";
        $stmtCheck = $db->prepare($checkQuery);
        $stmtCheck->execute([$mssv, $maHP]);

        if ($stmtCheck->rowCount() == 0) {
            $insertDKQuery = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (NOW(), ?)";
            $stmtInsertDK = $db->prepare($insertDKQuery);
            $stmtInsertDK->execute([$mssv]);
            $maDK = $db->lastInsertId();

            $insertCTQuery = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
            $stmtInsertCT = $db->prepare($insertCTQuery);
            $stmtInsertCT->execute([$maDK, $maHP]);
        }
    }

    if (isset($_POST['deleteMaHP'])) {
        $deleteHP = $_POST['deleteMaHP'];
        $deleteQuery = "DELETE FROM ChiTietDangKy 
                        WHERE MaHP = ? AND MaDK IN 
                        (SELECT MaDK FROM DangKy WHERE MaSV = ?)";
        $stmtDelete = $db->prepare($deleteQuery);
        $stmtDelete->execute([$deleteHP, $mssv]);
    }

    if (isset($_POST['deleteAll'])) {
        $deleteAllQuery = "DELETE FROM ChiTietDangKy WHERE MaDK IN 
                        (SELECT MaDK FROM DangKy WHERE MaSV = ?)";
        $stmtDeleteAll = $db->prepare($deleteAllQuery);
        $stmtDeleteAll->execute([$mssv]);
    }
}

$query = "SELECT HocPhan.MaHP, HocPhan.TenHP, HocPhan.SoTinChi 
        FROM ChiTietDangKy 
        JOIN DangKy ON ChiTietDangKy.MaDK = DangKy.MaDK
        JOIN HocPhan ON ChiTietDangKy.MaHP = HocPhan.MaHP
        WHERE DangKy.MaSV = ?";
$stmt = $db->prepare($query);
$stmt->execute([$mssv]);
$registeredList = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalCredits = 0;
$totalCourses = count($registeredList);
foreach ($registeredList as $row) {
    $totalCredits += $row['SoTinChi'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách học phần đã đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/../shares/header.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-3">Danh Sách Học Phần Đã Đăng Ký</h2>

        <table class="table table-bordered">
            <thead class="table-active">
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($totalCourses > 0) {
                    foreach ($registeredList as $row) {
                        echo "<tr>
                            <td>{$row['MaHP']}</td>
                            <td>{$row['TenHP']}</td>
                            <td>{$row['SoTinChi']}</td>
                            <td>
                                <form method='POST' class='d-inline'>
                                    <input type='hidden' name='deleteMaHP' value='{$row['MaHP']}'>
                                    <button type='submit' class='btn btn-danger btn-sm'>Xóa</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Chưa đăng ký học phần nào</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="mt-3">
            <p><strong>Tổng số học phần đã đăng ký:</strong> <?php echo $totalCourses; ?></p>
            <p><strong>Tổng số tín chỉ đã đăng ký:</strong> <?php echo $totalCredits; ?></p>
        </div>

        <?php if ($totalCourses >= 0): ?>
            <form method="POST" class="mt-3">
                <button type="submit" name="deleteAll" class="btn btn-danger mt-3" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ học phần đã đăng ký?')">Xóa Đăng Ký</button>
            </form>
        <?php endif; ?>

        <a href="hocphan.php" class="btn btn-primary mt-3">Quay lại danh sách học phần</a>
    </div>
</body>
</html>
