<?php
include_once '../config/database.php';
include_once '../models/User.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($conn)) {
        echo "Database connection is set.<br>";
    } else {
        echo "Database connection is NOT set.<br>";
    }

    $user = new User($conn);

    if ($user) {
        echo "User object created successfully.<br>";
    } else {
        echo "Failed to create User object.<br>";
    }

    $login_result = $user->login($email, $password);

    if ($login_result) {
        $_SESSION['user_id'] = $login_result['id'];
        $_SESSION['username'] = $login_result['username'];
        header("Location: ../views/welcome.php");
    } else {
        echo "Login failed. Invalid email or password.";
    }
} else {
    echo "No POST data received.";
}
?>
