<?php
include("db.php");
require 'header.php';
?>

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
<?php require 'footer.php'; ?>
