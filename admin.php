
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
        <h2 class="heading">Admin Interface</h2>
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
                        <th>Action</th>
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

                    $sql = "SELECT * FROM register WHERE status='pending'";
                    $result = $conn->query($sql);

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
                            echo "<td><img src='3.jpeg/MODI YASH SAMIR .JPG' alt='Profile Image' style='width: 70px; height: 60px;'></td>";
                            echo "<td>
                                    <form action='approve.php' method='post'>
                                        <input type='hidden' name='student_id' value='" . $row["student_id"] . "'>
                                        <button type='submit' class='approve-btn' name='approve'>Approve</button>
                                    </form>
                                    <form action='reject.php' method='post'>
                                        <input type='hidden' name='student_id' value='" . $row["student_id"] . "'>
                                        <button type='submit' class='reject-btn' name='reject'>Reject</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No pending registrations</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>Developed by: Yash Modi, Pratham Kotecha, Rohit Gupta, and Vansh Makwana under the Guidance of Prof. Pradnya Bhangle.</p>
        </div>
    </div>
</body>
</html>
