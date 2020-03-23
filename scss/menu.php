
<?php
include('includes/config.php');
session_start();

if(!isset($_SESSION['user_id']))
{
  header("location:login");
}
elseif ((time() - $_SESSION['last_time']) >900 ) {
	header("location:logout.php");
}
elseif ($_SESSION['user_status'] == 1 && $_SESSION['pass_updated']==0) {
           # code...
  header('location:passUpdate');
}
elseif ($_SESSION['user_status']==0) {
	# code...
	header("location:404");
}
$_SESSION['last_time'] = time();
?>

<nav class="navbar navbar-expand navbar-dark navbar-fixed-top fixed-top" style="background-color: #005f98; margin-bottom: auto;" >

    <a class="navbar-brand mr-1" href="home">
      <!-- <img src="img/band.png" alt="logo" width="200" height="30"> -->
      <h3>UMUCYO</h3>
    </a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>
      
    <!-- Navbar Search -->
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
     
    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0 my-2 my-md-0">
     <li class="nav-item  mx-3">
             <li class="" style="color: #FFF;">
        <?php echo date("Y-m-d")."  ". date("l"); ?>&nbsp;&nbsp;&nbsp;
      </li>
      </li>
      <li style="color: #FFF;"><strong><label id="timer"></label></strong></li>

      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger">9+</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown" >
          <a class="dropdown-item" href="profile">Settings</a>
          <a class="dropdown-item" href="passUpdate">Change password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>
  </div>
  </nav>
  <br><br>

<div id="wrapper" style="margin-top: 10px;" >
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav"style="background-color: #011f4b;">
      <li class="nav-item active">
        <a class="nav-link" href="home">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-hospital-alt"></i>
          <span>Medecine</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header"><i class="fas fa-briefcase-medical"></i> Manage medicine</h6>
          <a class="dropdown-item" href="medical_list"><i class="fas fa-briefcase-medical"></i> Medical Product</a>
          <a class="dropdown-item" href="medecine_purchase"><i class="fas fa-briefcase-medical"></i> Purchase Medecine</a>
          <a class="dropdown-item" href="selling_price"><i class="fas fa-briefcase-medical"></i> Selling Price</a>
          <!-- <a class="dropdown-item" href="medecine"><i class="fas fa-briefcase-medical"></i> Medecine list</a> -->
          <a class="dropdown-item" href="medecine_cat"><i class="fas fa-edit"></i> Medecine category</a>
        </div>
        </li>

          <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-money-bill-wave-alt"></i>
          <span>Management (s)</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header"><i class="fas fa-briefcase-medical"></i> Manage Expense(s)</h6>
          <a class="dropdown-item" href="expenses"><i class="fas fa-briefcase-medical"></i> Expense(s)</a>
          <a class="dropdown-item" href="medical_income"><i class="fas fa-edit"></i> Income(s)</a>
          <div class="dropdown-divider"></div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="medecine">
        <i class="fas fa-fw fa-table"></i>
          <span>Serve medecine</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pharmacy_branch">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Branche(s)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="all_sales">
          <i class="fas fa-weight"></i>
          <span>All sales</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="financialreport">
          <i class="fas fa-file"></i>
          <span>Reporting</span></a>
      </li>
     <li class="nav-item">
        <a class="nav-link" href="pharmacy_users">
          <i class="fas fa-users"></i>
          <span>Staff</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>
    </ul>
