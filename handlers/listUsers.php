<?php
require_once '../classes/DatabaseManager.php';
require_once '../classes/User.php';
?>
<?php
// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php'); // Redirect to login if not authenticated
    exit;
}

$email = $_SESSION['user_email'];

// Connect to the database
$db = new Database();
$connection = $db->connect();

// Query to get user Data
$query = "SELECT * FROM users where email != :email";
$params = ['email' => $email];
$result = $db->fetchAll($query, $params);

// Disconnect the database connection
$connection = $db->disconnect();
?>
