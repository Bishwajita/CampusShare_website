
<?php

echo "<pre>";
print_r($_SERVER);
print_r($_POST);
echo "</pre>";
exit;

var_dump($_POST);

// Only run this code if form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form (with fallback to avoid warnings)
    $username = $_POST["username"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Invalid email format.";
        exit;
    }

    // Confirm passwords match
    if ($password !== $confirm_password) {
        echo "❌ Passwords do not match.";
        exit;
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Connect to MySQL
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";  // Replace with your MySQL password if set
    $dbname = "campus_data";  // Replace with your actual DB name

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO user (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password_hash);

    // Execute and check
    if ($stmt->execute()) {
        echo "✅ Registration successful!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "❌ Invalid request.";
}
?>
