<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $email, $password) {
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . $this->conn->error);
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        return $stmt->execute();
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . $this->conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                return ['id' => $id, 'username' => $username];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>

