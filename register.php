<?php
// filepath: c:\xampp\htdocs\WebDevlopment\register.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Validate input
    if (empty($name) || empty($email) || empty($_POST['password']) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid input.";
        exit();
    }

    // Store data in text file (CSV format)
    $data = [$name, $email, $password];
    $file = fopen("registrations.txt", "a");
    fputcsv($file, $data);
    fclose($file);

    // Confirmation message
    echo "Registration successful!";
}
?>
