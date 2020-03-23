
<?php
include('includes/config.php');
session_start();
if(!isset($_SESSION["user_id"])){ header('location: index.php');  }
################## display the user privilegies on system  ###########
$sql_priv = "SELECT * FROM `user_privilegies` WHERE role_id ='$_SESSION[role_id]'";
echo $conn->error;
$result = $conn->query($sql_priv);
$rows = $result->fetch_assoc();
$role = $rows['role_id'];
###############################################
$sql_role = "SELECT * FROM `user_role` WHERE role_id ='$_SESSION[role_id]'";
echo $conn->error;
$result = $conn->query($sql_role);
$row_roleName = $result->fetch_assoc();
$role_name = $row_roleName['role_name'];
//$_SESSION['last_time'] = time();
###############################################
$sql_code = "SELECT institution_code FROM `login` WHERE user_id ='$_SESSION[user_id]'";
echo $conn->error;
$result = $conn->query($sql_code);
$row_code = $result->fetch_assoc();
$_SESSION['institution_code'] = $row_code['institution_code'];
//$_SESSION['last_time'] = time();
################## display of branch name on a page ##################
$sql = "SELECT * FROM `phar_branch` WHERE branch_ID = '$_SESSION[branch]'";
$result = $conn->query($sql);
$row = $result->fetch_object();
$branch_name = $row->branch_name;
$branch_status = $row->branch_status;

if(!isset($_SESSION['user_id']))
{
  header("location:login");
}
if ((time() - $_SESSION['last_time']) >900 ) {
	header("location:logout.php");
}
if ($_SESSION['user_status'] == 1 && $_SESSION['pass_updated']==1 && $_SESSION['branch_sta'] == 0) {
           # code...
          header('location:branch_p');
         }
if(time() - $_SESSION['last_time'] < 900){

  $_SESSION['last_time'] = time();
 }
elseif ($_SESSION['user_status'] == 1 && $_SESSION['pass_updated']==0) {
           # code...
  header('location:passUpdate');
}
elseif ($_SESSION['user_status'] == 1 && $_SESSION['pass_updated']==1 && $_SESSION['branch'] == 0) {
           # code...
  header('location:branch_p');
}
elseif ($_SESSION['user_status']==0) {
	# code...
	header("location:404");

}elseif ($branch_status==0) {
  # code...
  header('Location: branch_p');
}

?>

<nav class="navbar navbar-expand navbar-dark navbar-fixed-top fixed-top" style="background-color: #005f98; margin-bottom: auto;" >

    <a class="navbar-brand mr-1" href="home">
      <!-- <img src="img/band.png" alt="logo" width="200" height="30"> -->
      <h3>UMUCYO</h3>
    </a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>
    <a  href="" id=""  aria-expanded="false">
          <span style="color: #FFF;margin-left:100px;"><b><?php echo $branch_name; ?></b>
            &nbsp;&nbsp;&nbsp;&nbsp;<i id="demo"></i></span>
          
        </a>


<script>
  $(document).ready(function(){ 
  var x ="";
  if (navigator.onLine==true) {
    x="<i class='fas fa-signal' style='color: #FFF; font-size: 30px;' title='You have internet access'></i>";
  }else{x="<i style='color: #900; font-size: 30px;' class='fas fa-exclamation' title='No internet access'></i>";}
  document.getElementById("demo").innerHTML = x;
});
</script>
<!-- <h5 style="margin-left: 100px; color: #fff;"><?php //echo $_SESSION['institution_code']; ?></h5> -->
<h5 style="margin-left: 100px; color: #fff;"><?php echo $role_name; ?></h5>
    <!-- Navbar Search -->
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
     
    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0 my-2 my-md-0">
    
     
             <i class="" style="color: #FFF;">
        <?php echo date("Y-m-d")."  ". date("l"); ?>&nbsp;&nbsp;&nbsp;
      
      <strong><label id="timer"></label></strong>
      </i>
      
      <!-- <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger">9+</span>
        </a>
        broadcast-tower
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
      <!-- <li class="nav-item dropdown no-arrow mx-1">
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
      </li> -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span style="color: #FFF;"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?></span>
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
      <?php if($_SESSION['role_id']== 1){ ?>
      <li class="nav-item">
        <a class="nav-link" href="phar_institution">
        <i class="fas fa-fw fa-table"></i>
          <span>System Backup</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="phar_institution">
        <i class="fas fa-fw fa-table"></i>
          <span>Pharmacy Institution</span></a>
      </li>
      <?php } if($rows['acc_privilegie']== 1 || $_SESSION['role_id']== 1){ ?>
      <li class="nav-item">
        <a class="nav-link" href="pharmacy_privilegie">
        <i class="fas fa-fw fa-table"></i>
          <span>Access Right</span></a>
      </li>
      <?php } if($rows['acc_medecine']== 1 || $_SESSION['role_id']== 1){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-hospital-alt"></i>
          <span>Manage medicine</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header"><i class="fas fa-briefcase-medical"></i> Manage medicine</h6>
          <?php  if($rows['acc_medecine_list']== 1 || $_SESSION['role_id']== 1){ ?>
          <a class="dropdown-item" href="medical_list"><i class="fas fa-briefcase-medical"></i> Medical Product</a>
          <?php // } if($rows['acc_purchased']== 1 || $_SESSION['role_id']== 1){ ?>
          <!-- <a class="dropdown-item" href="medecine_purchase"><i class="fas fa-briefcase-medical"></i> Purchase Medecine</a> -->
          <!-- <a class="dropdown-item" href="selling_price"><i class="fas fa-briefcase-medical"></i> Selling Price</a> -->
          <!-- <a class="dropdown-item" href="medecine"><i class="fas fa-briefcase-medical"></i> Medecine list</a> -->
          <?php  }if($rows['acc_medecine_cat']== 1 || $_SESSION['role_id']== 1){ ?>
          <a class="dropdown-item" href="medecine_cat"><i class="fas fa-edit"></i> Medecine category</a>
          <?php  } ?>
        </div>
        </li>
      <?php } if($rows['acc_management']== 1 || $_SESSION['role_id']== 1){ ?>
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
      <?php  } if($rows['acc_purchased']== 1 || $_SESSION['role_id']== 1){ ?>
      <li class="nav-item">
        <a class="nav-link" href="medecine_purchase">
        <i class="fas fa-briefcase-medical"></i>
          <span>Purchase Medecine</span></a>
      </li>
      <?php } if($rows['acc_to_serve']== 1 || $_SESSION['role_id']== 1){ ?>
      <li class="nav-item">
        <a class="nav-link" href="medecine">
        <i class="fas fa-fw fa-table"></i>
          <span>Serve medecine</span></a>
      </li>
      <?php } if($rows['acc_branches']== 1 || $_SESSION['role_id']== 1){ ?>
      <li class="nav-item">
        <a class="nav-link" href="pharmacy_branch">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Branche(s)</span>
        </a>
      </li>
      <?php } if($rows['acc_all_served']== 1 || $_SESSION['role_id']== 1){ ?>
      <li class="nav-item">
        <a class="nav-link" href="all_sales">
          <i class="fas fa-weight"></i>
          <span>All sales</span></a>
      </li>
      <?php } if($rows['acc_manager_report']== 1 || $_SESSION['role_id']== 1){ ?>
      <li class="nav-item">
        <a class="nav-link" href="financialreport">
          <i class="fas fa-file"></i>
          <span>Reporting</span></a>
      </li>
      <?php } if($rows['acc_pharmacy_user']== 1 || $_SESSION['role_id']== 1){ ?>
     <li class="nav-item">
        <a class="nav-link" href="pharmacy_users">
          <i class="fas fa-users"></i>
          <span>Staff</span>
        </a>
      </li>
      <?php } if($rows['acc_transaction']== 1 || $_SESSION['role_id']== 1){ ?>
      <li class="nav-item">
        <a class="nav-link" href="checkout">
          <i class="fas fa-users"></i>
          <span>TRANSACTION</span>
        </a>
      </li>
      <?php } //if($rows['acc_transaction']== 1){ ?>
    </ul>
