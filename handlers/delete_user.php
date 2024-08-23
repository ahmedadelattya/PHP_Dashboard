<?php require_once '../classes/DatabaseManager.php'; ?>
<?php
if (isset($_POST['submit-btn'])) {
    $email = $_POST['email'];

    //Connect To The DataBase
    $db = new Database();
    $connection = $db->connect();

    //Deleting The User From DB
    $query = "DELETE FROM users WHERE email = :email";
    $params = ['email' => $email];
    $rowsAffected = $db->updateOrDelete($query, $params);

    // Disconnect the database connection
    $connection = $db->disconnect();

    header('Location: ../urls/dashboard.php?page=listUsers');
    exit;
}
