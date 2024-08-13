<?php
include 'config.php';

// Số thông báo trên mỗi trang
$limit = 5;

// Lấy trang hiện tại
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Lấy từ khóa tìm kiếm nếu có
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Lấy năm tìm kiếm nếu có
$year = isset($_GET['year']) ? (int)$_GET['year'] : '';

// Truy vấn tổng số thông báo
$sqlTotal = "SELECT COUNT(*) AS total FROM thongbao";
if ($search || $year) {
    $sqlTotal .= " WHERE";
    $conditions = [];
    if ($search) {
        $conditions[] = " Title LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
    }
    if ($year) {
        $conditions[] = " YEAR(DatePosted) = $year";
    }
    $sqlTotal .= implode(" AND", $conditions);
}
$result = mysqli_query($conn, $sqlTotal);
$row = mysqli_fetch_assoc($result);
$total = $row['total'];

// Truy vấn thông báo cho trang hiện tại
$sql = "SELECT * FROM thongbao";
if ($search || $year) {
    $sql .= " WHERE";
    $conditions = [];
    if ($search) {
        $conditions[] = " Title LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
    }
    if ($year) {
        $conditions[] = " YEAR(DatePosted) = $year";
    }
    $sql .= implode(" AND", $conditions);
}
$sql .= " ORDER BY DatePosted DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);

$pages = ceil($total / $limit);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <form method="GET" action="thongbao.php">
                    <input type="text" name="search" id="search" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>">
                    <input type="hidden" name="year" id="selectedYear" value="<?php echo htmlspecialchars($year); ?>">
                    <button type="submit">Tìm kiếm</button>
                </form>
            </div>
            <div class="news-list">
                <h2>Năm <?php echo htmlspecialchars($year ? $year : date('Y')); ?></h2>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="news-item">
                        <div class="news-date"><?php echo date('d/m/Y', strtotime($row['DatePosted'])); ?></div>
                        <div class="news-title"><a href="chitietthongbao.php?id=<?php echo $row['ID']; ?>"><?php echo htmlspecialchars($row['Title']); ?></a></div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="pagination">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <a href="thongbao.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&year=<?php echo urlencode($year); ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
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
            const selectedYearInput = document.getElementById("selectedYear");
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
