<?php
$servername = "localhost";
$username = "yash";
$password = "yash";
$dbname = "Project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $year_of_study = $_POST['year_of_study'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Error: Passwords do not match";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["profile_image"]["name"]);
    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
        echo "The file ". basename( $_FILES["profile_image"]["name"]). " has been uploaded.";
    } else {
        echo "CONGRATS:";
    }

    $stmt = $conn->prepare("INSERT INTO register (student_id, name, phone_number, email, address, year_of_study, password, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $student_id, $name, $phone_number, $email, $address, $year_of_study, $hashed_password, $targetFile);

    if ($stmt->execute() === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
