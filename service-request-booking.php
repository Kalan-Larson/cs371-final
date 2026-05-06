<?php
include("db.php");
include 'header.php';
//Checks if the customer is logged in.
//If not, redirects them to the login page.
if (!isset($_SESSION['customer'])) {
    header('Location: customer-login.php');
    exit;
}

$sql = "SELECT * FROM services";
$services = $conn->query($sql);
?>
<main class="container">
    <div>

        <section>
            <h1>Book Services Here!</h1>
            <form action="booking-estimation.php" method="post">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Base Price</th>
                            <th>Base Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="services[]" value="<?php echo htmlspecialchars($service['ServiceID']); ?>">
                                    <label for="services[]">Select Service</label>
                                </td>
                                <td><?php echo htmlspecialchars($service['Name']); ?></td>
                                <td><?php echo htmlspecialchars($service['Description']); ?></td>
                                <td><?php echo htmlspecialchars($service['BasePrice']); ?></td>
                                <td><?php echo htmlspecialchars($service['BaseDuration']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <label for="yard_size">Yard Size</label>
                <input type="text" id="yard_size" name="yard_size">

                <label for="notes">Additional Notes</label>
                <input type="text" id="notes" name="notes">

                <label for="preferred_date">Preferred Date</label>
                <input type="date" id="preferred_date" name="preferred_date">

                <label for="preferred_time">Preferred Time</label>
                <input type="time" id="preferred_time" name="preferred_time">

                <button type="submit">Book Services</button>
            </form>
        </section>

    </div>
</main>
<?php require 'footer.php'; ?>
