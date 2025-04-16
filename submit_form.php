<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data and sanitize inputs
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $Logic = !empty($_POST['Logic']) ? htmlspecialchars($_POST['Logic']) : NULL;
    $machine_learning = !empty($_POST['machine_learning']) ? htmlspecialchars($_POST['machine_learning']) : NULL;
    $smart_robot = !empty($_POST['smart_robot']) ? htmlspecialchars($_POST['smart_robot']) : NULL;
    $hacking = !empty($_POST['hacking']) ? htmlspecialchars($_POST['hacking']) : NULL;
    $monitoring_control = !empty($_POST['monitoring_control']) ? htmlspecialchars($_POST['monitoring_control']) : NULL;
    $leadership = !empty($_POST['leadership']) ? htmlspecialchars($_POST['leadership']) : NULL;
    $statistics = !empty($_POST['statistics']) ? htmlspecialchars($_POST['statistics']) : NULL;

    // Database connection
    $conn = new mysqli("localhost", "root", "", "form_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the responses table
    $sql = "INSERT INTO responses (name, email, Logic, machine_learning, smart_robot, hacking, monitoring_control, leadership, statistics) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
// Output SQL error if prepare() fails
die("Error preparing the query: " . $conn->error);
}

$stmt->bind_param("sssssssss", $name, $email, $Logic, $machine_learning, $smart_robot, $hacking, $monitoring_control, $leadership, $statistics);
    if ($stmt->execute()) {
        $last_id = $conn->insert_id; // Get the ID of the inserted record

        // Check if degrees data exists and insert them
        if (!empty($_POST['degrees'])) {
            $degrees = $_POST['degrees']; // Assuming it's an array of degrees submitted via the form
            $degree_sql = "INSERT INTO degrees (response_id, degree) VALUES (?, ?)";
            $degree_stmt = $conn->prepare($degree_sql);

            foreach ($degrees as $degree) {
                $degree = htmlspecialchars($degree); // Sanitize degree input
                $degree_stmt->bind_param("is", $last_id, $degree);
                $degree_stmt->execute();
            }
        }

        // Show success message and redirect to the homepage
        echo "<script>
                window.location.href = 'form.html'; // Redirect to the home page
              </script>";
    } else {
        // Show error message and redirect to homepage
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href = 'form.html'; // Redirect to the home page
              </script>";
    }

    // Close the prepared statements and connection
    $stmt->close();
    if (isset($degree_stmt)) {
        $degree_stmt->close();
    }
    $conn->close();
}
?>
