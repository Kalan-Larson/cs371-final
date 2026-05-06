<?php
include("db.php");
require 'header.php';

//Checks if the customer is logged in.
//If not, redirects them to the login page.
if (!isset($_SESSION['customer'])) {
    header('Location: customer-login.php');
    exit;
}

$user = $_SESSION['customer'];
$customerID = (int) ($user['CustomerID'] ?? 0);

// Get bookings for the logged in customer after the current date.
$sql = "SELECT * FROM bookings WHERE CustomerID = ? AND RequestedDate > CURDATE()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);
?>
    <div>

        <section>
            <h1>Upcoming Bookings</h1>
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