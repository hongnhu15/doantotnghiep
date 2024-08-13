<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $sql = "DELETE FROM thongbao WHERE ID=$id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Thông báo đã được xóa thành công!";
    } else {
        $_SESSION['message'] = "Xóa thông báo thất bại!";
    }
}

header("Location: admin.php?action=manage_announcements");
exit;
?>
