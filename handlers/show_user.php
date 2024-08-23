<?php
session_start();
require_once '../functions.php';
require_once '../classes/DatabaseManager.php';
require_once '../classes/User.php';

$errors = [];
$success = '';
$response = null;
$result = null; // Ensure result is null initially

// Handle form submission
if (isset($_POST['submit-btn'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $selected_room = $_POST['room'];
    $imagePath = null;

    // Validate name
    if (empty($name) || trim($name) === "") {
        $errors['name'] = "Name is required.";
    }

    // Validate email
    if (empty($email) || trim($email) === "") {
        $errors['email'] = "Email cannot be blank.";
    }

    // Validate room
    if (empty($selected_room) || trim($selected_room) === "") {
        $errors['room'] = "Room is required.";
    } else {
        $allowed_rooms = ['Application1', 'Application2', 'Cloud'];
        if (!in_array($selected_room, $allowed_rooms)) {
            $errors['room'] = "Invalid room selection.";
        }
    }

    // Image Validation
    $uploadedImg = $_FILES['image'];

    if (!empty($uploadedImg['name'])) {
        $response = image_validation($uploadedImg['name'], $uploadedImg['size'], $uploadedImg['tmp_name'], $uploadedImg['type']);

        if (strpos($response, "../uploads/") === 0) {
            $imagePath = $response;
        } else {
            $errors['Image'] = $response;
        }
    }

    // Handle password update
    $updatePassword = false;
    if (!empty($_POST['password']) && !empty($_POST['confPassword'])) {
        if ($_POST['password'] === $_POST['confPassword']) {
            $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $updatePassword = true;
        } else {
            $errors['password'] = 'Passwords do not match.';
        }
    } else if (!empty($_POST['password']) || !empty($_POST['confPassword'])) {
        $errors['password'] = 'Passwords do not match.';
    }

    // If no errors, process the update
    if (empty($errors)) {
        $db = new Database();
        $connection = $db->connect();

        // Get the user's current profile image if a new one isn't uploaded
        if (empty($imagePath)) {
            $query = "SELECT prof_pic FROM users WHERE email = :email";
            $params = ['email' => $email];
            $result = $db->fetch($query, $params);
            $imagePath = $result['prof_pic'];
        }

        // Prepare the update query
        $query = "UPDATE users SET name = :name, room = :room, prof_pic = :prof_pic" . ($updatePassword ? ", password = :password" : "") . " WHERE email = :email";
        $params = [
            'name' => $name,
            'email' => $email,
            'room' => $selected_room,
            'prof_pic' => $imagePath
        ];

        if ($updatePassword) {
            $params['password'] = $hashedPassword;
        }

        // Execute the update
        $rowsAffected = $db->updateOrDelete($query, $params);

        // Disconnect the database connection
        $db->disconnect();

        $success = 'Your info was updated successfully.';
        $_SESSION['success'] = $success;
        $_SESSION['response'] = $response;

        // Redirect to avoid resubmission on refresh
        header("Location: show_user.php?email=$email");
        exit;
    } else {
        // Re-query user data if validation failed (so the form is populated)
        $db = new Database();
        $connection = $db->connect();
        $query = "SELECT * FROM users WHERE email = :email";
        $params = ['email' => $email];
        $result = $db->fetch($query, $params);
        $db->disconnect();
        $_SESSION['errors'] = $errors;
    }
} else if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Connect to the database
    $db = new Database();
    $connection = $db->connect();

    // Query to get user Data
    $query = "SELECT * FROM users WHERE email = :email";
    $params = ['email' => $email];
    $result = $db->fetch($query, $params);

    // Disconnect the database connection
    $db->disconnect();

    if (!$result) {
        $errors[] = "User not found.";
    }
} else {
    $errors[] = "No user email specified.";
}
