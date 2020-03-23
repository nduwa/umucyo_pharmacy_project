<?php
include 'includes/config.php';
	session_start();
	$sql_clear = "DELETE FROM `total_sales` WHERE User_branch = '$_SESSION[branch]' AND institution_code = '$_SESSION[institution_code]' AND userID = '$_SESSION[user_id]' AND ser_status = '0'";
	$result_clear = $conn->query($sql_clear);
	if ($result_clear) {
		# code...
		$_SESSION['message'] = 
        '<div id="snackbar">
                  <strong>Cleaned successfully</strong>
              </div>
              <script>
        //function myFunction() {
          var x = document.getElementById("snackbar");
          x.className = "show";
          setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        //}
        </script>
            ';
            header('Location:medecine');
	}
?>