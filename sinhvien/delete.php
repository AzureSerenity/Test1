<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa sinh viên</title>
</head>
<body>
    <?php include __DIR__ . '/../shares/header.php'; ?>

    <?php
        include_once '../database.php';
        $database = new Database();
        $db = $database->dbConnection();

        if (isset($_GET["MaSV"])) {
            $stmt = $db->prepare("DELETE FROM sinhvien WHERE MaSV = :MaSV");
            $stmt->bindParam(":MaSV", $_GET["MaSV"]);
            $stmt->execute();
            header("Location: index.php");
        }
    ?>
</body>
</html>