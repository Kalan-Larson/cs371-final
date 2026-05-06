<?php
require 'header.php';
require 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $rating = $_POST['rating'] ?? null;
    $comment = $_POST['comment'] ?? '';

    if ($name !== '' && $comment !== '') {
        $stmt = $conn->prepare(
            "INSERT INTO feedback (CustomerID, Name, Email, Rating, Comment) VALUES (NULL, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssis", $name, $email, $rating, $comment);
        $stmt->execute();
    }
}

// Get all feedback
$sql = "SELECT * FROM feedback ORDER BY FeedbackID DESC";
$result = $conn->query($sql);
?>

<main class="container">

    <h1><strong>Customer Feedback</strong></h1>

    <!-- FORM -->
    <section class="feedback-form">
        <h2><strong>Leave Feedback</strong></h2>

        <form method="post">
            <label>Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email">

            <label>Rating (1–5)</label>
            <input type="number" name="rating" min="1" max="5">

            <label>Comment</label>
            <textarea name="comment" rows="4" required></textarea>

            <button type="submit" class="btn primary">Submit</button>
        </form>
    </section>

    <hr>

    <!-- DISPLAY FEEDBACK -->
    <section class="feedback-list">
        <h2><strong>What Our Customers Say</strong></h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="feedback-card">
                    <p><strong><?php echo htmlspecialchars($row['Name']); ?></strong></p>

                    <?php if (!empty($row['Rating'])): ?>
                        <p>Rating: <?php echo htmlspecialchars($row['Rating']); ?>/5</p>
                    <?php endif; ?>

                    <p><?php echo htmlspecialchars($row['Comment']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No feedback yet.</p>
        <?php endif; ?>
    </section>

</main>

<?php require 'footer.php'; ?>