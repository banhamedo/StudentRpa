<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Database connection
$conn = new mysqli("localhost", "root", "", "form_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT r.id, r.nname, r.email, r.Logic, 
            MAX(CASE WHEN d.subject = 'Machine Learning' THEN d.degree ELSE NULL END) AS machine_learning,
            MAX(CASE WHEN d.subject = 'Smart Robot' THEN d.degree ELSE NULL END) AS smart_robot,
            MAX(CASE WHEN d.subject = 'Hacking' THEN d.degree ELSE NULL END) AS hacking,
            MAX(CASE WHEN d.subject = 'Monitoring and Control' THEN d.degree ELSE NULL END) AS monitoring_control,
            MAX(CASE WHEN d.subject = 'Leadership' THEN d.degree ELSE NULL END) AS leadership,
            MAX(CASE WHEN d.subject = 'Statistics' THEN d.degree ELSE NULL END) AS statistics
        FROM responses r
        LEFT JOIN degrees d ON r.id = d.response_id
        GROUP BY r.id";

$result = $conn->query($sql);

// Initialize Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers
$sheet->setCellValue('A1', 'nname');
$sheet->setCellValue('B1', 'Email');
$sheet->setCellValue('C1', 'Logic');
$sheet->setCellValue('D1', 'Machine Learning');
$sheet->setCellValue('E1', 'Smart Robot');
$sheet->setCellValue('F1', 'Hacking');
$sheet->setCellValue('G1', 'Monitoring and Control');
$sheet->setCellValue('H1', 'Leadership');
$sheet->setCellValue('I1', 'Statistics');

// Populate data
$row = 2; // Start from the second row
if ($result->num_rows > 0) {
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['nname']);
        $sheet->setCellValue('B' . $row, $data['email']);
        $sheet->setCellValue('C' . $row, $data['Logic']);
        $sheet->setCellValue('D' . $row, $data['machine_learning']);
        $sheet->setCellValue('E' . $row, $data['smart_robot']);
        $sheet->setCellValue('F' . $row, $data['hacking']);
        $sheet->setCellValue('G' . $row, $data['monitoring_control']);
        $sheet->setCellValue('H' . $row, $data['leadership']);
        $sheet->setCellValue('I' . $row, $data['statistics']);
        $row++;
    }
} else {
    $sheet->setCellValue('A2', 'No data available');
}

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filenname="students_data.xlsx"');
header('Cache-Control: max-age=0');

// Write and output the file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
