<?php
	session_start();
	include 'includes/config.php';
	if (isset($_REQUEST['delete_item_id'])) {
		# code...
		$sql_delete = "DELETE FROM `total_sales` WHERE Ids = '$_REQUEST[delete_item_id]' AND medicine_ID = '$_REQUEST[medecine_id]' AND batch = '$_REQUEST[batch]' AND User_branch = '$_SESSION[branch]' AND institution_code = '$_SESSION[institution_code]' AND ser_status ='0'";
		$delete_result = $conn->query($sql_delete);
		if ($delete_result) {
			# code...
			$_SESSION['message'] = 
	        '<div id="snackbar">
	                  <strong>deleted successfully</strong>
	              </div>
	              <script>
	        //function myFunction() {
	          var x = document.getElementById("snackbar");
	          x.className = "show";
	          setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
	        //}
	        </script>
            ';
            header('Location:view_basket');
		}
	}
	//remove the id from our cart array
	// $key = array_search($_GET['id'], $_SESSION['cart']);	
	// unset($_SESSION['cart'][$key]);

	// unset($_SESSION['qty_array'][$_GET['index']]);
	// //rearrange array after unset
	// $_SESSION['qty_array'] = array_values($_SESSION['qty_array']);

	// $_SESSION['message'] = "Product deleted from cart";
	// header('location: view_cart');
?>