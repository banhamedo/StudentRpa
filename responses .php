<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "form_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the clear data request
if (isset($_POST['clear_data'])) {
    $sql = "DELETE FROM responses";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>All data has been cleared successfully.</p>";
    } else {
        echo "<p style='color: red;'>Error clearing data: " . $conn->error . "</p>";
    }
}

// Query to fetch all the responses from the database, sorted by the total in descending order
$sql = "SELECT id, name, email, Logic, machine_learning, smart_robot, hacking, monitoring_control, leadership, statistics, 
               (COALESCE(machine_learning, 0) + COALESCE(smart_robot, 0) + COALESCE(hacking, 0) + 
                COALESCE(monitoring_control, 0) + COALESCE(leadership, 0) + COALESCE(statistics, 0)) AS total 
        FROM responses 
        ORDER BY total DESC"; // Sort by total in descending order

$result = $conn->query($sql);

if ($result === false) {
    echo "Query failed: " . $conn->error;
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responses Table</title>
    <style>
        /* General Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-family: Arial, sans-serif;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        td {
            background-color: #fafafa;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        th {
            font-size: 14px;
        }
        .btn-download {
            display: block;
            text-align: center;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-download:hover {
            background-color: #218838;
        }
        .btn-clear {
            display: block;
            text-align: center;
            padding: 10px;
            background-color: #dc3545;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-clear:hover {
            background-color: #c82333;
        }
        /* Make the Table Responsive */
        @media screen and (max-width: 768px) {
            table {
                width: 100%;
            }

            th, td {
                font-size: 12px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<h1>The data are entered</h1>
<?php
// Check if there are any records
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Logic</th>
            <th>Machine Learning</th>
            <th>Smart Robot</th>
            <th>Hacking</th>
            <th>Monitoring and Control</th>
            <th>Leadership</th>
            <th>Statistics</th>
            <th>Total</th> <!-- New column for the total -->
          </tr>";

    // Fetch each row and display it
    while ($row = $result->fetch_assoc()) {
        // Handle empty values (e.g., null values)
        $machine_learning = !empty($row['machine_learning']) ? $row['machine_learning'] : 0;
        $Logic = !empty($row['Logic']) ? $row['Logic'] : 0;
        $smart_robot = !empty($row['smart_robot']) ? $row['smart_robot'] : 0;
        $hacking = !empty($row['hacking']) ? $row['hacking'] : 0;
        $monitoring_control = !empty($row['monitoring_control']) ? $row['monitoring_control'] : 0;
        $leadership = !empty($row['leadership']) ? $row['leadership'] : 0;
        $statistics = !empty($row['statistics']) ? $row['statistics'] : 0;

        // Calculate the total for the row (already calculated in SQL query)
        $total = $row['total'];

        // Display each row in the table
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['Logic'] . "</td>
                <td>" . $machine_learning . "</td>
                <td>" . $smart_robot . "</td>
                <td>" . $hacking . "</td>
                <td>" . $monitoring_control . "</td>
                <td>" . $leadership . "</td>
                <td>" . $statistics . "</td>
                <td>" . $total . "</td> <!-- Display the total -->
              </tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}

// Close the database connection
$conn->close();
?>
<a href="form.html" class="btn-download">Main page</a>

<!-- Form to clear data -->
<form method="POST" action="" onsubmit="return confirm('Are you sure you want to clear all data? This action cannot be undone.');">
    <button type="submit" name="clear_data" class="btn-clear">Clear All Data</button>
</form>
</body>
</html>