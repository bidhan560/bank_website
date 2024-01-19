<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CSD223_bidhan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$username = $password = $confirmPassword = $email = "";
$usernameErr = $passwordErr = $confirmPasswordErr = $emailErr = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate and sanitize user input
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    if (empty($_POST["confirmPassword"])) {
        $confirmPasswordErr = "Confirm Password is required";
    } else {
        $confirmPassword = test_input($_POST["confirmPassword"]);
        if ($confirmPassword !== $password) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if the email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Insert data into the "users" table if there are no validation errors
    if (empty($usernameErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($emailErr)) {
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "Signup successful!";
        } else {
            echo "Error: Unable to signup. Please try again later.";
            // Log the detailed error 
            error_log("Error: " . $conn->error);
        }
    }
}

$conn->close();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE HTML>  
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Signup Page</title>
    <link rel="stylesheet" type="text/css" href="signup.css">
</head>
<body>  

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  
        <h2>Signup Form</h2>
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo isset($username) ? $username : ''; ?>">
        <span class="error"><?php echo isset($usernameErr) ? $usernameErr : ''; ?></span>

        <label for="password">Password:</label>
        <input type="password" name="password">
        <span class="error"><?php echo isset($passwordErr) ? $passwordErr : ''; ?></span>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword">
        <span class="error"><?php echo isset($confirmPasswordErr) ? $confirmPasswordErr : ''; ?></span>

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
        <span class="error"><?php echo isset($emailErr) ? $emailErr : ''; ?></span>

        <input type="submit" name="submit" value="Signup">  
    </form>

</body>
</html>
