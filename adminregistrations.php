<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin - Registrations</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f5f7fb;
            font-family: Arial, Helvetica, sans-serif;
            overflow-x:hidden;
        }

        /* ================= NAVBAR ================= */

        .custom-navbar{
            background: linear-gradient(to right, #ff7b00, #ff9f43);
            padding: 12px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .navbar-brand{
            color:#fff !important;
            font-size:28px;
            font-weight:bold;
        }

        .navbar-nav .nav-link{
            color:#fff !important;
            font-size:16px;
            margin-right:10px;
            transition:0.3s;
            border-radius:8px;
            padding:8px 12px !important;
        }

        .navbar-nav .nav-link:hover{
            background:rgba(255,255,255,0.2);
            transform:translateY(-2px);
        }

        .dropdown-menu{
            border:none;
            border-radius:15px;
            overflow:hidden;
            box-shadow:0 5px 15px rgba(0,0,0,0.15);
        }

        .dropdown-item{
            padding:12px 15px;
            transition:0.3s;
        }

        .dropdown-item:hover{
            background:#ff7b00;
            color:white;
        }

        .admin-text{
            color:white;
            font-weight:bold;
            background:rgba(255,255,255,0.2);
            padding:8px 15px;
            border-radius:30px;
        }

        /* ================= PAGE TITLE ================= */

        .page-title{
            text-align:center;
            font-size:42px;
            font-weight:bold;
            color:#ff7b00;
            margin-top:30px;
            margin-bottom:25px;
        }

        /* ================= TABLE SECTION ================= */

        .table-container{
            width:95%;
            margin:auto;
            background:white;
            padding:25px;
            border-radius:20px;
            box-shadow:0 8px 20px rgba(0,0,0,0.08);
            overflow-x:auto;
            margin-bottom:40px;
        }

        .table-toolbar{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:15px;
            flex-wrap:wrap;
            margin-bottom:18px;
        }

        .table-toolbar-title{
            font-size:18px;
            font-weight:bold;
            color:#333;
        }

        .export-btn{
            display:inline-flex;
            align-items:center;
            gap:8px;
            background:linear-gradient(to right, #16a34a, #22c55e);
            color:white;
            border:none;
            border-radius:10px;
            padding:10px 16px;
            font-size:14px;
            font-weight:bold;
            text-decoration:none;
            box-shadow:0 6px 14px rgba(34,197,94,0.22);
            transition:0.3s;
            white-space:nowrap;
        }

        .export-btn:hover{
            color:white;
            transform:translateY(-2px);
            box-shadow:0 8px 18px rgba(34,197,94,0.28);
        }

        .table{
            min-width:1200px;
            vertical-align:middle;
        }

        .table thead{
            background:linear-gradient(to right, #ff7b00, #ff9f43);
            color:white;
        }

        .table th{
            padding:15px;
            text-align:center;
            font-size:15px;
            white-space:nowrap;
        }

        .table td{
            padding:14px;
            text-align:center;
            font-size:14px;
            color:#333;
        }

        .table-striped tbody tr:nth-of-type(odd){
            background:#fff7f0;
        }

        .table tbody tr:hover{
            background:#ffe3c2;
            transition:0.3s;
        }

        /* ================= RESPONSIVE ================= */

        @media(max-width:992px){

            .navbar-brand{
                font-size:24px;
            }

            .page-title{
                font-size:32px;
            }

            .admin-text{
                margin-top:10px;
                display:inline-block;
            }

        }

        @media(max-width:768px){

            .page-title{
                font-size:28px;
            }

            .table-container{
                padding:15px;
            }

            .table-toolbar{
                align-items:stretch;
            }

            .export-btn{
                width:100%;
                justify-content:center;
            }

            .table th,
            .table td{
                font-size:13px;
                padding:10px;
            }

        }

        @media(max-width:576px){

            .navbar-brand{
                font-size:20px;
            }

            .page-title{
                font-size:24px;
            }

            .navbar-nav .nav-link{
                margin-bottom:8px;
            }

            .admin-text{
                font-size:13px;
            }

        }

    </style>

</head>

<body>

<!-- ================= NAVBAR ================= -->

<nav class="navbar navbar-expand-lg custom-navbar navbar-dark">

    <div class="container-fluid">

        <a class="navbar-brand" href="dashboard.php">
            <i class="bi bi-journal-check"></i> JobUtsav Admin
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Candidates -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Candidates
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="admincandidate.php">
                                View Candidates
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Colleges -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Colleges
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="admincolleges.php">
                                View Colleges
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Companies -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Companies
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="admincompanies.php">
                                View Companies
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Sponsors -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Sponsors
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="adminsponsors.php">
                                View Sponsors
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Registrations -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Registrations
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="adminregistrations.php">
                                View Registrations
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- City Alerts -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        City Alerts
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="admincityalerts.php">
                                View City Alerts
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

            <!-- Admin Email -->
            <span class="admin-text">
                <i class="bi bi-person-circle"></i>
                <?php echo htmlspecialchars($_SESSION['admin_email']); ?>
            </span>

        </div>

    </div>

</nav>

<!-- ================= PAGE TITLE ================= -->

<h1 class="page-title">
    Registrations
</h1>

<!-- ================= TABLE SECTION ================= -->

<div class="table-container">

    <div class="table-toolbar">
        <div class="table-toolbar-title">Registered Students</div>

        <a href="export_students.php" class="export-btn">
            <i class="bi bi-file-earmark-spreadsheet"></i>
            Export to Excel
        </a>
    </div>

<?php

$result = $conn->query("SELECT * FROM registrations");

if ($result && $result->num_rows > 0) {

    echo "<table class='table table-bordered table-striped align-middle'>";

    echo "<thead><tr>";

    foreach ($result->fetch_fields() as $f) {

        echo "<th>" . htmlspecialchars($f->name) . "</th>";
    }

    echo "</tr></thead><tbody>";

    $result->data_seek(0);

    while ($row = $result->fetch_assoc()) {

        echo "<tr>";

        foreach ($row as $val) {

            echo "<td>" . htmlspecialchars($val) . "</td>";
        }

        echo "</tr>";
    }

    echo "</tbody></table>";

} elseif ($result === false) {

    echo "<div class='alert alert-danger text-center'>Unable to load registrations. Please try again later.</div>";

} else {

    echo "<div class='alert alert-warning text-center'>No records found.</div>";
}
?>

</div>

<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>