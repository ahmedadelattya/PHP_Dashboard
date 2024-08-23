<?php
require_once '../classes/DatabaseManager.php';
require_once '../classes/User.php';
?>
<?php
// Start the session
session_start();
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Connect To The DataBase
    $db = new Database();
    $connection = $db->connect();

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if email exists
    $query = "SELECT password FROM users WHERE email = :email";
    $params = ['email' => $email];
    $result = $db->fetch($query, $params);

    if ($result) {
        // Email exists, proceed to password verification
        $hashedPassword = $result['password'];

        // Password Verification
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, start session and redirect
            $_SESSION['user_email'] = $email;
            header('Location: dashboard.php');
            exit;
        } else {
            // Password is incorrect
            $error = 'Incorrect password.';
        }
    } else {
        // Email does not exist
        $error = 'Invalid email address.';
    }

    // Disconnect the database connection
    $connection = $db->disconnect();
}
