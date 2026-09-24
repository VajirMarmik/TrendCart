<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

// Include TCPDF library
require_once('../tcpdf/tcpdf.php');

// Set default timezone
date_default_timezone_set("Asia/Kolkata");

// Define the custom TCPDF class
class MYPDF extends TCPDF {
    // Page header
    public function Header() {
        // Logo
        $image_file = '../uploads/logo.png'; // Update the path to your logo file
        $this->Image($image_file, 15, 4, 10, 10, 'PNG', '', 'T', true, 150, '', false, false, 0);
        
        // Title
        $this->SetFont('helvetica', 'B', 23);
        $this->Cell(0, 10, 'TrendCart', 0, 1, 'C'); // Centered title

        // Date
        $this->SetFont('helvetica', '', 15);
        $this->Ln(10);
    }
}

// Create new PDF document
$pdf = new MYPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('TrendCart - Feedback Report');
$pdf->SetMargins(15, 18, 15);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Include database connection
include "db1.php";

// Fetch feedback based on selected date range
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Build SQL query
$sql = "SELECT * FROM feedback";
if ($startDate && $endDate) {
    $sql .= " WHERE DATE(created_at) BETWEEN '$startDate' AND '$endDate'";
}

// Order by created_at in descending order
$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);

if ($result === FALSE) {
    die('Error executing query: ' . $conn->error);
}


    // Generate the PDF content
    if ($startDate && $endDate) {
        $title = 'Feedback Report - Of ' . htmlspecialchars($startDate) . ' To ' . htmlspecialchars($endDate);
    } else {
        $title = 'Feedback Report - All Feedback';
    }


    $html = '<h3>' . $title . '</h3>';

// Generate the PDF content
if ($result->num_rows > 0) {
    $html .= '<table border="1" cellpadding="4">
                <thead>
                    <tr>
                        <th width="6%"><b>SR. No</b></th>
                        <th width="20%"><b>Name</b></th>
                        <th width="25%"><b>Email</b></th>
                        <th width="35%"><b>Feedback</b></th>
                        <th width="14%"><b>Feedback Date</b></th>
                    </tr>
                </thead>
                <tbody>';
    $serialNumber = 1;
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td width="6%">' . $serialNumber . '</td>
                    <td width="20%">' . htmlspecialchars($row['name']) . '</td>
                    <td width="25%">' . htmlspecialchars($row['email']) . '</td>
                    <td width="35%">' . htmlspecialchars($row['message']) . '</td>
                    <td width="14%">' . htmlspecialchars($row['created_at']) . '</td>
                </tr>';
        $serialNumber++;
    }
    $html .= '</tbody></table>';
} else {
    $html .= '<p>No feedback found.</p>';
}

// Append generated timestamp
$html .= '<p style="text-align: right;">Report - Generated on ' . date('Y-m-d H:i:s') . '</p>';

// Output HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('TrendCart - Feedback Report.pdf', 'D');
?>
