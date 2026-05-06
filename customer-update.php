<?php
require 'header.php';
require 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['customer'])) {
    header('Location: customer-login.php');
    exit;
}

$customerID = $_SESSION['customer']['CustomerID'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    $stmt = $conn->prepare(
        "UPDATE customers SET FirstName=?, LastName=?, Email=?, Phone=?, Address=? WHERE CustomerID=?"
    );
    $stmt->bind_param("sssssi", $fname, $lname, $email, $phone, $address, $customerID);
    $stmt->execute();
}

// Get current user data (for pre-fill)
$stmt = $conn->prepare("SELECT * FROM customers WHERE CustomerID = ?");
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<main class="container">

    <h1><strong>Update Profile</strong></h1>

    <section class="update-form">
        <form method="post">

            <label>First Name</label>
            <input type="text" name="fname" value="<?php echo htmlspecialchars($user['FirstName']); ?>" required>

            <label>Last Name</label>
            <input type="text" name="lname" value="<?php echo htmlspecialchars($user['LastName']); ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>

            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['Phone']); ?>">

            <label>Address</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($user['Address']); ?>">

            <button type="submit" class="btn primary">Update</button>

        </form>
    </section>

</main>

<?php require 'footer.php'; ?>