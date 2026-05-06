<?php
session_start();
session_destroy();
require 'header.php';
?>
<main class="container">
    <h1>You have been logged out.</h1>
    <p><a href="home.php">Return to the homepage</a></p>
</main>
<?php require 'footer.php'; ?>