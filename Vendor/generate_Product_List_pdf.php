<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

date_default_timezone_set("Asia/Kolkata");

// Fetch vendor ID based on the logged-in username
include "db1.php";
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Fetch vendor ID
$vendorUsername = $_SESSION['username'];
$vendorQuery = "SELECT id FROM vendors WHERE username = '$vendorUsername'";
$vendorResult = $conn->query($vendorQuery);
$vendorRow = $vendorResult->fetch_assoc();
$vendorId = $vendorRow['id'];

require_once('../tcpdf/tcpdf.php'); // Adjust the path as necessary

// Extend TCPDF class to customize the header
class MYPDF extends TCPDF {
    protected $vendorUsername;

    // Constructor to pass vendor username
    public function __construct($vendorUsername, $orientation, $unit, $format) {
        parent::__construct($orientation, $unit, $format);
        $this->vendorUsername = $vendorUsername;
    }

    public function Header() {
        // Logo
        $image_file = '../uploads/logo.png'; // Update the path to your logo file
        $this->Image($image_file, 15, 4, 10, 10, 'PNG', '', 'T', true, 150, '', false, false, 0);
                
        $this->SetFont('helvetica', 'B', 23);
        $this->Cell(0, 10, 'TrendCart - '. $this->vendorUsername ."'s ", 0, 1, 'C');
        
        // Date
        $this->SetFont('helvetica', '', 15);
        $this->Ln(10);
    }
}

// Create new PDF document and pass the vendor username
$pdf = new MYPDF($vendorUsername, 'L', 'mm', 'A4'); // 'L' for landscape, 'mm' for millimeters, 'A4' for page size
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('TrendCart - '. $vendorUsername ."'s Products Information Report");

// Set margins
$pdf->SetMargins(15, 22, 15);
$pdf->SetAutoPageBreak(TRUE, 20);

// Add a page
$pdf->AddPage();

// Set font for the content
$pdf->SetFont('helvetica', '', 12);

// Fetch products for the vendor
$sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name, v.username AS vendor_name
        FROM product p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN brands b ON p.brand_id = b.id
        LEFT JOIN vendors v ON p.vendor_id = v.id
        WHERE p.vendor_id = $vendorId";
if ($startDate && $endDate) {
    $sql .= " AND DATE(p.created_at) BETWEEN '$startDate' AND '$endDate'";
}

$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);

    // Generate the PDF content
    if ($startDate && $endDate) {
        $title = 'Products Report - Of ' . htmlspecialchars($startDate) . ' To ' . htmlspecialchars($endDate);
    } else {
        $title = 'Products Report - All Products';
    }

    $html = '<h3>' . $title . '</h3>';

// Include additional content
include "generate_Product_PDF_List.php";

// Append generated timestamp
$html .= '<p style="text-align: right;">Report - Generated on ' . date('Y-m-d H:i:s') . '</p>';

// Output HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('TrendCart - '. $vendorUsername ."'s Products Information Report.pdf", 'D');
?>
