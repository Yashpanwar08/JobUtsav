<?php
include 'db.php';
require('fpdf.php'); // FPDF library include
include(__DIR__ . '/phpqrcode/phpqrcode/qrlib.php');

if (isset($_GET['reg_id'])) {
    $regId = $_GET['reg_id'];

    // Fetch company details
    $sql = "SELECT comp.company_name, comp.contact_no, r.reg_code 
            FROM companies comp 
            JOIN registrations r ON r.user_ref_id = comp.company_id 
            WHERE r.user_type='company' AND r.reg_code='$regId'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Create PDF in Landscape (horizontal card)
        $pdf = new FPDF('L', 'mm', [100, 70]); // custom card size: 100mm x 70mm
        $pdf->AddPage();

        // Background template image (specific for companies)
        $imagePath = __DIR__ . '/company.jpeg';
        if (file_exists($imagePath)) {
            $pdf->Image($imagePath, 0, 0, 100, 70);
        }

        // Text settings
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(0, 0, 0);

        // Company details (only values)
        $pdf->SetXY(28, 23.6);
        $pdf->Cell(0, 6, $row['company_name'], 0, 1);

        $pdf->SetXY(28, 32.5);
        $pdf->Cell(0, 6, $row['contact_no'], 0, 1);

        $pdf->SetXY(28, 41.3);
        $pdf->Cell(0, 6, $row['reg_code'], 0, 0);

        //  QR Code generation
        // $qrLink = "http://localhost/finalljob/index.php?reg_id=" . $row['reg_code'];
        // Live server link (use when uploading to Hostinger)
       // Live server link (Hostinger)
$qrLink = "https://verify.jobutsav.com/index.php?reg_id=" . $row['reg_code'];

        $qrFile = __DIR__ . "/qrcodes/" . $row['reg_code'] . ".png";
        QRcode::png($qrLink, $qrFile, QR_ECLEVEL_L, 3, 0); // margin 0

        // Place QR code in PDF (smaller size)
        $pdf->Image($qrFile, 75, 50, 16, 16);

        // Output PDF
        $pdf->Output('D', 'CompanyGatepass_' . $row['reg_code'] . '.pdf');
    } else {
        die("No company gatepass found for this Registration ID.");
    }
} else {
    die("Registration ID not provided.");
}
?>