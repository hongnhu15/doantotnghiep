<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM sukien WHERE event_id=$id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Sự kiện đã được xóa thành công!";
    } else {
        $_SESSION['message'] = "Xóa sự kiện thất bại!";
    }
}

header("Location: admin.php?action=manage_events");
exit;
?>
