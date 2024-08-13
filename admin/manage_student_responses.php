<?php
include 'config.php';

$sql = "SELECT * FROM hoidap ORDER BY questionposted_at	 DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hỏi - Đáp</title>
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
        img {
            border-radius: 5px;
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
    </style>
</head>
<body>
<div class="container">
    <h2>Quản lý Hỏi - Đáp</h2>
    <?php if (isset($_GET['message'])) echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>'; ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>MSSV</th>
                <th>Email</th>
                <th>Nội dung câu hỏi</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['hotensinhvien']) . "</td>";
                echo "<td>" . htmlspecialchars($row['mssv']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['content_question']) . "</td>";
                echo "<td>
                        <a href='answer.php?id=" . htmlspecialchars($row['question_id']) . "' class='btn btn-primary'>Trả lời</a>
                        <a href='delete_question.php?id=" . htmlspecialchars($row['question_id']) . "' onclick='return confirm(\"Bạn có chắc muốn xóa?\");' class='btn btn-danger'>Xóa</a>
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
