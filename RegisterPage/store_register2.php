<?php
include '../dbconnect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$alertMessage = "";
$alerttype="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $name = $_POST["store-name"];
  $address = $_POST["store-address"];
  $query = "SELECT * FROM stores WHERE name = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $name);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    // If ID already exists, set alert message to show error
    $alertMessage = "Error: store name already exists. store name must be unique.";
    $alerttype="error";
  } else {
    $sql = "INSERT INTO stores (name,address) VALUES ('$name','$address')";
    
    if ($conn->query($sql) === TRUE) {
        $alertMessage = "Store Registered successfully!";
        $store_id = "store_".$conn->insert_id;
       
           echo "Add Employees details"; 
           $alerttype="success";
           header("Location: AddEmployee.html?sname=" . urlencode($name));  
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
     
  }

}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
</head>
<body>
  <h2>Store Name already exists. Name must be unique.</h2>
  <h3>Go back and Try with different unique name.</h3>
  
    <a href="store_register.html">go back</a>;
    <h3>If company already registered click below link to go to login page.</h3> 
    <a href="../index.html">Login Page</a>;
  <?php
  // Check if there is an alert message to display
  if ($alertMessage != "" && $alerttype=="error") {
    // Embed JavaScript alert in the HTML with the PHP message
    echo "<script type='text/javascript'>alert('$alertMessage');</script>";
   
    }
  else if ($alertMessage != "" && $alerttype=="success") {
    echo "<script type='text/javascript'>alert('$alertMessage');</script>";
    header("Location: AddEmployee.html?sname=" . urlencode($name));
   //   header("Location: AddEmployee.html"); // Redirect to Page 2 after setting the session variable
     
  
  }
  ?>
</body>
</html>
