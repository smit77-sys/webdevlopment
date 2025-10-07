<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

echo "<h2>Welcome, " . htmlspecialchars($_SESSION["user"]) . "!</h2>";
echo "<p>Email: " . htmlspecialchars($_SESSION["email"]) . "</p>";

if (isset($_COOKIE["user"])) {
    echo "<p>Remembered user: " . htmlspecialchars($_COOKIE["user"]) . "</p>";
}

echo '<a href="logout.php">Logout</a>';
?>
