<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">JobUtsav Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="candDrop" role="button" data-bs-toggle="dropdown">Candidates</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="admincandidate.php">View Candidates</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="colDrop" role="button" data-bs-toggle="dropdown">Colleges</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="admincolleges.php">View Colleges</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="compDrop" role="button" data-bs-toggle="dropdown">Companies</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="admincompanies.php">View Companies</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="sponDrop" role="button" data-bs-toggle="dropdown">Sponsors</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="adminsponsors.php">View Sponsors</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="regDrop" role="button" data-bs-toggle="dropdown">Registrations</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="adminregistrations.php">View Registrations</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="cityDrop" role="button" data-bs-toggle="dropdown">City Alerts</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="admincityalerts.php">View City Alerts</a></li>
          </ul>
        </li>
      </ul>
      <span class="navbar-text text-white">
        Logged in as <?php echo $_SESSION['admin_email']; ?>
      </span>
    </div>
  </div>
</nav>
