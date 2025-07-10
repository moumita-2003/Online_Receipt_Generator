<?php
include 'dbconnect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $store_name = $_POST["store-name"];
  //echo $store_name;
  header("Location: Billing.html?sname=" . urlencode($store_name));
  //header("Location: AddProduct.html?id=&?sname=" . urlencode($last_id,$store_name));
}
$conn->close();
?>

