<?php

//include('database_connection.php');
//include('includes/config.php');
session_start();

/*if(!isset($_SESSION['user_id']))
{
  header("location:login");
}

if ( $_SESSION['user_status'] == 1 )
{
  header("location:home");
}*/

if(isset($_SESSION["user_id"]))
{
 if((time() - $_SESSION['last_time']) > 900) // Time in Seconds
 {
 header("location:logout.php");
 }
 else
 {
 $_SESSION['last_time'] = time();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>User password</title>
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body id="page-top">
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <a class="navbar-brand mr-1" href="index.html">UMUCYO</a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar -->
  </nav>
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <!--<a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>-->
      </li>
    </ul>
    <div id="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
           <h4 class="display-5">Welcome <i class="btn btn-info">
             <span class="fas fa-user"> <?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?></span></i>
           </h4>
          </li>
          <?php 
              if (isset($_SESSION['mess'])) {
                # code...
                echo $_SESSION['mess'];
                unset($_SESSION['mess']);
              }

          ?>
        </ol>
        <!-- Page Content -->

        <div class="container">
        <h2><center><i class="fas fa-user"></i> Update your password <i class="fas fa-lock"></i></center> </h2>
         
        <form action="f/updateUserInfo.php" method="post" class="needs-validation" novalidate>
          <div class="form-group">
            <label for="pass1"><b class="fas fa-lock"> New password:</b></label>
            <input type="password" class="form-control" id="pass1" placeholder="Enter new password" name="pass1" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback"> Please enter new password. </div>
          </div>
          <div class="form-group">
            <label for="pass2"><b class="fas fa-lock"> Confirm Password:</b></label>
            <input type="password" class="form-control" id="pass2" placeholder="Confirm password" name="pass2" required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please confirm your password</div>
          </div>
          <button type="submit" name="update_password" class="btn btn-success btn-sm">
            <i class="fas fa-save"></i> Update</button>
        </form>
      </div> <br>

<script>
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>


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
  <script>
// Set the date we're counting down to
var countDownDate = new Date().getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate+5000 - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = "<div class='btn btn-success'>Please wait&nbsp; <i class='spinner-border text-warning'></i> "+ seconds + "<b>s</b></div>";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "<div class='btn btn-success'>Logging out  <i class='spinner-border text-default'></i>&nbsp;</div>";
  }
}, 1000);
</script>
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