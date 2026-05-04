<?php
include("db.php");

//Checks if the customer is logged in.
//If not, redirects them to the login page.
if (!isset($_SESSION['customer'])) {
    header('Location: customer-login.php');
    exit;
}

// Collect submitted form data
$self = $_SERVER['PHP_SELF'];
$selectedServices = $_POST['services[]'] ?? [];
$yardSize = $_POST['yard_size'] ?? '';
$notes = $_POST['notes'] ?? '';
$preferredDate = $_POST['preferred_date'] ?? '';

// Set selected service session variable to pass data to the confirmation page
// when this page is submitted.
session_start();
$_SESSION['selectedServices'] = $selectedServices;
// $_SESSION['yardSize'] = $yardSize;
// $_SESSION['notes'] = $notes;
// $_SESSION['preferredDate'] = $preferredDate;

// Calculate total base cost of all selected services
$totalBaseCost = 0;
foreach ($selectedServices as $serviceID) {
    $sql = "SELECT BasePrice FROM services WHERE ServiceID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $serviceID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $totalBaseCost += (float)$row['BasePrice'];
    }
}

// Determine final cost based on discount. Apply 10% discount if
// more than 3 or more services are selected, otherwise no discount. Also
// save discount for display purposes.
$discount = 0;
$finalCost = $totalBaseCost;
if (count($selectedServices) > 2) {
    $finalCost = $totalBaseCost * 0.9; // 10% discount
    $discount = 10;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Estimation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <?php require 'header-customer.php'; ?>

        <section>
            <h1>Booking Estimation</h1>
            <form action="booking-confirmation.php" method="post">
                <input type="hidden" name="yardSize" value="<?php echo htmlspecialchars($yardSize); ?>">
                <input type="hidden" name="notes" value="<?php echo htmlspecialchars($notes); ?>">
                <input type="hidden" name="preferredDate" value="<?php echo htmlspecialchars($preferredDate); ?>">
                <input type="hidden" name="totalBaseCost" value="<?php echo htmlspecialchars($totalBaseCost); ?>">
                <input type="hidden" name="finalCost" value="<?php echo htmlspecialchars($finalCost); ?>">
                <input type="hidden" name="discount" value="<?php echo htmlspecialchars($discount); ?>">


                <p>Total Base Cost: $<?php echo number_format($totalBaseCost, 2); ?></p>
                <p>Discount: <?php echo $discount; ?>%</p>
                <p>Final Cost: $<?php echo number_format($finalCost, 2); ?></p>

                <h2>Do you wish to confirm this booking?</h2>
                <button type="submit">Confirm Booking</button>
                <button><a href="index.php">Cancel</a></button>
            </form>
        </section>

        <?php require 'footer.php'; ?>
    </div>
</body>
</html>