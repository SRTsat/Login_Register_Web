<?php
include_once '../config/database.php';
include_once '../models/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User($conn);
    if ($user->register($username, $email, $password)) {
        header("Location: ../views/login.php");
    } else {
        echo "Registration failed. Email might already be in use.";
    }
}
?>