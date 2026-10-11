<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';
require('fpdf.php');
include(__DIR__ . '/phpqrcode/phpqrcode/qrlib.php');

if (isset($_GET['reg_id'])) {
    $regId = $_GET['reg_id'];

    // Fetch college details including profile_pic
    $sql = "SELECT c.representative_name, c.phone, c.designation, c.college_name, c.profile_pic, r.reg_code 
            FROM colleges c 
            JOIN registrations r ON r.user_ref_id = c.id 
            WHERE r.user_type='college' AND r.reg_code='$regId'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ✅ Create PDF in Landscape (horizontal card)
        $pdf = new FPDF('L', 'mm', [100, 70]);
        $pdf->AddPage();

        // ✅ Background template image
        $pdf->Image(__DIR__ . '/college.jpeg', 0, 0, 100, 70);

        // ✅ Text settings
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(0, 0, 0);

        // ✅ College details placement
        $pdf->SetXY(21, 20);
        $pdf->Cell(0, 6, $row['representative_name'], 0, 1);

        $pdf->SetXY(23, 27.7);
        $pdf->Cell(0, 6, $row['college_name'], 0, 1);

        $pdf->SetXY(21, 35);
        $pdf->Cell(0, 6, $row['reg_code'], 0, 1);

        // ✅ Profile picture placement (top-right corner)
        if (!empty($row['profile_pic']) && file_exists($row['profile_pic'])) {
            $pdf->Image($row['profile_pic'], 75, 2, 15, 15); 
        }

        // ✅ QR Code generation
        $qrLink = "https://verify.jobutsav.com/index.php?reg_id=" . $row['reg_code'];
        $qrFile = __DIR__ . "/qrcodes/" . $row['reg_code'] . ".png";
        QRcode::png($qrLink, $qrFile, QR_ECLEVEL_L, 3, 0);

        // ✅ Place QR code bottom-right
        $pdf->Image($qrFile, 75, 45, 16, 16);

        // ✅ Output PDF
        $pdf->Output('D', 'CollegeGatepass_' . $row['reg_code'] . '.pdf');
    } else {
        echo "No gatepass found for this Registration ID.";
    }
} else {
    echo "Registration ID not provided.";
}
?>