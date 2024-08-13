<?php
include 'config.php';

// Truy vấn lấy sự kiện mới nhất từ bảng sukien
$sql = "SELECT * FROM sukien ORDER BY event_date DESC LIMIT 5";
$events_result = mysqli_query($conn, $sql);

$events = [];
if ($events_result && mysqli_num_rows($events_result) > 0) {
    while ($event = mysqli_fetch_assoc($events_result)) {
        $events[] = $event;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
.admin-login {
    text-align: right;
    margin: 5px 15px;
    font-family: Arial, sans-serif;
}

.admin-login .btn {
    background-color: #1abc9c;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
}

.admin-login .btn:hover {
    background-color: white;
    color: #1abc9c;
    border: 2px solid #1abc9c;
}

    </style>
</head>

<body>
<header>
    <?php require "layouts/header.php"; ?>
    <!-- Nút Đăng nhập admin -->
    <div class="admin-login">
        <a href="login.php" class="btn btn-primary">Đăng nhập Admin</a>
    </div>
</header>
<main>
    <h3 style="color: orange">YOUTH FACULTY OF MANAGEMENT INFORMATION SYSTEMS</h3>
    <div class="main-content">
        <div class="slide-show">
            <?php foreach ($events as $index => $event): ?>
                <div class="slide <?= $index === 0 ? 'active' : '' ?>">
                    <img src="admin/<?= htmlspecialchars($event['image']) ?>" alt="Slide Image">
                    <div class="caption">
                        <a href="chitietsukien.php?id=<?= $event['event_id'] ?>" style="color: white;"><?= htmlspecialchars($event['title']) ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="btns">
                <div class="btn-left btn"><i class="fa fa-chevron-left"></i></div>
                <div class="btn-right btn"><i class="fa fa-chevron-right"></i></div>
            </div>
            <div class="index-images">
                <?php foreach ($events as $index => $event): ?>
                    <div class="index-item <?= $index === 0 ? 'active' : '' ?>" data-slide="<?= $index ?>"></div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="sidebar">
            <h3>Thông báo mới nhất</h3>
            <div class="latest-news">
                <?php
                // Kết nối tới database
                include 'config.php';

                // Truy vấn lấy tin tức mới nhất từ bảng thongbao
                $sql = "SELECT * FROM thongbao ORDER BY DatePosted DESC LIMIT 5";
                $result = mysqli_query($conn, $sql);

                // Kiểm tra xem truy vấn có thành công không
                if ($result && mysqli_num_rows($result) > 0) {
                    // Hiển thị thông báo
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="news-block">';
                        echo '<span class="date">' . date('d/m/Y', strtotime($row['DatePosted'])) . '</span>';
                        echo '<a href="chitietthongbao.php?id=' . $row['ID'] . '">';
                        echo '<h4>' . htmlspecialchars($row['Title']) . '</h4>';
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Không có thông báo nào.</p>';
                }

                // Đóng kết nối
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
    <p style="text-align: center">"Đoàn - Hội khoa Hệ thống Thông tin Quản lý <br>
        Nơi hội tụ những khát vọng muốn vươn xa."</p>
    <p>Là đơn vị trực thuộc Đoàn Thanh niên - Hội Sinh viên trường Đại học Ngân hàng TP. HCM, Đoàn - Hội khoa Hệ thống Thông Tin Quản lý mang trong mình sứ mệnh chăm lo đời sống cho sinh viên, đại diện cho tiếng nói của toàn thể sinh viên trong khoa và tích cực tạo ra các giá trị cho xã hội.<br>
        Là tổ chức chính trị - xã hội tập hợp các cá nhân là đại diện cho toàn thể Đoàn viên, Thanh niên, Hội viên, Sinh viên trong khoa. Đoàn kết, phát triển quan hệ đối ngoại, xây dựng môi trường lành mạnh cho việc học tập và rèn luyện các kỹ năng trong sinh viên
        . Đem đến những sân chơi bổ ích, lý thú, khoa học, đặc biệt là những giá trị về mặt tinh thần.</p>
    <P>Đoàn - Hội khoa Hệ thống Thông Tin Quản lý hoạt động theo nguyên tắc tự nguyện, cùng chung chí hướng, thống nhất hành động, sáng tạo và nỗ lực tiếp cận nhanh nhất công nghệ tiên tiến áp dụng trong lĩnh vực học tập và công tác.<br>
    Ngoài việc kế thừa những thành quả tốt đẹp từ các thế hệ đi trước, Ban Chấp hành Đoàn - Hội khoa đặc biệt chú trọng bồi dưỡng và tạo điều kiện cho nhân sự trong tổ chức phát huy những thế mạnh của bản thân và khả năng thích ứng trong mọi hoàn cảnh.</P>
    <img src="image/mis-footer.jpg" style="width: 100%;">
</main>
<footer>
    <div class="container">
            <p>&copy; 2024 Trường ĐH Ngân hàng TP. HCM Powered by nhuph.mis@gmail.com</p>
        </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="script.js"></script>
</body>

</html>
