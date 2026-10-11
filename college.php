<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db.php'); // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $college_name     = $_POST['college_name'];
    $college_location = $_POST['college_location'];
    $name             = $_POST['name'];
    $phone            = $_POST['phone'];
    $email            = $_POST['email'];
    $designation      = $_POST['designation'];

    // ✅ Handle profile picture upload
    $profilePic = "";
    if (!empty($_FILES['profilePic']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $profilePic = $targetDir . time() . "_" . basename($_FILES["profilePic"]["name"]);

        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $profilePic)) {
            echo "<p style='color:green;font-weight:600;'>Profile picture uploaded successfully!</p>";
        } else {
            echo "<p style='color:red;font-weight:600;'>Profile picture upload failed!</p>";
        }
    }

    // ✅ Insert college data
    $stmt = $conn->prepare("INSERT INTO colleges 
        (college_name, college_location, representative_name, phone, email, designation, profile_pic) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $college_name, $college_location, $name, $phone, $email, $designation, $profilePic);

    if ($stmt->execute()) {
        // Get last inserted college ID
        $lastCollegeId = $conn->insert_id;

        // ✅ Create registration entry for college
        $userType = "college";
        $sqlReg = "INSERT INTO registrations (user_type, user_ref_id) VALUES ('$userType', '$lastCollegeId')";
        $conn->query($sqlReg);

        // ✅ Generate registration code
        $newRegId = $conn->insert_id;
        $regCode = "JUGN" . $newRegId;
        $conn->query("UPDATE registrations SET reg_code='$regCode' WHERE reg_id=$newRegId");

        // ✅ Success message + Gatepass button
        echo "<h2>✅ College Registered Successfully!</h2>";
        echo "<p>Download your gatepass from here:</p>";

        echo "<a href='college_gatepass.php?reg_id=$regCode'>
                <button style='padding:10px 20px; background:#f47b20; color:#fff; border:none; border-radius:5px; cursor:pointer;'>
                  Download Gatepass
                </button>
              </a>";

        echo "<br><br><a href='index.html'>
                <button style='padding:10px 20px; background:#555; color:#fff; border:none; border-radius:5px; cursor:pointer;'>
                  Go to Home
                </button>
              </a>";
    } else {
        echo "<h3>❌ Error: " . $stmt->error . "</h3>";
    }

    $stmt->close();
    $conn->close();
}
?>