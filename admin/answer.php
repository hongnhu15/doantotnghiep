<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $question_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM hoidap WHERE question_id = '$question_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        die("Không tìm thấy câu hỏi với ID này.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['question_id'])) {
    $question_id = mysqli_real_escape_string($conn, $_POST['question_id']);
    $content_answer = mysqli_real_escape_string($conn, $_POST['content_answer']);
    $answered_at = date('Y-m-d H:i:s');

    $sqlUpdate = "UPDATE hoidap SET 
        content_answer = '$content_answer', 
        answered_at = '$answered_at' 
        WHERE question_id = '$question_id'";

    if (mysqli_query($conn, $sqlUpdate)) {
        $message = "Câu hỏi đã được trả lời thành công!";
        header("Location: manage_student_responses.php?message=" . urlencode($message));
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
    <title>Trả lời câu hỏi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
        }
        .container {
            margin-top: 50px;
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
    <h2>Trả lời câu hỏi</h2>
    <?php if (isset($message)) echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>'; ?>
    <form action="answer.php" method="POST">
        <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($row['question_id']); ?>">
        <div class="form-group">
            <label for="hotensinhvien">Họ tên sinh viên:</label>
            <input type="text" id="hotensinhvien" name="hotensinhvien" class="form-control" value="<?php echo htmlspecialchars($row['hotensinhvien']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="mssv">MSSV:</label>
            <input type="text" id="mssv" name="mssv" class="form-control" value="<?php echo htmlspecialchars($row['mssv']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="content_question">Nội dung câu hỏi:</label>
            <textarea id="content_question" name="content_question" class="form-control" readonly><?php echo htmlspecialchars($row['content_question']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="content_answer">Nội dung câu trả lời:</label>
            <textarea id="content_answer" name="content_answer" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi câu trả lời</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
