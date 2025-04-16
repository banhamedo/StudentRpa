<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // If not logged in, redirect to login page
    exit();
}

echo "<h2>Welcome, " . $_SESSION['username'] . "!</h2>";
echo "<p>Your account is successfully logged in.</p>";
echo "<a href='logout.php'>Logout</a>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Add any additional content for the dashboard here -->
</body>
</html>
