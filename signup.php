<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // change if needed
$password = "";     // change if you have a DB password
$dbname = "transitflow"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get data from frontend (JS fetch will send these via POST)
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Hash password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert into signup table
$sql = "INSERT INTO signup (name, email, password, role) 
        VALUES ('$name', '$email', '$hashedPassword', '$role')";

if ($conn->query($sql) === TRUE) {
  echo "Signup successful!";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
?>
