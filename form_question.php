<?php
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotensinhvien = mysqli_real_escape_string($conn, $_POST['hotensinhvien']);
    $mssv = mysqli_real_escape_string($conn, $_POST['mssv']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $content_question = mysqli_real_escape_string($conn, $_POST['content_question']);

    $sqlInsert = "INSERT INTO hoidap (hotensinhvien, mssv, email, content_question) VALUES ('$hotensinhvien', '$mssv', '$email', '$content_question')";

    if (mysqli_query($conn, $sqlInsert)) {
        $message = "Câu hỏi của bạn đã được gửi thành công!";
    } else {
        $message = "Có lỗi xảy ra: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt câu hỏi</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .required {
            color: red;
        }
        .buttons-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .custom-button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition: background-color 0.3s, transform 0.3s;
            cursor: pointer;
            border-radius: 5px;
        }

        .custom-button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .custom-button.active {
            background-color: #5dade2;
        }
    </style>
</head>
<body>
    <header>
        <?php require "layouts/header.php"; ?>
    </header>
    <main>
        <div class="container">
            <div class="media-support-form">
                <h2>Gửi câu hỏi</h2>
                <?php if (!empty($message)) echo "<p>$message</p>"; ?>
                <form action="form_question.php" method="POST">
                    <div class="form-group">
                        <label for="hotensinhvien">Họ tên: <span class="required">*</span></label>
                        <input type="text" id="hotensinhvien" name="hotensinhvien" placeholder="Nhập họ và tên..." required>
                    </div>
                    <div class="form-group">
                        <label for="mssv">Mã số sinh viên: <span class="required">*</span></label>
                        <input type="text" id="mssv" name="mssv" placeholder="Nhập mã số sinh viên..." required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <span class="required">*</span></label>
                        <input type="email" id="email" name="email" placeholder="Nhập email..." required>
                    </div>
                    <div class="form-group">
                        <label for="content_question">Nội dung câu hỏi: <span class="required">*</span></label>
                        <textarea id="content_question" name="content_question" placeholder="Nhập nội dung câu hỏi..." required></textarea>
                    </div>
                    <button type="submit">Gửi câu hỏi</button>
                </form>
                <div class="buttons-container">
        <a href="hoidap.php" class="custom-button">Quay lại</a>
    </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Trường ĐH Ngân hàng TP. HCM Powered by nhuph.mis@gmail.com</p>
        </div>
    </footer>
</body>
</html>
