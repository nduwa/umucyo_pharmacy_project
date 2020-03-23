<?php include('includes/head_tag.php');
session_start();
?>

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
        <div class="text-center mb-4">
          <?php 
          if(isset($_SESSION['reset_password']))
           {
            echo  $_SESSION['reset_password'];
            unset($_SESSION['reset_password']);
           }
          ?>
          <h4>Forgot your password?</h4>
          <p>Enter your email address and we will send you instructions on how to reset your password.</p>
        
        </div>
        <form action="action_page.php" method="post" >
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="inputEmail" name="reset_email" class="form-control" placeholder="Enter email address" required="required" autofocus="autofocus" />
              <label for="inputEmail">Enter email address</label>
            </div>
          </div>
          <input class="btn btn-primary btn-block" type="submit" name="reset_pass" value="Reset Password" >
        </form>
        <div class="text-center">
          <a class="d-block small" href="login">Login Page</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
