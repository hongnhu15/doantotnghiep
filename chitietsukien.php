<?php
include 'config.php';

// Lấy id từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Truy vấn lấy chi tiết tin tức
$sql = "SELECT * FROM sukien WHERE event_id = $id";
$result = mysqli_query($conn, $sql);

// Kiểm tra xem truy vấn có thành công không
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo 'Thông báo không tồn tại.';
    exit;
}

// Đóng kết nối
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['title']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <header>
        <?php require "layouts/header.php" ; ?>
    </header>
    <main>
        <div class="container">
            <article>
                <div class="content-block">
                    <h1><?php echo htmlspecialchars($row['title']); ?></h1>
                    <p><?php echo htmlspecialchars($row['event_date']); ?><p>
                    <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                </div>
                <?php
                if (!empty($row['image'])) {
                    echo '<img src="admin/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '" style="width: 100%; height: auto;">';
                }
                ?>
            </article>
        </div>
    </main>
    <footer>
        <!-- Nội dung footer của bạn -->
    </footer>
</body>

</html>
