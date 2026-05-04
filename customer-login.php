<?php

// Start the session and load the shared database connection.
session_start();

// This file defines $conn using mysqli to connect to MySQL.

require_once 'db.php';

// Skip the login screen if the user is already authenticated.
// Or redirect them straight to the home page.

if (isset($_SESSION['customer'])) {
    header('Location: customer-dashboard.php');
    exit;
}

// Initialize the default page state.
$error = '';
$email = '';
$password = '';

// Handle form submission and validate the supplied credentials.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read and normalize the submitted email value.
    $email = trim($_POST['email'] ?? '');

    // Read the submitted password exactly as entered.
    $password = $_POST['password'] ?? '';

    // Stop early if either required field was left blank.
    if ($email === '' || $password === '') {
        $error = 'Email and password are required.';
    } else {
        // Look up the customer instance by email and password.
        $statement = $conn->prepare(
            'SELECT CustomerID from customers WHERE Email = ? AND PasswordHash = ?'
        );
        $statement->bind_param('ss', $email, $password);

        // Abort if the database query could not be prepared.
        if (!$statement) {
            exit('Database statement preparation failed: ' . $conn->error);
        }

        // Run the account lookup query.
        if (!$statement->execute()) {
            exit('Database statement execution failed: ' . $statement->error);
        }

        // Check if a row was returned.
        if ($statement->affected_rows === 1) {
            // Read the first matching account, if one exists.
            $result = $statement->get_result();
            $user = $result->fetch_assoc();
            $result->free();
            $statement->close();

            // Persist the minimum user data needed by the dashboard.
            $_SESSION['customer'] = [
                'CustomerID' => $user['CustomerID'],
            ];

            // Send the authenticated user to the dashboard page.
            header('Location: customer-dashboard.php');
            exit;
        }

        // Show a generic error when the account is missing or the password does not match.
        $error = 'Invalid login credentials.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h1>Login</h1>
        <p>Enter your account details.</p>

        <!-- Show validation or authentication errors above the form. -->
        <?php if ($error !== ''): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Post the submitted credentials back to this page for processing. -->
        <form method="post">
            <!-- Keep the email field filled after a failed login attempt. -->
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <!-- Ask for the password again on each submission attempt. -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <!-- Submit the login form to start authentication. -->
            <button type="submit">Login</button>
        </form>

        <!-- Display the demo credentials for quick testing. -->
        <p>Demo: john@example.com / hashedpass1</p>
    </div>
</body>
</html>
