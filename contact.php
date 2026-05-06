<?php require 'header.php'; ?>

<?php
// Simple success message (no database)
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = true;
}
?>

<main class="container">

    <h1><strong>Contact Us</strong></h1>

    <!-- Contact Info -->
    <section class="contact-info">
        <p><strong>Green Lawn Fargo</strong></p>
        <p>Phone: (701) 555-1234</p>
        <p>Address: 123 Greenway Dr, Fargo, ND</p>
    </section>

    <hr>

    <!-- Success Message -->
    <?php if ($success): ?>
        <p class="success">Thank you! Your message has been received.</p>
    <?php endif; ?>

    <!-- Contact Form -->
    <section class="contact-form">
        <h2><strong>Send Us a Message</strong></h2>

        <form method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" required></textarea>
            
            <br><br>

            <button type="submit" class="btn primary">Submit</button>
        </form>
    </section>

</main>

<?php require 'footer.php'; ?>