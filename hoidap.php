<?php
include 'config.php';

$sql = "SELECT * FROM hoidap WHERE content_answer IS NOT NULL ORDER BY questionposted_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hỏi - Đáp</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .btn-primary, .btn-danger {
            margin-right: 5px;
        }
        .btn-primary {
            background-color: #1abc9c;
            border-color: #1abc9c;
        }
        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }
        .btn-primary:hover {
            background-color: #16a085;
            border-color: #16a085;
        }
        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }
        .table thead th {
            background-color: #34495e;
            color: white;
            border: none;
        }
        .table thead th:first-child {
            border-top-left-radius: 10px;
        }
        .table thead th:last-child {
            border-top-right-radius: 10px;
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
<header>
<?php require "layouts/header.php"; ?>
</header>
<body>
<div class="container">
    <div class="buttons-container">
        <a href="form_question.php" class="custom-button">Gửi câu hỏi</a>
        <a href="giaidap.php" class="custom-button active">Giải đáp</a>
    </div>
    <h2>Hỏi - Đáp</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Thông tin sinh viên</th>
                <th>Nội dung câu hỏi và câu trả lời</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>
                        <p><strong>Họ tên:</strong> " . htmlspecialchars($row['hotensinhvien']) . "</p>
                        <p><strong>MSSV:</strong> " . htmlspecialchars($row['mssv']) . "</p>
                      </td>";
                echo "<td>
                        <p><strong>Nội dung câu hỏi:</strong><br>" . nl2br(htmlspecialchars($row['content_question'])) . "</p>
                        <p><strong>Nội dung câu trả lời:</strong><br>" . nl2br(htmlspecialchars($row['content_answer'])) . "</p>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
