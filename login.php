<?php

include('database_connection.php');

session_start();

if(isset($_SESSION['user_id']))
{
  header("location:home");

}
include 'includes/head_tag.php';
?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!--  background image and home design -->
  <style>
body, html {
  height: auto;
  font-family: Arial, Helvetica, sans-serif;
  background-color: #f5f5f5;
}

* {
  box-sizing: border-box;

}

.bg-img {
  /* The image used */
  background-image: url("img/pharmacy_b.png");
  background-color: #f5f5f5;
  min-height: auto;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;

}
/* Add styles to the form container */
.container {
  position: absolute;
  right: 0;
  margin: 20px;
  max-width: cover;
  padding: 16px;
  background-color: gray;
}


/* Set a style for the submit button */
.btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.btn:hover {
  opacity: 1;
}
</style>
</head>
<body class="hold-transition lockscreen bg-img">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper" style="border: 2px solid #fff;border-radius:15px; padding: 10px; background:#c0d6e4;">
  <div class="lockscreen-logo" style="background-color: #37baf5;">
   <small>
    <strong> <h1>UMUCYO</h1><hr>
    </strong>
   </small>
  </div>
  <!-- User name -->
  <div class="lockscreen-name"><a href="">Super Admin</a></div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="img/PH_icon.png" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials">
      <div class="input-group">
        <input type="password" class="form-control" id="pwd" autofocus placeholder="password">
        <div class="input-group-btn">
         <a href="home">
           <button type="button" class="btn"><i class="glyphicon glyphicon-arrow-right text-muted"></i></button>
         </a>
        </div>
        <div class="input-group-btn">
           <button type="button" onclick="myFunction()" class="btn">
            <i class="glyphicon glyphicon-eye-open text-muted"></i>
          </button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->
        <script>
        function myFunction() {
          var x = document.getElementById("pwd");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }
        </script>
  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center" style="color: #000;">
    Enter your password to retrieve your session
  </div>
  <div class="text-center">
    <a href="index">
      <button type="button" class="btn btn-link" >
      Sign in as a user
      </button>
    </a>
  </div>
  <div class="lockscreen-footer text-center" style="background:#37baf5;padding:10px">
    Copyright &copy; 2019-2020<b>
      <a href="#" class="text-black">Ituze pharmacy</a></b><br>
    All rights reserved
  </div>
</div>

<!-- /.center -->

<!-- jQuery 3 -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
