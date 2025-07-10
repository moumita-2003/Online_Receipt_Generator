<?php
include '../dbconnect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$alertMessage = "";
$alerttype="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $name = $_POST["name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

$query = "SELECT * FROM customers WHERE email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    // If ID already exists, set alert message to show error
    $alertMessage = " Email address already exists. Email must be unique.";
    $alerttype="success";

    //header("Location: AddEmployee.html?id=" . urlencode($store_id));  
  } else {
    $sql = "INSERT INTO Customers ( name,password,email,phone) VALUES ('$name','$pass','$email','$phone')";
  if ($conn->query($sql) === TRUE) {
      $alertMessage = "customer Registered successfully!";
     
     
        header("Location: ../index.html" . urlencode($store_id));  
      
  }  else {
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
  <h2>Email-ID already exists. Email must be unique.</h2>
  <h3>Go back and Try with different unique name.</h3>
  
    <a href="Customer_register.html">go back</a>;
    <h3>If user already registered click below link to go to login page.</h3> 
    <a href="../index.html">Login Page</a>;
  <?php
  // Check if there is an alert message to display
  if ($alertMessage != "" && $alerttype=="success") {
    // Embed JavaScript alert in the HTML with the PHP message
    echo "<script type='text/javascript'>alert('$alertMessage');</script>";
    //header("Location: AddEmployee.html?id=" . urlencode($store_id));  
    }
  
  ?>
</body>
</html>
