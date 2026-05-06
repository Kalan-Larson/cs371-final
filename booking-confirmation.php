<?php
include("db.php");
require 'header.php'; 

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
$preferredTime = $_POST['preferredTime'] ?? '';
$totalBaseCost = $_POST['totalBaseCost'] ?? 0;
$finalCost = $_POST['finalCost'] ?? 0;
$discount = $_POST['discount'] ?? 0;

// Default values for certain attributes
$status = 'Pending';
$serviceProvider = 'Unknown';
$message = 'Your booking is pending.';

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

// Create new booking record that binds the service request
// and the customer to it
$sql = "INSERT INTO bookings (CustomerID, RequestID, FinalPrice, RequestedDate, BookingTime, Status, ServiceProvider) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iidssss", $customerID, $serviceRequestID, $finalCost, $preferredDate, $preferredTime, $status, $serviceProvider);
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
<main class="container">
    <div>
    <?php require 'header-customer.php'; ?>

    <h1>Booking Confirmation</h1>
    <p><?php echo $message; ?></p>
    </div>
</main> 
<?php require 'footer.php'; ?>

