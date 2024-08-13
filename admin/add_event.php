<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Thêm sự kiện
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Xử lý tải ảnh lên
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image = $target_file;
    } else {
        $image = '';
    }

    $sql = "INSERT INTO sukien (title, event_date, content, status, image) VALUES ('$title', '$event_date', '$content', '$status', '$image')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Sự kiện đã được thêm thành công!";
        header("Location: admin.php?action=manage_events");
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
    <title>Thêm sự kiện</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Thêm sự kiện</h2>
    <form action="add_event.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Tiêu đề:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="event_date">Ngày diễn ra:</label>
            <input type="date" id="event_date" name="event_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content">Nội dung:</label>
            <textarea id="content" name="content" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="status">Trạng thái:</label>
            <select id="status" name="status" class="form-control" required>
                <option value="Đang diễn ra">Đang diễn ra</option>
                <option value="Đã diễn ra">Đã diễn ra</option>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Tải ảnh lên:</label>
            <input type="file" id="image" name="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="admin.php?action=manage_events" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>
