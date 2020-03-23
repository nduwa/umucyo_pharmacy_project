<?php

include('includes/config.php');
session_start();
$_SESSION['last_time'] = time();
$sql = "SELECT * FROM `phar_branch` WHERE branch_ID = '$_SESSION[branch]'";
$result = $conn->query($sql);
$row = $result->fetch_object();
$branch_name = $row->branch_name;
$branch_status = $row->branch_status;

if(isset($_SESSION["user_id"]))
{

 if((time() - $_SESSION['last_time']) > 900) // Time in Seconds
 {
 header("location:logout.php");
 }

 else
 {
 $_SESSION['last_time'] = time();

 
include 'includes/head_tag.php';
?>


</head>

<body id="page-top">
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <a class="navbar-brand mr-1" href="index.html"><a  href="./" id=""  aria-expanded="false">
          <span style="color: #FFF;"><b><?php echo $branch_name; ?></b></span>
          
        </a></a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar -->
  </nav>
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
    </ul>
    <div id="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="./">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">404 Error</li>
        </ol>
        <!-- Page Content -->
        <center>
        <h1 class="display-1">HOOPS !!!!!!</h1>
        <h1 class=""><a href=""><i class="fas fa-info" style="font-size: 100px;"></i></a>
         <strong><i><?php echo $branch_name; ?></i></strong></h1>
         <h3> is not working contact your manager <a href=""><i class="fas fa-sms"></i></a>
         , or 
          <a href="logout" class="btn btn-warning"><i class="fas fa-window-close"></i></a></h3>
      </div>
      <!-- /.container-fluid -->
      <!-- Sticky Footer -->
     <?php include('includes/footer.php'); ?>
    </div>
    <!-- /.content-wrapper -->
  </div>
  <!-- /#wrapper -->
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
</center>
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>
</body>
</html>

<?php
 }
}
else
{
 header('Location:logout.php');
}

?>