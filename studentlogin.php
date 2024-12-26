<?php
session_start();

$servername = "localhost";
$username = "yash";
$password = "yash";
$dbname = "Project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM register WHERE email='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            if ($row['status'] == 'approved') {
                $_SESSION['student_id'] = $row['student_id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['phone_number'] = $row['phone_number'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['address'] = $row['address'];
                $_SESSION['password'] = $row['password'];
                $_SESSION['profile_image'] = $row['profile_image'];
                $_SESSION['year_of_study'] = $row['year_of_study']; // Added this line
                header("Location: studentloginhomepage.html");
                exit();
            } else {
                $_SESSION['error'] = "Your account is not approved yet.";
            }
        } else {
            $_SESSION['error'] = "Invalid username or password.";
        }
    } else {
        $_SESSION['error'] = "Invalid username or password.";
    }
}

$conn->close();
header("Location: studentlogin.php"); 
exit();
?>
