<?php
include 'dbconnect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$alertMessage = "";
$alerttype="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $store_name = $_POST["store-name"];
  $customer_name = $_POST["customer-name"];
  $customer_email = $_POST["customer-email"];
  $date_time = $_POST["datetimeField"];
  $sql = "INSERT INTO bills (customer,customer_email,store,date_time) VALUES ( '$customer_name','$customer_email','$store_name','$date_time')";
  if ($conn->query($sql) === TRUE) {
    $alertMessage = "customer Registered successfully!";
    $last_id = "ODR".$conn->insert_id;
    $query2 = "create table $last_id (pid int auto_increment primary key,p_name varchar(20), price varchar(50),gst varchar(50),quantity varchar(20) )";
    if ($conn->query($query2) === TRUE) {
      //echo $store_name;
       //echo "Add Employees details";    
       header("Location: AddProduct.html?sname=". urlencode($store_name) . "&id=" . urlencode($last_id));
       exit();}
}  else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
$conn->close();
?>

