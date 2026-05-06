<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Lawn Fargo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="navbar">
    <div class="nav-container">

        <nav class="nav-left">
            <a href="home.php">Home</a>
            <a href="service-view.php">Services</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
        </nav>

        <nav class="nav-right">
            <?php if (isset($_SESSION['admin'])): ?>
                <a href="admin-dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>

            <?php elseif (isset($_SESSION['customer'])): ?>
                <a href="customer-dashboard.php">Dashboard</a>
                <a href="service-request-booking.php">Book</a>
                <a href="booking-history.php">History</a>
                <a href="logout.php">Logout</a>

            <?php else: ?>
                <a href="customer-login.php" class="btn-login">Login</a>
                <a href="registration.php">Register</a>
            <?php endif; ?>
        </nav>

    </div>
</header>