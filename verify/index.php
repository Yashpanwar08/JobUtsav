<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Verification Result | JobUtsav</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --orange:#f47b20;
      --bg:#f6f7f9;
      --text:#0f172a;
      --muted:#64748b;
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
      max-width:650px;
      background:#fff;
      border-radius:18px;
      box-shadow:0 20px 40px rgba(0,0,0,0.1);
      padding:25px;
    }

    h2{
      margin-top:0;
      text-align:center;
      color:var(--orange);
      font-size:22px;
    }

    .info{
      margin-top:15px;
    }

    .info p{
      margin:10px 0;
      font-size:15px;
      color:var(--text);
      display:flex;
      justify-content:space-between;
      border-bottom:1px solid #eee;
      padding-bottom:6px;
      flex-wrap:wrap;
    }

    .info b{
      color:var(--muted);
      font-weight:600;
    }

    .centerMsg{
      text-align:center;
      font-size:16px;
      margin-top:20px;
    }

    @media(max-width:500px){
      .card{padding:18px;}
      h2{font-size:18px;}
      .info p{font-size:14px;}
    }
  </style>
</head>

<body>
<div class="card">
<?php
include 'db.php';

if (isset($_GET['reg_id'])) {
    $regId = $_GET['reg_id'];

    // Fetch registration details
    $sqlType = "SELECT user_type, user_ref_id, reg_code, created_at FROM registrations WHERE reg_code='$regId'";
    $resType = $conn->query($sqlType);

    if ($resType && $resType->num_rows > 0) {
        $rowType = $resType->fetch_assoc();
        $userType = $rowType['user_type'];
        $userRef  = $rowType['user_ref_id'];
        $regCode  = $rowType['reg_code'];
        $created  = $rowType['created_at'];

        echo "<h2>Verification Result</h2>";
        echo "<div class='info'>";

        // Candidate / College
        if ($userType == 'candidate') {
            $sql = "SELECT full_name, college_name, phone, email, qualification, experience, preferred_industry 
                    FROM candidates WHERE candidate_id='$userRef'";
        } elseif ($userType == 'college') {
            $sql = "SELECT representative_name AS full_name, college_name, phone, email, designation AS qualification, college_location AS experience, 'Education' AS preferred_industry 
                    FROM colleges WHERE id='$userRef'";
        } elseif ($userType == 'company') {
          $sql = "SELECT company_name AS full_name, hr_name AS college_name, contact_no AS phone, email, job_roles AS qualification, openings AS experience, hiring_location AS preferred_industry, booth_no 
                   FROM companies WHERE company_id='$userRef'";
        } elseif ($userType == 'sponsor') {
            $sql = "SELECT company_name AS full_name, hr_name AS college_name, hr_contact_no AS phone, hr_email AS email, 'Sponsor' AS qualification, '' AS experience, '' AS preferred_industry 
                    FROM sponsors WHERE sponsor_id='$userRef'";
        }

        $res = $conn->query($sql);
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            echo "<p><b>Name:</b> ".$row['full_name']."</p>";
            echo "<p><b>College/Company:</b> ".$row['college_name']."</p>";
            echo "<p><b>Phone:</b> ".$row['phone']."</p>";
            echo "<p><b>Email:</b> ".$row['email']."</p>";
            echo "<p><b>Qualification:</b> ".$row['qualification']."</p>";
            echo "<p><b>Experience:</b> ".$row['experience']."</p>";
            echo "<p><b>Preferred Industry:</b> ".$row['preferred_industry']."</p>";
            echo "<p><b>Reg Code:</b> ".$regCode."</p>";
            echo "<p><b>Created At:</b> ".$created."</p>";
            echo "<p><b>Booth No:</b> ".$row['booth_no']."</p>";
        }

        echo "</div>";
        echo "<div style='text-align:center; margin-top:20px;'>
       <a href='https://jobutsav.com/index.html'>
          <button style='padding:12px 20px; border:none; border-radius:10px; background:linear-gradient(135deg,#f47b20,#ff8a2a); color:#fff; font-weight:700; cursor:pointer;'>
            ← Go Back to Website
          </button>
        </a>
      </div>";

    } else {
        echo "<div class='centerMsg'>No record found for this Registration ID.</div>";
    }
} else {
    echo "<div class='centerMsg'>Registration ID not provided.</div>";
}
?>
</div>
</body>
</html>
