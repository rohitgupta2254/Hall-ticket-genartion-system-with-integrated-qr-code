<?php

$servername = "localhost";
$username = "yash"; 
$password = "yash"; 
$database = "Project"; 


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$stmt = $conn->prepare("INSERT INTO subjects (year, department, semester, subject_code, subject_name, date, start_time, end_time, day) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isissssss", $year, $department, $semester, $subject_code, $subject_name, $date, $start_time, $end_time, $day);


$year = $_POST['year1'];
$department = $_POST['department1'];
$semester = $_POST['semester1'];
$subject_codes = $_POST['subject_code'];
$subject_names = $_POST['subject_name'];
$dates = $_POST['date'];
$start_times = $_POST['start_time'];
$end_times = $_POST['end_time'];
$days = $_POST['day'];


for ($i = 0; $i < count($subject_codes); $i++) {
    $subject_code = $subject_codes[$i];
    $subject_name = $subject_names[$i];
    $date = $dates[$i];
    $start_time = $start_times[$i];
    $end_time = $end_times[$i];
    $day = $days[$i];

    
    $stmt->execute();
}

echo "Subjects added successfully.";


$stmt->close();
$conn->close();
?>
