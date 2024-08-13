<?php
include 'config.php';

// Lấy id từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Truy vấn lấy chi tiết tin tức
$sql = "SELECT * FROM thongbao WHERE id = $id";
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
    <title><?php echo htmlspecialchars($row['Title']); ?></title>
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
                    <h1><?php echo htmlspecialchars($row['Title']); ?></h1>
                    <p><?php echo htmlspecialchars($row['DatePosted']); ?><p>
                    <p><?php echo nl2br(htmlspecialchars($row['Content'])); ?></p>
                </div>
                <?php
                if (!empty($row['ImageThongbao'])) {
                    echo '<img src="uploads/' . htmlspecialchars($row['ImageThongbao']) . '" alt="' . htmlspecialchars($row['Title']) . '" style="width: 100%; height: auto;">';
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
