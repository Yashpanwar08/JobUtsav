<?php
include 'db.php';
require('fpdf.php'); // FPDF library include
include(__DIR__ . '/phpqrcode/phpqrcode/qrlib.php'); // QR library include

if (isset($_GET['reg_id'])) {
    $regId = $_GET['reg_id'];

    // ✅ Fetch sponsor details including company_logo
    $sql = "SELECT s.company_name, s.hr_contact_no, s.company_logo, r.reg_code 
            FROM sponsors s 
            JOIN registrations r ON r.user_ref_id = s.sponsor_id 
            WHERE r.user_type='sponsor' AND r.reg_code='$regId'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ✅ Create PDF in Landscape (horizontal card)
        $pdf = new FPDF('L', 'mm', [100, 70]); // custom card size: 100mm x 70mm
        $pdf->AddPage();

        // ✅ Background template image (specific for sponsors)
        $imagePath = __DIR__ . '/sponser.jpeg'; 
        if (file_exists($imagePath)) {
            $pdf->Image($imagePath, 0, 0, 100, 70);
        }

        // ✅ Text settings
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(0, 0, 0);

        // ✅ Sponsor details
        $pdf->SetXY(28, 23.6);
        $pdf->Cell(0, 6, $row['company_name'], 0, 1);

        $pdf->SetXY(28, 32.5);
        $pdf->Cell(0, 6, $row['hr_contact_no'], 0, 1);

        $pdf->SetXY(28, 41.3);
        $pdf->Cell(0, 6, $row['reg_code'], 0, 0);

        // ✅ Company Logo placement (top-right corner)
        if (!empty($row['company_logo'])) {
            $logoPath = $row['company_logo'];
            // If stored path is relative, prepend __DIR__
            if (!file_exists($logoPath)) {
                $logoPath = __DIR__ . '/' . $logoPath;
            }
            if (file_exists($logoPath)) {
                $pdf->Image($logoPath, 75, 5, 18, 18);
            }
        }

        // ✅ QR Code generation
        $qrLink = "https://verify.jobutsav.com/index.php?reg_id=" . $row['reg_code'];
        $qrFile = __DIR__ . "/qrcodes/" . $row['reg_code'] . ".png";
        QRcode::png($qrLink, $qrFile, QR_ECLEVEL_L, 3, 0);

        // ✅ Place QR code bottom-right
        $pdf->Image($qrFile, 75, 50, 16, 16);

        // ✅ Output PDF
        $pdf->Output('D', 'SponsorGatepass_' . $row['reg_code'] . '.pdf');
    } else {
        die("No sponsor gatepass found for this Registration ID.");
    }
} else {
    die("Registration ID not provided.");
}
?>