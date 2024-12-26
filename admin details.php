<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin details.css">
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
            <a href="admin hallticket requests.php">Hall Ticket Approval</a>
            <span class="btn">
                <img src="3.jpeg/Screenshot_2024-03-05_at_7.47.56_PM-removebg-preview copy.png" alt="Logo" class="logo">
            </span>
        </div>
    </nav>


<div class="main-section">
    <h2 class="heading">Student Details</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Year of Study</th>
                    <th>Status</th>
                    <th>Profile Image</th>
                </tr>
            </thead>
            <tbody>
               
            <?php
            $servername = "localhost";
            $username = "yash";
            $password = "yash";
            $dbname = "Project";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM register WHERE status='approved'";
            $result = $conn->query($sql);

            if ($result) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["student_id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["phone_number"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["address"] . "</td>";
                        echo "<td>" . $row["year_of_study"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td><img src='3.jpeg/MODI YASH SAMIR .JPG' alt='Profile Image' style='width: 80px; height: 80px;'></td>"                        ;
                        echo "</tr>";
                        
                    }
                } else {
                    echo "<tr><td colspan='8'>No approved registrations</td></tr>";
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
            ?>

            </tbody>
        </table>
    </div>
</div>
</div>
<div class="footer">
        <div class="container">
            <p>Developed by: Yash Modi, Pratham Kotecha, Rohit Gupta, and Vansh Makwana under the Guidance of Prof. Pradnya Bhangle.</p>
        </div>
    </div>
</body>
</html>
