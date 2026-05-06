<?php
require 'header.php';
require 'db.php';

// Make sure user is logged in
if (!isset($_SESSION['customer'])) {
    header('Location: customer-login.php');
    exit;
}

$user = $_SESSION['customer'];
?>

<main class="container">

    <h1><strong>Customer Dashboard</strong></h1>

    <section class="dashboard">

        <p><strong>Welcome back!</strong></p>

        <div class="dashboard-grid">

            <a href="service-request-booking.php" class="dashboard-card">
                <h3>Book Services</h3>
                <p>Select and schedule lawn care services.</p>
            </a>

            <a href="booking-history.php" class="dashboard-card">
                <h3>Booking History</h3>
                <p>View your past completed bookings.</p>
            </a>

            <a href="booking-calendar.php" class="dashboard-card">
                <h3>Upcoming Bookings</h3>
                <p>See your scheduled services.</p>
            </a>

            <a href="feedback.php" class="dashboard-card">
                <h3>Leave Feedback</h3>
                <p>Share your experience with us.</p>
            </a>

            <a href="customer-update.php" class="dashboard-card">
                <h3>Update Profile</h3>
                <p>Manage your account information.</p>
            </a>

        </div>

    </section>

</main>

<?php require 'footer.php'; ?>