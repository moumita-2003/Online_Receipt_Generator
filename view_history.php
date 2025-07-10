<?php


include 'dbconnect.php';

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $user = $_POST["username"];
    //echo $_POST["username"];
// Fetch the purchase history from the database
$sql = "SELECT bil_id, store,date_time, total_amount FROM bills where customer_email='$user' ORDER BY date_time DESC";
$result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <link rel="stylesheet" href="styles/history.css">
    
</head>
<body>

    <h1>Purchase History</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Bill no</th>
                    <th>Store</th>
                    <th>Total Amount</th>
                    <th>Purchase Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display each row of the result set
                while ($row = $result->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $row["bil_id"]; ?></td>
                        <td><?php echo htmlspecialchars($row["store"]); ?></td>
                        <td><?php echo number_format($row["total_amount"], 2); ?></td>
                        <td><?php echo date("Y-m-d H:i", strtotime($row["date_time"])); ?></td>
                        <td>
                            <a href="view_purchase_details.php?id=<?php echo $row['bil_id']; ?>&total=<?php echo number_format($row["total_amount"], 2); ?>" class="view-button">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No purchases found.</p>
    <?php endif; ?>

    <?php
    // Close the database connection
    $conn->close();
    ?>

</body>
</html>
