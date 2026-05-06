<?php
require_once 'db.php';
require 'header.php';

if (isset($_SESSION['customer'])) {
    header('Location: customer-dashboard.php');
    exit;
}

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Process the registration data (e.g., save to database)
    $sql = "INSERT INTO customers(FirstName, LastName, Email, PasswordHash, Phone, Address) 
            VALUES ('$fname','$lname','$email','$password','$phone','$address')";
    if ($conn->query($sql) === TRUE) {
        header('Location: customer-login.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<main class="container">
    <div>
        <h1>Register</h1>
        <p>Create a new account.</p>

        <form method="post">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" required>

            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" required>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>

            <button type="submit" name="register">Register</button>
        </form>

        <!-- Display a link to the login page for existing users. -->
        <p><a href="customer-login.php">Already have an account? Login here.</a></p>
    </div>
</main>
<?php require 'footer.php'; ?>