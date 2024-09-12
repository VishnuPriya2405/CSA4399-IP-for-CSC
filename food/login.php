<?php
// Start the session
session_start();

// Database connection settings
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$confirmPassword="password";
$dbname = "food"; // Replace with your database name

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
    // Get and sanitize form inputs
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    // Prepare the SQL query to select user data
    $sql = "SELECT * FROM register WHERE email = $email"; // Ensure the column name matches your database
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);

        // Execute the statement
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['Password'])) {
                // Password is correct, start a session
                $_SESSION['user_id'] = $user['ID']; // Store user ID in session
                $_SESSION['user_name'] = $user['Name']; // Store user name in session

                // Redirect to home page
                header("Location: home.html");
                exit();
            } else {
                // Invalid password
                $error = "Invalid email or password.";
            }
        } else {
            // User not found
            $error = "Invalid email or password.";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error preparing the statement
        $error = "Error preparing statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url('login.png') no-repeat center center fixed; /* Replace with your image path */
            background-size: contain; /* Cover the entire viewport */
            font-family: 'Times New Roman', serif;
        }

        .container {
            text-align: center;
            border: 2px solid #007bff; /* Blue border */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white for readability */
            max-width: 400px;
            width: 100%;
        }

        .container h2 {
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box; /* Ensure padding and border are included in the element's total width and height */
        }

        .button {
            width: 100%;
            padding: 12px;
            background-color: #007bff; /* Blue background */
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .container p {
            margin-top: 15px;
            font-size: 14px;
        }

        .container a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .container a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            display: block;
            margin-top: 10px;
            font-size: 14px;
        }

        .error {
            color: #ff6347; /* Red color for error messages */
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email ID" id="loginEmail" required><br>
            <div class="error"><?php echo isset($error) ? $error : ''; ?></div>
            <input type="password" name="password" placeholder="Password" id="loginPassword" required><br>
            <button class="button" type="submit">Login</button>
            <a href="forgotpassword.html" class="forgot-password">Forgot Password?</a>
        </form>
        <p>Don't have an account? <a href="register.html">Register</a></p>
    </div>
</body>
</html>
