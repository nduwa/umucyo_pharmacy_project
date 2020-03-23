<?php 

include('../includes/config.php');
//include('../includes/menu.php');
session_start();

if (isset($_POST['UpdateUserInfo'])) {
	# code...
  $_SSESSION['mess'] = "";
	if ($_POST['password1']==$_POST['password2']) {
		# code...
        	$fname    =  $_POST['FIRSTNAME'];
			$Lname    =  $_POST['LASTNAME'];
			//$branch   =  $_POST['Branch'];
			$tel      =  $_POST['CONTACTNUMBER'];
			$username =  $_POST['USERNAME'];
			$pwd1     =  $_POST['password1'];
			$pwd2     =  $_POST['password2'];
            
			$new_info = "UPDATE login
					     SET first_name='$fname', last_name='$Lname' , phone='$tel', username='$username'
					     WHERE username='$_SESSION[username]'";

		    $update = mysqli_query($conn,$new_info);

		    if ($update) {
		    	# code...
		    	$_SSESSION['mess'] = "Data updated well";
		    	echo '<script>
		        alert("Information Updated");
		        
		      </script>';

		      session_destroy();
			  header('location:../');
		    }
		    else{ echo $conn->error; }
		    

	}

	else{
		$_SSESSION['mess'] = "Password not match Information not changed";
		echo '<script>
		        alert("Password not match Information not changed");
		        window.location.replace("../profile");
		      </script>';
	}
}

################# update user passwor ############################
if (isset($_POST['update_password'])) {
	# code...
    $_SSESSION['mess'] = "";
	if ($_POST['pass1']==$_POST['pass2']) {

    //$passcode     = password_hash($pass, PASSWORD_DEFAULT);

			$pwd1     =  password_hash($_POST['pass1'], PASSWORD_DEFAULT);
            
			$update_user_password = "UPDATE login
					     SET password='$pwd1', pass_updated='1' WHERE username='$_SESSION[username]'";

		    $pass_update = mysqli_query($conn,$update_user_password);

		    if ($pass_update) {
		    	# code...
		    	
		    	$_SESSION['mess'] = '<div class="alert alert-success alert-dismissible fade show">
								    <button type="button" class="close" data-dismiss="alert">&times;</button>
								    <strong>Passwor updated successfully!</strong>
								  </div>'.'<script>
			         setTimeout(function(){
			            window.location.href = "logout";
			         }, 7000);
			      </script>'.'<i id="demo"></i>';

		      //session_destroy();
			  header('location:../passUpdate');
			  /*echo '<script>
			         setTimeout(function(){
			            window.location.href = "profile";
			         }, 5000);
			      </script>';*/
		    }
		    else{ echo $conn->error; }
		    

	}

	else{
        $_SESSION['mess'] = '<div class="alert alert-danger alert-dismissible fade show">
								    <button type="button" class="close" data-dismiss="alert">&times;</button>
								    <strong>Password not match, and then password not changed!</strong>
								    <b>Try again</b>
								  </div>';

		//$_SESSION['mess'] = "Password not updated";
		header('location:../passUpdate');
		/*echo '<script>
		        alert("Password not match Information not changed");
		        window.location.replace("../passUpdate");
		      </script>';*/
	}
}
?>