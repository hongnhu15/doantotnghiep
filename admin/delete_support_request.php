<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $media_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $sql = "DELETE FROM hotrotruyenthong WHERE media_id = '$media_id'";
    if (mysqli_query($conn, $sql)) {
        $message = "Yêu cầu hỗ trợ truyền thông đã được xóa thành công!";
    } else {
        $message = "Có lỗi xảy ra: " . mysqli_error($conn);
    }

    header("Location: manage_support_requests.php?message=" . urlencode($message));
    exit();
}

mysqli_close($conn);
?>
