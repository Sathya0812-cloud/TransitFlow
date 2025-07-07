<?php
// Database connection
$host = 'localhost';
$db   = 'transitflow';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

// Get POST data
$name     = $_POST['name'] ?? '';
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';

// Validate input
if (!$name || !$email || !$password || !$role) {
    echo "Please fill in all fields.";
    exit;
}

// Check for duplicate email
$stmt = $pdo->prepare("SELECT email FROM signup WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    echo "Email already registered.";
    exit;
}

// 🚫 No hashing, store raw password directly
$stmt = $pdo->prepare("INSERT INTO signup (name, email, password, role) VALUES (?, ?, ?, ?)");
$success = $stmt->execute([$name, $email, $password, $role]);

echo $success ? "Signup successful!" : "Signup failed. Try again.";
?>
