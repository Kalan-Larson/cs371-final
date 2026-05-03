<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>You have been logged out.</h1>
    <p><a href="home.php">Return to the homepage</a></p>
</body>
</html>