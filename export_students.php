<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit();
}

ob_start();
require_once __DIR__ . '/db.php';
ob_end_clean();

function export_error($message, $conn = null)
{
    if ($conn instanceof mysqli && !empty($conn->error)) {
        error_log("Student export error: " . $conn->error);
    }

    http_response_code(500);
    header("Content-Type: text/plain; charset=utf-8");
    echo $message;
    exit();
}

function format_export_value($columnName, $value)
{
    if ($value === null) {
        return '';
    }

    $dateColumns = ['registration_date', 'registered_at', 'created_at', 'created_on', 'reg_date'];

    if (in_array(strtolower($columnName), $dateColumns, true) && $value !== '') {
        $timestamp = strtotime($value);
        if ($timestamp !== false) {
            return date('d-m-Y', $timestamp);
        }
    }

    return $value;
}

if (!isset($conn) || !($conn instanceof mysqli)) {
    export_error("Database connection is not available.");
}

$sql = "SELECT * FROM registrations";
$result = $conn->query($sql);

if (!$result) {
    export_error("Unable to fetch registered student records.", $conn);
}

$fields = $result->fetch_fields();

if (empty($fields)) {
    export_error("No columns were found in the registrations table.", $conn);
}

header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=\"jobutsav_registered_students_" . date("Y-m-d") . ".csv\"");
header("Pragma: no-cache");
header("Expires: 0");

$output = fopen("php://output", "w");

if ($output === false) {
    export_error("Unable to create CSV output.");
}

fwrite($output, "\xEF\xBB\xBF");

$headings = [];
foreach ($fields as $field) {
    $headings[] = $field->name;
}
fputcsv($output, $headings);

while ($row = $result->fetch_assoc()) {
    $csvRow = [];
    foreach ($headings as $columnName) {
        $csvRow[] = format_export_value($columnName, $row[$columnName] ?? '');
    }
    fputcsv($output, $csvRow);
}

fclose($output);
exit();
?>