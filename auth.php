<?php
session_start();

// Handle logout redirection if user is already logged in
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Dataset of valid users
$users = [
    "abc@gmail.com" => "password123",
    "admin@charusat.edu.in" => "admin123",
    "student@charusat.edu.in" => "student123"
];

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (isset($users[$email]) && $users[$email] === $password) {
        $_SESSION['user'] = $email;

        // Set cookie if remember-me checked
        if ($remember) {
            setcookie("user", $email, time() + (86400 * 7), "/"); // 7 days
        }

        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<form method="POST" action="">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>
        <input type="checkbox" name="remember"> Remember Me
    </label><br><br>

    <button type="submit">Login</button>
</form>
<p style="color:red;"><?php echo $error; ?></p>
</body>
</html>
