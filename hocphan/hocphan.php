<?php
    session_start();
    if (!isset($_SESSION['MaSV'])) {
        header("Location: ../authorize/dangnhap.php");
        exit();
    }

    include_once '../database.php';
    $database = new Database();
    $db = $database->dbConnection();

    $query = "SELECT * FROM hocphan";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $hplist = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách học phần</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/../shares/header.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-3">Danh Sách Học Phần</h2>

        <table class="table table-bordered">
            <thead class="table-active">
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Số Lượng Dự Kiến</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($hplist) > 0) {
                    foreach ($hplist as $row) {                
                        echo "<tr>
                            <td>{$row['MaHP']}</td>
                            <td>{$row['TenHP']}</td>
                            <td>{$row['SoTinChi']}</td>
                            <td>{$row['SoLuongDuKien']}</td>
                            <td>
                                <form action='dkhocphan.php' method='POST'>
                                    <input type='hidden' name='MaHP' value='{$row['MaHP']}'>
                                    <button type='submit' class='btn btn-success btn-sm'>Đăng ký</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Không có học phần nào</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="dkhocphan.php" class="btn btn-primary mt-3">Xem học phần đã đăng ký</a>
    </div>
</body>
</html>
