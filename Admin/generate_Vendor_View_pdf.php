<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

require_once('../tcpdf/tcpdf.php');

date_default_timezone_set("Asia/Kolkata");

// Extend TCPDF class to customize the header
class MYPDF extends TCPDF {
    // Page header
    public function Header() {
        // Logo
        $image_file = '../uploads/logo.png'; // Update the path to your logo file
        $this->Image($image_file, 15, 4, 10, 10, 'PNG', '', 'T', true, 150, '', false, false, 0);
        
        // Title
        $this->SetFont('helvetica', 'B', 23);
        $this->Cell(0, 10, 'TrendCart', 0, 1, 'C'); // Align text to the Center

        // Date
        $this->SetFont('helvetica', '', 15);
        $this->Ln(10);
    }
}

// Create new PDF document in landscape orientation
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('TrendCart - Vendors Report');
$pdf->SetMargins(15, 18, 15);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Fetch vendors data
include "db1.php";
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$sql = "SELECT * FROM `vendors`";
if ($startDate && $endDate) {
    $sql .= " WHERE DATE(created_at) BETWEEN '$startDate' AND '$endDate'";
}
$sql .= " ORDER BY created_at DESC";  // Add this line to sort the results in descending order

$result = $conn->query($sql);

if ($result === FALSE) {
    die('Error executing query: ' . $conn->error);
}

// Generate the PDF content
if ($startDate && $endDate) {
    $title = 'Vendors Report - Of ' . htmlspecialchars($startDate) . ' To ' . htmlspecialchars($endDate);
} else {
    $title = 'Vendors Report - All Vendors';
}

$html = '<h3>' . $title . '</h3>';

include "generate_Vendor_PDF_View.php";

// Append generated timestamp
$html .= '<p style="text-align: right;">Report - Generated on ' . date('Y-m-d H:i:s') . '</p>';

// Output HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('TrendCart - Vendors Report.pdf', 'D');
?>
