<?php
function generateQRCode($data) {

    $pageUrl = 'http://yourdomain.com/hallticket.php';
    
    $qrData = urlencode($data);
    return "https://api.qrserver.com/v1/create-qr-code/?data=$qrData&size=200x200";
}


$servername = "localhost";
$username = "yash";
$password = "yash";
$dbname = "Project";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ht.student_id, ht.department, ht.seat_number, ht.semester, sb.subject_code, sb.subject_name, sb.start_time, sb.end_time,sb.day,sb.date, r.name, r.profile_image 
        FROM hall_tickets ht
        INNER JOIN subjects sb ON ht.department = sb.department AND ht.semester = sb.semester AND ht.year = sb.year
        INNER JOIN register r ON ht.student_id = r.student_id";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hall Ticket</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
   
    <style>
       * {
    margin:0px;
    padding:0px;
}
html, body {
    font-family: Roboto, sans-serif, arial;
    font-size: 14px;
    color: #242424;
    box-sizing: border-box;
    background-image: url(3.jpeg/back.jpg);
    background-size: cover; 
    background-position: center;
    background-repeat: no-repeat;
}
.tagline {
    font-size: 16px;
    color: white;
    margin-top: 5px;
}

.main-section 
{
    width: 100%;
    float: left;
    padding:50px 0px 40px 0px;
}
.heading {
    font-size: 22px;
    font-weight: 500;
    border-bottom: 1px solid #ff5722;
    margin-bottom:25px;
    color: #ff5722;
}
nav {
    background-color: #ff5722;
    color: #fff;
    padding: 10px 0;
    text-align: center;
    position: relative;
}

.logo {
    width: 100px;
    height: auto;
    position: absolute;
    left: 20px; 
    top: 50%;
    transform: translateY(-50%);
}

nav a {
    color: #fff;
    text-decoration: none;
    margin: 0 10px;
}

nav .btn {
    float: right;
}



.title {
    text-align: center;
    color: black;
}
.heading {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

        h1, h2, h3 {
            color: #ff5722;
            margin-bottom: 10px;
        }
        p {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        nav {
            background-color: #ff5722;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s;
        }
        nav a:hover {
            color: #fff;
            text-decoration: underline;
        }
        .logo {
            width: 100px;
            height: auto;
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
        }
        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 999;
        }
        .container1 {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            min-height: calc(100vh - 60px); 
        }
        .hall-ticket-details {
            display: flex;
            align-items: center; 
            margin-bottom: 30px; 
        }

        .profile-container {
    display: flex;
    align-items: center;
    margin-left:375px;
    margin-top: -10px; 
    margin-right: 80px; 
}

.profile-image {
    width: 125px;
    height: 150px;
    overflow: hidden;
    flex-shrink: 0;
    border-radius: 0; 
}

.profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}


        .hall-ticket-details .text-details {
            flex-grow: 1; 
        }
        .text-details p {
            margin-bottom: 8px; 
            margin-left: 40px;
        }
        .qr-code {
            position: absolute;
            left: 50%;
            transform: translateX(80%);
            top: 30px; 
            max-width: 200px;
            height: auto;
            margin-top: 30px;
        }

        .qr-code img {
            width: 100%;
            height: 150px;
        }

        .subjects {
            margin-top: 20px; 
        }

       
        #downloadBtn {
            background-color: #ff5722;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }
        #downloadBtn:hover {
            background-color: #ff8a65;
        }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <h1 class="title">Hall Ticket Generation System with Integrated QR Code</h1>
            <p class="tagline">KJ SOMAIYA INSTITUTE OF TECHNOLOGY</p>
            <a href="studentloginhomepage.html">Home</a>
            <a href="hallticketreq2.html">Hall Ticket Request</a>
            <a href="download_hallticket.php">Download Hall Ticket</a>
            <img src="3.jpeg/Screenshot_2024-03-05_at_7.47.56_PM-removebg-preview copy.png" alt="Logo" class="logo">
        </div>
    </nav>

    <main>
        <div class="container1">
            <h2 class="heading">Your Hall Ticket</h2>
            <?php if ($result->num_rows > 0): ?>
                <?php $row = $result->fetch_assoc(); ?>
                <?php
                    $qrData = implode('|', $row);
                    echo "<div class='qr-code'>";
                    $qrCodeUrl = generateQRCode($qrData);
                    echo "<img src='$qrCodeUrl' alt='QR Code'>";
                    echo "</div>";
                ?>
                <div class="hall-ticket-details">
                    <div class="profile-container">
                        <div class="profile-image">
                            <img src='3.jpeg/MODI YASH SAMIR .JPG' alt='Profile Image'>
                        </div>
                        <div class='text-details'>
                            <p><strong>Name:</strong> <?php echo $row['name']; ?></p>
                            <p><strong>Student ID:</strong> <?php echo $row['student_id']; ?></p>
                            <p><strong>Department:</strong> <?php echo $row['department']; ?></p>
                            <p><strong>Seat Number:</strong> <?php echo $row['seat_number']; ?></p>
                            <p><strong>Semester:</strong> <?php echo $row['semester']; ?></p>
                        </div>
                    </div>
                </div>
                <div class='subjects'>
                    <table>
                        <tr><th>Subject Code</th><th>Subject Name</th><th>Start Time</th><th>End Time</th><th>Date</th><th>Day</th></tr>
                        <?php do { ?>
                            <tr>
                                <td><?php echo $row['subject_code']; ?></td>
                                <td><?php echo $row['subject_name']; ?></td>
                                <td><?php echo $row['start_time']; ?></td>
                                <td><?php echo $row['end_time']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['day']; ?></td>
                            </tr>
                        <?php } while ($row = $result->fetch_assoc()); ?>
                    </table>
                </div>
            <?php else: ?>
                <p>No results found.</p>
            <?php endif; ?>
            
        </div>
    </main>

    <div class="footer">
        <div class="container">
            <p>Developed by: Yash Modi, Pratham Kotecha, Rohit Gupta, and Vansh Makwana under the Guidance of Prof. Pradnya Bhangle.</p>
        </div>
    </div>

    <script>
        document.getElementById('downloadBtn').addEventListener('click', function() {
            const hallTicket = document.querySelector('.container');
            const pdf = new jsPDF();
            pdf.html(hallTicket, {
                callback: function(pdf) {
                    pdf.save('hall_ticket.pdf');
                }
            });
        });
    </script>
</body>
</html>