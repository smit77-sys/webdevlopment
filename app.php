<?php
session_start();

// Load registered users from registrations.txt
$users = [];
if (file_exists('registrations.txt')) {
    $lines = file('registrations.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = array_map('trim', explode('|', $line));
        if (count($parts) === 3) {
            list($name, $email, $password) = $parts;
            $users[$email] = ['name' => $name, 'password' => $password];
        }
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie("user", "", time() - 3600, "/");
    header("Location: login.html");
    exit();
}

// Already logged in?
$loggedInUser = $_SESSION['user'] ?? ($_COOKIE['user'] ?? null);

// Handle login form
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (isset($users[$email]) && $users[$email]['password'] === $password) {
        $_SESSION['user'] = $email;
        $loggedInUser = $email;
        setcookie("user", $email, time() + (86400 * 7), "/"); // 7 days
        header("Location: app.php");
        exit();
    } else {
        $error = "❌ Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Login System</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="container">
    <div class="form-box">
<?php if (!$loggedInUser): ?>
        <h2>Login</h2>
        <form method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
        <div class="message error"><?= $error ?></div>
        <div class="toggle-text">
            Don't have an account? <a href="register.html">Register here</a>.
        </div>
<?php else: ?>
        <h2>Welcome!</h2>
        <div class="message success">Login successfully!</div>
        <div class="toggle-text">
            <a href="app.php?logout=1">Logout</a> | 
            <a href="index.html">Go to Home</a>
        </div>
<?php endif; ?>
    </div>
</div>
</body>
</html>
