<?php

// Start the session and load the shared database connection.
session_start();

// This file defines $conn using mysqli to connect to MySQL.

require_once 'db.php';
require 'header.php';
// Skip the login screen if the user is already authenticated.
// Or redirect them straight to the home page.

if (isset($_SESSION['admin'])) {
    header('Location: admin-dashboard.php');
    exit;
}

// Initialize the default page state.
$error = '';
$username = '';

// Handle form submission and validate the supplied credentials.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read and normalize the submitted email value.
    $username = trim($_POST['username'] ?? '');

    // Read the submitted password exactly as entered.
    $password = $_POST['password'] ?? '';

    // Stop early if either required field was left blank.
    if ($username === '' || $password === '') {
        $error = 'Username and password are required.';
    } else {
        // Look up the admin instance by username and password.
        $statement = $conn->prepare(
            'SELECT AdminID FROM admins WHERE Username = ? AND PasswordHash = ? LIMIT 1'
        );

        // Abort if the database query could not be prepared.
        if (!$statement) {
            exit('Database statement preparation failed: ' . $conn->error);
        }

        $statement->bind_param('ss', $username, $password);

        // Run the account lookup query.
        if (!$statement->execute()) {
            exit('Database statement execution failed: ' . $statement->error);
        }

        $result = $statement->get_result();

        // Check if a row was returned.
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $result->free();
            $statement->close();

            // Persist the minimum user data needed by the dashboard.
            $_SESSION['admin'] = [
                'AdminID' => $user['AdminID'],
            ];
            // Send the authenticated user to the dashboard page.
            header('Location: admin-dashboard.php');
            exit;
        }

        // Show a generic error when the account is missing or the password does not match.
        $error = 'Invalid login credentials.';
    }
}
?>
<main class="container">
    <div>
        <h1>Login</h1>
        <p>Enter your account details.</p>

        <!-- Show validation or authentication errors above the form. -->
        <?php if ($error !== ''): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Post the submitted credentials back to this page for processing. -->
        <form method="post">
            <!-- Keep the username field filled after a failed login attempt. -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

            <!-- Ask for the password again on each submission attempt. -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <br><br>

            <!-- Submit the login form to start authentication. -->
            <button type="submit" class="btn">Login</button>
        </form>

        <!-- Display the demo credentials for quick testing. -->
        <p>Demo: admin1 / adminpass1</p>
    </div>
</main>

<?php require 'footer.php'; ?>