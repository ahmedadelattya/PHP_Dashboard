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
$query = "SELECT * FROM users WHERE email = :email";
$params = ['email' => $email];
$result = $db->fetch($query, $params);

// Disconnect the database connection
$connection = $db->disconnect();

// Fetch any success or error messages from the session
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';



// Clear the messages from the session after they've been displayed
unset($_SESSION['errors']);
unset($_SESSION['success']);
