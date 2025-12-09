<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "Pollution_monitoring";

// Create DB connection
$conn = new mysqli($host, $user, $password, $database);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = isset($_POST['name']) ? $_POST['name'] : "";
    $number = isset($_POST['number']) ? $_POST['number'] : "";
    $address = isset($_POST['address']) ? $_POST['address'] : "";
    $comment = isset($_POST['comment']) ? $_POST['comment'] : "";

    // File upload handling
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {

        $photoName = $_FILES['photo']['name'];
        $photoTmp = $_FILES['photo']['tmp_name'];

        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uniqueName = time() . "_" . basename($photoName);
        $uploadPath = $uploadDir . $uniqueName;

        if (move_uploaded_file($photoTmp, $uploadPath)) {
            $photoStored = $uploadPath;
        } else {
            die("Failed to upload image.");
        }

    } else {
        die("No image uploaded or upload error.");
    }

    // Insert into database
    $sql = "INSERT INTO form_entries (name, number, photo, address, comment)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $number, $photoStored, $address, $comment);

    if ($stmt->execute()) {
        echo "<h2>Form submitted successfully!</h2>";
        echo '<br>';
        echo '<a href="Main_page.html" 
                style="
                    padding: 10px 20px; 
                    background: #007bff; 
                    color: white; 
                    text-decoration: none; 
                    border-radius: 5px;
                    font-size: 16px;">
                Go to Main Page
              </a>';
    } else {
        echo "Database Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
