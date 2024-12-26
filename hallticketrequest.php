<?php
session_start();

$servername = "localhost";
$username = "yash";
$password = "yash";
$database = "Project";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_SESSION['email'];
    $password = $_SESSION['password'];

    $sql = "SELECT * FROM register WHERE email=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $studentId = $row['student_id'];
        $year = $row['year_of_study'];

        $stmt2 = $conn->prepare("INSERT INTO hall_ticket_requests (student_id, year, department, semester, roll_number, fee_status, receipt_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("isssiss", $studentId, $year, $department, $semester, $rollNumber, $feeStatus, $receiptNumber);

        $department = $_POST["department"];
        $semester = $_POST["semester"];
        $rollNumber = $_POST["rollNumber"];
        $feeStatus = isset($_POST["feeStatus"]) ? $_POST["feeStatus"] : "";
        $receiptNumber = isset($_POST["receiptNumber"]) ? $_POST["receiptNumber"] : "";

        if ($stmt2->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt2->error;
        }

        $stmt2->close();
    } else {
        echo "Error: Invalid username or password";
    }
}

$stmt->close();
$conn->close();
?>
