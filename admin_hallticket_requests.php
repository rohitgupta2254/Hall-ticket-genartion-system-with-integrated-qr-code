<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_interface.css">
    <title>Admin Interface</title>
</head>
<body>
<nav>
    <div class="container">
        <h1 class="title">Hall Ticket Generation System with Integrated QR Code</h1>
        <p class="tagline">KJ SOMAIYA INSTITUTE OF TECHNOLOGY</p>
        <a href="admin home page.html">Home</a>
        <a href="admin.php">Student Approval</a>
        <a href="admin details.php">Student Details</a>
        <a href="admin add subjects.html">Add Subjects</a>
        <a href="admin_hallticket_requests.php">Hall Ticket Approval</a>
        <a href="adminlogin2.html">Logout</a>
        <span class="btn">
            <img src="3.jpeg/Screenshot_2024-03-05_at_7.47.56_PM-removebg-preview copy.png" alt="Logo" class="logo">
        </span>
    </div>
</nav>

<div class="main-section">
    <h2 class="heading">Hall Ticket Requests</h2>
    <div class="table-container">
        <?php
        $servername = "localhost";
        $username = "yash";
        $password = "yash";
        $dbname = "Project";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_POST['approve'])) {
            $request_id = $_POST['request_id'];
            
            // Fetch the request details
            $fetch_sql = "SELECT * FROM hall_ticket_requests WHERE id = $request_id";
            $fetch_result = $conn->query($fetch_sql);
            
            if ($fetch_result->num_rows > 0) {
                $row = $fetch_result->fetch_assoc();
                // Generate seat number based on department, year, roll number, and student ID
                $seat_number = generateSeatNumber($row["department"], $row["year"], $row["roll_number"], $row["student_id"]);
                // Insert data into hall_tickets table
                $insert_sql = "INSERT INTO hall_tickets (student_id, year, department, semester, roll_number, seat_number, fee_status, receipt_number, status) VALUES ('".$row["student_id"]."', '".$row["year"]."', '".$row["department"]."', '".$row["semester"]."', '".$row["roll_number"]."', '$seat_number', '".$row["fee_status"]."', '".$row["receipt_number"]."', '".$row["status"]."')";
                
                if ($conn->query($insert_sql) === TRUE) {
                    // Delete record from hall_ticket_requests table
                    $delete_sql = "DELETE FROM hall_ticket_requests WHERE id = $request_id";
                    if ($conn->query($delete_sql) === TRUE) {
                        // Record deleted successfully
                        echo "<script>alert('Request approved successfully. Seat number generated and record moved to hall_tickets table.')</script>";
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                } else {
                    echo "Error inserting record: " . $conn->error;
                }
            }
        } elseif (isset($_POST['reject'])) {
            $request_id = $_POST['request_id'];
            // Delete record from hall_ticket_requests table
            $delete_sql = "DELETE FROM hall_ticket_requests WHERE id = $request_id";
            if ($conn->query($delete_sql) === TRUE) {
                // Record deleted successfully
                echo "<script>alert('Request rejected successfully.')</script>";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }

        // Function to generate a seat number based on department, year, roll number, and student ID
        function generateSeatNumber($department, $year, $roll_number, $student_id) {
            // You can use any logic to create a unique seat number based on the given parameters
            // For example, concatenating department abbreviation, year, roll number, and student ID
            // You may need to adjust this logic based on your specific requirements
            $seat_number = strtoupper(substr($department, 0, 3)) . $year . $roll_number . substr($student_id, -4);
            return $seat_number;
        }

        $sql = "SELECT * FROM hall_ticket_requests";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Student ID</th><th>Year</th><th>Department</th><th>Semester</th><th>Roll Number</th><th>Fee Status</th><th>Receipt Number</th><th>Status</th><th>Action</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["student_id"] . "</td>";
                echo "<td>" . $row["year"] . "</td>";
                echo "<td>" . $row["department"] . "</td>";
                echo "<td>" . $row["semester"] . "</td>";
                echo "<td>" . $row["roll_number"] . "</td>";
                echo "<td>" . $row["fee_status"] . "</td>";
                echo "<td>" . $row["receipt_number"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='request_id' value='" . $row["id"] . "'>";
                echo "<button type='submit' name='approve'>Approve</button>";
                echo "<button type='submit' name='reject'>Reject</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='info'>No hall ticket requests found.</p>";
        }

        $conn->close();
        ?>
    </div>
</div>
<div class="footer">
        <div class="container">
            <p>Developed by: Yash Modi, Pratham Kotecha, Rohit Gupta, and Vansh Makwana under the Guidance of Prof. Pradnya Bhangle.</p>
        </div>
    </div>
</body>
</html>
