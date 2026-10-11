<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db.php';
require('fpdf.php'); // FPDF library include
include(__DIR__ . '/phpqrcode/phpqrcode/qrlib.php');

if (isset($_GET['reg_id'])) {
    $regId = $_GET['reg_id'];

    // Fetch candidate details including profile pic
    $sql = "SELECT c.full_name, c.college_name, c.profile_pic, r.reg_code 
            FROM candidates c 
            JOIN registrations r ON r.user_ref_id = c.candidate_id 
            WHERE r.user_type='candidate' AND r.reg_code='$regId'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Create PDF in Landscape (horizontal card)
        $pdf = new FPDF('L', 'mm', [100, 70]); // custom card size: 100mm x 70mm
        $pdf->AddPage();

        // Background template image
        $pdf->Image(__DIR__ . '/candidate.jpeg', 0, 0, 100, 70);

        // Text settings (Normal font, not bold)
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(0, 0, 0);

        // Candidate details (only values)
        $pdf->SetXY(28, 23.7);
        $pdf->Cell(0, 6, $row['full_name'], 0, 1);

        $pdf->SetXY(28, 32.7);
        $pdf->Cell(0, 6, $row['college_name'], 0, 1);

        $pdf->SetXY(28, 41.5); 
        $pdf->Cell(0, 6, $row['reg_code'], 0, 0); // no line break

        // Profile picture (assuming stored path in DB like 'uploads/profilepic.jpg')
        if (!empty($row['profile_pic']) && file_exists($row['profile_pic'])) {
            // Place profile pic at fixed coordinates (x=73, y=1, width=18mm, height=18mm)
            $pdf->Image($row['profile_pic'], 73, 1, 18, 18);
        }

        //  QR Code generation
        // Localhost testing link
        // $qrLink = "http://localhost/finalljob/index.php?reg_id=" . $row['reg_code'];
        // Live server link (use when uploading to Hostinger)
$qrLink = "https://verify.jobutsav.com/index.php?reg_id=" . $row['reg_code'];

        $qrFile = __DIR__ . "/qrcodes/" . $row['reg_code'] . ".png";
        QRcode::png($qrLink, $qrFile, QR_ECLEVEL_L, 3 ,0); // Generate QR code with low error correction, size 3, no margin

        // Place QR code in PDF (adjust coordinates as per layout)
        $pdf->Image($qrFile, 75, 50, 16, 16); // x=75, y=50, width=16mm, height=16mm

        // Output PDF
        $pdf->Output('D', 'Gatepass_' . $row['reg_code'] . '.pdf');
    } else {
        echo "No gatepass found for this Registration ID.";
    }
} else {
    echo "Registration ID not provided.";
}
?>