<?php
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>

    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Services</h1>

<?php
$sql = "SELECT * FROM services";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo "<table>";
    echo "<tr>
            <th>Name</th>
            <th>Description</th>
            <th>Base Price</th>
            <th>Base Duration</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["Name"]."</td>
                <td>".$row["Description"]."</td>
                <td>".$row["BasePrice"]."</td>
                <td>".$row["BaseDuration"]."</td>
              </tr>";
    }

    echo "</table><br><br>";

} else {
    echo "<p>No results found</p>";
}
?>

</body>
</html>
