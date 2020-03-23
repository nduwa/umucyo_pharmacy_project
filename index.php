<?php
include('database_connection.php');
session_start();
$message = '';
if(isset($_SESSION['user_id']))
{
  header('location:home');
}
if(isset($_POST['login']))
{
  $query = "
    SELECT * FROM login INNER JOIN `phar_branch` ON login.branch=phar_branch.branch_ID
      WHERE login.username = :username
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
    array(
      ':username' => $_POST["username"]
    )
  );
  $count = $statement->rowCount();
  if($count > 0)
  {
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
      if(password_verify($_POST["password"], $row["password"]))
      {
        $_SESSION['user_id']    = $row['user_id'];
        $_SESSION['username']   = $row['username'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name']  = $row['last_name'];
        $_SESSION['phone']      = $row['phone'];
        $_SESSION['email']      = $row['email'];
        //$_SESSION['institution_code'] = $row['institution_code'];
        $_SESSION['branch']     = $row['branch'];
        $_SESSION['role_id']    = $row['role_id'];
        $_SESSION['branch_sta'] = $row['branch_status'];
        $_SESSION['reg_date']   = $row['reg_date'];
        $_SESSION['user_status']= $row['user_status'];
        $_SESSION['pass_updated']=$row['pass_updated'];
        $_SESSION['last_time']  = time();
        
        $sub_query = "
        INSERT INTO login_details
          (user_id)
          VALUES ('".$row['user_id']."')
        ";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
        $_SESSION['login_details_id'] = $connect->lastInsertId();

        if ($_SESSION['user_status'] == 1 && $_SESSION['pass_updated']==1 && $_SESSION['branch_sta']==1)
         {
           header('location:home');
         }
         elseif ($_SESSION['user_status'] == 1 && $_SESSION['pass_updated']==0 && $_SESSION['branch_sta']==1) {
           # code...
          header('location:passUpdate');
         }
          elseif ($_SESSION['user_status'] == 1 && $_SESSION['pass_updated']==1 && $_SESSION['branch_sta'] == 0) {
           # code...
          header('location:branch_p');
         }

        else
        {
          header('location:404');
        }
      }
      else
      {
        $message = '
          <p style="color: #900;">
          <i class="fas fa-lock"></i> <strong>Wrong Password</strong>
      </p>';
      }
    }
  }
  else
  {
    $message = '
       <p style="color: #900;">
          <i class="fas fa-user"></i> <strong style="color: #900;">
          Wrong Username
          </strong>
      </p>';
  }
}
include('includes/head_tag.php');
?>
<!--  background image and home design -->
  <style>
body, html {
  height: auto;
  font-family: Arial, Helvetica, sans-serif;
  background-color: #c0d6e4;
}

* {
  box-sizing: border-box;
}

.bg-img {
  /* The image used */
  background-image: url("img/pharmacy_bg0.png");

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
  right: 250px;
  margin: 20px;
  max-width: auto;
  padding: 16px;
  background-color: white;
}
/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}
input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
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
<body class="bg-img">
  <center>
  <div class="">
    <div class="card card-login mx-auto mt-5"style="background-color: #005f98;border-radius:10px;">
      <div class="card-header" style="background-color: #37baf5; border-radius:10px;">
        <div class="lockscreen-image">
          <img src="img/PH_icon.png" alt="User Image" style="height:130px">
        </div>
        <center>
          <h1 style="margin-top:-50px">UMUCYO</h1>
        </center>
        </div>
      <div class="card-body">
        <?php echo $message; ?>
        <form method="post">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
              <label for="inputEmail">Username</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="required" autofocus="autofocus">
              <label for="inputPassword">Password</label>
            </div>
          </div>
          <input type="submit" style="padding: 5px;" class="btn btn-primary btn-sm" name="login" value="Login" >
        </form>
        <hr>
        <div class="row">
        <div class="col-md-6">
          <a href="login">
            <button type="button" class="btn btn-primary " >
              <small> Patrol use? </small>
            </button>
          </a>
        </div>
        <div class="col-md-6">
          <a href="forgot-password">
            <button type="button" class="btn btn-primary ">
              <small>Forgot Password?</small>
            </button>
          </a>
        </div>
      </div>
      </div>
      <div class="lockscreen-footer text-center" style="background:#37baf5;padding:5px;border-radius:10px;">
        Copyright &copy; 2019-2020<b>
          <a href="#" class="text-black">Pharmacie Store.</a></b><br>
        All rights reserved
      </div>
      </div>
    </div>
  </div>
</center>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>
