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

// Get login input
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Static admin login check
$adminEmail = "admin@transitflow.com";
$adminPass  = "admin123";

if ($email === $adminEmail && $password === $adminPass) {
    echo "admin";
    exit;
}

// Check user in signup table
$stmt = $pdo->prepare("SELECT name, email, password, role FROM signup WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Compare plain passwords
if ($user && $password === $user['password']) {
    echo strtolower($user['role']); // output: "operator" or "driver"
} else {
    echo "Invalid email or password.";
}
?>
