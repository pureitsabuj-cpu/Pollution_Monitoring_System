<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup_data";

// DB connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get login info
$email = $_POST['email'];
$password = $_POST['password'];

// Check email exists
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Check password (hashed)
    if (password_verify($password, $row['password'])) {

        // Save session
        $_SESSION['user'] = $row['fullname'];

        echo "
            <script>
                alert('Login Successful!');
                window.location.href = 'Main_page.html';
            </script>
        ";

    } else {
        echo "
            <script>
                alert('Incorrect Password!');
                window.location.href = 'Log.html';
            </script>
        ";
    }
} else {
    echo "
        <script>
            alert('No account found, Please SignUP!');
            window.location.href = 'Log.html';
        </script>
    ";
}

$conn->close();
?>
