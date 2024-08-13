<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if (isset($_GET['question_id'])) {
    $id = $_GET['question_id'];
    $sql = "DELETE FROM hoidap WHERE question_id=$id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Câu hỏi đã được xóa thành công!";
    } else {
        $_SESSION['message'] = "Xóa câu hỏi thất bại!";
    }
}

header("Location: admin.php?action=manage_student_responses");
exit;
?>
