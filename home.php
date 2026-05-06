<?php require 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- HERO SECTION -->
<section class="hero">
    <h1>Green Lawn Fargo</h1>
    <p>Professional Lawn Care & Landscaping Services</p>

    <div class="hero-buttons">
        <a href="service-view.php" class="btn">View Services</a>
        <a href="service-request-booking.php" class="btn primary">Book Now</a>
    </div>
</section>

<!-- SERVICES PREVIEW -->
<section class="services">
    <h2>Our Services</h2>

    <div class="service-grid">
        <div class="service-card">
            <h3>Grass Seeding</h3>
            <p>Improve lawn thickness and health.</p>
        </div>

        <div class="service-card">
            <h3>Weed Control</h3>
            <p>Remove unwanted weeds efficiently.</p>
        </div>

        <div class="service-card">
            <h3>Lawn Fertilizing</h3>
            <p>Boost lawn growth with proper nutrients.</p>
        </div>

        <div class="service-card">
            <h3>Seasonal Cleanup</h3>
            <p>Leaf and debris removal for a clean yard.</p>
        </div>
    </div>

    <!-- CTA to full services -->
    <div class="center">
        <a href="service-view.php" class="btn">View All Services</a>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="why">
    <h2>Why Choose Us?</h2>
    <ul>
        <li>Affordable pricing</li>
        <li>Fast and reliable scheduling</li>
        <li>Professional lawn care experts</li>
    </ul>
</section>

<!-- FINAL CTA -->
<section class="cta">
    <h2>Let's Get Started!</h2>
    <a href="registration.php" class="btn primary">Register</a>
    <p><a href="customer-login.php">Already have an account? Login</a></p>
</section>

<?php require 'footer.php'; ?>

</body>
</html>