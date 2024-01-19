<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CSD223_bidhan";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user inputs
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Query to check if the entered credentials exist in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a matching record is found, redirect to another page
    if ($result->num_rows > 0) {
        header("Location: account_details.php");
        exit();
    } else {
        echo '<p style="color: red;">Invalid credentials. Please try again.</p>';
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bank of Shrestha</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>

    <div class="login-container">
        <h1>Login to Your Account</h1>
        <form action="" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="loginButton">LogIn</button>
        </form>
        <p class="signup-link">Don't have an account? <a href="signup_page.php">Sign up</a></p>
    </div>

</body>

</html>
