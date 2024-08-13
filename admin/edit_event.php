<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $image = $target_file;
            $sql = "UPDATE sukien SET title='$title', event_date='$event_date', content='$content', status='$status', image='$image' WHERE event_id=$id";
        } else {
            $sql = "UPDATE sukien SET title='$title', event_date='$event_date', content='$content', status='$status' WHERE event_id=$id";
        }

        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "Sự kiện đã được cập nhật thành công!";
            header("Location: admin.php?action=manage_events");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    $sql = "SELECT * FROM sukien WHERE event_id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
} else {
    header("Location: admin.php?action=manage_events");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sự kiện</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Sửa sự kiện</h2>
    <form action="edit_event.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Tiêu đề:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="event_date">Ngày diễn ra:</label>
            <input type="date" id="event_date" name="event_date" class="form-control" value="<?php echo htmlspecialchars($row['event_date']); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Nội dung:</label>
            <textarea id="content" name="content" class="form-control" required><?php echo htmlspecialchars($row['content']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Trạng thái:</label>
            <select id="status" name="status" class="form-control" required>
                <option value="Đang diễn ra" <?php if ($row['status'] == 'Đang diễn ra') echo 'selected'; ?>>Đang diễn ra</option>
                <option value="Đã diễn ra" <?php if ($row['status'] == 'Đã diễn ra') echo 'selected'; ?>>Đã diễn ra</option>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Tải ảnh lên:</label>
            <input type="file" id="image" name="image" class="form-control">
            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Event Image" width="100">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="admin.php?action=manage_events" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>
