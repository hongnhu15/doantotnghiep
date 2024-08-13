<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if (isset($_GET['ID'])) {
  $id = $_GET['ID'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['Title']);
    $dataposted = mysqli_real_escape_string($conn, $_POST['DatePosted']);
    $content = mysqli_real_escape_string($conn, $_POST['Content']);

    if (isset($_FILES['ImageThongbao']) && $_FILES['ImageThongbao']['error'] === UPLOAD_ERR_OK) {
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
      $image = $target_file;
      $sql = "UPDATE thongbao SET Title='$title', DatePosted='$dataposted', Content='$content', ImageThongbao='$image' WHERE ID=$id";
    } else {
      $sql = "UPDATE thongbao SET Title='$title', DatePosted='$dataposted', Content='$content' WHERE ID=$id";
    }

    if (mysqli_query($conn, $sql)) {
      $_SESSION['message'] = "Thông báo đã được cập nhật thành công!";
      header("Location: admin.php?action=manage_announcements");
      exit;
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }

  $sql = "SELECT * FROM thongbao WHERE ID=$id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
} else {
  header("Location: admin.php?action=manage_announcements");
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông báo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Sửa thông báo</h2>
    <form action="edit_announcement.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Tiêu đề:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($row['Title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="event_date">Ngày diễn ra:</label>
            <input type="date" id="event_date" name="event_date" class="form-control" value="<?php echo htmlspecialchars($row['DatePosted']); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Nội dung:</label>
            <textarea id="content" name="content" class="form-control" required><?php echo htmlspecialchars($row['Content']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Tải ảnh lên:</label>
            <input type="file" id="image" name="image" class="form-control">
            <img src="<?php echo htmlspecialchars($row['ImageThongbao']); ?>" alt="Event Image" width="100">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="admin.php?action=manage_announcements" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>
