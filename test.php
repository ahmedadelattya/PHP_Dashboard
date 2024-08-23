<?php
require_once 'classes/DatabaseManager.php';
require_once 'classes/User.php';

$db = new Database();
$connection = $db->connect();

$query = "SELECT * FROM Users WHERE Room = :room";
$params = ['room' => 'Application1'];
$user = $db->fetch($query, $params);
print_r($user);


$email = 'medo.adel1399@gmail.com';
$name = 'Ahmed Adel';
$password = 'Ahmed123@';
$room = 'Application1';
$profPic = './uploads/R5IXNhnETY.jpg';

$newUser = new User($email, $name, $password, $room, $profPic);

$newUser->setRoom('Ahmed Adel');
echo "<pre>";
var_dump($newUser);
echo "</pre>";
$newUser->setRoom('Cloud');
echo "<pre>";
var_dump($newUser);
echo "</pre>";
