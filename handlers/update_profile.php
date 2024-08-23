<?php
session_start();
require_once '../functions.php';
require_once '../classes/image.php';
require_once '../classes/DatabaseManager.php';
require_once '../classes/User.php';

$errors = [];
$success = '';
$response = null;
if (isset($_POST['submit-btn'])) {
    $data = $_POST;

    // Validate name
    if (empty($_POST["name"]) || trim($_POST["name"]) === "") {
        $errors['name'] = "Name is required.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty($_POST["email"]) || trim($_POST["email"]) === "") {
        $errors['email'] = "Email is cannot Be Blank Smart!";
    } else if ($_POST['email'] != $_SESSION['user_email']) {
        $errors['email'] = "Email Can not Be Changed You Smart Man.";
    } else {
        $email = trim($_POST['email']);
    }

    // Validate room
    if (empty($_POST["room"]) || trim($_POST["room"]) === "") {
        $errors['room'] = "Room is required.";
    } else {
        $selected_room = trim($_POST["room"]);
        $allowed_rooms = ['Application1', 'Application2', 'Cloud'];
        if (!in_array($selected_room, $allowed_rooms)) {
            $errors['room'] = "Invalid room selection.";
        }
    }

    // Image 
    $imagePath = null;
    $uploadedImg = $_FILES['image'];
    $imageValidator = new image();
    $response = $imageValidator->image_validation($uploadedImg['name'], $uploadedImg['size'], $uploadedImg['tmp_name'], $uploadedImg['type']);

    if (strpos($response, "../uploads/") === 0) {
        $imagePath = $response;
    } else {
        //Connect To The DataBase
        $db = new Database();
        $connection = $db->connect();

        //Get The User Current profile Image
        $query = "SELECT prof_pic FROM users WHERE email = :email";
        $params = ['email' => $email];
        $result = $db->fetch($query, $params);


        if ($result) {
            $imagePath = $result['prof_pic'];
        } else {
            $errors['Image'] = 'Please Select An Image';
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


    // Check for errors
    if (empty($errors)) {
        //Connect To The DataBase
        $db = new Database();
        $connection = $db->connect();


        // Prepare the query
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

        //Close The DataBase Connection
        $db->disconnect();

        $success = 'Your info was updated successfully.';
        $_SESSION['success'] = $success;
        $_SESSION['response'] = $response;
    } else {
        $_SESSION['errors'] = $errors;
    }

    header('Location: ../urls/dashboard.php?page=profile');
    exit;
}
