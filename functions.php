<?php
function image_validation($image_name, $image_size, $image_temp, $image_type)
{
    if (empty($image_name)) {
        return 'Please select a file';
    }

    // Validate MIME type using finfo
    $file_info = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $file_info->file($image_temp);

    $allowed_images_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

    if (!in_array($mime_type, $allowed_images_types)) {
        return 'Only JPEG, JPG, PNG, and GIF image files are allowed';
    }

    // Validate file size
    $upload_max_size = 2 * 1024 * 1024; // 2MB
    if ($image_size > $upload_max_size) {
        return "Image must be less than 2MB";
    }

    // Generate a unique file name
    $str = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $length = 10;
    $new_name = substr(str_shuffle($str), 0, $length);

    $extension = pathinfo($image_name, PATHINFO_EXTENSION);
    $image_name = $new_name . "." . $extension;

    // Ensure the 'uploads' directory exists
    $upload_dir = "../uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Check if the file already exists in the directory
    if (file_exists($upload_dir . $image_name)) {
        return "Image already exists in the folder";
    }

    // Move the uploaded file to the target directory
    $move_file = move_uploaded_file($image_temp, $upload_dir . $image_name);
    if (!$move_file) {
        return "File not saved. Please try again";
    }

    // Return the path to the saved image for further use
    return $upload_dir . $image_name;
}



// Function to authenticate user
function authenticate_user($email, $password)
{
    $file_path = '../users.json'; // Adjust path if necessary
    if (!file_exists($file_path)) {
        return 'User data file does not exist.';
    }

    $jsonData = file_get_contents($file_path);
    if ($jsonData === false) {
        return 'Failed to read user data file.';
    }

    $users = json_decode($jsonData, true);
    if (!is_array($users)) {
        return 'Invalid user data format.';
    }

    foreach ($users as $user) {
        if ($user['Email'] === $email && $user['Password'] === $password) {
            return true; // User authenticated
        }
    }
    return 'Invalid email or password'; // Authentication failed
}

// Function to get user data
function get_user_data($email) {
    $file_path = '../users.json'; // Adjust path if necessary
    if (!file_exists($file_path)) {
        return null;
    }

    $jsonData = file_get_contents($file_path);
    if ($jsonData === false) {
        return null;
    }

    $users = json_decode($jsonData, true);
    if (!is_array($users)) {
        return null;
    }

    foreach ($users as $user) {
        if ($user['Email'] === $email) {
            return $user;
        }
    }
    return null;
}
