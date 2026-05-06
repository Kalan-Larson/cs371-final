<?php
require 'header.php';
require 'db.php';

// Ensure admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingID = $_POST['booking_id'] ?? 0;
    $serviceProvider = $_POST['service_provider'] ?? '';
    $status = $_POST['status'] ?? '';

    if ($bookingID && $status && $serviceProvider) {
        $stmt = $conn->prepare("UPDATE bookings SET Status = ?, ServiceProvider = ? WHERE BookingID = ?");
        $stmt->bind_param("ssi", $status, $serviceProvider, $bookingID);
        $stmt->execute();
    }
}

// Get all bookings
$sql = "SELECT * FROM bookings ORDER BY RequestedDate DESC";
$result = $conn->query($sql);
?>

<main class="container">

    <h1><strong>Admin Dashboard</strong></h1>

    <section>
        <h2><strong>Manage Bookings</strong></h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Service Provider</th>
                    <th>Update</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['BookingID']); ?></td>
                        <td><?php echo htmlspecialchars($row['CustomerID']); ?></td>
                        <td><?php echo htmlspecialchars($row['RequestedDate']); ?></td>
                        <td><?php echo htmlspecialchars($row['BookingTime']); ?></td>
                        <td>$<?php echo number_format($row['FinalPrice'], 2); ?></td>

                        <form method="post">
                            <td>
                                <input type="hidden" name="booking_id" value="<?php echo $row['BookingID']; ?>">
                                <select name="status">
                                    <option value="Pending" <?php if ($row['Status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Confirmed" <?php if ($row['Status'] == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
                                    <option value="Completed" <?php if ($row['Status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="service_provider" value="<?php echo htmlspecialchars($row['ServiceProvider']); ?>">
                            </td>
                            <td>
                                <button type="submit" class="btn">Update</button>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </section>

</main>

<?php require 'footer.php'; ?>