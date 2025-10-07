<?php
// filepath: c:\xampp\htdocs\WebDevlopment\login.php

// 1. Start the session to manage the user's login state.
session_start();
require 'db.php';

// Check if the form was submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT name, password FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['name'];
            setcookie("user_session", $row['name'], time() + (86400 * 30), "/");

            // Redirect to the main home page.
            header("Location: home.html");
            exit();
        }
    }
    // If login fails, redirect back to the login page with an error flag.
    header("Location: index.html?error=1");
    exit();
}
?>