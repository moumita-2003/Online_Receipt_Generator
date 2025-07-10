<?php

include 'dbconnect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo 'Hello';
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    //parse_str(file_get_contents("php://input"), $params);
    $billNo = $_GET['billNo'];
    $productId = $_GET['id'];
    $bill_id = (int)(substr($billNo, 3));
    //echo $productId;
    $query = "SELECT price, gst, quantity FROM $billNo WHERE pid = $productId";
    $result2 = $conn->query($query);

// Check if rows were returned
if ($result2->num_rows > 0) {
    // Fetch each row as an associative array
    while ($row = $result2->fetch_assoc()) {
        $productTotal=  $row["price"] * $row["quantity"] *(1 + $row["gst"] / 100);
    }
} 
    //$productTotal = $productPrice * $productQuantity * (1 + $productGST / 100);
    //echo $productTotal;
    // Delete product from the database
    $sql = "DELETE FROM $billNo WHERE pid = $productId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $updateTotalQuery = "UPDATE bills SET total_amount = total_amount - $productTotal WHERE bil_id = $bill_id";
        if( mysqli_query($conn, $updateTotalQuery )){
            echo "Product removed and total updated.";
        } else {
            echo "Failed to update total amount.";
        }
        //http_response_code(200);
    } else {
        echo "Failed to remove product.";
        //http_response_code(500);
    }
    $conn->close();
}
?>

