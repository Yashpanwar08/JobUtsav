<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Candidate Registration | JobUtsav</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --orange:#f47b20;
      --orange2:#ff8a2a;
      --bg:#f6f7f9;
      --text:#0f172a;
      --muted:#64748b;
      --card:#ffffff;
    }
    *{box-sizing:border-box;}
    body{
      margin:0;
      font-family:Poppins, sans-serif;
      background:var(--bg);
      display:flex;
      align-items:center;
      justify-content:center;
      min-height:100vh;
      padding:20px;
    }
    .card{
      width:100%;
      max-width:600px;
      background:#fff;
      border-radius:18px;
      box-shadow:0 20px 40px rgba(0,0,0,0.1);
      overflow:hidden;
    }
    .header{
      padding:20px;
      border-bottom:1px solid #eee;
      display:flex;
      justify-content:space-between;
      align-items:center;
    }
    .logo{font-weight:800;color:var(--orange);font-size:18px;}
    .status{font-size:12px;font-weight:700;color:#22c55e;}
    .body{padding:20px;font-size:15px;line-height:1.6;}
    .body h2{margin:0 0 10px;font-size:20px;}
    .body p{color:var(--muted);margin:10px 0;}
    .body a{display:block;margin-top:12px;text-decoration:none;}
    button{
      width:100%;padding:12px;border:none;border-radius:10px;
      font-weight:700;background:linear-gradient(135deg,var(--orange),var(--orange2));
      color:#fff;cursor:pointer;transition:0.2s;
    }
    button:hover{transform:translateY(-2px);}
    @media(max-width:500px){.body h2{font-size:18px;}}
  </style>
</head>

<body>

<div class="card">
  <div class="header">
    <div class="logo">JobUtsav</div>
    <div class="status">Success</div>
  </div>

  <div class="body">

<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $college = $_POST['college'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $qualification = $_POST['qualification'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $industry = $_POST['industry'] ?? '';
    $slot = $_POST['slot'] ?? '';

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    // ✅ Resume Upload
    $resumePath = '';
    if (!empty($_FILES['resume']['name'])) {
        $resumeName = time() . "_" . basename($_FILES['resume']['name']);
        $resumePath = "uploads/" . $resumeName;
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $resumePath)) {
            echo "<p style='color:green;font-weight:600;'>Resume uploaded successfully!</p>";
        } else {
            echo "<p style='color:red;font-weight:600;'>Resume upload failed!</p>";
        }
    }

    // ✅ Profile Picture Upload
    $profilePicPath = '';
    if (!empty($_FILES['profilePic']['name'])) {
        $picName = time() . "_" . basename($_FILES['profilePic']['name']);
        $profilePicPath = "uploads/" . $picName;
        if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $profilePicPath)) {
            echo "<p style='color:green;font-weight:600;'>Profile picture uploaded successfully!</p>";
        } else {
            echo "<p style='color:red;font-weight:600;'>Profile picture upload failed!</p>";
        }
    }

    // ✅ Insert candidate data
    $sql = "INSERT INTO candidates 
            (full_name, college_name, phone, email, password, qualification, experience, preferred_industry, resume, profile_pic, preferred_slot) 
            VALUES 
            ('$name', '$college', '$phone', '$email', '$hashedPassword', '$qualification', '$experience', '$industry', '$resumePath', '$profilePicPath', '$slot')";

    if ($conn->query($sql) === TRUE) {
        $lastUserId = $conn->insert_id;

        $userType = "candidate";
        $sqlReg = "INSERT INTO registrations (user_type, user_ref_id) VALUES ('$userType', '$lastUserId')";
        $conn->query($sqlReg);

        $newRegId = $conn->insert_id;
        $regCode = "JUGN" . $newRegId;
        $conn->query("UPDATE registrations SET reg_code='$regCode' WHERE reg_id=$newRegId");

        echo "<h2>✅ Candidate Registered Successfully!</h2>";
        echo "<p>Download your gatepass from here:</p>";

        echo "<a href='candidate_gatepass.php?reg_id=$regCode'>
                <button>Download Gatepass</button>
              </a>";

        echo "<a href='index.html'>
                <button>Go to Home</button>
              </a>";
    } else {
        echo "<h2>Error</h2>";
        echo "<p>" . $conn->error . "</p>";
    }
}
?>

  </div>
</div>

</body>
</html>