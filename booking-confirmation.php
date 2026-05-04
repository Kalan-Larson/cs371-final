<?php
include("db.php");

// Get session variables
session_start();
$selectedServices = $_SESSION['selectedServices'] ?? [];

//Checks if the customer is logged in.
//If not, redirects them to the login page.
if (!isset($_SESSION['customer'])) {
    header('Location: customer-login.php');
    exit;
}
$user = $_SESSION['customer'];
$customerID = (int) ($user['CustomerID'] ?? 0);

// Collect submitted form data
$yardSize = $_POST['yardSize'] ?? '';
$notes = $_POST['notes'] ?? '';
$preferredDate = $_POST['preferredDate'] ?? '';
$totalBaseCost = $_POST['totalBaseCost'] ?? 0;
$finalCost = $_POST['finalCost'] ?? 0;
$discount = $_POST['discount'] ?? 0;

// Default values for certain attributes
$status = 'Pending';
$serviceProvider = 'Unknown';
$message = 'Your booking has been confirmed. Thank you for choosing our services!';

// Create new service request
$sql = "INSERT INTO service_requests (CustomerID, YardSize, Notes, BaseTotal, DiscountPercent, FinalEstimate, Status) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issddds", $customerID, $yardSize, $notes, $totalBaseCost, $discount, $finalCost, $status);
$stmt->execute();

// Get the ID of the newly created service request
$serviceRequestID = $conn->insert_id;

// For each selected service, create a new service request item
// that binds the service to the new service request
foreach ($selectedServices as $service) {
    $sql = "INSERT INTO service_request_items (RequestID, ServiceID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $serviceRequestID, $service);
    $stmt->execute();
}

// Get current date and time
$bookingTime = date('Y-m-d H:i:s');

// Create new booking record that binds the service request
// and the customer to it
$sql = "INSERT INTO bookings (CustomerID, RequestID, FinalPrice, RequestedDate, BookingTime, Status, ServiceProvider) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iidssss", $customerID, $serviceRequestID, $finalCost, $preferredDate, $bookingTime, $status, $serviceProvider);
$stmt->execute();

// Get the ID of the newly created booking
$bookingID = $conn->insert_id;

// For each selected service, create a new booking services
// item that binds the service to the new booking
foreach ($selectedServices as $service) {
    $sql = "INSERT INTO booking_services (BookingID, ServiceID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $bookingID, $service);
    $stmt->execute();
}

// Create new confirmation record that includes the customer ID
// and the booking ID.
$sql = "INSERT INTO confirmations (BookingID, CustomerID, Message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $bookingID, $customerID, $message);
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require 'header-customer.php'; ?>

    <h1>Booking Confirmation</h1>
    <p><?php echo $message; ?></p>

    <?php require 'footer.php'; ?>
</body>
</html>