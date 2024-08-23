<?php
require_once '../functions.php';
require_once '../classes/DatabaseManager.php';
require_once '../classes/User.php';
require_once '../functions.php';
?>

<?php
// Initialize an array to hold error messages
$errors = [];
$response = null;
if (isset($_POST['submit-btn'])) {
    // Validate  name
    $data = $_POST;
    if (empty($_POST["name"]) || trim($_POST["name"]) === "") {
        $errors['name'] = " Name is required.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email , the Second way Is To Use Reg Exp
    if (empty($_POST["email"]) || trim($_POST["email"]) === "") {
        $errors['email'] = "Email is required.";
    } else {
        $email = trim($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }
    }

    // Validate password
    if (empty($_POST["password"]) || trim($_POST["password"]) === "") {
        $errors['password'] = "password is required.";
    } else {
        $password = $_POST["password"];
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        // check if password is well-formed
        if (!preg_match($pattern, $password)) {
            $errors['password'] = "password is inValid";
        }
    }

    // Validate password confirmation
    if (empty($_POST["confirmPassword"]) || trim($_POST["confirmPassword"]) === "") {
        $errors['confirmPassword'] = "confirm Password is required";
    } else {
        // check if password is matched
        if ($_POST["password"] != $_POST["confirmPassword"]) {
            $errors['confirmPassword'] = "Password does not match ";
        }
    }

    // Validate Rooms
    if (empty($_POST["room"]) || trim($_POST["room"]) === "") {
        $errors['room'] = "Room is required.";
    } else {
        $selected_room = trim($_POST["room"]);
        $allowed_rooms = ['Application1', 'Application2', 'Cloud'];
        if (!in_array($selected_room, $allowed_rooms)) {
            // The selected value is valid
            $errors['room'] = "Invalid room selection";
        }
    }
    // Image Validation
    $uploadedImg = $_FILES['image'];
    $response = image_validation($uploadedImg['name'], $uploadedImg['size'], $uploadedImg['tmp_name'], $uploadedImg['type']);
    // Check if the response is a valid path (successful upload)
    if (strpos($response, "../uploads/") === 0) {
        // The response is the path to the uploaded image
        $imagePath = $response;
    }

    // No Errors
    if (empty($errors)) {
        //Handling Adding a New User

        // Hash password before saving to database
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Create User object with hashed password
        $newUser = new User($email, $name, $hashedPassword, $selected_room, $imagePath);

        //Connect To The DataBase
        $db = new Database();
        $connection = $db->connect();

        //Inserting Data To The DataBase
        $query = "INSERT INTO users (email, name, password , room , prof_pic) VALUES (:email, :name ,:password , :room, :prof_pic)";
        $params = ['name' => $name, 'email' => $email, 'password' => $hashedPassword, 'room' => $selected_room, 'prof_pic' => $imagePath];
        $lastInsertedEmail = $db->insert($query, $params);

        // Disconnect the database connection
        $connection = $db->disconnect();

        header('Location: ../urls/dashboard.php?page=listUsers');
        exit;
    }
}
