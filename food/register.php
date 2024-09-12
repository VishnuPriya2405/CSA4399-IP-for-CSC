<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food";

// Create a connection to the database
$conn = new mysqli($name, $email, $password,$confirmPassword, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $confirmPassword = sanitizeInput($_POST['confirmPassword']);

    // Check if the passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Prepare SQL query to insert only the entered password
        $sql = "INSERT INTO register (name, email, password,confirmPassword) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Prepare() failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("sss", $name, $email, $hashedPassword,$confirmPassword);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "<script>alert('Successfully registered!'); 
            window.location.href = 'login.html';</script>";
        } else {
            echo "Error executing query: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    }
}

$conn->close();
?>
