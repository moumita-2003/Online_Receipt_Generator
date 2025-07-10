<?php
$servername = "localhost";
$username = "root";
$password = "root123";
//$dbname = "online_receipt";
//$dbname = "ebilling";
$dbname = "digital_billing";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
