<?php
include("db.php");

//Checks if the customer is logged in.
//If not, redirects them to the login page.
if (!isset($_SESSION['customer'])) {
    header('Location: customer-login.php');
    exit;
}

$user = $_SESSION['customer'];
$customerID = (int) ($user['CustomerID'] ?? 0);

// Get bookings for the logged in customer before the current date.
$sql = "SELECT * FROM bookings WHERE CustomerID = ? AND RequestedDate < CURDATE()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <?php require 'header-customer.php'; ?>

        <section>
            <h1>Booking History</h1>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price</th>
                        <th>Service Provider</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['RequestedDate']); ?></td>
                            <td><?php echo htmlspecialchars($booking['BookingTime']); ?></td>
                            <td><?php echo htmlspecialchars($booking['FinalPrice']); ?></td>
                            <td><?php echo htmlspecialchars($booking['ServiceProvider']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <?php require 'footer.php'; ?>
    </div>
</body>
</html>