<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f7f6;
    }
    .sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 100;
      padding: 48px 0 0;
      box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
      background-color: #2c3e50;
    }
    .sidebar a {
      color: white !important;
      display: block;
      padding: 10px 15px;
      font-size: 16px;
      text-decoration: none;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #1abc9c;
      color: white !important;
    }
    .sidebar .nav-item {
      margin-bottom: 10px;
    }
    .navbar {
      font-weight: bold;
      margin: 0 auto;
      margin-bottom: 0px;
      background-color: #ecf0f1;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .navbar-nav {
      margin: 0 auto;
      width: 1000px;
      padding-left: 60px;
    }
    .navbar-nav a {
      color: black !important;
    }
    .content {
      margin-left: 240px;
      padding: 20px;
    }
    .content h2 {
      color: #34495e;
      margin-bottom: 20px;
    }
    .alert {
      margin-bottom: 20px;
    }
    .login {
      position: absolute;
      top: 10px;
      right: 10px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="admin.php">HOME ADMIN</a>
      </li>
    </ul>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item"><a href="admin.php?action=manage_events" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'manage_events' || !isset($_GET['action'])) ? 'active' : ''; ?>">Quản lý sự kiện</a></li>
            <li class="nav-item"><a href="admin.php?action=manage_announcements" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'manage_announcements') ? 'active' : ''; ?>">Quản lý thông báo</a></li>
            <li class="nav-item"><a href="admin.php?action=manage_support_requests" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'manage_support_requests') ? 'active' : ''; ?>">Quản lý hỗ trợ truyền thông</a></li>
            <li class="nav-item"><a href="admin.php?action=manage_student_responses" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'manage_student_responses') ? 'active' : ''; ?>">Quản lý Hỏi - Đáp</a></li>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-md-4 content">
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <?php
        $action = isset($_GET['action']) ? $_GET['action'] : 'manage_events';
        switch ($action) {
            case 'manage_events':
                include 'manage_events.php';
                break;
            case 'add_event':
                include 'add_event.php';
                break;
            case 'edit_event':
                include 'edit_event.php';
                break;
            case 'manage_announcements':
                include 'manage_announcements.php';
                break;
            case 'add_announcement':
                include 'add_announcement.php';
                break;
            case 'edit_announcement':
                include 'edit_announcement.php';
                break;
            case 'manage_support_requests':
                include 'manage_support_requests.php';
                break;
            case 'add_support':
                include 'add_support.php';
                break;
            case 'edit_support':
                include 'edit_support.php';
                break;
            case 'manage_student_responses':
                include 'manage_student_responses.php';
                break;
            default:
                include 'manage_events.php';
        }
        ?>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
