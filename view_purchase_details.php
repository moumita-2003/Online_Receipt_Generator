<?php
// Database connection details

include 'dbconnect.php';

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the purchase ID from the URL
$purchaseId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$billId="odr".$purchaseId;
echo "Bill No: ".$billId;
// Fetch purchase details from the database
$sql = "SELECT pid, p_name, price, gst,quantity FROM $billId ";
$stmt = $conn->prepare($sql);
//$stmt->bind_param("i", $purchaseId);
$stmt->execute();
$result = $stmt->get_result();
//$purchase = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Details</title>
    <link rel="stylesheet" href="styles/history.css">
    <script>
   
    // Get the 'data' parameter from the URL
    const urlParams = new URLSearchParams(window.location.search);
    //const username = urlParams.get('username');
    const value = urlParams.get('total');
    window.onload = function() {
        console.log(value);
            const inputField2 = document.getElementById("totalamt");
            
            // Step 4: Set the input field's value to the constant value
            inputField2.value =value;
            
        };
        //window.onload = 
 
</script>
</head>
<body>

    <div class="details">
    
<?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Product Id</th>
                    <th>Product name</th>
                    <th>price</th>
                    <th>GST(%)</th>
                    <th>Quantity</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                // Display each row of the result set\
               
                while ($row = $result->fetch_assoc()):
                ?>
                
                    <tr>
                    <td><?php echo $row["pid"]; ?></td>
                        <td><?php echo htmlspecialchars($row["p_name"]); ?></td>
                        <td><?php echo number_format($row["price"], 2); ?></td>
                        <td><?php echo $row["gst"]; ?></td>
                        <td><?php echo $row["quantity"]; ?></td>
                        
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No purchases found.</p>
    <?php endif; ?>
    <br>
    <br>
    <div class="input-group">
            <label for="totalamt">Total Amount:</label>
            <input type="text" id="totalamt" name="totalamt" placeholder="Autofilled" readonly>
        </div>
    </div>
   
    

</body>
</html>

