<?php
// Connect to the database
include 'dbconnect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$data = json_decode(file_get_contents("php://input"), true);

$billNo = $data['billNo'];
$bill_id = (int)(substr($billNo, 3));
$productName = $data['productName'];
$productPrice = $data['productPrice'];
$productGST = $data['productGST'];
$productQuantity = $data['productQuantity'];

$sql ="INSERT INTO $billNo (p_name, price ,gst ,quantity)  VALUES ('$productName', $productPrice, $productGST, $productQuantity)";
if (mysqli_query($conn, $sql)) {
  $productId =$conn->insert_id;
  echo json_encode([
    'id' => $productId,
    'product_name' => $productName,
    'product_price' => $productPrice,
    'product_gst' => $productGST,
    'product_quantity' => $productQuantity
  ]);
  $productTotal = $productPrice * $productQuantity * (1 + $productGST / 100);

        // Update the total amount in the bills table
        $updateTotalQuery = "UPDATE bills SET total_amount = total_amount + ? WHERE bil_id = ?";
        $updateStmt = $conn->prepare($updateTotalQuery);
        $updateStmt->bind_param("ds", $productTotal, $bill_id);

        if ($updateStmt->execute()) {
            http_response_code(200);
           // echo json_encode(['message' => 'Product added and total updated.']);
        } else {
            http_response_code(500);
            //echo json_encode(['message' => 'Failed to update total amount.']);
        }
    

} else {
    //echo json_encode(['message' => 'Failed to insert product.']);
  http_response_code(500);
}
?>
