<?php

$servername = "localhost";
$username = "root";    // XAMPP/WAMP default
$password = "";        // XAMPP/WAMP default
$dbname = "signup_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Getting form data
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$region = $_POST['Region'];
$region_code = $_POST['Code'];
$password = $_POST['password'];

// Encrypt password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert query
$sql = "INSERT INTO users (`fullname`, `email`, `region`, `region_code`, `password`)
        VALUES ('$fullname', '$email', '$region', '$region_code', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "
        <script>
            alert('Account created successfully!');
            window.location.href = 'Main_page.html';
        </script>
    ";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
