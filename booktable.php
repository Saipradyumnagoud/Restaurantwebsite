<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background-color: #f4f4f4; */
            background-image: url(home.png);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .booking-details {
            margin-top: 20px;
        }
        .booking-details p {
            margin: 10px 0;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Booking Details</h1>
        <div class="booking-details">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Establish database connection
                $conn = new mysqli("127.0.0.1", "root", "", "restaurantdetails");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $name = $_POST['name'];
                $phone = $_POST['phone'];

                // Check if user can book a table
                $sixHoursAgo = date('Y-m-d H:i:s', strtotime('-6 hours'));
                $sql = "SELECT * FROM bookings WHERE phone = ? AND booking_time > ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $phone, $sixHoursAgo);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "You have already booked a table within the last 6 hours.";
                } else {
                    // Assign table number
                    $tableNumber = assignTableNumber();

                    // Insert booking into the database
                    $sql = "INSERT INTO bookings (name, phone, table_number) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssi", $name, $phone, $tableNumber);
                    if ($stmt->execute()) {
                        echo "<p><strong>Name:</strong> $name</p>";
                        echo "<p><strong>Phone Number:</strong> $phone</p>";
                        echo "<p><strong>Table Number:</strong> $tableNumber</p>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                $conn->close();
            }
            ?>
        </div>
        <div class="back-link">
            <a href="index.html">Back to Home</a>
        </div>
    </div>
</body>
</html>

<?php
// Function to assign a random table number
function assignTableNumber() {
    return rand(1, 30);
}
?>