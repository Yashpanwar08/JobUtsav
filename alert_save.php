<?php
include('db.php'); // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $whatsapp = $_POST['whatsapp'];
    $email = $_POST['email'];
    $city = $_POST['city'];

    $stmt = $conn->prepare("INSERT INTO city_alerts (name, whatsapp_number, email, city) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $whatsapp, $email, $city);

    if ($stmt->execute()) {
        echo "success"; // ✅ exact lowercase, no spaces
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
