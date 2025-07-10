<?php
include '../dbconnect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$alertMessage = "";
$alerttype="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $pass = $_POST["password"];
  $user= $_POST["users"];
// Query to retrieve the hashed password for the entered username
$sql = "SELECT * FROM $user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
// Check if the user exists
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $hashedPassword = $row["password"];
  
  //echo $user;
  // Verify the password using password_verify
  if (password_verify($pass, $hashedPassword)) {
    $_SESSION["username"] = $username;
    $message= "Successful";
    if($user=="Employees"){
    $name = $row["name"];
    $store_name = $row["store_name"];
        header("Location: ../Billing.html?sname=" . urlencode($store_name));
    }else if($user=="Customers")
    //echo $username;
        header("Location: ../Customer_history.html?id=" . urlencode($username));
  } else {
    echo "Incorrect password.";
  }
} else {
  echo "User not found.";
}

$stmt->close();
}
$conn->close();
?>
