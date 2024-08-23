<?php
require_once '../classes/DatabaseManager.php';
require_once '../classes/User.php';
?>
<?php
// Start session
session_start();

// Check if logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Sticky Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link" href="dashboard.php?page=profile">Profile</a>
                    </li>
                    <li class="nav-item  ">
                        <a class="nav-link" href="dashboard.php?page=addUser">Add User</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="dashboard.php?page=listUsers">List Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Page Content -->
    <div class="container mt-4 content">
        <?php
        // Handle page routing
        $whitelistedPages = ["addUser", "profile", "listUsers"];

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if (in_array($page, $whitelistedPages)) {
                switch ($page) {
                    case "addUser":
                        require_once("../urls/adduser.php");
                        break;
                    case "profile":
                        require_once("../urls/profile.php");
                        break;
                    case "listUsers":
                        require_once("../urls/listUsers.php");
                        break;
                    default:
                        require_once("pages/404.php"); // Optional: for handling unknown pages
                        break;
                }
            } else {
                require_once("pages/404.php"); // Optional: for handling unknown pages
            }
        } else {
            require_once("../urls/listUsers.php"); // Default page content or dashboard overview
        }
        ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>