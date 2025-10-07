<?php
// filepath: c:\xampp\htdocs\WebDevlopment\logout.php

// 1. Start the session so we can access and destroy it.
session_start();

// 2. Unset all of the session variables.
// This clears all data stored in the session.
$_SESSION = array();

// 3. Destroy the session completely.
session_destroy();

// 4. Delete the login cookie.
// To delete a cookie, you must set its expiration date to a time in the past.
if (isset($_COOKIE['user_session'])) {
    setcookie('user_session', '', time() - 3600, '/'); // Set expiration to one hour ago
}

// 5. Redirect the user to the login page.
// This is where the "login option is open".
header("Location: index.html");
exit(); // Always call exit() after a header redirect to ensure the script stops.
?>