<?php
include 'config.php';

// Xử lý dữ liệu form khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tendonvi = mysqli_real_escape_string($conn, $_POST['tendonvi']);
    $hotennguoigui = mysqli_real_escape_string($conn, $_POST['hotennguoigui']);
    $chucvu = mysqli_real_escape_string($conn, $_POST['chucvu']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $link_image = mysqli_real_escape_string($conn, $_POST['link_image']);
    $image = '';  // Nếu bạn cần xử lý ảnh tải lên, thêm mã xử lý tại đây

    // Thực hiện truy vấn để lưu thông tin vào cơ sở dữ liệu
    $sqlInsert = "INSERT INTO hotrotruyenthong (tendonvi, hotennguoigui, chucvu, phone, email, title, content, link_image, image, trangthaibaidang) VALUES ('$tendonvi', '$hotennguoigui', '$chucvu', '$phone', '$email', '$title', '$content', '$link_image', '$image', 'Đang đợi kiểm duyệt')";
    if (mysqli_query($conn, $sqlInsert)) {
        $message = "Yêu cầu của bạn đã được gửi thành công và đang đợi kiểm duyệt!";
    } else {
        $message = "Có lỗi xảy ra: " . mysqli_error($conn);
    }
}

$limit = 5;

// Lấy trang hiện tại
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Lấy từ khóa tìm kiếm nếu có
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Lấy năm tìm kiếm nếu có
$year = isset($_GET['year']) ? (int)$_GET['year'] : '';

$sqlTotal = "SELECT COUNT(*) AS total FROM hotrotruyenthong WHERE trangthaibaidang = 'Đã đăng'";
if ($search || $year) {
    $sqlTotal .= " AND";
    $conditions = [];
    if ($search) {
        $conditions[] = " title LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
    }
    if ($year) {
        $conditions[] = " YEAR(dateposted) = $year";
    }
    $sqlTotal .= implode(" AND", $conditions);
}
$result = mysqli_query($conn, $sqlTotal);
$row = mysqli_fetch_assoc($result);
$total = $row['total'];

// Truy vấn sự kiện cho trang hiện tại
$sql = "SELECT * FROM hotrotruyenthong WHERE trangthaibaidang = 'Đã đăng'";
if ($search || $year) {
    $sql .= " AND";
    $conditions = [];
    if ($search) {
        $conditions[] = " title LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
    }
    if ($year) {
        $conditions[] = " YEAR(dateposted) = $year";
    }
    $sql .= implode(" AND", $conditions);
}
$sql .= " ORDER BY dateposted DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);

$pages = ceil($total / $limit);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hỗ trợ truyền thông</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .required {
            color: red;
        }
        
    </style>
</head>
<body>
    <header>
        <?php require "layouts/header.php"; ?>
    </header>
    <main>
        <div class="container">
            <div class="filter">
                <select id="yearFilter">
                    <option value="">Chọn năm</option>
                    <!-- Các năm sẽ được thêm vào đây bằng JavaScript -->
                </select>
                <form method="GET" action="hotrotruyenthong.php">
                    <input type="text" name="search" id="search" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit">Tìm kiếm</button>
                </form>
            </div>
            <div class="news-list">
                <h2>Năm <?php echo htmlspecialchars($year ? $year : date('Y')); ?></h2>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="news-item">
                        <div class="news-date"><?php echo date('d/m/Y', strtotime($row['dateposted'])); ?></div>
                        <div class="news-title"><a href="chitiethotro.php?id=<?php echo $row['media_id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="pagination">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <a href="hotrotruyenthong.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&year=<?php echo urlencode($year); ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
            <!-- Form nhập thông tin hỗ trợ truyền thông -->
            <div class="media-support-form">
                <h2>Thư hỗ trợ truyền thông</h2>
                <?php if (isset($message)) echo "<p>$message</p>"; ?>
                <form action="hotrotruyenthong.php" method="POST">
                    <div class="form-group">
                        <label for="tendonvi">Tên đơn vị: <span class="required">*</span></label>
                        <input type="text" id="tendonvi" name="tendonvi" placeholder="Nhập tên đơn vị ..." required>
                    </div>
                    <div class="form-group">
                        <label for="hotennguoigui">Tên người gửi: <span class="required">*</span></label>
                        <input type="text" id="hotennguoigui" name="hotennguoigui" placeholder="Nhập họ và tên..." required>
                    </div>
                    <div class="form-group">
                        <label for="chucvu">Chức vụ:</label>
                        <input type="text" id="chucvu" name="chucvu" placeholder="Chức vụ...">
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại: <span class="required">*</span></label>
                        <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại..." required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <span class="required">*</span></label>
                        <input type="email" id="email" name="email" placeholder="Nhập email..." required>
                    </div>
                    <div class="form-group">
                        <label for="title">Tiêu đề bài truyền thông: <span class="required">*</span></label>
                        <input type="text" id="title" name="title" placeholder="Nhập tiêu đề..." required>
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung cần hỗ trợ truyền thông: <span class="required">*</span></label>
                        <textarea id="content" name="content" placeholder="Nhập nội dung, các thông tin liên quan về bài đăng..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="link_image">Link ảnh bài truyền thông: <span class="required">*</span></label>
                        <input type="text" id="link_image" name="link_image" placeholder="Nhập link ảnh..." required>
                    </div>
                    <button type="submit">Gửi thư</button>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Trường ĐH Ngân hàng TP. HCM Powered by nhuph.mis@gmail.com</p>
        </div>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Thêm các năm vào filter
            const yearFilter = document.getElementById("yearFilter");
            const currentYear = new Date().getFullYear();
            const selectedYear = "<?php echo htmlspecialchars($year); ?>";

            for (let year = currentYear; year >= 2000; year--) {
                const option = document.createElement("option");
                option.value = year;
                option.textContent = year;
                if (year == selectedYear) {
                    option.selected = true;
                }
                yearFilter.appendChild(option);
            }

            // Cập nhật hidden input khi chọn năm
            yearFilter.addEventListener("change", function() {
                selectedYearInput.value = yearFilter.value;
            });
        });
    </script>
</body>
</html>

