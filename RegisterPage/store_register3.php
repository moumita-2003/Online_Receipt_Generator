<?php
include '../dbconnect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$alertMessage = "";
$alerttype="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $id = $_POST["emp-id"];
  $name = $_POST["emp-name"];
  $email = $_POST["emp-email"];
  $phone = $_POST["emp-phone"];
  $designation = $_POST["designation"];
  $store_name= $_POST["store-name"];
  $pass= password_hash($_POST["emp-email"], PASSWORD_DEFAULT);//by default password:emailid
  echo "Hello, " . $store_id;
  

$query = "SELECT * FROM Employees WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    // If ID already exists, set alert message to show error
    $alertMessage = "Error: Employee ID already exists. ID must be unique.";
    $alerttype="success";

    //header("Location: AddEmployee.html?id=" . urlencode($store_id));  
  } else {
    $sql = "INSERT INTO Employees (id, name,password,email,phone,designation,store_name) VALUES ('$id','$name','$pass','$email','$phone','$designation','$store_name')";
  if ($conn->query($sql) === TRUE) {
      $alertMessage = "Store Registered successfully!";
     
     
        header("Location: AddEmployee.html?sname=" . urlencode($store_name));  
      
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
  <h2>Employee ID already exists. ID must be unique.</h2>
  <h3>Go back and Try with different unique id.</h3>
  
    <a href="store_register2.php">go back</a>;
    <h3>If employee already registered click below link to go to login page.</h3> 
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
