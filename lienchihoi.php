<?php
include 'config.php';

// Truy vấn lấy danh sách thành viên đang hoạt động
$sql = "SELECT hoten, chucvu, nhiemky FROM danhsachbchlienchihoi WHERE trangthai = 'Đang hoạt động'";
$result = mysqli_query($conn, $sql);

// Kiểm tra xem truy vấn có thành công không
if ($result && mysqli_num_rows($result) > 0) {
    $members = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $members = [];
}
$nhiemky = '';
if (!empty($members)) {
    $nhiemky = htmlspecialchars($members[0]['nhiemky']);
}

// Đóng kết nối
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
</head>
<header>
    <?php require "layouts/header.php"; ?>
</header>
<body>
<main>
    <div class="container">
        <article>
            <div class="content-block">
                <h2 style="color: orange; text-align: center;">
                    THÔNG TIN NHÂN SỰ BAN CHẤP HÀNH<br> 
                    LIÊN CHI HỘI SINH VIÊN KHOA HTTTQL NHIỆM KỲ <?php echo $nhiemky; ?>
                </h2>
                <p style="text-align: justify;">
                    Ban Chấp hành Liên chi Hội Sinh viên khoa Hệ thống thông tin quản lý nhiệm kỳ <?php echo $nhiemky; ?> gồm các đồng chí sau:
                </p>
                <ol>
                    <?php foreach ($members as $index => $member): ?>
                        <li>
                            <?php echo htmlspecialchars($member['hoten']); ?> - <?php echo htmlspecialchars($member['chucvu']); ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
                <div class="image-container">
                    <img src="image/lienchihoi.jpg" style="max-width: 50%;">
                </div>
            </div>
        </article>
    </div>
</main>
</body>
</html>
