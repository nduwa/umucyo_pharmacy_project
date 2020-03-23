<?php 
if (isset($_POST['UpdateUserInfo'])) {
	# code...

	if ($_POST['password1']==$_POST['password2']) {
		# code...
        	$fname    =  $_POST['FIRSTNAME'];
			$Lname    =  $_POST['LASTNAME'];
			$branch   =  $_POST['Branch'];
			$tel      =  $_POST['CONTACTNUMBER'];
			$username =  $_POST['USERNAME'];
			$pwd1     =  $_POST['password1'];
			$pwd2     =  $_POST['password2'];
	}

	else{
		echo '<script>
		        alert("Password not match");
		      </script>'
	}
}
?>