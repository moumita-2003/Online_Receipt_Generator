<?php
include 'dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the POST request
    $data = json_decode(file_get_contents('php://input'), true);

    // Get the billNo and totalAmount from the request
    $billNo = $data['billNo'];
    $totalAmount = $data['totalAmount'];
$bill_id =(int)( substr($billNo, 3) );  // Extract "67890" starting from position 9

// Insert or update the total amount for the bill
$sql = "UPDATE bills
SET  total_amount  = '$totalAmount'
WHERE bil_id =$bill_id";

mysqli_query($conn, $sql);

// Retrieve all products associated with the bill number
$sql = "SELECT id, name, price, gst, quantity, (price + (price * gst / 100)) * quantity AS total
        FROM $billNo WHERE bill_no = '$billNo'";
$result = mysqli_query($conn, $sql);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Return response
echo json_encode([
    "success" => true,
    "products" => $products
]);
}
?>
