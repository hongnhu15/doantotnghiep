<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Thêm thông báo
    $title = mysqli_real_escape_string($conn, $_POST['Title']);
    $dateposted = mysqli_real_escape_string($conn, $_POST['DatePosted']);
    $content = mysqli_real_escape_string($conn, $_POST['Content']);

    // Xử lý tải ảnh lên
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["ImageThongbao"]["name"]);
    if (move_uploaded_file($_FILES["ImageThongbao"]["tmp_name"], $target_file)) {
        $image = $target_file;
    } else {
        $image = '';
    }

    $sql = "INSERT INTO thongbao (Title, DatePosted, Content, ImageThongbao) VALUES ('$title', '$dateposted', '$content', '$image')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Thông báo đã được thêm thành công!";
        header("Location: admin.php?action=manage_announcements");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thông báo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Thêm thông báo</h2>
    <form action="add_announcement.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="Title">Tiêu đề:</label>
            <input type="text" id="Title" name="Title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="DatePosted">Ngày đăng:</label>
            <input type="date" id="DatePosted" name="DatePosted" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="Content">Nội dung:</label>
            <textarea id="content" name="Content" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="ImageThongbao">Tải ảnh lên:</label>
            <input type="file" id="ImageThongbao" name="ImageThongbao" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="admin.php?action=manage_announcements" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>
