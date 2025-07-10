<?php
include 'dbconnect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$alertMessage = "";
$alerttype="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bill = $_POST["bill-no"];
  $product_name = $_POST["product-name"];
  $price = $_POST["product-price"];
  $gst = $_POST["product-gst"];
  $quantity = $_POST["product-quantity"];
  $sql = "INSERT INTO $bill(p_name, price ,gst ,quantity) VALUES ( '$product_name','$price','$gst','$quantity')";
  if ($conn->query($sql) === TRUE) {
    header("Location: AddProduct.html?id=" . urlencode($bill));
    //header("Location:AddProduct.html" . urlencode($store_id));  
    
}  else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Information Management</title>
</head>
<body>

  <script src="script.js"></script>
</body>
</html>

