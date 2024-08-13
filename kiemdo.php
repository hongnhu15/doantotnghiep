<?php
include 'config.php';

// Truy vấn lấy danh sách sự kiện đã diễn ra
$sql = "SELECT title, linkkiemdo FROM sukien WHERE status = 'Đã diễn ra'";
$result = mysqli_query($conn, $sql);

// Kiểm tra xem truy vấn có thành công không
if ($result && mysqli_num_rows($result) > 0) {
    $members = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $members = [];
}

// Đóng kết nối
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm dò</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    .join-now {
        color: #1abc9c; /* Màu chữ ban đầu */
        text-decoration: none; /* Xóa gạch chân */
        transition: color 0.3s ease, transform 0.3s ease; /* Hiệu ứng chuyển đổi */
        justify-content: center; /* Căn giữa theo chiều ngang */
        align-items: center; /* Căn giữa theo chiều dọc */
    }

    .join-now:hover {
        color: #16a085; /* Màu chữ khi di chuột qua */
        transform: scale(1.1); /* Phóng to chữ khi di chuột qua */
    }

    .content-block {
        text-align: center;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    h2 {
        color: orange;
    }
</style>
<header>
    <?php require "layouts/header.php"; ?>
</header>
<body>
<main>
    <div class="container">
        <article>
            <div class="content-block">
                <h2>
                    DANH SÁCH KIỂM DÒ <br>ĐIỂM PHÂN LOẠI CÁC CHƯƠNG TRÌNH, HOẠT ĐỘNG
                </h2> 
                <ol style="text-align: justify;">
                    <?php foreach ($members as $index => $member): ?>
                        <li>
                            <?php echo htmlspecialchars($member['title']); ?> : 
                            <a href="<?php echo htmlspecialchars($member['linkkiemdo']); ?>" class="join-now">Link</a>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </article>
    </div>
</main>
</body>
</html>
