<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>JobUtsav Dashboard</title>

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
            background: linear-gradient(135deg, #fff4e8, #ffffff);
            font-family: Arial, Helvetica, sans-serif;
            overflow-x:hidden;
            min-height:100vh;
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

        /* ================= HERO SECTION ================= */

        .dashboard-section{
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:85vh;
            padding:40px 20px;
        }

        .dashboard-card{
            width:100%;
            max-width:900px;
            background:white;
            border-radius:30px;
            padding:60px 40px;
            text-align:center;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
            position:relative;
            overflow:hidden;
            animation:fadeIn 1s ease;
        }

        .dashboard-card::before{
            content:'';
            position:absolute;
            top:-50px;
            right:-50px;
            width:180px;
            height:180px;
            background:rgba(255,123,0,0.1);
            border-radius:50%;
        }

        .dashboard-card::after{
            content:'';
            position:absolute;
            bottom:-60px;
            left:-60px;
            width:220px;
            height:220px;
            background:rgba(255,159,67,0.1);
            border-radius:50%;
        }

        .dashboard-icon{
            width:120px;
            height:120px;
            margin:auto;
            background:linear-gradient(to right, #ff7b00, #ff9f43);
            border-radius:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            color:white;
            font-size:55px;
            margin-bottom:30px;
            box-shadow:0 10px 25px rgba(255,123,0,0.3);
        }

        .dashboard-title{
            font-size:48px;
            color:#ff7b00;
            font-weight:bold;
            margin-bottom:20px;
        }

        .dashboard-text{
            font-size:20px;
            color:#555;
            line-height:1.8;
            max-width:700px;
            margin:auto;
        }

        .highlight{
            color:#ff7b00;
            font-weight:bold;
        }

        .dashboard-buttons{
            margin-top:40px;
            display:flex;
            justify-content:center;
            flex-wrap:wrap;
            gap:15px;
        }

        .dashboard-btn{
            padding:14px 28px;
            border:none;
            border-radius:12px;
            background:linear-gradient(to right, #ff7b00, #ff9f43);
            color:white;
            font-size:16px;
            font-weight:bold;
            text-decoration:none;
            transition:0.3s;
            box-shadow:0 5px 15px rgba(255,123,0,0.25);
        }

        .dashboard-btn:hover{
            transform:translateY(-3px);
            color:white;
        }

        /* ================= ANIMATION ================= */

        @keyframes fadeIn{
            from{
                opacity:0;
                transform:translateY(40px);
            }

            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        /* ================= RESPONSIVE ================= */

        @media(max-width:992px){

            .dashboard-title{
                font-size:38px;
            }

            .dashboard-text{
                font-size:18px;
            }

        }

        @media(max-width:768px){

            .dashboard-card{
                padding:40px 25px;
            }

            .dashboard-title{
                font-size:32px;
            }

            .dashboard-text{
                font-size:16px;
            }

            .dashboard-icon{
                width:100px;
                height:100px;
                font-size:45px;
            }

        }

        @media(max-width:576px){

            .navbar-brand{
                font-size:20px;
            }

            .dashboard-title{
                font-size:26px;
            }

            .dashboard-text{
                font-size:15px;
            }

            .dashboard-btn{
                width:100%;
            }

            .navbar-nav .nav-link{
                margin-bottom:8px;
            }

            .admin-text{
                font-size:13px;
                margin-top:10px;
                display:inline-block;
            }

        }

    </style>

</head>

<body>

<!-- ================= NAVBAR ================= -->

<nav class="navbar navbar-expand-lg custom-navbar navbar-dark">

    <div class="container-fluid">

        <a class="navbar-brand" href="dashboard.php">
            <i class="bi bi-briefcase-fill"></i> JobUtsav Admin
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
                <?php echo $_SESSION['admin_email']; ?>
            </span>

        </div>

    </div>

</nav>

<!-- ================= DASHBOARD SECTION ================= -->

<section class="dashboard-section">

    <div class="dashboard-card">

        <div class="dashboard-icon">
            <i class="bi bi-speedometer2"></i>
        </div>

        <h1 class="dashboard-title">
            Welcome to JobUtsav Dashboard
        </h1>

        <p class="dashboard-text">
            Manage all <span class="highlight">Candidates</span>,
            <span class="highlight">Colleges</span>,
            <span class="highlight">Companies</span>,
            <span class="highlight">Sponsors</span>,
            <span class="highlight">Registrations</span> and
            <span class="highlight">City Alerts</span>
            from one powerful admin panel.
            <br><br>
            Use the navigation menu above to explore enrolments,
            manage records, and monitor all activities easily with a
            beautiful and responsive dashboard experience.
        </p>

        <div class="dashboard-buttons">

            <a href="admincandidate.php" class="dashboard-btn">
                Candidates
            </a>

            <a href="admincolleges.php" class="dashboard-btn">
                Colleges
            </a>

            <a href="admincompanies.php" class="dashboard-btn">
                Companies
            </a>

            <a href="adminsponsors.php" class="dashboard-btn">
                Sponsors
            </a>

        </div>

    </div>

</section>

<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>