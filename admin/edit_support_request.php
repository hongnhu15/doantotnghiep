<?php
include 'config.php';
require 'vendor/autoload.php'; // Đảm bảo rằng bạn đã cài đặt PHPMailer và Composer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $media_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM hotrotruyenthong WHERE media_id = '$media_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        die("Không tìm thấy yêu cầu hỗ trợ truyền thông với ID này.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $media_id = mysqli_real_escape_string($conn, $_POST['media_id']);
    $tendonvi = mysqli_real_escape_string($conn, $_POST['tendonvi']);
    $hotennguoigui = mysqli_real_escape_string($conn, $_POST['hotennguoigui']);
    $chucvu = mysqli_real_escape_string($conn, $_POST['chucvu']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $link_image = mysqli_real_escape_string($conn, $_POST['link_image']);
    $trangthaibaidang = mysqli_real_escape_string($conn, $_POST['trangthaibaidang']);

    $sqlUpdate = "UPDATE hotrotruyenthong SET 
        tendonvi = '$tendonvi',
        hotennguoigui = '$hotennguoigui',
        chucvu = '$chucvu',
        phone = '$phone',
        email = '$email',
        title = '$title',
        content = '$content',
        link_image = '$link_image',
        trangthaibaidang = '$trangthaibaidang'
        WHERE media_id = '$media_id'";

    if (mysqli_query($conn, $sqlUpdate)) {
        $message = "Yêu cầu hỗ trợ truyền thông đã được cập nhật thành công!";

        if ($trangthaibaidang == 'Từ chối đăng') {
            // Gửi email thông báo từ chối đăng
            $mail = new PHPMailer(true);
            try {
                //Cài đặt máy chủ thư
                $mail->CharSet = 'UTF-8';                                  
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'nhuph.mis@gmail.com';
                $mail->Password = 'bljhtlurxcrzshan'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                //Người gửi
                $mail->setFrom('no-reply@example.com', 'Admin trang thông tin điện tử Đoàn - Hội khoa HTTTQL');
                $mail->addAddress($email, $hotennguoigui);

                //Nội dung email
                $mail->isHTML(true);
                $mail->Subject = 'Yêu cầu hỗ trợ truyền thông bị từ chối';
                $mail->Body    = "Xin chào $hotennguoigui,<br><br>Yêu cầu hỗ trợ truyền thông của bạn với tiêu đề \"$title\" đã bị từ chối.<br><br>Trân trọng,<br>Admin";
                $mail->AltBody = "Xin chào $hotennguoigui,\n\nYêu cầu hỗ trợ truyền thông của bạn với tiêu đề \"$title\" đã bị từ chối.\n\nTrân trọng,\nAdmin";

                $mail->send();
            } catch (Exception $e) {
                $message .= " Có lỗi xảy ra khi gửi email: {$mail->ErrorInfo}";
            }
        }

        header("Location: manage_support_requests.php?message=" . urlencode($message));
        exit();
    } else {
        $message = "Có lỗi xảy ra: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa yêu cầu hỗ trợ truyền thông</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
        }
        .container {
            margin-top: 50px;   
            /*margin-left: 220px; /* Add this line */
            /* width: calc(100% - 220px); /* Add this line */
        }
        h2 {
            color: #34495e;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: #1abc9c;
            border-color: #1abc9c;
        }
        .btn-primary:hover {
            background-color: #16a085;
            border-color: #16a085;
        }
        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Chỉnh sửa yêu cầu hỗ trợ truyền thông</h2>
    <?php if (isset($message)) echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>'; ?>
    <form action="edit_support_request.php" method="POST">
        <input type="hidden" name="media_id" value="<?php echo htmlspecialchars($row['media_id']); ?>">
        <div class="form-group">
            <label for="tendonvi">Tên đơn vị:</label>
            <input type="text" id="tendonvi" name="tendonvi" class="form-control" value="<?php echo htmlspecialchars($row['tendonvi']); ?>" required>
        </div>
        <div class="form-group">
            <label for="hotennguoigui">Họ tên người gửi:</label>
            <input type="text" id="hotennguoigui" name="hotennguoigui" class="form-control" value="<?php echo htmlspecialchars($row['hotennguoigui']); ?>" required>
        </div>
        <div class="form-group">
            <label for="chucvu">Chức vụ:</label>
            <input type="text" id="chucvu" name="chucvu" class="form-control" value="<?php echo htmlspecialchars($row['chucvu']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="title">Tiêu đề bài truyền thông:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Nội dung cần hỗ trợ truyền thông:</label>
            <textarea id="content" name="content" class="form-control" required><?php echo htmlspecialchars($row['content']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="link_image">Link ảnh bài truyền thông:</label>
            <input type="text" id="link_image" name="link_image" class="form-control" value="<?php echo htmlspecialchars($row['link_image']); ?>" required>
        </div>
        <div class="form-group">
            <label for="trangthaibaidang">Trạng thái bài đăng:</label>
            <select id="trangthaibaidang" name="trangthaibaidang" class="form-control">
                <option value="Đã đăng" <?php if ($row['trangthaibaidang'] == 'Đã đăng') echo 'selected'; ?>>Đã đăng</option>
                <option value="Đang đợi kiểm duyệt" <?php if ($row['trangthaibaidang'] == 'Đang đợi kiểm duyệt') echo 'selected'; ?>>Đang đợi kiểm duyệt</option>
                <option value="Từ chối đăng" <?php if ($row['trangthaibaidang'] == 'Từ chối đăng') echo 'selected'; ?>>Từ chối đăng</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
