<?php
    session_start();

    include_once '../database.php';
    $database = new Database();
    $db = $database->dbConnection();

    $query = "SELECT * FROM sinhvien";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $svlist = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
</head>
<body>
    <?php include __DIR__ . '/../shares/header.php'; ?>

    <h2>Danh sách sinh viên</h2>
    <a href="create.php">Thêm sinh viên</a>
    <table border="1">
        <tr>
            <th>MSSV</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Ngày sinh</th>
            <th>Hình ảnh</th>
            <th>Mã ngành</th>
            <th>Thao tác</th>
        </tr>
        <?php foreach ($svlist as $sv): ?>
        <tr>
            <td><?php echo htmlspecialchars($sv["MaSV"]); ?></td>
            <td><?php echo htmlspecialchars($sv["HoTen"]); ?></td>
            <td><?php echo htmlspecialchars($sv["GioiTinh"]); ?></td>
            <td><?php echo date("d/m/Y", strtotime($sv["NgaySinh"])); ?></td>
            <td>
                <?php if (!empty($sv["Hinh"])): ?>
                    <img src="/opensource/kiemtra/images/<?php echo htmlspecialchars($sv['Hinh']); ?>" width="100">
                    <?php else: ?>
                    Không có ảnh
                <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($sv["MaNganh"]); ?></td>
            <td>
                <a href="edit.php?MaSV=<?php echo urlencode($sv["MaSV"]); ?>">Sửa</a> | 
                <a href="detail.php?MaSV=<?php echo urlencode($sv["MaSV"]); ?>">Chi tiết</a> | 
                <a href="delete.php?MaSV=<?php echo urlencode($sv["MaSV"]); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
