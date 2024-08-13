<?php
// header.php
function isActive($page) {
    return basename($_SERVER['PHP_SELF']) == $page ? 'selected' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<header>
    <div class="container header-content">
        <div class="header-logos-left">
            <div class="header-logo">
                <a href="//hub.edu.vn" title="Trường ĐH Ngân Hàng Thành Phố Hồ Chí Minh">
                    <img src="image/logohub.png" class="logo-hub" />
                </a>
            </div>
            <div class="header-logo">
                <a href="https://khoahtttql.buh.edu.vn/trang-chu.html" title="Khoa Hệ Thống thông tin quản lý">
                    <img src="image/logokhoahtttql.png" class="logo-khoa" />
                </a>
            </div>
        </div>
        <div class="header-titles">
            <h1>TRANG THÔNG TIN ĐIỆN TỬ</h1>
            <h1 class="highlight">ĐOÀN - HỘI KHOA HỆ THỐNG THÔNG TIN QUẢN LÝ</h1>
            <h1 class="highlight">TRƯỜNG ĐẠI HỌC NGÂN HÀNG TP. HCM</h1>
        </div>
        <div class="header-logos-right">
            <div class="header-logo">
                <img src="image/logodoan.png" class="logo-doan" />
            </div>
            <div class="header-logo">
                <img src="image/logohoi.png" class="logo-hoi" />
            </div>
        </div>
    </div>
    <div class="banner"></div>
    <nav>
        <ul>
            <li><a href="index.php" class="<?php echo isActive('index.php'); ?>"><i class="fa fa-home"></i>Trang chủ</a></li>
            <li class="dropdown">
                <a href="#" class="<?php echo isActive('doankhoa.php') || isActive('lienchihoi.php') ? 'selected' : ''; ?>"><i class="fa fa-users"></i>Giới thiệu <i class="fa fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="doankhoa.php" class="<?php echo isActive('doankhoa.php'); ?>">Đoàn khoa</a></li>
                    <li><a href="lienchihoi.php" class="<?php echo isActive('lienchihoi.php'); ?>">Liên chi Hội Sinh viên</a></li>
                </ul>
            </li>
            <li><a href="sukien.php" class="<?php echo isActive('sukien.php'); ?>"><i class="fa fa-newspaper-o"></i>Sự kiện</a></li>
            <li><a href="thongbao.php" class="<?php echo isActive('thongbao.php'); ?>"><i class="fa fa-volume-up"></i>Thông báo</a></li>
            <li><a href="hotrotruyenthong.php" class="<?php echo isActive('hotrotruyenthong.php'); ?>"><i class="fa fa-envelope-open-o"></i>Hỗ trợ truyền thông</a></li>
            <li class="dropdown">
                <a href="#" class="<?php echo isActive('diendan.php') || isActive('kiemdo.php') || isActive('hoidap.php') ? 'selected' : ''; ?>"><i class="fa fa-user"></i>Sinh viên <i class="fa fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="diendan.php" class="<?php echo isActive('diendan.php'); ?>">Diễn đàn</a></li>
                    <li><a href="kiemdo.php" class="<?php echo isActive('kiemdo.php'); ?>">Kiểm dò điểm phân loại</a></li>
                    <li><a href="hoidap.php" class="<?php echo isActive('hoidap.php'); ?>">Hỏi - Đáp</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
